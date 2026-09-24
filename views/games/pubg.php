<?php
session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Cash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/styles-juegos-gateway.css">
    <link rel="stylesheet" href="../../assets/css/styles-code-block.css">
    <?php $theme_seccion = 'juegos'; require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>
    <?php require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>
<style>
    /* Tienda de Cash — acento verde */
    :root {
        --gj-accent:        hsl(142, 71%, 55%);
        --gj-accent-glow:   rgba(34, 197, 94, 0.25);
        --gj-accent-soft:   rgba(34, 197, 94, 0.15);
        --gj-accent-hover:  rgba(34, 197, 94, 0.4);
        --gj-accent-dark:   rgb(21, 128, 61);
    }
</style>
<body>
    <?php
    $nav_back_url  = "juegos.php";
    $nav_back_text = "Atras";
    $nav_base      = "../../";
    require_once '../../php/navbar.php';
    ?>
 
  <!-- --- GAME BANNER --- -->
  <div class="game-banner">
    <div class="game-banner__tag">
      <img src="../../assets/imgames/cash/cash-banner.svg" class="card-img-top" alt="" class="game-icon" />
      Tienda de Cash
      <span class="gw-badge"> API Gateway</span>
    </div>
  </div>
      <div class="security-warning">
        <i class="bi bi-shield-exclamation"></i>
        <div style="width: 100%;">
            <div class="security-warning-header" onclick="toggleWarning()">
                <strong>?? Aviso para comercios</strong>
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
            <div class="section-block">
                <p class="section-label">Elige el importe</p>
                <div class="products-grid">

                    <div class="product-card" data-id="1" data-pts="60" data-price="4900" data-original="" data-discount="">
                        <img src="../../assets/imgames/cash/cash-icon.svg" style="height: 40px; width: 40px" alt="">
                        <div class="product-card__pts">60 Cash</div>
                        <div class="product-card__label">Cash</div>
                        <div class="product-card__price">4.900 COP</div>
                    </div>

                    <div class="product-card popular-card" data-id="2" data-pts="325" data-price="21900" data-original="28000" data-discount="21">
                        <div class="badge-popular">? Popular</div>
                        <img src="../../assets/imgames/cash/cash-icon.svg" style="height: 40px; width: 40px" alt="">
                        <div class="product-card__pts">325 Cash</div>
                        <div class="product-card__label">Cash</div>
                        <div class="product-card__price-old">28.000 COP</div>
                        <div class="product-card__price">21.900 COP <span class="discount-tag">-21%</span></div>
                    </div>

                    <div class="product-card" data-id="3" data-pts="660" data-price="39900" data-original="52000" data-discount="23">
                        <img src="../../assets/imgames/cash/cash-icon.svg" style="height: 40px; width: 40px" alt="">
                        <div class="product-card__pts">660 Cash</div>
                        <div class="product-card__label">Cash</div>
                        <div class="product-card__price-old">52.000 COP</div>
                        <div class="product-card__price">39.900 COP <span class="discount-tag">-23%</span></div>
                    </div>

                    <div class="product-card" data-id="4" data-pts="1800" data-price="99900" data-original="135000" data-discount="26">
                        <img src="../../assets/imgames/cash/cash-icon.svg" style="height: 40px; width: 40px" alt="">
                        <div class="product-card__pts">1800 Cash</div>
                        <div class="product-card__label">Cash</div>
                        <div class="product-card__price-old">135.000 COP</div>
                        <div class="product-card__price">99.900 COP <span class="discount-tag">-26%</span></div>
                    </div>

                    <div class="product-card" data-id="5" data-pts="3850" data-price="189900" data-original="260000" data-discount="26">
                        <img src="../../assets/imgames/cash/cash-icon.svg" style="height: 40px; width: 40px" alt="">
                        <div class="product-card__pts">3850 Cash</div>
                        <div class="product-card__label">Cash</div>
                        <div class="product-card__price-old">260.000 COP</div>
                        <div class="product-card__price">189.900 COP <span class="discount-tag">-26%</span></div>
                    </div>
                    <div class="product-card" data-id="6" data-pts="8100" data-price="369900" data-original="500000" data-discount="26">
                        <img src="../../assets/imgames/cash/cash-icon.svg" style="height: 40px; width: 40px" alt="">
                        <div class="product-card__pts">8100 Cash</div>
                        <div class="product-card__label">Cash</div>
                        <div class="product-card__price-old">500.000 COP</div>
                        <div class="product-card__price">369.900 COP <span class="discount-tag">-26%</span></div>
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
                    <div class="sim-mode-hint" id="modoHint">Elige manualmente cómo termina la transacción.</div>
                </div>
            </div>
        </section>

        <!-- CHECKOUT CON FORMULARIO DE PAGO -->
        <aside class="checkout-panel">
            <div class="checkout-box">
                <div class="checkout-product-name"><img id="checkoutImg" src="" alt="" /><span id="checkoutName">?? 325 Cash</span></div>
                <div class="checkout-price-row">
                    <span style="font-size:0.85rem;color:var(--pt-text-sec);">Total</span>
                    <span class="checkout-price" id="checkoutPrice">21.900 COP</span>
                </div>

                <div class="checkout-divider"></div>

                <!-- Tabs método de pago -->
                <div class="payment-tabs" id="paymentTabs">
                    <button class="payment-tab active" id="tabTarjeta" onclick="setPayment('tarjeta')">
                        <i class="bi bi-credit-card-fill"></i> Tarjeta
                    </button>
                    <button class="payment-tab" id="tabCuenta" onclick="setPayment('cuenta')">
                        <i class="bi bi-bank2"></i> Cuenta
                    </button>
                </div>

                <!-- FORMULARIO TARJETA -->
                <div class="form-section active" id="formTarjeta">
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
                        <input type="text" class="field-input" id="cardName" placeholder="Como aparece en la tarjeta" value="<?php echo htmlspecialchars($_SESSION['usuario'] ?? ''); ?>">
                    </div>
                    <div class="field-row">
                        <div class="field-group">
                            <label class="field-label">Tipo de documento</label>
                            <select class="field-input" id="cardTipoDoc">
                                <option value="TI">Tarjeta de Identidad</option> 
                                <option value="CC">Cédula</option>
                                <option value="PP">Pasaporte</option>       
                                <option value="CE">Cédula Extranjería</option>
                                <option value="NIT">NIT</option>
                                <option value="PP">Pasaporte</option>
                            </select>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Número de documento</label>
                            <input type="text" class="field-input" id="cardNumDoc" placeholder="1234567890">
                        </div>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Correo electrónico</label>
                        <input type="email" class="field-input" id="cardCorreo" placeholder="correo@ejemplo.com"
                               value="<?php echo htmlspecialchars($_SESSION['correo'] ?? ''); ?>">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Teléfono</label>
                        <input type="text" class="field-input" id="cardTelefono" placeholder="3001234567">
                    </div>
                </div>

                <!-- FORMULARIO CUENTA -->
                <div class="form-section" id="formCuenta">
                    <div class="field-group">
                        <label class="field-label">Banco</label>
                        <select class="field-input" id="cuentaBanco">
                            <option value="BANCOLOMBIA">Bancolombia</option>
                            <option value="NEQUI">Nequi</option>
                            <option value="DAVIVIENDA">Davivienda</option>
                            <option value="BBVA">BBVA</option>
                            <option value="BOGOTA">Banco de Bogotá</option>
                            <option value="OCCIDENTE">Banco de Occidente</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Tipo de cuenta</label>
                        <select class="field-input" id="cuentaTipo">
                            <option value="AHORROS">Ahorros</option>
                            <option value="CORRIENTE">Corriente</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Número de cuenta</label>
                        <input type="text" class="field-input" id="cuentaNumero" placeholder="0000000000">
                    </div>
                    <div class="field-row">
                        <div class="field-group">
                            <label class="field-label">Tipo de documento</label>
                            <select class="field-input" id="cuentaTipoDoc">
                                <option value="TI">Tarjeta de Identidad</option>
                                <option value="CC">Cédula</option>
                                <option value="PP">Pasaporte</option>  
                                <option value="CE">Cédula Extranjería</option>
                                <option value="NIT">NIT</option>
                            </select>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Número de documento</label>
                            <input type="text" class="field-input" id="cuentaNumDoc" placeholder="1234567890">
                        </div>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Nombre completo</label>
                        <input type="text" class="field-input" id="cuentaNombre" placeholder="Nombre y apellido">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Correo electrónico</label>
                        <input type="email" class="field-input" id="cuentaCorreo" placeholder="correo@ejemplo.com"
                               value="<?php echo htmlspecialchars($_SESSION['correo'] ?? ''); ?>">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Teléfono</label>
                        <input type="text" class="field-input" id="cuentaTelefono" placeholder="3001234567">
                    </div>
                </div>

                <div class="checkout-divider"></div>
                <div class="field-group">
                    <label class="field-label"><i class="bi bi-person-vcard-fill fs-6"></i> ID de jugador</label>
                    <input type="text" class="field-input" id="jugadorIdInput" placeholder="Ej: 123456789" autocomplete="off">
                </div>

                <button class="btn-pagar" id="btnPagar">
                    <i class="bi bi-lock-fill"></i> Pagar ahora
                </button>

                <div class="security-note">
                    <i class="bi bi-shield-check"></i>
                    API Gateway · Evertec PlacetoPay
                </div>
                
            </div>
            <div class="vendor-box">
             <p class="section-label">Designer</p>
                <div class="vendor-info">
                <div class="vendor-avatar">JM</div>
                <div>
                    <div class="vendor-name">Jair ?</div>
                    <div class="vendor-rating">?? 2026 · <a href="#" style="color: rgb(255, 225, 128);">Evertec Placetopay SAS</a></div>
                </div>
            </div>
        </div>
        </aside>
    </main>

    <!-- --- INTEGRACIÓN PLACETOPAY --- -->
    <section class="integration-docs" style="--code-accent:var(--gj-accent); --code-accent-ink:var(--gj-accent-ink); --code-accent-soft:var(--gj-accent-soft); --code-radius-sm:var(--gj-radius-sm); --code-radius-md:var(--gj-radius-md); --code-radius-lg:var(--gj-radius-lg); --code-font:var(--gj-font-body);">
        <span class="integration-docs__badge"><i class="bi bi-braces"></i> Integración PlacetoPay</span>
        <h3>Así se procesa el pago de esta tienda</h3>
        <p>A diferencia de Web Checkout, aquí <strong>no hay redirección</strong>: los datos de la tarjeta (o cuenta) que llenas en este mismo panel viajan en el request de creación de la transacción, y <strong>PlaceToPay Gateway</strong> responde de una vez con el estado final del pago — <code>APPROVED</code>, <code>PENDING</code> o <code>REJECTED</code> — sin devolver un <code>processUrl</code>.</p>

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
    <span class="jk">"reference"</span>: <span class="js">"GW-9F3A2E1C"</span>,
    <span class="jk">"description"</span>: <span class="js">"325 Cash"</span>,
    <span class="jk">"amount"</span>: { <span class="jk">"currency"</span>: <span class="js">"COP"</span>, <span class="jk">"total"</span>: <span class="jn">21900</span> }
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

