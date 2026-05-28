<?php require __DIR__ . '/layout/header.php'; ?>

<div class="container my-5">

    <h1 class="mb-4 admin-title">Gestión de Pedidos</h1>

    <div class="table-responsive">

        <table class="table table-bordered table-striped bg-white text-center align-middle shadow-sm">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Método Pago</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Cambiar Estado</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($pedidos as $pedido): ?>

                <tr>
                    <td><?php echo $pedido['id']; ?></td>

                    <td><?php echo htmlspecialchars($pedido['cliente']); ?></td>

                    <td><?php echo htmlspecialchars($pedido['email']); ?></td>

                    <td>$<?php echo number_format($pedido['total'], 2); ?></td>

                    <td><?php echo htmlspecialchars($pedido['metodo_pago']); ?></td>

                    <td>
                        <?php if ($pedido['estado'] === 'pagado'): ?>
                            <span class="badge bg-success">Pagado</span>
                        <?php elseif ($pedido['estado'] === 'cancelado'): ?>
                            <span class="badge bg-danger">Cancelado</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        <?php endif; ?>
                    </td>

                    <td><?php echo $pedido['fecha_creacion']; ?></td>

                    <td>
                        <form method="POST" action="index.php?accion=admin_cambiar_estado_pedido&id=<?php echo $pedido['id']; ?>">
                            <select name="estado" class="form-select form-select-sm mb-2">
                                <option value="pendiente" <?php echo $pedido['estado'] === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="pagado" <?php echo $pedido['estado'] === 'pagado' ? 'selected' : ''; ?>>Pagado</option>
                                <option value="cancelado" <?php echo $pedido['estado'] === 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                            </select>

                            <button class="btn btn-primary btn-sm">Actualizar</button>
                        </form>
                    </td>
                </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>