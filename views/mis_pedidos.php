<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos - RASPAFROST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* ========================================= */
        /* VARIABLES GLOBALES RASPAFROST */
        /* ========================================= */
        :root {
            --azul-hielo: #00cfff;
            --azul-frost: #38bdf8;
            --rosa-fresa: #ff3ea5;
            --morado-uva: #7c3aed;
            --amarillo-mango: #ffd60a;
            --verde-limon: #7cff00;
            --blanco-hielo: #ffffff;
            --gris-texto: #334155;
            --oscuro: #0f172a;
        }

        body { 
            background: 
                radial-gradient(circle at 0% 0%, rgba(0, 207, 255, 0.1), transparent 40%),
                radial-gradient(circle at 100% 100%, rgba(124, 58, 237, 0.06), transparent 40%),
                #f8fafc;
            font-family: 'Poppins', Arial, sans-serif;
            color: var(--oscuro);
            min-height: 100vh;
        }

        /* Encabezado Institucional Sincronizado Premium */
        .header-tecnm { 
            background: rgba(255, 255, 255, 0.8) !important; 
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 207, 255, 0.15) !important; 
        }

        .logo-container {
            width: 120px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--blanco-hielo);
            border-radius: 12px;
            padding: 4px;
            border: 1px solid rgba(0, 207, 255, 0.1);
            box-shadow: 0 4px 12px rgba(0, 207, 255, 0.05);
        }

        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Componentes del Sistema RASPAFROST */
        h1.text-dark {
            color: var(--oscuro) !important;
        }

        /* Botones de acción estilizados */
        .btn-custom { 
            border-radius: 12px !important; 
            font-weight: 700 !important; 
            font-size: 14px;
            padding: 10px 20px !important;
            border: none !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .btn-secondary.btn-custom {
            background: #e2e8f0 !important;
            color: var(--oscuro) !important;
            border: 1px solid #cbd5e1 !important;
        }

        .btn-secondary.btn-custom:hover {
            background: #cbd5e1 !important;
            transform: translateY(-2px);
        }

        .btn-outline-primary.btn-custom {
            background: transparent !important;
            color: var(--oscuro) !important;
            border: 2px solid var(--oscuro) !important;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05) !important;
        }

        .btn-outline-primary.btn-custom:hover {
            background: var(--oscuro) !important;
            color: var(--blanco-hielo) !important;
            transform: translateY(-2px);
        }

        /* Estilos de la tabla de pedidos */
        .table-responsive {
            border-radius: 20px !important;
            overflow: hidden;
            border: 1px solid rgba(15, 23, 42, 0.06);
            box-shadow: 0 4px 25px rgba(15, 23, 42, 0.03) !important;
        }

        .tabla-pedidos {
            background: var(--blanco-hielo) !important;
        }

        .tabla-pedidos thead.table-dark {
            border-bottom: 1px solid rgba(15, 23, 42, 0.06);
        }

        .tabla-pedidos th { 
            background: #f1f5f9 !important;
            color: var(--oscuro) !important;
            font-size: 13px !important;
            font-weight: 800 !important; 
            text-transform: uppercase !important;
            letter-spacing: 0.5px;
            padding: 16px 10px !important;
        }

        .tabla-pedidos td {
            font-size: 14px !important;
            font-weight: 600 !important;
            color: var(--gris-texto) !important;
            padding: 16px 10px !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }

        .tabla-pedidos tr:hover {
            background-color: #f8fafc !important;
        }

        .producto-img {
            width: 55px; 
            height: 55px; 
            object-fit: contain;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid rgba(15, 23, 42, 0.06);
            padding: 4px;
        }

        /* Alertas y Estados */
        .alert-info {
            background: var(--blanco-hielo) !important;
            border: 1px dashed #cbd5e1 !important;
            border-radius: 16px !important;
            padding: 30px !important;
        }

        .badge-pill-custom {
            font-size: 11px !important;
            font-weight: 800 !important;
            letter-spacing: 0.3px;
            padding: 6px 12px !important;
            text-transform: uppercase !important;
            border-radius: 8px !important;
            display: inline-block;
        }

        .bg-success.badge-pill-custom {
            background-color: #f0fdf4 !important;
            color: #166534 !important;
            border: 1px solid #bbf7d0;
        }

        .bg-info.badge-pill-custom {
            background-color: #f0f9ff !important;
            color: #0369a1 !important;
            border: 1px solid #bae6fd;
        }

        .bg-warning.badge-pill-custom {
            background-color: #fff7ed !important;
            color: #c2410c !important;
            border: 1px solid #ffedd5;
        }
    </style>