<span class="cm">// autenticación: Base64( SHA256( nonce + seed + secretKey ) )</span>
<span class="cvar">$seed</span>     = date(<span class="js">'c'</span>);
<span class="cvar">$nonce</span>    = bin2hex(random_bytes(16));
<span class="cvar">$tranKey</span>  = base64_encode(hash(<span class="js">'sha256'</span>, <span class="cvar">$nonce</span> . <span class="cvar">$seed</span> . <span class="cvar">$secretKey</span>, true));
<span class="cvar">$nonceB64</span> = base64_encode(<span class="cvar">$nonce</span>);

<span class="cm">// según el método elegido, el instrumento es tarjeta o cuenta</span>
<span class="cvar">$instrument</span> = <span class="cvar">$metodo</span> === <span class="js">'tarjeta'</span>
    ? [<span class="jk">'card'</span> =&gt; [<span class="jk">'number'</span> =&gt; <span class="cvar">$card_number</span>, <span class="jk">'expiration'</span> =&gt; <span class="cvar">$card_expiry</span>, <span class="jk">'cvv'</span> =&gt; <span class="cvar">$card_cvv</span>]]
    : [<span class="jk">'bank'</span> =&gt; [<span class="jk">'code'</span> =&gt; <span class="cvar">$banco</span>, <span class="jk">'account'</span> =&gt; <span class="cvar">$num_cuenta</span>]];

