<?php
    session_start();


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataformas</title>
        <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <!-- Tu CSS -->
    <link rel="stylesheet" href="../../assets/css/estilos.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/estilos.css'); ?>">
    <?php $theme_seccion = 'plataformas'; require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>


<style>
    body {
        /* background-image: url(../assets/images/bg2.jpg); */
        background-color: #111111;
        color: white;

        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        background-size: cover;
        font-family: 'Barlow', sans-serif;
    }
    .card {
        /* background: linear-gradient( rgba(30, 30, 31, 0.8) 0%, hsla(170, 97%, 50%, 0.81)); */
        background-color: var(--pt-navbar);
        background-size: cover;        color: var(--pt-text);
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        align-items: center

    }
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(42, 255, 184, 0.5);
    }
    .card-img-top {
        border-radius: 15px 15px 0 0;
        height: 200px;
        width: 100%;
        object-fit: cover;
    }
    .btn-producto {
        background-color: hsl(182, 97%, 63%);
    }
    .btn:hover{
        background-color: rgb(255, 123, 0);
    }

    main {
        flex: 1;
    }
    .navbar {
        background-color: #252424a9 !important;
        backdrop-filter: blur(8px);
        color:  #ffff;
    }
    .back:hover {
        background: #ff6811f5;
        transform: translateY(-1px);
        box-shadow: 0 5px 10px rgba(255, 94, 0, 0.5);

    }
    /*.suscrip {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #ff6811f5;
        color: rgb(255, 255, 255);
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        padding: 0.15rem 0.55rem;
        border-radius: 12px;
        z-index: 2;
    }*/
    /* necesito centrar los mensajitos naranaja en la parte superior de cada card, y que quede fijo ahi, sin importar el tamaño de la imagen o el contenido de la card. Tambien quiero que tenga un fondo naranja con letras negras, y que se vea como una etiqueta superpuesta a la imagen, pero sin afectar el diseño responsivo de las cards. */

        .suscrip {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgb(0, 255, 255);
            color: rgb(0, 0, 0);
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            padding: 0.15rem 0.5rem;
            border-radius: 10px;
        } 

    .servicio1 {
        background: rgba(0, 183, 255, 0.96);
        color: rgb(255, 255, 255);
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        padding: 0.15rem 0.5rem;
        /*    border-radius: 0 0 10px 0; */
        border-radius: 12px;
    }
    .servicio2 {
        background: #ff3939f5;
        color: rgb(255, 255, 255);
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        padding: 0.15rem 0.5rem;
        /*    border-radius: 0 0 10px 0; */
        border-radius: 12px;
    }
    /* Filtro servicio (botones) */
    .servicio-toggle{
        display: inline-flex;
        overflow: hidden;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.15);
        background: rgba(0,0,0,0.18);
    }
    .servicio-btn{
        border: 0;
        padding: 0.6rem 1.2rem;
        background: transparent;
        color: rgba(255,255,255,0.9);
        font-weight: 700;
        letter-spacing: 0.02em;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
        line-height: 1;
    }
    .servicio-btn + .servicio-btn{
        border-left: 1px solid rgba(255,255,255,0.12);
    }
    .servicio-btn.active{
        background: rgba(66, 117, 119, 0.7);
        color: #3df9ff;
    }
        .second-title {
        background: linear-gradient(135deg, rgba(0, 204, 255, 0.20), rgba(3, 204, 194, 0.08));
        border: 1px solid rgba(0, 204, 255, 0.35);
        border-radius: 14px;
        padding: 1.25rem 1.75rem;
        margin: 0 10px 20px;
        gap: 1rem;
        align-items: center;
        font-size: 1.05rem;
        color: var(--pt-text);
        line-height: 1.5;
        box-shadow: 0 6px 22px rgba(0, 204, 255, 0.18);
    }
    .second-title i{color: rgb(0, 204, 255);font-size:1.7rem;flex-shrink:0;}
    .second-title strong{color: rgb(3, 204, 194); font-size: 1.12rem;}


</style>


