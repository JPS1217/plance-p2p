<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IA's — API Gateway</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <?php require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../../assets/css/styles-plataformas-gateway.css">
    <link rel="stylesheet" href="../../assets/css/styles-code-block.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>
<style>
    /* IA's API Gateway — acento naranja, igual que la IA's de Web Checkout */
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
            <i class="bi bi-robot"></i> IA's — Recurrencia
            <span class="gw-badge"><i class="bi bi-lightning-charge-fill"></i> API Gateway</span>
            <span class="sub-badge"><i class="bi bi-arrow-repeat"></i> Recurrencia</span>
        </div>
        <div class="period-selector" id="periodSelector">
            <button class="period-btn active" id="btnMensual" onclick="setPeriod('mensual')">Mensual</button>
            <button class="period-btn" id="btnAnual" onclick="setPeriod('anual')">Anual</button>
        </div>
    </div>

    <div class="security-warning">
        <i class="bi bi-shield-exclamation"></i>
        <div style="width: 100%;">
            <div class="security-warning-header" onclick="toggleWarning()">
                <strong>⚠️ Aviso para comercios</strong>
                <i class="bi bi-chevron-down security-warning-toggle" id="warningToggle"></i>
            </div>
            <div class="security-warning-content" id="warningContent">
                La integración con API Gateway implica el manejo directo de datos sensibles del usuario. Para operar en producción es <strong>obligatorio</strong> contar con certificación <strong>PCI-DSS</strong> y se recomienda implementar <strong>3D Secure (3DS)</strong> para reducir el riesgo de fraude. Esta demo es solo con fines ilustrativos.
                <br><br>
                La base de datos de esta web <strong>NO! Guarda datos sensibles </strong> como el <strong> Numero de tarjeta, Fecha y CVV</strong> o <strong>Numeros de cuenta</strong> esta es solo una demostracion del servicio.
            </div>
        </div>
    </div>

    <main class="shop-layout">
        <section class="products-panel" id="productsPanel">

            <!-- BLACKBOX -->
            <div class="section-block">
                <div class="platform-header">
                    <img src="../../assets/implataformas/ia/blackbox-icon.svg" alt="Blackbox AI">
                    <span>Blackbox AI</span>
                </div>
                <div class="products-grid">
                    <div class="product-card popular-card" data-id="1" data-servicio="Blackbox AI" data-plan="Pro" data-precio-mensual="24900" data-precio-anual="249000">
                        <div class="badge-popular">★ Popular</div>
                        <div class="product-card__platform">Blackbox AI</div>
                        <div class="product-card__pts">Pro</div>
                        <div class="product-card__label">Autocompletado ilimitado · Chat de código</div>
                        <div class="product-card__price price-mensual">24.900 COP <span class="sub-tag">/ mes</span></div>
                        <div class="product-card__price price-anual">249.000 COP <span class="sub-tag">/ año</span></div>
                    </div>
                    <div class="product-card" data-id="2" data-servicio="Blackbox AI" data-plan="Ultra" data-precio-mensual="79900" data-precio-anual="799000">
                        <div class="product-card__platform">Blackbox AI</div>
                        <div class="product-card__pts">Ultra</div>
                        <div class="product-card__label">Modelos avanzados · Uso ilimitado en equipo</div>
                        <div class="product-card__price price-mensual">79.900 COP <span class="sub-tag">/ mes</span></div>
                        <div class="product-card__price price-anual">799.000 COP <span class="sub-tag">/ año</span></div>
                    </div>
                </div>
            </div>

            <!-- DEEPSEEK -->
            <div class="section-block">
                <div class="platform-header">
                    <img src="../../assets/implataformas/ia/deepseek-icon.svg" alt="DeepSeek">
                    <span>DeepSeek</span>
                </div>
                <div class="products-grid">
                    <div class="product-card" data-id="3" data-servicio="DeepSeek" data-plan="Plus" data-precio-mensual="15900" data-precio-anual="159000">
                        <div class="product-card__platform">DeepSeek</div>
                        <div class="product-card__pts">Plus</div>
                        <div class="product-card__label">Uso extendido · Sin límites de espera</div>
                        <div class="product-card__price price-mensual">15.900 COP <span class="sub-tag">/ mes</span></div>
                        <div class="product-card__price price-anual">159.000 COP <span class="sub-tag">/ año</span></div>
                    </div>
                    <div class="product-card popular-card" data-id="4" data-servicio="DeepSeek" data-plan="Pro" data-precio-mensual="39900" data-precio-anual="399000">
                        <div class="badge-popular">★ Popular</div>
                        <div class="product-card__platform">DeepSeek</div>
                        <div class="product-card__pts">Pro</div>
                        <div class="product-card__label">Modelo de razonamiento · Prioridad de cómputo</div>
                        <div class="product-card__price price-mensual">39.900 COP <span class="sub-tag">/ mes</span></div>
                        <div class="product-card__price price-anual">399.000 COP <span class="sub-tag">/ año</span></div>
                    </div>
                </div>
            </div>

            <!-- Modo de simulación -->
            <div class="sim-mode-wrap" id="simModeWrap">
                <span class="sim-mode-label">Modo de simulación</span>
                <div class="sim-mode-toggle">
                        <button type="button" class="sim-mode-opt active" id="modoElegir" onclick="setModo('elegir')">
                            <i class="bi bi-sliders"></i> Elegir estado
                        </button>
                        <button type="button" class="sim-mode-opt" id="modoAuto" onclick="setModo('auto')">
                            <i class="bi bi-lightning-charge-fill"></i> Pago normal
                        </button>
                </div>
                <div class="sim-mode-hint" id="modoHint">Elige manualmente cómo termina la recurrencia.</div>
            </div>

        </section>

        <!-- CHECKOUT -->
        <aside class="checkout-panel">
            <div class="checkout-box">
                <div class="checkout-product-name" id="checkoutName">🤖 Blackbox AI — Pro</div>
                <div class="checkout-price-row">
                    <span style="font-size:0.85rem;color:var(--pt-text-sec);" id="checkoutPeriodLabel">Total / mes</span>
                    <span class="checkout-price" id="checkoutPrice">24.900 COP</span>
                </div>

                <div class="checkout-divider"></div>

                <div class="token-info">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Recurrencia — se cobra el primer periodo y PlacetoPay programa los cobros siguientes automáticamente.</span>
                </div>

                <span class="section-label-sm">Datos de la tarjeta</span>
                <div class="field-group">
                    <label class="field-label">Número de tarjeta</label>
                    <input type="text" class="field-input" id="cardNumber" placeholder="0000 0000 0000 0000" maxlength="19">
                </div>
                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">Vencimiento</label>
                        <input type="text" class="field-input" id="cardExpiry" placeholder="MM/AA" maxlength="5">
                    </div>
                    <div class="field-group">
                        <label class="field-label">CVV</label>
                        <input type="password" class="field-input" id="cardCvv" placeholder="123" maxlength="4" inputmode="numeric">
                    </div>
                </div>
                <div class="field-group">
                    <label class="field-label">Nombre en la tarjeta</label>
                    <input type="text" class="field-input" id="cardNameOnCard" placeholder="Como aparece en la tarjeta">
                </div>

                <div class="checkout-divider"></div>
                <span class="section-label-sm">Datos del titular</span>
                <div class="field-group">
                    <label class="field-label">Correo electrónico</label>
                    <input type="email" class="field-input" id="gwCorreo"
                           value="<?php echo htmlspecialchars($_SESSION['correo'] ?? ''); ?>">
                </div>
                <div class="field-group">
                    <label class="field-label">Teléfono</label>
                    <input type="text" class="field-input" id="gwTelefono" placeholder="3001234567">
                </div>
                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">Tipo de documento</label>
                        <select class="field-input" id="gwTipoDoc">
                            <option value="CC">Cédula</option>
                            <option value="CE">Cédula Extranjería</option>
                            <option value="NIT">NIT</option>
                            <option value="PP">Pasaporte</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Número de documento</label>
                        <input type="text" class="field-input" id="gwNumDoc" placeholder="1234567890">
                    </div>
                </div>

                <button class="btn-pagar" id="btnPagar">
                    <i class="bi bi-lock-fill"></i> Activar recurrencia
                </button>
                <div class="security-note">
                    <i class="bi bi-shield-check"></i>
                    Pago seguro · API Gateway · Evertec PlacetoPay
                </div>
            </div>
        </aside>
    </main>

    <!-- ═══ INTEGRACIÓN PLACETOPAY ═══ -->
    <section class="integration-docs" style="--code-accent:var(--plat-accent); --code-accent-ink:var(--plat-accent-ink); --code-accent-soft:rgba(var(--plat-accent-rgb),0.12); --code-radius-sm:var(--plat-radius-sm); --code-radius-md:var(--plat-radius-md); --code-radius-lg:var(--plat-radius-lg); --code-font:var(--plat-font);">
        <span class="integration-docs__badge"><i class="bi bi-braces"></i> Integración PlacetoPay</span>
        <h3>Así se procesa el pago de esta tienda</h3>
        <p>A diferencia de Web Checkout, aquí <strong>no hay redirección</strong>: los datos de tarjeta viajan en el request. Pero la recurrencia funciona igual en ambos canales — el cuerpo lleva el mismo bloque <code>recurring</code> dentro de <code>payment</code>: se cobra el primer periodo <strong>ahora mismo</strong> y <strong>PlaceToPay</strong> programa y ejecuta los cobros siguientes automáticamente, sin que nuestro backend tenga que volver a hacer nada.</p>
        <p>No hay <code>subscribe</code> ni token de por medio: esta tienda no gestiona el reintento, PlacetoPay sí. El <code>periodicidad</code>/<code>next_payment</code>/<code>fecha_fin</code> quedan guardados en nuestra base de datos solo como referencia informativa.</p>

        <div class="endpoint-bar">
            <span class="method-pill">POST</span>
            <span class="endpoint-url">https://api-test.placetopay.com/rest/gateway/process</span>
            <span class="endpoint-note">ambiente de pruebas</span>
        </div>

        <div class="code-block">
            <div class="code-tabs">
                <button class="code-tab active" data-key="json">JSON</button>
                <button class="code-tab" data-key="php">PHP</button>
                <button class="code-copy"><i class="bi bi-clipboard"></i> Copiar</button>
            </div>
            <pre class="code-panel active" data-key="json"><code>{
  <span class="jk">"auth"</span>: {
    <span class="jk">"login"</span>: <span class="js">"YOUR_LOGIN"</span>,
    <span class="jk">"tranKey"</span>: <span class="js">"TRAN_KEY_CALCULADO"</span>,
    <span class="jk">"nonce"</span>: <span class="js">"Tm9uY2VFbkJhc2U2NA=="</span>,
    <span class="jk">"seed"</span>: <span class="js">"2026-08-25T10:15:32-05:00"</span>
  },
  <span class="jk">"payer"</span>: {
    <span class="jk">"name"</span>: <span class="js">"Andrés Torres"</span>,
    <span class="jk">"surname"</span>: <span class="js">""</span>,
    <span class="jk">"email"</span>: <span class="js">"usuario@correo.com"</span>,
    <span class="jk">"documentType"</span>: <span class="js">"CC"</span>,
    <span class="jk">"document"</span>: <span class="js">"1234567890"</span>,
    <span class="jk">"mobile"</span>: <span class="js">"3001234567"</span>
  },
  <span class="jk">"payment"</span>: {
    <span class="jk">"reference"</span>: <span class="js">"GWREC-9F3A2E1C"</span>,
    <span class="jk">"description"</span>: <span class="js">"Blackbox AI — Pro"</span>,
    <span class="jk">"amount"</span>: { <span class="jk">"currency"</span>: <span class="js">"COP"</span>, <span class="jk">"total"</span>: <span class="jn">24900</span> },
    <span class="cm">// clave: programa el cobro automático de los siguientes periodos</span>
    <span class="jk">"recurring"</span>: {
      <span class="jk">"periodicity"</span>: <span class="js">"M"</span>,
      <span class="jk">"interval"</span>: <span class="js">"1"</span>,
      <span class="jk">"nextPayment"</span>: <span class="js">"2026-09-28"</span>,
      <span class="jk">"maxPeriods"</span>: <span class="jn">12</span>
    }
  },
  <span class="jk">"instrument"</span>: {
    <span class="jk">"card"</span>: {
      <span class="jk">"number"</span>: <span class="js">"tok_************1111"</span>,
      <span class="jk">"expiration"</span>: <span class="js">"12/28"</span>,
      <span class="jk">"cvv"</span>: <span class="js">"***"</span>
    }
  },
  <span class="jk">"notificationUrl"</span>: <span class="js">"https://tu-dominio.com/php/notify.php"</span>,
  <span class="jk">"ipAddress"</span>: <span class="js">"203.0.113.42"</span>,
  <span class="jk">"userAgent"</span>: <span class="js">"Mozilla/5.0 (Windows NT 10.0; Win64; x64)"</span>
}</code></pre>
            <pre class="code-panel" data-key="php"><code>&lt;?php
