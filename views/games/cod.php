<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Monedas</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/styles-juegos.css">
    <link rel="stylesheet" href="../../assets/css/styles-code-block.css">
    <?php $theme_seccion = 'juegos'; require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">

</head>
<style>
    /* Tienda de Monedas — acento dorado */
    :root {
        --gj-accent:        #f0b429;
        --gj-accent-glow:   rgba(240, 180, 41, 0.25);
        --gj-accent-soft:   rgba(240, 180, 41, 0.15);
        --gj-accent-hover:  rgba(240, 180, 41, 0.4);
        --gj-accent-dark:   #c99010;
    }
</style>
<body>
      <?php
        $nav_back_url  = "juegos.php";
        $nav_back_text = "Atras";
        $nav_base      = "../../";
        require_once '../../php/navbar.php';
      ?>
  <!-- BANNER -->
  <div class="game-banner">
    <div class="game-banner__tag">
      <img src="../../assets/imgames/monedas/coin-banner.svg" class="card-img-top" alt="Monedas" style="height:40px;width:auto;" >
      Tienda de Monedas
    </div>
  </div>

  <!-- --- MAIN LAYOUT --- -->
  <main class="shop-layout">

    <!-- IZQ: Productos Panel -->
    <section class="products-panel">

      <!-- Products Grid -->
      <div class="section-block" id="bloque-productos">
        <p class="section-label">Elige el producto</p>
        <div class="products-grid" id="productsGrid">

          <div class="product-card" data-id="1" data-pts="88" data-price="16614" data-original="" data-discount="">
            <img src="../../assets/imgames/monedas/coin-icon.svg" style="height: 40px; width: 40px" alt="">
            <div class="product-card__pts">88</div>
            <div class="product-card__label">Monedas</div>
            <div class="product-card__price">7.000 COP</div>
          </div>

          <div class="product-card popular-card" data-id="2" data-pts="500" data-price="12927" data-original="18972" data-discount="32">
            <div class="badge-popular">? Popular</div>
            <img src="../../assets/imgames/monedas/coin-icon.svg" style="height: 25px; width: 40px" alt="">
            <div class="product-card__pts">460</div>
            <div class="product-card__label">Monedas</div>
            <div class="product-card__price-old">18.972 COP</div>
            <div class="product-card__price">12.927 COP <span class="discount-tag">-32%</span></div>
          </div>

          <div class="product-card" data-id="3" data-pts="1100" data-price="26233" data-original="37981" data-discount="31">
             <img src="../../assets/imgames/monedas/coin-icon.svg" style="height: 40px; width: 40px" alt="">
            <div class="product-card__pts">1100</div>
            <div class="product-card__label">Monedas</div>
            <div class="product-card__price-old">9.000 COP</div>
            <div class="product-card__price">26.233 COP <span class="discount-tag">-31%</span></div>
          </div>

          <div class="product-card" data-id="4" data-pts="2400" data-price="29921" data-original="74000" data-discount="61">
            <img src="../../assets/imgames/monedas/coin-icon.svg" style="height: 40px; width: 40px" alt="">


            <div class="product-card__pts">2400</div>
            <div class="product-card__label">Monedas</div>
            <div class="product-card__price-old">74.000 COP</div>
            <div class="product-card__price">29.921 COP <span class="discount-tag">-61%</span></div>
          </div>

          <div class="product-card" data-id="5" data-pts="5000" data-price="56611" data-original="152039" data-discount="62">
            <img src="../../assets/imgames/monedas/coin-icon.svg" style="height: 40px; width: 40px" alt="">
            <div class="product-card__pts">5000</div>
            <div class="product-card__label">Monedas</div>
            <div class="product-card__price-old">152.039 COP</div>
            <div class="product-card__price">56.611 COP <span class="discount-tag">-62%</span></div>
          </div>

          <div class="product-card" data-id="6" data-pts="9500" data-price="94858" data-original="285406" data-discount="67">
            <img src="../../assets/imgames/monedas/coin-icon.svg" style="height: 40px; width: 40px" alt="">
            <div class="product-card__pts">9500</div>
            <div class="product-card__label">Monedas</div>
            <div class="product-card__price-old">285.406 COP</div>
            <div class="product-card__price">94.858 COP <span class="discount-tag">-67%</span></div>
          </div>

          <div class="product-card" data-id="7" data-pts="13000" data-price="142762" data-original="380154" data-discount="63">
            <img src="../../assets/imgames/monedas/coin-icon.svg" style="height: 40px; width: 40px" alt="">
            <div class="product-card__pts">13000</div>
            <div class="product-card__label">Monedas</div>
            <div class="product-card__price-old">380.154 COP</div>
            <div class="product-card__price">142.762 COP <span class="discount-tag">-63%</span></div>
          </div>


          <div class="product-card" data-id="8" data-pts="21000" data-price="216215" data-original="579249" data-discount="63">
            <img src="../../assets/imgames/monedas/coin-icon.svg" style="height: 40px; width: 40px" alt="">
            <div class="product-card__pts">21000</div>
            <div class="product-card__label">Monedas</div>
            <div class="product-card__price-old">579.249 COP</div>
            <div class="product-card__price">216.215 COP <span class="discount-tag">-63%</span></div>
          </div>

          <div class="product-card" data-id="9" data-pts="26000" data-price="262066" data-original="760307" data-discount="66">
            <img src="../../assets/imgames/monedas/coin-icon.svg" style="height: 40px; width: 40px" alt="">
            <div class="product-card__pts">26000</div>
            <div class="product-card__label">Monedas</div>
            <div class="product-card__price-old">760.307 COP</div>
            <div class="product-card__price">262.066 COP <span class="discount-tag">-66%</span></div>
          </div>

          <div class="product-card" data-id="10" data-pts="39000" data-price="387339" data-original="1140461" data-discount="67">
            <img src="../../assets/imgames/monedas/coin-icon.svg" style="height: 40px; width: 40px" alt="">
            <div class="product-card__pts">39000</div>
            <div class="product-card__label">Monedas</div>
            <div class="product-card__price-old">1.140.461 COP</div>
            <div class="product-card__price">387.339 COP <span class="discount-tag">-67%</span></div>
          </div>

          <div class="product-card battlepass-card" data-id="11" data-pts="Battle Pass" data-price="106187" data-original="114019" data-discount="7">
            <img src="../../assets/imgames/comunes/pase-icon.svg" style="height: 40px; width: 40px" alt="">
            <div class="product-card__pts" style="font-size:0.85rem;">Pase VIP</div>
            <div class="product-card__label">Pase VIP</div>
            <div class="product-card__price-old">38.000 COP</div>
            <div class="product-card__price">24.000 COP <span class="discount-tag">-7%</span></div>
          </div>

        </div>
      </div>
    </section>

    <!-- Derecha: Checkout Panel -->
    <aside class="checkout-panel" id="checkoutPanel">

      <div class="checkout-summary">
        <div class="checkout-product-name">
          <img id="checkoutImg" src="" alt="" />
          <span id="checkoutName"></span>
        </div>
        <div class="checkout-row">
          <span class="checkout-label">Plazo de entrega</span>
          <span class="checkout-delivery">Instante</span>
        </div>

        <div class="checkout-divider"></div>

        <div class="checkout-row checkout-total-row">
          <span class="checkout-label">Total</span>
          <div class="checkout-pricing">
            <span class="checkout-original" id="checkoutOriginal">18.972 COP</span>
            <div class="checkout-final-row">
              <span class="checkout-badge" id="checkoutBadge">-32%</span>
              <span class="checkout-final-price" id="checkoutPrice">12.927 COP</span>
            </div>
          </div>
        </div>

        <div class="checkout-player-id">
          <label for="jugadorIdInput"><i class="bi bi-person-vcard-fill fs-6"></i> ID de jugador</label>
          <input type="text" id="jugadorIdInput" placeholder="Ej: 0011122224444555" autocomplete="off" />
        </div>

        <button class="btn-buy" id="btnBuy">
          <span>Comprar ahora</span>
          <span class="btn-arrow">?</span>
        </button>


        <div class="checkout-divider"></div>

        <!--- <div class="trust-badges">
          <div class="trust-item"><i class="bi bi-shield-check fs-6 text-warning"></i><span>Garantía de reembolso · P2P</span></div>
          <div class="trust-item"><i class="bi bi-lightning-fill fs-6 text-warning"></i><span>Pago rápido · Apple Pay / G Pay</span></div>
          <div class="trust-item"><i class="bi bi-headset fs-6 text-warning"></i><span>Asistencia en directo 24/7 — ¡A tu lado!</span></div>
        </div>
      </div> -->

      <div class="session-instructions">
        <p class="section-label">Instrucciones para crear sesión</p>
        <ol class="session-steps">
          <li class="session-step">
            <span class="session-step__num">1</span>
            <div class="session-step__body">
              <span class="session-step__title">Digita tu ID de jugador</span>
              <span class="session-step__desc">Escríbelo en el campo "ID de jugador" del panel de la derecha, tal como aparece en tu cuenta del juego.</span>
            </div>
          </li>
          <li class="session-step">
            <span class="session-step__num">2</span>
            <div class="session-step__body">
              <span class="session-step__title">Elige el producto</span>
              <span class="session-step__desc">Selecciona la cantidad de puntos o el paquete que quieres comprar en el panel de la izquierda.</span>
            </div>
          </li>
          <li class="session-step">
            <span class="session-step__num">3</span>
            <div class="session-step__body">
              <span class="session-step__title">Crea tu sesión de pago</span>
              <span class="session-step__desc">Presiona "Comprar ahora" para generar tu sesión y completar el pago de forma segura.</span>
            </div>
          </li>
        </ol>
      </div>

      <div class="vendor-box">
        <p class="section-label">Designer</p>
        <div class="vendor-info">
          <div class="vendor-avatar">JM</div>
          <div>
            <div class="vendor-name">Jair ?</div>
            <div class="vendor-rating">?? 2026 · <a href="#">Evertec Placetopay SAS</a></div>
          </div>
        </div>
      </div>

    </aside>
  </main>

  <!-- --- INTEGRACIÓN PLACETOPAY --- -->
  <section class="integration-docs" style="--code-accent:var(--gj-accent); --code-accent-ink:var(--gj-accent-ink); --code-accent-soft:var(--gj-accent-soft); --code-radius-sm:var(--gj-radius-sm); --code-radius-md:var(--gj-radius-md); --code-radius-lg:var(--gj-radius-lg); --code-font:var(--gj-font-body);">
    <span class="integration-docs__badge"><i class="bi bi-braces"></i> Integración PlacetoPay</span>
    <h3>Así se crea la sesión de pago de esta tienda</h3>
    <p>Cuando presionas <strong>"Comprar ahora"</strong>, nuestro backend arma este mismo request y lo envía a <strong>PlacetoPay Web Checkout</strong>. La respuesta trae un <code>processUrl</code> al que te redirigimos para pagar con tarjeta o PSE — tus datos de pago nunca pasan por nuestro servidor.</p>

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
    <span class="jk">"reference"</span>: <span class="js">"ORD-000482"</span>,
    <span class="jk">"description"</span>: <span class="js">"460 Monedas"</span>,
    <span class="jk">"amount"</span>: { <span class="jk">"currency"</span>: <span class="js">"COP"</span>, <span class="jk">"total"</span>: <span class="jn">12927</span> }
  },
  <span class="jk">"expiration"</span>: <span class="js">"2026-08-25T11:15:32-05:00"</span>,
  <span class="jk">"returnUrl"</span>: <span class="js">"https://tu-dominio.com/retorno/retorno.php?order=482"</span>,
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