</head>
<body>

<header class="header-tecnm py-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo-container">
            <img src="assets/tecnm.png" alt="Logo TecNM">
        </div>
        <h5 class="m-0 text-center fw-bold d-none d-md-block text-secondary">
            Tecnológico Nacional de México - Campus Pachuca
        </h5>
        <div class="logo-container">
            <img src="assets/itp.png" alt="Logo ITP">
        </div>
    </div>
</header>

<div class="container my-5">

    <div class="text-center mb-5">
        <img src="assets/LOGO.png" class="img-fluid mb-2" style="max-width: 110px;" alt="Logo Raspafrost">
        <h1 class="text-dark fw-bold m-0">📦 Mis pedidos</h1>
        <p class="text-muted mt-2">
            Consulta el estado de tus compras, métodos de pago y el seguimiento de tus pedidos.
        </p>
    </div>

    <div class="d-flex gap-2 mb-4">
        <a href="index.php" class="btn btn-secondary btn-custom shadow-sm">← Volver al catálogo</a>
        <a href="index.php?accion=mis_mensajes" class="btn btn-outline-primary btn-custom shadow-sm">✉️ Ver mis mensajes</a>
    </div>

    <?php if (empty($pedidos)): ?>
        
        <div class="alert alert-info text-center shadow-sm p-4 rounded-3">
            <h5 class="mb-1 fw-bold text-dark">Sin compras aún</h5>
            <p class="mb-0 text-secondary">Aún no ha realizado ningún pedido en nuestra tienda virtual.</p>
        </div>

    <?php else: ?>

        <div class="table-responsive shadow-sm rounded-3">
            <table class="table table-bordered table-striped bg-white text-center align-middle mb-0 tabla-pedidos">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 12%;">ID Pedido</th>
                        <th style="width: 22%;">Producto</th>
                        <th style="width: 13%;">Imagen</th>
                        <th style="width: 10%;">Cantidad</th>
                        <th style="width: 15%;">Método de pago</th>
                        <th style="width: 13%;">Total pagado</th>
                        <th style="width: 15%;">Estado envío</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td class="fw-bold text-secondary">
                            #<?php echo htmlspecialchars($pedido['id_pedido'] ?? $pedido['pedido_id'] ?? $pedido['id'] ?? ''); ?>
                        </td>
                        
                        <td class="text-start px-3 fw-semibold text-dark">
                            <?php echo htmlspecialchars($pedido['nombre_producto'] ?? $pedido['producto'] ?? 'No disponible'); ?>
                        </td>
                        
                        <td>
                            <?php 
                            $imagen = $pedido['imagen'] ?? $pedido['foto'] ?? 'default.png';
                            $ruta_img = (strpos($imagen, 'assets/') === false) ? 'assets/' . $imagen : $imagen;
                            ?>
                            <img src="<?php echo htmlspecialchars($ruta_img); ?>" alt="Producto" class="producto-img shadow-sm">
                        </td>
                        
                        <td class="fw-bold">
                            <?php echo htmlspecialchars($pedido['cantidad'] ?? 1); ?>
                        </td>
                        
                        <td class="text-muted">
                            <?php echo htmlspecialchars($pedido['metodo_pago'] ?? 'No especificado'); ?>
                        </td>
                        
                        <td class="fw-bold text-dark">
                            $<?php echo number_format($pedido['total_pagado'] ?? $pedido['total'] ?? $pedido['precio'] ?? 0, 2); ?>
                        </td>
                        
                        <td>
                            <?php 
                            $estado = strtolower($pedido['estado'] ?? $pedido['estado_envio'] ?? 'pendiente');
                            if ($estado === 'entregado' || $estado === 'completado'): ?>
                                <span class="badge bg-success badge-pill-custom">Entregado</span>
                            <?php elseif ($estado === 'en camino' || $estado === 'enviado'): ?>
                                <span class="badge bg-info text-dark badge-pill-custom">En Camino</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark badge-pill-custom">Pendiente</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>

</div>

</body>
</html>