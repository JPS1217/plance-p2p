<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros | Plance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <style>
        :root {
            --bg: #0a0a0a; --surface: #111111; --card: #141414; --border: #222222;
            --accent: #ff5c1b; --accent-soft:rgba(255, 81, 0, 0.1);
            --text: #f0f1f3; --muted: #8a8d96;
            --font-d:'Barlow',sans-serif; --font-b:'Barlow',sans-serif;
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{background:var(--bg);color:var(--text);font-family:var(--font-b);min-height:100vh;-webkit-font-smoothing:antialiased;}

        .topnav{display:flex;align-items:center;justify-content:space-between;padding:1rem 2rem;border-bottom:1px solid var(--border);background:rgba(10,10,10,0.95);backdrop-filter:blur(12px);position:sticky;top:0;z-index:10;}
        .topnav-brand{display:flex;align-items:center;gap:0.5rem;text-decoration:none;}
        .brand-dot{width:10px;height:10px;border-radius:50%;background:var(--accent);box-shadow:0 0 0 6px rgba(255, 81, 0, 0.15);}
        .brand-name{font-family:var(--font-d);font-size:1.1rem;font-weight:800;color:var(--text);letter-spacing:0.04em;}
        .btn-back{display:inline-flex;align-items:center;gap:0.4rem;background:var(--accent-soft);border:1px solid rgba(255, 81, 0, 0.3);color:var(--accent);border-radius:8px;padding:0.45rem 1rem;font-size:0.85rem;font-weight:600;text-decoration:none;transition:all 0.2s;}
        .btn-back:hover{background:rgba(253, 114, 0, 0.18);}

        .hero{text-align:center;padding:5rem 2rem 3rem;background:radial-gradient(ellipse at top, rgba(230, 81, 36, 0.08), transparent 60%);} 
        .hero-tag{display:inline-flex;align-items:center;gap:0.4rem;background:var(--accent-soft);border:1px solid rgba(240, 121, 41, 0.25);color:var(--accent);border-radius:20px;padding:0.3rem 1rem;font-size:0.8rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:1.5rem;animation:fadeDown 0.6s ease both;}
        .hero h1{font-family:var(--font-d);font-size:clamp(2.5rem,6vw,4.5rem);font-weight:800;line-height:1.05;letter-spacing:0.02em;margin-bottom:1rem;animation:fadeDown 0.6s 0.1s ease both;}
        .hero h1 span{color:var(--accent);}
        .hero p{max-width:580px;margin:0 auto;color:var(--muted);font-size:1.05rem;line-height:1.75;animation:fadeDown 0.6s 0.2s ease both;}

        .container{max-width:1100px;margin:0 auto;padding:3rem 2rem 5rem;}
        .section-title{font-family:var(--font-d);font-size:0.78rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--accent);margin-bottom:1rem;}

        .cards-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.2rem;margin-bottom:2rem;}
        .cards-grid-2{grid-template-columns:repeat(2,1fr);}

        .card{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:1.8rem;transition:transform 0.3s ease,border-color 0.3s ease,box-shadow 0.3s ease;opacity:0;transform:translateY(24px);animation:cardIn 0.5s ease forwards;}
        .card:hover{transform:translateY(-4px);border-color:rgba(240, 121, 41, 0.3);box-shadow:0 12px 32px rgba(0,0,0,0.4);}
        .card:nth-child(1){animation-delay:0.1s;}
        .card:nth-child(2){animation-delay:0.2s;}
        .card:nth-child(3){animation-delay:0.3s;}
        .card:nth-child(4){animation-delay:0.2s;}
        .card:nth-child(5){animation-delay:0.3s;}

        .card-icon{width:44px;height:44px;border-radius:12px;background:var(--accent-soft);border:1px solid rgba(240, 121, 41, 0.2);display:flex;align-items:center;justify-content:center;font-size:1.3rem;margin-bottom:1rem;}
        .card h3{font-family:var(--font-d);font-size:1.2rem;font-weight:800;margin-bottom:0.6rem;letter-spacing:0.02em;}
        .card p{color:var(--muted);font-size:0.9rem;line-height:1.7;}
        .card-tag{display:inline-block;margin-top:1rem;background:var(--accent-soft);color:var(--accent);font-size:0.72rem;font-weight:700;padding:0.2rem 0.7rem;border-radius:20px;letter-spacing:0.05em;}

        /* Estado pills */
        .estados{display:flex;gap:0.5rem;flex-wrap:wrap;margin-top:1rem;}
        .estado{display:inline-flex;align-items:center;gap:0.3rem;padding:0.2rem 0.65rem;border-radius:20px;font-size:0.75rem;font-weight:700;letter-spacing:0.04em;}
        .estado.aprobada{background:rgba(62,207,142,0.15);color:#3ecf8e;}
        .estado.pendiente{background:rgba(240,180,41,0.15);color:#f0b429;}
        .estado.rechazada{background:rgba(224,82,82,0.15);color:#e05252;}
        .estado.reversada{background:rgba(138,141,150,0.15);color:#8a8d96;}

        .banner{background:linear-gradient(135deg,#141414,#0f0f0f);border:1px solid rgba(240,180,41,0.2);border-left:4px solid var(--accent);border-radius:14px;padding:2rem 2.5rem;display:flex;align-items:center;gap:2rem;margin-bottom:2rem;animation:fadeDown 0.6s 0.4s ease both;}
        .banner-icon{font-size:2.5rem;flex-shrink:0;}
        .banner h2{font-family:var(--font-d);font-size:1.6rem;font-weight:800;margin-bottom:0.4rem;}
        .banner p{color:var(--muted);font-size:0.92rem;line-height:1.7;margin:0;}

        /* Timeline */
        .timeline{display:grid;gap:0.8rem;margin-bottom:2rem;}
        .timeline-item{display:grid;grid-template-columns:36px 1fr;gap:1rem;align-items:start;padding:1.2rem;background:var(--card);border:1px solid var(--border);border-radius:12px;transition:border-color 0.2s;opacity:0;animation:cardIn 0.5s ease forwards;}
        .timeline-item:hover{border-color:rgba(240,180,41,0.25);}
        .timeline-item:nth-child(1){animation-delay:0.1s;}
        .timeline-item:nth-child(2){animation-delay:0.2s;}
        .timeline-item:nth-child(3){animation-delay:0.3s;}
        .timeline-item:nth-child(4){animation-delay:0.4s;}
        .tl-num{width:36px;height:36px;border-radius:50%;background:var(--accent-soft);border:1px solid rgba(240,180,41,0.35);color:var(--accent);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.85rem;flex-shrink:0;}
        .tl-title{font-family:var(--font-d);font-size:1rem;font-weight:700;margin-bottom:0.3rem;}
        .tl-desc{color:var(--muted);font-size:0.87rem;line-height:1.6;}

        @keyframes fadeDown{from{opacity:0;transform:translateY(-12px);}to{opacity:1;transform:translateY(0);}}
        @keyframes cardIn{from{opacity:0;transform:translateY(24px);}to{opacity:1;transform:translateY(0);}}
        @media(max-width:800px){.cards-grid,.cards-grid-2{grid-template-columns:1fr;}.banner{flex-direction:column;gap:1rem;}}
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
    <div class="hero-tag"><i class="bi bi-clipboard-data-fill" style="color: #ff5c1b;"></i> Registros</div>
    <h1>Tus transacciones,<br><span>siempre visibles</span></h1>
    <p>Cada pago, suscripción o membresía que realizas que hagas queda registrada automáticamente. Aquí te explicamos qué significa cada estado y cómo interpretar tu historial.</p>
</section>

<div class="container">

    <div class="banner">
        <div class="banner-icon"><i class="bi bi-journal-text"></i></div>
        <div>
            <h2>¿Por qué es importante el historial?</h2>
            <p>En un sistema de pagos real, el historial es la fuente de verdad. Permite al comercio rastrear ingresos, detectar transacciones pendientes y atender solicitudes de reverso o reembolso. Plance demuestra cómo se vería ese historial en producción con PlacetoPay.</p>
        </div>
    </div>

    <p class="section-title">Estados de una transacción</p>
    <div class="cards-grid">
        <div class="card">
            <div class="card-icon"><i class="fa-solid fa-circle-check" style="color: rgb(115, 255, 0);"></i></div>
            <h3>Aprobada</h3>
            <p>El pago fue procesado y confirmado exitosamente. El dinero fue debitado y el producto o servicio quedó activo.</p>
            <div class="estados"><span class="estado aprobada">APROBADA</span></div>
        </div>
        <div class="card">
            <div class="card-icon"><i class="fa-solid fa-hourglass-half" style="color: hsl(56, 100%, 50%);"></i></div>
            <h3>Pendiente</h3>
            <p>El pago está en proceso. Puede ocurrir por problemas de conexión o porque el usuario cerró el checkout antes de completarlo. Se puede verificar manualmente.</p>
            <div class="estados"><span class="estado pendiente">PENDIENTE</span></div>
        </div>
        <div class="card">
            <div class="card-icon"><i class="fa-solid fa-circle-xmark" style="color: hsl(4, 100%, 62%);"></i></div>
            <h3>Rechazada / Reversada</h3>
            <p>El pago fue rechazado por el banco o fue reversado por el comercio antes de liquidarse. El dinero no fue cobrado o fue devuelto automáticamente.</p>
            <div class="estados"><span class="estado rechazada">RECHAZADA</span><span class="estado reversada">REVERSADA</span></div>
        </div>
    </div>

    <p class="section-title">¿Qué tipo de registros existen?</p>
    <div class="cards-grid cards-grid-2">
        <div class="card">
            <div class="card-icon"><i class="bi bi-laptop" style="color: #ff5c1b;"></i></div>
            <h3>Registros Web Checkout</h3>
            <p>Incluyen pagos básicos de juegos y textiles, reservas con preautorización, dispersión de tickets, suscripciones de streaming y membresías recurrentes. Todos procesados a través de la pasarela visual de PlacetoPay.</p>
            <span class="card-tag">Web Checkout</span>
        </div>
        <div class="card">
            <div class="card-icon"><i class="bi bi-lightning-fill" style="color: #ff5c1b;"></i></div>
            <h3>Registros API Gateway</h3>
            <p>Incluyen pagos directos procesados desde el backend — como recargas de PUBG, Blood Strike, streaming y música — sin redirigir al usuario a la página de PlacetoPay.</p>
            <span class="card-tag">API Gateway</span>
        </div>
    </div>

    <p class="section-title">¿Cómo se actualiza un registro?</p>
    <div class="timeline">
        <div class="timeline-item">
            <div class="tl-num">1</div>
            <div>
                <div class="tl-title">El usuario realiza el pago</div>
                <div class="tl-desc">Al confirmar la transacción, el registro se crea automáticamente en la base de datos con estado "pendiente".</div>
            </div>
        </div>
        <div class="timeline-item">
            <div class="tl-num">2</div>
            <div>
                <div class="tl-title">PlacetoPay procesa la respuesta</div>
                <div class="tl-desc">Al regresar del checkout o al recibir la notificación del servidor, el estado se actualiza a "aprobada" o "rechazada".</div>
            </div>
        </div>
        <div class="timeline-item">
            <div class="tl-num">3</div>
            <div>
                <div class="tl-title">Verificación manual si es necesario</div>
                <div class="tl-desc">Si el pago quedó pendiente, el usuario puede verificar su estado desde el historial con un botón que consulta directamente a PlacetoPay.</div>
            </div>
        </div>
        <div class="timeline-item">
            <div class="tl-num">4</div>
            <div>
                <div class="tl-title">Reverso si aplica</div>
                <div class="tl-desc">Antes de la hora de corte del día, el comercio puede reversar una transacción aprobada. El dinero nunca llega a liquidarse.</div>
            </div>
        </div>
    </div>

</div>
</body>
</html>