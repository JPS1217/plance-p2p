<?php
    session_start();


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deportivos</title>
        <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <!-- Tu CSS -->
    <link rel="stylesheet" href="../../assets/css/estilos.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/estilos.css'); ?>">

    <?php $theme_seccion = 'textiles'; require_once dirname(__DIR__, 2) . '/php/theme.php'; ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet"
        href="../../assets/css/components/driver-theme.css?v=<?php echo filemtime(dirname(__DIR__, 2) . '/assets/css/components/driver-theme.css'); ?>">
</head>


<style>
    body {
        /* background-image: url(../assets/images/bg22.jpg); */
        background-color: var(--pt-bg-base);
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        background-size: cover;
        font-family: 'Barlow', sans-serif;
    }
    .card {
        /*background: linear-gradient( rgba(146, 50, 255, 0.8) 0%, hsla(281, 100%, 33%, 0.81)); */
        background: var(--pt-bg-card2);
        background-size: cover;
        color: var(--pt-text);
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        align-items: center

    }
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(255, 174, 0, 0.5);
    }
    .card-img-top {
        border-radius: 15px 15px 0 0;
        height: 200px;
        width: 100%;
        object-fit: cover;
    }
    .btn-producto{
        background-color: rgb(232, 97, 250);
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
        color:  #ffffff;
    }
    .back:hover {
        background: #ff6811f5;
        transform: translateY(-1px);
        box-shadow: 0 5px 10px rgba(255, 94, 0, 0.5);

    }
    /*necesito centrar el mensajito naranaja "pago basico" en la parte superior de cada card, y que quede fijo ahi, sin importar el tamaño de la imagen o el contenido de la card. Tambien quiero que tenga un fondo naranja con letras negras, y que se vea como una etiqueta superpuesta a la imagen, pero sin afectar el diseño responsivo de las cards. */
    .linkp {    
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        background-color: hsl(295, 100%, 66%);
        color: rgb(0, 0, 0);
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        padding: 0.15rem 0.5rem;
        /*    border-radius: 0 0 10px 0; */
        border-radius: 12px;
    }








    .servicio1{
        background: rgb(182, 92, 255);
        color: rgb(255, 255, 255);
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        padding: 0.15rem 0.5rem;
        /*    border-radius: 0 0 10px 0; */
        border-radius: 12px;
    }
    .servicio2{
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
        background: rgba(99, 22, 82, 0.7);
        color: #f36eff;
    }
    .second-title {
        background: linear-gradient(135deg, rgba(182, 92, 255, 0.20), rgba(232, 97, 250, 0.08));
        border: 1px solid rgba(182, 92, 255, 0.35);
        border-radius: 14px;
        padding: 1.25rem 1.75rem;
        margin: 0 10px 20px;
        gap: 1rem;
        align-items: center;
        font-size: 1.05rem;
        color: var(--pt-text);
        line-height: 1.5;
        box-shadow: 0 6px 22px rgba(182, 92, 255, 0.18);
    }
    .second-title i{color: rgb(217, 93, 255);font-size:1.7rem;flex-shrink:0;}
    .second-title strong{color: rgb(217, 93, 255); font-size: 1.12rem;}
    
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
        <i class="fa-solid fa-calendar-check fs-3"></i>
        <div>
            <strong>Bienvenido a la sesion de Textiles</strong>
            <br>
            Elige alguna tienda y adquiere tu camiseta de tu equipo favorito
        </div>
    </div>



    <section>
        <div class="container mt-5" >
            <h1 class="text-center mb-3">Textiles</h1>

            <!-- Canal de pago disponible -->
            <div class="d-flex justify-content-center mb-4">
                <div class="servicio-toggle" role="group" aria-label="Canal de pago" id="tipo-flujo">
                    <button type="button" class="servicio-btn active" data-filter="web">API Link de pagos</button>
                </div>
            </div>

            <div class="row" style="text-align: center;" id="games-row">

                <div class="col-md-4 mb-4" data-servicio="web">
                    <div class="card h-100" id="tarjeta">

                        <img src="../../assets/imtextil/premier-league-card.svg" class="card-img-top" alt="Premier League" style="height: 100px; width: 100%; object-fit: cover;"><div class="linkp" id="tipo-link-pagos">API Link de pagos</div>

                        <div class="card-body">
                            <div class="servicio1">API Link de pagos</div>
                            <h5 class="card-title">Premier League</h5>
                            <p class="card-text">Compra Equipaciones de tus equipos ingleses favoritos</p>
                            <a href="../textil/pl.php" class="btn btn-producto" styles=""; >Productos</a>
                        </div>
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
    <script src="../../assets/js/components/driver-tours/tour-textiles.js"></script>
</body>
</html>