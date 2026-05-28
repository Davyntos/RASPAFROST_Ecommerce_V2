<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo</title>
    <link rel="stylesheet" href="css/estilos.css?v=<?php echo time(); ?>">
    <style>
        /* ==========================================================================
           CORRECCIÓN DEFINITIVA: BOTONES FLOTANTES DE SOPORTE RASPAFROST
           ========================================================================== */
        .soporte-flotante {
            position: fixed !important;
            bottom: 100px !important; /* Subido para que se posicione bien arriba del footer */
            right: 30px !important;  
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            z-index: 99999 !important; /* Máxima prioridad de capa */
        }

        /* Forzamos las propiedades base de los enlaces para eliminar transparencias */
        .btn-flotante, 
        .soporte-flotante a,
        .soporte-flotante a:link, 
        .soporte-flotante a:visited {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 10px !important;
            padding: 12px 22px !important;
            border-radius: 30px !important;
            color: #FFFFFF !important; /* Fuerza el texto a blanco puro */
            text-decoration: none !important;
            font-weight: bold !important;
            font-family: 'Segoe UI', Roboto, sans-serif !important;
            font-size: 14px !important;
            opacity: 1 !important; /* Rompe la transparencia de tu CSS externo */
            visibility: visible !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3) !important;
            transition: all 0.3s ease !important;
        }

        /* SELECTORES POR ID: Evitan que estilos externos vuelvan invisibles los fondos */
        #btn-flotante-mensajes {
            background: linear-gradient(135px, #06b6d4 0%, #0369a1 100%) !important;
            background-color: #0369a1 !important;
        }

        #btn-flotante-atencion {
            background: linear-gradient(135px, #d946ef 0%, #a21caf 100%) !important;
            background-color: #a21caf !important;
        }

        /* Efecto Hover interactivo al pasar el mouse */
        .btn-flotante:hover,
        .soporte-flotante a:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.4) !important;
            filter: brightness(1.2) !important; /* Ilumina el botón */
            opacity: 1 !important;
            color: #FFFFFF !important;
        }

        .icono-flotante {
            font-size: 16px !important;
            color: #FFFFFF !important;
        }

        /* Adaptación perfecta para pantallas de teléfonos Celulares */
        @media (max-width: 576px) {
            .soporte-flotante {
                bottom: 90px !important;
                right: 20px !important;
            }
            .texto-flotante {
                display: none !important; /* Esconde el texto en móviles */
            }
            .btn-flotante,
            .soporte-flotante a {
                padding: 12px !important;
                border-radius: 50% !important;
                width: 45px !important;
                height: 45px !important;
            }
        }
    </style>
</head>
<body>

<header class="header">
    <img src="assets/tecnm.png" class="logo-izq" alt="Logo TecNM">
    <h1>RASPAFROST</h1>
    <img src="assets/itp.png" class="logo-der" alt="Logo ITP">
</header>

<div class="encabezado-catalogo">
    <img src="assets/LOGO.png" class="logo-catalogo" alt="Logo Catálogo">
    <h1>Catálogo de Productos</h1>

    <div class="menu-catalogo">
        <?php if (isset($_SESSION['usuario'])): ?>
            <p>
                Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?>
            </p>
            <div class="botones-menu-catalogo">
                <a href="index.php?accion=ver_carrito">Ver carrito</a>
                <a href="index.php?accion=logout">Cerrar sesión</a>
            </div>
        <?php else: ?>
            <div class="botones-menu-catalogo">
                <a href="index.php?accion=login">Iniciar sesión</a>
                <a href="index.php?accion=registro">Registrarse</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="contenedor-productos">
    <?php foreach ($productos as $producto): ?>
        <div class="producto">
            <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" 
                 alt="<?php echo htmlspecialchars($producto['nombre']); ?>">

            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
            <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
            <p>
                <strong>Stock disponible:</strong> 
                <?php echo htmlspecialchars($producto['stock']); ?>
            </p>
            <p>$<?php echo number_format($producto['precio'], 2); ?></p>

            <?php if (isset($_SESSION['usuario'])): ?>
                <?php if ($producto['stock'] > 0): ?>
                    <a href="index.php?accion=agregar_carrito&id=<?php echo $producto['id']; ?>">
                        Agregar al carrito
                    </a>
                <?php else: ?>
                    <a href="#" onclick="return false;">
                        Sin stock
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <a href="index.php?accion=login">
                    Inicia sesión para comprar
                </a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<div class="soporte-flotante">
    <a href="index.php?accion=mis_mensajes" class="btn-flotante" id="btn-flotante-mensajes" title="Mis Mensajes">
        <span class="icono-flotante">✉</span>
        <span class="texto-flotante">Mensajes</span>
    </a>
    
    <a href="index.php?accion=contacto" class="btn-flotante" id="btn-flotante-atencion" title="Atención al Cliente">
        <span class="icono-flotante">🎧</span>
        <span class="texto-flotante">Atención al cliente</span>
    </a>
</div>

<footer class="footer">
    <p>© 2026 Ecommerce - Todos los derechos reservados Negocios Electrónicos II - EQUIPO 4</p>
</footer>

</body>
</html>