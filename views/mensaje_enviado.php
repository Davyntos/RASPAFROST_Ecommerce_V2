<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensaje Enviado - RASPAFROST</title>
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
        .card-confirmacion {
            border: 1px solid rgba(15, 23, 42, 0.06) !important;
            border-radius: 24px !important;
            background: var(--blanco-hielo) !important;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04) !important;
        }

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

        .icono-exito {
            font-size: 3rem;
            color: #166534;
            background: #f0fdf4;
            width: 80px;
            height: 80px;
            line-height: 76px;
            border-radius: 50%;
            margin: 0 auto;
            border: 1px solid #bbf7d0;
            box-shadow: 0 4px 12px rgba(22, 101, 52, 0.08);
            animation: scaleUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Pequeña animación para hacer la interfaz más interactiva */
        @keyframes scaleUp {
            0% { transform: scale(0.6); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
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
        <div class="col-md-7 col-lg-6">
            
            <div class="card card-confirmacion shadow-sm text-center bg-white border-0">
                <div class="card-body p-5">
                    
                    <img src="assets/LOGO.png" class="img-fluid mb-4" style="max-width: 110px;" alt="Logo Raspafrost">
                    
                    <div class="mb-4">
                        <div class="icono-exito">✓</div>
                    </div>

                    <h2 class="text-dark fw-bold mb-2">¡Mensaje enviado con éxito!</h2>
                    <p class="text-secondary mb-4 fs-6 px-3">
                        Gracias por ponerte en contacto con nosotros. Tu solicitud ha sido registrada correctamente y nuestro equipo te responderá a la brevedad en tu bandeja de soporte.
                    </p>

                    <hr class="text-muted opacity-25 mb-4">

                    <div class="d-grid d-sm-flex gap-2 justify-content-sm-center">
                        <a href="index.php" class="btn btn-secondary btn-custom shadow-sm">
                            ← Volver al catálogo
                        </a>
                        <a href="index.php?accion=mis_mensajes" class="btn btn-primary btn-custom shadow-sm">
                            ✉️ Ir a mis mensajes
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>