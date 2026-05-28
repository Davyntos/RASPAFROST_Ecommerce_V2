<?php require __DIR__ . '/layout/header.php'; ?>

<div class="container my-5">

    <div class="card shadow">
        <div class="card-body">

            <h1 class="admin-title mb-4">
                <?php echo ($tipoMovimiento === 'entrada') ? 'Entrada de mercancía' : 'Salida de mercancía'; ?>
            </h1>

            <form action="index.php?accion=admin_guardar_movimiento" method="POST">

                <input type="hidden" name="tipo_movimiento" value="<?php echo $tipoMovimiento; ?>">

                <div class="mb-3">
                    <label class="form-label">Producto</label>

                    <select name="producto_id" class="form-select" required>
                        <option value="">Seleccione un producto</option>

                        <?php foreach ($productos as $producto): ?>
                            <option value="<?php echo $producto['id']; ?>">
                                <?php echo htmlspecialchars($producto['nombre']); ?>
                                | Stock actual: <?php echo $producto['stock']; ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" min="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Motivo</label>
                    <input type="text" name="motivo" class="form-control"
                           placeholder="<?php echo ($tipoMovimiento === 'entrada') ? 'Compra a proveedor' : 'Venta, merma, ajuste, etc.'; ?>"
                           required>
                </div>

                <button class="btn btn-success">
                    Guardar movimiento
                </button>

                <a href="index.php?accion=admin_inventario" class="btn btn-secondary">
                    Cancelar
                </a>

            </form>

        </div>
    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>