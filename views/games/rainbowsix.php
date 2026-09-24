<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Gemas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/styles-juegos-mixto.css">
    <link rel="stylesheet" href="../../assets/css/styles-code-block.css">
    <?php $theme_seccion = 'juegos'; require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>
<style>
    /* Tienda de Gemas — morado (Gemas) + azul (Web Checkout / multi) */
    :root {
        --gj-accent:        #7c3aed;
        --gj-accent-glow:   rgba(124, 58, 237, 0.25);
        --gj-accent-soft:   rgba(124, 58, 237, 0.15);
        --gj-accent-hover:  rgba(124, 58, 237, 0.4);
        --gj-accent-dark:   #5b21b6;
        --gj-accent2:       #3b82f6;
        --gj-accent2-glow:  rgba(59, 130, 246, 0.2);
        --gj-accent2-soft:  rgba(59, 130, 246, 0.15);
        --gj-accent2-hover: rgba(59, 130, 246, 0.5);
    }
</style>
<body>
    <?php
    $nav_back_url  = "juegos.php";
    $nav_back_text = "Atras";
    $nav_base      = "../../";
    $nav_back_text_cod = "cod.php";
    require_once '../../php/navbar.php';
    ?>

    <div class="game-banner">
        <div class="game-banner__tag">
            ?? Tienda de Gemas
            <span class="wc-badge">??? Web Checkout</span>
            <span class="mixto-badge" id="pagoMixtoBadge">?? Pago Mixto</span>
        </div>
    </div>

    <main class="shop-layout">
        <section class="products-panel" id="productsPanel">

            <!-- Gemas -->
            <p class="section-label">?? Gemas — Moneda del juego</p>
            <div class="products-grid">
                <div class="product-card" data-id="p1" data-nombre="60 Gemas" data-precio="4900">
                    <img class="product-card__icon" src="../../assets/imgames/gemas/gem-icon.svg" alt="">
                    <div class="product-card__info">
                        <div class="product-card__pts">60 Gemas</div>
                        <div class="product-card__label">Moneda del juego</div>
                        <div class="product-card__price">4.900 COP</div>
                    </div>
                </div>
                <div class="product-card" data-id="p2" data-nombre="120 Gemas" data-precio="9900">
                    <img class="product-card__icon" src="../../assets/imgames/gemas/gem-icon.svg" alt="">
                    <div class="product-card__info">
                        <div class="product-card__pts">120 Gemas</div>
                        <div class="product-card__label">Moneda del juego</div>
                        <div class="product-card__price">9.900 COP</div>
                    </div>
                </div>
                <div class="product-card popular-card" data-id="p3" data-nombre="300 Gemas" data-precio="24900">
                    <div class="badge-popular">? Popular</div>
                    <img class="product-card__icon" src="../../assets/imgames/gemas/gem-icon.svg" alt="">
                    <div class="product-card__info">
                        <div class="product-card__pts">300 Gemas</div>
                        <div class="product-card__label">Moneda del juego</div>
                        <div class="product-card__price">24.900 COP</div>
                    </div>
                </div>
                <div class="product-card" data-id="p4" data-nombre="600 Gemas" data-precio="49900">
                    <img class="product-card__icon" src="../../assets/imgames/gemas/gem-icon.svg" alt="">
                    <div class="product-card__info">
                        <div class="product-card__pts">600 Gemas</div>
                        <div class="product-card__label">Moneda del juego</div>
                        <div class="product-card__price">49.900 COP</div>
                    </div>
                </div>

                <div class="product-card popular-card" data-id="p5" data-nombre="1200 Gemas" data-precio="99900">
                    <div class="badge-popular">Mejor valor</div>
                    <img class="product-card__icon" src="../../assets/imgames/gemas/gem-icon.svg" alt="">
                    <div class="product-card__info">
                        <div class="product-card__pts">1200 Gemas</div>
                        <div class="product-card__label">Moneda del juego</div>
                        <div class="product-card__price">99.900 COP</div>
                    </div>
                </div>
                <div class="product-card" data-id="p6" data-nombre="2400 Gemas" data-precio="189900">
                    <img class="product-card__icon" src="../../assets/imgames/gemas/gem-icon.svg" alt="">
                    <div class="product-card__info">
                        <div class="product-card__pts">2400 Gemas</div>
                        <div class="product-card__label">Moneda del juego</div>
                        <div class="product-card__price">189.900 COP</div>
                    </div>
                </div>
            </div>

            <!-- PASES -->
            <p class="section-label">??? Pases de batalla</p>
            <div class="pases-grid">
                <div class="pase-card" data-id="b1" data-nombre="Pase Premium" data-precio="39900">
                    <span class="pase-tag">PASE DE BATALLA</span>
                    <div class="pase-head">
                        <img class="pase-icon" src="../../assets/imgames/comunes/pase-icon.svg" alt="">
                        <div class="pase-name">Pase Premium</div>
                    </div>
                    <div class="pase-desc">Acceso al pase de temporada con recompensas exclusivas del operador.</div>
                    <div class="pase-price">39.900 COP</div>
                </div>
                <div class="pase-card" data-id="b2" data-nombre="Pase Elite" data-precio="79900">
                    <span class="pase-tag">PASE ELITE</span>
                    <div class="pase-head">
                        <img class="pase-icon" src="../../assets/imgames/comunes/pase-icon.svg" alt="">
                        <div class="pase-name">Pase Elite</div>
                    </div>
                    <div class="pase-desc">Incluye todo el Pase Premium más contenido exclusivo elite y recompensas adicionales.</div>
                    <div class="pase-price">79.900 COP</div>
                </div>
            </div>

        </section>

        <!-- CHECKOUT -->
        <aside class="checkout-panel">
            <div class="checkout-box">

                <!-- Multi-producto checkbox -->
                <label class="check-wrap multi" style="margin-bottom:0.8rem;">
                    <input type="checkbox" id="multiCheck" onchange="toggleMulti()">
                    <span class="check-label">
                        <strong>?? Selección múltiple</strong>
                        Agrega varios productos al carrito y págalos juntos.
                    </span>
                </label>

                <!-- Carrito / resumen -->
                <span class="section-label-sm">Resumen</span>
                <div class="cart-items" id="cartItems">
                    <div class="cart-empty" id="cartEmpty">Selecciona un producto para comenzar</div>
                </div>
                <div class="total-row">
                    <span class="total-label">Total</span>
                    <span class="total-price" id="totalPrice">$0 COP</span>
                </div>

                <!-- Pago parcial checkbox 
                <label class="check-wrap parcial">
                    <input type="checkbox" id="parcialCheck" onchange="toggleParcial()">
                    <span class="check-label">
                        <strong>?? Pago parcial (Mixto)</strong>
                        Paga solo una parte ahora y el resto después.
                    </span>
                </label>-->
                

                <!-- Panel pago parcial -->
                <div class="parcial-panel" id="parcialPanel">
                    <div class="parcial-amounts">
                        <span>Mínimo: <strong id="minAmount">0</strong></span>
                        <span>Total: <strong id="maxAmount">0</strong></span>
                    </div>
                    <input type="range" class="parcial-slider" id="parcialSlider" min="0" max="100" value="50" oninput="updateSlider()">
                    <div class="parcial-now" id="parcialNow">$0 COP</div>
                    <div class="parcial-rest" id="parcialRest">Restante: $0 COP</div>
                </div>

                <div style="height:0.8rem;"></div>
                <span class="section-label-sm">Datos del jugador</span>
                <div class="field-group">
                    <label class="field-label"><i class="bi bi-person-vcard-fill fs-6 text-warning"></i> ID de jugador</label>
                    <input type="text" class="field-input" id="jugadorId" placeholder="Ej: R6M-123456">
                </div>

                <button class="btn-pagar" id="btnPagar" onclick="pagar()">
                    <i class="bi bi-lock-fill"></i> Pagar ahora
                </button>
                <div class="security-note">
                    <i class="bi bi-shield-check"></i>
                    Web Checkout · PlacetoPay · Evertec
                </div>
            </div>
        </aside>
    </main>

    <!-- --- INTEGRACIÓN PLACETOPAY --- -->
    <section class="integration-docs" style="--code-accent:var(--gj-accent); --code-accent-ink:var(--gj-accent-ink); --code-accent-soft:var(--gj-accent-soft); --code-radius-sm:var(--gj-radius-sm, 6px); --code-radius-md:var(--gj-radius-md); --code-radius-lg:var(--gj-radius-lg); --code-font:var(--gj-font-body);">
        <span class="integration-docs__badge"><i class="bi bi-braces"></i> Integración PlacetoPay</span>
        <h3>Así se crea la sesión de pago de esta tienda</h3>
        <p>Cuando presionas <strong>"Pagar ahora"</strong>, nuestro backend arma este mismo request y lo envía a <strong>PlacetoPay Web Checkout</strong> con <code>payment.allowPartial: true</code>. En la pasarela verás una casilla para elegir cuánto pagar ahora — el resto queda pendiente para completarlo después.</p>

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
  <span class="jk">"auth"</span>: {
    <span class="jk">"login"</span>: <span class="js">"YOUR_LOGIN"</span>,
    <span class="jk">"tranKey"</span>: <span class="js">"TRAN_KEY_CALCULADO"</span>,
    <span class="jk">"nonce"</span>: <span class="js">"Tm9uY2VFbkJhc2U2NA=="</span>,
    <span class="jk">"seed"</span>: <span class="js">"2026-08-25T10:15:32-05:00"</span>
  },
  <span class="jk">"payment"</span>: {
    <span class="jk">"reference"</span>: <span class="js">"MIX-9F3A2E1C"</span>,
    <span class="jk">"description"</span>: <span class="js">"300 Gemas"</span>,
    <span class="jk">"amount"</span>: {
      <span class="jk">"currency"</span>: <span class="js">"COP"</span>,
      <span class="jk">"total"</span>: <span class="jn">24900</span>,
      <span class="cm">// mínimo permitido: 10% del total</span>
      <span class="jk">"minimum"</span>: <span class="jn">2490</span>
    },
    <span class="cm">// clave: habilita la casilla de pago parcial en la pasarela</span>
    <span class="jk">"allowPartial"</span>: <span class="jb">true</span>
  },
  <span class="jk">"expiration"</span>: <span class="js">"2026-08-25T10:45:32-05:00"</span>,
  <span class="jk">"returnUrl"</span>: <span class="js">"https://tu-dominio.com/retorno/retorno_mixto.php"</span>,
  <span class="jk">"ipAddress"</span>: <span class="js">"203.0.113.42"</span>,
  <span class="jk">"userAgent"</span>: <span class="js">"Mozilla/5.0 (Windows NT 10.0; Win64; x64)"</span>,
  <span class="jk">"locale"</span>: <span class="js">"es_CO"</span>
}</code></pre>
            <pre class="code-panel" data-key="php"><code>&lt;?php
