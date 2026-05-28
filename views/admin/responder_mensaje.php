<?php require __DIR__ . '/layout/header.php'; ?>

<div class="container my-5">

    <h1 class="mb-4 admin-title">Responder mensaje</h1>

    <div class="card shadow mb-4">
        <div class="card-body">

            <p><strong>Cliente:</strong> <?php echo htmlspecialchars($mensaje['nombre']); ?></p>
            <p><strong>Correo:</strong> <?php echo htmlspecialchars($mensaje['correo']); ?></p>
            <p><strong>Asunto:</strong> <?php echo htmlspecialchars($mensaje['asunto']); ?></p>
            <p><strong>Mensaje:</strong></p>

            <div class="alert alert-secondary">
                <?php echo htmlspecialchars($mensaje['mensaje']); ?>
            </div>

        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <form action="index.php?accion=admin_guardar_respuesta" method="POST">

                <input type="hidden" name="id" value="<?php echo $mensaje['id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Respuesta</label>
                    <textarea name="respuesta" class="form-control" rows="5" required><?php echo htmlspecialchars($mensaje['respuesta'] ?? ''); ?></textarea>
                </div>

                <button type="submit" class="btn btn-success">Guardar respuesta</button>
                <a href="index.php?accion=admin_mensajes" class="btn btn-secondary">Cancelar</a>

            </form>

        </div>
    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>