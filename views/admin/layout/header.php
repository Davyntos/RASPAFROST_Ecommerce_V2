<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Importación correcta del modelo de mensajería nativo
require_once __DIR__ . '/../../../models/Mensaje.php';

// Corrección del error de clase: Usamos la clase Mensaje declarada en tu archivo de modelo
$mensajesPendientes = Mensaje::contarMensajesPendientes();

// Detectar la acción de la URL para iluminar dinámicamente el botón activo
$accionActual = isset($_GET['accion']) ? $_GET['accion'] : 'admin_dashboard';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Administrativo - RASPAFROST</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">

    <style>
        /* ==========================================================================
           SOBREESCRITURA DE ESTILOS: IDENTIDAD VISUAL RASPAFROST PARA EL PANEL ADMIN
           ========================================================================== */
        :root {
            --azul-frost: #00cfff;
            --azul-hielo: #0088cc;
            --morado-uva: #6f42c1;
            --rosa-fresa: #e11d48;
            --amarillo-mango: #ffc107;
            --oscuro: #1e293b;
            --gris-texto: #334155;
        }

        body {
            background-color: #f1f5f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Encabezado Institucional con degradado de marca */
        .header-tecnm {
            background: linear-gradient(135deg, #00cfff, #6f42c1) !important;
            border-bottom: 4px solid #ffc107 !important;
            padding: 15px 0;
        }

        .header-tecnm h5 {
            color: #ffffff !important;
            text-shadow: 2px 2px 0 rgba(0, 0, 0, 0.25);
            font-size: 1.15rem;
        }

        /* Barra de Navegación del Administrador */
        .navbar-admin {
            background: #ffffff !important;
            border-bottom: 3px solid rgba(0, 207, 255, 0.15) !important;
            padding: 12px 0 !important;
        }

        .logo-admin {
            width: 65px;
            height: 65px;
            object-fit: contain;
            margin-right: 12px;
            filter: drop-shadow(0 4px 6px rgba(0, 207, 255, 0.2));
        }

        .navbar-brand-custom {
            font-size: 1.4rem;
            font-weight: 900;
            background: linear-gradient(135deg, #00cfff, #e11d48);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
        }

        /* Estilización de Botones en forma de píldora */
        .nav-btn-custom {
            font-weight: 700 !important;
            font-size: 0.85rem !important;
            border-radius: 999px !important;
            padding: 6px 16px !important;
            transition: all 0.25s ease-in-out !important;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            text-decoration: none;
            display: inline-block;
        }

        /* Botón Activo Estilo Frost */
        .btn-admin-primary {
            background: linear-gradient(135deg, #00cfff, #0088cc) !important;
            color: #ffffff !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(0, 207, 255, 0.25);
        }

        .btn-admin-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 207, 255, 0.4);
        }

        /* Botones Secundarios */
        .btn-admin-outline {
            background: transparent !important;
            color: #1e293b !important;
            border: 2px solid #e2e8f0 !important;
        }

        .btn-admin-outline:hover {
            background: #ffffff !important;
            border-color: #00cfff !important;
            color: #00cfff !important;
            transform: translateY(-2px);
        }

        /* Variación Alerta/Mensajes */
        .btn-admin-danger-outline {
            background: transparent !important;
            color: #e11d48 !important;
            border: 2px solid #ffe4e6 !important;
        }

        .btn-admin-danger-outline:hover {
            background: #fff1f2 !important;
            border-color: #e11d48 !important;
            transform: translateY(-2px);
        }

        /* Botón de Salida */
        .btn-admin-logout {
            background: linear-gradient(135deg, #e11d48, #be123c) !important;
            color: #ffffff !important;
            border: none !important;
        }

        .btn-admin-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(225, 29, 72, 0.3);
        }

        .badge-notif-custom {
            background: #e11d48 !important;
            font-weight: 900 !important;
            font-size: 11px !important;
            border: 2px solid #ffffff;
        }

        /* ==========================================================================
           🌟 CONTROL ESTRICTO DE TIPOGRAFÍA Y SIMETRÍA EN TABLAS DE ADMINISTRACIÓN
           ========================================================================== */
        
        /* Asegurar misma fuente base en todo el ecosistema de tablas */
        table, .table {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            font-size: 14px !important;
        }

        /* Encabezados de tabla unificados */
        table th, .table th, .table thead th {
            font-size: 14px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            padding: 14px 10px !important;
            vertical-align: middle !important;
        }

        /* Celdas de datos: Forzamos la misma escala y grosor en todas las columnas */
        table td, .table td,
        table td strong, .table td strong,
        table td span, .table td .fw-bold, .table td b {
            font-size: 14px !important;
            font-weight: 600 !important; /* Peso uniforme para evitar que columnas destaquen sobre otras */
            color: var(--gris-texto) !important;
            padding: 12px 10px !important;
            vertical-align: middle !important;
            text-shadow: none !important;
        }

        /* Distinción sutil de color para textos importantes (como Nombres), manteniendo el tamaño */
        table td strong, .table td strong {
            color: var(--oscuro) !important;
        }

        /* Estandarizar badges internos en celdas (ej: "Activo" o contadores) */
        .table .badge, .badge-estado, .badge-envio, table td .badge {
            font-size: 12px !important;
            font-weight: 800 !important;
            letter-spacing: 0.3px !important;
            padding: 5px 12px !important;
            text-transform: uppercase !important;
            border-radius: 6px !important;
            display: inline-block !important;
        }
    </style>
</head>
<body>

<header class="header-tecnm shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <div style="width: 180px; height: 95px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.15); border-radius: 10px; padding: 6px;">
    <img src="assets/tecnm.png" style="width: 100%; height: 100%; object-fit: contain;">
</div>
        <h5 class="m-0 text-center fw-bold">
            Tecnológico Nacional de México - Campus Pachuca
        </h5>
         <div style="width: 180px; height: 95px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.15); border-radius: 10px; padding: 6px;">
    <img src="assets/itp.png" style="width: 100%; height: 100%; object-fit: contain;">
</div>
    </div>
</header>

<nav class="navbar navbar-expand-lg navbar-light navbar-admin shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand-custom d-flex align-items-center" href="index.php?accion=admin_dashboard">
            <img src="assets/LOGO.png" class="logo-admin" alt="Raspafrost">
            Panel Administrativo
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#menuAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="menuAdmin">
            <div class="d-flex gap-2 flex-wrap mt-3 mt-lg-0">

                <a href="index.php?accion=admin_dashboard" class="nav-btn-custom <?php echo ($accionActual === 'admin_dashboard') ? 'btn-admin-primary' : 'btn-admin-outline'; ?>">
                    Dashboard
                </a>

                <a href="index.php?accion=admin_productos" class="nav-btn-custom <?php echo (strpos($accionActual, 'producto') !== false) ? 'btn-admin-primary' : 'btn-admin-outline'; ?>">
                    Productos
                </a>

                <a href="index.php?accion=admin_inventario" class="nav-btn-custom <?php echo ($accionActual === 'admin_inventario') ? 'btn-admin-primary' : 'btn-admin-outline'; ?>">
                    Inventario
                </a>

                <a href="index.php?accion=admin_movimientos" class="nav-btn-custom <?php echo (strpos($accionActual, 'movimiento') !== false || $accionActual === 'admin_entrada_almacen' || $accionActual === 'admin_salida_almacen') ? 'btn-admin-primary' : 'btn-admin-outline'; ?>">
                    Movimientos
                </a>

                <a href="index.php?accion=admin_pedidos" class="nav-btn-custom <?php echo ($accionActual === 'admin_pedidos') ? 'btn-admin-primary' : 'btn-admin-outline'; ?>">
                    Pedidos
                </a>

                <a href="index.php?accion=admin_clientes" class="nav-btn-custom <?php echo ($accionActual === 'admin_clientes') ? 'btn-admin-primary' : 'btn-admin-outline'; ?>">
                    Clientes
                </a>

                <a href="index.php?accion=admin_pagos" class="nav-btn-custom <?php echo ($accionActual === 'admin_pagos') ? 'btn-admin-primary' : 'btn-admin-outline'; ?>">
                    Pagos
                </a>

                <a href="index.php?accion=admin_reportes" class="nav-btn-custom <?php echo ($accionActual === 'admin_reportes') ? 'btn-admin-primary' : 'btn-admin-outline'; ?>">
                    Reportes
                </a>

                <a href="index.php?accion=admin_mensajes" class="nav-btn-custom position-relative <?php echo (strpos($accionActual, 'mensaje') !== false || $accionActual === 'admin_responder_mensaje') ? 'btn-admin-primary' : 'btn-admin-danger-outline'; ?>">
                    Mensajes
                    <?php if ($mensajesPendientes > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-notif-custom">
                            <?= $mensajesPendientes; ?>
                        </span>
                    <?php endif; ?>
                </a>

                <a href="index.php?accion=logout" class="nav-btn-custom btn-admin-logout">
                    Cerrar sesión
                </a>

            </div>
        </div>
    </div>
</nav>

<div class="py-4">