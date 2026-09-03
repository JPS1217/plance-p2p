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

    <?php $theme_seccion = 'home'; require_once __DIR__ . '/php/theme.php'; ?>

    <link rel="stylesheet"
        href="assets/css/pages/index.css?v=<?php echo filemtime(__DIR__ . '/assets/css/pages/index.css'); ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="assets/css/components/driver-theme.css?v=<?php echo filemtime(__DIR__ . '/assets/css/components/driver-theme.css'); ?>">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php
    $show_tutorial_help = true;
    $nav_back_url  = 'home.php';
    $nav_back_text = 'Atrás';
    $nav_base      = '';
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

        <section class="py-0 resources-section">
            <div class="hero-intro">
                <div class="resources-badge"><i class="bi bi-stars"></i> Centro de recursos</div>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4" id="tarjetas">
                <div class="col">
                    <div class="resource-card-wrap">
                        <a href="sesiones.php" id="sesiones" class="resource-card">
                            <div class="resource-icon">
                                <i class="bi bi-lightbulb-fill"></i>
                            </div>
                            <h3>Ejemplos de integraciones</h3>
                            <p>Aquí podrás ver como seria el proceso de compra dentro del sitio web de un comercio y que
                                tipo de integración con Place to Pay se asocia ese flujo.</p>
                            <span class="resource-cta">Ver ejemplos <i class="bi bi-arrow-right"></i></span>
                        </a>
                        <div class="resource-help-wrap">
                            <button class="resource-help" type="button"
                                aria-label="Más información sobre ejemplos de integraciones"
                                aria-describedby="help-sesiones">
                                <i class="bi bi-question-lg" aria-hidden="true"></i>
                            </button>
                            <div class="resource-help-popover" id="help-sesiones" role="tooltip">
                                <strong>¿Qué encontrarás aquí?</strong>
                                <p>Podrás recorrer una compra como la que viviría un cliente: elegir un producto,
                                    iniciar el pago y observar qué ocurre detrás de cada paso hasta recibir la respuesta
                                    de Place to Pay.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="resource-card-wrap">
                        <a href="views/guias/guia.php" id="guia-user" class="resource-card">
                            <div class="resource-icon">
                                <i class="bi bi-book-half"></i>
                            </div>
                            <h3>Guía de usuario</h3>
                            <p>Aprende sobre PlacetoPay y conoce los principales conceptos, términos y
                                soluciones relacionados con la integración de comercios, pagos, suscripciones y
                                transacciones en la plataforma.</p>
                            <span class="resource-cta">Leer guía <i class="bi bi-arrow-right"></i></span>
                        </a>
                        <div class="resource-help-wrap">
                            <button class="resource-help" type="button"
                                aria-label="Más información sobre la guía de usuario" aria-describedby="help-guia-user">
                                <i class="bi bi-question-lg" aria-hidden="true"></i>
                            </button>
                            <div class="resource-help-popover" id="help-guia-user" role="tooltip">
                                <strong>¿Qué encontrarás aquí?</strong>
                                <p>Es un punto de partida para familiarizarte con el vocabulario y las decisiones
                                    habituales de un pago digital, incluso si todavía no sabes cómo se conectan los
                                    sistemas.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="resource-card-wrap">
                        <a href="views/guias/guia-dev/lab_index.php" id="guia-developer" class="resource-card">
                            <div class="resource-icon">
                                <i class="bi bi-code-slash"></i>
                            </div>
                            <h3>Guía developer</h3>
                            <p>Accede a la parte técnica de la integración, estructura del proyecto y
                                recursos clave para implementar los servicios de PlacetoPay de forma ordenada.</p>
                            <span class="resource-cta">Interactuar con la guía <i class="bi bi-arrow-right"></i></span>
                        </a>
                        <div class="resource-help-wrap">
                            <button class="resource-help" type="button"
                                aria-label="Más información sobre la guía developer"
                                aria-describedby="help-guia-developer">
                                <i class="bi bi-question-lg" aria-hidden="true"></i>
                            </button>
                            <div class="resource-help-popover" id="help-guia-developer" role="tooltip">
                                <strong>¿Qué encontrarás aquí?</strong>
                                <p>Cuando quieras pasar de entender el flujo a construirlo, aquí verás la estructura
                                    técnica, los recursos necesarios y la forma de llevar la integración a tu propio
                                    comercio.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <!-- Librería Driver.js: debe cargarse antes del tour -->
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="assets/js/components/driver-tours/tour-index.js"></script>
</body>

</html>
