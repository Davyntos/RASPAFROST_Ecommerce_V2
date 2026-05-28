<?php require __DIR__ . '/layout/header.php'; ?>

<div class="container my-5">

    <h1 class="mb-4 admin-title">Dashboard</h1>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card shadow text-center border-primary">
                <div class="card-body">
                    <h5>Productos activos</h5>
                    <h2><?php echo $productosActivos; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow text-center border-info">
                <div class="card-body">
                    <h5>Pedidos realizados</h5>
                    <h2><?php echo $pedidosRealizados; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow text-center border-success">
                <div class="card-body">
                    <h5>Ventas totales</h5>
                    <h2>$<?php echo number_format($ventasTotales, 2); ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow text-center border-secondary">
                <div class="card-body">
                    <h5>Clientes registrados</h5>
                    <h2><?php echo $clientesRegistrados; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow text-center border-warning">
                <div class="card-body">
                    <h5>Stock bajo</h5>
                    <h2><?php echo $stockBajo; ?></h2>
                </div>
            </div>
        </div>

    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>