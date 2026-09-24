<?php
session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streaming — Suscripciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <?php $theme_seccion = 'plataformas'; require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../../assets/css/styles-plataformas.css">
    <link rel="stylesheet" href="../../assets/css/styles-code-block.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>
<style>
    /* Streaming — acento morado */
    :root {
        --plat-accent:      #a855f7;
        --plat-accent-rgb:  168, 85, 247;
        --plat-accent-dark: #7c3aed;
    }
</style>
<body>

    <!-- NAVBAR -->
    <?php
        $nav_back_url  = "suscripciones.php";
        $nav_back_text = "Atras";
        $nav_base      = "../../";
        require_once '../../php/navbar.php';
    ?>

    <!-- GAME BANNER -->
    <div class="game-banner">
        <div class="game-banner__tag">
            <i class="bi bi-tv-fill" style="color: rgba(174, 0, 255, 0.96);"></i> Suscripciones Streaming
        </div>
    </div>


    <!-- MAIN LAYOUT -->
    <main class="shop-layout">

        <!-- LEFT: Products Panel -->
        <section class="products-panel" id="productsPanel">

            <!-- NETFLIX -->
            <div class="section-block">
                <div class="platform-header">
                    <img src="../../assets/implataformas/streaming/netflix-icon.svg" alt="Netflix">
                    <span>Netflix</span>
                </div>
                <div class="products-grid">

                    <div class="product-card" data-id="1" data-plataforma="Netflix" data-plan="Estándar con Anuncios" data-precio="17900">
                        <div class="product-card__platform">Netflix</div>
                        <div class="product-card__pts">Estándar con Anuncios</div>
                        <div class="product-card__label">1 mes · HD · 2 pantallas</div>
                        <div class="product-card__price">17.900 COP</div>
                    </div>

                    <div class="product-card popular-card" data-id="2" data-plataforma="Netflix" data-plan="Estándar" data-precio="26900">
                        <div class="badge-popular">★ Popular</div>
                        <div class="product-card__platform">Netflix</div>
                        <div class="product-card__pts">Estándar</div>
                        <div class="product-card__label">1 mes · Full HD · 2 pantallas</div>
                        <div class="product-card__price">26.900 COP</div>
                    </div>

                    <div class="product-card" data-id="3" data-plataforma="Netflix" data-plan="Premium" data-precio="36900">
                        <div class="product-card__platform">Netflix</div>
                        <div class="product-card__pts">Premium</div>
                        <div class="product-card__label">1 mes · 4K · 4 pantallas</div>
                        <div class="product-card__price">36.900 COP</div>
                    </div>

                </div>
            </div>

            <!-- HBO MAX -->
            <div class="section-block">
                <div class="platform-header">
                    <img src="../../assets/implataformas/streaming/hbomax-icon.svg" alt="HBO Max">
                    <span>HBO Max</span>
                </div>
                <div class="products-grid">

                    <div class="product-card" data-id="4" data-plataforma="HBO Max" data-plan="Básico" data-precio="19900">
                        <div class="product-card__platform">HBO Max</div>
                        <div class="product-card__pts">Básico</div>
                        <div class="product-card__label">1 mes · HD · 2 pantallas</div>
                        <div class="product-card__price">19.900 COP</div>
                    </div>

                    <div class="product-card" data-id="5" data-plataforma="HBO Max" data-plan="Estándar" data-precio="29900">
                        <div class="product-card__platform">HBO Max</div>
                        <div class="product-card__pts">Estándar</div>
                        <div class="product-card__label">1 mes · Full HD · 3 pantallas</div>
                        <div class="product-card__price">29.900 COP</div>
                    </div>

                    <div class="product-card" data-id="6" data-plataforma="HBO Max" data-plan="Ultimate" data-precio="39900">
                        <div class="product-card__platform">HBO Max</div>
                        <div class="product-card__pts">Ultimate</div>
                        <div class="product-card__label">1 mes · 4K · 4 pantallas</div>
                        <div class="product-card__price">39.900 COP</div>
                    </div>

                </div>
            </div>

            <!-- DISNEY+ -->
            <div class="section-block">
                <div class="platform-header">
                    <img src="../../assets/implataformas/streaming/disney-icon.svg" alt="Disney+">
                    <span>Disney+</span>
                </div>
                <div class="products-grid">

                    <div class="product-card" data-id="7" data-plataforma="Disney+" data-plan="Estándar" data-precio="16900">
                        <div class="product-card__platform">Disney+</div>
                        <div class="product-card__pts">Estándar</div>
                        <div class="product-card__label">1 mes · Full HD · 2 pantallas</div>
                        <div class="product-card__price">16.900 COP</div>
                    </div>

                    <div class="product-card popular-card" data-id="8" data-plataforma="Disney+" data-plan="Premium" data-precio="28900">
                        <div class="badge-popular">★ Popular</div>
                        <div class="product-card__platform">Disney+</div>
                        <div class="product-card__pts">Premium</div>
                        <div class="product-card__label">1 mes · 4K · 4 pantallas</div>
                        <div class="product-card__price">28.900 COP</div>
                    </div>

                    <div class="product-card" data-id="9" data-plataforma="Disney+" data-plan="Duo Premium" data-precio="38900">
                        <div class="product-card__platform">Disney+</div>
                        <div class="product-card__pts">Duo Premium</div>
                        <div class="product-card__label">1 mes · 4K · 4 pantallas</div>
                        <div class="product-card__price">38.900 COP</div>
                    </div>

                </div>
            </div>

        </section>

        <!-- RIGHT: Checkout Panel -->
        <aside class="checkout-panel" id="checkoutPanel">

            <div class="checkout-summary">
                <div class="checkout-product-name" id="checkoutName">📺 Netflix — Estándar</div>

                <div class="checkout-row">
                    <span class="checkout-label">Duración</span>
                    <span class="checkout-delivery">1 mes</span>
                </div>
                <div class="checkout-row">
                    <span class="checkout-label">Renovación</span>
                    <span class="checkout-delivery">Manual</span>
                </div>

                <div class="checkout-divider"></div>

                <div class="checkout-row checkout-total-row">
                    <span class="checkout-label">Total</span>
                    <div class="checkout-pricing">
                        <span class="checkout-final-price" id="checkoutPrice">26.900 COP</span>
                    </div>
                </div>

                <div class="card-required-notice" id="cardRequiredNotice">
                    <i class="bi bi-info-circle-fill"></i>
                    <span><strong>Solo tarjeta.</strong> Esta suscripción guarda tu método de pago para renovarla automáticamente — PSE no permite esto, por eso en la pasarela solo verás la opción de tarjeta (Visa / Mastercard).</span>
                </div>

                <div class="checkout-correo">
                    <label for="usuarioIdInput"><i class="bi bi-envelope-fill fs-6"></i> Correo electrónico</label>
                    <input type="email" id="usuarioIdInput" placeholder="Ingresa tu correo electrónico"
                        value="<?php echo htmlspecialchars($_SESSION['correo'] ?? ''); ?>" autocomplete="off">
                </div>

                <button class="btn-buy" id="btnBuy">
                    <span>Suscribirse ahora</span>
                    <span class="btn-arrow">→</span>
                </button>

                <!-- <div class="trust-badges">
                    <div class="trust-item">🛡️ <span>Garantía de reembolso · P2P</span></div>
                    <div class="trust-item">⚡ <span>Pago rápido · Apple Pay / G Pay</span></div>
                    <div class="trust-item">💬 <span>Asistencia en directo 24/7</span></div>
                </div> -->
            </div>

            <div class="session-instructions">
                <p class="section-label">Instrucciones para crear sesión</p>
                <ol class="session-steps">
                    <li class="session-step">
                        <span class="session-step__num">1</span>
                        <div class="session-step__body">
                            <span class="session-step__title">Digita tu correo electrónico</span>
                            <span class="session-step__desc">Escríbelo en el campo "Correo electrónico" del panel de la derecha; ahí gestionamos el acceso a tu suscripción.</span>
                        </div>
                    </li>
                    <li class="session-step">
                        <span class="session-step__num">2</span>
                        <div class="session-step__body">
                            <span class="session-step__title">Elige el plan</span>
                            <span class="session-step__desc">Selecciona la plataforma y el plan que quieres suscribir en el panel de la izquierda.</span>
                        </div>
                    </li>
                    <li class="session-step">
                        <span class="session-step__num">3</span>
                        <div class="session-step__body">
                            <span class="session-step__title">Crea tu sesión de pago</span>
                            <span class="session-step__desc">Presiona "Suscribirse ahora" para generar tu sesión y completar el pago de forma segura.</span>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="vendor-box">
                <p class="section-label">Designer</p>
                <div class="vendor-info">
                    <div class="vendor-avatar">JM</div>
                    <div>
                        <div class="vendor-name">Jair ✅</div>
                        <div class="vendor-rating">👍 2026 · <a href="#">Evertec Placetopay SAS</a></div>
                    </div>
                </div>
            </div>

        </aside>
    </main>

    <!-- ═══ INTEGRACIÓN PLACETOPAY ═══ -->
    <section class="integration-docs" style="--code-accent:var(--plat-accent); --code-accent-ink:var(--plat-accent-ink); --code-accent-soft:rgba(var(--plat-accent-rgb),0.12); --code-radius-sm:var(--plat-radius-sm); --code-radius-md:var(--plat-radius-md); --code-radius-lg:var(--plat-radius-lg); --code-font:var(--plat-font);">
        <span class="integration-docs__badge"><i class="bi bi-braces"></i> Integración PlacetoPay</span>
        <h3>Así se crea la sesión de pago de esta tienda</h3>
        <p>Cuando presionas <strong>"Suscribirse ahora"</strong>, nuestro backend arma este mismo request y lo envía a <strong>PlacetoPay Web Checkout</strong> con <code>payment.subscribe: true</code>. La respuesta trae un <code>processUrl</code> al que te redirigimos para pagar con tarjeta — es el único método que permite guardarla para las renovaciones.</p>

        <div class="endpoint-bar">
            <span class="method-pill">POST</span>
            <span class="endpoint-url">https://checkout-test.placetopay.com/api/session</span>
            <span class="endpoint-note">ambiente de pruebas</span>
        </div>

        <div class="code-block">
            <div class="code-tabs">
                <button class="code-tab active" data-key="json">JSON</button>
                <button class="code-tab" data-key="php">PHP</button>
                <button class="code-copy"><i class="bi bi-clipboard"></i> Copiar</button>
            </div>
            <pre class="code-panel active" data-key="json"><code>{
  <span class="jk">"locale"</span>: <span class="js">"es_CO"</span>,
  <span class="jk">"auth"</span>: {
    <span class="jk">"login"</span>: <span class="js">"YOUR_LOGIN"</span>,
    <span class="jk">"tranKey"</span>: <span class="js">"TRAN_KEY_CALCULADO"</span>,
    <span class="jk">"nonce"</span>: <span class="js">"Tm9uY2VFbkJhc2U2NA=="</span>,
    <span class="jk">"seed"</span>: <span class="js">"2026-08-25T10:15:32-05:00"</span>
  },
  <span class="cm">// pre-diligencia el correo para que PlacetoPay no lo vuelva a pedir</span>
  <span class="jk">"buyer"</span>: { <span class="jk">"email"</span>: <span class="js">"usuario@correo.com"</span> },
  <span class="jk">"payment"</span>: {
    <span class="jk">"reference"</span>: <span class="js">"SUB-000058"</span>,
    <span class="jk">"description"</span>: <span class="js">"Netflix Estandar"</span>,
    <span class="jk">"amount"</span>: { <span class="jk">"currency"</span>: <span class="js">"COP"</span>, <span class="jk">"total"</span>: <span class="jn">26900</span> },
    <span class="cm">// clave: cobra el primer mes Y tokeniza la tarjeta para el siguiente</span>
    <span class="jk">"subscribe"</span>: <span class="jb">true</span>
  },
  <span class="jk">"expiration"</span>: <span class="js">"2026-08-25T11:15:32-05:00"</span>,
  <span class="jk">"returnUrl"</span>: <span class="js">"https://tu-dominio.com/retorno/retorno_subs.php?sub=58"</span>,
  <span class="jk">"notifyUrl"</span>: <span class="js">"https://tu-dominio.com/php/notify.php"</span>,
  <span class="jk">"ipAddress"</span>: <span class="js">"203.0.113.42"</span>,
  <span class="jk">"userAgent"</span>: <span class="js">"Mozilla/5.0 (Windows NT 10.0; Win64; x64)"</span>
}</code></pre>
            <pre class="code-panel" data-key="php"><code>&lt;?php
