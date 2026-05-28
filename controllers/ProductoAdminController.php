<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../models/Usuario.php';

class ProductoAdminController {

    private function validarAdmin() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: index.php?accion=login");
            exit;
        }
    }

    private function subirImagen($imagenActual = '') {
        if (!isset($_FILES['imagen_archivo']) || $_FILES['imagen_archivo']['error'] !== UPLOAD_ERR_OK) {
            return $imagenActual;
        }

        $carpeta = __DIR__ . '/../uploads/productos/';

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $nombreOriginal = $_FILES['imagen_archivo']['name'];
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

        $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($extension, $permitidas)) {
            return $imagenActual;
        }

        $nuevoNombre = 'producto_' . time() . '_' . rand(1000, 9999) . '.' . $extension;
        $rutaDestino = $carpeta . $nuevoNombre;

        if (move_uploaded_file($_FILES['imagen_archivo']['tmp_name'], $rutaDestino)) {
            return 'uploads/productos/' . $nuevoNombre;
        }

        return $imagenActual;
    }

    public function dashboard() {
        $this->validarAdmin();

        $productosActivos = Producto::contarProductosActivos();
        $pedidosRealizados = Pedido::contarPedidos();
        $ventasTotales = Pedido::ventasTotales();
        $clientesRegistrados = Usuario::contarClientes();
        $stockBajo = Producto::contarStockBajo();

        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function productos() {
        $this->validarAdmin();
        $productos = Producto::obtenerTodosAdmin();
        require __DIR__ . '/../views/admin/productos.php';
    }

    public function crearProducto() {
        $this->validarAdmin();
        $producto = null;
        require __DIR__ . '/../views/admin/producto_form.php';
    }

    public function guardarProducto() {
        $this->validarAdmin();

        $imagen = $this->subirImagen('');

        Producto::crearProducto(
            $_POST['nombre'] ?? '',
            $_POST['descripcion'] ?? '',
            $_POST['precio'] ?? 0,
            $_POST['stock'] ?? 0,
            $imagen,
            $_POST['categoria'] ?? '',
            $_POST['estado'] ?? 'activo'
        );

        header("Location: index.php?accion=admin_productos");
        exit;
    }

    public function editarProducto($id) {
        $this->validarAdmin();

        $producto = Producto::obtenerPorIdAdmin($id);

        require __DIR__ . '/../views/admin/producto_form.php';
    }

    public function actualizarProducto() {
        $this->validarAdmin();

        $imagenActual = $_POST['imagen_actual'] ?? '';
        $imagen = $this->subirImagen($imagenActual);

        Producto::actualizarProducto(
            $_POST['id'],
            $_POST['nombre'],
            $_POST['descripcion'],
            $_POST['precio'],
            $_POST['stock'],
            $imagen,
            $_POST['categoria'],
            $_POST['estado']
        );

        header("Location: index.php?accion=admin_productos");
        exit;
    }

    public function cambiarEstado($id, $estado) {
        $this->validarAdmin();

        Producto::cambiarEstado($id, $estado);

        header("Location: index.php?accion=admin_productos");
        exit;
    }

    public function pedidos() {
        $this->validarAdmin();
        $pedidos = Pedido::obtenerTodosAdmin();
        require __DIR__ . '/../views/admin/pedidos.php';
    }

    public function cambiarEstadoPedido($id, $estado) {
        $this->validarAdmin();
        Pedido::cambiarEstado($id, $estado);
        header("Location: index.php?accion=admin_pedidos");
        exit;
    }

    public function inventario() {
        $this->validarAdmin();
        $inventario = Producto::obtenerInventario();
        require __DIR__ . '/../views/admin/inventario.php';
    }

    public function formularioMovimiento($tipo) {
        $this->validarAdmin();
        $productos = Producto::obtenerTodosAdmin();
        $tipoMovimiento = $tipo;
        require __DIR__ . '/../views/admin/movimiento_form.php';
    }

    public function guardarMovimiento() {
        $this->validarAdmin();

        Producto::registrarMovimiento(
            $_POST['producto_id'] ?? null,
            $_POST['tipo_movimiento'] ?? '',
            $_POST['cantidad'] ?? 0,
            $_POST['motivo'] ?? ''
        );

        header("Location: index.php?accion=admin_inventario");
        exit;
    }

    public function movimientos() {
        $this->validarAdmin();
        $movimientos = Producto::obtenerMovimientosAlmacen();
        require __DIR__ . '/../views/admin/movimientos.php';
    }

    public function clientes() {
        $this->validarAdmin();
        $clientes = Usuario::obtenerClientesAdmin();
        require __DIR__ . '/../views/admin/clientes.php';
    }

    public function reportes() {
        $this->validarAdmin();

        $ventasTotales = Pedido::ventasTotales();
        $pedidosRealizados = Pedido::contarPedidos();
        $productosVendidos = Pedido::productosMasVendidos();
        $clientesFrecuentes = Pedido::clientesFrecuentes();

        require __DIR__ . '/../views/admin/reportes.php';
    }

    public function pagos() {
        $this->validarAdmin();
        $pagos = Pedido::obtenerPagosAdmin();
        require __DIR__ . '/../views/admin/pagos.php';
    }
}
?>