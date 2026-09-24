<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experiencia | Plance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <style>
        :root {
            --bg: #0a0a0a; --surface: #111111; --card: #141414; --border: #222222;
            --accent: #f06829; --accent-soft:rgba(255, 107, 38, 0.1);
            --text: #f0f1f3; --muted: #8a8d96;
            --font-d:'Barlow',sans-serif; --font-b:'Barlow',sans-serif;
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{background:var(--bg);color:var(--text);font-family:var(--font-b);min-height:100vh;-webkit-font-smoothing:antialiased;}
 
        .topnav{display:flex;align-items:center;justify-content:space-between;padding:1rem 2rem;border-bottom:1px solid var(--border);background:rgba(10,10,10,0.95);backdrop-filter:blur(12px);position:sticky;top:0;z-index:10;}
        .topnav-brand{display:flex;align-items:center;gap:0.5rem;text-decoration:none;}
        .brand-dot{width:10px;height:10px;border-radius:50%;background:var(--accent);box-shadow:0 0 0 6px rgba(240,180,41,0.15);}
        .brand-name{font-family:var(--font-d);font-size:1.1rem;font-weight:800;color:var(--text);letter-spacing:0.04em;}
        .btn-back{display:inline-flex;align-items:center;gap:0.4rem;background:var(--accent-soft);border:1px solid rgba(240,180,41,0.3);color:var(--accent);border-radius:8px;padding:0.45rem 1rem;font-size:0.85rem;font-weight:600;text-decoration:none;transition:all 0.2s;}
        .btn-back:hover{background:rgba(240,180,41,0.18);}

        .hero{text-align:center;padding:5rem 2rem 3rem;background:radial-gradient(ellipse at top,rgba(240,180,41,0.08),transparent 60%);}
        .hero-tag{display:inline-flex;align-items:center;gap:0.4rem;background:var(--accent-soft);border:1px solid rgba(240,180,41,0.25);color:var(--accent);border-radius:20px;padding:0.3rem 1rem;font-size:0.8rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:1.5rem;animation:fadeDown 0.6s ease both;}
        .hero h1{font-family:var(--font-d);font-size:clamp(2.5rem,6vw,4.5rem);font-weight:800;line-height:1.05;letter-spacing:0.02em;margin-bottom:1rem;animation:fadeDown 0.6s 0.1s ease both;}
        .hero h1 span{color:var(--accent);}
        .hero p{max-width:580px;margin:0 auto;color:var(--muted);font-size:1.05rem;line-height:1.75;animation:fadeDown 0.6s 0.2s ease both;}

        .container{max-width:1100px;margin:0 auto;padding:3rem 2rem 5rem;}
        .section-title{font-family:var(--font-d);font-size:0.78rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--accent);margin-bottom:1rem;}

        .cards-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.2rem;margin-bottom:2rem;}
        .cards-grid-2{grid-template-columns:repeat(2,1fr);}

        .card{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:1.8rem;transition:transform 0.3s ease,border-color 0.3s ease,box-shadow 0.3s ease;opacity:0;transform:translateY(24px);animation:cardIn 0.5s ease forwards;}
        .card:hover{transform:translateY(-4px);border-color:rgba(240,180,41,0.3);box-shadow:0 12px 32px rgba(0,0,0,0.4);}
        .card:nth-child(1){animation-delay:0.1s;}
        .card:nth-child(2){animation-delay:0.2s;}
        .card:nth-child(3){animation-delay:0.3s;}
        .card:nth-child(4){animation-delay:0.2s;}
        .card:nth-child(5){animation-delay:0.3s;}

        .card-icon{width:44px;height:44px;border-radius:12px;background:var(--accent-soft);border:1px solid rgba(240,180,41,0.2);display:flex;align-items:center;justify-content:center;font-size:1.3rem;margin-bottom:1rem;}
        .card h3{font-family:var(--font-d);font-size:1.2rem;font-weight:800;margin-bottom:0.6rem;letter-spacing:0.02em;}
        .card p{color:var(--muted);font-size:0.9rem;line-height:1.7;}
        .card-tag{display:inline-block;margin-top:1rem;background:var(--accent-soft);color:var(--accent);font-size:0.72rem;font-weight:700;padding:0.2rem 0.7rem;border-radius:20px;letter-spacing:0.05em;}

        .banner{background:linear-gradient(135deg,#141414,#0f0f0f);border:1px solid rgba(240,180,41,0.2);border-left:4px solid var(--accent);border-radius:14px;padding:2rem 2.5rem;display:flex;align-items:center;gap:2rem;margin-bottom:2rem;animation:fadeDown 0.6s 0.4s ease both;}
        .banner-icon{font-size:2.5rem;flex-shrink:0;}
        .banner h2{font-family:var(--font-d);font-size:1.6rem;font-weight:800;margin-bottom:0.4rem;}
        .banner p{color:var(--muted);font-size:0.92rem;line-height:1.7;margin:0;}

        /* Feature list */
        .feature-list{display:grid;gap:0.8rem;margin-bottom:2rem;}
        .feature-item{display:flex;align-items:flex-start;gap:1rem;padding:1.2rem 1.4rem;background:var(--card);border:1px solid var(--border);border-radius:12px;transition:border-color 0.2s,transform 0.2s;opacity:0;animation:cardIn 0.5s ease forwards;}
        .feature-item:hover{border-color:rgba(240,180,41,0.25);transform:translateX(4px);}
        .feature-item:nth-child(1){animation-delay:0.1s;}
        .feature-item:nth-child(2){animation-delay:0.2s;}
        .feature-item:nth-child(3){animation-delay:0.3s;}
        .feature-item:nth-child(4){animation-delay:0.4s;}
        .fi-icon{font-size:1.3rem;flex-shrink:0;margin-top:0.1rem;}
        .fi-title{font-family:var(--font-d);font-size:1rem;font-weight:700;margin-bottom:0.3rem;}
        .fi-desc{color:var(--muted);font-size:0.87rem;line-height:1.6;}

        /* Seguridad grid */
        .seg-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;margin-bottom:2rem;}
        .seg-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:1.4rem;display:flex;gap:1rem;align-items:flex-start;transition:border-color 0.2s;opacity:0;animation:cardIn 0.5s ease forwards;}
        .seg-card:hover{border-color:rgba(240,180,41,0.25);}
        .seg-card:nth-child(1){animation-delay:0.1s;}
        .seg-card:nth-child(2){animation-delay:0.2s;}
        .seg-card:nth-child(3){animation-delay:0.3s;}
        .seg-card:nth-child(4){animation-delay:0.4s;}
        .seg-icon{font-size:1.4rem;flex-shrink:0;}
        .seg-title{font-family:var(--font-d);font-size:1rem;font-weight:700;margin-bottom:0.3rem;}
        .seg-desc{color:var(--muted);font-size:0.85rem;line-height:1.6;}

        @keyframes fadeDown{from{opacity:0;transform:translateY(-12px);}to{opacity:1;transform:translateY(0);}}
        @keyframes cardIn{from{opacity:0;transform:translateY(24px);}to{opacity:1;transform:translateY(0);}}
        @media(max-width:800px){.cards-grid,.cards-grid-2,.seg-grid{grid-template-columns:1fr;}.banner{flex-direction:column;gap:1rem;}}
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
    <div class="hero-tag"><i class="bi bi-palette-fill" style="color: #f06829;"></i> Experiencia</div>
    <h1>Diseñado para que<br><span>todo sea sencillo</span></h1>
    <p>Pensando en la experiencia del usuario final. Cada detalle — desde el perfil hasta el historial de actividad — está pensado para que cualquier persona entienda qué está pasando con sus pagos.</p>