<span class="cm">// credenciales fuera del código, nunca hardcodeadas</span>
<span class="cvar">$login</span>     = getenv(<span class="js">'P2P_LOGIN'</span>);
<span class="cvar">$secretKey</span> = getenv(<span class="js">'P2P_SECRET_KEY'</span>);
<span class="cvar">$endpoint</span>  = <span class="js">'https://api-test.placetopay.com/rest/gateway/process'</span>;

<span class="cm">// según la periodicidad elegida, arma el bloque "recurring"</span>
<span class="fn">if</span> (<span class="cvar">$periodicidad</span> === <span class="js">'Y'</span>) {
    <span class="cvar">$interval</span>    = <span class="js">'12'</span>;
    <span class="cvar">$maxPeriods</span>  = 1;
} <span class="fn">else</span> {
    <span class="cvar">$interval</span>    = <span class="js">'1'</span>;
    <span class="cvar">$maxPeriods</span>  = 12;
}

<span class="cm">// cuerpo del request — cobra el primer periodo, PlacetoPay programa el resto</span>
<span class="cvar">$body</span> = [
    <span class="jk">'auth'</span> =&gt; [
        <span class="jk">'login'</span>   =&gt; <span class="cvar">$login</span>,
        <span class="jk">'tranKey'</span> =&gt; <span class="cvar">$tranKey</span>,
        <span class="jk">'nonce'</span>   =&gt; <span class="cvar">$nonceB64</span>,
        <span class="jk">'seed'</span>    =&gt; <span class="cvar">$seed</span>,
    ],
    <span class="jk">'payment'</span> =&gt; [
        <span class="jk">'reference'</span>   =&gt; <span class="js">'GWREC-'</span> . strtoupper(bin2hex(random_bytes(4))),
        <span class="jk">'description'</span> =&gt; <span class="cvar">$servicio</span> . <span class="js">' — '</span> . <span class="cvar">$plan</span>,
        <span class="jk">'amount'</span>      =&gt; [<span class="jk">'currency'</span> =&gt; <span class="js">'COP'</span>, <span class="jk">'total'</span> =&gt; (float) <span class="cvar">$precio</span>],
        <span class="jk">'recurring'</span>   =&gt; [
            <span class="jk">'periodicity'</span> =&gt; <span class="cvar">$periodicidad</span>,  <span class="cm">// 'M' o 'Y'</span>
            <span class="jk">'interval'</span>    =&gt; <span class="cvar">$interval</span>,
            <span class="jk">'nextPayment'</span> =&gt; <span class="cvar">$nextPayment</span>,
            <span class="jk">'maxPeriods'</span>  =&gt; <span class="cvar">$maxPeriods</span>,
        ],
    ],
    <span class="jk">'instrument'</span> =&gt; [
        <span class="jk">'card'</span> =&gt; [<span class="jk">'number'</span> =&gt; <span class="cvar">$card_number</span>, <span class="jk">'expiration'</span> =&gt; <span class="cvar">$card_expiry</span>, <span class="jk">'cvv'</span> =&gt; <span class="cvar">$card_cvv</span>],
    ],
    <span class="jk">'notificationUrl'</span> =&gt; <span class="cvar">$notifyUrl</span>,
    <span class="jk">'ipAddress'</span>       =&gt; <span class="cvar">$_SERVER</span>[<span class="js">'REMOTE_ADDR'</span>],
    <span class="jk">'userAgent'</span>       =&gt; <span class="cvar">$_SERVER</span>[<span class="js">'HTTP_USER_AGENT'</span>],
];

