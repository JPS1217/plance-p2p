<?php
session_start();

// Sin base de datos: no hay transacciones aprobadas que reversar (estado vacío).
$transacciones = [];

// Mensaje
$msg      = $_SESSION['reverso_msg']      ?? '';
$msg_type = $_SESSION['reverso_msg_type'] ?? '';
unset($_SESSION['reverso_msg'], $_SESSION['reverso_msg_type']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reversos — Transacciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <?php require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../../assets/css/styles-historiales.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>
<style>
    /* Reversos — acento rojo */
    :root {
        --hist-accent:     #e05252;
        --hist-accent-rgb: 224, 82, 82;
    }
</style>
<body>
    <?php
    $nav_back_url  = "historial.php";
    $nav_back_text = "Atras";
    $nav_base      = "../../";
    require_once '../../php/navbar.php';
    ?>

    <div class="tabla-container">
        <div class="tabla-titulo" id="rev-titulo">
            <i class="bi bi-arrow-counterclockwise"></i> Transacciones para Reverso
        </div>

        <?php if ($msg): ?>
        <div class="alert-<?= $msg_type === 'success' ? 'success' : 'error' ?>-custom">
            <?= htmlspecialchars($msg) ?>
        </div>
        <?php endif; ?>

        <?php if (count($transacciones) > 0): ?>
        <div class="table-responsive" id="rev-tabla">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th id="rev-th-tipo">Tipo</th>
                        <th>Producto / Servicio</th>
                        <th>Usuario</th>
                        <th>Precio</th>
                        <th id="rev-th-estado">Estado</th>
                        <th>Fecha</th>
                        <th id="rev-th-accion">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transacciones as $trx): ?>
                    <tr>
                        <td><span style="color:#8a8d96;">#<?= htmlspecialchars($trx['id']) ?></span></td>
                        <td>
                            <span class="tipo-badge tipo-<?= $trx['tipo'] ?>">
                                <?= $trx['tipo'] === 'orden' ? '<i class="bi bi-controller"></i> Juego' : ($trx['tipo'] === 'suscripcion' ? '<i class="bi bi-tv"></i> Suscripción' : '🔄 Recurrencia') ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($trx['nombre']) ?></td>
                        <td><code style="color:#8a8d96;"><?= htmlspecialchars($trx['usuario']) ?></code></td>
                        <td style="color:#3ecf8e; font-weight:700;">$<?= number_format($trx['precio'], 0, ',', '.') ?> COP</td>
                        <td>
                            <span class="estado-pill badge-<?= strtolower($trx['estado']) ?>">
                                <?= strtoupper($trx['estado']) ?>
                            </span>
                        </td>
                        <td style="color:#8a8d96; font-size:0.8rem;"><?= htmlspecialchars($trx['created_at']) ?></td>
                        <td>
                            <a href="detalle_reverso.php?id=<?= $trx['id'] ?>&tipo=<?= $trx['tipo'] ?>" class="btn-detalle">
                                <i class="bi bi-eye-fill"></i> Ver detalle
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="sin-registros">
                <i class="bi bi-arrow-counterclockwise" style="font-size:2rem; display:block; margin-bottom:0.5rem;"></i>
                No tienes transacciones aprobadas disponibles para reverso.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="paginacion.css">
    <style>:root{--pag-accent:#e05252;}</style>
    <script src="paginacion.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="../../assets/js/components/driver-tours/tour-reversos.js"></script>
</body>
</html>
