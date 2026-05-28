<?php require __DIR__ . '/layout/header.php'; ?>

<div class="container my-5">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

        <h1 class="admin-title">Inventario</h1>

        <div class="d-flex gap-2 flex-wrap">
            <a href="index.php?accion=admin_entrada_almacen" class="btn btn-success">
                + Entrada de mercancía
            </a>

            <a href="index.php?accion=admin_salida_almacen" class="btn btn-danger">
                - Salida de mercancía
            </a>

            <a href="index.php?accion=admin_movimientos" class="btn btn-primary">
                Historial de movimientos
            </a>
        </div>

    </div>

    <div class="alert alert-warning shadow-sm">
        <strong>Alerta:</strong> Los productos con stock actual menor o igual al stock mínimo aparecerán marcados como stock bajo.
    </div>

    <div class="table-responsive">

        <table class="table table-bordered table-striped bg-white text-center align-middle shadow-sm">

            <thead class="table-dark">
                <tr>
                    <th>ID Producto</th>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Stock Actual</th>
                    <th>Stock Mínimo</th>
                    <th>Estado Stock</th>
                    <th>Estado de Venta</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($inventario as $item): ?>

                <tr class="<?php echo ($item['stock'] <= $item['stock_minimo']) ? 'table-warning' : ''; ?>">

                    <td><?php echo $item['id']; ?></td>

                    <td>
                        <?php 
                            // Sistema inteligente de rescate de imágenes:
                            // Si la consulta no trae la columna 'imagen', la armamos usando el ID del producto
                            if (!empty($item['imagen'])) {
                                $srcFinal = "/ecommerce/" . htmlspecialchars($item['imagen']);
                            } else {
                                // Forzamos la ruta apuntando a la carpeta assets usando el ID (ej: raspado1.jpeg, raspado3.jpeg)
                                $srcFinal = "/ecommerce/assets/raspado" . $item['id'] . ".jpeg";
                            }
                        ?>
                        <img src="<?php echo $srcFinal; ?>" width="65" height="65" style="border-radius: 12px; object-fit: cover; border: 1px solid #e2e8f0; background-color: #f8fafc;" alt="Producto">
                    </td>

                    <td><strong><?php echo htmlspecialchars($item['nombre']); ?></strong></td>

                    <td><?php echo htmlspecialchars($item['categoria']); ?></td>

                    <td>
                        <strong><?php echo $item['stock']; ?></strong>
                    </td>

                    <td><?php echo $item['stock_minimo']; ?></td>

                    <td>
                        <?php if ($item['stock'] <= 0): ?>
                            <span class="badge bg-danger">Sin stock</span>
                        <?php elseif ($item['stock'] <= $item['stock_minimo']): ?>
                            <span class="badge bg-warning text-dark">Stock bajo</span>
                        <?php else: ?>
                            <span class="badge bg-success">Disponible</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <span class="badge <?php echo (isset($item['estado']) && $item['estado'] === 'activo') ? 'bg-info' : 'bg-secondary'; ?>">
                            <?php echo ucfirst($item['estado'] ?? 'Activo'); ?>
                        </span>
                    </td>

                </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>