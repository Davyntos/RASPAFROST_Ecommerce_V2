<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atención a Clientes - RASPAFROST</title>
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
            --gris-texto: #475569;
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

        /* Componentes del Formulario RASPAFROST */
        .card-formulario {
            border: 1px solid rgba(15, 23, 42, 0.06) !important;
            border-radius: 24px !important;
            background: var(--blanco-hielo) !important;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04) !important;
        }

        .form-label {
            font-weight: 700 !important;
            font-size: 13px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px;
            color: var(--oscuro) !important;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 12px !important;
            border: 1px solid #cbd5e1 !important;
            padding: 12px 16px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            color: var(--oscuro) !important;
            background-color: #f8fafc !important;
            transition: all 0.2s ease !important;
        }

        .form-control::placeholder {
            color: #94a3b8 !important;
            font-weight: 400;
        }

        .form-control:focus {
            background-color: var(--blanco-hielo) !important;
            border-color: var(--azul-frost) !important;
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.15) !important;
            outline: none !important;
        }

        /* Botones de acción estilizados */
        .btn-custom { 
            border-radius: 12px !important; 
            font-weight: 700 !important; 
            font-size: 14px;
            padding: 12px 24px !important;
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

        .btn-primary.btn-custom {
            background: var(--oscuro) !important;
            color: var(--blanco-hielo) !important;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15) !important;
        }

        .btn-primary.btn-custom:hover {
            background: var(--morado-uva) !important;
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.25) !important;
            transform: translateY(-2px);
        }

        /* Alerta de Error Interna */
        .alert-danger {
            background-color: #fef2f2 !important;
            border: 1px solid #fee2e2 !important;
            color: #991b1b !important;
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
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card card-formulario shadow-sm bg-white">
                <div class="card-body p-4 p-sm-5">

                    <div class="text-center mb-4">
                        <img src="assets/LOGO.png" class="img-fluid mb-2" style="max-width: 110px;" alt="Logo Raspafrost">
                        <h1 class="text-dark fw-bold m-0 fs-2">Atención a clientes</h1>
                        <p class="text-muted mt-1">Envíanos tu duda, queja o comentario y te responderemos pronto.</p>
                    </div>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger shadow-sm py-2 px-3 rounded-3" role="alert">
                            <small class="fw-semibold">⚠ <?php echo htmlspecialchars($_SESSION['error']); ?></small>
                        </div>
                    <?php unset($_SESSION['error']); endif; ?>

                    <form action="index.php?accion=guardar_mensaje" method="POST">

                        <div class="mb-3">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej. Juan Pérez" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" name="correo" class="form-control" placeholder="nombre@correo.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Asunto</label>
                            <input type="text" name="asunto" class="form-control" placeholder="¿Cuál es el motivo de tu mensaje?" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Mensaje o Comentario</label>
                            <textarea name="mensaje" class="form-control" rows="4" placeholder="Escribe detalladamente tu solicitud aquí..." required></textarea>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="index.php" class="btn btn-secondary btn-custom shadow-sm">Volver</a>
                            <button type="submit" class="btn btn-primary btn-custom shadow-sm">Enviar mensaje</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>