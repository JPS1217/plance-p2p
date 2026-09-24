<?php
session_start();

require_once __DIR__ . '/../../php/env.php';

// ══════════════════════════════════════════
// Guardar apariencia seleccionada (tema + fondo personalizado)
// Sin base de datos: la selección se guarda solo en la sesión actual.
// (La persistencia real vía localStorage es un paso posterior.)
// ══════════════════════════════════════════
$alerta = '';
$alerta_tipo = '';

$APARIENCIAS_VALIDAS = ['oscuro', 'claro', 'personalizado1', 'personalizado2'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apariencia_post = $_POST['apariencia'] ?? 'oscuro';
    if (!in_array($apariencia_post, $APARIENCIAS_VALIDAS, true)) {
        $apariencia_post = 'oscuro';
    }

    // personalizado1 = oscuro + fondo oscuro · personalizado2 = claro + fondo claro
    if ($apariencia_post === 'personalizado1') {
        $tema_post = 'oscuro';
        $fondo_post = 'personalizado1';
    } elseif ($apariencia_post === 'personalizado2') {
        $tema_post = 'claro';
        $fondo_post = 'personalizado2';
    } else {
        $tema_post = $apariencia_post;
        $fondo_post = 'ninguno';
    }

    $_SESSION['tema_local'] = $tema_post;
    $_SESSION['fondo_local'] = $fondo_post;

    $alerta = '¡Apariencia actualizada!';
    $alerta_tipo = 'success';
}

// Cargar apariencia actual (solo sesión)
$tema_actual  = $_SESSION['tema_local'] ?? 'oscuro';
$fondo_actual = $_SESSION['fondo_local'] ?? 'ninguno';

if ($fondo_actual === 'personalizado1' || $fondo_actual === 'personalizado2') {
    $apariencia_actual = $fondo_actual;
} else {
    $apariencia_actual = $tema_actual === 'claro' ? 'claro' : 'oscuro';
}

