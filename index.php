<?php
session_start();
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
    $nav_back_url = 'index.php';
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

        <!-- ══════════════════════════════════════════════════════
             CATEGORÍA 1 — Quiero hacer una integración
             ══════════════════════════════════════════════════════ -->
        <section class="cat-section" aria-labelledby="cat-integracion-title">
            <header class="cat-head">
                <div>
                    <h2 class="cat-title" id="cat-integracion-title">Quiero hacer una integración</h2>
                    <p class="cat-sub">Elige el tipo de cobro que necesitas y arma tu petición paso a paso.</p>
                </div>
            </header>

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

        <!-- ══════════════════════════════════════════════════════
             CATEGORÍA 2 — Qué necesito para integrarme (FAQ)
             ══════════════════════════════════════════════════════ -->
        <section class="cat-section" aria-labelledby="cat-faq-title">
            <header class="cat-head">
                <div>
                    <h2 class="cat-title" id="cat-faq-title">¿Qué necesito para integrarme?</h2>
                    <p class="cat-sub">Preguntas frecuentes — toca una pregunta para ver la respuesta.</p>
                </div>
            </header>

            <div class="faq-list">
                <?php
                $faqs = [
                    [
                        'q' => '¿Qué es una integración?',
                        'a' => 'Es la conexión entre tu aplicación (tu tienda, tu app o tu plataforma) y Place to Pay para poder cobrar en línea. En la práctica, tu sistema le envía una petición a Place to Pay con los datos del pago y Place to Pay se encarga de procesar el cobro y devolverte el resultado.'
                    ],
                    [
                        'q' => '¿Quién desarrolla la integración?',
                        'a' => 'La desarrolla el equipo técnico del comercio (tú o tus programadores). Place to Pay entrega la documentación, las credenciales de prueba y los endpoints; tu equipo escribe el código que arma las peticiones y procesa las respuestas dentro de tu propia aplicación.'
                    ],
                    [
                        'q' => '¿Qué hace mi aplicación?',
                        'a' => 'Tu aplicación reúne los datos del pago (monto, referencia, comprador), firma la petición con tus credenciales y la envía a Place to Pay. Luego recibe la respuesta —aprobado, rechazado o pendiente— y actúa en consecuencia: muestra el resultado al cliente y entrega el producto o servicio.'
                    ],
                    [
                        'q' => '¿Qué hace Place to Pay?',
                        'a' => 'Place to Pay es la pasarela de pagos: recibe tu petición, presenta al cliente los medios de pago (tarjeta, PSE, etc.), procesa la transacción con el banco y te devuelve el resultado. Se encarga de la seguridad, el cumplimiento y la comunicación con las entidades financieras para que tú no tengas que hacerlo.'
                    ],
                    [
                        'q' => '¿Dónde se utiliza la información mostrada en esta plataforma?',
                        'a' => 'Los ejemplos, guías y peticiones de esta plataforma son material de aprendizaje: sirven para que entiendas cómo se construye cada tipo de integración antes de llevarla a tu propio proyecto. Las credenciales y URLs que ves aquí apuntan al ambiente de PRUEBAS de Place to Pay, no a producción.'
                    ],
                    [
                        'q' => '¿Necesito saber programar?',
                        'a' => 'Para entender los conceptos y recorrer los ejemplos, no. Para implementar la integración en tu propia aplicación, sí: necesitas conocimientos básicos de desarrollo web (peticiones HTTP, JSON y el lenguaje de tu backend, como PHP). Esta plataforma está pensada para acompañarte en ese aprendizaje.'
                    ],
                    [
                        'q' => '¿Qué es una solicitud (request)?',
                        'a' => 'Es el mensaje que tu aplicación le envía a Place to Pay para pedir algo —por ejemplo, iniciar un cobro. Viaja en formato JSON e incluye la autenticación (tus credenciales firmadas) y los datos del pago: monto, moneda, referencia y datos del comprador.'
                    ],
                    [
                        'q' => '¿Qué es una respuesta (response)?',
                        'a' => 'Es el mensaje que Place to Pay le devuelve a tu aplicación después de procesar tu solicitud. También viaja en JSON e indica el estado de la operación (aprobada, rechazada o pendiente), un identificador de la transacción y la información necesaria para continuar el flujo o mostrarle el resultado al cliente.'
                    ],
                ];
                foreach ($faqs as $i => $faq):
                    $panelId = 'faq-panel-' . $i;
                    $btnId   = 'faq-btn-' . $i;
                ?>
                <div class="faq-item">
                    <button type="button" class="faq-question" id="<?= $btnId ?>"
                        aria-expanded="false" aria-controls="<?= $panelId ?>">
                        <span class="faq-q-text"><?= htmlspecialchars($faq['q']) ?></span>
                        <i class="bi bi-plus-lg faq-icon" aria-hidden="true"></i>
                    </button>
                    <div class="faq-answer" id="<?= $panelId ?>" role="region"
                        aria-labelledby="<?= $btnId ?>" hidden>
                        <p><?= htmlspecialchars($faq['a']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <p class="faq-guias-cta">
                Consulta nuestras guías para más información.
                <a href="views/guias/guia.php">Ir a las guías <i class="bi bi-arrow-right"></i></a>
            </p>
        </section>

        <!-- ══════════════════════════════════════════════════════
             CATEGORÍA 3 — Ejemplos de integración
             ══════════════════════════════════════════════════════ -->
        <section class="cat-section" aria-labelledby="cat-ejemplos-title">
            <header class="cat-head">
                <div>
                    <h2 class="cat-title" id="cat-ejemplos-title">Ejemplos de integración</h2>
                    <p class="cat-sub">Explora las integraciones de Place to Pay por servicio.</p>
                </div>
            </header>

            <div class="examples-panel" id="lista-integraciones">
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

                <ul class="examples-list" data-servicio="web">
                    <li><a href="views/games/juegos.php">Pago Básico</a></li>
                    <li><a href="views/plataformas/suscripciones.php">Pagos Mixto</a></li>
                    <li><a href="views/textil/textiles.php">Pago Recurrente</a></li>
                    <li><a href="views/dispersiones/tickets.php">Pago con Dispersión</a></li>
                    <li><a href="views/reservaciones/hotel.php">Pago con Preautorización</a></li>
                    <li><a href="views/reservaciones/hotel.php">Suscripción</a></li>
                </ul>

                <ul class="examples-list" data-servicio="api" hidden>
                    <li><a href="views/games/juegos.php">Pago Básico</a></li>
                    <li><a href="views/plataformas/suscripciones.php">Recurrencia y Suscripción</a></li>
                    <li><a href="views/dispersiones/tickets.php">Dispersiones</a></li>
                    <li><a href="views/reservaciones/hotel.php">Preautorización</a></li>
                </ul>

                <ul class="examples-list" data-servicio="link" hidden>
                    <li><a href="views/games/juegos.php">Link de Pagos</a></li>
                </ul>
            </div>
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // ── Filtro de ejemplos por servicio ──
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

            // ── FAQ acordeón (click para expandir; uno abierto a la vez) ──
            const faqButtons = Array.from(document.querySelectorAll('.faq-question'));
            faqButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const panel = document.getElementById(btn.getAttribute('aria-controls'));
                    const isOpen = btn.getAttribute('aria-expanded') === 'true';

                    // Cerrar los demás
                    faqButtons.forEach(other => {
                        if (other !== btn) {
                            other.setAttribute('aria-expanded', 'false');
                            other.classList.remove('open');
                            const p = document.getElementById(other.getAttribute('aria-controls'));
                            if (p) { p.hidden = true; p.classList.remove('show'); }
                        }
                    });

                    // Alternar el actual
                    if (isOpen) {
                        btn.setAttribute('aria-expanded', 'false');
                        btn.classList.remove('open');
                        panel.classList.remove('show');
                        panel.hidden = true;
                    } else {
                        btn.setAttribute('aria-expanded', 'true');
                        btn.classList.add('open');
                        panel.hidden = false;
                        // reflow para animar
                        void panel.offsetHeight;
                        panel.classList.add('show');
                    }
                });
            });
        });
    </script>
    <!-- Librería Driver.js: debe cargarse antes del tour -->
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="assets/js/components/driver-tours/tour-index.js"></script>
</body>

</html>