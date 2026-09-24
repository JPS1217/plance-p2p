<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['gw_subs_pending'] = $_POST;
}

if (empty($_SESSION['gw_subs_pending'])) {
    header("Location: ../index.php");
    exit();
}

$data       = $_SESSION['gw_subs_pending'];
$servicio   = $data['servicio'] ?? 'Servicio';
$plan       = $data['plan']     ?? '';
$precio     = $data['precio']   ?? 0;
$destino    = $data['destino']  ?? 'suscripcion';
$es_recurrencia = ($destino === 'recurrencia'); // IA's = recurrencia, Streamings = suscripcion pura
$form_action = $es_recurrencia ? 'crear_recurrencia_gateway' : 'crear_suscription_gateway';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de suscripción | Plance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
    <?php require_once dirname(__DIR__) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../assets/css/styles-retorno-estados.css">
</head>
<body>
    <div class="main-card">

        <div class="demo-banner">
            <strong>⚡ Simulación API Gateway — Suscripción</strong>
            Elige el estado que deseas simular para esta transacción
        </div>

        <div class="card-title-main">¡Transacción de prueba!</div>
        <div class="card-subtitle">
            Selecciona el resultado que quieres ver.<br>
            En producción real, PlacetoPay determina este estado automáticamente.
        </div>

        <div class="product-info">
            <span class="product-info-name">
                <?= $es_recurrencia ? '🤖' : '📺' ?>
                <?= htmlspecialchars($servicio) ?> — <?= htmlspecialchars($plan) ?>
            </span>
            <span class="product-info-price">$<?= number_format((float)$precio, 0, ',', '.') ?> COP</span>
        </div>

        <span class="estado-label">Estado de la transacción</span>
        <div class="estados-grid">
            <div class="estado-btn aprobada-token selected" onclick="selectEstado('aprobada-token', this)">
                <span class="check">✔</span>
                <div class="estado-icon">🔐</div>
                <div class="estado-name">Aprobada + Token</div>
                <div class="estado-desc">Pago exitoso y tarjeta guardada</div>
            </div>
            <div class="estado-btn aprobada-sin" onclick="selectEstado('aprobada-sin', this)">
                <span class="check">✔</span>
                <div class="estado-icon">✅</div>
                <div class="estado-name">Aprobada</div>
                <div class="estado-desc">Pago exitoso sin tokenizar</div>
            </div>
            <div class="estado-btn pendiente" onclick="selectEstado('pendiente', this)">
                <span class="check">✔</span>
                <div class="estado-icon">⏳</div>
                <div class="estado-name">Pendiente</div>
                <div class="estado-desc">En proceso de verificación</div>
            </div>
            <div class="estado-btn rechazada" onclick="selectEstado('rechazada', this)">
                <span class="check">✔</span>
                <div class="estado-icon">❌</div>
                <div class="estado-name">Rechazada</div>
                <div class="estado-desc">No se pudo procesar</div>
            </div>
            <div class="estado-btn pend-aprobada" onclick="selectEstado('pend-aprobada', this)">
                <span class="check">✔</span>
                <div class="estado-icon">⏳✅</div>
                <div class="estado-name">Pendiente → Aprobada</div>
                <div class="estado-desc">Queda pendiente ~90s y luego se aprueba sola</div>
            </div>
            <div class="estado-btn pend-rechazada" onclick="selectEstado('pend-rechazada', this)">
                <span class="check">✔</span>
                <div class="estado-icon">⏳❌</div>
                <div class="estado-name">Pendiente → Rechazada</div>
                <div class="estado-desc">Queda pendiente ~90s y luego se rechaza sola</div>
            </div>
            <div class="estado-btn pend-180min" onclick="selectEstado('pend-180min', this)">
                <span class="check">✔</span>
                <div class="estado-icon">🐢</div>
                <div class="estado-name">180 min → Aprobada</div>
                <div class="estado-desc">Simula una respuesta muy demorada del emisor</div>
            </div>
        </div>

        <div class="razon-wrap">
            <span class="estado-label">Razón</span>
            <select class="razon-select" id="razonSelect">
                <option value="APPROVED_TRANSACTION">APPROVED_TRANSACTION (00) — Con token</option>
            </select>
        </div>

        <form method="POST" action="../php/<?= $form_action ?>.php" id="estadoForm">
            <input type="hidden" name="estado_elegido"   id="estadoElegido"   value="aprobada-token">
            <input type="hidden" name="razon_elegida"    id="razonElegida"    value="APPROVED_TRANSACTION">
            <?php foreach ($data as $key => $value): ?>
            <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
            <?php endforeach; ?>
        </form>

        <button class="btn-procesar" id="btnProcesar" onclick="procesar()">
            <i class="bi bi-play-circle-fill"></i> Procesar transacción
        </button>
        <a href="javascript:history.back()" class="cancel-link">← Cancelar y volver</a>
    </div>

    <script>
    const razones = {
        'aprobada-token': [{ v:'APPROVED_TRANSACTION', l:'APPROVED_TRANSACTION (00) — Con token' }],
        'aprobada-sin':   [{ v:'APPROVED_TRANSACTION', l:'APPROVED_TRANSACTION (00) — Sin token' }],
        'pendiente':      [{ v:'PENDING_TRANSACTION', l:'PENDING_TRANSACTION (?-)' }, { v:'PENDING_VALIDATION', l:'PENDING_VALIDATION (?V)' }],
        'rechazada':      [{ v:'CANCELLED_TRANSACTION', l:'CANCELLED_TRANSACTION (?C)' }, { v:'FAILED_TRANSACTION', l:'FAILED_TRANSACTION (?F)' }, { v:'REJECTED_TRANSACTION', l:'REJECTED_TRANSACTION (?R)' }],
        'pend-aprobada':  [{ v:'PENDING_TRANSACTION', l:'PENDING_TRANSACTION (?-)' }, { v:'PENDING_VALIDATION', l:'PENDING_VALIDATION (?V)' }],
        'pend-rechazada': [{ v:'PENDING_TRANSACTION', l:'PENDING_TRANSACTION (?-)' }, { v:'PENDING_VALIDATION', l:'PENDING_VALIDATION (?V)' }],
        'pend-180min':    [{ v:'PENDING_TRANSACTION', l:'PENDING_TRANSACTION (?-)' }, { v:'PENDING_VALIDATION', l:'PENDING_VALIDATION (?V)' }]
    };

    function selectEstado(estado, el) {
        document.querySelectorAll('.estado-btn').forEach(b => b.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('estadoElegido').value = estado;

        const select = document.getElementById('razonSelect');
        select.innerHTML = '';
        razones[estado].forEach(function(r) {
            const opt = document.createElement('option');
            opt.value = r.v; opt.textContent = r.l;
            select.appendChild(opt);
        });
        actualizarRazon();
    }

    function actualizarRazon() {
        document.getElementById('razonElegida').value = document.getElementById('razonSelect').value;
    }

    document.getElementById('razonSelect').addEventListener('change', actualizarRazon);

    function procesar() {
        actualizarRazon();
        document.getElementById('btnProcesar').disabled = true;
        document.getElementById('btnProcesar').innerHTML = '<i class="bi bi-hourglass-split"></i> Procesando...';
        document.getElementById('estadoForm').submit();
    }

    selectEstado('aprobada-token', document.querySelector('.estado-btn.aprobada-token'));
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