<span class="cvar">$result</span> = json_decode(curl_exec(<span class="cvar">$ch</span>), true);

<span class="cm">// guardamos periodicidad/next_payment/fecha_fin solo como referencia —</span>
<span class="cm">// el cobro de los siguientes periodos lo ejecuta PlacetoPay, no nosotros</span>
<span class="cvar">$query</span> = <span class="js">"INSERT INTO gateway_recurrencias (..., periodicidad, next_payment, fecha_fin) VALUES (...)"</span>;</code></pre>
        </div>

        <div class="doc-note">
            <span class="doc-note-icon">⚠️</span>
            <span>Como los datos de tarjeta pasan por nuestra página, este flujo requiere <strong>certificación PCI-DSS</strong> en producción. Igual que en Web Checkout, esta demo no guarda número, fecha ni CVV — se usan solo para armar el request.</span>
        </div>

        <a class="integration-docs__link" href="../guias/guia-developer.php#api-gateway">
            <div>
                <strong>¿Quieres entender esta integración a fondo?</strong>
                <span>Lee la documentación completa de API Gateway — alcance PCI-DSS, 3D Secure y más.</span>
            </div>
            <i class="bi bi-arrow-right"></i>
        </a>
    </section>

    <input type="hidden" id="currentPeriod" value="mensual">

    <script>
    (function() {
        const products = {
            1:{name:' Blackbox AI — Pro',   servicio:'Blackbox AI', plan:'Pro',   precioM:24900, precioA:249000},
            2:{name:' Blackbox AI — Ultra', servicio:'Blackbox AI', plan:'Ultra', precioM:79900, precioA:799000},
            3:{name:' DeepSeek — Plus',     servicio:'DeepSeek',    plan:'Plus',  precioM:15900, precioA:159000},
            4:{name:' DeepSeek — Pro',      servicio:'DeepSeek',    plan:'Pro',   precioM:39900, precioA:399000},
        };

        function fmt(n) { return n.toLocaleString('es-CO') + ' COP'; }

        function updateCheckout(id) {
            const p = products[id];
            if (!p) return;
            const period = document.getElementById('currentPeriod').value;
            const precio = period === 'mensual' ? p.precioM : p.precioA;

            document.getElementById('checkoutName').textContent        = p.name;
            document.getElementById('checkoutPrice').textContent       = fmt(precio);
            document.getElementById('checkoutPeriodLabel').textContent = period === 'mensual' ? 'Total / mes' : 'Total / año';
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

        // Formatear número de tarjeta
        document.getElementById('cardNumber').addEventListener('input', function() {
            let v = this.value.replace(/\D/g,'').substring(0,16);
            this.value = v.replace(/(.{4})/g,'$1 ').trim();
        });
        // Formatear fecha
        document.getElementById('cardExpiry').addEventListener('input', function() {
            let v = this.value.replace(/\D/g,'').substring(0,4);
            if (v.length >= 2) v = v.substring(0,2) + '/' + v.substring(2);
            this.value = v;
        });

        // ── Modo de simulación ──
        let modoSimulacion = 'elegir';
        window.setModo = function(modo) {
            modoSimulacion = modo;
            document.getElementById('modoElegir').classList.toggle('active', modo === 'elegir');
            document.getElementById('modoAuto').classList.toggle('active', modo === 'auto');
            document.getElementById('modoHint').textContent = (modo === 'elegir')
                ? 'Elige manualmente cómo termina la recurrencia.'
                : 'El estado se asigna automáticamente, como un pago real.';
        };

        let envioEnCurso = false;
        const btnPagarDefaultHTML = document.getElementById('btnPagar').innerHTML;

        window.addEventListener('pageshow', function(event) {
            if (!event.persisted) return;
            envioEnCurso = false;
            const btn = document.getElementById('btnPagar');
            btn.disabled = false;
            btn.style.opacity = '';
            btn.style.cursor = '';
            btn.innerHTML = btnPagarDefaultHTML;
        });

        document.getElementById('btnPagar').addEventListener('click', function() {
            if (envioEnCurso) return;

            const selected = document.querySelector('.product-card.selected');
            if (!selected) { alert('⚠️ Selecciona un plan primero.'); return; }

            const cardNum  = document.getElementById('cardNumber').value.replace(/\s/g,'');
            const expiry   = document.getElementById('cardExpiry').value;
            const cvv      = document.getElementById('cardCvv').value;
            const cardName = document.getElementById('cardNameOnCard').value.trim();
            const nombre   = cardName;
            const correo   = document.getElementById('gwCorreo').value.trim();
            const telefono = document.getElementById('gwTelefono').value.trim();
            const tipoDoc  = document.getElementById('gwTipoDoc').value;
            const numDoc   = document.getElementById('gwNumDoc').value.trim();

            if (!cardNum || cardNum.length < 15) { alert('⚠️ Ingresa un número de tarjeta válido.'); return; }
            if (!expiry)  { alert('⚠️ Ingresa la fecha de vencimiento.'); return; }
            if (!cvv)     { alert('⚠️ Ingresa el CVV.'); return; }
            if (!cardName){ alert('⚠️ Ingresa el nombre en la tarjeta.'); return; }
            if (!nombre || !correo || !numDoc || !telefono) {
                alert('⚠️ Por favor completa todos los campos del titular.'); return;
            }

            const id     = parseInt(selected.getAttribute('data-id'));
            const p      = products[id];
            const period = document.getElementById('currentPeriod').value;
            const precio = period === 'mensual' ? p.precioM : p.precioA;
            const periodicidad = period === 'mensual' ? 'M' : 'Y';

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = (modoSimulacion === 'auto')
                ? '../../php/crear_recurrencia_gateway.php'
                : '../../retorno/estados-subs-gateway.php';

            const campos = [
                ['servicio', p.servicio], ['plan', p.plan], ['precio', precio],
                ['nombre', nombre], ['correo', correo], ['telefono', telefono],
                ['tipo_doc', tipoDoc], ['num_doc', numDoc],
                ['periodicidad', periodicidad], ['destino', 'recurrencia'],
                ['card_number', document.getElementById('cardNumber').value.replace(/\s/g,'')],
                ['card_expiry', document.getElementById('cardExpiry').value],
                ['card_cvv',    document.getElementById('cardCvv').value],
                ['card_name',   document.getElementById('cardNameOnCard').value]
            ];

            campos.forEach(function(pair) {
                const input = document.createElement('input');
                input.type = 'hidden'; input.name = pair[0]; input.value = pair[1];
                form.appendChild(input);
            });

            envioEnCurso = true;
            const btn = document.getElementById('btnPagar');
            btn.disabled = true;
            btn.style.opacity = '0.6';
            btn.style.cursor = 'not-allowed';
            btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Procesando...';

            document.body.appendChild(form);
            form.submit();
        });
    })();

    // Toggle para el mensaje de aviso
    function toggleWarning() {
        const content = document.getElementById('warningContent');
        const toggle = document.getElementById('warningToggle');
        content.classList.toggle('collapsed');
        toggle.classList.toggle('collapsed');
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/code-block.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="../../assets/js/components/driver-tours/tour-ia-gateway.js"></script>
</body>
</html>
