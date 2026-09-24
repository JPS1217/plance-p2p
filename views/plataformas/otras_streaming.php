<?php
session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otras Plataformas — Suscripción</title>
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
    /* Otras Plataformas — acento verde */
    :root {
        --plat-accent:      #22c55e;
        --plat-accent-rgb:  34, 197, 94;
        --plat-accent-dark: #16a34a;
    }
</style>
<body>
    <?php
    $nav_back_url  = "suscripciones.php";
    $nav_back_text = "Atras";
    $nav_base      = "../../";
    require_once '../../php/navbar.php';
    ?>

    <div class="game-banner">
        <div class="game-banner__tag">
            <i class="bi bi-tv-fill" style="color: #16a34a;"></i>Otras Plataformas — Suscripción Pura
            <span class="sub-badge"><i class="bi bi-shield-lock-fill"></i> Tokenización</span>
        </div>
    </div>

    <main class="shop-layout">
        <section class="products-panel" id="productsPanel">

            <!-- AMAZON PRIME -->
            <div class="section-block">
                <div class="platform-header">
                    <img src="../../assets/implataformas/streaming/primevideo-icon.svg" alt="Amazon Prime">
                    <span>Amazon Prime</span>
                </div>
                <div class="products-grid">
                    <div class="product-card popular-card" data-id="1" data-servicio="Amazon Prime" data-plan="Mensual" data-precio="9900">
                        <div class="badge-popular">★ Popular</div>
                        <div class="product-card__platform">Amazon Prime</div>
                        <div class="product-card__pts">Mensual</div>
                        <div class="product-card__label">Video · Music · Envíos · 1 mes</div>
                        <div class="product-card__price">9.900 COP <span class="sub-tag">/ mes</span></div>
                    </div>
                    <div class="product-card" data-id="2" data-servicio="Amazon Prime" data-plan="Anual" data-precio="89900">
                        <div class="product-card__platform">Amazon Prime</div>
                        <div class="product-card__pts">Anual</div>
                        <div class="product-card__label">Video · Music · Envíos · 12 meses</div>
                        <div class="product-card__price">89.900 COP <span class="sub-tag">/ año</span></div>
                    </div>
                </div>
            </div>

            <!-- CRUNCHYROLL -->
            <div class="section-block">
                <div class="platform-header">
                    <img src="../../assets/implataformas/streaming/crunchyroll-icon.svg" alt="Crunchyroll">
                    <span>Crunchyroll</span>
                </div>
                <div class="products-grid">
                    <div class="product-card" data-id="3" data-servicio="Crunchyroll" data-plan="Fan" data-precio="12900">
                        <div class="product-card__platform">Crunchyroll</div>
                        <div class="product-card__pts">Fan</div>
                        <div class="product-card__label">Anime HD · Sin anuncios · 1 pantalla</div>
                        <div class="product-card__price">12.900 COP <span class="sub-tag">/ mes</span></div>
                    </div>
                    <div class="product-card popular-card" data-id="4" data-servicio="Crunchyroll" data-plan="Mega Fan" data-precio="19900">
                        <div class="badge-popular">★ Popular</div>
                        <div class="product-card__platform">Crunchyroll</div>
                        <div class="product-card__pts">Mega Fan</div>
                        <div class="product-card__label">Anime 4K · Sin anuncios · 4 pantallas</div>
                        <div class="product-card__price">19.900 COP <span class="sub-tag">/ mes</span></div>
                    </div>
                </div>
            </div>

            <!-- STAR+ -->
            <div class="section-block">
                <div class="platform-header">
                    <img src="../../assets/implataformas/streaming/starplus-icon.svg" alt="Star+">
                    <span>Star+</span>
                </div>
                <div class="products-grid">
                    <div class="product-card" data-id="5" data-servicio="Star+" data-plan="Estándar" data-precio="19900">
                        <div class="product-card__platform">Star+</div>
                        <div class="product-card__pts">Estándar</div>
                        <div class="product-card__label">Series · Deportes · Full HD</div>
                        <div class="product-card__price">19.900 COP <span class="sub-tag">/ mes</span></div>
                    </div>
                    <div class="product-card popular-card" data-id="6" data-servicio="Star+" data-plan="Combo+" data-precio="29900">
                        <div class="badge-popular">★ Popular</div>
                        <div class="product-card__platform">Star+</div>
                        <div class="product-card__pts">Combo+</div>
                        <div class="product-card__label">Star+ y Disney+ · 4K · 4 pantallas</div>
                        <div class="product-card__price">29.900 COP <span class="sub-tag">/ mes</span></div>
                    </div>
                </div>
            </div>

        </section>

        <!-- CHECKOUT -->
        <aside class="checkout-panel" id="checkoutPanel">
            <div class="checkout-summary">
                <div class="checkout-product-name" id="checkoutName">🛒 Amazon Prime — Mensual</div>
                <div class="checkout-row">
                    <span class="checkout-label">Tipo</span>
                    <span class="checkout-delivery">Suscripción</span>
                </div>
                <div class="checkout-row">
                    <span class="checkout-label">Cobro</span>
                    <span class="checkout-delivery">Primer mes + tokenización</span>
                </div>
                <div class="checkout-divider"></div>
                <div class="checkout-row checkout-total-row">
                    <span class="checkout-label">Total</span>
                    <div class="checkout-pricing">
                        <span class="checkout-final-price" id="checkoutPrice">9.900 COP</span>
                    </div>
                </div>
                <div class="sub-info" id="subInfo">
                    <i class="bi bi-shield-lock-fill"></i>
                    <span>Tu tarjeta será tokenizada de forma segura para futuros cobros. El primer mes se cobra al suscribirse.</span>
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
                    <div class="trust-item">🔐 <span>Tarjeta tokenizada de forma segura</span></div>
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
                        <div class="vendor-rating">👍 2026 · <a href="#" style="color:#22c55e;">Evertec Placetopay SAS</a></div>
                    </div>
                </div>
            </div>
        </aside>
    </main>

    <!-- ═══ INTEGRACIÓN PLACETOPAY ═══ -->
    <section class="integration-docs" style="--code-accent:var(--plat-accent); --code-accent-ink:var(--plat-accent-ink); --code-accent-soft:rgba(var(--plat-accent-rgb),0.12); --code-radius-sm:var(--plat-radius-sm); --code-radius-md:var(--plat-radius-md); --code-radius-lg:var(--plat-radius-lg); --code-font:var(--plat-font);">
        <span class="integration-docs__badge"><i class="bi bi-braces"></i> Integración PlacetoPay</span>
        <h3>Así se crea la sesión de pago de esta tienda</h3>
        <p>Cuando presionas <strong>"Suscribirse ahora"</strong>, nuestro backend arma este mismo request y lo envía a <strong>PlacetoPay Web Checkout</strong> usando el bloque <code>subscription</code> — a diferencia de un cobro normal, aquí <strong>no se cobra nada todavía</strong>, solo se guarda tu tarjeta de forma segura para el primer cobro.</p>

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
  <span class="jk">"buyer"</span>: { <span class="jk">"email"</span>: <span class="js">"usuario@correo.com"</span> },
  <span class="cm">// "subscription" (sin "payment"): solo tokeniza, no cobra nada ahora</span>
  <span class="jk">"subscription"</span>: {
    <span class="jk">"reference"</span>: <span class="js">"SUB-000091"</span>,
    <span class="jk">"description"</span>: <span class="js">"Amazon Prime Mensual"</span>
  },
  <span class="jk">"expiration"</span>: <span class="js">"2026-08-25T10:45:32-05:00"</span>,
  <span class="jk">"returnUrl"</span>: <span class="js">"https://tu-dominio.com/retorno/retorno_suscription.php?sub=91"</span>,
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

