<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión | Plance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg:      #0a0a0a;
            --surface: #111111;
            --card:    #141414;
            --border:  #222222;
            --accent:  rgb(255, 91, 26);
            --accent-soft: rgba(252, 111, 29, 0.1);
            --text:    #f0f1f3;
            --muted:   #8a8d96;
            --font-d:   'Barlow', sans-serif;
            --font-b:   'Barlow', sans-serif;
        }
        *,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--bg); color: var(--text);
            font-family: var(--font-b); min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* NAV */
        .topnav {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 2rem; border-bottom: 1px solid var(--border);
            background: rgba(10,10,10,0.95); backdrop-filter: blur(12px);
            position: sticky; top: 0; z-index: 10;
        }
        .topnav-brand { display: flex; align-items: center; gap: 0.5rem; text-decoration: none; }
        .brand-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--accent); box-shadow: 0 0 0 6px rgba(240,180,41,0.15); } 
        .brand-name { font-family: var(--font-d); font-size: 1.1rem; font-weight: 800; color: var(--text); letter-spacing: 0.04em; }
        .btn-back {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: var(--accent-soft); border: 1px solid rgba(240,180,41,0.3);
            color: var(--accent); border-radius: 8px; padding: 0.45rem 1rem;
            font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.2s;
        }
        .btn-back:hover { background: rgba(255, 92, 16, 0.18); }

        /* HERO */
        .hero {
            text-align: center; padding: 5rem 2rem 3rem;
            background: radial-gradient(ellipse at top, rgba(240,180,41,0.08), transparent 60%);
        }
        .hero-tag {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: var(--accent-soft); border: 1px solid rgba(240,180,41,0.25);
            color: var(--accent); border-radius: 20px; padding: 0.3rem 1rem;
            font-size: 0.8rem; font-weight: 700; letter-spacing: 0.06em;
            text-transform: uppercase; margin-bottom: 1.5rem;
            animation: fadeDown 0.6s ease both;
        }
        .hero h1 {
            font-family: var(--font-d); font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 800; line-height: 1.05; letter-spacing: 0.02em;
            margin-bottom: 1rem;
            animation: fadeDown 0.6s 0.1s ease both;
        }
        .hero h1 span { color: var(--accent); }
        .hero p {
            max-width: 580px; margin: 0 auto; color: var(--muted);
            font-size: 1.05rem; line-height: 1.75;
            animation: fadeDown 0.6s 0.2s ease both;
        }
        .sub-title { font-family: var(--font-d); font-size: 1.1rem; margin-bottom: 0.6rem; letter-spacing: 0.02em; background: var(--accent-soft); padding: 0.3rem 0.7rem; border-radius: 20px; color: rgb(255, 121, 11); } 

        /* GRID */
        .container { max-width: 1100px; margin: 0 auto; padding: 3rem 2rem 5rem; }

        .cards-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 1.2rem; margin-bottom: 2rem;
        }
        .cards-grid-2 { grid-template-columns: repeat(2, 1fr); }

        /* CARD */
        .card {
            background: var(--card); border: 1px solid var(--border);
            border-radius: 16px; padding: 1.8rem;
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
            opacity: 0; transform: translateY(24px);
            animation: cardIn 0.5s ease forwards;
        }
        .card:hover {
            transform: translateY(-4px);
            border-color: rgba(240, 97, 41, 0.3);
            box-shadow: 0 12px 32px rgba(0,0,0,0.4);
        }
        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.2s; }
        .card:nth-child(5) { animation-delay: 0.3s; }

        .card-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: var(--accent-soft); border: 1px solid rgba(240,180,41,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; margin-bottom: 1rem;
        }
        .card h3 { font-family: var(--font-d); font-size: 1.2rem; font-weight: 800; margin-bottom: 0.6rem; letter-spacing: 0.02em; }
        .card p  { color: var(--muted); font-size: 0.9rem; line-height: 1.7; }
        .card-tag {
            display: inline-block; margin-top: 1rem;
            background: var(--accent-soft); color: var(--accent);
            font-size: 0.72rem; font-weight: 700; padding: 0.2rem 0.7rem;
            border-radius: 20px; letter-spacing: 0.05em;
        }

        /* BANNER */
        .banner {
            background: linear-gradient(135deg, #141414, #0f0f0f);
            border: 1px solid rgba(240,180,41,0.2);
            border-left: 4px solid var(--accent);
            border-radius: 14px; padding: 2rem 2.5rem;
            display: flex; align-items: center; gap: 2rem;
            margin-bottom: 2rem;
            animation: fadeDown 0.6s 0.4s ease both; opacity: 0;
        }
        .banner.animated { opacity: 1; }
        .banner-icon { font-size: 2.5rem; flex-shrink: 0; }
        .banner h2 { font-family: var(--font-d); font-size: 1.6rem; font-weight: 800; margin-bottom: 0.4rem; }
        .banner p  { color: var(--muted); font-size: 0.92rem; line-height: 1.7; margin: 0; }

        /* SECTION TITLE */
        .section-title {
            font-family: var(--font-d); font-size: 0.78rem; font-weight: 700;
            letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--accent); margin-bottom: 1rem;
        }

        @keyframes fadeDown { from { opacity:0; transform:translateY(-12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes cardIn  { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }

        @media(max-width:800px) { .cards-grid, .cards-grid-2 { grid-template-columns: 1fr; } .banner { flex-direction: column; gap: 1rem; } }
    </style>
</head>
<body>

<nav class="topnav">
        <a href="../../index.php">
            <img src="../../assets/icons/icono.png" alt="Icon" style="height: 35px;">
        </a>
    <a href="../../index.php" class="btn-back">← Volver</a>
</nav>

<section class="hero">
    <div class="hero-tag"><i class="bi bi-table" style="color: #ff6600;"></i> Gestión</div>
    <h1>Administra todo<br>desde <span>un solo lugar</span></h1>
    <p>Este panel fue creado para que tanto comercios como usuarios puedan experimentar y entender los servicios de PlacetoPay, con una visión clara de cómo integrarlos en sus propios proyectos.</p>
</section>

<div class="container">

    <div class="banner">
        <div class="banner-icon"><i class="fa-solid fa-lightbulb" style="color: hsl(0, 0%, 98%);"></i></div>
        <div>
            <h2 >¿Para qué sirve?</h2>
            <p>Esta es una plataforma de demostración construida sobre PlacetoPay. Su propósito es mostrar a los comercios cómo se ve y cómo funciona un sistema de pagos completo — desde una recarga de videojuego hasta una suscripción recurrente — para que tengan una referencia concreta antes de integrar el servicio en su negocio.</p>
        </div>
    </div>

    <p class="section-title">¿Qué puedes gestionar?</p>
    <div class="cards-grid">
        <div class="card">
            <div class="card-icon"><i class="fa-solid fa-gamepad" style="color: hsl(17, 100%, 56%);"></i></div>
            <h3 class="sub-title">Recargas y pagos únicos</h3>
            <p>Gestiona compras de productos digitales como monedas, puntos o pases de batalla para juegos. Cada transacción queda registrada y puede consultarse en cualquier momento.</p>
            <span class="card-tag">Web Checkout</span>
        </div>
        <div class="card">
            <div class="card-icon"><i class="fa-brands fa-chromecast" style="color: hsl(17, 100%, 56%);"></i></div>
            <h3 class="sub-title">Suscripciones activas</h3>
            <p>Administra las suscripciones de streaming y plataformas digitales. Puedes ver cuáles están activas, cuáles tienen tarjeta guardada y cuáles están pendientes de pago.</p>
            <span class="card-tag">Suscripción</span>
        </div>
        <div class="card">
            <div class="card-icon"><i class="fa-solid fa-rotate" style="color: hsl(17, 100%, 56%);"></i></div>
            <h3 class="sub-title">Membresías recurrentes</h3>
            <p>Controla las membresías con cobro automático mensual o anual. Desde aquí puedes ver la fecha del próximo cobro, el fin de la recurrencia y cancelar si es necesario.</p>
            <span class="card-tag">Recurrente</span>
        </div>
    </div>

    <p class="section-title">Otros tipos de compra</p>
    <div class="cards-grid cards-grid-2">
        <div class="card">
            <div class="card-icon"><i class="fa-solid fa-shirt" style="color: hsl(17, 100%, 56%);"></i></div>
            <h3 class="sub-title">Compras textiles</h3>
            <p>Gestiona compras de ropa y accesorios con pago básico, procesadas por Web Checkout o por Link de Pago vía API.</p>
            <span class="card-tag">Pago Básico</span>
        </div>
        <div class="card">
            <div class="card-icon"><i class="fa-solid fa-plane-departure" style="color: hsl(17, 100%, 56%);"></i></div>
            <h3 class="sub-title">Reservas y dispersión</h3>
            <p>Reserva hoteles con preautorización de tarjeta o gestiona la dispersión de pagos como tickets y vuelos.</p>
            <span class="card-tag">Preautorización · Dispersión</span>
        </div>
    </div>

    <p class="section-title">¿Cómo funciona el flujo?</p>
    <div class="cards-grid cards-grid-2">
        <div class="card">
            <div class="card-icon"><i class="fa-solid fa-bolt" style="color: hsl(17, 100%, 56%);"></i></div>
            <h3 class="sub-title">API Gateway</h3>
            <p>Para comercios que necesitan control total sobre la experiencia de pago. El comercio maneja directamente los datos del usuario y los procesa a través del backend de PlacetoPay, sin redirigir al usuario a otra página.</p>
            <span class="card-tag">Backend directo</span>
        </div>
        <div class="card">
            <div class="card-icon"><i class="fa-solid fa-desktop" style="color: hsl(17, 100%, 56%);"></i></div>
            <h3 class="sub-title">Web Checkout</h3>
            <p>La forma más sencilla de cobrar. PlacetoPay se encarga de toda la experiencia de pago — el usuario es redirigido a una página segura donde ingresa sus datos sin que el comercio los maneje directamente.</p>
            <span class="card-tag">Redireccionado </span>
        </div>
    </div>

</div>
</body>
</html>