<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiquetes — Dispersión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <?php $theme_seccion = 'dispersion'; require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../../assets/css/styles-code-block.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>
<style>
    :root {
        --bg-base:var(--pt-bg-base); --bg-surface:var(--pt-bg-surface); --bg-card:var(--pt-navbar);
        --bg-card-hover: var(--pt-hover); --bg-selected: #0a1520; --border: var(--pt-border);
        --accent:#10b981; --accent-glow:rgba(16,185,129,0.25); --accent-dark:#059669;
        --accent-soft:rgba(16,185,129,0.1);
         --text-primary:var(--pt-text); --text-secondary:var(--pt-text-sec); --text-muted:var(--pt-text-sec)
        --font-display:'Barlow',sans-serif; --font-body:'Barlow',sans-serif;
        --radius-md:10px; --radius-lg:14px;
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    body{background-color:var(--bg-base);color:var(--text-primary);font-family:var(--font-body);min-height:100vh;-webkit-font-smoothing:antialiased;}
    .navbar{background-color:#0f0f0fa9!important;backdrop-filter:blur(8px);border-bottom:1px solid var(--border);}

    .game-banner{display:flex;align-items:center;justify-content:space-between;padding:0.6rem 2rem;background:var(--bg-surface);border-bottom:1px solid var(--border);gap:1rem;flex-wrap:wrap;}
    .game-banner__tag{display:flex;align-items:center;gap:0.5rem;font-family:var(--font-display);font-weight:700;font-size:1rem;letter-spacing:0.04em;}
    .wc-badge{background:var(--accent-soft);color:var(--accent);font-size:0.72rem;font-weight:700;padding:0.2rem 0.6rem;border-radius:20px;letter-spacing:0.05em;font-family:var(--font-display);}
    .disp-badge{background:rgba(16,185,129,0.12);color:#6ee7b7;font-size:0.72rem;font-weight:700;padding:0.2rem 0.6rem;border-radius:20px;letter-spacing:0.05em;font-family:var(--font-display);}

    .shop-layout{display:grid;grid-template-columns:1fr 370px;gap:1.5rem;max-width:1200px;margin:1.5rem auto;padding:0 1.5rem 3rem;align-items:start;}
    .section-label{font-family:var(--font-display);font-size:0.78rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-secondary);margin-bottom:0.75rem;}

    /* INFO DISPERSIÓN */
    .disp-info{background:rgba(16,185,129,0.07);border:1px solid rgba(16,185,129,0.2);border-left:3px solid var(--accent);border-radius:0 8px 8px 0;padding:0.8rem 1rem;margin-bottom:1.2rem;font-size:0.82rem;color:#6ee7b7;line-height:1.6;}
    .disp-info strong{color:var(--accent);}

    /* REGIÓN TABS */
    .region-tabs{display:flex;gap:0.4rem;margin-bottom:1rem;flex-wrap:wrap;}
    .region-tab{padding:0.4rem 0.9rem;border:1.5px solid var(--border);border-radius:20px;background:var(--bg-card);color:var(--text-secondary);font-size:0.78rem;font-weight:700;cursor:pointer;transition:all 0.2s;font-family:var(--font-body);}
    .region-tab:hover{border-color:var(--accent);color:var(--text-primary);}
    .region-tab.active{border-color:var(--accent);background:var(--accent-soft);color:var(--accent);}

    /* GRID TIQUETES */
    .tickets-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:0.8rem;}
    .ticket-group{display:none;}
    .ticket-group.show{display:contents;}

    .ticket-card{position:relative;background:var(--bg-card);border:1.5px solid var(--border);border-radius:var(--radius-lg);padding:1.1rem;cursor:pointer;transition:all 0.18s ease;overflow:hidden;}
    .ticket-card:hover{background:var(--bg-card-hover);border-color:rgba(16,185,129,0.4);transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,0.35);}
    .ticket-card.selected{background:var(--pt-border);border-color:var(--accent);box-shadow:0 0 0 1px var(--accent),0 4px 24px var(--accent-glow);}
    .ticket-card.selected::after{content:'✔';position:absolute;top:0.6rem;right:0.6rem;width:20px;height:20px;background:var(--accent);border-radius:50%;color:#fff;font-size:0.68rem;display:flex;align-items:center;justify-content:center;font-weight:900;line-height:20px;text-align:center;}

    /* Diseño tiquete */
    .ticket-header{display:flex;align-items:center;gap:0.6rem;margin-bottom:0.6rem;}
    .ticket-flag{font-size:1.6rem;}
    .ticket-dest{font-family:var(--font-display);font-size:1.1rem;font-weight:800;letter-spacing:0.02em;}
    .ticket-sub{font-size:0.72rem;color:var(--text-secondary);}
    .ticket-divider{height:1px;background:repeating-linear-gradient(to right,var(--border) 0,var(--border) 6px,transparent 6px,transparent 12px);margin:0.6rem 0;}
    .ticket-details{display:flex;justify-content:space-between;align-items:flex-end;}
    .ticket-desglose{font-size:0.72rem;color:var(--text-secondary);line-height:1.7;}
    .ticket-desglose span{color:var(--text-muted);}
    .ticket-total{text-align:right;}
    .ticket-total-label{font-size:0.68rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;}
    .ticket-price{font-family:var(--font-display);font-size:1.2rem;font-weight:800;color:var(--accent);}

    /* CHECKOUT */
    .checkout-panel{display:flex;flex-direction:column;gap:1rem;position:sticky;top:16px;}
    .checkout-box{background:var(--bg-surface);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.3rem;}
    .checkout-dest{font-family:var(--font-display);font-size:1.2rem;font-weight:800;margin-bottom:0.3rem;}
    .checkout-price-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:0.4rem;}
    .checkout-price{font-family:var(--font-display);font-size:1.4rem;font-weight:800;color:var(--text-primary);}
    .checkout-divider{height:1px;background:var(--border);margin:0.7rem 0;}
    .section-label-sm{font-family:var(--font-display);font-size:0.73rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-secondary);margin-bottom:0.5rem;display:block;}

    /* Desglose dispersión */
    .dispersion-box{background:rgba(16,185,129,0.07);border:1px solid rgba(16,185,129,0.2);border-radius:8px;padding:0.75rem;margin-bottom:0.7rem;font-size:0.8rem;}
    .disp-row{display:flex;justify-content:space-between;padding:0.25rem 0;color:var(--text-secondary);}
    .disp-row span:last-child{color:var(--text-primary);font-weight:600;}
    .disp-row.total{border-top:1px solid rgba(16,185,129,0.2);margin-top:0.3rem;padding-top:0.4rem;}
    .disp-row.total span{color:var(--accent);font-weight:800;}

    .field-group{margin-bottom:0.65rem;}
    .field-label{font-size:0.73rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.25rem;display:block;}
    .field-input{width:100%;background:var(--pt-border);border:1.5px solid var(--border);border-radius:8px;color:var(--text-primary);font-family:var(--font-body);font-size:0.83rem;padding:0.4rem 0.7rem;outline:none;transition:border-color 0.2s;}
    .field-input:focus{border-color:var(--accent);}
    .field-input::placeholder{color:var(--text-muted);}
    .field-row{display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;}

    .btn-comprar{width:100%;margin-top:0.8rem;padding:0.85rem;background:var(--accent);border:none;border-radius:var(--radius-md);color:#fff;font-family:var(--font-display);font-size:1.05rem;font-weight:800;letter-spacing:0.06em;text-transform:uppercase;cursor:pointer;transition:all 0.18s ease;display:flex;align-items:center;justify-content:center;gap:0.5rem;}
    .btn-comprar:hover{background:var(--accent-dark);transform:translateY(-1px);box-shadow:0 6px 20px var(--accent-glow);}
    .security-note{display:flex;align-items:center;gap:0.4rem;font-size:0.73rem;color:var(--text-muted);margin-top:0.5rem;justify-content:center;}

    @keyframes fadeSlideIn{from{opacity:0;transform:translateY(6px);}to{opacity:1;transform:translateY(0);}}
    .products-panel{animation:fadeSlideIn 0.4s ease both;}
    .checkout-panel{animation:fadeSlideIn 0.4s 0.1s ease both;}
    @media(max-width:900px){.shop-layout{grid-template-columns:1fr;}.checkout-panel{position:static;}.tickets-grid{grid-template-columns:1fr;}}
</style>
<body>
    <?php
    $nav_back_url  = "../../sesiones.php";
    $nav_back_text = "Atras";
    $nav_base      = "../../";
    require_once '../../php/navbar.php';
    ?>

    <div class="game-banner">
        <div class="game-banner__tag">
            ✈️ Tiquetes Aéreos — Dispersión de Pago
            <span class="wc-badge">🖥️ Web Checkout</span>
            <span class="disp-badge">💸 Dispersión</span>
        </div>
    </div>

    <main class="shop-layout">
        <section class="products-panel" id="productsPanel">

            <div class="disp-info" id="dispInfo">
                <i class="bi bi-info-circle-fill"></i>
                <span><strong>¿Qué es la Dispersión?</strong> Al pagar tu tiquete, el monto total se divide automáticamente: una parte va al valor del vuelo y otra cubre los impuestos aeroportuarios. Todo en una sola transacción.</span>
            </div>

            <!-- Filtro por región -->
            <div class="region-tabs">
                <button class="region-tab active" onclick="filterRegion('all', this)">🌎 Todos</button>
                <button class="region-tab" onclick="filterRegion('sur', this)">🌎 Suramérica</button>
                <button class="region-tab" onclick="filterRegion('europa', this)">🌍 Europa</button>
                <button class="region-tab" onclick="filterRegion('asia', this)">🌏 Asia & NA</button>
            </div>

            <p class="section-label">✈️ Destinos disponibles</p>
            <div class="tickets-grid">

                <!-- SURAMÉRICA -->
                <div class="ticket-card" data-region="sur" data-id="1" data-dest="Cartagena, Colombia" data-base="350000" data-imp="50000" data-total="400000">
                    <div class="ticket-header">
                        <span class="ticket-flag">🇨🇴</span>
                        <div><div class="ticket-dest">Cartagena</div><div class="ticket-sub">Colombia · Vuelo directo</div></div>
                    </div>
                    <div class="ticket-divider"></div>
                    <div class="ticket-details">
                        <div class="ticket-desglose">
                            <div>Vuelo: <span>$350.000</span></div>
                            <div>Impuestos: <span>$50.000</span></div>
                        </div>
                        <div class="ticket-total">
                            <div class="ticket-total-label">Total</div>
                            <div class="ticket-price">400.000 COP</div>
                        </div>
                    </div>
                </div>

                <div class="ticket-card" data-region="sur" data-id="2" data-dest="Buenos Aires, Argentina" data-base="800000" data-imp="120000" data-total="920000">
                    <div class="ticket-header">
                        <span class="ticket-flag">🇦🇷</span>
                        <div><div class="ticket-dest">Buenos Aires</div><div class="ticket-sub">Argentina · 1 escala</div></div>
                    </div>
                    <div class="ticket-divider"></div>
                    <div class="ticket-details">
                        <div class="ticket-desglose">
                            <div>Vuelo: <span>$800.000</span></div>
                            <div>Impuestos: <span>$120.000</span></div>
                        </div>
                        <div class="ticket-total">
                            <div class="ticket-total-label">Total</div>
                            <div class="ticket-price">920.000 COP</div>
                        </div>
                    </div>
                </div>

                <div class="ticket-card" data-region="sur" data-id="3" data-dest="Cusco, Perú" data-base="650000" data-imp="95000" data-total="745000">
                    <div class="ticket-header">
                        <span class="ticket-flag">🇵🇪</span>
                        <div><div class="ticket-dest">Cusco</div><div class="ticket-sub">Perú · 1 escala</div></div>
                    </div>
                    <div class="ticket-divider"></div>
                    <div class="ticket-details">
                        <div class="ticket-desglose">
                            <div>Vuelo: <span>$650.000</span></div>
                            <div>Impuestos: <span>$95.000</span></div>
                        </div>
                        <div class="ticket-total">
                            <div class="ticket-total-label">Total</div>
                            <div class="ticket-price">745.000 COP</div>
                        </div>
                    </div>
                </div>

                <div class="ticket-card" data-region="sur" data-id="4" data-dest="Río de Janeiro, Brasil" data-base="900000" data-imp="130000" data-total="1030000">
                    <div class="ticket-header">
                        <span class="ticket-flag">🇧🇷</span>
                        <div><div class="ticket-dest">Río de Janeiro</div><div class="ticket-sub">Brasil · 1 escala</div></div>
                    </div>
                    <div class="ticket-divider"></div>
                    <div class="ticket-details">
                        <div class="ticket-desglose">
                            <div>Vuelo: <span>$900.000</span></div>
                            <div>Impuestos: <span>$130.000</span></div>
                        </div>
                        <div class="ticket-total">
                            <div class="ticket-total-label">Total</div>
                            <div class="ticket-price">1.030.000 COP</div>
                        </div>
                    </div>
                </div>

                <!-- EUROPA -->
                <div class="ticket-card" data-region="europa" data-id="5" data-dest="París, Francia" data-base="2500000" data-imp="350000" data-total="2850000">
                    <div class="ticket-header">
                        <span class="ticket-flag">🇫🇷</span>
                        <div><div class="ticket-dest">París</div><div class="ticket-sub">Francia · 2 escalas</div></div>
                    </div>
                    <div class="ticket-divider"></div>
                    <div class="ticket-details">
                        <div class="ticket-desglose">
                            <div>Vuelo: <span>$2.500.000</span></div>
                            <div>Impuestos: <span>$350.000</span></div>
                        </div>
                        <div class="ticket-total">
                            <div class="ticket-total-label">Total</div>
                            <div class="ticket-price">2.850.000 COP</div>
                        </div>
                    </div>
                </div>

                <div class="ticket-card" data-region="europa" data-id="6" data-dest="Roma, Italia" data-base="2200000" data-imp="320000" data-total="2520000">
                    <div class="ticket-header">
                        <span class="ticket-flag">🇮🇹</span>
                        <div><div class="ticket-dest">Roma</div><div class="ticket-sub">Italia · 2 escalas</div></div>
                    </div>
                    <div class="ticket-divider"></div>
                    <div class="ticket-details">
                        <div class="ticket-desglose">
                            <div>Vuelo: <span>$2.200.000</span></div>
                            <div>Impuestos: <span>$320.000</span></div>
                        </div>
                        <div class="ticket-total">
                            <div class="ticket-total-label">Total</div>
                            <div class="ticket-price">2.520.000 COP</div>
                        </div>
                    </div>
                </div>

                <!-- ASIA & NA -->
                <div class="ticket-card" data-region="asia" data-id="7" data-dest="Tokio, Japón" data-base="3000000" data-imp="420000" data-total="3420000">
                    <div class="ticket-header">
                        <span class="ticket-flag">🇯🇵</span>
                        <div><div class="ticket-dest">Tokio</div><div class="ticket-sub">Japón · 2 escalas</div></div>
                    </div>
                    <div class="ticket-divider"></div>
                    <div class="ticket-details">
                        <div class="ticket-desglose">
                            <div>Vuelo: <span>$3.000.000</span></div>
                            <div>Impuestos: <span>$420.000</span></div>
                        </div>
                        <div class="ticket-total">
                            <div class="ticket-total-label">Total</div>
                            <div class="ticket-price">3.420.000 COP</div>
                        </div>
                    </div>
                </div>

                <div class="ticket-card" data-region="asia" data-id="8" data-dest="Nueva York, USA" data-base="1800000" data-imp="250000" data-total="2050000">
                    <div class="ticket-header">
                        <span class="ticket-flag">🇺🇸</span>
                        <div><div class="ticket-dest">Nueva York</div><div class="ticket-sub">USA · 1 escala</div></div>
                    </div>
                    <div class="ticket-divider"></div>
                    <div class="ticket-details">
                        <div class="ticket-desglose">
                            <div>Vuelo: <span>$1.800.000</span></div>
                            <div>Impuestos: <span>$250.000</span></div>
                        </div>
                        <div class="ticket-total">
                            <div class="ticket-total-label">Total</div>
                            <div class="ticket-price">2.050.000 COP</div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- CHECKOUT -->
        <aside class="checkout-panel">
            <div class="checkout-box" id="checkoutBox">
                <div class="checkout-dest" id="checkoutDest">✈️ Selecciona un destino</div>
                <div class="checkout-price-row">
                    <span style="font-size:0.85rem;color:var(--text-secondary);">Total del tiquete</span>
                    <span class="checkout-price" id="checkoutPrice">—</span>
                </div>

                <!-- Desglose dispersión -->
                <div class="dispersion-box" id="dispBox" style="display:none;">
                    <div style="font-family:var(--font-display);font-size:0.72rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-secondary);margin-bottom:0.5rem;">Dispersión del pago</div>
                    <div class="disp-row">
                        <span>✈️ Aerolínea (vuelo)</span>
                        <span id="dispBase">$0</span>
                    </div>
                    <div class="disp-row">
                        <span>🏛️ Impuestos aerop.</span>
                        <span id="dispImp">$0</span>
                    </div>
                    <div class="disp-row total">
                        <span>Total</span>
                        <span id="dispTotal">$0</span>
                    </div>
                </div>

                <div class="checkout-divider"></div>
                <span class="section-label-sm">Datos del pasajero</span>

                <div class="field-group">
                    <label class="field-label">Nombre completo</label>
                    <input type="text" class="field-input" id="pNombre" placeholder="Nombre y apellido">
                </div>
                <div class="field-group">
                    <label class="field-label">Correo electrónico</label>
                    <input type="email" class="field-input" id="pCorreo"
                           value="<?php echo htmlspecialchars($_SESSION['correo'] ?? ''); ?>">
                </div>
                <div class="field-group">
                    <label class="field-label">Teléfono</label>
                    <input type="text" class="field-input" id="pTelefono" placeholder="00000000">
                </div>
                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">Tipo de documento</label>
                        <select class="field-input" id="pTipoDoc">
                            <option value="CC">Cédula</option>
                            <option value="CE">Cédula Extranjería</option>
                            <option value="PP">Pasaporte</option>
                            <option value="NIT">NIT</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Número de documento</label>
                        <input type="text" class="field-input" id="pNumDoc" placeholder="1234567890">
                    </div>
                </div>

                <button class="btn-comprar" id="btnComprar" onclick="comprar()">
                    <i class="bi bi-airplane-fill"></i> Comprar tiquete
                </button>
                <div class="security-note">
                    <i class="bi bi-shield-check"></i>
                    Dispersión · Web Checkout · PlacetoPay · Evertec
                </div>
            </div>
        </aside>
    </main>

    <!-- ═══ INTEGRACIÓN PLACETOPAY ═══ -->
    <section class="integration-docs" style="--code-accent:var(--accent); --code-accent-ink:#ffffff; --code-accent-soft:var(--accent-soft); --code-radius-sm:6px; --code-radius-md:var(--radius-md); --code-radius-lg:var(--radius-lg); --code-font:var(--font-body);">
        <span class="integration-docs__badge"><i class="bi bi-braces"></i> Integración PlacetoPay</span>
        <h3>Así se crea la sesión de pago de este tiquete</h3>
        <p>Cuando presionas <strong>"Comprar tiquete"</strong>, nuestro backend arma este mismo request y lo envía a <strong>PlacetoPay Web Checkout</strong> con un bloque <code>dispersion</code>: el mismo cobro se reparte automáticamente entre varios beneficiarios — la aerolínea y el impuesto aeroportuario — en una sola transacción.</p>

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
    <span class="jk">"reference"</span>: <span class="js">"DISP-9F3A2E1C"</span>,
    <span class="jk">"description"</span>: <span class="js">"Tiquete a Cartagena, Colombia"</span>,
    <span class="jk">"amount"</span>: { <span class="jk">"currency"</span>: <span class="js">"COP"</span>, <span class="jk">"total"</span>: <span class="jn">400000</span> },
    <span class="cm">// "dispersion" reparte el total entre varios beneficiarios</span>
    <span class="jk">"dispersion"</span>: [
      { <span class="jk">"agreement"</span>: <span class="jn">1</span>, <span class="jk">"agreementType"</span>: <span class="js">"AIRLINE"</span>, <span class="jk">"amount"</span>: { <span class="jk">"currency"</span>: <span class="js">"COP"</span>, <span class="jk">"total"</span>: <span class="jn">350000</span> } },
      { <span class="jk">"agreement"</span>: <span class="jn">2</span>, <span class="jk">"agreementType"</span>: <span class="js">"MERCHANT"</span>, <span class="jk">"amount"</span>: { <span class="jk">"currency"</span>: <span class="js">"COP"</span>, <span class="jk">"total"</span>: <span class="jn">50000</span> } }
    ]
  },
  <span class="jk">"buyer"</span>: {
    <span class="jk">"name"</span>: <span class="js">"Andrés Torres"</span>,
    <span class="jk">"surname"</span>: <span class="js">""</span>,
    <span class="jk">"email"</span>: <span class="js">"usuario@correo.com"</span>,
    <span class="jk">"documentType"</span>: <span class="js">"CC"</span>,
    <span class="jk">"document"</span>: <span class="js">"1234567890"</span>,
    <span class="jk">"mobile"</span>: <span class="js">"3001234567"</span>
  },
  <span class="jk">"expiration"</span>: <span class="js">"2026-08-25T10:45:32-05:00"</span>,
  <span class="jk">"returnUrl"</span>: <span class="js">"https://tu-dominio.com/retorno/retorno_dispersion.php?disp_id=482"</span>,
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

