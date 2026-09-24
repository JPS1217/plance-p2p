<?php

/**
 * navbar.php — Navbar reutilizable
 * 
 * Variables que puedes definir ANTES de incluir este archivo:
 * $nav_back_url  → URL del botón "Volver"        (default: index.php)
 * $nav_back_text → Texto del botón "Volver"       (default: "Volver")
 * $nav_base      → Ruta base hacia la raíz        (default: "../")
 *
 * Ejemplo de uso en cualquier página:
 *   $nav_back_url  = "../index.php";
 *   $nav_back_text = "Volver";
 *   $nav_base      = "../";
 *   require_once '../php/navbar.php';
 */

// Valores por defecto
$nav_back_url  = $nav_back_url  ?? 'index.php';
$nav_back_text = $nav_back_text ?? 'volver';
$nav_base      = $nav_base      ?? '../';

// Sin base de datos ni cuentas de usuario: navbar neutral.
$nav_avatar    = '';
$nav_initials  = 'P';

// ── Links rápidos entre páginas del mismo grupo ──
// Cada carpeta de views/ que agrupa varias páginas hermanas (tiendas de juegos,
// plataformas, textiles, historiales...) tiene sus páginas mapeadas aquí.
// Al entrar a una de ellas, el navbar muestra un desplegable con acceso
// directo a las demás páginas del mismo grupo.
$nav_grupos_tiendas = [
    'games' => [
        'label' => 'Juegos',
        'icon'  => 'fa-shop',
        'items' => [
            'cod.php'         => 'Tienda de Monedas',
            'rainbowsix.php'  => 'Tienda de Gemas',
            'pubg.php'        => 'Tienda de Cash',
            'bloodstrike.php' => 'Tienda de Esmeraldas',
        ],
    ],
    'plataformas' => [
        'label' => 'Plataformas',
        'icon'  => 'fa-shop',
        'items' => [
            'streaming.php'         => 'Streaming',
            'otras_streaming.php'   => 'Otros Streaming',
            'streaming_gateway.php' => 'Streaming Gateway',
            'ia.php'                => 'Inteligencia Artificial',
            'ia_gateway.php'        => 'IA\'s Gateway',
        ],
    ],
    'textil' => [
        'label' => 'Textiles',
        'icon'  => 'fa-shop',
        'items' => [
            'pl.php' => 'Premier League',
        ],
    ],
    'historial' => [
        'label' => 'Historiales',
        'icon'  => 'fa-clock-rotate-left',
        'items' => [
            'reg-pgb.php'  => 'Pagos Básicos',
            'reg-sus.php'  => 'Suscripciones',
            'reg-rec.php'  => 'Recurrentes',
            'reg-link.php' => 'Links de Pago',
            'reg-prea.php' => 'Preautorizaciones',
            'reg-disp.php' => 'Dispersiones',
            'reversos.php' => 'Reversos',
        ],
    ],
];

$nav_current_dir   = basename(dirname($_SERVER['SCRIPT_NAME']));
$nav_current_file  = basename($_SERVER['SCRIPT_NAME']);
$nav_grupo_activo  = $nav_grupos_tiendas[$nav_current_dir] ?? null;
$nav_mostrar_tiendas = $nav_grupo_activo && array_key_exists($nav_current_file, $nav_grupo_activo['items']);

// ── Links entre las secciones (juegos, plataformas, textiles, reservaciones, dispersiones) ──
// Se muestran en cualquier página dentro de esas carpetas para saltar de una sección a otra
// sin tener que volver primero a sesiones.php.
$nav_secciones = [
    'games/juegos.php'               => ['label' => 'Juegos Mobiles',        'icon' => 'fa-solid fa-gamepad'],
    'plataformas/suscripciones.php'  => ['label' => 'Plataformas Digitales', 'icon' => 'bi bi-google-play'],
    'textil/textiles.php'            => ['label' => 'Textiles',              'icon' => 'fa-solid fa-tshirt'],
    'reservaciones/hotel.php'        => ['label' => 'Reservaciones',         'icon' => 'fa-solid fa-calendar-check'],
    'dispersiones/tickets.php'       => ['label' => 'Dispersiones',          'icon' => 'bi bi-airplane-fill'],
];

