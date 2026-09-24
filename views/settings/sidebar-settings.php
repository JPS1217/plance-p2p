<?php
/**
 * sidebar-settings.php — Sidebar reutilizable para la sección Settings
 *
 * Variables que puedes definir ANTES de incluir este archivo:
 * $settings_base → Ruta base hacia la carpeta Settings (default: "")
 *
 * Ejemplo de uso en cualquier página dentro de /settings/:
 *   require_once 'sidebar-settings.php';
 */

$settings_base = $settings_base ?? '';
$pagina_actual = basename($_SERVER['PHP_SELF']);
?>
<style>
    .settings-sidebar {
        background: var(--pt-bg-card);
        border-radius: 16px;
        padding: 16px;
        position: sticky;
        top: 20px;
        box-shadow: var(--shadow, 0 8px 24px rgba(0,0,0,0.3));
    }

    .sidebar-menu {
        display: flex;
        flex-direction: column;
        gap: 8px;
        border-radius: 12px;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 10px;
        color: var(--pt-text, #f1f5f9);
        font-weight: 600;
        transition: .2s ease;
        text-decoration: none;
    }
    .sidebar-link:hover { text-decoration: none; }

    .sidebar-link i {
        width: 18px;
        text-align: center;
        color: var(--pt-text-sec, #dce5ec);
    }

    .sidebar-link.active,
    .sidebar-link:hover {
        background-color: var(--pt-hover);
        color: var(--pt-text);
    }
    .sidebar-link.active i,
    .sidebar-link:hover i {
        color: #000000;
    }

    .sidebar-divider {
        height: 1px;
        background: var(--pt-border, rgba(255,255,255,0.08));
        margin: 12px 4px;
    }
</style>

<aside class="settings-sidebar">
    <nav class="sidebar-menu">
        <a href="<?= $settings_base ?>configuracion.php" class="sidebar-link <?= $pagina_actual === 'configuracion.php' ? 'active' : '' ?>">
            <i class="bi bi-sliders"></i>
            Configuración
        </a>
    </nav>

    <div class="sidebar-divider"></div>

    <div style="padding: 8px 10px 2px; color: var(--text-soft, #8a8d96); font-size: .9rem;">
        <i class="bi bi-info-circle"></i>
        Preferencias de apariencia
    </div>
</aside>