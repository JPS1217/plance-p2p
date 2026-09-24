<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premier League — Kits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <?php $theme_seccion = 'textiles'; require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../../assets/css/styles-textiles.css">
    <link rel="stylesheet" href="../../assets/css/styles-code-block.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>
<style>
    /* Premier League — acento azul */
    :root {
        --tex-accent:      #3b82f6;
        --tex-accent-rgb:  59, 130, 246;
        --tex-accent-dark: #2563eb;
    }
</style>
<body>
    <?php
    $nav_back_url  = "textiles.php";
    $nav_back_text = "Atras";
    $nav_base      = "../../";
    require_once '../../php/navbar.php';
    ?>

    <div class="game-banner">
        <div class="game-banner__tag">
            <i class="fa-solid fa-futbol" style="color: hsl(207, 100%, 62%);"></i> Premier League — Kits Deportivos
            <span class="link-badge">?? Link de Pago</span>
        </div>
    </div>

    <main class="shop-layout">
        <section class="products-panel" id="productsPanel">
            <p class="section-label">Elige tu equipación</p>
            <div class="products-grid">

                <div class="product-card" data-id="1" data-producto="Kit Liverpool FC" data-precio="50000">
                    <div class="product-card__img">
                        <img src="../../assets/kits/generic/liverpool-icon.svg" alt="Liverpool FC">
                    </div>
                    <div class="product-card__name">Liverpool FC</div>
                    <div class="product-card__label">Camiseta · Temporada 17/18</div>
                    <div class="product-card__price">50.000 COP</div>
                </div>

                <div class="product-card" data-id="2" data-producto="Kit Manchester City" data-precio="50000">
                    <div class="product-card__img">
                        <img src="../../assets/kits/generic/mancity-icon.svg" alt="Manchester City">
                    </div>
                    <div class="product-card__name">Manchester City</div>
                    <div class="product-card__label">Camiseta · Temporada 18/19</div>
                    <div class="product-card__price">50.000 COP</div>
                </div>

                <div class="product-card" data-id="3" data-producto="Kit Manchester United" data-precio="50000">
                    <div class="product-card__img">
                        <img src="../../assets/kits/generic/manutd-icon.svg" alt="Manchester United">
                    </div>
                    <div class="product-card__name">Manchester United</div>
                    <div class="product-card__label">Camiseta · Temporada 18/19</div>
                    <div class="product-card__price">50.000 COP</div>
                </div>
                
                <div class="product-card" data-id="4" data-producto="Kit Chelsea FC" data-precio="50000">
                    <div class="product-card__img">
                        <img src="../../assets/kits/generic/chelsea-icon.svg" alt="Chelsea FC">
                    </div>
                    <div class="product-card__name">Chelsea FC</div>
                    <div class="product-card__label">Camiseta · Temporada 23/24</div>
                    <div class="product-card__price">50.000 COP</div>
                </div>

                <div class="product-card" data-id="5" data-producto="Kit Arsenal FC" data-precio="50000">
                    <div class="product-card__img">
                        <img src="../../assets/kits/generic/arsenal-icon.svg" alt="Arsenal FC">
                    </div>
                    <div class="product-card__name">Arsenal FC</div>
                    <div class="product-card__label">Camiseta · Temporada 24/25</div>
                    <div class="product-card__price">50.000 COP</div>
                </div>

                <div class="product-card" data-id="6" data-producto=" West Ham United" data-precio="50000">
                    <div class="product-card__img">
                        <img src="../../assets/kits/generic/westham-icon.svg" alt="west-ham">
                    </div>
                    <div class="product-card__name">West Ham United</div>
                    <div class="product-card__label">Camiseta · Temporada 24/25</div>
                    <div class="product-card__price">50.000 COP</div>
                </div>

                <div class="product-card" data-id="7" data-producto="Kit Tottenham Hotspur" data-precio="50000">
                    <div class="product-card__img">
                        <img src="../../assets/kits/generic/tottenham-icon.svg" alt="Tottenham Hotspur">
                    </div>
                    <div class="product-card__name">Tottenham Hotspur</div>
                    <div class="product-card__label">Camiseta · Temporada 22/23</div>
                    <div class="product-card__price">50.000 COP</div>
                </div>

                <div class="product-card" data-id="8" data-producto="Kit Aston Villa" data-precio="50000">
                    <div class="product-card__img">
                        <img src="../../assets/kits/generic/astonvilla-icon.svg" alt="Aston Villa">
                    </div>
                    <div class="product-card__name">Aston Villa</div>
                    <div class="product-card__label">Camiseta · Temporada 21/22</div>
                    <div class="product-card__price">50.000 COP</div>
                </div>

            </div>
        </section>

        <!-- CHECKOUT -->
        <aside class="checkout-panel">
            <div class="checkout-box">
                <div class="checkout-header">
                    <div class="checkout-product-img" id="checkoutImg">??</div>
                    <div class="checkout-product-info">
                        <div class="checkout-product-name" id="checkoutName">Liverpool FC</div>
                        <div class="checkout-product-label">Camiseta · Temporada 24/25</div>
                        <div class="checkout-price-row">
                            <span style="font-size:0.85rem;color:var(--pt-text-sec);">Total</span>
                            <span class="checkout-price">50.000 COP</span>
                        </div>
                    </div>
                </div>

                <div class="link-info" id="linkInfo">
                    <i class="bi bi-link-45deg" style="font-size:1rem;flex-shrink:0;"></i>
                    <span>Se generará un <strong>link de pago</strong> que podrás compartir por correo, WhatsApp o redes sociales. El link expira en 24 horas.</span>
                </div>

                <div class="checkout-divider"></div>
                <span class="section-label-sm">Datos del comprador</span>

                <div class="field-group">
                    <label class="field-label">Correo electrónico</label>
                    <input type="email" class="field-input" id="correoInput"
                           value="<?php echo htmlspecialchars($_SESSION['correo'] ?? ''); ?>"
                           placeholder="correo@ejemplo.com">
                </div>
                <div class="field-group">
                    <label class="field-label">Nombre completo</label>
                    <input type="text" class="field-input" id="nombreInput" placeholder="Nombre y apellido">
                </div>

                <button class="btn-generar" id="btnGenerar">
                    <i class="bi bi-link-45deg"></i> Generar link de pago
                </button>
                <div class="security-note">
                    <i class="bi bi-shield-check"></i>
                    Link de Pago · PlacetoPay · Evertec
                </div>
            </div>
        </aside>
    </main>

    <!-- --- INTEGRACIÓN PLACETOPAY --- -->
    <section class="integration-docs" style="--code-accent:var(--tex-accent); --code-accent-ink:var(--tex-accent-ink); --code-accent-soft:rgba(var(--tex-accent-rgb),0.12); --code-radius-sm:var(--tex-radius-sm); --code-radius-md:var(--tex-radius-md); --code-radius-lg:var(--tex-radius-lg); --code-font:var(--tex-font);">
        <span class="integration-docs__badge"><i class="bi bi-braces"></i> Integración PlacetoPay</span>
        <h3>Así se genera el link de pago de esta tienda</h3>
        <p>Cuando presionas <strong>"Generar link de pago"</strong>, nuestro backend arma este request y lo envía a la <strong>API de Link de Pagos</strong> de PlacetoPay — un endpoint distinto al de Web Checkout. La respuesta trae una URL que puedes compartir por correo, WhatsApp o redes: quien la abra paga sin que tú tengas que estar presente.</p>

        <div class="endpoint-bar">
            <span class="method-pill">POST</span>
            <span class="endpoint-url">https://sites-test.placetopay.com/api/payment-link</span>
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
  <span class="jk">"locale"</span>: <span class="js">"es_CO"</span>,
  <span class="jk">"name"</span>: <span class="js">"Kit Liverpool FC"</span>,
  <span class="jk">"description"</span>: <span class="js">"Kit deportivo: Kit Liverpool FC"</span>,
  <span class="jk">"reference"</span>: <span class="js">"PL-9F3A2E1C"</span>,
  <span class="jk">"paymentsAllowed"</span>: <span class="jn">12</span>,
  <span class="jk">"expirationDate"</span>: <span class="js">"2026-08-26 10:15:32"</span>,
  <span class="jk">"paymentExpiration"</span>: <span class="jn">15</span>,
  <span class="jk">"payment"</span>: {
    <span class="jk">"amount"</span>: { <span class="jk">"currency"</span>: <span class="js">"COP"</span>, <span class="jk">"total"</span>: <span class="jn">50000</span> }
  },
  <span class="jk">"paymentMethod"</span>: [<span class="js">"pse"</span>, <span class="js">"visa"</span>, <span class="js">"mastercard"</span>],
  <span class="jk">"notificationUrl"</span>: <span class="js">"https://tu-dominio.com/php/notify.php"</span>,
  <span class="jk">"receiverEmails"</span>: [<span class="js">"comprador@correo.com"</span>]
}</code></pre>
            <pre class="code-panel" data-key="php"><code>&lt;?php