<span class="cm">// cuerpo del request — así lo arma esta tienda</span>
<span class="cvar">$body</span> = [
    <span class="jk">'auth'</span> =&gt; [
        <span class="jk">'login'</span>   =&gt; <span class="cvar">$login</span>,
        <span class="jk">'tranKey'</span> =&gt; <span class="cvar">$tranKey</span>,
        <span class="jk">'nonce'</span>   =&gt; <span class="cvar">$nonceB64</span>,
        <span class="jk">'seed'</span>    =&gt; <span class="cvar">$seed</span>,
    ],
    <span class="jk">'payer'</span> =&gt; [
        <span class="jk">'name'</span>         =&gt; <span class="cvar">$nombre</span>,
        <span class="jk">'surname'</span>      =&gt; <span class="js">''</span>,
        <span class="jk">'email'</span>        =&gt; <span class="cvar">$correo</span>,
        <span class="jk">'documentType'</span> =&gt; <span class="cvar">$tipo_doc</span>,
        <span class="jk">'document'</span>     =&gt; <span class="cvar">$num_doc</span>,
        <span class="jk">'mobile'</span>       =&gt; <span class="cvar">$telefono</span>,
    ],
    <span class="jk">'payment'</span> =&gt; [
        <span class="jk">'reference'</span>   =&gt; <span class="js">'GW-'</span> . strtoupper(bin2hex(random_bytes(4))),
        <span class="jk">'description'</span> =&gt; <span class="cvar">$producto</span>,               <span class="cm">// ej: "325 Cash"</span>
        <span class="jk">'amount'</span>      =&gt; [<span class="jk">'currency'</span> =&gt; <span class="js">'COP'</span>, <span class="jk">'total'</span> =&gt; (float) <span class="cvar">$precio</span>],
    ],
    <span class="jk">'instrument'</span>      =&gt; <span class="cvar">$instrument</span>,
    <span class="jk">'notificationUrl'</span> =&gt; <span class="cvar">$notifyUrl</span>,
    <span class="jk">'ipAddress'</span>       =&gt; <span class="cvar">$_SERVER</span>[<span class="js">'REMOTE_ADDR'</span>],
    <span class="jk">'userAgent'</span>       =&gt; <span class="cvar">$_SERVER</span>[<span class="js">'HTTP_USER_AGENT'</span>],
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

<span class="cm">// aquí no hay processUrl: el estado ya viene resuelto</span>
<span class="cvar">$estado</span> = <span class="cvar">$result</span>[<span class="js">'status'</span>][<span class="js">'status'</span>]; <span class="cm">// APPROVED / PENDING / REJECTED</span></code></pre>
        </div>

        <div class="doc-note">
            <span class="doc-note-icon">??</span>
            <span>Por eso el aviso de seguridad de esta página: como los datos de tarjeta pasan por nuestra página antes de llegar a PlacetoPay, este flujo requiere <strong>certificación PCI-DSS</strong> en producción. Esta demo no guarda número, fecha ni CVV — se usan solo para armar el request y nunca se persisten en la base de datos.</span>
        </div>

        <a class="integration-docs__link" href="../guias/guia-developer.php#api-gateway">
            <div>
                <strong>¿Quieres entender esta integración a fondo?</strong>
                <span>Lee la documentación completa de API Gateway — alcance PCI-DSS, 3D Secure y más.</span>
            </div>
            <i class="bi bi-arrow-right"></i>
        </a>
    </section>

    <input type="hidden" id="currentPayment" value="tarjeta">

    <script>
    (function() {
        const products = {
            1: { name: ' 60 Cash',   price: '4.900 COP',   precio: 4900   },
            2: { name: ' 325 Cash',  price: '21.900 COP',  precio: 21900  },
            3: { name: ' 660 Cash',  price: '39.900 COP',  precio: 39900  },
            4: { name: ' 1800 Cash', price: '99.900 COP',  precio: 99900  },
            5: { name: ' 3850 Cash', price: '189.900 COP', precio: 189900 },
            6: { name: ' 8100 Cash', price: '369.900 COP', precio: 369900 },
        };

        function updateCheckout(id) {
            const p = products[id];
            if (!p) return;
            document.getElementById('checkoutName').textContent  = p.name;
            document.getElementById('checkoutPrice').textContent = p.price;

            const imgEl   = document.getElementById('checkoutImg');
            const cardImg = document.querySelector('.product-card[data-id="' + id + '"] img');
            if (imgEl && cardImg) {
                imgEl.src = cardImg.getAttribute('src');
                imgEl.style.display = '';
            } else if (imgEl) {
                imgEl.style.display = 'none';
            }
        }

        window.setPayment = function(method) {
            document.getElementById('currentPayment').value = method;
            document.getElementById('tabTarjeta').classList.toggle('active', method === 'tarjeta');
            document.getElementById('tabCuenta').classList.toggle('active', method === 'cuenta');
            document.getElementById('formTarjeta').classList.toggle('active', method === 'tarjeta');
            document.getElementById('formCuenta').classList.toggle('active', method === 'cuenta');
            actualizarDisponibilidadModo(method);
        };

        // Pago por cuenta no puede resolverse de forma automática/instantánea
        // (igual que el mock real de PlacetoPay), así que se bloquea "Pago normal".
        function actualizarDisponibilidadModo(method) {
            const modoAutoBtn = document.getElementById('modoAuto');
            const esCuenta = method === 'cuenta';
            modoAutoBtn.disabled = esCuenta;
            modoAutoBtn.title = esCuenta ? 'No disponible para pagos por cuenta' : '';
            if (esCuenta && modoSimulacion === 'auto') {
                setModo('elegir');
            }
        }

        // Formatear número de tarjeta
        document.getElementById('cardNumber').addEventListener('input', function() {
            let v = this.value.replace(/\D/g, '').substring(0,16);
            this.value = v.replace(/(.{4})/g, '$1 ').trim();
        });

        // Formatear fecha
        document.getElementById('cardExpiry').addEventListener('input', function() {
            let v = this.value.replace(/\D/g, '').substring(0,4);
            if (v.length >= 2) v = v.substring(0,2) + '/' + v.substring(2);
            this.value = v;
        });

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
            var def = document.querySelector('.product-card[data-id="2"]');
            if (def) { def.classList.add('selected'); updateCheckout(2); }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCards);
        } else { initCards(); }

        // -- Modo de simulación --
        let modoSimulacion = 'elegir';
        window.setModo = function(modo) {
            modoSimulacion = modo;
            document.getElementById('modoElegir').classList.toggle('active', modo === 'elegir');
            document.getElementById('modoAuto').classList.toggle('active', modo === 'auto');
            document.getElementById('modoHint').textContent = (modo === 'elegir')
                ? 'Elige manualmente cómo termina la transacción.'
                : 'El estado se asigna automáticamente, como un pago real.';
        };
         let envioEnCurso = false;
        const btnPagarDefaultHTML = document.getElementById('btnPagar').innerHTML;

        // Al volver desde el mock (ej. "Cancelar y volver") el navegador puede
        // restaurar esta página desde bfcache con el botón tal como quedó justo
        // antes de enviar el formulario (deshabilitado y en "Procesando...").
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
            if (envioEnCurso) return; // ya se está procesando, ignorar clics repetidos
            const jugadorId = document.getElementById('jugadorIdInput').value.trim();
            if (!jugadorId) { alert('?? Por favor ingresa tu ID de jugador.'); return; }

            const selectedCard = document.querySelector('.product-card.selected');
            if (!selectedCard) { alert('?? Selecciona un producto.'); return; }

            const method  = document.getElementById('currentPayment').value;
            const producto = document.getElementById('checkoutName').textContent.trim();
            const precio   = document.getElementById('checkoutPrice').textContent.replace(/[^0-9]/g, '');

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = (modoSimulacion === 'auto')
                ? '../../php/crear_pb_gateway.php'
                : '../../retorno/estados-gateway.php';

            const campos = [
                ['producto', producto], ['precio', precio],
                ['jugador_id', jugadorId], ['metodo', method]
            ];

            if (method === 'tarjeta') {
                const cardNum = document.getElementById('cardNumber').value.replace(/\s/g,'');
                const expiry  = document.getElementById('cardExpiry').value;
                const cvv     = document.getElementById('cardCvv').value;
                const name    = document.getElementById('cardName').value;
                const tipoDoc = document.getElementById('cardTipoDoc').value;
                const numDoc  = document.getElementById('cardNumDoc').value;
                const correo  = document.getElementById('cardCorreo').value;
                const tel     = document.getElementById('cardTelefono').value;

                if (!cardNum || !expiry || !cvv || !name || !numDoc || !correo || !tel) {
                    alert('?? Por favor completa todos los campos de tarjeta.'); return;
                }
                campos.push(
                    ['card_number', cardNum], ['card_expiry', expiry],
                    ['card_cvv', cvv], ['card_name', name],
                    ['tipo_doc', tipoDoc], ['num_doc', numDoc],
                    ['correo', correo], ['telefono', tel]
                );
            } else {
                const banco   = document.getElementById('cuentaBanco').value;
                const tipo    = document.getElementById('cuentaTipo').value;
                const numero  = document.getElementById('cuentaNumero').value;
                const tipoDoc = document.getElementById('cuentaTipoDoc').value;
                const numDoc  = document.getElementById('cuentaNumDoc').value;
                const nombre  = document.getElementById('cuentaNombre').value;
                const correo  = document.getElementById('cuentaCorreo').value;
                const tel     = document.getElementById('cuentaTelefono').value;

                if (!numero || !numDoc || !nombre || !correo || !tel) {
                    alert('?? Por favor completa todos los campos de cuenta.'); return;
                }
                campos.push(
                    ['banco', banco], ['tipo_cuenta', tipo],
                    ['num_cuenta', numero], ['tipo_doc', tipoDoc],
                    ['num_doc', numDoc], ['nombre', nombre],
                    ['correo', correo], ['telefono', tel],
                    ['cuenta_banco', banco]
                );
            }

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
    <script src="../../assets/js/components/driver-tours/tour-pubg.js"></script>
</body>
</html>