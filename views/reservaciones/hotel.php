<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Plance — Reservaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <?php $theme_seccion = 'preautor'; require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../../assets/css/styles-code-block.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>
<style>
    :root {
       --bg-base:var(--pt-bg-base); --bg-surface:var(--pt-bg-surface); --bg-card:var(--pt-navbar);
        --bg-card-hover: var(--pt-hover); --bg-selected: #0a1520; --border: var(--pt-border);
        --accent:#6366f1; --accent-glow:rgba(99,102,241,0.25); --accent-dark: #4f46e5;
        --accent-soft:rgba(99,102,241,0.1);
        --text-primary:var(--pt-text); --text-secondary:var(--pt-text-sec); --text-muted:var(--pt-text-sec)
        --font-display:'Barlow',sans-serif; --font-body:'Barlow',sans-serif;
        --radius-md:10px; --radius-lg:14px;
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    body{background-color:var(--bg-base);color:var(--text-primary);font-family:var(--font-body);min-height:100vh;-webkit-font-smoothing:antialiased;}
    .navbar{background-color:#0f0f0fa9!important;backdrop-filter:blur(8px);border-bottom:1px solid var(--border);}

    .game-banner{display:flex;align-items:center;justify-content:space-between;padding:0.6rem 2rem;background:var(--pt-th2);border-bottom:1px solid var(--border);gap:1rem;flex-wrap:wrap;}
    .game-banner__tag{display:flex;align-items:center;gap:0.5rem;font-family:var(--font-display);font-weight:700;font-size:1rem;letter-spacing:0.04em;}
    .wc-badge{background:var(--accent-soft);color:var(--accent);font-size:0.72rem;font-weight:700;padding:0.2rem 0.6rem;border-radius:20px;letter-spacing:0.05em;font-family:var(--font-display);}
    .pre-badge{background:rgba(99,102,241,0.15);color:#a5b4fc;font-size:0.72rem;font-weight:700;padding:0.2rem 0.6rem;border-radius:20px;letter-spacing:0.05em;font-family:var(--font-display);}

    .shop-layout{display:grid;grid-template-columns:1fr 370px;gap:1.5rem;max-width:1200px;margin:1.5rem auto;padding:0 1.5rem 3rem;align-items:start;}
    .section-label{font-family:var(--font-display);font-size:0.78rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-secondary);margin-bottom:0.75rem;}

    /* INFO PREAUTORIZACION */
    .preauth-info{background:rgba(99,102,241,0.07);border:1px solid rgba(99,102,241,0.2);border-left:3px solid var(--accent);border-radius:0 8px 8px 0;padding:0.8rem 1rem;margin-bottom:1.2rem;font-size:0.82rem;color:#a5b4fc;line-height:1.6;}
    .preauth-info strong{color:var(--accent);}

    /* GRID HABITACIONES */
    .rooms-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:0.8rem;}

    .room-card{position:relative;background:var(--bg-card);border:1.5px solid var(--border);border-radius:var(--radius-lg);padding:1.2rem;cursor:pointer;transition:all 0.18s ease;overflow:hidden;}
    .room-card:hover{background:var(--bg-card-hover);border-color:rgba(99,102,241,0.4);transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,0.35);}
    .room-card.selected{background:var(--pt-border);border-color:var(--accent);box-shadow:0 0 0 1px var(--accent),0 4px 24px var(--accent-glow);}
    .room-card.selected::after{content:'✔';position:absolute;top:0.7rem;right:0.7rem;width:20px;height:20px;background:var(--accent);border-radius:50%;color:#fff;font-size:0.7rem;display:flex;align-items:center;justify-content:center;font-weight:900;line-height:20px;text-align:center;}
    .room-badge{display:inline-block;background:var(--accent-soft);color:var(--accent);font-size:0.68rem;font-weight:700;padding:0.15rem 0.5rem;border-radius:4px;margin-bottom:0.5rem;font-family:var(--font-display);letter-spacing:0.05em;}
    .room-badge.premium{background:rgba(245,158,11,0.12);color:#f0b429;}
    .room-badge.suite{background:rgba(62,207,142,0.12);color:#3ecf8e;}
    .room-icon{font-size:1.6rem;margin-bottom:0.4rem;}
    .room-name{font-family:var(--font-display);font-size:1.15rem;font-weight:800;margin-bottom:0.3rem;letter-spacing:0.02em;}
    .room-desc{font-size:0.78rem;color:var(--text-secondary);line-height:1.5;margin-bottom:0.6rem;}
    .room-amenities{display:flex;gap:0.4rem;flex-wrap:wrap;margin-bottom:0.6rem;}
    .amenity{font-size:0.68rem;background:rgba(255,255,255,0.05);border:1px solid var(--border);padding:0.15rem 0.4rem;border-radius:4px;color:var(--text-secondary);}
    .room-price{font-family:var(--font-display);font-size:1.2rem;font-weight:800;color:var(--accent);}
    .room-price-label{font-size:0.7rem;color:var(--text-muted);margin-left:0.2rem;}

    /* CHECKOUT */
    .checkout-panel{display:flex;flex-direction:column;gap:1rem;position:sticky;top:16px;}
    .checkout-box{background:var(--bg-surface);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.3rem;}
    .checkout-room-name{font-family:var(--font-display);font-size:1.15rem;font-weight:800;margin-bottom:0.3rem;}
    .checkout-price-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:0.6rem;}
    .checkout-price{font-family:var(--font-display);font-size:1.4rem;font-weight:800;color:var(--text-primary);}
    .checkout-divider{height:1px;background:var(--border);margin:0.7rem 0;}
    .section-label-sm{font-family:var(--font-display);font-size:0.73rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-secondary);margin-bottom:0.5rem;display:block;}

    .field-group{margin-bottom:0.65rem;}
    .field-label{font-size:0.73rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.25rem;display:block;}
    .field-input{width:100%;background:var(--pt-border);border:1.5px solid var(--border);border-radius:8px;color:var(--text-primary);font-family:var(--font-body);font-size:0.83rem;padding:0.4rem 0.7rem;outline:none;transition:border-color 0.2s;}
    .field-input:focus{border-color:var(--accent);}
    .field-input::placeholder{color:var(--text-muted);}
    .field-row{display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;}

    /* Fechas */
    .dates-info{background:var(--accent-soft);border:1px solid rgba(99,102,241,0.25);border-radius:8px;padding:0.65rem 0.9rem;margin-bottom:0.6rem;font-size:0.8rem;color:#a5b4fc;display:flex;align-items:center;gap:0.4rem;}

    .btn-reservar{width:100%;margin-top:0.8rem;padding:0.85rem;background:var(--accent);border:none;border-radius:var(--radius-md);color:#fff;font-family:var(--font-display);font-size:1.05rem;font-weight:800;letter-spacing:0.06em;text-transform:uppercase;cursor:pointer;transition:all 0.18s ease;display:flex;align-items:center;justify-content:center;gap:0.5rem;}
    .btn-reservar:hover{background:var(--accent-dark);transform:translateY(-1px);box-shadow:0 6px 20px var(--accent-glow);}
    .security-note{display:flex;align-items:center;gap:0.4rem;font-size:0.73rem;color:var(--text-muted);margin-top:0.5rem;justify-content:center;}

    /* Preauth notice en checkout */
    .preauth-notice{background:rgba(99,102,241,0.08);border:1px solid rgba(99,102,241,0.2);border-radius:8px;padding:0.65rem 0.9rem;margin-top:0.6rem;font-size:0.78rem;color:#a5b4fc;line-height:1.5;}

    @keyframes fadeSlideIn{from{opacity:0;transform:translateY(6px);}to{opacity:1;transform:translateY(0);}}
    .products-panel{animation:fadeSlideIn 0.4s ease both;}
    .checkout-panel{animation:fadeSlideIn 0.4s 0.1s ease both;}
    @media(max-width:900px){.shop-layout{grid-template-columns:1fr;}.checkout-panel{position:static;}.rooms-grid{grid-template-columns:1fr;}}
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
            <i class="bi bi-building-fill-lock" style="color: #4f46e5;"></i> Hotel Plance — Reservaciones
            <span class="wc-badge"><i class="fa-solid fa-desktop" style="color: #4f46e5;"></i> Web Checkout</span>
            <span class="pre-badge"><i class="fa-solid fa-building-lock" style="color: rgb(255, 130, 63);"></i> Preautorización</span>
        </div>
    </div>

    <main class="shop-layout">
        <section class="products-panel" id="productsPanel">

            <div class="preauth-info" id="preauthInfo">
                <i class="bi bi-info-circle-fill"></i>
                <span><strong>¿Cómo funciona la preautorización?</strong> Al reservar, PlacetoPay reserva el monto en tu tarjeta sin cobrarlo aún. El cargo real se realiza al momento del check-out del hotel. Si cancelas antes, el monto se libera automáticamente.</span>
            </div>

            <p class="section-label"><i class="fa-solid fa-bed" style="color: #4f46e5;"></i> Selecciona tu habitación</p>
            <div class="rooms-grid">

                <div class="room-card" data-id="1" data-nombre="Habitación Estándar" data-precio="150000" data-moneda="COP">
                    <span class="room-badge">ESTÁNDAR</span>
                    <div class="room-icon"><i class="fa-solid fa-bed" style="color: #4f46e5;"></i></div>
                    <div class="room-name">Habitación Estándar</div>
                    <div class="room-desc">Cómoda habitación con cama doble, ideal para viajeros individuales o parejas.</div>
                    <div class="room-amenities">
                        <span class="amenity"><i class="bi bi-wifi" style="color: rgb(82, 128, 255);"></i> WiFi</span>
                        <span class="amenity"><i class="bi bi-snow2" style="color: rgb(82, 128, 255);"></i> A/C</span>
                        <span class="amenity"><i class="bi bi-tv" style="color: rgb(82, 128, 255);"></i> TV</span>
                    </div>
                    <div class="room-price">150.000 COP <span class="room-price-label">/ noche</span></div>
                </div>

                <div class="room-card" data-id="2" data-nombre="Habitación Doble" data-precio="220000" data-moneda="COP">
                    <span class="room-badge">DOBLE</span>
                    <div class="room-icon"><i class="fa-solid fa-bed" style="color: #4f46e5;"></i><i class="fa-solid fa-bed" style="color: #4f46e5;"></i></div>
                    <div class="room-name">Habitación Doble</div>
                    <div class="room-desc">Espaciosa habitación con dos camas individuales, perfecta para grupos o familias.</div>
                    <div class="room-amenities">
                        <span class="amenity"><i class="bi bi-wifi" style="color: rgb(82, 128, 255);"></i> WiFi</span>
                        <span class="amenity"><i class="bi bi-snow2" style="color: rgb(82, 128, 255);"></i> A/C</span>
                        <span class="amenity"><i class="bi bi-tv" style="color: rgb(82, 128, 255);"></i> TV</span>
                        <span class="amenity"><i class="fa-solid fa-pump-soap" style="color: rgb(255, 201, 173);"></i> Amenities</span>
                    </div>
                    <div class="room-price">220.000 COP <span class="room-price-label">/ noche</span></div>
                </div>

                <div class="room-card" data-id="3" data-nombre="Habitación con Vista al Mar" data-precio="320000" data-moneda="COP">
                    <span class="room-badge premium">PREMIUM</span>
                    <div class="room-icon"><i class="fa-solid fa-umbrella-beach" style="color: rgb(82, 128, 255);"></i></div>
                    <div class="room-name">Vista al Mar</div>
                    <div class="room-desc">Habitación premium con balcón privado y vista panorámica al mar. Desayuno incluido.</div>
                    <div class="room-amenities">
                        <span class="amenity"><i class="bi bi-wifi" style="color: rgb(82, 128, 255);"></i> WiFi</span>
                        <span class="amenity"><i class="bi bi-snow2" style="color: rgb(82, 128, 255);"></i> A/C</span>
                        <span class="amenity"><i class="bi bi-fork-knife" style="color: rgb(82, 128, 255);"></i> Desayuno</span>
                        <span class="amenity"><i class="fa-solid fa-hot-tub-person" style="color: rgb(82, 128, 255);"></i> Jacuzzi</span>
                    </div>
                    <div class="room-price">320.000 COP <span class="room-price-label">/ noche</span></div>
                </div>

                <div class="room-card" data-id="4" data-nombre="Suite Junior" data-precio="480000" data-moneda="COP">
                    <span class="room-badge suite">SUITE</span>
                    <div class="room-icon"><i class="bi bi-moon-stars-fill" style="color:  rgb(82, 128, 255);"></i></div>
                    <div class="room-name">Suite Junior</div>
                    <div class="room-desc">Suite moderna con sala de estar separada, cama king y amenidades de lujo.</div>
                    <div class="room-amenities">
                        <span class="amenity"><i class="bi bi-wifi" style="color: rgb(82, 128, 255);"></i> WiFi</span>
                        <span class="amenity"><i class="bi bi-snow2" style="color: rgb(82, 128, 255);"></i> A/C</span>
                        <span class="amenity"><i class="bi bi-fork-knife" style="color: rgb(82, 128, 255);"></i> Desayuno</span>
                        <span class="amenity"><i class="fa-solid fa-hot-tub-person" style="color: rgb(82, 128, 255);"></i> Jacuzzi</span>
                        <span class="amenity"><i class="fa-solid fa-champagne-glasses" style="color: rgb(82, 128, 255);"></i> Minibar</span>
                    </div>
                    <div class="room-price">480.000 COP <span class="room-price-label">/ noche</span></div>
                </div>

                <div class="room-card" data-id="5" data-nombre="Suite Presidencial" data-precio="850000" data-moneda="COP">
                    <span class="room-badge suite">PRESIDENCIAL</span>
                    <div class="room-icon"><i class="fa-solid fa-web-awesome" style="color: rgb(82, 128, 255);"></i></div>
                    <div class="room-name">Suite Presidencial</div>
                    <div class="room-desc">La experiencia más exclusiva. Sala, comedor, habitación y terraza privada con vista de 360°.</div>
                    <div class="room-amenities">
                        <span class="amenity"><i class="bi bi-wifi" style="color: rgb(82, 128, 255);"></i> WiFi <strong>Premium</strong></span>
                        <span class="amenity"><i class="bi bi-cup-straw" style="color: rgb(82, 128, 255);"><i class="bi bi-snow2" style="color: rgb(82, 128, 255);"></i></i><i class="bi bi-fork-knife" style="color: rgb(82, 128, 255);"></i><i class="fa-solid fa-hot-tub-person" style="color: rgb(82, 128, 255);"></i> Todo incluido</span>
                        <span class="amenity"><i class="bi bi-truck" style="color: rgb(82, 128, 255);"></i> Transfer</span>
                        <span class="amenity"><i class="fa-solid fa-bath" style="color: rgb(82, 128, 255);"></i> Spa privado</span>
                    </div>
                    <div class="room-price">850.000 COP <span class="room-price-label">/ noche</span></div>
                </div>

                <div class="room-card" data-id="6" data-nombre="Habitación Familiar" data-precio="280000" data-moneda="COP">
                    <span class="room-badge">FAMILIAR</span>
                    <div class="room-icon"><i class="fa-solid fa-arrows-down-to-people" style="color: rgb(82, 128, 255); "></i></div>
                    <div class="room-name">Habitación Familiar</div>
                    <div class="room-desc">Amplia habitación diseñada para familias, con cama matrimonial y literas para los pequeños.</div>
                    <div class="room-amenities">
                        <span class="amenity"><i class="bi bi-wifi" style="color: rgb(82, 128, 255);"></i> WiFi</span>
                        <span class="amenity"><i class="bi bi-snow" style="color: rgb(82, 128, 255);"></i> A/C</span>
                        <span class="amenity"><i class="bi bi-tv" style="color: rgb(82, 128, 255);"></i> TV</span>
                        <span class="amenity"><i class="bi bi-balloon" style="color: rgb(82, 128, 255);"></i> Kids friendly</span>
                    </div>
                    <div class="room-price">280.000 COP <span class="room-price-label">/ noche</span></div>
                </div>

                <div class="room-card" data-id="7" data-nombre="Habitación Ejecutiva" data-precio="390000" data-moneda="COP">
                    <span class="room-badge premium">EJECUTIVA</span>
                    <div class="room-icon"><i class="fa-solid fa-suitcase-rolling" style="color:  rgb(82, 128, 255);"></i></div>
                    <div class="room-name">Habitación Ejecutiva</div>
                    <div class="room-desc">Perfecta para viajeros de negocios. Escritorio, acceso al lounge ejecutivo y late check-out.</div>
                    <div class="room-amenities">
                        <span class="amenity"><i class="bi bi-wifi" style="color: rgb(82, 128, 255);"></i> WiFi Premium</span>
                        <span class="amenity"><i class="fa-solid fa-burger" style="color: rgb(82, 128, 255);"></i> Lounge</span>
                        <span class="amenity"><i class="fa-solid fa-print" style="color:rgb(82, 128, 255);"></i> Impresora</span>
                        <span class="amenity"><i class="bi bi-fork-knife" style="color: rgb(82, 128, 255);"></i> Desayuno</span>
                    </div>
                    <div class="room-price">390.000 COP <span class="room-price-label">/ noche</span></div>
                </div>

                <div class="room-card" data-id="8" data-nombre="Penthouse" data-precio="1200000" data-moneda="COP">
                    <span class="room-badge suite">PENTHOUSE</span>
                    <div class="room-icon"><i class="bi bi-building-fill-lock" style="color: rgb(82, 128, 255);"></i></div>
                    <div class="room-name">Penthouse</div>
                    <div class="room-desc">El piso más alto del hotel. Piscina privada, cocina equipada y mayordomo personal las 24h.</div>
                    <div class="room-amenities">
                        <span class="amenity"><i class="fa-solid fa-water-ladder" style="color: rgb(116, 192, 252);"></i>Piscina privada</span>
                        <span class="amenity">👨‍🍳 Chef</span>
                        <span class="amenity">🚗 Limousine</span>
                        <span class="amenity">🛁 Spa</span>
                    </div>
                    <div class="room-price">1.200.000 COP <span class="room-price-label">/ noche</span></div>
                </div>

            </div>
        </section>

        <!-- CHECKOUT -->
        <aside class="checkout-panel">
            <div class="checkout-box">
                <div class="checkout-room-name" id="checkoutName">🛏️ Habitación Estándar</div>
                <div class="checkout-price-row">
                    <span style="font-size:0.85rem;color:var(--text-secondary);">Precio / noche</span>
                    <span class="checkout-price" id="checkoutPrice">150.000 COP</span>
                </div>

                <div class="dates-info">
                    <i class="bi bi-calendar2-check"></i>
                    Selecciona las fechas de tu estancia
                </div>

                <div class="field-row" style="margin-bottom:0.65rem;">
                    <div class="field-group" style="margin-bottom:0;">
                        <label class="field-label">Check-in</label>
                        <input type="date" class="field-input" id="checkIn" onchange="calcTotal()">
                    </div>
                    <div class="field-group" style="margin-bottom:0;">
                        <label class="field-label">Check-out</label>
                        <input type="date" class="field-input" id="checkOut" onchange="calcTotal()">
                    </div>
                </div>

                <div id="totalNochesRow" style="display:none;background:var(--accent-soft);border-radius:8px;padding:0.6rem 0.8rem;margin-bottom:0.6rem;font-size:0.85rem;text-align:center;">
                    <span id="totalNochesText" style="color:#a5b4fc;"></span>
                    <div style="font-family:'Barlow Condensed',sans-serif;font-size:1.3rem;font-weight:800;color:var(--accent);" id="totalFinalText"></div>
                </div>

                <div class="checkout-divider"></div>
                <span class="section-label-sm">Datos del huésped</span>

                <div class="field-group">
                    <label class="field-label">Nombre completo</label>
                    <input type="text" class="field-input" id="hNombre" placeholder="Nombre y apellido">
                </div>
                <div class="field-group">
                    <label class="field-label">Correo electrónico</label>
                    <input type="email" class="field-input" id="hCorreo"
                           value="<?php echo htmlspecialchars($_SESSION['correo'] ?? ''); ?>">
                </div>
                <div class="field-group">
                    <label class="field-label">Teléfono</label>
                    <input type="text" class="field-input" id="hTelefono" placeholder="3001234567">
                </div>
                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">Tipo de documento</label>
                        <select class="field-input" id="hTipoDoc">
                            <option value="CC">Cédula</option>
                            <option value="CE">Cédula Extranjería</option>
                            <option value="PP">Pasaporte</option>
                            <option value="NIT">NIT</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Número de documento</label>
                        <input type="text" class="field-input" id="hNumDoc" placeholder="1234567890">
                    </div>
                </div>

                <button class="btn-reservar" id="btnReservar" onclick="reservar()">
                    <i class="bi bi-calendar2-check-fill"></i> Reservar ahora
                </button>
                <div class="security-note">
                    <i class="bi bi-shield-check"></i>
                    Preautorización segura · PlacetoPay · Evertec
                </div>

                <div class="preauth-notice" id="preauthNotice">
                    🔐 <strong>Preautorización:</strong> Tu tarjeta no será cobrada hasta el check-out. Solo se reserva el monto como garantía.
                </div>
            </div>
        </aside>
    </main>

    <!-- ═══ INTEGRACIÓN PLACETOPAY ═══ -->
    <section class="integration-docs" style="--code-accent:var(--accent); --code-accent-ink:#ffffff; --code-accent-soft:var(--accent-soft); --code-radius-sm:6px; --code-radius-md:var(--radius-md); --code-radius-lg:var(--radius-lg); --code-font:var(--font-body);">
        <span class="integration-docs__badge"><i class="bi bi-braces"></i> Integración PlacetoPay</span>
        <h3>Así se crea la sesión de pago de esta reserva</h3>
        <p>Cuando presionas <strong>"Reservar ahora"</strong>, nuestro backend arma este mismo request y lo envía a <strong>PlacetoPay Web Checkout</strong> con <code>type: "checkin"</code>. Esto aparta el monto en tu tarjeta como garantía, <strong>sin cobrarlo todavía</strong> — el cargo real se hace al check-out.</p>

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
  <span class="cm">// "checkin": aparta el monto sin cobrarlo todavía</span>
  <span class="jk">"type"</span>: <span class="js">"checkin"</span>,
  <span class="jk">"payment"</span>: {
    <span class="jk">"reference"</span>: <span class="js">"PRE-9F3A2E1C"</span>,
    <span class="jk">"description"</span>: <span class="js">"Reserva Habitación Estándar - 3 noches"</span>,
    <span class="jk">"amount"</span>: { <span class="jk">"currency"</span>: <span class="js">"COP"</span>, <span class="jk">"total"</span>: <span class="jn">450000</span> }
  },
  <span class="jk">"buyer"</span>: {
    <span class="jk">"name"</span>: <span class="js">"Andrés Torres"</span>,
    <span class="jk">"surname"</span>: <span class="js">""</span>,
    <span class="jk">"email"</span>: <span class="js">"usuario@correo.com"</span>,
    <span class="jk">"documentType"</span>: <span class="js">"CC"</span>,
    <span class="jk">"document"</span>: <span class="js">"1234567890"</span>,
    <span class="jk">"mobile"</span>: <span class="js">"3001234567"</span>
  },
  <span class="jk">"expiration"</span>: <span class="js">"2026-08-27T10:15:32-05:00"</span>,
  <span class="jk">"returnUrl"</span>: <span class="js">"https://tu-dominio.com/retorno/retorno_preautorizacion.php?reserva_id=482"</span>,
  <span class="jk">"ipAddress"</span>: <span class="js">"203.0.113.42"</span>,
  <span class="jk">"userAgent"</span>: <span class="js">"Mozilla/5.0 (Windows NT 10.0; Win64; x64)"</span>,
  <span class="jk">"notificationUrl"</span>: <span class="js">"https://tu-dominio.com/php/notify.php"</span>
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

<span class="cm">// cuerpo del request — "checkin" preautoriza en vez de cobrar</span>
<span class="cvar">$body</span> = [
    <span class="jk">'locale'</span> =&gt; <span class="js">'es_CO'</span>,
    <span class="jk">'auth'</span>   =&gt; [
        <span class="jk">'login'</span>   =&gt; <span class="cvar">$login</span>,
        <span class="jk">'tranKey'</span> =&gt; <span class="cvar">$tranKey</span>,
        <span class="jk">'nonce'</span>   =&gt; <span class="cvar">$nonceB64</span>,
        <span class="jk">'seed'</span>    =&gt; <span class="cvar">$seed</span>,
    ],
    <span class="jk">'type'</span>    =&gt; <span class="js">'checkin'</span>,  <span class="cm">// ← clave: preautoriza, no cobra</span>
    <span class="jk">'payment'</span> =&gt; [
        <span class="jk">'reference'</span>   =&gt; <span class="js">'PRE-'</span> . strtoupper(bin2hex(random_bytes(4))),
        <span class="jk">'description'</span> =&gt; <span class="js">'Reserva '</span> . <span class="cvar">$habitacion</span> . <span class="js">' - '</span> . <span class="cvar">$noches</span> . <span class="js">' noches'</span>,
        <span class="jk">'amount'</span>      =&gt; [<span class="jk">'currency'</span> =&gt; <span class="js">'COP'</span>, <span class="jk">'total'</span> =&gt; <span class="cvar">$total</span>],
    ],
    <span class="jk">'buyer'</span> =&gt; [
        <span class="jk">'name'</span>         =&gt; <span class="cvar">$nombre</span>,
        <span class="jk">'surname'</span>      =&gt; <span class="js">''</span>,
        <span class="jk">'email'</span>        =&gt; <span class="cvar">$correo</span>,
        <span class="jk">'documentType'</span> =&gt; <span class="cvar">$tipo_doc</span>,
        <span class="jk">'document'</span>     =&gt; <span class="cvar">$num_doc</span>,
        <span class="jk">'mobile'</span>       =&gt; <span class="cvar">$telefono</span>,
    ],
    <span class="jk">'expiration'</span>      =&gt; date(<span class="js">'c'</span>, strtotime(<span class="js">'+2 days'</span>)),
    <span class="jk">'returnUrl'</span>       =&gt; app_base_url() . <span class="js">'/retorno/retorno_preautorizacion.php?reserva_id='</span> . <span class="cvar">$reserva_id</span>,
    <span class="jk">'ipAddress'</span>       =&gt; <span class="cvar">$_SERVER</span>[<span class="js">'REMOTE_ADDR'</span>],
    <span class="jk">'userAgent'</span>       =&gt; <span class="cvar">$_SERVER</span>[<span class="js">'HTTP_USER_AGENT'</span>],
    <span class="jk">'notificationUrl'</span> =&gt; <span class="cvar">$notifyUrl</span>,
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
            <span>La construcción del request es la <strong>misma</strong> que un Web Checkout normal — lo único que cambia es <code>type: "checkin"</code>. Si cancelas antes del check-in, el monto reservado se libera automáticamente sin ningún cargo.</span>
        </div>

        <a class="integration-docs__link" href="../guias/guia-developer.php#tipos-pago">
            <div>
                <strong>¿Quieres entender esta integración a fondo?</strong>
                <span>Lee la documentación completa sobre tipos de pago — incluye preautorización.</span>
            </div>
            <i class="bi bi-arrow-right"></i>
        </a>
    </section>

    <script>
    (function() {
        const products = {
            1:{name:'🛏️ Habitación Estándar',   precio:150000,  price:'150.000 COP'},
            2:{name:'🛏️🛏️ Habitación Doble',    precio:220000,  price:'220.000 COP'},
            3:{name:'🌊 Vista al Mar',            precio:320000,  price:'320.000 COP'},
            4:{name:'✨ Suite Junior',             precio:480000,  price:'480.000 COP'},
            5:{name:'👑 Suite Presidencial',      precio:850000,  price:'850.000 COP'},
            6:{name:'👨‍👩‍👧‍👦 Habitación Familiar', precio:280000,  price:'280.000 COP'},
            7:{name:'💼 Habitación Ejecutiva',    precio:390000,  price:'390.000 COP'},
            8:{name:'🌆 Penthouse',               precio:1200000, price:'1.200.000 COP'},
        };

        let selectedId = null;

        function fmt(n) { return '$' + n.toLocaleString('es-CO') + ' COP'; }

        window.calcTotal = function() {
            if (!selectedId) return;
            const ci = document.getElementById('checkIn').value;
            const co = document.getElementById('checkOut').value;
            if (!ci || !co) return;
            const diff = (new Date(co) - new Date(ci)) / 86400000;
            if (diff <= 0) {
                document.getElementById('totalNochesRow').style.display = 'none';
                return;
            }
            const total = diff * products[selectedId].precio;
            document.getElementById('totalNochesText').textContent = diff + ' noche(s) × ' + products[selectedId].price;
            document.getElementById('totalFinalText').textContent  = 'Total: ' + fmt(total);
            document.getElementById('totalNochesRow').style.display = 'block';
        };

        function initCards() {
            const cards = document.querySelectorAll('.room-card');
            if (!cards.length) { setTimeout(initCards, 100); return; }
            cards.forEach(function(card) {
                card.addEventListener('click', function() {
                    cards.forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');
                    selectedId = parseInt(card.getAttribute('data-id'));
                    document.getElementById('checkoutName').textContent  = products[selectedId].name;
                    document.getElementById('checkoutPrice').textContent = products[selectedId].price;
                    calcTotal();
                });
            });
        }

        // Fechas mínimas
        const hoy = new Date().toISOString().split('T')[0];
        document.getElementById('checkIn').min  = hoy;
        document.getElementById('checkOut').min = hoy;

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCards);
        } else { initCards(); }

        window.reservar = function() {
            if (!selectedId) { alert('⚠️ Selecciona una habitación.'); return; }

            const ci      = document.getElementById('checkIn').value;
            const co      = document.getElementById('checkOut').value;
            const nombre  = document.getElementById('hNombre').value.trim();
            const correo  = document.getElementById('hCorreo').value.trim();
            const tel     = document.getElementById('hTelefono').value.trim();
            const tipoDoc = document.getElementById('hTipoDoc').value;
            const numDoc  = document.getElementById('hNumDoc').value.trim();

            if (!ci || !co)       { alert('⚠️ Selecciona las fechas de check-in y check-out.'); return; }
            if (new Date(co) <= new Date(ci)) { alert('⚠️ El check-out debe ser posterior al check-in.'); return; }
            if (!nombre || !correo || !tel || !numDoc) { alert('⚠️ Completa todos los datos del huésped.'); return; }

            const noches = (new Date(co) - new Date(ci)) / 86400000;
            const total  = noches * products[selectedId].precio;
            const card   = document.querySelector('.room-card.selected');

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../../php/crear_preautorizacion.php';

            [
                ['habitacion',  card.getAttribute('data-nombre')],
                ['precio',      products[selectedId].precio],
                ['total',       total],
                ['noches',      noches],
                ['checkin',     ci],
                ['checkout',    co],
                ['nombre',      nombre],
                ['correo',      correo],
                ['telefono',    tel],
                ['tipo_doc',    tipoDoc],
                ['num_doc',     numDoc],
            ].forEach(function(pair) {
                const input = document.createElement('input');
                input.type = 'hidden'; input.name = pair[0]; input.value = pair[1];
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
    <script src="../../assets/js/components/driver-tours/tour-hotel.js"></script>
</body>
</html>