<?php
// Se incluye el archivo de conexión a la base de datos.
// Este archivo contiene la variable $conexion, la cual permite realizar consultas mediante PDO.
require_once __DIR__ . '/../config/db.php';

// Modelo Producto.
// Esta clase se encarga de gestionar las operaciones relacionadas con los productos
// dentro de la base de datos, como consultar productos activos,
// obtener un producto específico y actualizar su stock.
class Producto {

    // Método estático encargado de obtener todos los productos activos.
    public static function obtenerTodos() {
        // Se utiliza la conexión global definida en el archivo db.php.
        global $conexion;

        // Consulta SQL para seleccionar únicamente los productos que están activos.
        $sql = "SELECT * FROM productos WHERE estado = 'activo'";

        // Se prepara la consulta para ejecutarla de forma segura.
        $stmt = $conexion->prepare($sql);

        // Se ejecuta la consulta.
        $stmt->execute();

        // Se devuelven todos los registros encontrados en forma de arreglo asociativo.
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método estático encargado de obtener un producto específico por su ID.
    public static function obtenerPorId($id) {
        global $conexion;

        $sql = "SELECT * FROM productos WHERE id = :id AND estado = 'activo'";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método estático encargado de actualizar el stock de un producto (Venta pública).
    public static function actualizarStock($id, $cantidad) {
        global $conexion;

        $sql = "UPDATE productos 
                SET stock = stock - :cantidad 
                WHERE id = :id AND stock >= :cantidad";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // =========================================================================
    // 🛠️ MÉTODOS DE GESTIÓN Y PANEL DE ADMINISTRACIÓN
    // =========================================================================

    // 📊 Métricas para el Dashboard
    public static function contarProductosActivos() {
        global $conexion;
        $sql = "SELECT COUNT(*) as total FROM productos WHERE estado = 'activo'";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }

    /**
     * Compara dinámicamente el stock actual contra el stock mínimo 
     * establecido individualmente en la base de datos.
     */
    public static function contarStockBajo() {
        global $conexion;
        $sql = "SELECT COUNT(*) as total FROM productos WHERE stock <= stock_minimo AND estado = 'activo'";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }

    // 📋 Métodos de gestión para ProductoAdminController
    public static function obtenerTodosAdmin() {
        global $conexion;
        // Trae todos los productos sin importar si están activos o inactivos
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerPorIdAdmin($id) {
        global $conexion;
        $sql = "SELECT * FROM productos WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function crearProducto($nombre, $descripcion, $precio, $stock, $imagen, $categoria, $estado) {
        global $conexion;
        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen, categoria, estado) 
                VALUES (:nombre, :descripcion, :precio, :stock, :imagen, :categoria, :estado)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindParam(':imagen', $imagen);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    public static function actualizarProducto($id, $nombre, $descripcion, $precio, $stock, $imagen, $categoria, $estado) {
        global $conexion;
        $sql = "UPDATE productos 
                SET nombre = :nombre, descripcion = :descripcion, precio = :precio, 
                    stock = :stock, imagen = :imagen, categoria = :categoria, estado = :estado 
                WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindParam(':imagen', $imagen);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    public static function cambiarEstado($id, $estado) {
        global $conexion;
        $sql = "UPDATE productos SET estado = :estado WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // 📦 Gestión de Inventario y Almacén
    public static function obtenerInventario() {
        global $conexion;
        // 🌟 CORRECCIÓN: Se añade 'stock_minimo' a la consulta selectiva
        $sql = "SELECT id, nombre, stock, stock_minimo, categoria, estado FROM productos ORDER BY stock ASC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function registrarMovimiento($producto_id, $tipo_movimiento, $cantidad, $motivo) {
        global $conexion;
        
        // 1. Registrar la bitácora del movimiento
        $sqlMov = "INSERT INTO movimientos_inventario (producto_id, tipo_movimiento, quantity, motivo, fecha) 
                   VALUES (:producto_id, :tipo_movimiento, :cantidad, :motivo, NOW())";
        // NOTA: Si en tu base de datos la columna es 'cantidad' en lugar de 'quantity', 
        // puedes cambiarla en la línea anterior según corresponda.
        $sqlMov = "INSERT INTO movimientos_inventario (producto_id, tipo_movimiento, cantidad, motivo, fecha) 
                   VALUES (:producto_id, :tipo_movimiento, :cantidad, :motivo, NOW())";
        
        $stmtMov = $conexion->prepare($sqlMov);
        $stmtMov->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmtMov->bindParam(':tipo_movimiento', $tipo_movimiento);
        $stmtMov->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmtMov->bindParam(':motivo', $motivo);
        $stmtMov->execute();

        // 2. Modificar el stock real en la tabla productos según el tipo
        if ($tipo_movimiento === 'entrada') {
            $sqlStock = "UPDATE productos SET stock = stock + :cantidad WHERE id = :id";
        } else {
            $sqlStock = "UPDATE productos SET stock = stock - :cantidad WHERE id = :id AND stock >= :cantidad";
        }
        
        $stmtStock = $conexion->prepare($sqlStock);
        $stmtStock->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmtStock->bindParam(':id', $producto_id, PDO::PARAM_INT);
        return $stmtStock->execute();
    }

    public static function obtenerMovimientosAlmacen() {
        global $conexion;
        // Realiza un JOIN para poder mostrar el nombre del producto en el historial
        $sql = "SELECT m.*, p.nombre as producto_nombre 
                FROM movimientos_inventario m 
                JOIN productos p ON m.producto_id = p.id 
                ORDER BY m.id DESC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>