<span class="cm">// credenciales fuera del código, nunca hardcodeadas</span>
<span class="cvar">$login</span>     = getenv(<span class="js">'P2P_LOGIN'</span>);
<span class="cvar">$secretKey</span> = getenv(<span class="js">'P2P_SECRET_KEY'</span>);
<span class="cvar">$endpoint</span>  = <span class="js">'https://checkout-test.placetopay.com/api/session'</span>;

<span class="cm">// autenticación: Base64( SHA256( nonce + seed + secretKey ) )</span>
<span class="cvar">$seed</span>     = date(<span class="js">'c'</span>);
<span class="cvar">$nonce</span>    = bin2hex(random_bytes(16));
<span class="cvar">$tranKey</span>  = base64_encode(hash(<span class="js">'sha256'</span>, <span class="cvar">$nonce</span> . <span class="cvar">$seed</span> . <span class="cvar">$secretKey</span>, true));
<span class="cvar">$nonceB64</span> = base64_encode(<span class="cvar">$nonce</span>);

<span class="cm">// para pagos mixtos: siempre se envía el total completo</span>
<span class="cvar">$amount</span> = [<span class="jk">'currency'</span> =&gt; <span class="js">'COP'</span>, <span class="jk">'total'</span> =&gt; (float) <span class="cvar">$total</span>];