$theme_seccion = 'settings';
require_once __DIR__ . '/../../php/theme.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración | Plance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <?php require_once __DIR__ . '/../../php/theme.php'; ?>

    <style>

        :root {
            --bg-main: #161616;
            --bg-card: #0e0f0f;
            --border: rgba(255,255,255,0.08);
            --text-main: #f5f7fa;
            --text-soft: #98a2ad;
            --orange: rgb(255, 123, 0);
            --success: #49c774;
            --shadow: 0 12px 30px rgba(0,0,0,0.22);
            --radius-lg: 16px;
            --radius-md: 12px;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; background: var(--pt-bg-base); color: var(--pt-text); font-family: 'Barlow', sans-serif; }
        a { text-decoration: none; }

        .settings-page { max-width: 1280px; margin: 0 auto; padding: 28px 20px 40px; }
        .topbar { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 22px; }
        .back-link {
            display: inline-flex; align-items: center; gap: .55rem;
            color: #dbe3ea; font-weight: 700; font-size: .95rem;
            padding: 10px 14px; border: 1px solid var(--border); border-radius: 10px;
            background: rgba(255,255,255,0.02); transition: .2s ease;
        }
        .back-link:hover { color: #fff; border-color: rgba(255,255,255,0.16); background: rgba(255,255,255,0.04); }
        .topbar-title { font-size: 1.6rem; font-weight: 800; margin: 0; }
        .topbar-subtitle { margin: 2px 0 0; color: var(--text-soft); font-size: .95rem; }

        .settings-layout { display: grid; grid-template-columns: 270px 1fr; gap: 20px; align-items: start; }
        .settings-main { display: grid; gap: 20px; }

        .card-panel {
            background: var(--pt-bg-card); border-radius: var(--radius-lg);
            border: 1px solid var(--border); box-shadow: var(--shadow);
            padding: 22px; opacity: 0;
        }
        .settings-card-title { font-size: 1.15rem; font-weight: 800; margin: 0 0 4px; }
        .settings-card-desc { color: var(--text-soft); font-size: .9rem; margin: 0 0 18px; } 

        .alert-box { padding: 12px 14px; border-radius: 10px; font-size: .88rem; margin-bottom: 16px; }
        .alert-box.success { background: rgba(73,199,116,0.12); color: var(--success); border: 1px solid rgba(73,199,116,0.3); }
        .alert-box.error   { background: rgba(224,82,82,0.12); color: #e05252; border: 1px solid rgba(224,82,82,0.3); }

        .theme-picker { display: flex; gap: 14px; flex-wrap: wrap; }

        .theme-card {
            width: 188px;
            display: block;
            border-radius: var(--radius-md);
            border: 2px solid var(--border);
            overflow: hidden;
            cursor: pointer;
            transition: border-color .2s ease, box-shadow .2s ease, transform .15s ease;
        }
        .theme-card:hover { border-color: rgba(255,123,0,0.55); transform: translateY(-1px); }
        .theme-card.active { border-color: var(--orange); box-shadow: 0 0 0 3px rgba(255,123,0,0.15); }
        .theme-card input { position: absolute; opacity: 0; pointer-events: none; }

        .theme-preview {
            height: 100px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 7px;
        }
        .theme-preview-dark { background: #0d0e10; }
        .theme-preview-light { background: #eef0f3; }
        .theme-preview-photo {
            background-size: cover;
            background-position: center;
            justify-content: flex-start;
        }

        .tp-tabs { display: flex; gap: 4px; }
        .tp-tab { height: 6px; width: 20px; border-radius: 3px; }
        .theme-preview-dark .tp-tab { background: rgba(255,255,255,0.14); }
        .theme-preview-light .tp-tab { background: rgba(17,17,20,0.14); }

        .tp-titlebar { height: 6px; width: 42%; border-radius: 3px; }
        .theme-preview-dark .tp-titlebar { background: rgba(255,255,255,0.22); }
        .theme-preview-light .tp-titlebar { background: rgba(17,17,20,0.2); }

        .tp-row { display: flex; gap: 6px; flex: 1; }
        .tp-accent-block {
            flex: 1.6; border-radius: 6px;
            background: linear-gradient(135deg, rgba(255,140,0,0.95), rgba(255,80,0,0.7));
        }
        .tp-side-block { flex: 1; border-radius: 6px; }
        .theme-preview-dark .tp-side-block { background: rgba(255,255,255,0.07); }
        .theme-preview-light .tp-side-block { background: rgba(17,17,20,0.08); }

        .theme-card-footer {
            display: flex; align-items: center; gap: 8px;
            padding: 10px 12px;
            background: var(--pt-bg-card);
            border-top: 1px solid var(--border);
        }
        .theme-radio {
            width: 15px; height: 15px; border-radius: 50%; flex-shrink: 0;
            border: 2px solid var(--text-soft);
            position: relative; transition: border-color .2s ease;
        }
        .theme-card.active .theme-radio { border-color: var(--orange); }
        .theme-card.active .theme-radio::after {
            content: ''; position: absolute; inset: 2px; border-radius: 50%; background: var(--orange);
        }
        .theme-card-label {
            font-weight: 700; font-size: .88rem;
            display: flex; align-items: center; gap: 6px;
            white-space: nowrap;
        }
        .theme-card-badge {
            margin-left: auto; font-size: .62rem; font-weight: 800; letter-spacing: .03em;
            text-transform: uppercase; white-space: nowrap;
            color: var(--orange); background: rgba(255,123,0,0.12);
            border: 1px solid rgba(255,123,0,0.3); border-radius: 20px; padding: 2px 7px;
        }

        .theme-picker-hint {
            display: flex; align-items: flex-start; gap: 8px;
            margin: 14px 0 0; max-width: 620px;
            color: var(--text-soft); font-size: .84rem; line-height: 1.5;
        }
        .theme-picker-hint i { margin-top: 2px; }

        .form-actions { margin-top: 20px; }
        .btn-save {
            background: var(--orange); color: #0d0e10; border: none;
            padding: 11px 22px; border-radius: 10px; font-weight: 800;
            cursor: pointer; transition: .2s ease;
        }
        .btn-save:hover { opacity: .88; }

        @media (max-width: 900px) {
            .settings-layout { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="settings-page">
        <div class="topbar">
            <div>
                <h1 class="topbar-title">Configuración</h1>
                <p class="topbar-subtitle">Personaliza la apariencia de Plance.</p>
            </div>
            <a href="../../index.php" class="back-link">
                <i class="bi bi-arrow-left"></i>
                Atras
            </a>
        </div>

        <div class="settings-layout">
            <?php require_once __DIR__ . '/sidebar-settings.php'; ?>

            <main class="settings-main">
                <section class="card-panel">
                    <h2 class="settings-card-title">Apariencia</h2>
                    <p class="settings-card-desc">Elige el tema con el que quieres ver Plance.</p>

                    <?php if ($alerta): ?>
                        <div class="alert-box <?= $alerta_tipo ?>"><?= htmlspecialchars($alerta) ?></div>
                    <?php endif; ?>

                    <form method="POST" id="temaForm">
                        <div class="theme-picker">
                            <label class="theme-card <?= $apariencia_actual === 'oscuro' ? 'active' : '' ?>">
                                <input type="radio" name="apariencia" value="oscuro" <?= $apariencia_actual === 'oscuro' ? 'checked' : '' ?>>
                                <div class="theme-preview theme-preview-dark">
                                    <div class="tp-tabs"><span class="tp-tab"></span><span class="tp-tab"></span><span class="tp-tab"></span></div>
                                    <div class="tp-titlebar"></div>
                                    <div class="tp-row">
                                        <div class="tp-accent-block"></div>
                                        <div class="tp-side-block"></div>
                                    </div>
                                </div>
                                <div class="theme-card-footer">
                                    <span class="theme-radio"></span>
                                    <span class="theme-card-label"><i class="bi bi-moon-stars-fill"></i> Oscuro</span>
                                    <?php if ($apariencia_actual === 'oscuro'): ?><span class="theme-card-badge">Activo</span><?php endif; ?>
                                </div>
                            </label>

                            <label class="theme-card <?= $apariencia_actual === 'claro' ? 'active' : '' ?>">
                                <input type="radio" name="apariencia" value="claro" <?= $apariencia_actual === 'claro' ? 'checked' : '' ?>>
                                <div class="theme-preview theme-preview-light">
                                    <div class="tp-tabs"><span class="tp-tab"></span><span class="tp-tab"></span><span class="tp-tab"></span></div>
                                    <div class="tp-titlebar"></div>
                                    <div class="tp-row">
                                        <div class="tp-accent-block"></div>
                                        <div class="tp-side-block"></div>
                                    </div>
                                </div>
                                <div class="theme-card-footer">
                                    <span class="theme-radio"></span>
                                    <span class="theme-card-label"><i class="bi bi-sun-fill"></i> Claro</span>
                                    <?php if ($apariencia_actual === 'claro'): ?><span class="theme-card-badge">Activo</span><?php endif; ?>
                                </div>
                            </label>

                            <label class="theme-card <?= $apariencia_actual === 'personalizado1' ? 'active' : '' ?>">
                                <input type="radio" name="apariencia" value="personalizado1" <?= $apariencia_actual === 'personalizado1' ? 'checked' : '' ?>>
                                <div class="theme-preview theme-preview-photo" style="background-image: linear-gradient(180deg, rgba(10,10,10,0.15), rgba(10,10,10,0.75)), url('/assets/images/bg25.webp');">
                                    <div class="tp-tabs"><span class="tp-tab" style="background:rgba(255,255,255,0.35);"></span><span class="tp-tab" style="background:rgba(255,255,255,0.35);"></span><span class="tp-tab" style="background:rgba(255,255,255,0.35);"></span></div>
                                </div>
                                <div class="theme-card-footer">
                                    <span class="theme-radio"></span>
                                    <span class="theme-card-label"><i class="bi bi-image-fill"></i> Personalizado 1</span>
                                    <?php if ($apariencia_actual === 'personalizado1'): ?><span class="theme-card-badge">Activo</span><?php endif; ?>
                                </div>
                            </label>

                            <label class="theme-card <?= $apariencia_actual === 'personalizado2' ? 'active' : '' ?>">
                                <input type="radio" name="apariencia" value="personalizado2" <?= $apariencia_actual === 'personalizado2' ? 'checked' : '' ?>>
                                <div class="theme-preview theme-preview-photo" style="background-image: linear-gradient(180deg, rgba(255,255,255,0.1), rgba(255,255,255,0.6)), url('/assets/images/bg43.webp');">
                                    <div class="tp-tabs"><span class="tp-tab" style="background:rgba(17,17,20,0.3);"></span><span class="tp-tab" style="background:rgba(17,17,20,0.3);"></span><span class="tp-tab" style="background:rgba(17,17,20,0.3);"></span></div>
                                </div>
                                <div class="theme-card-footer">
                                    <span class="theme-radio"></span>
                                    <span class="theme-card-label"><i class="bi bi-image-fill"></i> Personalizado 2</span>
                                    <?php if ($apariencia_actual === 'personalizado2'): ?><span class="theme-card-badge">Activo</span><?php endif; ?>
                                </div>
                            </label>
                        </div>

                        <p class="theme-picker-hint">
                            <i class="bi bi-info-circle"></i>
                            Personalizado 1 y 2 aplican un fondo de imagen (oscuro o claro) en Inicio, Sesiones, Juegos, Historial, Plataformas y Guías.
                        </p>

                        <div class="form-actions">
                            <button type="submit" class="btn-save">Guardar</button>
                        </div>
                    </form>
                </section>
            </main>
        </div>
    </div>

    <script>
        document.querySelectorAll('.theme-card').forEach(function(card) {
            card.addEventListener('click', function() {
                document.querySelectorAll('.theme-card').forEach(function(c) {
                    c.classList.remove('active');
                    var oldBadge = c.querySelector('.theme-card-badge');
                    if (oldBadge) oldBadge.remove();
                });
                this.classList.add('active');
                this.querySelector('input[type="radio"]').checked = true;
                var badge = document.createElement('span');
                badge.className = 'theme-card-badge';
                badge.textContent = 'Activo';
                this.querySelector('.theme-card-footer').appendChild(badge);
            });
        });

        // Entrada rápida de los paneles (sin animejs, CSS puro para que cargue al instante)
        document.querySelectorAll('.card-panel').forEach(function(p, i) {
            p.style.transition = 'opacity .25s ease';
            setTimeout(() => p.style.opacity = '1', 20 + i * 40);
        });
    </script>
</body>
</html>