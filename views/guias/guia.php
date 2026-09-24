<?php
    session_start();


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guía</title>
        <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.2/lib/anime.min.js"></script>
    <!-- Tu CSS -->
    <link rel="stylesheet" href="../../assets/css/estilos.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/estilos.css'); ?>">
     <?php $theme_seccion = 'guias'; require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>
</head>


<style>
    body {
        background: var(--pt-bg-secondary);
        color: var(--pt-text);
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        font-family: 'Barlow', sans-serif;
        min-height: 100vh;
    }

    .navbar {
        background-color: var(--pt-navbar) !important;
        backdrop-filter: blur(10px);
        color: var(--pt-text);
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }

    .guide-hero {
        max-width: 860px;
        margin: 0 auto 2.2rem;
        text-align: center;
        padding: 1rem 1rem 0;
    }

    .guide-title {
        font-family: 'Barlow', sans-serif;
        font-size: clamp(2.4rem, 5vw, 4rem);
        font-weight: 800;
        margin-bottom: 0.65rem;
        letter-spacing: 0.02em;
    }

    .guide-subtitle {
        max-width: 760px;
        margin: 0 auto;
        color: var(--pt-text);
        font-size: 1.02rem;
    }

    .guide-section {
        width: min(1180px, 94%);
        margin: 0 auto 3rem;
    }

    .guide-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(280px, 1fr));
        gap: 22px;
        align-items: stretch;
    }

    .doc-card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-height: 430px;
        padding: 0;
        text-decoration: none;
        color: var(--pt-text);
        border-radius: 22px;
        overflow: hidden;
        border: 1px solid rgba(255, 123, 0, 0.14);
        background: var(--pt-navbar);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.28);
        transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
        animation: fadeIn 0.8s ease forwards;
        opacity: 0;
    }

    .doc-card:nth-child(1) { animation-delay: 0.08s; }
    .doc-card:nth-child(2) { animation-delay: 0.16s; }

    .doc-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(rgba(255,255,255,0.045) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.045) 1px, transparent 1px);
        background-size: 42px 42px;
        mask-image: linear-gradient(180deg, rgba(0,0,0,0.7), transparent 78%);
        pointer-events: none;
    }

    .doc-card::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top center, rgba(0, 0, 0, 0.12), transparent 45%);
        pointer-events: none;
    }

    .doc-card:hover {
        transform: translateY(-8px);
        border-color: rgba(236, 106, 31, 0.4);
        box-shadow: 0 26px 60px rgba(0, 0, 0, 0.35);
        color: var(--pt-text);
    }

    .doc-card-visual {
        position: relative;
        min-height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1.5rem 1.2rem;
        z-index: 1;
    }

    .visual-window,
    .visual-panel,
    .visual-shield {
        position: relative;
        filter: drop-shadow(0 18px 28px rgba(0, 0, 0, 0.25));
    }

    .visual-window {
        width: 180px;
        height: 128px;
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,0.12);
        background: linear-gradient(180deg, #7a8191 0%, #646d7f 100%);
        box-shadow: inset 0 0 0 1px rgba(255,255,255,0.04);
    }

    .visual-window::before {
        content: "";
        position: absolute;
        top: 12px;
        left: 14px;
        width: 78px;
        height: 10px;
        border-radius: 999px;
        background: rgba(0, 0, 0, 0.35);
        box-shadow: 0 18px 0 rgba(0, 0, 0, 0.28), 0 36px 0 rgba(36, 36, 36, 0.24), 0 54px 0 rgba(0, 0, 0, 0.2);
    }

    .visual-window::after {
        content: "";
        position: absolute;
        right: -22px;
        bottom: -10px;
        width: 74px;
        height: 96px;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.08);
        background: linear-gradient(180deg, #7f8797 0%, #667082 100%);
       
    }

    .doc-card--user .doc-card-visual .mini-lines,
    .doc-card--developer .doc-card-visual .mini-lines {
        position: absolute;
        width: 54px;
        height: 8px;
        border-radius: 999px;
        background: rgba(37, 37, 37, 0.28);
        top: 62px;
        left: calc(50% - 68px);
        box-shadow: 0 16px 0 rgba(0, 0, 0, 0.22), 0 32px 0 rgba(0, 0, 0, 0.18);
        z-index: 2;
    }

    .visual-panel {
        width: 188px;
        height: 132px;
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,0.12);
        background: linear-gradient(180deg, #7a8191 0%, #646d7f 100%);
    }

    .visual-panel::before {
        content: "";
        position: absolute;
        top: 16px;
        left: 14px;
        width: 160px;
        height: 8px;
        border-radius: 999px;
        background: rgba(0, 0, 0, 0.32);
    }

    .visual-panel::after {
        content: "<​/>";
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(0, 0, 0, 0.55);
        font-size: 3rem;
        font-weight: 800;
        letter-spacing: 0.08em;
    }

    .mini-tag {
        position: absolute;
        padding: 0.18rem 0.45rem;
        border-radius: 7px;
        background: rgba(255,255,255,0.9);
        color: #8c92a0;
        font-size: 0.72rem;
        font-weight: 800;
        box-shadow: 0 8px 18px rgba(0,0,0,0.12);
        z-index: 2;
    }

    .tag-api { left: calc(50% - 108px); top: 36px; }
    .tag-dev { right: calc(50% - 115px); top: 32px; }
    .tag-user { right: calc(50% - 102px); bottom: 34px; }

    .visual-shield {
        width: 122px;
        height: 144px;
        background: linear-gradient(180deg, #667082 0%, #4f5868 100%);
        clip-path: polygon(50% 0%, 88% 14%, 88% 58%, 76% 84%, 50% 100%, 24% 84%, 12% 58%, 12% 14%);
        border: 1px solid rgba(255,255,255,0.1);
    }

    .visual-shield::before {
        content: "";
        position: absolute;
        width: 32px;
        height: 44px;
        border-radius: 20px;
        background: rgba(0, 0, 0, 0.5);
        left: 50%;
        top: 36px;
        transform: translateX(-50%);
    }

    .visual-shield::after {
        content: "";
        position: absolute;
        width: 12px;
        height: 22px;
        border-radius: 0 0 10px 10px;
        background: rgba(0, 0, 0, 0.72);
        left: 50%;
        top: 58px;
        transform: translateX(-50%);
    }

    .doc-card-body {
        position: relative;
        z-index: 1;
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 0 1.55rem 1.45rem;
        text-align: center;
    }

    .doc-card-title {
        font-family: 'Barlow', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--pt-text);
    }

    .doc-card-text {
        color: var(--pt-text);
        line-height: 1.55;
        font-size: 1rem;
        margin-bottom: 1.4rem;
    }

    .doc-card-link {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: rgb(255, 209, 5);
        font-weight: 700;
        font-size: 1rem;
        border-top: 1px solid rgba(255,255,255,0.07);
        padding-top: 1rem;
    }

    .doc-card-link i {
        font-size: 1rem;
        transition: transform 0.25s ease;
    }

    .doc-card:hover .doc-card-link i {
        transform: translateX(4px);
    }

    .back:hover {
        background: #ff6811f5;
        transform: translateY(-1px);
        box-shadow: 0 5px 10px rgba(255, 94, 0, 0.5);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(18px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 991px) {
        .guide-grid {
            grid-template-columns: 1fr;
        }

        .doc-card {
            min-height: 390px;
        }
    }
</style>


<body class="d-flex flex-column min-vh-100">
    
        <?php
            $nav_back_url  = "../../index.php";
            $nav_back_text = "Atras";
            $nav_base      = "../../";
            require_once '../../php/navbar.php';
        ?>

        <div class="guide-hero">
            <h4 class="guide-title">Guías</h4>
            <p class="guide-subtitle">Explora la documentación principal de tu proyecto en un formato visual inspirado en la documentación oficial. Elige la guía de usuario o la guía técnica para continuar.</p>
        </div>

        <section class="guide-section">
            <div class="guide-grid">

                <a href="guia-user.php" class="doc-card doc-card--user">
                    <div class="doc-card-visual">
                        <div class="visual-window"></div>
                        <span class="mini-lines"></span>
                    </div>
                    <div class="doc-card-body">
                        <h2 class="doc-card-title">Guía Usuario</h2>
                        <p class="doc-card-text">Conoce el flujo de compra, la experiencia del comprador y la navegación básica para entender cómo interactúa el usuario con la plataforma.</p>
                        <div class="doc-card-link">
                            <span>Ver Guia</span>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>

                <a href="guia-developer.php" class="doc-card doc-card--developer">
                    <div class="doc-card-visual">
                        <div class="visual-panel"></div>
                        <span class="mini-tag tag-api">API</span>
                        <span class="mini-tag tag-dev">DEV</span>
                        <span class="mini-tag tag-user">SDK</span>
                    </div>
                    <div class="doc-card-body">
                        <h2 class="doc-card-title">Guía Developer</h2>
                        <p class="doc-card-text">Accede a la parte técnica de la integración, estructura del proyecto y recursos clave para implementar los servicios de PlacetoPay de forma ordenada.</p>
                        <div class="doc-card-link">
                            <span>Ver Guia</span>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>

            </div>
        </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/validaciones.js"></script>
    <script>
        if (typeof anime !== 'undefined') {
            document.querySelectorAll('.doc-card').forEach(function(card) {
                const visual = card.querySelector('.doc-card-visual > div');
                card.addEventListener('mouseenter', function() {
                    if (visual) anime({ targets: visual, scale: 1.06, duration: 350, easing: 'easeOutQuad' });
                });
                card.addEventListener('mouseleave', function() {
                    if (visual) anime({ targets: visual, scale: 1, duration: 350, easing: 'easeOutQuad' });
                });
            });
        }
    </script>
</body>
</html>