<span class="cm">// si se permite pago parcial, se agrega el monto mínimo (10%)</span>
<span class="fn">if</span> (<span class="cvar">$allow_partial</span>) {
    <span class="cvar">$amount</span>[<span class="js">'minimum'</span>] = (float) ceil(<span class="cvar">$total</span> * 0.1);
}

<span class="cvar">$body</span> = [
    <span class="jk">'auth'</span> =&gt; [
        <span class="jk">'login'</span>   =&gt; <span class="cvar">$login</span>,
        <span class="jk">'tranKey'</span> =&gt; <span class="cvar">$tranKey</span>,
        <span class="jk">'nonce'</span>   =&gt; <span class="cvar">$nonceB64</span>,
        <span class="jk">'seed'</span>    =&gt; <span class="cvar">$seed</span>,
    ],
    <span class="jk">'payment'</span> =&gt; [
        <span class="jk">'reference'</span>    =&gt; <span class="js">'MIX-'</span> . strtoupper(bin2hex(random_bytes(4))),
        <span class="jk">'description'</span>  =&gt; <span class="cvar">$productos</span>,             <span class="cm">// ej: "300 Gemas" (o varios unidos con " + ")</span>
        <span class="jk">'amount'</span>       =&gt; <span class="cvar">$amount</span>,
        <span class="jk">'allowPartial'</span> =&gt; <span class="cvar">$allow_partial</span>,      <span class="cm">// ? clave: activa el pago mixto</span>
    ],
    <span class="jk">'expiration'</span> =&gt; date(<span class="js">'c'</span>, strtotime(<span class="js">'+30 minutes'</span>)),
    <span class="jk">'returnUrl'</span>  =&gt; app_base_url() . <span class="js">'/retorno/retorno_mixto.php'</span>,
    <span class="jk">'ipAddress'</span>  =&gt; <span class="cvar">$_SERVER</span>[<span class="js">'REMOTE_ADDR'</span>],
    <span class="jk">'userAgent'</span>  =&gt; <span class="cvar">$_SERVER</span>[<span class="js">'HTTP_USER_AGENT'</span>],
    <span class="jk">'locale'</span>     =&gt; <span class="js">'es_CO'</span>,
];

