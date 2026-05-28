<?php require __DIR__ . '/layout/header.php'; ?>

<div class="container my-5">

    <h1 class="mb-4 admin-title">Reportes Básicos</h1>

    <div class="row g-4 mb-5">

        <div class="col-md-6">
            <div class="card shadow text-center border-success">
                <div class="card-body">
                    <h5>Ventas Totales</h5>
                    <h2>$<?php echo number_format($ventasTotales ?? 0, 2); ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow text-center border-info">
                <div class="card-body">
                    <h5>Pedidos Realizados</h5>
                    <h2><?php echo $pedidosRealizados ?? 0; ?></h2>
                </div>
            </div>
        </div>

    </div>

    <h3>Productos más vendidos</h3>

    <div class="table-responsive mb-5">

        <table class="table table-bordered bg-white text-center align-middle shadow-sm">

            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad Vendida</th>
                    <th>Total Generado</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach (($productosVendidos ?? []) as $producto): ?>

                <tr>
                    <td><strong><?php echo htmlspecialchars($producto['nombre_producto'] ?? 'Desconocido'); ?></strong></td>

                    <td>
                        <span class="badge bg-primary">
                            <?php echo $producto['total_vendido'] ?? 0; ?> uds
                        </span>
                    </td>

                    <td>
                        <span class="text-success fw-bold">
                            $<?php echo number_format($producto['total_generado'] ?? 0, 2); ?>
                        </span>
                    </td>
                </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <h3>Clientes frecuentes</h3>

    <div class="table-responsive">

        <table class="table table-bordered bg-white text-center align-middle shadow-sm">

            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Pedidos</th>
                    <th>Total Comprado</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach (($clientesFrecuentes ?? []) as $cliente): ?>

                <tr>
                    <td><strong><?php echo htmlspecialchars($cliente['nombre'] ?? 'Cliente anónimo'); ?></strong></td>

                    <td><?php echo htmlspecialchars($cliente['email'] ?? 'Sin correo registrado'); ?></td>

                    <td>
                        <span class="badge bg-info text-dark">
                            <?php echo $cliente['total_pedidos'] ?? 0; ?>
                        </span>
                    </td>

                    <td>
                        <span class="text-success fw-bold">
                            $<?php echo number_format($cliente['total_compras'] ?? $cliente['total_gastado'] ?? 0, 2); ?>
                        </span>
                    </td>
                </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>