<span class="cm">// credenciales fuera del código, nunca hardcodeadas</span>
<span class="cvar">$login</span>     = getenv(<span class="js">'P2P_LOGIN'</span>);
<span class="cvar">$secretKey</span> = getenv(<span class="js">'P2P_SECRET_KEY'</span>);
<span class="cvar">$url</span>       = <span class="js">'https://checkout-test.placetopay.com/api/session'</span>;

<span class="cm">// autenticación: Base64( SHA256( nonce + seed + secretKey ) )</span>
<span class="cvar">$seed</span>     = date(<span class="js">'c'</span>);
<span class="cvar">$nonce</span>    = bin2hex(random_bytes(16));
<span class="cvar">$tranKey</span>  = base64_encode(hash(<span class="js">'sha256'</span>, <span class="cvar">$nonce</span> . <span class="cvar">$seed</span> . <span class="cvar">$secretKey</span>, true));
<span class="cvar">$nonceB64</span> = base64_encode(<span class="cvar">$nonce</span>);

<span class="cm">// cuerpo del request — cobra el primer mes Y tokeniza la tarjeta</span>
<span class="cvar">$data</span> = [
    <span class="jk">'locale'</span> =&gt; <span class="js">'es_CO'</span>,
    <span class="jk">'auth'</span>   =&gt; [
        <span class="jk">'login'</span>   =&gt; <span class="cvar">$login</span>,
        <span class="jk">'tranKey'</span> =&gt; <span class="cvar">$tranKey</span>,
        <span class="jk">'nonce'</span>   =&gt; <span class="cvar">$nonceB64</span>,
        <span class="jk">'seed'</span>    =&gt; <span class="cvar">$seed</span>,
    ],
    <span class="jk">'buyer'</span>  =&gt; [<span class="jk">'email'</span> =&gt; <span class="cvar">$usuario_id</span>],
    <span class="jk">'payment'</span> =&gt; [
        <span class="jk">'reference'</span>   =&gt; <span class="js">'SUB-'</span> . <span class="cvar">$sub_id</span>,
        <span class="jk">'description'</span> =&gt; <span class="cvar">$plataforma</span> . <span class="js">' '</span> . <span class="cvar">$plan</span>,
        <span class="jk">'amount'</span>      =&gt; [<span class="jk">'currency'</span> =&gt; <span class="js">'COP'</span>, <span class="jk">'total'</span> =&gt; (float) <span class="cvar">$precio</span>],
        <span class="jk">'subscribe'</span>   =&gt; true,  <span class="cm">// ← clave: cobra + tokeniza en un solo paso</span>
    ],
    <span class="jk">'expiration'</span> =&gt; date(<span class="js">'c'</span>, strtotime(<span class="js">'+1 hour'</span>)),
    <span class="jk">'returnUrl'</span>  =&gt; app_base_url() . <span class="js">'/retorno/retorno_subs.php?sub='</span> . <span class="cvar">$sub_id</span>,
    <span class="jk">'notifyUrl'</span>  =&gt; <span class="cvar">$notifyUrl</span>,
    <span class="jk">'ipAddress'</span>  =&gt; <span class="cvar">$_SERVER</span>[<span class="js">'REMOTE_ADDR'</span>],
    <span class="jk">'userAgent'</span>  =&gt; <span class="cvar">$_SERVER</span>[<span class="js">'HTTP_USER_AGENT'</span>],
];

