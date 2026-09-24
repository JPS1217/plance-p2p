<?php
session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IA's — Planes de Inteligencia Artificial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/estilos.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <?php $theme_seccion = 'plataformas'; require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../../assets/css/styles-plataformas.css">
    <link rel="stylesheet" href="../../assets/css/styles-code-block.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>
<style>
    /* IA's — acento naranja */
    :root {
        --plat-accent:      hsl(29, 99%, 45%);
        --plat-accent-rgb:  228, 111, 1;
        --plat-accent-dark: rgb(255, 187, 0);
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
            <i class="bi bi-robot" style="color:hsl(29, 99%, 45%) ;"></i> IA's — Planes de Inteligencia Artificial
            <span class="rec-badge"><i class="fa-solid fa-globe" style="color:hsl(29, 99%, 45%) ;"></i> Suscripcion Recurrente</span>
        </div>
        <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
            <div class="period-selector" id="periodSelector">
                <button class="period-btn active" id="btnMensual" onclick="setPeriod('mensual')">Mensual</button>
                <button class="period-btn" id="btnAnual" onclick="setPeriod('anual')">Anual</button>
            </div>
        </div>
    </div>

    <main class="shop-layout">
        <section class="products-panel" id="productsPanel">

            <!-- CLAUDE -->
            <div class="section-block">
                <div class="platform-header">
                    <img src="../../assets/implataformas/ia/claude-icon.svg" alt="Claude">
                    <span>Claude</span>
                </div>
                <div class="products-grid">
                    <div class="product-card popular-card"
                         data-id="1" data-servicio="Claude" data-plan="Pro"
                         data-precio-mensual="22900" data-precio-anual="229000">
                        <div class="badge-popular">★ Popular</div>
                        <div class="product-card__platform">Claude</div>
                        <div class="product-card__pts">Pro</div>
                        <div class="product-card__label">Uso extendido · Proyectos · Prioridad</div>
                        <div class="product-card__price price-mensual">22.900 COP <span class="rec-tag">/ mes</span></div>
                        <div class="product-card__price price-anual">229.000 COP <span class="rec-tag">/ año</span></div>
                    </div>
                    <div class="product-card"
                         data-id="2" data-servicio="Claude" data-plan="Max"
                         data-precio-mensual="109000" data-precio-anual="1090000">
                        <div class="product-card__platform">Claude</div>
                        <div class="product-card__pts">Max</div>
                        <div class="product-card__label">5x más uso · Acceso anticipado</div>
                        <div class="product-card__price price-mensual">109.000 COP <span class="rec-tag">/ mes</span></div>
                        <div class="product-card__price price-anual">1.090.000 COP <span class="rec-tag">/ año</span></div>
                    </div>
                </div>
            </div>

            <!-- CHATGPT -->
            <div class="section-block">
                <div class="platform-header">
                    <img src="../../assets/implataformas/ia/chatgpt-icon.svg" alt="ChatGPT">
                    <span>ChatGPT</span>
                </div>
                <div class="products-grid">
                    <div class="product-card"
                         data-id="3" data-servicio="ChatGPT" data-plan="Go"
                         data-precio-mensual="8900" data-precio-anual="89000">
                        <div class="product-card__platform">ChatGPT</div>
                        <div class="product-card__pts">Go</div>
                        <div class="product-card__label">Acceso básico · GPT-4o mini</div>
                        <div class="product-card__price price-mensual">8.900 COP <span class="rec-tag">/ mes</span></div>
                        <div class="product-card__price price-anual">89.000 COP <span class="rec-tag">/ año</span></div>
                    </div>
                    <div class="product-card popular-card"
                         data-id="4" data-servicio="ChatGPT" data-plan="Plus"
                         data-precio-mensual="22900" data-precio-anual="229000">
                        <div class="badge-popular">★ Popular</div>
                        <div class="product-card__platform">ChatGPT</div>
                        <div class="product-card__pts">Plus</div>
                        <div class="product-card__label">GPT-4o · DALL·E · Plugins</div>
                        <div class="product-card__price price-mensual">22.900 COP <span class="rec-tag">/ mes</span></div>
                        <div class="product-card__price price-anual">229.000 COP <span class="rec-tag">/ año</span></div>
                    </div>
                    <div class="product-card"
                         data-id="5" data-servicio="ChatGPT" data-plan="Pro"
                         data-precio-mensual="219000" data-precio-anual="2190000">
                        <div class="product-card__platform">ChatGPT</div>
                        <div class="product-card__pts">Pro</div>
                        <div class="product-card__label">Uso ilimitado · o1 Pro · Acceso total</div>
                        <div class="product-card__price price-mensual">219.000 COP <span class="rec-tag">/ mes</span></div>
                        <div class="product-card__price price-anual">2.190.000 COP <span class="rec-tag">/ año</span></div>
                    </div>
                </div>
            </div>

        </section>

        <!-- CHECKOUT -->
        <aside class="checkout-panel" id="checkoutPanel">
            <div class="checkout-summary">
                <div class="checkout-product-name" id="checkoutName">🤖 Claude — Pro</div>
                <div class="checkout-row">
                    <span class="checkout-label">Periodicidad</span>
                    <span class="checkout-delivery" id="checkoutPeriod">Mensual</span>
                </div>
                <div class="checkout-row">
                    <span class="checkout-label">Duración</span>
                    <span class="checkout-delivery" id="checkoutDuration">12 meses</span>
                </div>
                <div class="checkout-divider"></div>
                <div class="checkout-row checkout-total-row">
                    <span class="checkout-label">Total</span>
                    <div class="checkout-pricing">
                        <span class="checkout-final-price" id="checkoutPrice">22.900 COP</span>
                    </div>
                </div>
                <div class="recurring-info">
                    <i class="bi bi-arrow-repeat"></i>
                    <span id="recurringMsg">Cobro automático mensual durante 12 meses.</span>
                </div>
                <div class="checkout-correo">
                    <label for="usuarioIdInput"><i class="bi bi-envelope-fill fs-6"></i> Correo electrónico</label>
                    <input type="email" id="usuarioIdInput" placeholder="Tu correo electronico"
                           value="<?php echo htmlspecialchars($_SESSION['correo'] ?? ''); ?>" autocomplete="off">
                </div>

                <button class="btn-buy" id="btnBuy">
                    <span>Suscribirse ahora</span>
                    <span class="btn-arrow">→</span>
                </button>
                <!-- <div class="trust-badges">
                    <div class="trust-item">🛡️ <span>Garantía de reembolso · P2P</span></div>
                    <div class="trust-item">🔄 <span>Cobro recurrente automático</span></div>
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
                            <span class="session-step__desc">Selecciona el servicio y el plan que quieres suscribir en el panel de la izquierda.</span>
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
        <p>Cuando presionas <strong>"Suscribirse ahora"</strong>, nuestro backend arma este mismo request y lo envía a <strong>PlacetoPay Web Checkout</strong> con un bloque <code>recurring</code> dentro de <code>payment</code>. Se cobra el primer periodo <strong>ahora mismo</strong> y PlacetoPay programa los cobros siguientes automáticamente, sin volver a redirigirte.</p>

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
  <span class="jk">"payment"</span>: {
    <span class="jk">"reference"</span>: <span class="js">"SREC-000044"</span>,
    <span class="jk">"description"</span>: <span class="js">"Claude Pro"</span>,
    <span class="jk">"amount"</span>: { <span class="jk">"currency"</span>: <span class="js">"COP"</span>, <span class="jk">"total"</span>: <span class="jn">22900</span> },
    <span class="cm">// clave: programa el cobro automático de los siguientes periodos</span>
    <span class="jk">"recurring"</span>: {
      <span class="jk">"periodicity"</span>: <span class="js">"M"</span>,
      <span class="jk">"interval"</span>: <span class="js">"1"</span>,
      <span class="jk">"nextPayment"</span>: <span class="js">"2026-09-25"</span>,
      <span class="jk">"maxPeriods"</span>: <span class="jn">12</span>
    }
  },
  <span class="jk">"expiration"</span>: <span class="js">"2026-08-25T11:15:32-05:00"</span>,
  <span class="jk">"returnUrl"</span>: <span class="js">"https://tu-dominio.com/retorno/retorno_suscription_rec.php?rec=44"</span>,
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

<span class="cm">// según el plan elegido (mensual o anual) cambia la periodicidad</span>
<span class="fn">if</span> (<span class="cvar">$periodicidad</span> === <span class="js">'Y'</span>) {
    <span class="cvar">$nextPayment</span> = date(<span class="js">'Y-m-d'</span>, strtotime(<span class="js">'+1 year'</span>));
    <span class="cvar">$maxPeriods</span>  = 1;
    <span class="cvar">$interval</span>    = <span class="js">'12'</span>;
} <span class="fn">else</span> {
    <span class="cvar">$nextPayment</span> = date(<span class="js">'Y-m-d'</span>, strtotime(<span class="js">'+1 month'</span>));
    <span class="cvar">$maxPeriods</span>  = 12;
    <span class="cvar">$interval</span>    = <span class="js">'1'</span>;
}

<span class="cvar">$data</span> = [
    <span class="jk">'locale'</span> =&gt; <span class="js">'es_CO'</span>,
    <span class="jk">'auth'</span>   =&gt; [
        <span class="jk">'login'</span>   =&gt; <span class="cvar">$login</span>,
        <span class="jk">'tranKey'</span> =&gt; <span class="cvar">$tranKey</span>,
        <span class="jk">'nonce'</span>   =&gt; <span class="cvar">$nonceB64</span>,
        <span class="jk">'seed'</span>    =&gt; <span class="cvar">$seed</span>,
    ],
    <span class="jk">'buyer'</span> =&gt; [<span class="jk">'email'</span> =&gt; <span class="cvar">$usuario_id</span>],
    <span class="jk">'payment'</span> =&gt; [
        <span class="jk">'reference'</span>   =&gt; <span class="js">'SREC-'</span> . <span class="cvar">$rec_id</span>,
        <span class="jk">'description'</span> =&gt; <span class="cvar">$servicio</span> . <span class="js">' '</span> . <span class="cvar">$plan</span>,
        <span class="jk">'amount'</span>      =&gt; [<span class="jk">'currency'</span> =&gt; <span class="js">'COP'</span>, <span class="jk">'total'</span> =&gt; (float) <span class="cvar">$precio</span>],
        <span class="jk">'recurring'</span>   =&gt; [
            <span class="jk">'periodicity'</span> =&gt; <span class="cvar">$periodicidad</span>,  <span class="cm">// 'M' o 'Y'</span>
            <span class="jk">'interval'</span>    =&gt; <span class="cvar">$interval</span>,
            <span class="jk">'nextPayment'</span> =&gt; <span class="cvar">$nextPayment</span>,
            <span class="jk">'maxPeriods'</span>  =&gt; <span class="cvar">$maxPeriods</span>,
        ],
    ],
    <span class="jk">'expiration'</span> =&gt; date(<span class="js">'c'</span>, strtotime(<span class="js">'+1 hour'</span>)),
    <span class="jk">'returnUrl'</span>  =&gt; app_base_url() . <span class="js">'/retorno/retorno_suscription_rec.php?rec='</span> . <span class="cvar">$rec_id</span>,
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
            <span>Si eliges <strong>Mensual</strong>, <code>maxPeriods: 12</code> programa hasta un año de cobros automáticos; con <strong>Anual</strong>, el plan cobra una sola vez al año (<code>maxPeriods: 1</code>, <code>interval: 12</code>). En ambos casos puedes cancelar la recurrencia desde tu perfil.</span>
        </div>

        <a class="integration-docs__link" href="../guias/guia-developer.php#tipos-pago">
            <div>
                <strong>¿Quieres entender esta integración a fondo?</strong>
                <span>Lee la documentación completa sobre tipos de pago y cobros recurrentes en Web Checkout.</span>
            </div>
            <i class="bi bi-arrow-right"></i>
        </a>
    </section>

    <input type="hidden" id="currentPeriod" value="mensual">

    <script>
    (function() {
        const products = {
            1: { name: '🤖 Claude — Pro',     servicio: 'Claude',   plan: 'Pro',   precioM: 22900,   precioA: 229000 },
            2: { name: '🤖 Claude — Max',     servicio: 'Claude',   plan: 'Max',   precioM: 109000,  precioA: 1090000 },
            3: { name: '💬 ChatGPT — Go',     servicio: 'ChatGPT',  plan: 'Go',    precioM: 8900,    precioA: 89000 },
            4: { name: '💬 ChatGPT — Plus',   servicio: 'ChatGPT',  plan: 'Plus',  precioM: 22900,   precioA: 229000 },
            5: { name: '💬 ChatGPT — Pro',    servicio: 'ChatGPT',  plan: 'Pro',   precioM: 219000,  precioA: 2190000 },
        };

        function fmt(n) {
            return n.toLocaleString('es-CO') + ' COP';
        }

        function updateCheckout(id) {
            const p = products[id];
            if (!p) return;
            const period = document.getElementById('currentPeriod').value;
            const precio = period === 'mensual' ? p.precioM : p.precioA;
            const tag    = period === 'mensual' ? '/ mes' : '/ año';
            const dur    = period === 'mensual' ? '12 meses' : '1 año';

            document.getElementById('checkoutName').textContent    = p.name;
            document.getElementById('checkoutPrice').textContent   = fmt(precio);
            document.getElementById('checkoutPeriod').textContent  = period === 'mensual' ? 'Mensual' : 'Anual';
            document.getElementById('checkoutDuration').textContent = dur;
            document.getElementById('recurringMsg').textContent    = 'Cobro automático ' + (period === 'mensual' ? 'mensual durante 12 meses.' : 'anual por 1 año.');
        }

        window.setPeriod = function(period) {
            document.getElementById('currentPeriod').value = period;
            document.getElementById('btnMensual').classList.toggle('active', period === 'mensual');
            document.getElementById('btnAnual').classList.toggle('active', period === 'anual');

            document.querySelectorAll('.price-mensual').forEach(el => el.style.display = period === 'mensual' ? 'flex' : 'none');
            document.querySelectorAll('.price-anual').forEach(el => el.style.display = period === 'anual' ? 'flex' : 'none');

            const sel = document.querySelector('.product-card.selected');
            if (sel) updateCheckout(parseInt(sel.getAttribute('data-id')));
        };

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

            var period  = document.getElementById('currentPeriod').value;
            var id      = parseInt(selectedCard.getAttribute('data-id'));
            var p       = <?= json_encode([
                1 => ['servicio'=>'Claude','plan'=>'Pro','precioM'=>22900,'precioA'=>229000],
                2 => ['servicio'=>'Claude','plan'=>'Max','precioM'=>109000,'precioA'=>1090000],
                3 => ['servicio'=>'ChatGPT','plan'=>'Go','precioM'=>8900,'precioA'=>89000],
                4 => ['servicio'=>'ChatGPT','plan'=>'Plus','precioM'=>22900,'precioA'=>229000],
                5 => ['servicio'=>'ChatGPT','plan'=>'Pro','precioM'=>219000,'precioA'=>2190000],
            ]) ?>[id];

            var precio = period === 'mensual' ? p.precioM : p.precioA;
            var periodicidad = period === 'mensual' ? 'M' : 'Y';

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '../../php/crear_suscription_rec.php';

            [['servicio', p.servicio], ['plan', p.plan], ['precio', precio],
             ['usuario_id', usuarioId], ['periodicidad', periodicidad]].forEach(function(pair) {
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
    <script src="../../assets/js/components/driver-tours/tour-ia.js"></script>
</body>
</html>
