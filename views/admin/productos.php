<?php require __DIR__ . '/layout/header.php'; ?>

<div class="container my-5">

    <div class="d-flex justify-content-between mb-4">
        <h1 class="admin-title">Gestión de Productos</h1>

        <a href="index.php?accion=admin_crear_producto" class="btn btn-success">
            Nuevo producto
        </a>
    </div>

    <div class="table-responsive">

        <table class="table table-bordered table-striped bg-white text-center align-middle shadow-sm">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($productos as $producto): ?>

                <tr>
                    <td><?php echo $producto['id']; ?></td>

                    <td>
                        <img src="/ECOMMERCE/<?php echo htmlspecialchars($producto['imagen']); ?>" width="70">
                    </td>

                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>

                    <td><?php echo htmlspecialchars($producto['categoria']); ?></td>

                    <td>$<?php echo number_format($producto['precio'], 2); ?></td>

                    <td><?php echo $producto['stock']; ?></td>

                    <td>
                        <?php if ($producto['estado'] === 'activo'): ?>
                            <span class="badge bg-success">Activo</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Inactivo</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="index.php?accion=admin_editar_producto&id=<?php echo $producto['id']; ?>" 
                           class="btn btn-primary btn-sm">
                            Editar
                        </a>

                        <?php if ($producto['estado'] === 'activo'): ?>
                            <a href="index.php?accion=admin_cambiar_estado&id=<?php echo $producto['id']; ?>&estado=inactivo" 
                               class="btn btn-warning btn-sm">
                                Inactivar
                            </a>
                        <?php else: ?>
                            <a href="index.php?accion=admin_cambiar_estado&id=<?php echo $producto['id']; ?>&estado=activo" 
                               class="btn btn-success btn-sm">
                                Activar
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>