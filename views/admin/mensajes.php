<?php require __DIR__ . '/layout/header.php'; ?>

<div class="container my-5">

    <h1 class="mb-4 admin-title">Mensajes de Atención a Clientes</h1>

    <div class="table-responsive">

        <table class="table table-bordered table-striped bg-white text-center align-middle shadow-sm">

            <thead class="table-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>Asunto</th>
                    <th>Mensaje</th>
                    <th>Estado</th>
                    <th>Respuesta</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($mensajes as $mensaje): ?>

                <tr>
                    <td><?php echo $mensaje['fecha']; ?></td>

                    <td><?php echo htmlspecialchars($mensaje['nombre']); ?></td>

                    <td><?php echo htmlspecialchars($mensaje['correo']); ?></td>

                    <td><?php echo htmlspecialchars($mensaje['asunto']); ?></td>

                    <td><?php echo htmlspecialchars($mensaje['mensaje']); ?></td>

                    <td>
                        <?php if ($mensaje['estado'] === 'respondido'): ?>
                            <span class="badge bg-success">Respondido</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Nuevo</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php echo !empty($mensaje['respuesta']) 
                            ? htmlspecialchars($mensaje['respuesta']) 
                            : 'Sin respuesta'; ?>
                    </td>

                    <td>
                        <a href="index.php?accion=admin_responder_mensaje&id=<?php echo $mensaje['id']; ?>"
                           class="btn btn-primary btn-sm">
                            Responder
                        </a>
                    </td>
                </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>