<span class="cm">// credenciales fuera del código, nunca hardcodeadas</span>
<span class="cvar">$login</span>     = getenv(<span class="js">'P2P_LOGIN'</span>);
<span class="cvar">$secretKey</span> = getenv(<span class="js">'P2P_SECRET_KEY'</span>);
<span class="cvar">$url</span>       = <span class="js">'https://sites-test.placetopay.com/api/payment-link'</span>;

<span class="cm">// autenticación: Base64( SHA256( nonce + seed + secretKey ) )</span>
<span class="cvar">$seed</span>     = date(<span class="js">'c'</span>);
<span class="cvar">$nonce</span>    = bin2hex(random_bytes(16));
<span class="cvar">$tranKey</span>  = base64_encode(hash(<span class="js">'sha256'</span>, <span class="cvar">$nonce</span> . <span class="cvar">$seed</span> . <span class="cvar">$secretKey</span>, true));
<span class="cvar">$nonceB64</span> = base64_encode(<span class="cvar">$nonce</span>);

<span class="cm">// el link expira en 24h; cada pago individual, en 15 min</span>
<span class="cvar">$expiracion</span> = date(<span class="js">'Y-m-d H:i:s'</span>, strtotime(<span class="js">'+24 hours'</span>));

<span class="cm">// cuerpo del request — así lo arma esta tienda</span>
<span class="cvar">$data</span> = [
    <span class="jk">'auth'</span> =&gt; [
        <span class="jk">'login'</span>   =&gt; <span class="cvar">$login</span>,
        <span class="jk">'tranKey'</span> =&gt; <span class="cvar">$tranKey</span>,
        <span class="jk">'nonce'</span>   =&gt; <span class="cvar">$nonceB64</span>,
        <span class="jk">'seed'</span>    =&gt; <span class="cvar">$seed</span>,
    ],
    <span class="jk">'locale'</span>            =&gt; <span class="js">'es_CO'</span>,
    <span class="jk">'name'</span>              =&gt; <span class="cvar">$producto</span>,
    <span class="jk">'description'</span>       =&gt; <span class="js">'Kit deportivo: '</span> . <span class="cvar">$producto</span>,
    <span class="jk">'reference'</span>         =&gt; <span class="js">'PL-'</span> . strtoupper(bin2hex(random_bytes(4))),
    <span class="jk">'paymentsAllowed'</span>   =&gt; 12,
    <span class="jk">'expirationDate'</span>    =&gt; <span class="cvar">$expiracion</span>,
    <span class="jk">'paymentExpiration'</span> =&gt; 15,
    <span class="jk">'payment'</span>           =&gt; [
        <span class="jk">'amount'</span> =&gt; [<span class="jk">'currency'</span> =&gt; <span class="js">'COP'</span>, <span class="jk">'total'</span> =&gt; (float) <span class="cvar">$precio</span>],
    ],
    <span class="jk">'paymentMethod'</span>   =&gt; [<span class="js">'pse'</span>, <span class="js">'visa'</span>, <span class="js">'mastercard'</span>],
    <span class="jk">'notificationUrl'</span> =&gt; <span class="cvar">$notifyUrl</span>,
    <span class="jk">'receiverEmails'</span>  =&gt; [<span class="cvar">$correo</span>],
];

