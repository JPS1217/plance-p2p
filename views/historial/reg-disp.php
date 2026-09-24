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
    <title>Historial — Dispersiones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <?php require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../../assets/css/styles-historiales.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>
<style>
    /* Historial de Dispersiones — acento esmeralda */
    :root {
        --hist-accent:     #10b981;
        --hist-accent-rgb: 16, 185, 129;
        --hist-maxw:       1150px;
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
        <div class="tabla-titulo" id="disp-titulo">
            <i class="bi bi-diagram-3-fill" style="color:#10b981;"></i>
            Historial de Tiquetes — Dispersión de Pago
        </div>

        <div class="info-banner" id="disp-info">
            <i class="bi bi-info-circle-fill"></i>
            En los pagos con <strong>dispersión</strong>, el monto total se divide automáticamente entre la aerolínea y los impuestos aeroportuarios. Aquí puedes ver el desglose de cada tiquete.
        </div>

        <?php if (!empty($_SESSION['verify_msg'])): ?>
        <div class="alert-verify"><?= htmlspecialchars($_SESSION['verify_msg']) ?></div>
        <?php unset($_SESSION['verify_msg']); endif; ?>

        <?php if (count($resultado) > 0): ?>
        <div class="table-responsive" id="disp-tabla">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Destino</th>
                        <th>Tipo</th>
                        <th id="disp-th-desglose">Vuelo (aerolínea)</th>
                        <th>Impuestos</th>
                        <th>Total</th>
                        <th id="disp-th-estado">Estado</th>
                        <th>Fecha</th>
                        <th id="disp-th-accion">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($resultado ?? []) as $row): ?>
                    <tr>
                        <td><span style="color:#8a8d96;">#<?= htmlspecialchars($row['id']) ?></span></td>
                        <td style="font-weight:600;">✈️ <?= htmlspecialchars($row['destino']) ?></td>
                        <td><span class="disp-pill"><i class="bi bi-diagram-3-fill"></i> Dispersión</span></td>
                        <td class="desglose-cell">
                            <span class="desglose-vuelo">$<?= number_format($row['precio_base'], 0, ',', '.') ?> COP</span>
                        </td>
                        <td class="desglose-cell">
                            <span class="desglose-imp">$<?= number_format($row['impuesto'], 0, ',', '.') ?> COP</span>
                        </td>
                        <td style="color:#10b981;font-weight:700;font-size:0.95rem;">
                            $<?= number_format($row['precio_total'], 0, ',', '.') ?> COP
                        </td>
                        <td>
                            <span class="estado-pill badge-<?= strtolower($row['estado']) ?>">
                                <?= strtoupper($row['estado']) ?>
                            </span>
                        </td>
                        <td style="color:#8a8d96;font-size:0.8rem;"><?= htmlspecialchars($row['created_at']) ?></td>
                        <td>
                            <?php if (strtolower($row['estado']) === 'pendiente' && !empty($row['request_id'])): ?>
                            <a href="../../php/verificar_pago.php?tabla=dispersiones&id=<?= $row['id'] ?>&request_id=<?= urlencode($row['request_id']) ?>&redirect=../views/historial/reg-disp.php"
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
                <i class="bi bi-airplane" style="font-size:2rem;display:block;margin-bottom:0.5rem;"></i>
                No tienes tiquetes registrados aún.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="paginacion.css">
    <style>:root{--pag-accent:#10b981;}</style>
    <script src="paginacion.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="../../assets/js/components/driver-tours/tour-reg-disp.js"></script>
</body>
</html>
