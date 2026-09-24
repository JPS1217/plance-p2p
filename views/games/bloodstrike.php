<?php
session_start();

// Sin base de datos: la precarga de un pago mixto en curso dependia de una
// orden almacenada. Sin persistencia siempre se inicia un pago nuevo.
$continuar_orden = null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Esmeraldas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">



    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/styles-juegos-gateway.css">
    <link rel="stylesheet" href="../../assets/css/styles-code-block.css">
    <?php $theme_seccion = 'juegos'; require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>
<style>
    /* Tienda de Esmeraldas — acento esmeralda, tipografía Barlow */
    :root {
        --gj-accent:        #10b981;
        --gj-accent-glow:   rgba(16, 185, 129, 0.25);
        --gj-accent-soft:   rgba(16, 185, 129, 0.15);
        --gj-accent-hover:  rgba(16, 185, 129, 0.4);
        --gj-accent-dark:   #065f46;
        --gj-font-display:  'Barlow', sans-serif;
        --gj-font-body:     'Barlow', sans-serif;
    }

    .field-hint { display:block; font-size:0.72rem; color:var(--pt-text-sec); margin-top:0.35rem; }
    .field-hint.hint-error { color:#e05252; }

    .continuar-orden-banner {
        margin: 0 2rem 1rem;
        padding: 0.7rem 1.1rem;
        background: var(--gj-accent-soft);
        border: 1px solid var(--gj-accent);
        border-radius: var(--gj-radius-sm);
        color: var(--pt-text);
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        flex-wrap: wrap;
    }

    .continuar-orden-card {
        border: 1.5px solid var(--pt-border);
        border-radius: var(--gj-radius-md);
        padding: 1rem 1.1rem;
    }
    .continuar-orden-title { font-weight: 700; margin-bottom: 0.6rem; }
    .continuar-orden-row { display:flex; justify-content:space-between; font-size:0.85rem; padding:0.3rem 0; color: var(--pt-text-sec); }
    .continuar-orden-row.continuar-orden-saldo { color: var(--gj-accent); font-weight: 700; border-top: 1px solid var(--pt-border); margin-top: 0.3rem; padding-top: 0.6rem; }
</style>
<body>
    <?php
    $nav_back_url  = "juegos.php";
    $nav_back_text = "Atras";
    $nav_base      = "../../";
    require_once '../../php/navbar.php';
    ?>

    <div class="game-banner">
        <div class="game-banner__tag">
            ?? Tienda de Esmeraldas
            <span class="gw-badge">? API Gateway</span>
            <span class="gw-badge" id="pagoMixtoBadge"><i class="bi bi-shuffle"></i> Pago Mixto</span>
            <!--<span class="tds-badge"><i class="bi bi-shield-lock-fill"></i> 3DS Obligatorio</span -->
        </div>

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

    <?php if ($continuar_orden): ?>
    <div class="continuar-orden-banner">
        <i class="bi bi-arrow-repeat"></i>
        Completando la orden <strong>#<?= (int) $continuar_orden['id'] ?></strong> — saldo pendiente:
        <strong>$<?= number_format($continuar_orden['saldo'], 0, ',', '.') ?> COP</strong>
    </div>
    <?php endif; ?>

    <main class="shop-layout">
        <section class="products-panel" id="productsPanel">
            <?php if ($continuar_orden): ?>
            <p class="section-label">Orden en curso</p>
            <div class="continuar-orden-card">
                <div class="continuar-orden-title"><?= htmlspecialchars($continuar_orden['producto']) ?></div>
                <div class="continuar-orden-row"><span>Total del pedido</span><span>$<?= number_format((float) $continuar_orden['precio'], 0, ',', '.') ?> COP</span></div>
                <div class="continuar-orden-row"><span>Pagado hasta ahora</span><span>$<?= number_format((float) ($continuar_orden['monto_pagado'] ?? 0), 0, ',', '.') ?> COP</span></div>
                <div class="continuar-orden-row continuar-orden-saldo"><span>Saldo pendiente</span><span>$<?= number_format($continuar_orden['saldo'], 0, ',', '.') ?> COP</span></div>
            </div>
            <?php else: ?>
            <p class="section-label">Elige el importe de Esmeraldas</p>
            <div class="products-grid">

                <div class="product-card" data-id="1" data-price="4900" data-pts="80">
                    <div class="product-card__img">
                        <img src="../../assets/imgames/esmeraldas/emerald-icon.svg" style="height: 40px; width: 40px" alt="">
                    </div>
                    <div class="product-card__pts">80 Esmeraldas</div>
                    <div class="product-card__label">Moneda del juego</div>
                    <div class="product-card__price">4.900 COP</div>
                </div>

                <div class="product-card" data-id="2" data-price="9900" data-pts="170">
                    <div class="product-card__img">
                        <img src="../../assets/imgames/esmeraldas/emerald-icon.svg" style="height: 40px; width: 40px" alt="">
                    </div>
                    <div class="product-card__pts">170 Esmeraldas</div>
                    <div class="product-card__label">Moneda del juego</div>
                    <div class="product-card__price">9.900 COP</div>
                </div>

                <div class="product-card popular-card" data-id="3" data-price="19900" data-pts="360">
                    <div class="badge-popular">? Popular</div>
                    <div class="product-card__img">
                        <img src="../../assets/imgames/esmeraldas/emerald-icon.svg" style="height: 40px; width: 40px" alt="">
                    </div>
                    <div class="product-card__pts">360 Esmeraldas</div>
                    <div class="product-card__label">Moneda del juego</div>
                    <div class="product-card__price">19.900 COP <span class="discount-tag">+20 extra</span></div>
                </div>

                <div class="product-card" data-id="4" data-price="34900" data-pts="660">
                    <div class="product-card__img">
                        <img src="../../assets/imgames/esmeraldas/emerald-icon.svg" style="height: 40px; width: 40px" alt="">

                    </div>
                    <div class="product-card__pts">660 Esmeraldas</div>
                    <div class="product-card__label">Moneda del juego</div>
                    <div class="product-card__price">34.900 COP <span class="discount-tag">+40 extra</span></div>
                </div>

                <div class="product-card" data-id="5" data-price="54900" data-pts="1120">
                    <div class="product-card__img">
                        <img src="../../assets/imgames/esmeraldas/emerald-icon.svg" style="height: 40px; width: 40px" alt="">
                    </div>
                    <div class="product-card__pts">1120 Esmeraldas</div>
                    <div class="product-card__label">Moneda del juego</div>
                    <div class="product-card__price">54.900 COP <span class="discount-tag">+80 extra</span></div>
                </div>

                <div class="product-card popular-card" data-id="6" data-price="99900" data-pts="2240">
                    <div class="badge-popular">?? Mejor valor</div>
                    <div class="product-card__img">
                        <img src="../../assets/imgames/esmeraldas/emerald-icon.svg" style="height: 40px; width: 40px" alt="">
                    </div>
                    <div class="product-card__pts">2240 Esmeraldas</div>
                    <div class="product-card__label">Moneda del juego</div>
                    <div class="product-card__price">99.900 COP <span class="discount-tag">+200 extra</span></div>
                </div>

                <div class="product-card" data-id="7" data-price="179900" data-pts="4480">
                    <div class="product-card__img">
                        <img src="../../assets/imgames/esmeraldas/emerald-icon.svg" style="height: 40px; width: 40px" alt="">
                    </div>
                    <div class="product-card__pts">4480 Esmeraldas</div>
                    <div class="product-card__label">Moneda del juego</div>
                    <div class="product-card__price">179.900 COP <span class="discount-tag">+480 extra</span></div>
                </div>

                <div class="product-card" data-id="8" data-price="299900" data-pts="8960">
                    <div class="product-card__img">
                        <img src="../../assets/imgames/esmeraldas/emerald-icon.svg" style="height: 40px; width: 40px" alt="">
                    </div>
                    <div class="product-card__pts">8960 Esmeraldas</div>
                    <div class="product-card__label">Moneda del juego</div>
                    <div class="product-card__price">299.900 COP <span class="discount-tag">+960 extra</span></div>
                </div>
            </div>
            <!-- Modo de simulación -->
             <div class="sim-mode-wrap">
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
            <?php endif; ?>
        </section>

        <!-- CHECKOUT -->
        <aside class="checkout-panel">
            <div class="checkout-box">
                <div class="checkout-product-name"><img id="checkoutImg" src="" alt="" /><span id="checkoutName"><?= $continuar_orden ? '?? ' . htmlspecialchars($continuar_orden['producto']) : '?? 360 Esmeraldas' ?></span></div>
                <div class="checkout-price-row">
                    <span style="font-size:0.85rem;color:var(--pt-text-sec);"><?= $continuar_orden ? 'Total del pedido' : 'Total' ?></span>
                    <span class="checkout-price" id="checkoutPrice"><?= $continuar_orden ? number_format((float) $continuar_orden['precio'], 0, ',', '.') . ' COP' : '19.900 COP' ?></span>
                </div>

                <div class="field-group" id="montoPagarGroup">
                    <label class="field-label">¿Cuánto quieres pagar ahora?</label>
                    <input type="number" class="field-input" id="montoPagar" min="1000"
                           max="<?= $continuar_orden ? (int) $continuar_orden['saldo'] : 19900 ?>" step="100"
                           value="<?= $continuar_orden ? (int) $continuar_orden['saldo'] : 19900 ?>">
                    <span class="field-hint" id="montoHint">Mínimo $1.000 COP · Máximo $<span id="montoMaxLabel"><?= $continuar_orden ? number_format($continuar_orden['saldo'], 0, ',', '.') : '19.900' ?></span> COP (saldo pendiente)</span>
                </div>

                <div class="checkout-divider"></div>

                <!-- Tabs método de pago -->
                <div class="payment-tabs">
                    <button class="payment-tab active" id="tabTarjeta" onclick="setPayment('tarjeta')">
                        <i class="bi bi-credit-card-fill"></i> Tarjeta
                    </button>
                    <button class="payment-tab" id="tabCuenta" onclick="setPayment('cuenta')">
                        <i class="bi bi-bank2"></i> Cuenta
                    </button>
                </div>

                <!-- FORMULARIO TARJETA -->
                <div class="form-section active" id="formTarjeta">
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
                        <input type="text" class="field-input" id="cardName" placeholder="Como aparece en la tarjeta" value="<?= htmlspecialchars($continuar_orden['nombre'] ?? '') ?>">
                    </div>
                    <div class="checkout-divider"></div>
                    <span class="section-label-sm">Datos del titular</span>
                    <div class="field-group">
                        <label class="field-label">Correo electrónico</label>
                        <input type="email" class="field-input" id="bsCorreo" value="<?php echo htmlspecialchars($continuar_orden['correo'] ?? $_SESSION['correo'] ?? ''); ?>">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Teléfono</label>
                        <input type="text" class="field-input" id="bsTelefono" placeholder="3001234567" value="<?= htmlspecialchars($continuar_orden['telefono'] ?? '') ?>">
                    </div>
                    <div class="field-row">
                        <div class="field-group">
                            <label class="field-label">Tipo de documento</label>
                            <select class="field-input" id="bsTipoDoc">
                                <?php $bs_tipo_doc = $continuar_orden['tipo_doc'] ?? 'CC'; ?>
                                <option value="CC" <?= $bs_tipo_doc === 'CC' ? 'selected' : '' ?>>Cédula</option>
                                <option value="CE" <?= $bs_tipo_doc === 'CE' ? 'selected' : '' ?>>Cédula Extranjería</option>
                                <option value="NIT" <?= $bs_tipo_doc === 'NIT' ? 'selected' : '' ?>>NIT</option>
                                <option value="PP" <?= $bs_tipo_doc === 'PP' ? 'selected' : '' ?>>Pasaporte</option>
                            </select>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Número de documento</label>
                            <input type="text" class="field-input" id="bsNumDoc" placeholder="1234567890" value="<?= htmlspecialchars($continuar_orden['num_doc'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Nombre completo</label>
                        <input type="text" class="field-input" id="bsNombre" placeholder="Nombre y apellido">
                    </div>
                </div>

                <!-- FORMULARIO CUENTA -->
                <div class="form-section" id="formCuenta">
                    <span class="section-label-sm">Datos bancarios</span>
                    <div class="field-group">
                        <label class="field-label">Banco</label>
                        <select class="field-input" id="cuentaBanco">
                            <option value="BANCOLOMBIA">Bancolombia</option>
                            <option value="NEQUI">Nequi</option>
                            <option value="DAVIVIENDA">Davivienda</option>
                            <option value="BBVA">BBVA</option>
                            <option value="BOGOTA">Banco de Bogotá</option>
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
                    <div class="checkout-divider"></div>
                    <span class="section-label-sm">Datos del titular</span>
                    <div class="field-group">
                        <label class="field-label">Nombre completo</label>
                        <input type="text" class="field-input" id="cuentaNombre" placeholder="Nombre y apellido" value="<?= htmlspecialchars($continuar_orden['nombre'] ?? '') ?>">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Correo electrónico</label>
                        <input type="email" class="field-input" id="cuentaCorreo" value="<?php echo htmlspecialchars($continuar_orden['correo'] ?? $_SESSION['correo'] ?? ''); ?>">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Teléfono</label>
                        <input type="text" class="field-input" id="cuentaTelefono" placeholder="3001234567" value="<?= htmlspecialchars($continuar_orden['telefono'] ?? '') ?>">
                    </div>
                    <div class="field-row">
                        <div class="field-group">
                            <label class="field-label">Tipo de documento</label>
                            <select class="field-input" id="cuentaTipoDoc">
                                <?php $cuenta_tipo_doc = $continuar_orden['tipo_doc'] ?? 'CC'; ?>
                                <option value="CC" <?= $cuenta_tipo_doc === 'CC' ? 'selected' : '' ?>>Cédula</option>
                                <option value="CE" <?= $cuenta_tipo_doc === 'CE' ? 'selected' : '' ?>>Cédula Extranjería</option>
                                <option value="NIT" <?= $cuenta_tipo_doc === 'NIT' ? 'selected' : '' ?>>NIT</option>
                            </select>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Número de documento</label>
                            <input type="text" class="field-input" id="cuentaNumDoc" placeholder="1234567890" value="<?= htmlspecialchars($continuar_orden['num_doc'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <div class="checkout-divider"></div>
                <div class="field-group">
                    <label class="field-label"><i class="bi bi-person-vcard-fill fs-6"></i> ID de jugador</label>
                    <input type="text" class="field-input" id="jugadorIdInput" placeholder="Ej: 512345678" autocomplete="off">
                </div>

                <button class="btn-pagar" id="btnPagar">
                     Pagar ahora
                </button>
                <div class="security-note">
                    <i class="bi bi-shield-check"></i>
                     Pago Mixto · API Gateway · Evertec
                </div>
            </div>
        </aside>
    </main>

    <!-- --- INTEGRACIÓN PLACETOPAY --- -->
    <section class="integration-docs" style="--code-accent:var(--gj-accent); --code-accent-ink:var(--gj-accent-ink); --code-accent-soft:var(--gj-accent-soft); --code-radius-sm:var(--gj-radius-sm); --code-radius-md:var(--gj-radius-md); --code-radius-lg:var(--gj-radius-lg); --code-font:var(--gj-font-body);">
        <span class="integration-docs__badge"><i class="bi bi-braces"></i> Integración PlacetoPay</span>
        <h3>Así se procesa el pago de esta tienda</h3>
        <p>A diferencia de Web Checkout, aquí <strong>no hay redirección</strong>: los datos de la tarjeta (o cuenta) que llenas en este mismo panel viajan en el request de creación de la transacción, y <strong>PlaceToPay Gateway</strong> responde de una vez con el estado final del pago — <code>APPROVED</code>, <code>PENDING</code> o <code>REJECTED</code> — sin devolver un <code>processUrl</code>.</p>
        <p>Como esta tienda es de <strong>Pago Mixto</strong>, cada envío solo cobra el monto que elijas (no el total): se guarda como un <em>abono</em> y puedes repetir el proceso — incluso con otro medio de pago — hasta completar el total del pedido.</p>

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
    <span class="jk">"description"</span>: <span class="js">"360 Esmeraldas"</span>,
    <span class="jk">"amount"</span>: { <span class="jk">"currency"</span>: <span class="js">"COP"</span>, <span class="jk">"total"</span>: <span class="jn">19900</span> }
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
        <span class="jk">'description'</span> =&gt; <span class="cvar">$producto</span>,               <span class="cm">// ej: "360 Esmeraldas"</span>
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
            <span>Por eso el aviso de arriba: como los datos de tarjeta pasan por nuestra página antes de llegar a PlacetoPay, este flujo requiere <strong>certificación PCI-DSS</strong> en producción. Esta demo no guarda número, fecha ni CVV — se usan solo para armar el request y nunca se persisten en la base de datos.</span>
        </div>

        <a class="integration-docs__link" href="../guias/guia-developer.php#api-gateway">
            <div>
                <strong>¿Quieres entender esta integración a fondo?</strong>
                <span>Lee la documentación completa de API Gateway — alcance PCI-DSS, 3D Secure y más.</span>
            </div>
            <i class="bi bi-arrow-right"></i>
        </a>
    </section>

    <input type="hidden" id="usuarioIdInput" value="<?php echo htmlspecialchars($_SESSION['correo'] ?? ''); ?>">
    <input type="hidden" id="currentPayment" value="tarjeta">
    <input type="hidden" id="ordenIdInput" value="<?= $continuar_orden ? (int) $continuar_orden['id'] : '' ?>">

    <script>

        
    (function() {
        const products = {
            1:{name:' 80 Esmeraldas',   precio:4900,  price:'4.900 COP'},
            2:{name:' 170 Esmeraldas',  precio:9900,  price:'9.900 COP'},
            3:{name:' 360 Esmeraldas',  precio:19900, price:'19.900 COP'},
            4:{name:' 660 Esmeraldas',  precio:34900, price:'34.900 COP'},
            5:{name:' 1120 Esmeraldas', precio:54900, price:'54.900 COP'},
            6:{name:' 2240 Esmeraldas', precio:99900, price:'99.900 COP'},
            7:{name:' 4480 Esmeraldas', precio:179900,price:'179.900 COP'},
            8:{name:' 8960 Esmeraldas', precio:299900,price:'299.900 COP'},
        };

        // -- Continuar pago: cuando venimos de ?orden=ID no hay tarjetas que elegir,
        // el producto y el saldo ya vienen fijados desde PHP. --
        const isContinuar       = <?= $continuar_orden ? 'true' : 'false' ?>;
        const continuarProducto = <?= json_encode($continuar_orden['producto'] ?? '') ?>;
        const continuarPrecio   = <?= (int) ($continuar_orden['precio'] ?? 0) ?>;
        let montoMaxActual      = <?= $continuar_orden ? (int) $continuar_orden['saldo'] : 19900 ?>;

        function actualizarMontoMax(max) {
            montoMaxActual = max;
            const montoInput = document.getElementById('montoPagar');
            montoInput.max   = max;
            if (parseInt(montoInput.value, 10) > max || !montoInput.value) montoInput.value = max;
            document.getElementById('montoMaxLabel').textContent = max.toLocaleString('es-CO');
        }

        function updateCheckout(id) {
            const p = products[id];
            if (!p) return;
            document.getElementById('checkoutName').textContent  = p.name;
            document.getElementById('checkoutPrice').textContent = p.price;
            actualizarMontoMax(p.precio);

            const imgEl   = document.getElementById('checkoutImg');
            const cardImg = document.querySelector('.product-card[data-id="' + id + '"] img');
            if (imgEl && cardImg) {
                imgEl.src = cardImg.getAttribute('src');
                imgEl.style.display = '';
            } else if (imgEl) {
                imgEl.style.display = 'none';
            }
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
            var def = document.querySelector('.product-card[data-id="3"]');
            if (def) { def.classList.add('selected'); updateCheckout(3); }
        }

        if (!isContinuar) {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initCards);
            } else { initCards(); }
        }

        // -- Tabs método de pago --
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

        // Formatear tarjeta
        document.getElementById('cardNumber').addEventListener('input', function() {
            let v = this.value.replace(/\D/g,'').substring(0,16);
            this.value = v.replace(/(.{4})/g,'$1 ').trim();
        });
        document.getElementById('cardExpiry').addEventListener('input', function() {
            let v = this.value.replace(/\D/g,'').substring(0,4);
            if (v.length >= 2) v = v.substring(0,2) + '/' + v.substring(2);
            this.value = v;
        });


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

            let producto, precioTotal;
            if (isContinuar) {
                producto    = continuarProducto;
                precioTotal = continuarPrecio;
            } else {
                const selected = document.querySelector('.product-card.selected');
                if (!selected) { alert('?? Selecciona un producto.'); return; }
                const id = parseInt(selected.getAttribute('data-id'));
                const p  = products[id];
                producto    = p.name;
                precioTotal = p.precio;
            }

            const montoPagar = parseInt(document.getElementById('montoPagar').value, 10);
            if (!montoPagar || montoPagar < 1000) { alert('?? El monto a pagar debe ser de al menos $1.000 COP.'); return; }
            if (montoPagar > montoMaxActual) { alert('?? El monto a pagar no puede superar el saldo pendiente ($' + montoMaxActual.toLocaleString('es-CO') + ' COP).'); return; }

            const method = document.getElementById('currentPayment').value;
            let nombre, correo, telefono, tipoDoc, numDoc;

            if (method === 'tarjeta') {
                const cardNum = document.getElementById('cardNumber').value.replace(/\s/g,'');
                const cvv     = document.getElementById('cardCvv').value;
                const expiry  = document.getElementById('cardExpiry').value;
                nombre   = document.getElementById('cardName').value.trim();
                correo   = document.getElementById('bsCorreo').value.trim();
                telefono = document.getElementById('bsTelefono').value.trim();
                tipoDoc  = document.getElementById('bsTipoDoc').value;
                numDoc   = document.getElementById('bsNumDoc').value.trim();
                if (!cardNum || cardNum.length < 15) { alert('?? Ingresa un número de tarjeta válido.'); return; }
                if (!expiry) { alert('?? Ingresa la fecha de vencimiento.'); return; }
                if (!cvv)    { alert('?? Ingresa el CVV.'); return; }
            } else {
                nombre   = document.getElementById('cuentaNombre').value.trim();
                correo   = document.getElementById('cuentaCorreo').value.trim();
                telefono = document.getElementById('cuentaTelefono').value.trim();
                tipoDoc  = document.getElementById('cuentaTipoDoc').value;
                numDoc   = document.getElementById('cuentaNumDoc').value.trim();
            }

            if (!nombre || !correo || !telefono || !numDoc) {
                alert('?? Por favor completa todos los campos del titular.'); return;
            }

            // Armar formulario pero NO enviarlo aún
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = (modoSimulacion === 'auto')
                ? '../../php/pago_mixto_gateway.php'
                : '../../retorno/estados-gateway.php';

            const campos = [
                ['producto', producto], ['precio', precioTotal],
                ['jugador_id', jugadorId], ['metodo', method],
                ['card_name', nombre], ['correo', correo],
                ['telefono', telefono], ['tipo_doc', tipoDoc],
                ['num_doc', numDoc], ['monto_pagar', montoPagar],
                ['orden_id', document.getElementById('ordenIdInput').value],
                ['destino', 'mixto']
            ];

            // Si es tarjeta, agregar datos de tarjeta
            if (method === 'tarjeta') {
                campos.push(
                    ['card_number', document.getElementById('cardNumber').value.replace(/\s/g,'')],
                    ['card_cvv',    document.getElementById('cardCvv').value],
                    ['card_expiry', document.getElementById('cardExpiry').value]
                );
            } else {
                campos.push(
                    ['num_cuenta',   document.getElementById('cuentaNumero').value],
                    ['cuenta_banco', document.getElementById('cuentaBanco').value]
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

            pendingForm = form;
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
    <script src="../../assets/js/components/driver-tours/tour-bloodstrike.js"></script>
</body>
</html>