<body class="d-flex flex-column min-vh-100">


    <?php
        $nav_back_url  = "../../sesiones.php";
        $nav_back_text = "Atras";
        $nav_base      = "../../";
        require_once '../../php/navbar.php';
    ?>


    <div class="container-fluid text-center px-4" >
       <div class="second-title ">
        <i class="bi bi-google-play fs-3"></i>
        <div>
            <strong>Plataformas</strong>
            <br>
            Elige la tienda en la que vas a suscribirte
        </div>
    </div>
    </nav><br>
    <!--<div class="container text-center" >
        <h3 class="display-4 fw-bold mb-3">Bienvenido a la sesion de plataformas</h3>
        <p class="lead mb-4">Elije la plataforma en donde vas a hacer tus compras</p>
    </div> --->



    <section>
        <div class="container mt-5" >
            <h1 class="text-center mb-3" >Tiendas Disponibles</h1>

            <!-- Botones para filtrar por servicio PlaceToPay -->
            <div class="d-flex justify-content-center mb-4">
                <div class="servicio-toggle" role="group" aria-label="Filtrar juegos por servicio" id="tipo-flujo">
                    <button type="button" class="servicio-btn active" data-filter="web">Web Checkout</button>
                    <button type="button" class="servicio-btn" data-filter="api">API Gateway</button>
                </div>
            </div>


            <div class="row" style="text-align: center" id="suscripciones-row">

                <!-- WEB CHECKOUT -->
                <div class="col-md-4 mb-4" data-servicio="web">
                    <div class="card h-100" id="tarjeta">

                        <img src="../../assets/implataformas/streaming/streaming-card.svg" class="card-img-top" alt="streaming">

                        <div class="card-body">
                            <div class="suscrip" id="tipo-suscripcion-mixta">Pago + Suscripción</div>
                            <div class="servicio1">Web Chekout</div>
                            <h5 class="card-title">Streamings</h5>
                            <p class="card-text">Adquiere planes</p>
                            <a href="streaming.php" class="btn btn-producto" >Productos</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4" data-servicio="web">
                    <div class="card h-100">
                        <div class="suscrip" id="tipo-suscripcion-recurrencia">Recurrencia</div>
                        <img src="../../assets/implataformas/ia/ia-card.svg" class="card-img-top" alt="ia">
                        <div class="card-body">
                            <div class="servicio1">Web Chekout</div>
                            <h5 class="card-title">IA's</h5>
                            <p class="card-text">Mejora tus planes</p>
                            <a href="ia.php" class="btn btn-producto">Productos</a>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 mb-4" data-servicio="web">
                    <div class="card h-100 ">
                        <div class="suscrip">Suscripción</div>
                        <img src="../../assets/implataformas/streaming/otras-streaming-card.svg" class="card-img-top" alt="otras streaming">
                        <div class="card-body">
                            <div class="servicio1">Web Chekout</div>
                            <h5 class="card-title">Otros Streamings</h5>
                            <p class="card-text">Adquiere planes</p>
                            <a href="otras_streaming.php" class="btn btn-producto">Productos</a>
                        </div>
                    </div>
                </div>

                <!-- API GATEWAY -->
                <div class="col-md-4 mb-4" data-servicio="api">
                    <div class="card h-100 ">
                        <div class="suscrip">Suscripción</div>
                        <img src="../../assets/implataformas/streaming/streaming-card.svg" class="card-img-top" alt="streamings gateway">
                        <div class="card-body">
                            <div class="servicio2">Api Gateway</div>
                            <h5 class="card-title">Streamings</h5>
                            <p class="card-text">Adquiere planes</p>
                            <a href="../plataformas/streaming_gateway.php" class="btn btn-producto">Productos</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4" data-servicio="api">
                    <div class="card h-100">
                        <div class="suscrip">Recurrencia</div>
                        <img src="../../assets/implataformas/ia/ia-card.svg" class="card-img-top" alt="ia gateway">
                        <div class="card-body">
                            <div class="servicio2">Api Gateway</div>
                            <h5 class="card-title">IA's</h5>
                            <p class="card-text">Mejora tus planes</p>
                            <a href="../plataformas/ia_gateway.php" class="btn btn-producto">Productos</a>
                        </div>
                    </div>
                </div>

            </div>
    </section>
    <script>
        (function () {
            const buttons = Array.from(document.querySelectorAll('.servicio-btn'));
            const cards = Array.from(document.querySelectorAll('[data-servicio]'));

            function applyFilter(filter) {
                cards.forEach(card => {
                    const svc = card.getAttribute('data-servicio');
                    card.style.display = (svc === filter) ? '' : 'none';
                });
            }

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    buttons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    applyFilter(btn.getAttribute('data-filter'));
                });
            });

            // Default: Web Checkout
            applyFilter('web');
        })();
    </script>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/validaciones.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="../../assets/js/components/driver-tours/tour-suscripciones.js"></script>
</body>
</html>