</section>

<div class="container">

    <div class="banner">
        <div class="banner-icon"><i class="bi bi-ui-checks-grid" ></i></div>
        <div>
            <h2>¿Qué hace única la experiencia?</h2>
            <p>A diferencia de otras demos, este panel no solo se muestra que un pago funciona — muestra todo el ecosistema alrededor: el perfil del usuario, su actividad histórica, sus suscripciones activas, sus opciones de cancelación y reverso. Es una experiencia completa de principio a fin.</p>
        </div>
    </div>

    <p class="section-title">Características de la experiencia</p>
    <div class="feature-list">
        <div class="feature-item">
            <div class="fi-icon"><i class="bi bi-person-fill" style="color: #f06829;"></i></div>
            <div>
                <div class="fi-title">Perfil personalizable</div>
                <div class="fi-desc">Cada usuario tiene su propio perfil con foto, bio, ubicación y un calendario de actividad que muestra visualmente sus transacciones de los últimos 365 días — similar al de GitHub.</div>
            </div>
        </div>
        <div class="feature-item">
            <div class="fi-icon"><i class="bi bi-graph-up-arrow" style="color: #f06829;" ></i></div>
            <div>
                <div class="fi-title">Resumen de actividad en tiempo real</div>
                <div class="fi-desc">El panel del perfil muestra en tiempo real cuántas recargas, suscripciones y membresías tiene el usuario, incluyendo los pagos procesados vía API Gateway.</div>
            </div>
        </div>
        <div class="feature-item">
            <div class="fi-icon"><i class="bi bi-arrow-repeat" style="color: #f06829;"></i></div>
            <div>
                <div class="fi-title">Gestión de suscripciones y cancelaciones</div>
                <div class="fi-desc">El usuario puede ver sus membresías activas, la fecha del próximo cobro y cancelarlas directamente desde el historial con un solo click.</div>
            </div>
        </div>
        <div class="feature-item">
            <div class="fi-icon"><i class="bi bi-arrow-return-right" style="color: #f06829;"></i></div>
            <div>
                <div class="fi-title">Reverso de transacciones</div>
                <div class="fi-desc">Antes de la hora de corte, el usuario puede solicitar el reverso de un pago aprobado. El sistema genera automáticamente una carta de reverso descargable.</div>
            </div>
        </div>
    </div>

    <p class="section-title">Seguridad en cada paso</p>
    <div class="seg-grid">
        <div class="seg-card">
            <div class="seg-icon"><i class="bi bi-shield-lock-fill" style="color: #f06829;"></i></div>
            <div>
                <div class="seg-title">Tokenización de tarjetas</div>
                <div class="seg-desc">Plance nunca guarda el número real de tu tarjeta. Solo almacena un token seguro generado por PlacetoPay para futuros cobros automáticos.</div>
            </div>
        </div>
        <div class="seg-card">
            <div class="seg-icon"><i class="bi bi-bell-fill" style="color: #f06829;"></i></div>
            <div>
                <div class="seg-title">Notificaciones automáticas (notifyUrl)</div>
                <div class="seg-desc">El servidor recibe notificaciones automáticas de PlacetoPay cuando el estado de un pago cambia, sin necesidad de que el usuario haga nada.</div>
            </div>
        </div>
        <div class="seg-card">
            <div class="seg-icon"><i class="bi bi-bank" style="color: #f06829;"></i></div>
            <div>
                <div class="seg-title">PCI-DSS en Gateway</div>
                <div class="seg-desc">El módulo de API Gateway advierte a los comercios sobre la necesidad de certificación PCI-DSS al manejar datos sensibles directamente en su backend.</div>
            </div>
        </div>
    </div>

    <p class="section-title">Tipos de productos disponibles</p>
    <div class="cards-grid">
        <div class="card">
            <div class="card-icon"><i class="bi bi-joystick" style="color: #f06829;"></i></div>
            <h3>Juegos</h3>
            <p>CoD Mobile y Rainbow Six por Web Checkout, PUBG y Blood Strike por API Gateway — cada tienda con pago básico o mixto.</p>
            <span class="card-tag">4 juegos</span>
        </div>
        <div class="card">
            <div class="card-icon"><i class="bi bi-tv" style="color: #f06829;"></i></div>
            <h3>Plataformas digitales</h3>
            <p>Streaming, redes sociales, IA's, música y otras plataformas — cada una con su propio tipo de pago: único, suscripción, recurrente o puro.</p>
            <span class="card-tag">5 categorías</span>
        </div>
        <div class="card">
            <div class="card-icon"><i class="bi bi-gear" style="color: #f06829;"></i></div>
            <h3>API Gateway</h3>
            <p>Streaming, música y juegos procesados directamente por backend, con formulario de tarjeta o cuenta bancaria</p>
            <span class="card-tag">Demo avanzada</span>
        </div>
    </div>

    <div class="cards-grid cards-grid-2">
        <div class="card">
            <div class="card-icon"><i class="bi bi-bag-fill" style="color: #f06829;"></i></div>
            <h3>Textiles</h3>
            <p>Tienda de ropa y accesorios con pago básico, disponible por Web Checkout y por Link de Pago vía API.</p>
            <span class="card-tag">Pago Básico</span>
        </div>
        <div class="card">
            <div class="card-icon"><i class="bi bi-suitcase-fill" style="color: #f06829;"></i></div>
            <h3>Reservas y dispersión</h3>
            <p>Reservas de hotel con preautorización de tarjeta y dispersión de pagos para tickets y vuelos, ambas por Web Checkout.</p>
            <span class="card-tag">2 categorías</span>
        </div>
    </div>

</div>
</body>
</html>