<span class="cm">// cuerpo del request — suscripción pura, NO cobra</span>
<span class="cvar">$data</span> = [
    <span class="jk">'locale'</span> =&gt; <span class="js">'es_CO'</span>,
    <span class="jk">'auth'</span>   =&gt; [
        <span class="jk">'login'</span>   =&gt; <span class="cvar">$login</span>,
        <span class="jk">'tranKey'</span> =&gt; <span class="cvar">$tranKey</span>,
        <span class="jk">'nonce'</span>   =&gt; <span class="cvar">$nonceB64</span>,
        <span class="jk">'seed'</span>    =&gt; <span class="cvar">$seed</span>,
    ],
    <span class="jk">'buyer'</span> =&gt; [<span class="jk">'email'</span> =&gt; <span class="cvar">$usuario_id</span>],
    <span class="cm">// "subscription" en vez de "payment": tokeniza sin cobrar</span>
    <span class="jk">'subscription'</span> =&gt; [
        <span class="jk">'reference'</span>   =&gt; <span class="js">'SUB-'</span> . <span class="cvar">$sub_id</span>,
        <span class="jk">'description'</span> =&gt; <span class="cvar">$servicio</span> . <span class="js">' '</span> . <span class="cvar">$plan</span>,
    ],
    <span class="jk">'expiration'</span> =&gt; date(<span class="js">'c'</span>, strtotime(<span class="js">'+30 minutes'</span>)),
    <span class="jk">'returnUrl'</span>  =&gt; app_base_url() . <span class="js">'/retorno/retorno_suscription.php?sub='</span> . <span class="cvar">$sub_id</span>,
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
            <span>Como aquí <strong>no hay <code>payment</code></strong>, PlacetoPay no cobra nada al crear la sesión — solo tokeniza la tarjeta. El primer cobro real (y los siguientes) los dispara nuestro backend por separado, contra la tarjeta ya guardada.</span>
        </div>

        <a class="integration-docs__link" href="../guias/guia-developer.php#tipos-pago">
            <div>
                <strong>¿Quieres entender esta integración a fondo?</strong>
                <span>Lee la documentación completa sobre tipos de pago y tokenización en Web Checkout.</span>
            </div>
            <i class="bi bi-arrow-right"></i>
        </a>
    </section>

    <script>
    (function() {
        const products = {
            1: { name: '🛒 Amazon Prime — Mensual', servicio: 'Amazon Prime',  plan: 'Mensual',  precio: 9900  },
            2: { name: '🛒 Amazon Prime — Anual',   servicio: 'Amazon Prime',  plan: 'Anual',    precio: 89900 },
            3: { name: '🍥 Crunchyroll — Fan',       servicio: 'Crunchyroll',   plan: 'Fan',      precio: 12900 },
            4: { name: '🍥 Crunchyroll — Mega Fan',  servicio: 'Crunchyroll',   plan: 'Mega Fan', precio: 19900 },
            5: { name: '⭐ Star+ — Estándar',        servicio: 'Star+',         plan: 'Estándar', precio: 19900 },
            6: { name: '⭐ Star+ — Combo+',          servicio: 'Star+',         plan: 'Combo+',   precio: 29900 },
        };

        function updateCheckout(id) {
            const p = products[id];
            if (!p) return;
            document.getElementById('checkoutName').textContent  = p.name;
            document.getElementById('checkoutPrice').textContent = p.precio.toLocaleString('es-CO') + ' COP';
        }

        function initCards() {
            const cards = document.querySelectorAll('.product-card');
            if (cards.length === 0) { setTimeout(initCards, 100); return; }
            cards.forEach(function(card) {
                card.addEventListener('click', function() {
                    cards.forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');
                    updateCheckout(parseInt(card.getAttribute('data-id')));
                });
            });
            var def = document.querySelector('.product-card[data-id="1"]');
            if (def) { def.classList.add('selected'); updateCheckout(1); }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCards);
        } else { initCards(); }

        document.addEventListener('click', function(e) {
            var btn = e.target.closest('#btnBuy');
            if (!btn) return;

            var usuarioId = document.getElementById('usuarioIdInput').value.trim();
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!usuarioId || !emailRegex.test(usuarioId)) {
                alert('⚠️ Por favor ingresa un correo electrónico válido.');
                document.getElementById('usuarioIdInput').focus();
                return;
            }

            var selectedCard = document.querySelector('.product-card.selected');
            if (!selectedCard) { alert('⚠️ Selecciona un plan primero.'); return; }

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '../../php/crear_suscription.php';

            [['servicio', selectedCard.getAttribute('data-servicio')],
             ['plan',     selectedCard.getAttribute('data-plan')],
             ['precio',   selectedCard.getAttribute('data-precio')],
             ['usuario_id', usuarioId]].forEach(function(pair) {
                var input = document.createElement('input');
                input.type = 'hidden'; input.name = pair[0]; input.value = pair[1];
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        });
    })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/code-block.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="../../assets/js/components/driver-tours/tour-otras-streaming.js"></script>
</body>
</html>
