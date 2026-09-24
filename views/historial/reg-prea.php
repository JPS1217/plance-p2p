<?php
session_start();

// Sin base de datos: historial vacío (estado "sin registros").
$resultado = [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial — Preautorizaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?php require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/styles-historiales.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>
<style>
    /* Historial de Preautorizaciones — acento índigo */
    :root {
        --hist-accent:     #6366f1;
        --hist-accent-rgb: 99, 102, 241;
    }
</style>
<body>
    <?php
        $nav_back_url  = "historial.php";
        $nav_back_text = "Atrás";
        $nav_base      = "../../";
        require_once '../../php/navbar.php';
    ?>

    <div class="tabla-container">
        <div class="tabla-titulo" id="prea-titulo">
            <i class="bi bi-shield-lock-fill" style="color:#6366f1;"></i>
            Historial de Preautorizaciones
        </div>

        <div class="info-banner" id="prea-info">
            <i class="bi bi-info-circle-fill"></i>
            Las <strong>preautorizaciones</strong> reservan el monto en tu tarjeta sin cobrarlo. El cargo real se realiza al hacer check-out en el hotel. Si ves estado <strong>Pendiente</strong>, puedes verificar el estado actual con el botón correspondiente.
        </div>

        <?php if (!empty($_SESSION['verify_msg'])): ?>
        <div class="alert-verify"><?= htmlspecialchars($_SESSION['verify_msg']) ?></div>
        <?php unset($_SESSION['verify_msg']); endif; ?>

        <?php if (count($resultado) > 0): ?>
        <div class="table-responsive" id="prea-tabla">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Habitación</th>
                        <th>Descripción</th>
                        <th>Monto</th>
                        <th>Tipo</th>
                        <th id="prea-th-estado">Estado</th>
                        <th>Fecha</th>
                        <th id="prea-th-accion">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($resultado ?? []) as $row): ?>
                    <tr>
                        <td><span style="color:#8a8d96;">#<?= htmlspecialchars($row['id']) ?></span></td>
                        <td style="font-weight:600;">🏨 <?= htmlspecialchars($row['habitacion']) ?></td>
                        <td style="font-size:0.82rem;color:#8a8d96;max-width:200px;"><?= htmlspecialchars($row['descripcion']) ?></td>
                        <td style="color:#6366f1;font-weight:700;">
                            $<?= number_format($row['precio'], 0, ',', '.') ?>
                            <span style="font-size:0.72rem;color:#8a8d96;"><?= htmlspecialchars($row['moneda']) ?></span>
                        </td>
                        <td><span class="preauth-pill"><i class="bi bi-shield-lock-fill"></i> Check-in</span></td>
                        <td>
                            <span class="estado-pill badge-<?= strtolower($row['estado']) ?>">
                                <?= strtoupper($row['estado']) ?>
                            </span>
                        </td>
                        <td style="color:#8a8d96;font-size:0.8rem;"><?= htmlspecialchars($row['created_at']) ?></td>
                        <td>
                            <?php if (strtolower($row['estado']) === 'pendiente' && !empty($row['session_id'])): ?>
                            <a href="../../php/verificar_pago.php?tabla=reservaciones&id=<?= $row['id'] ?>&request_id=<?= urlencode($row['session_id']) ?>&redirect=../views/historial/reg-prea.php"
                               class="btn-verificar">
                                <i class="bi bi-arrow-repeat"></i> Verificar
                            </a>
                            <?php else: ?>
                            <span style="color:#555860;font-size:0.75rem;">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="sin-registros">
                <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:0.5rem;"></i>
                No tienes reservaciones registradas aún.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="../../assets/js/components/driver-tours/tour-reg-prea.js"></script>
</body>
</html>
