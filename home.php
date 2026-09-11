<?php
session_start();

if (!isset($_SESSION["usuario"]) && empty($_SESSION["invitado"])) {
    echo '<script>
            alert("Por favor, inicie sesión para acceder a esta página.");
            window.location.href = "index.php";
            </script>';

    session_destroy();
    die();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plance | Centro de recursos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Barlow:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <?php $theme_seccion = 'home';
    require_once __DIR__ . '/php/theme.php'; ?>

    <link rel="stylesheet"
        href="assets/css/pages/home.css?v=<?php echo filemtime(__DIR__ . '/assets/css/pages/home.css'); ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="assets/css/components/driver-theme.css?v=<?php echo filemtime(__DIR__ . '/assets/css/components/driver-theme.css'); ?>">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php
    $show_tutorial_help = true;
    $nav_back_url = 'home.php';
    $nav_back_text = 'Atrás';
    $nav_base = '';
    require_once __DIR__ . '/php/navbar.php';
    ?>

    <main class="container px-3 py-2">

        <section class="hero-header text-center pt-4">
            <h1 id="heroTitle" class="hero-title">
                Bienvenido&nbsp;&nbsp;a&nbsp;&nbsp;<span>Plance</span>
            </h1>
            <p class="hero-subtitle">
                Aprende a integrarte con Place to Pay mediante ejemplos prácticos, guías y recursos diseñados para
                acompañarte durante el proceso.
            </p>
        </section>

        <div class="hero-intro">
            <div class="resources-badge"><i class="bi bi-stars"></i> Que necesitas hacer?</div>
        </div>

        <section class="orientation-panel" aria-labelledby="orientation-title">

            <div class="orientation-grid">
                <a href="views/guias/guia-dev/requestdemo.php?tipo=basico" class="orientation-item">
                    <span aria-hidden="true">📦</span>
                    <span><strong>Cobrar una compra normal</strong><small>Pago Básico</small></span>
                </a>
                <a href="views/guias/guia-dev/requestdemo.php?tipo=recurrencia" class="orientation-item">
                    <span aria-hidden="true">🔄</span>
                    <span><strong>Realizar cobros periódicos</strong><small>Pago Recurrente</small></span>
                </a>
                <a href="views/guias/guia-dev/requestdemo.php?tipo=suscripcion" class="orientation-item">
                    <span aria-hidden="true">💳</span>
                    <span><strong>Guardar una tarjeta para cobros futuros</strong><small>Suscripción</small></span>
                </a>
                <a href="views/guias/guia-dev/requestdemo.php?tipo=dispersion" class="orientation-item">
                    <span aria-hidden="true">🏪</span>
                    <span><strong>Dividir el pago entre varios beneficiarios</strong><small>Pago con
                            Dispersión</small></span>
                </a>
                <a href="views/guias/guia-dev/requestdemo.php?tipo=preauth" class="orientation-item">
                    <span aria-hidden="true">🏨</span>
                    <span><strong>Bloquear fondos y capturar después</strong><small>Preautorización</small></span>
                </a>
            </div>
        </section>

        <section class="hero-card p-4 p-lg-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <h1 class="display-5 fw-bold mt-3 mb-3">Explora las integraciones de Place to Pay</h1>
                    <p class="lead mb-0">Selecciona una categoría</p>
                </div>
                <div class="col-lg-4">
                    <div class="hero-panel" id="lista-integraciones">
                        <div class="servicio-toggle" role="group" aria-label="Filtrar integraciones por servicio">
                            <button type="button" class="servicio-btn active" data-filter="web" aria-pressed="true">
                                Web Checkout
                            </button>
                            <button type="button" class="servicio-btn" data-filter="api" aria-pressed="false">
                                API Gateway
                            </button>
                            <button type="button" class="servicio-btn" data-filter="link" aria-pressed="false">
                                Link de Pagos
                            </button>
                        </div>

                        <ul class="mb-0 ps-3 hero-panel-list" data-servicio="web">
                            <li><a href="views/games/juegos.php">Pago Básico</a></li>
                            <li><a href="views/plataformas/suscripciones.php">Pagos Mixto</a></li>
                            <li><a href="views/textil/textiles.php">Pago Recurrente</a></li>
                            <li><a href="views/dispersiones/tickets.php">Pago con Dispersion</a></li>
                            <li><a href="views/reservaciones/hotel.php">Pago con Preautorización</a></li>
                            <li><a href="views/reservaciones/hotel.php">Suscripcion</a></li>
                        </ul>

                        <ul class="mb-0 ps-3 hero-panel-list" data-servicio="api" hidden>
                            <li><a href="views/games/juegos.php">Pago Básico</a></li>
                            <li><a href="views/plataformas/suscripciones.php">Recurrencia y Suscripción</a></li>
                            <li><a href="views/dispersiones/tickets.php">Dispersiones</a></li>
                            <li><a href="views/reservaciones/hotel.php">Preautorización</a></li>
                        </ul>

                        <ul class="mb-0 ps-3 hero-panel-list" data-servicio="link" hidden>
                            <li><a href="views/games/juegos.php">Link de Pagos</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>



    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = Array.from(document.querySelectorAll('.servicio-btn'));
            const lists = Array.from(document.querySelectorAll('[data-servicio]'));

            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    const selectedService = button.dataset.filter;
                    const currentList = lists.find(list => !list.hidden);
                    const nextList = lists.find(
                        list => list.dataset.servicio === selectedService
                    );

                    if (!nextList || currentList === nextList) {
                        return;
                    }

                    buttons.forEach(item => {
                        const isActive = item === button;
                        item.classList.toggle('active', isActive);
                        item.setAttribute('aria-pressed', String(isActive));
                    });

                    currentList.classList.add('is-leaving');

                    setTimeout(() => {
                        currentList.hidden = true;
                        currentList.classList.remove('is-leaving');

                        nextList.hidden = false;
                        nextList.classList.add('is-entering');

                        setTimeout(() => {
                            nextList.classList.remove('is-entering');
                        }, 220);
                    }, 180);
                });
            });
        });
    </script>
    <!-- Librería Driver.js: debe cargarse antes del tour -->
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="assets/js/components/driver-tours/tour-index.js"></script>
</body>

</html>