<span class="cm">// cuerpo del request — así lo arma esta tienda</span>
<span class="cvar">$data</span> = [
    <span class="jk">'auth'</span> =&gt; [
        <span class="jk">'login'</span>   =&gt; <span class="cvar">$login</span>,
        <span class="jk">'tranKey'</span> =&gt; <span class="cvar">$tranKey</span>,
        <span class="jk">'nonce'</span>   =&gt; <span class="cvar">$nonceB64</span>,
        <span class="jk">'seed'</span>    =&gt; <span class="cvar">$seed</span>,
    ],
    <span class="jk">'payment'</span> =&gt; [
        <span class="jk">'reference'</span>   =&gt; <span class="js">'ORD-'</span> . str_pad(<span class="cvar">$order_id</span>, 6, <span class="js">'0'</span>, STR_PAD_LEFT),
        <span class="jk">'description'</span> =&gt; <span class="cvar">$producto</span>,               <span class="cm">// ej: "460 Monedas"</span>
        <span class="jk">'amount'</span>      =&gt; [<span class="jk">'currency'</span> =&gt; <span class="js">'COP'</span>, <span class="jk">'total'</span> =&gt; (float) <span class="cvar">$precio</span>],
    ],
    <span class="jk">'expiration'</span> =&gt; date(<span class="js">'c'</span>, strtotime(<span class="js">'+1 hour'</span>)),
    <span class="jk">'returnUrl'</span>  =&gt; app_base_url() . <span class="js">'/retorno/retorno.php?order='</span> . <span class="cvar">$order_id</span>,
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
      <span class="doc-note-icon">??</span>
      <span>Este flujo es <strong>Web Checkout de pago único</strong>: un solo cobro por el valor de los puntos elegidos, sin tokenizar tarjeta ni programar cobros futuros. Cuando vuelvas de la pasarela, consultamos el estado real de la sesión antes de entregar los puntos.</span>
    </div>

    <a class="integration-docs__link" href="../guias/guia-developer.php#web-checkout">
      <div>
        <strong>¿Quieres entender esta integración a fondo?</strong>
        <span>Lee la documentación completa de Web Checkout — autenticación, notificaciones y más.</span>
      </div>
      <i class="bi bi-arrow-right"></i>
    </a>
  </section>

  <!--JS -->
  <script>
  (function() {

    const products = {
      1:  { name: '88 Monedas',        price: '7.000 COP',  original: '',              badge: '',     delivery: 'Instante' },
      2:  { name: '460 Monedas',        price: '12.927 COP',  original: '18.972 COP',    badge: '-32%', delivery: 'Instante' },
      3:  { name: '1100 Monedas',       price: '26.233 COP',  original: '37.981 COP',    badge: '-31%', delivery: 'Instante' },
      4:  { name: '2400 Monedas',       price: '29.921 COP',  original: '74.000 COP',    badge: '-61%', delivery: 'Instante' },
      5:  { name: '5000 Monedas',       price: '56.611 COP',  original: '152.039 COP',   badge: '-62%', delivery: 'Instante' },
      6:  { name: '9500 Monedas',       price: '94.858 COP',  original: '285.406 COP',   badge: '-67%', delivery: 'Instante' },
      7:  { name: '13000 Monedas',      price: '142.762 COP', original: '380.154 COP',   badge: '-63%', delivery: 'Instante' },
      8:  { name: '21000 Monedas',      price: '216.215 COP', original: '579.249 COP',   badge: '-63%', delivery: 'Instante' },
      9:  { name: '26000 Monedas',      price: '262.066 COP', original: '760.307 COP',   badge: '-66%', delivery: 'Instante' },
      10: { name: '39000 Monedas',      price: '387.339 COP', original: '1.140.461 COP', badge: '-67%', delivery: 'Instante' },
      11: { name: 'Pase VIP', price: '24.000 COP', original: '38.000 COP',   badge: '-37%',  delivery: 'Instante' },
    };

    function updateCheckout(id) {
      const p = products[id];
      if (!p) return;

      document.getElementById('checkoutName').textContent  = p.name;
      document.getElementById('checkoutPrice').textContent = p.price;

      const imgEl  = document.getElementById('checkoutImg');
      const cardImg = document.querySelector('.product-card[data-id="' + id + '"] img');
      if (imgEl && cardImg) {
        imgEl.src = cardImg.getAttribute('src');
        imgEl.style.display = '';
      } else if (imgEl) {
        imgEl.style.display = 'none';
      }

      const origEl  = document.getElementById('checkoutOriginal');
      const badgeEl = document.getElementById('checkoutBadge');

      if (p.original) {
        origEl.textContent   = p.original;
        badgeEl.textContent  = p.badge;
        origEl.style.display  = '';
        badgeEl.style.display = '';
      } else {
        origEl.style.display  = 'none';
        badgeEl.style.display = 'none';
      }
    }

    function initCards() {
      const cards = document.querySelectorAll('.product-card');

      if (cards.length === 0) {
        // Si el DOM aún no está listo, reintenta
        setTimeout(initCards, 100);
        return;
      }

      cards.forEach(function(card) {
        card.addEventListener('click', function() {
          cards.forEach(function(c) { c.classList.remove('selected'); });
          card.classList.add('selected');
          updateCheckout(parseInt(card.getAttribute('data-id')));
        });
      });

      // Selección por defecto: tarjeta 460 Monedas
      var def = document.querySelector('.product-card[data-id="2"]');
      if (def) {
        def.classList.add('selected');
        updateCheckout(2);
      }
    }

    // Funciona tanto si el DOM ya cargó como si no
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initCards);
    } else {
      initCards();
    }

    // Buy button
    document.addEventListener('click', function(e) {
      var btn = e.target.closest('#btnBuy');
      if (!btn) return;

      var jugadorId = document.getElementById('jugadorIdInput').value.trim();
      if (!jugadorId) {
        alert('?? Por favor ingresa tu ID de jugador antes de continuar.');
        document.getElementById('jugadorIdInput').focus();
        return;
      }

      var producto = document.getElementById('checkoutName').textContent.trim();
      var precio   = document.getElementById('checkoutPrice').textContent.replace(/[^0-9]/g, '');

      var form = document.createElement('form');
      form.method = 'POST';
      form.action = '../../php/crear_orden.php';

      [['producto', producto], ['precio', precio], ['jugador_id', jugadorId]].forEach(function(pair) {
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
  <script src="../../assets/js/code-block.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
  <script src="../../assets/js/components/driver-tours/tour-cod.js"></script>
</body>
</html>