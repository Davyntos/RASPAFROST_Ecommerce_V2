<?php
require __DIR__ . '/layout/header.php';

$esEdicion = isset($producto) && is_array($producto);
?>

<div class="container my-5">

    <div class="card shadow">
        <div class="card-body">

            <h1 class="mb-4 admin-title">
                <?php echo $esEdicion ? 'Editar producto' : 'Crear producto'; ?>
            </h1>

            <form method="POST"
                  enctype="multipart/form-data"
                  action="<?php echo $esEdicion ? 'index.php?accion=admin_actualizar_producto' : 'index.php?accion=admin_guardar_producto'; ?>">

                <?php if ($esEdicion): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id']); ?>">
                    <input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($producto['imagen'] ?? ''); ?>">
                <?php endif; ?>

                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control mb-3" required
                       value="<?php echo $esEdicion ? htmlspecialchars($producto['nombre'] ?? '') : ''; ?>">

                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control mb-3"><?php echo $esEdicion ? htmlspecialchars($producto['descripcion'] ?? '') : ''; ?></textarea>

                <label class="form-label">Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control mb-3" required
                       value="<?php echo $esEdicion ? htmlspecialchars($producto['precio'] ?? '') : ''; ?>">

                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control mb-3" required
                       value="<?php echo $esEdicion ? htmlspecialchars($producto['stock'] ?? 0) : 0; ?>">

                <label class="form-label">Imagen del producto</label>
                <input type="file" name="imagen_archivo" class="form-control mb-3" accept=".jpg,.jpeg,.png,.webp">

                <?php if ($esEdicion && !empty($producto['imagen'])): ?>
                    <div class="mb-3 text-center">
                        <p class="text-muted">Imagen actual:</p>
                        <img src="/ECOMMERCE/<?php echo htmlspecialchars($producto['imagen']); ?>"
                             style="width:150px;height:150px;object-fit:contain;">
                    </div>
                <?php endif; ?>

                <label class="form-label">Categoría</label>
                <input type="text" name="categoria" class="form-control mb-3"
                       value="<?php echo $esEdicion ? htmlspecialchars($producto['categoria'] ?? '') : ''; ?>">

                <label class="form-label">Estado</label>
                <select name="estado" class="form-select mb-4">
                    <option value="activo" <?php echo ($esEdicion && ($producto['estado'] ?? '') === 'activo') ? 'selected' : ''; ?>>
                        Activo
                    </option>
                    <option value="inactivo" <?php echo ($esEdicion && ($producto['estado'] ?? '') === 'inactivo') ? 'selected' : ''; ?>>
                        Inactivo
                    </option>
                </select>

                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="index.php?accion=admin_productos" class="btn btn-secondary">Cancelar</a>

            </form>

        </div>
    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>