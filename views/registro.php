<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atención a clientes - RASPAFROST</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .header-tecnm {
            background: white;
            border-bottom: 3px solid #0d6efd;
        }
        .card-contacto {
            border-radius: 15px;
            max-width: 600px;
            margin: 0 auto;
        }
        .btn-enviar {
            background: #0d6efd;
            border: none;
            color: white;
            border-radius: 10px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-enviar:hover {
            background: #0b5ed7;
            transform: translateY(-1px);
        }
        .btn-volver {
            border-radius: 10px;
        }
        
        /* DISEÑO CORREGIDO PARA LOS BOTONES FLOTANTES DE SOPORTE */
        .botones-soporte-flotantes {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .btn-soporte-personalizado {
            background: rgba(255, 255, 255, 0.95) !important;
            color: #1e1b4b !important; /* Azul marino oscuro para legibilidad absoluta */
            font-weight: bold !important;
            border: 2px solid #a21caf !important; /* Borde rosa/morado estético */
            border-radius: 30px !important;
            padding: 10px 20px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
            text-decoration: none !none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .btn-soporte-personalizado:hover {
            background: #a21caf !important;
            color: white !important;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>

<header class="header-tecnm py-3 shadow-sm mb-5">
    <div class="container d-flex justify-content-between align-items-center">
        <div style="width:120px;height:70px;display:flex;align-items:center;justify-content:center;">
            <img src="./assets/tecnm.png" style="width: 100%; height: 100%; object-fit: contain;" alt="Logo TecNM">
        </div>

        <h5 class="m-0 text-center fw-bold d-none d-md-block">
            Tecnológico Nacional de México - Campus Pachuca
        </h5>

        <div style="width:120px;height:70px;display:flex;align-items:center;justify-content:center;">
            <img src="./assets/itp.png" style="width: 100%; height: 100%; object-fit: contain;" alt="Logo ITP">
        </div>
    </div>
</header>

<div class="container">
    <div class="card card-contacto shadow-sm">
        <div class="card-body p-4">

            <div class="text-center mb-4">
                <img src="./assets/LOGO.png" style="width:120px;" alt="Logo Raspafrost">
                <h1 class="text-primary mt-3 fw-bold">Atención a clientes</h1>
                <p class="text-muted">Envíanos tu duda, queja o comentario y te responderemos a la brevedad.</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger text-center shadow-sm">
                    <?php 
                        echo htmlspecialchars($_SESSION['error']); 
                        unset($_SESSION['error']); 
                    ?>
                </div>
            <?php endif; ?>

            <form action="index.php?accion=guardar_mensaje" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="nombre" class="form-control" 
                           value="<?php echo $_SESSION['usuario']['nombre'] ?? ''; ?>" placeholder="Tu nombre completo" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Correo</label>
                    <input type="email" name="correo" class="form-control" 
                           value="<?php echo $_SESSION['usuario']['email'] ?? ''; ?>" placeholder="nombre@correo.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Asunto</label>
                    <input type="text" name="asunto" class="form-control" placeholder="Motivo del mensaje" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Mensaje</label>
                    <textarea name="mensaje" class="form-control" rows="5" placeholder="Escribe detalladamente aquí..." required></textarea>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-enviar px-4 py-2 flex-grow-1">Enviar mensaje</button>
                    <a href="index.php" class="btn btn-secondary btn-volver px-4 py-2">Volver</a>
                </div>
            </form>

        </div>
    </div>
</div>

<footer class="text-center py-4 text-muted mt-5 bg-white border-top">
    <p class="mb-0">© 2026 Ecommerce - Todos los derechos reservados Negocios Electrónicos II - EQUIPO 4</p>
</footer>

</body>
</html>