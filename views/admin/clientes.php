<?php require __DIR__ . '/layout/header.php'; ?>

<div class="container my-5">

    <h1 class="mb-4 admin-title">Gestión de Clientes</h1>

    <p class="text-muted">
        En esta sección se muestran los usuarios registrados como clientes y su historial básico de compras.
    </p>

    <div class="table-responsive">

        <table class="table table-bordered table-striped bg-white text-center align-middle shadow-sm">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Fecha Registro</th>
                    <th>Total Pedidos</th>
                    <th>Total Compras</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($clientes as $cliente): ?>

                <tr>
                    <td><?php echo $cliente['id']; ?></td>

                    <td>
                        <strong><?php echo htmlspecialchars($cliente['nombre']); ?></strong>
                    </td>

                    <td><?php echo htmlspecialchars($cliente['email']); ?></td>

                    <td>
                        <?php if (($cliente['estado'] ?? 'activo') === 'activo'): ?>
                            <span class="badge bg-success">Activo</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Inactivo</span>
                        <?php endif; ?>
                    </td>

                    <td><?php echo $cliente['fecha_creacion'] ?? 'No registrada'; ?></td>

                    <td>
                        <span class="badge bg-primary">
                            <?php echo $cliente['total_pedidos'] ?? 0; ?>
                        </span>
                    </td>

                    <td>
                        <strong>$<?php echo number_format($cliente['total_compras'] ?? 0, 2); ?></strong>
                    </td>
                </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>