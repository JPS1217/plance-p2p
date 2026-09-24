
<?php
// ══════════════════════════════════════════
// theme.php — Motor de tema (claro/oscuro)
// Se incluye en el <head> de cada página, justo antes de </head>
// Sin base de datos ni cuentas de usuario: la apariencia por defecto es la
// misma que veía un invitado (tema oscuro, sin imagen de fondo). La
// personalización cliente (localStorage) se conecta aquí más adelante.
// ══════════════════════════════════════════

if (session_status() === PHP_SESSION_NONE) session_start();

// ── Apariencia por defecto (equivalente a un invitado navegando hoy) ──
$theme_tema = 'oscuro';
$theme_fondo = 'ninguno';

// ── Fondos personalizados por sección (Apariencia > Personalizado 1 / 2) ──
// $theme_seccion lo define cada página ANTES de incluir este archivo.
$FONDOS_PERSONALIZADOS = [
    'personalizado1' => [ // oscuros
        'home'        => 'bg13.webp',
        'sesiones'    => 'bg30.webp',
        'juegos'      => 'bg28.webp',
        'tiendas'     => 'bg23.webp',
        'textiles'    => 'bg11.webp',
        'preautor'     => 'bg27.webp',
        'dispersion'     => 'bg29.webp',
        'registros'   => 'bg7.webp',
        'historial'   => 'bg40.webp',
        'plataformas' => 'bg50.webp',
        'guias'       => 'bg39.webp',
    ],
    'personalizado2' => [ // claros
        'home'        => 'bg43.webp',
        'sesiones'    => 'bg43.webp',
        'juegos'      => 'bg53.webp',
        'tiendas'     => 'bg52.webp',
        'textiles'    => 'bg54.webp',
        'preautor'     => 'bg59.webp',
        'dispersion'     => 'bg54.webp',
        'registros'    => 'bg45.webp',
        'historial'   => 'bg19.webp',
        'plataformas' => 'bg48.webp',
        'guias'       => 'bg44.webp',

    ],
];

$theme_bg_image = null;
if (isset($theme_seccion) && isset($FONDOS_PERSONALIZADOS[$theme_fondo][$theme_seccion])) {
    $theme_bg_image = '/assets/images/' . $FONDOS_PERSONALIZADOS[$theme_fondo][$theme_seccion];
}
if ($theme_bg_image) {
    // Adelanta la descarga de la imagen de fondo: sin esto el navegador no
    // la pide hasta terminar de parsear el <style> generado más abajo.
    echo '<link rel="preload" as="image" fetchpriority="high" href="' . htmlspecialchars($theme_bg_image) . '">' . "\n";
}
// ── Definir una fuente de texto ──




// ── Definir paleta según tema ──
$es_claro = ($theme_tema === 'claro');
$c_bg_base    = $es_claro ? '#f5f5f7' : '#0d0e10';
$c_bg_secondary = $es_claro ? '#f5f5f7' : '#000000';
$c_bg_surface = $es_claro ? '#ffffff' : '#16181c';
$c_bg_card    = $es_claro ? '#f0f0f2' : '#1e2128';
$c_bg_card2    = $es_claro ? '#f1f1f1fa' : '#2b2b2ba9';
$c_border     = $es_claro ?  '#f3f3f3;' : '#2e3038';
$c_text       = $es_claro ? '#111114' : '#f0f1f3';
$c_text_sec   = $es_claro ? '#5a5a63' : '#8a8d96';
$c_text_ter    = $es_claro ? '#fefeff' : '#f0f0f0';
$c_navbar     = $es_claro ? 'rgba(255,255,255,0.85)' : '#2b2b2ba9';
$c_box_shadow  = $es_claro ? '0 2px 4px rgba(0,0,0,0.1)' : '0 2px 4px rgba(0,0,0,0.5)';
$c_hover      = $es_claro ?  '#f3f3f3;' : '#2e3038';
$c_paint       = $es_claro ? 'rgb(238, 238, 238)' : '#0a0a0a';
$c_th       = $es_claro ? 'hsla(0, 100%, 100%, 0.84)' : '#0a0a0a';
$c_th2       = $es_claro ? 'rgba(223, 223, 223, 0.72)' : '#0a0a0a';
$c_boxitem       = $es_claro ? 'rgb(255, 253, 253)' : '#222224';  
$c_boxitem2       = $es_claro ? 'rgb(255, 253, 253)' : '#1d1d1f';  
$c_lightbox       = $es_claro ? 'rgba(255, 255, 255, 0.85)' : 'rgba(14,14,14,0.8)';
$c_recivos       = $es_claro ? 'rgb(255, 253, 253)' : '#222224';
$c_dropdown       = $es_claro ? 'rgba(247, 246, 246, 0.85)' : 'rgba(14,14,14,0.8)';
$c_bg_gradiente    = $es_claro ? '#f5f5f7' : '#0d0e10'; //como seria esto con gradiente? 
?>
<style id="plance-theme-engine">
    :root {
        --pt-bg-base:    <?= $c_bg_base ?>;
        --pt-bg-secondary: <?= $c_bg_secondary ?>;
        --pt-bg-surface: <?= $c_bg_surface ?>;
        --pt-bg-card:    <?= $c_bg_card ?>;
        --pt-bg-card2:   <?= $c_bg_card2 ?>;
        --pt-border:     <?= $c_border ?>;
        --pt-text:       <?= $c_text ?>;
        --pt-text-sec:   <?= $c_text_sec ?>;
        --pt-text-ter:   <?= $c_text_ter ?>;
        --pt-navbar:     <?= $c_navbar ?>;
        --pt-paint:      <?= $c_paint ?>; 
        --pt-box-shadow:  <?= $c_box_shadow ?>;
        --pt-th: <?= $c_th ?>;
        --pt-th2: <?= $c_th2 ?>;
        --pt-boxitem: <?= $c_boxitem ?>;
        --pt-boxitem2: <?= $c_boxitem2 ?>;
        --pt-hover: <?= $c_hover ?>;
        --pt-recivos: <?= $c_recivos ?>;
        --pt-lightbox: <?= $c_lightbox ?>;
        --pt-dropdown: <?= $c_dropdown ?>;
    }
    body {
        background-color: var(--pt-bg-base) !important;
        color: var(--pt-text) !important;
    }
    .navbar { background-color: var(--pt-navbar) !important; }
    <?php if ($theme_bg_image): ?>
    body {
        background-image:
            linear-gradient(180deg, <?= $es_claro ? 'rgba(245, 245, 247, 0)' : 'rgba(10, 10, 10, 0.01)' ?> 0%, <?= $es_claro ? 'rgba(245, 245, 247, 0)' : 'rgba(10, 10, 10, 0)' ?> 100%),
            url('<?= $theme_bg_image ?>') !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        background-attachment: fixed !important;
        background-size: cover !important;
    }
    <?php endif; ?>
</style>