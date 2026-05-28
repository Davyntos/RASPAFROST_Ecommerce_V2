<?php require __DIR__ . '/layout/header.php'; ?>

<div class="container my-5">

    <h1 class="mb-4 admin-title">Pagos Simulados</h1>

    <div class="alert alert-info shadow-sm">
        Los pagos rechazados no se guardan en la base de datos porque no generan pedido.
        Aquí se muestran pagos asociados a pedidos generados.
    </div>

    <div class="table-responsive">

        <table class="table table-bordered table-striped bg-white text-center align-middle shadow-sm">

            <thead class="table-dark">
                <tr>
                    <th>ID Pago/Pedido</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Método Pago</th>
                    <th>Total</th>
                    <th>Estado Pago</th>
                    <th>Fecha</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($pagos as $pago): ?>

                <tr>
                    <td><strong>#<?php echo $pago['id']; ?></strong></td>

                    <td><?php echo htmlspecialchars($pago['cliente'] ?? 'Cliente Desconocido'); ?></td>

                    <td><?php echo htmlspecialchars($pago['email'] ?? 'N/A'); ?></td>

                    <td>
                        <span class="badge bg-light text-dark border">
                            <?php echo htmlspecialchars($pago['metodo_pago']); ?>
                        </span>
                    </td>

                    <td><span class="text-success fw-bold">$<?php echo number_format($pago['total'], 2); ?></span></td>

                    <td>
                        <?php if (strtolower($pago['estado'] ?? '') === 'cancelado'): ?>
                            <span class="badge bg-danger">Rechazado / Cancelado</span>
                        <?php else: ?>
                            <span class="badge bg-success">Aprobado</span>
                        <?php endif; ?>
                    </td>

                    <td><?php echo $pago['fecha_creacion'] ?? 'Fecha no disponible'; ?></td>
                </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>