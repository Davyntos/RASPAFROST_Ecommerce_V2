<?php
// =========================================================================
// 1. CONFIGURACIÓN DE SESIÓN, SEGURIDAD Y BÚFER DE SALIDA
// =========================================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * 🛠️ ACTIVADOR DE ERRORES FORZADO (Antídoto contra la pantalla en blanco)
 * Esto obliga a XAMPP a pintar en pantalla cualquier error de sintaxis u olvido.
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Activamos el búfer de salida. 
 * Esto nos permite capturar todo el HTML generado por el catálogo o las vistas
 * y corregir cualquier ruta rota hacia "img/" sobre la marcha antes de enviarla al cliente.
 */
ob_start();

try {
    // =========================================================================
    // 2. INCLUSIÓN DE CONTROLADORES Y MODELOS REQUERIDOS
    // =========================================================================
    require_once __DIR__ . '/controllers/ProductoController.php';
    require_once __DIR__ . '/controllers/CarritoController.php';
    require_once __DIR__ . '/controllers/AuthController.php';
    require_once __DIR__ . '/controllers/checkoutcontroller.php'; 
    require_once __DIR__ . '/controllers/ProductoAdminController.php'; 
    require_once __DIR__ . '/controllers/MensajeController.php';

    // Carga global del modelo de mensajes en minúscula para evitar errores
    require_once __DIR__ . '/models/mensaje.php'; 

    /**
     * Auxiliar para proteger de forma masiva todas las rutas de administración.
     */
    function verificarPermisoAdmin() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: index.php?accion=login");
            exit;
        }
    }

    // =========================================================================
    // 3. ENRUTADOR (ROUTER) SINCRONIZADO AL CONTROLADOR
    // =========================================================================
    $accion = $_GET['accion'] ?? 'catalogo';

    switch ($accion) {

        // 🔐 RUTAS PROTEGIDAS: PANEL DE ADMINISTRACIÓN (BACKOFFICE)
        case 'admin_dashboard':
        case 'dashboard': 
            verificarPermisoAdmin();
            $controller = new ProductoAdminController();
            $controller->dashboard(); 
            break;

        case 'admin_productos':
            verificarPermisoAdmin();
            $controller = new ProductoAdminController();
            $controller->productos(); 
            break;

        case 'admin_crear_producto':
            verificarPermisoAdmin();
            $controller = new ProductoAdminController();
            $controller->crearProducto(); 
            break;

        case 'admin_editar_producto':
            verificarPermisoAdmin();
            $id = $_GET['id'] ?? null;
            $controller = new ProductoAdminController();
            $controller->editarProducto($id); 
            break;

        case 'admin_guardar_producto':
            verificarPermisoAdmin();
            $controller = new ProductoAdminController();
            $controller->guardarProducto(); 
            break;

        case 'admin_actualizar_producto':
            verificarPermisoAdmin();
            $controller = new ProductoAdminController();
            $controller->actualizarProducto(); 
            break;

        case 'admin_cambiar_estado':
            verificarPermisoAdmin();
            $id = $_GET['id'] ?? null;
            $estado = $_GET['estado'] ?? 'activo';
            $controller = new ProductoAdminController();
            $controller->cambiarEstado($id, $estado); 
            break;

        case 'admin_inventario':
            verificarPermisoAdmin();
            $controller = new ProductoAdminController();
            $controller->inventario(); 
            break;

        case 'admin_movimientos':
            verificarPermisoAdmin();
            $controller = new ProductoAdminController();
            $controller->movimientos(); 
            break;

        case 'admin_entrada_almacen':
            verificarPermisoAdmin();
            $controller = new ProductoAdminController();
            $controller->formularioMovimiento('entrada'); 
            break;

        case 'admin_salida_almacen':
            verificarPermisoAdmin();
            $controller = new ProductoAdminController();
            $controller->formularioMovimiento('salida'); 
            break;

        case 'admin_guardar_movimiento':
            verificarPermisoAdmin();
            $controller = new ProductoAdminController();
            $controller->guardarMovimiento(); 
            break;

        case 'admin_pedidos':
            verificarPermisoAdmin();
            $controller = new ProductoAdminController();
            $controller->pedidos(); 
            break;

        case 'admin_cambiar_estado_pedido':
            verificarPermisoAdmin(); 
            $id = $_GET['id'] ?? null;
            $estado = $_GET['estado'] ?? '';
            $controller = new ProductoAdminController();
            $controller->cambiarEstadoPedido($id, $estado); 
            break;

        case 'admin_clientes':
            verificarPermisoAdmin();
            $controller = new ProductoAdminController();
            $controller->clientes(); 
            break;

        case 'admin_pagos':
            verificarPermisoAdmin();
            $controller = new ProductoAdminController();
            $controller->pagos(); 
            break;

        case 'admin_reportes':
            verificarPermisoAdmin();
            $controller = new ProductoAdminController();
            $controller->reportes(); 
            break;

        // ✉️ RUTAS DE CORREO / MENSAJERÍA (BACKOFFICE)
        case 'admin_mensajes':
            verificarPermisoAdmin();
            $controller = new MensajeController();
            $controller->adminMensajes(); 
            break;

        case 'admin_responder_mensaje':
            verificarPermisoAdmin();
            $id = $_GET['id'] ?? null;
            $controller = new MensajeController();
            $controller->responderMensaje($id); 
            break;

        case 'admin_guardar_respuesta':
            verificarPermisoAdmin();
            $controller = new MensajeController();
            $controller->guardarRespuesta(); 
            break;

        // =========================================================================
        // 🎧 RUTAS PÚBLICAS: ATENCIÓN AL CLIENTE (MÓDULO DE SOPORTE)
        // =========================================================================
        case 'contacto':
            $controller = new MensajeController();
            $controller->contacto(); 
            break;

        case 'guardar_mensaje':
            $controller = new MensajeController();
            $controller->guardarMensaje(); 
            break;

        case 'mensaje_enviado':
            $controller = new MensajeController();
            $controller->mensajeEnviado();
            break;

        case 'mis_mensajes':
            $controller = new MensajeController();
            $controller->misMensajes(); 
            break;

        // 🛒 RUTAS DE AUTENTICACIÓN (AUTH)
        case 'login':
            $controller = new AuthController();
            $controller->mostrarLogin();
            break;

        case 'registro':
            $controller = new AuthController();
            $controller->mostrarRegistro();
            break;

        case 'guardar_usuario':
            $controller = new AuthController();
            $controller->registrar();
            break;

        case 'validar_login':
            $controller = new AuthController();
            $controller->login();
            break;

        case 'logout':
            $controller = new AuthController();
            $controller->logout();
            break;

        // 📦 RUTAS DEL CATÁLOGO DE PRODUCTOS (PÚBLICO)
        case 'catalogo':
            $controller = new ProductoController();
            $controller->mostrarCatalogo();
            break;

        // 🛍️ RUTAS DEL CARRITO DE COMPRAS
        case 'agregar_carrito':
            $id = $_GET['id'] ?? null;
            $controller = new CarritoController();
            $controller->agregar($id);
            break;

        case 'ver_carrito':
            $controller = new CarritoController();
            $controller->verCarrito();
            break;

        case 'aumentar_carrito':
            $id = $_GET['id'] ?? null;
            $controller = new CarritoController();
            $controller->aumentar($id);
            break;

        case 'disminuir_carrito':
            $id = $_GET['id'] ?? null;
            $controller = new CarritoController();
            $controller->disminuir($id);
            break;

        case 'eliminar_carrito':
            $id = $_GET['id'] ?? null;
            $controller = new CarritoController();
            $controller->eliminar($id);
            break;

        case 'vaciar_carrito':
            $controller = new CarritoController();
            $controller->vaciar();
            break;

        case 'finalizar_compra':
            $controller = new CarritoController();
            $controller->finalizarCompra();
            break;

        // 📦 HISTORIAL DE PEDIDOS DEL CLIENTE LOGUEADO
        case 'mis_pedidos':
            $controller = new CarritoController();
            $controller->misPedidos(); 
            break;

        // 💳 RUTAS DE CHECKOUT Y PAGO
        case 'checkout':
            $controller = new checkoutcontroller();
            $controller->mostrarCheckout();
            break;

        case 'procesar_pago':
            $controller = new checkoutcontroller();
            $controller->procesarPago();
            break;

        case 'confirmacion':
            $controller = new checkoutcontroller();
            $controller->confirmacion();
            break;

        // 📋 RUTA POR DEFECTO
        default:
            $controller = new ProductoController();
            $controller->mostrarCatalogo();
            break;
    }

} catch (Throwable $e) {
    // Si algo truena en medio del camino, limpiamos el búfer y pintamos el error real
    ob_end_clean();
    echo "<div style='padding:20px; background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; font-family:sans-serif;'>";
    echo "<h3>💥 Error detectado en el sistema RASPAFROST:</h3>";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . " en la línea " . $e->getLine() . "</p>";
    echo "</div>";
    exit;
}

// =========================================================================
// 4. FILTRO SANITIZADOR DE RUTAS EMITIDAS (Limpieza forzada contra 404)
// =========================================================================
// Recuperamos el contenido total del HTML procesado en el buffer
$contenido_salida = ob_get_clean();

/**
 * Buscamos cadenas que apunten a la carpeta vieja "img/" o nombres incorrectos
 * y las reemplazamos en tiempo de ejecución por sus rutas funcionales en "assets/".
 */
$contenido_salida = str_replace('img/logotecnm.png', 'assets/tecnm.png', $contenido_salida);
$contenido_salida = str_replace('img/logoitp.png', 'assets/itp.png', $contenido_salida);
$contenido_salida = str_replace('img/logo.png', 'assets/LOGO.png', $contenido_salida);
$contenido_salida = str_replace('ECOMMERCE/img/', 'assets/', $contenido_salida);

// Renderizamos el código limpio directamente al navegador
echo $contenido_salida;
?>