<span class="cm">// cuerpo del request — reparte el pago entre aerolínea e impuestos</span>
<span class="cvar">$body</span> = [
    <span class="jk">'auth'</span> =&gt; [
        <span class="jk">'login'</span>   =&gt; <span class="cvar">$login</span>,
        <span class="jk">'tranKey'</span> =&gt; <span class="cvar">$tranKey</span>,
        <span class="jk">'nonce'</span>   =&gt; <span class="cvar">$nonceB64</span>,
        <span class="jk">'seed'</span>    =&gt; <span class="cvar">$seed</span>,
    ],
    <span class="jk">'payment'</span> =&gt; [
        <span class="jk">'reference'</span>   =&gt; <span class="js">'DISP-'</span> . strtoupper(bin2hex(random_bytes(4))),
        <span class="jk">'description'</span> =&gt; <span class="js">'Tiquete a '</span> . <span class="cvar">$destino</span>,
        <span class="jk">'amount'</span>      =&gt; [<span class="jk">'currency'</span> =&gt; <span class="js">'COP'</span>, <span class="jk">'total'</span> =&gt; <span class="cvar">$total</span>],
        <span class="jk">'dispersion'</span>  =&gt; [
            [<span class="jk">'agreement'</span> =&gt; 1, <span class="jk">'agreementType'</span> =&gt; <span class="js">'AIRLINE'</span>,  <span class="jk">'amount'</span> =&gt; [<span class="jk">'currency'</span> =&gt; <span class="js">'COP'</span>, <span class="jk">'total'</span> =&gt; <span class="cvar">$base</span>]],
            [<span class="jk">'agreement'</span> =&gt; 2, <span class="jk">'agreementType'</span> =&gt; <span class="js">'MERCHANT'</span>, <span class="jk">'amount'</span> =&gt; [<span class="jk">'currency'</span> =&gt; <span class="js">'COP'</span>, <span class="jk">'total'</span> =&gt; <span class="cvar">$impuesto</span>]],
        ],
    ],
    <span class="jk">'buyer'</span> =&gt; [
        <span class="jk">'name'</span>         =&gt; <span class="cvar">$nombre</span>,
        <span class="jk">'surname'</span>      =&gt; <span class="js">''</span>,
        <span class="jk">'email'</span>        =&gt; <span class="cvar">$correo</span>,
        <span class="jk">'documentType'</span> =&gt; <span class="cvar">$tipo_doc</span>,
        <span class="jk">'document'</span>     =&gt; <span class="cvar">$num_doc</span>,
        <span class="jk">'mobile'</span>       =&gt; <span class="cvar">$telefono</span>,
    ],
    <span class="jk">'expiration'</span> =&gt; date(<span class="js">'c'</span>, strtotime(<span class="js">'+30 minutes'</span>)),
    <span class="jk">'returnUrl'</span>  =&gt; app_base_url() . <span class="js">'/retorno/retorno_dispersion.php?disp_id='</span> . <span class="cvar">$dispersion_id</span>,
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
            <span class="doc-note-icon">💡</span>
            <span>El comprador solo ve <strong>un cobro por el total</strong>; el reparto entre <code>agreement</code> ocurre del lado de PlacetoPay. Cada entrada de <code>dispersion</code> es un beneficiario distinto, identificado por su propio <code>agreement</code>.</span>
        </div>

        <a class="integration-docs__link" href="../guias/guia-developer.php#tipos-pago">
            <div>
                <strong>¿Quieres entender esta integración a fondo?</strong>
                <span>Lee la documentación completa sobre tipos de pago — incluye dispersión.</span>
            </div>
            <i class="bi bi-arrow-right"></i>
        </a>
    </section>

    <script>
    (function() {
        const tickets = {
            1:{dest:'✈️ Cartagena, Colombia',   base:350000,  imp:50000,  total:400000},
            2:{dest:'✈️ Buenos Aires, Argentina',base:800000,  imp:120000, total:920000},
            3:{dest:'✈️ Cusco, Perú',            base:650000,  imp:95000,  total:745000},
            4:{dest:'✈️ Río de Janeiro, Brasil', base:900000,  imp:130000, total:1030000},
            5:{dest:'✈️ París, Francia',         base:2500000, imp:350000, total:2850000},
            6:{dest:'✈️ Roma, Italia',           base:2200000, imp:320000, total:2520000},
            7:{dest:'✈️ Tokio, Japón',           base:3000000, imp:420000, total:3420000},
            8:{dest:'✈️ Nueva York, USA',        base:1800000, imp:250000, total:2050000},
        };

        let selectedId = null;
        function fmt(n){ return '$' + n.toLocaleString('es-CO') + ' COP'; }

        function updateCheckout(id) {
            const t = tickets[id];
            document.getElementById('checkoutDest').textContent  = t.dest;
            document.getElementById('checkoutPrice').textContent = fmt(t.total);
            document.getElementById('dispBase').textContent  = fmt(t.base);
            document.getElementById('dispImp').textContent   = fmt(t.imp);
            document.getElementById('dispTotal').textContent = fmt(t.total);
            document.getElementById('dispBox').style.display = 'block';
        }

        window.filterRegion = function(region, el) {
            document.querySelectorAll('.region-tab').forEach(t=>t.classList.remove('active'));
            el.classList.add('active');
            document.querySelectorAll('.ticket-card').forEach(function(card) {
                const r = card.getAttribute('data-region');
                card.style.display = (region === 'all' || r === region) ? '' : 'none';
            });
        };

        function initCards() {
            const cards = document.querySelectorAll('.ticket-card');
            if (!cards.length) { setTimeout(initCards,100); return; }
            cards.forEach(function(card) {
                card.addEventListener('click', function() {
                    cards.forEach(c=>c.classList.remove('selected'));
                    card.classList.add('selected');
                    selectedId = parseInt(card.getAttribute('data-id'));
                    updateCheckout(selectedId);
                });
            });
        }

        if (document.readyState==='loading') {
            document.addEventListener('DOMContentLoaded', initCards);
        } else { initCards(); }

        window.comprar = function() {
            if (!selectedId) { alert('⚠️ Selecciona un destino primero.'); return; }
            const nombre   = document.getElementById('pNombre').value.trim();
            const correo   = document.getElementById('pCorreo').value.trim();
            const telefono = document.getElementById('pTelefono').value.trim();
            const tipoDoc  = document.getElementById('pTipoDoc').value;
            const numDoc   = document.getElementById('pNumDoc').value.trim();

            if (!nombre || !correo || !telefono || !numDoc) {
                alert('⚠️ Completa todos los datos del pasajero.'); return;
            }

            const t = tickets[selectedId];
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../../php/crear_dispersion.php';

            [
                ['destino',   t.dest.replace('✈️ ','')],
                ['base',      t.base],
                ['impuesto',  t.imp],
                ['total',     t.total],
                ['nombre',    nombre],
                ['correo',    correo],
                ['telefono',  telefono],
                ['tipo_doc',  tipoDoc],
                ['num_doc',   numDoc],
            ].forEach(function(pair) {
                const input = document.createElement('input');
                input.type='hidden'; input.name=pair[0]; input.value=pair[1];
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        };
    })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/code-block.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="../../assets/js/components/driver-tours/tour-tickets.js"></script>
</body>
</html>