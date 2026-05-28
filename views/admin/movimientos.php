<?php require __DIR__ . '/layout/header.php'; ?>

<div class="container my-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="admin-title">Historial de movimientos</h1>

        <a href="index.php?accion=admin_inventario" class="btn btn-secondary">
            Volver al inventario
        </a>

    </div>

    <div class="table-responsive">

        <table class="table table-bordered table-striped bg-white text-center align-middle shadow-sm">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Motivo</th>
                    <th>Fecha</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($movimientos as $movimiento): ?>

                <tr>
                    <td><?php echo $movimiento['id']; ?></td>

                    <td>
                        <?php 
                            // 1. Verificamos si existe y no está vacía la clave 'imagen'
                            if (!empty($movimiento['imagen'])) {
                                $srcFinal = "/ecommerce/" . htmlspecialchars($movimiento['imagen']);
                            } else {
                                // 2. Si no viene en el JOIN, la deducimos con el ID del producto o del movimiento
                                $idReferencia = $movimiento['id_producto'] ?? $movimiento['producto_id'] ?? $movimiento['id'] ?? 1;
                                $srcFinal = "/ecommerce/assets/raspado" . $idReferencia . ".jpeg";
                            }
                        ?>
                        <img src="<?php echo $srcFinal; ?>" width="65" height="65" style="border-radius: 12px; object-fit: cover; border: 1px solid #e2e8f0; background-color: #f8fafc;" alt="Producto">
                    </td>

                    <td>
                        <strong>
                            <?php 
                                // Protección contra 'Undefined array key "producto"'
                                echo htmlspecialchars($movimiento['producto'] ?? $movimiento['nombre'] ?? $movimiento['nombre_producto'] ?? 'Producto'); 
                            ?>
                        </strong>
                    </td>

                    <td>
                        <?php 
                            // Normalizamos a minúsculas por si acaso
                            $tipoMov = strtolower($movimiento['tipo_movimiento'] ?? $movimiento['tipo'] ?? 'entrada');
                            if ($tipoMov === 'entrada'): 
                        ?>
                            <span class="badge bg-success">Entrada</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Salida</span>
                        <?php endif; ?>
                    </td>

                    <td><strong><?php echo $movimiento['cantidad']; ?></strong></td>

                    <td><?php echo htmlspecialchars($movimiento['motivo'] ?? 'Sin motivo registrado'); ?></td>

                    <td><?php echo $movimiento['fecha']; ?></td>
                </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>