<span class="cvar">$ch</span> = curl_init(<span class="cvar">$endpoint</span>);
curl_setopt_array(<span class="cvar">$ch</span>, [
    CURLOPT_POST           =&gt; true,
    CURLOPT_RETURNTRANSFER =&gt; true,
    CURLOPT_HTTPHEADER     =&gt; [<span class="js">'Content-Type: application/json'</span>],
    CURLOPT_POSTFIELDS     =&gt; json_encode(<span class="cvar">$body</span>),
]);

<span class="cvar">$result</span> = json_decode(curl_exec(<span class="cvar">$ch</span>), true);
curl_close(<span class="cvar">$ch</span>);

<span class="cm">// redirige al comprador a la pasarela de PlacetoPay</span>
header(<span class="js">'Location: '</span> . <span class="cvar">$result</span>[<span class="js">'processUrl'</span>]);</code></pre>
        </div>

        <div class="doc-note">
            <span class="doc-note-icon">??</span>
            <span>Este carrito soporta <strong>selección múltiple</strong>: si agregas varios productos, todos viajan juntos en un solo <code>description</code> y un único <code>amount.total</code>. El pago mixto siempre está activo aquí, así que el comprador decide en la pasarela si paga todo de una vez o solo una parte.</span>
        </div>

        <a class="integration-docs__link" href="../guias/guia-developer.php#web-checkout">
            <div>
                <strong>¿Quieres entender esta integración a fondo?</strong>
                <span>Lee la documentación completa de Web Checkout — autenticación, notificaciones y más.</span>
            </div>
            <i class="bi bi-arrow-right"></i>
        </a>
    </section>

    <script>
    (function() {
        let cart      = {};   // { id: { nombre, precio } }
        let multiMode = false;

        function fmt(n) { return '$' + n.toLocaleString('es-CO') + ' COP'; }

        function getTotal() { return Object.values(cart).reduce((s,p)=>s+p.precio,0); }

        function renderCart() {
            const items  = Object.values(cart);
            const total  = getTotal();
            const empty  = document.getElementById('cartEmpty');
            const cont   = document.getElementById('cartItems');
            const tprice = document.getElementById('totalPrice');

            // Limpiar items previos (excepto empty)
            cont.querySelectorAll('.cart-item').forEach(e=>e.remove());

            if (items.length === 0) {
                empty.style.display = 'block';
            } else {
                empty.style.display = 'none';
                items.forEach(function(p) {
                    const row = document.createElement('div');
                    row.className = 'cart-item';
                    row.innerHTML = `<span class="cart-item-name">${p.nombre}</span><span class="cart-item-price">${fmt(p.precio)}</span>`;
                    cont.appendChild(row);
                });
            }

            tprice.textContent = fmt(total);
        }

        window.toggleMulti = function() {
            multiMode = document.getElementById('multiCheck').checked;
            if (!multiMode) {
                // En modo single dejamos solo el primero del carrito
                const keys = Object.keys(cart);
                if (keys.length > 1) {
                    const first = keys[0];
                    const keep  = cart[first];
                    cart = { [first]: keep };
                }
                document.querySelectorAll('.product-card.in-cart, .pase-card.in-cart').forEach(c=>{
                    if (c.getAttribute('data-id') !== Object.keys(cart)[0]) c.classList.remove('in-cart');
                });
            }
            renderCart();
        };

        window.toggleParcial = function() {
            // Función deshabilitada - pago parcial removido
        };

        function toggleCard(card_el) {
            const id     = card_el.getAttribute('data-id');
            const nombre = card_el.getAttribute('data-nombre');
            const precio = parseInt(card_el.getAttribute('data-precio'));

            if (multiMode) {
                if (cart[id]) {
                    delete cart[id];
                    card_el.classList.remove('in-cart');
                } else {
                    cart[id] = { nombre, precio };
                    card_el.classList.add('in-cart');
                }
            } else {
                // Single mode — deseleccionar todo y seleccionar este
                document.querySelectorAll('.product-card, .pase-card').forEach(c=>{
                    c.classList.remove('selected','in-cart');
                });
                cart = {};
                cart[id] = { nombre, precio };
                card_el.classList.add('selected');
            }
            renderCart();
        }

        // Bind cards
        document.querySelectorAll('.product-card, .pase-card').forEach(function(card_el) {
            card_el.addEventListener('click', function() { toggleCard(this); });
        });

        window.pagar = function() {
            const jugadorId = document.getElementById('jugadorId').value.trim();
            if (!jugadorId) { alert('?? Por favor ingresa tu ID de jugador.'); return; }

            const items = Object.values(cart);
            if (items.length === 0) { alert('?? Selecciona al menos un producto.'); return; }

            const total = getTotal();

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../../php/crear_pago_mixto.php';

            const productos = items.map(p=>p.nombre).join(' + ');

            [
                ['jugador_id',    jugadorId],
                ['productos',     productos],
                ['total',         total],
                ['monto_parcial', total],
                ['allow_partial', '1'],  // Siempre activar pago mixto
                ['items_json',    JSON.stringify(items)]
            ].forEach(function(pair) {
                const input = document.createElement('input');
                input.type='hidden'; input.name=pair[0]; input.value=pair[1];
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        };

        renderCart();
    })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/code-block.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="../../assets/js/components/driver-tours/tour-rainbowsix.js"></script>
</body>
</html>