<span class="cvar">$ch</span> = curl_init(<span class="cvar">$url</span>);
curl_setopt_array(<span class="cvar">$ch</span>, [
    CURLOPT_POST           =&gt; true,
    CURLOPT_RETURNTRANSFER =&gt; true,
    CURLOPT_HTTPHEADER     =&gt; [<span class="js">'Content-Type: application/json'</span>],
    CURLOPT_POSTFIELDS     =&gt; json_encode(<span class="cvar">$data</span>),
]);

<span class="cvar">$result</span>   = json_decode(curl_exec(<span class="cvar">$ch</span>), true);
curl_close(<span class="cvar">$ch</span>);

<span class="cm">// el link generado — es lo que se comparte con el comprador</span>
<span class="cvar">$link_url</span> = <span class="cvar">$result</span>[<span class="js">'url'</span>] ?? <span class="cvar">$result</span>[<span class="js">'link'</span>] ?? <span class="js">''</span>;</code></pre>
        </div>

        <div class="doc-note">
            <span class="doc-note-icon">??</span>
            <span>El link vive <strong>24 horas</strong> (<code>expirationDate</code>) y cada intento de pago individual dentro de ese link expira a los <strong>15 minutos</strong> (<code>paymentExpiration</code>). <code>receiverEmails</code> envía automáticamente el link al correo del comprador, además de mostrarlo en pantalla.</span>
        </div>

        <a class="integration-docs__link" href="../guias/guia-developer.php#link-pagos">
            <div>
                <strong>¿Quieres entender esta integración a fondo?</strong>
                <span>Lee la documentación completa sobre Link de Pagos en PlacetoPay.</span>
            </div>
            <i class="bi bi-arrow-right"></i>
        </a>
    </section>

    <script>
    (function() {
        // ====================================================================
        // ?? SISTEMA AUTOMÁTICO DE IMÁGENES
        // ====================================================================
        // El sistema detecta automáticamente si una card tiene imagen PNG
        // y la sincroniza con el checkout. Solo agrega tus imágenes en el HTML.
        // ====================================================================

        function updateCheckoutFromCard(card) {
            const cardImg = card.querySelector('.product-card__img');
            const checkoutImg = document.getElementById('checkoutImg');
            
            // Verificar si la card tiene una imagen <img> o solo emoji/texto
            const imgElement = cardImg.querySelector('img');
            
            if (imgElement) {
                // Tiene imagen PNG - clonarla al checkout
                checkoutImg.innerHTML = '<img src="' + imgElement.src + '" alt="' + imgElement.alt + '">';
            } else {
                // Solo tiene emoji/texto - copiar el contenido
                checkoutImg.innerHTML = cardImg.innerHTML;
            }
            
            // Actualizar nombre del producto
            const productName = card.querySelector('.product-card__name').textContent;
            document.getElementById('checkoutName').textContent = productName;
        }

        function initCards() {
            const cards = document.querySelectorAll('.product-card');
            if (cards.length === 0) { setTimeout(initCards, 100); return; }
            
            cards.forEach(function(card) {
                card.addEventListener('click', function() {
                    cards.forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');
                    updateCheckoutFromCard(card);
                });
            });
            
            // Seleccionar el primer producto por defecto
            var def = document.querySelector('.product-card[data-id="1"]');
            if (def) {
                def.classList.add('selected');
                updateCheckoutFromCard(def);
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCards);
        } else { initCards(); }

        document.getElementById('btnGenerar').addEventListener('click', function() {
            const selected = document.querySelector('.product-card.selected');
            if (!selected) { alert('?? Selecciona una equipación primero.'); return; }

            const correo = document.getElementById('correoInput').value.trim();
            const nombre = document.getElementById('nombreInput').value.trim();

            if (!correo) { alert('?? Por favor ingresa tu correo electrónico.'); return; }
            if (!nombre) { alert('?? Por favor ingresa tu nombre.'); return; }

            const producto = selected.getAttribute('data-producto');
            const precio   = selected.getAttribute('data-precio');

            const btn = document.getElementById('btnGenerar');
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Generando link...';

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../../php/crear_link_pago.php';

            [['producto', producto], ['precio', precio],
             ['correo', correo], ['nombre', nombre]].forEach(function(pair) {
                const input = document.createElement('input');
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
    <script src="../../assets/js/components/driver-tours/tour-pl.js"></script>
</body>
</html>




























