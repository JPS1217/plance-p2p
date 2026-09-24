<?php
session_start();


$data = $_SESSION['link_result'] ?? null;
unset($_SESSION['link_result']);

if (!$data) {
    header("Location: ../index.php");
    exit();
}

$link_url   = $data['link_url']    ?? '';
$producto   = $data['producto']    ?? '';
$precio     = $data['precio']      ?? 0;
$correo     = $data['correo']      ?? '';
$nombre     = $data['nombre']      ?? '';
$referencia = $data['referencia']  ?? '';
$expiracion = $data['expiracion']  ?? '';
$link_id    = $data['link_id']     ?? '';
$exito      = !empty($link_url);

if ($exito) {
    $icono   = '🔗'; $titulo  = '¡Link generado!';
    $mensaje = 'Tu link de pago fue creado exitosamente. Compártelo por correo, WhatsApp o redes sociales.';
    $color   = '#3b82f6'; $bg_icon = 'rgba(59,130,246,0.15)'; $color_rgb = '59, 130, 246'; $ink = '#fff';
} else {
    $icono   = '❌'; $titulo  = 'Error al generar';
    $mensaje = 'No se pudo generar el link de pago. Intenta de nuevo.';
    $color   = '#e05252'; $bg_icon = 'rgba(224,82,82,0.15)'; $color_rgb = '224, 82, 82'; $ink = '#0d0e10';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link de Pago | Plance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <?php require_once dirname(__DIR__) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../assets/css/styles-retorno.css">
    <style>
        :root {
            --ret-color:     <?= $color ?>;
            --ret-bg-icon:   <?= $bg_icon ?>;
            --ret-color-rgb: <?= $color_rgb ?>;
            --ret-ink:       <?= $ink ?>;
            --ret-ctx-color: #93c5fd;
            --ret-ctx-rgb:   59, 130, 246;
        }
    </style>
</head>
<body>
    <div class="result-card">
        <div class="result-icon"><?= $icono ?></div>
        <div class="result-title"><?= $titulo ?></div>
        <p class="result-message"><?= $mensaje ?></p>

        <?php if ($exito): ?>
        <!-- Link box -->
        <div class="link-box">
            <div class="link-box-label">🔗 Tu link de pago</div>
            <div class="link-url">
                <span class="link-url-text" id="linkText"><?= htmlspecialchars($link_url) ?></span>
                <button class="btn-copy" id="btnCopy" onclick="copyLink()">
                    <i class="bi bi-clipboard"></i> Copiar
                </button>
            </div>
        </div>

        <!-- Botones compartir -->
        <div class="share-title">Compartir link</div>
        <div class="share-btns">
            <a href="https://wa.me/?text=<?= urlencode('¡Aquí está tu link de pago para ' . $producto . '! ' . $link_url) ?>"
               target="_blank" class="share-btn wa">
                <i class="bi bi-whatsapp"></i> WhatsApp
            </a>
            <a href="<?= htmlspecialchars($link_url) ?>" target="_blank" class="share-btn open">
                <i class="bi bi-box-arrow-up-right"></i> Abrir link
            </a>
        </div>
        <?php endif; ?>

        <!-- Detalles -->
        <div class="order-details">
            <div class="order-row"><span>Producto</span><span><?= htmlspecialchars($producto) ?></span></div>
            <div class="order-row"><span>Precio</span><span style="color:#3b82f6;font-size:1.05rem;">$<?= number_format((float)$precio,0,',','.') ?> COP</span></div>
            <div class="order-row"><span>Comprador</span><span><?= htmlspecialchars($nombre) ?></span></div>
            <div class="order-row"><span>Correo</span><span><?= htmlspecialchars($correo) ?></span></div>
            <div class="order-row"><span>Referencia</span><span style="font-size:0.78rem;color:var(--pt-text-sec);"><?= htmlspecialchars($referencia) ?></span></div>
            <?php if ($expiracion): ?>
            <div class="order-row"><span>Expira</span><span style="color:#f0b429;"><?= htmlspecialchars($expiracion) ?></span></div>
            <?php endif; ?>
            <div class="order-row">
                <span>Estado</span>
                <span style="color:<?= $exito ? '#3b82f6' : '#e05252' ?>;font-weight:700;">
                    <?= $exito ? '🔗 LINK ACTIVO' : '❌ ERROR' ?>
                </span>
            </div>
        </div>

        <a href="../index.php" class="btn-home">← Inicio</a>
        <a href="../views/textil/pl.php" class="btn-volver">Ver tienda</a>
    </div>

    <script>
    function copyLink() {
        const text = document.getElementById('linkText').textContent.trim();
        navigator.clipboard.writeText(text).then(function() {
            const btn = document.getElementById('btnCopy');
            btn.classList.add('copied');
            btn.innerHTML = '<i class="bi bi-check2"></i> Copiado';
            setTimeout(function() {
                btn.classList.remove('copied');
                btn.innerHTML = '<i class="bi bi-clipboard"></i> Copiar';
            }, 2000);
        });
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
