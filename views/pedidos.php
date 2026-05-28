<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Mis pedidos</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background-color:#f8f9fa;
}

.producto-img{
    width:90px;
    height:90px;
    object-fit:contain;
}

.estado{
    font-size:14px;
    padding:6px 12px;
    border-radius:20px;
}

</style>

</head>

<body>

<!-- HEADER -->
<header class="bg-white text-black py-3 shadow-sm">

    <div class="container d-flex justify-content-between align-items-center">

        <div style="width:120px;height:65px;display:flex;align-items:center;justify-content:center;">
            <img src="/ECOMMERCE/img/logotecnm.png"
                 style="max-width:100%;max-height:100%;">
        </div>

        <h4 class="m-0 text-center">
            <b>Tecnológico Nacional de México - Campus Pachuca</b>
        </h4>

        <div style="width:120px;height:65px;display:flex;align-items:center;justify-content:center;">
            <img src="/ECOMMERCE/img/logoitp.png"
                 style="max-width:100%;max-height:100%;">
        </div>

    </div>

</header>

<div class="container my-5">

    <!-- TITULO -->
    <h1 class="text-center mb-5 fw-bold">
        📦 Mis pedidos
    </h1>

    <!-- BOTON -->
    <div class="mb-4">
        <a href="/ECOMMERCE/index.php"
           class="btn btn-secondary">
            ← Volver al catálogo
        </a>
    </div>

    <?php if(empty($pedidos)): ?>

        <div class="alert alert-info text-center shadow-sm">

            <h4>No hay pedidos realizados 🛒</h4>

            <p class="mb-0">
                Cuando realices una compra aparecerá aquí.
            </p>

        </div>

    <?php else: ?>

    <div class="table-responsive">

        <table class="table table-bordered align-middle text-center bg-white shadow-sm">

            <thead class="table-dark">

                <tr>
                    <th>ID Pedido</th>
                    <th>Producto</th>
                    <th>Imagen</th>
                    <th>Cantidad</th>
                    <th>Método de pago</th>
                    <th>Total pagado</th>
                    <th>Estado envío</th>
                </tr>

            </thead>

            <tbody>

            <?php foreach($pedidos as $pedido): ?>

                <tr>

                    <!-- ID -->
                    <td>
                        <?php echo $pedido['pedido_id']; ?>
                    </td>

                    <!-- PRODUCTO -->
                    <td>
                        <?php echo htmlspecialchars($pedido['nombre_producto']); ?>
                    </td>

                    <!-- IMAGEN -->
                    <td>

                        <img
                            src="/ECOMMERCE/<?php echo htmlspecialchars($pedido['imagen']); ?>"
                            class="producto-img"
                        >

                    </td>

                    <!-- CANTIDAD -->
                    <td>
                        <?php echo $pedido['cantidad']; ?>
                    </td>

                    <!-- METODO -->
                    <td>
                        <?php echo htmlspecialchars($pedido['metodo_pago']); ?>
                    </td>

                    <!-- TOTAL -->
                    <td>
                        $<?php echo number_format($pedido['total'],2); ?>
                    </td>

                    <!-- ESTADO -->
                    <td>

                        <span class="badge bg-warning text-dark estado">
                            Pendiente
                        </span>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <?php endif; ?>

</div>

</body>
</html>