$nav_dirs_secciones = ['games', 'plataformas', 'textil', 'reservaciones', 'dispersiones'];
$nav_mostrar_secciones = in_array($nav_current_dir, $nav_dirs_secciones, true);
$nav_seccion_actual = $nav_current_dir . '/' . $nav_current_file;
?>

<style>
    .navbar {
        background-color: var(--pt-navbar, #2e2e2ea9) !important;
        backdrop-filter: blur(8px);
        position: relative;
        z-index: 1030;
    }

    /* ── Controles del tutorial (Driver.js) ── */
    body.tutorial-active .navbar { z-index: 1000000001; }
    body.tutorial-active .driver-popover { z-index: 1000000002; }
    body.tutorial-active #navbar-tutorial-actions,
    body.tutorial-active #navbar-tutorial-actions .btn-tutorial {
        z-index: 1000000003;
        pointer-events: auto !important;
        cursor: pointer !important;
    }

    .navbar-tutorial-actions {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 2;
    }

    .btn-tutorial {
        background-color: #f07229;
        color: #0d0e10;
        border: 1px solid #f07229;
        padding: 4px 10px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.82rem;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-tutorial:hover {
        background-color: #ff8a4d;
        border-color: #ff8a4d;
    }

    @media (max-width: 767px) {
        .navbar-tutorial-actions {
            position: static;
            transform: none;
            justify-content: center;
            margin: 6px 0;
            width: 100%;
            order: 10;
        }
    }


    /* ── NAVBAR AVATAR ── */
    .nav-avatar-wrap {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    .nav-avatar-wrap:hover { text-decoration: none; }

    .nav-avatar-img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #f06829;
        transition: border-color 0.2s, transform 0.2s;
    }
    .nav-avatar-img:hover { border-color: #fff; transform: scale(1.08); }

    .nav-avatar-initials {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f04729, #c96910);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.8rem;
        color: #0d0e10;
        border: 2px solid #ff702d;
        transition: border-color 0.2s, transform 0.2s;
        flex-shrink: 0;
    }
    .nav-avatar-initials:hover { border-color: #fff; transform: scale(1.08); }

    .nav-username {
        background-color: var(--pt-bg-card, hsla(120, 2%, 10%, 0.84));
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        color: var(--pt-text, #ffffff);
    }

    /* ── DROPDOWN ── */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropbtn {
        background: var(--pt-dropdown, hsla(120, 2%, 10%, 0.84));
        color: #f07229;
        border: 1.5px solid rgba(240, 180, 41, 0.3);
        border-radius: 8px;
        padding: 6px 14px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    .dropbtn:hover {
        border-color: #f0b429;
        background: rgba(240, 180, 41, 0.1);
    }

    .dropdown-content {
        display: none;
        position: absolute;
        left: 0;
        top: calc(100% + 6px);
        background: var(--pt-bg-surface, #16181c);
        border: 1px solid var(--pt-border, #2e3038);
        border-radius: 10px;
        min-width: 170px;
        z-index: 999;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0,0,0,0.5);
        animation: dropFade 0.15s ease;
    }

    @keyframes dropFade {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .dropdown-content a {
        display: block;
        padding: 0.6rem 1rem;
        color: var(--pt-text, #f0f1f3);
        font-size: 0.87rem;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
    }
    .dropdown-content a i {
        width: 1.1em;
        margin-right: 0.35rem;
        text-align: center;
    }
    .dropdown-content a:hover {
        background: rgba(240, 180, 41, 0.1);
        color: #f06829;
        text-decoration: none;
    }

    .dropdown-content hr {
        border-color: var(--pt-border, #2e3038);
        margin: 0.2rem 0;
    }

    .dropdown-content .cerrar-sesion {
        color: #e05252 !important;
    }
    .dropdown-content .cerrar-sesion:hover {
        background: rgba(224, 82, 82, 0.1) !important;
        color: #e05252 !important;
    }

    .dropdown-content .tienda-activa {
        color: #f0b429 !important;
        font-weight: 700;
        cursor: default;
        pointer-events: none;
        background: rgba(240, 180, 41, 0.08);
    }

    .dropdown-content.show { display: block; }



</style>

<nav class="navbar navbar-dark navbar-expand-lg px-2">
    <a class="navbar-brand fw-bold" href="<?= $nav_base ?>index.php" style="color: orange;">
        <img src="<?= $nav_base ?>assets/icons/icono.png" alt="Logo" style="width: 30px;">
    </a>

 
  
    <!-- BOTON DE RETROSESO -->
    <a href="<?= htmlspecialchars($nav_back_url) ?>" class="btn" style="color: black; color: #f06129;">
        <i class="fa-solid fa-circle-arrow-left fs-6"></i> <?= htmlspecialchars($nav_back_text) ?>
    </a>  <!---->

    <div id="navbar-tutorial-actions" class="navbar-tutorial-actions">
        <button id="navbar-iniciar-tutorial" type="button" class="btn-tutorial">
            <i class="bi bi-question-circle"></i> Iniciar tutorial
        </button>
        <button id="navbar-cerrar-tutorial" type="button" class="btn-tutorial" hidden>
            <i class="bi bi-x-circle"></i> Cerrar tutorial
        </button>
    </div>

    <?php if ($nav_mostrar_secciones): ?>
    <!-- Acceso rápido para saltar a otra sección (juegos, plataformas, textiles, reservaciones, dispersiones) -->
    <div class="dropdown">
        <button class="dropbtn"><i class="fa-solid fa-layer-group"></i> Secciones ▼</button>
        <div class="dropdown-content">
            <?php foreach ($nav_secciones as $nav_sec_ruta => $nav_sec_info): ?>
                <?php if ($nav_sec_ruta === $nav_seccion_actual): ?>
                    <a class="tienda-activa" href="#" aria-current="page"><i class="<?= htmlspecialchars($nav_sec_info['icon']) ?>"></i> <?= htmlspecialchars($nav_sec_info['label']) ?></a>
                <?php else: ?>
                    <a href="<?= $nav_base . 'views/' . htmlspecialchars($nav_sec_ruta) ?>"><i class="<?= htmlspecialchars($nav_sec_info['icon']) ?>"></i> <?= htmlspecialchars($nav_sec_info['label']) ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($nav_mostrar_tiendas): ?>
    <!-- Acceso rápido a las demás tiendas del mismo grupo -->
    <div class="dropdown">
        <button class="dropbtn"><i class="fa-solid <?= htmlspecialchars($nav_grupo_activo['icon'] ?? 'fa-shop') ?>"></i> <?= htmlspecialchars($nav_grupo_activo['label']) ?> ▼</button>
        <div class="dropdown-content">
            <?php foreach ($nav_grupo_activo['items'] as $nav_item_file => $nav_item_label): ?>
                <?php if ($nav_item_file === $nav_current_file): ?>
                    <a class="tienda-activa" href="#" aria-current="page"><i class="fa-solid fa-check"></i> <?= htmlspecialchars($nav_item_label) ?></a>
                <?php else: ?>
                    <a href="<?= htmlspecialchars($nav_item_file) ?>"><?= htmlspecialchars($nav_item_label) ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="ms-auto d-flex align-items-center gap-2">

        <!-- Opciones (sin cuentas de usuario) -->
        <div class="dropdown">
            <button class="dropbtn">Opciones ▼</button>
            <div class="dropdown-content">
                <a href="<?= $nav_base ?>views/settings/configuracion.php">Configuración</a>
            </div>
        </div>
    </div>
</nav>

<script>
(function () {
    var dropdowns = document.querySelectorAll('.navbar .dropdown');

    dropdowns.forEach(function (dropdown) {
        var btn     = dropdown.querySelector('.dropbtn');
        var content = dropdown.querySelector('.dropdown-content');
        if (!btn || !content) return;

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var yaAbierto = content.classList.contains('show');

            document.querySelectorAll('.navbar .dropdown-content.show').forEach(function (abierto) {
                abierto.classList.remove('show');
            });

            if (!yaAbierto) content.classList.add('show');
        });
    });

    document.addEventListener('click', function () {
        document.querySelectorAll('.navbar .dropdown-content.show').forEach(function (abierto) {
            abierto.classList.remove('show');
        });
    });
})();
</script>