<span class="cvar">$ch</span> = curl_init(<span class="cvar">$url</span>);
curl_setopt_array(<span class="cvar">$ch</span>, [
    CURLOPT_POST           =&gt; true,
    CURLOPT_RETURNTRANSFER =&gt; true,
    CURLOPT_HTTPHEADER     =&gt; [<span class="js">'Content-Type: application/json'</span>],
    CURLOPT_POSTFIELDS     =&gt; json_encode(<span class="cvar">$data</span>),
]);

<span class="cvar">$result</span> = json_decode(curl_exec(<span class="cvar">$ch</span>), true);
curl_close(<span class="cvar">$ch</span>);

<span class="cm">// redirige al comprador a la pasarela de PlacetoPay</span>
header(<span class="js">'Location: '</span> . <span class="cvar">$result</span>[<span class="js">'processUrl'</span>]);</code></pre>
        </div>

        <div class="doc-note">
            <span class="doc-note-icon">💡</span>
            <span>Por eso el checkout de esta tienda solo acepta <strong>tarjeta</strong>: PSE no permite guardar un medio de pago para cobros futuros. Cuando el mes termina, el sistema vuelve a cobrar automáticamente sobre la tarjeta tokenizada, sin que tengas que hacer nada.</span>
        </div>

        <a class="integration-docs__link" href="../guias/guia-developer.php#tipos-pago">
            <div>
                <strong>¿Quieres entender esta integración a fondo?</strong>
                <span>Lee la documentación completa sobre tipos de pago y tokenización en Web Checkout.</span>
            </div>
            <i class="bi bi-arrow-right"></i>
        </a>
    </section>

    <!-- JS -->
    <script>
    (function() {

        const products = {
            1: { name: '📺 Netflix — Est. con Anuncios', plataforma: 'Netflix',  plan: 'Estándar con Anuncios', price: '17.900 COP', precio: 17900 },
            2: { name: '📺 Netflix — Estándar',          plataforma: 'Netflix',  plan: 'Estándar',              price: '26.900 COP', precio: 26900 },
            3: { name: '📺 Netflix — Premium',           plataforma: 'Netflix',  plan: 'Premium',               price: '36.900 COP', precio: 36900 },
            4: { name: '🎬 HBO Max — Básico',            plataforma: 'HBO Max',  plan: 'Básico',                price: '19.900 COP', precio: 19900 },
            5: { name: '🎬 HBO Max — Estándar',          plataforma: 'HBO Max',  plan: 'Estándar',              price: '29.900 COP', precio: 29900 },
            6: { name: '🎬 HBO Max — Ultimate',          plataforma: 'HBO Max',  plan: 'Ultimate',              price: '39.900 COP', precio: 39900 },
            7: { name: '✨ Disney+ — Estándar',          plataforma: 'Disney+',  plan: 'Estándar',              price: '16.900 COP', precio: 16900 },
            8: { name: '✨ Disney+ — Premium',           plataforma: 'Disney+',  plan: 'Premium',               price: '28.900 COP', precio: 28900 },
            9: { name: '✨ Disney+ — Duo Premium',       plataforma: 'Disney+',  plan: 'Duo Premium',           price: '38.900 COP', precio: 38900 },
        };

        function updateCheckout(id) {
            const p = products[id];
            if (!p) return;

            document.getElementById('checkoutName').textContent  = p.name;
            document.getElementById('checkoutPrice').textContent = p.price;

        }

        function initCards() {
            const cards = document.querySelectorAll('.product-card');
            if (cards.length === 0) { setTimeout(initCards, 100); return; }

            cards.forEach(function(card) {
                card.addEventListener('click', function() {
                    cards.forEach(function(c) { c.classList.remove('selected'); });
                    card.classList.add('selected');
                    updateCheckout(parseInt(card.getAttribute('data-id')));
                });
            });

            // Selección por defecto: Netflix Estándar
            var def = document.querySelector('.product-card[data-id="2"]');
            if (def) { def.classList.add('selected'); updateCheckout(2); }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCards);
        } else {
            initCards();
        }

        // Buy button
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('#btnBuy');
            if (!btn) return;

            var usuarioId = document.getElementById('usuarioIdInput').value.trim();
            if (!usuarioId) {
                alert('⚠️ Por favor ingresa tu correo antes de continuar.');
                document.getElementById('usuarioIdInput').focus();
                return;
            }

            // Obtener datos de la tarjeta seleccionada
            var selectedCard = document.querySelector('.product-card.selected');
            if (!selectedCard) { alert('⚠️ Selecciona un plan primero.'); return; }

            var plataforma = selectedCard.getAttribute('data-plataforma');
            var plan       = selectedCard.getAttribute('data-plan');
            var precio     = selectedCard.getAttribute('data-precio');

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '../../php/crear_subs.php';

            [['plataforma', plataforma], ['plan', plan], ['precio', precio], ['usuario_id', usuarioId]].forEach(function(pair) {
                var input = document.createElement('input');
                input.type  = 'hidden';
                input.name  = pair[0];
                input.value = pair[1];
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        });

    })();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/validaciones.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="../../assets/js/code-block.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="../../assets/js/components/driver-tours/tour-streaming.js"></script>
</body>
</html>
