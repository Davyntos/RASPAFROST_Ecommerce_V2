<?php
// Se incluye el modelo Producto, ya que este controlador necesita consultar
// información de productos y actualizar el stock al finalizar una compra.
require_once __DIR__ . '/../models/Producto.php';

// Controlador encargado de gestionar todas las acciones relacionadas
// con el carrito de compras del sistema.
class CarritoController {

    // Método encargado de agregar un producto al carrito.
    public function agregar($id) {

        // Se verifica si la sesión aún no ha sido iniciada.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Se valida que el usuario haya iniciado sesión.
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }

        // Se obtiene la información del producto desde la base de datos.
        $producto = Producto::obtenerPorId($id);

        // Si el producto no existe, se redirige al inicio del sistema.
        if (!$producto) {
            header("Location: index.php");
            exit;
        }

        // Si aún no existe el carrito en la sesión, se crea como un arreglo vacío.
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Si el producto ya existe dentro del carrito, únicamente se aumenta la cantidad.
        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++;
        } else {
            // Si el producto no existe en el carrito, se agrega con sus datos principales.
            $_SESSION['carrito'][$id] = [
                'id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'imagen' => $producto['imagen'],
                'cantidad' => 1
            ];
        }

        // Después de agregar el producto, se redirige a la vista del carrito.
        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    // Método encargado de mostrar el contenido actual del carrito.
    public function verCarrito() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }

        $carrito = $_SESSION['carrito'] ?? [];

        // Se carga la vista encargada de mostrar los productos del carrito.
        require __DIR__ . '/../views/carrito.php';
    }

    // Método encargado de aumentar la cantidad de un producto dentro del carrito.
    public function aumentar($id) {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }

        if ($id !== null && isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++;
        }

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    // Método encargado de disminuir la cantidad de un producto en el carrito.
    public function disminuir($id) {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }

        if ($id !== null && isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']--;

            if ($_SESSION['carrito'][$id]['cantidad'] <= 0) {
                unset($_SESSION['carrito'][$id]);
            }
        }

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    // Método encargado de eliminar completamente un producto del carrito.
    public function eliminar($id) {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }

        if (isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    // Método encargado de vaciar completamente el carrito de compras.
    public function vaciar() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }

        unset($_SESSION['carrito']);

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    // Método encargado de finalizar la compra.
    public function finalizarCompra() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }

        if (empty($_SESSION['carrito'])) {
            header("Location: index.php?accion=ver_carrito");
            exit;
        }

        foreach ($_SESSION['carrito'] as $item) {
            Producto::actualizarStock($item['id'], $item['cantidad']);
        }

        unset($_SESSION['carrito']);

        header("Location: index.php?accion=catalogo");
        exit;
    }

    // =========================================================================
    // 📦 MÉTODO CORREGIDO: HISTORIAL DESGLOSADO DE PEDIDOS (MEDIANTE EL MODELO)
    // =========================================================================
    /**
     * Recupera el listado de pedidos delegando la consulta SQL al modelo Pedido,
     * respetando el patrón arquitectónico MVC y evitando errores de clases no encontradas.
     */
    public function misPedidos() {
        
        // Se inicia la sesión si aún no está activa.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Se valida que el usuario esté autenticado antes de ver su historial.
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }

        // Se extrae el ID único del usuario desde la sesión.
        $usuario_id = $_SESSION['usuario']['id'] ?? null;

        // Se incluye de forma limpia el modelo de Pedido
        require_once __DIR__ . '/../models/Pedido.php';
        
        // El controlador solicita la información procesada directamente al modelo estático
        $pedidos = Pedido::obtenerPorUsuario($usuario_id);

        // Se carga la interfaz visual de RASPAFROST para mapear la tabla.
        require __DIR__ . '/../views/mis_pedidos.php';
    }
}
?>