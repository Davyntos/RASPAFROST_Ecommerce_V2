<?php
// Se incluye el archivo de conexión a la base de datos.
// Este archivo contiene la variable $conexion, que permite ejecutar consultas mediante PDO.
require_once __DIR__ . '/../config/db.php';

// Modelo encargado de gestionar la información relacionada con los pedidos.
class Pedido {

    // Método estático encargado de crear un nuevo pedido en la base de datos.
    // Recibe el ID del usuario, los productos del carrito y el método de pago seleccionado.
    public static function crearPedido($usuario_id, $carrito, $metodo_pago) {

        // Se utiliza la conexión global definida en el archivo db.php.
        global $conexion;

        try {
            // Se inicia una transacción para asegurar que todas las operaciones
            // del pedido se realicen correctamente.
            $conexion->beginTransaction();

            // Variable utilizada para calcular el subtotal neto.
            $subtotal_neto = 0;

            // Se recorre el carrito para calcular el costo base de la compra.
            foreach ($carrito as $item) {
                $subtotal_neto += $item['precio'] * $item['cantidad'];
            }

            // APLICACIÓN AUTOMÁTICA DEL IVA 16%
            $total_con_iva = $subtotal_neto * 1.16;

            // Consulta SQL para registrar el pedido principal con el total que incluye IVA.
            $sql = "INSERT INTO pedidos (usuario_id, total, estado, metodo_pago)
                    VALUES (:usuario_id, :total, 'pagado', :metodo_pago)";

            // Se prepara la consulta para evitar inyecciones SQL.
            $stmt = $conexion->prepare($sql);

            // Se enlazan los valores recibidos con los parámetros de la consulta.
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':total', $total_con_iva); // Guardamos la cantidad neta con impuesto
            $stmt->bindParam(':metodo_pago', $metodo_pago);

            // Se ejecuta la consulta para guardar el pedido.
            $stmt->execute();

            // Se obtiene el ID del pedido recién creado.
            $pedido_id = $conexion->lastInsertId();

            // Se recorre nuevamente el carrito para guardar cada producto.
            foreach ($carrito as $item) {

                // Se calcula el subtotal individual de cada producto.
                $subtotal = $item['precio'] * $item['cantidad'];

                // Consulta SQL para registrar el detalle del pedido (tabla: detalle_pedido).
                $sqlDetalle = "INSERT INTO detalle_pedido 
                (pedido_id, producto_id, nombre_producto, precio, cantidad, subtotal)
                VALUES 
                (:pedido_id, :producto_id, :nombre_producto, :precio, :cantidad, :subtotal)";

                // Se prepara la consulta del detalle del pedido.
                $stmtDetalle = $conexion->prepare($sqlDetalle);

                // Se enlazan los datos del pedido and del producto.
                $stmtDetalle->bindParam(':pedido_id', $pedido_id);
                $stmtDetalle->bindParam(':producto_id', $item['id']);
                $stmtDetalle->bindParam(':nombre_producto', $item['nombre']);
                $stmtDetalle->bindParam(':precio', $item['precio']);
                $stmtDetalle->bindParam(':cantidad', $item['cantidad']);
                $stmtDetalle->bindParam(':subtotal', $subtotal);

                // Se ejecuta la inserción del detalle del pedido.
                $stmtDetalle->execute();

                // Consulta SQL para actualizar el stock del producto comprado.
                $sqlStock = "UPDATE productos 
                             SET stock = stock - :cantidad 
                             WHERE id = :producto_id";

                // Se prepara la consulta de actualización de stock.
                $stmtStock = $conexion->prepare($sqlStock);

                // Se enlazan la cantidad comprada y el ID del producto.
                $stmtStock->bindParam(':cantidad', $item['cantidad']);
                $stmtStock->bindParam(':producto_id', $item['id']);

                // Se ejecuta la actualización del stock.
                $stmtStock->execute();
            }

            // Si todas las consultas se realizaron correctamente, se confirma la transacción.
            $conexion->commit();

            // Se retorna el ID del pedido creado.
            return $pedido_id;

        } catch (Exception $e) {
            // Si ocurre cualquier error, se revierten todos los cambios.
            $conexion->rollBack();
            return false;
        }
    }

    // =========================================================================
    // 📊 MÉTODOS DE ADMINISTRACIÓN Y MÉTRICAS
    // =========================================================================

    // Contar la cantidad total de pedidos en la tienda
    public static function contarPedidos() {
        global $conexion;
        $sql = "SELECT COUNT(*) as total FROM pedidos";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }

    // Sumar el dinero acumulado de las ventas
    public static function ventasTotales() {
        global $conexion;
        $sql = "SELECT SUM(total) as total_ventas FROM pedidos";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total_ventas'] ?? 0.00;
    }

    /**
     * Listado de pedidos para el Backoffice
     */
    public static function obtenerTodosAdmin() {
        global $conexion;
        $sql = "SELECT p.*, u.nombre as cliente, u.email 
                FROM pedidos p 
                JOIN usuarios u ON p.usuario_id = u.id 
                ORDER BY p.id DESC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar el estado de una compra (ej: pendiente, pagado, enviado)
    public static function cambiarEstado($id, $estado) {
        global $conexion;
        $sql = "UPDATE pedidos SET estado = :estado WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Obtener transacciones monetarias exitosas (Pagos Simulados)
     * p.* evita fallos si la columna de fecha tiene nombres distintos en tu DB.
     */
    public static function obtenerPagosAdmin() {
        global $conexion;
        $sql = "SELECT p.*, u.nombre as cliente, u.email
                FROM pedidos p
                INNER JOIN usuarios u ON p.usuario_id = u.id
                WHERE p.estado = 'pagado' 
                ORDER BY p.id DESC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Estadísticas: Top 5 de productos más vendidos
     */
    public static function productosMasVendidos() {
        global $conexion;
        $sql = "SELECT dp.nombre_producto, 
                       SUM(dp.cantidad) as total_vendido,
                       SUM(dp.subtotal) as total_generado
                FROM detalle_pedido dp
                GROUP BY dp.producto_id, dp.nombre_producto
                ORDER BY total_vendido DESC
                LIMIT 5";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Estadísticas: Top 5 de usuarios compradores (Clientes frecuentes)
     */
    public static function clientesFrecuentes() {
        global $conexion;
        $sql = "SELECT p.usuario_id, u.nombre, u.email, 
                       COUNT(p.id) as total_pedidos, 
                       SUM(p.total) as total_compras 
                FROM pedidos p
                JOIN usuarios u ON p.usuario_id = u.id
                GROUP BY p.usuario_id, u.nombre, u.email
                ORDER BY total_pedidos DESC
                LIMIT 5";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =========================================================================
    // 📦 MÉTODO OPTIMIZADO: HISTORIAL DESGLOSADO CON CONTROL DE IMÁGENES NULL
    // =========================================================================
    /**
     * Consulta el historial detallado de las compras del usuario actual.
     * Si el producto ya no existe en el catálogo, IFNULL le asigna 'default.png'.
     */
    public static function obtenerPorUsuario($usuario_id) {
        global $conexion;
        
        try {
            // Forzamos la conversión a entero para prevenir incompatibilidades con la columna INT de MySQL
            $usuario_id_limpio = (int)$usuario_id;
            
            // Usamos IFNULL para que si prod.imagen es null, devuelva 'default.png' de forma automática
            $sql = "SELECT 
                        p.id AS id_pedido, 
                        dp.nombre_producto AS nombre_producto, 
                        IFNULL(prod.imagen, 'default.png') AS imagen, 
                        dp.cantidad AS cantidad, 
                        p.metodo_pago AS metodo_pago, 
                        dp.subtotal AS total_pagado, 
                        p.estado AS estado
                    FROM pedidos p
                    INNER JOIN detalle_pedido dp ON p.id = dp.pedido_id
                    LEFT JOIN productos prod ON dp.producto_id = prod.id
                    WHERE p.usuario_id = :usuario_id 
                    ORDER BY p.id DESC";
                    
            $stmt = $conexion->prepare($sql);
            $stmt->execute([':usuario_id' => $usuario_id_limpio]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            // En caso de que falle la base de datos, retornamos un arreglo vacío de forma controlada
            return [];
        }
    }
}
?>