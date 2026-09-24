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
    <title>Historial — Membresías Recurrentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <?php $theme_seccion = 'historial'; require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../../assets/css/styles-historiales.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>
<style>
    /* Historial de Membresías Recurrentes — acento azul */
    :root {
        --hist-accent:     #4d9fff;
        --hist-accent-rgb: 77, 159, 255;
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
        <div class="tabla-titulo" id="rec-titulo">
            <i class="bi bi-calendar-check-fill" style="color: #4d9fff;"></i>Historial de Membresías Recurrentes
        </div>

        <?php
        if (!empty($_SESSION['verify_msg'])) {
            echo '<div class="alert-verify">' . htmlspecialchars($_SESSION['verify_msg']) . '</div>';
            unset($_SESSION['verify_msg']);
        }
        if (!empty($_SESSION['cancel_msg'])) {
            echo '<div class="alert-cancel">' . htmlspecialchars($_SESSION['cancel_msg']) . '</div>';
            unset($_SESSION['cancel_msg']);
        }
        ?>

        <?php if (count($resultado) > 0): ?>
        <div class="table-responsive" id="rec-tabla">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Servicio</th>
                        <th>Plan</th>
                        <th>Correo</th>
                        <th>Precio / mes</th>
                        <th>Próximo cobro</th>
                        <th>Fin recurrencia</th>
                        <th>Periodicidad</th>
                        <th id="rec-th-estado">Estado</th>
                        <th>Fecha</th>
                        <th id="rec-th-accion">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($resultado ?? []) as $row): ?>
                    <tr>
                        <td><span style="color:#8a8d96;">#<?= htmlspecialchars($row['id']) ?></span></td>
                        <td><?= htmlspecialchars($row['servicio']) ?></td>
                        <td><?= htmlspecialchars($row['plan']) ?></td>
                        <td><code style="color:#4d9fff;"><?= htmlspecialchars($row['usuario_id']) ?></code></td>
                        <td style="color:#4d9fff; font-weight:700;">
                            $<?= number_format($row['precio'], 0, ',', '.') ?> COP
                        </td>
                        <td style="color:#f0f1f3;">
                            <?= !empty($row['next_payment']) ? htmlspecialchars($row['next_payment']) : '—' ?>
                        </td>
                        <td style="color:#f0b429;">
                            <?= !empty($row['fecha_fin']) ? htmlspecialchars($row['fecha_fin']) : '—' ?>
                        </td>
                        <td>
                            <span class="recurrente-badge">
                                <i class="bi bi-arrow-repeat"></i>
                                <?= $row['periodicidad'] === 'M' ? 'Mensual' : htmlspecialchars($row['periodicidad']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="estado-pill badge-<?= strtolower($row['estado']) ?>">
                                <?= strtoupper($row['estado']) ?>
                            </span>
                        </td>
                        <td style="color:#8a8d96; font-size:0.8rem;">
                            <?= htmlspecialchars($row['created_at']) ?>
                        </td>
                        <td style="display:flex; flex-direction:column; gap:0.3rem;">
                            <?php if (strtolower($row['estado']) === 'pendiente' && !empty($row['request_id'])): ?>
                            <a href="../../php/verificar_pago.php?tabla=recurrencias&id=<?= $row['id'] ?>&request_id=<?= urlencode($row['request_id']) ?>&redirect=../views/historial/reg-rec.php"
                               class="btn-verificar">
                                <i class="bi bi-arrow-repeat"></i> Verificar
                            </a>
                            <?php elseif (strtolower($row['estado']) === 'aprobada'): ?>
                            <a href="../../php/cancelar_rec.php?id=<?= $row['id'] ?>"
                               class="btn-cancelar"
                               onclick="return confirm('⚠️ ¿Estás seguro de cancelar esta membresía? Esta acción no se puede deshacer.')">
                                <i class="bi bi-x-circle-fill"></i> Cancelar
                            </a>
                            <?php else: ?>
                            <span style="color:#555860; font-size:0.75rem;">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="sin-registros">
                <i class="bi bi-arrow-repeat" style="font-size:2rem; display:block; margin-bottom:0.5rem;"></i>
                No tienes membresías recurrentes registradas aún.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="paginacion.css">
    <style>:root{--pag-accent:#4d9fff;}</style>
    <script src="paginacion.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="../../assets/js/components/driver-tours/tour-reg-rec.js"></script>
</body>
</html>
