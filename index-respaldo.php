<?php
    session_start();

    if(isset($_SESSION['usuario'])){
        header("Location: home.php");
        die();
    }
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placetopay</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">


    <link rel="stylesheet" href="assets/css/estilos.css?v=<?php echo filemtime(__DIR__ . '/assets/css/estilos.css'); ?>">
</head>
<body>
    <main>

        <div class="auth-page">
            <div class="auth-shell">

                <!-- Panel izquierdo: marca / contexto -->
                <div class="auth-brand">
                    <img src="assets/icons/icono.png" alt="Logo de Plance">
                    <h1>Bienvenido a P2P</h1>
                    <p>Plataforma Demo sobre PlacetoPay, informacion que necesitas saber de nuestro panel.</p>

                    <ul class="auth-brand-list">
                        <li><i class="fa-solid fa-check"></i>Servicios e Integraciones</li>
                        <li><i class="fa-solid fa-check"></i>Registro de transacciones</li>
                        <li><i class="fa-solid fa-check"></i>Seguridad y Almacenamiento</li>
                    </ul>

                    <a href="welcome.php" class="auth-brand-back"><i class="bi bi-arrow-left"></i> Volver a la página de bienvenida</a>
                </div>

                <!-- Panel derecho: formularios -->
                <div class="auth-panel">
                    <div class="auth-tabs">
                        <button type="button" class="auth-tab is-active" id="tab-login" data-target="form-login">Iniciar sesión</button>
                        <button type="button" class="auth-tab" id="tab-register" data-target="form-register">Registrarse</button>
                    </div>

                    <div class="auth-forms">

                        <!-- Login -->
                        <form action="php/login_user_be.php" method="POST" class="auth-form is-active" id="form-login">
                            <div class="auth-field">
                                <label for="loginCorreo">Correo</label>
                                <input type="email" id="loginCorreo" placeholder="tucorreo@ejemplo.com" name="correo" required autocomplete="email">
                            </div>

                            <div class="auth-field auth-field-pass">
                                <label for="loginpassword">Contraseña</label>
                                <input type="password" id="loginpassword" name="contraseña" required placeholder="Tu contraseña" autocomplete="current-password">
                                <i id="toggleIconLogin" class="bi bi-eye toggle-eye"></i>
                            </div>

                            <button type="submit" class="auth-submit">Entrar</button>

                            <div class="auth-divider">
                                <span></span>
                                <span class="auth-divider-text">o</span>
                                <span></span>
                            </div>

                            <a href="php/entrar_invitado.php" class="auth-guest"><i class="bi bi-person"></i> Continuar como invitado</a>
                        </form>

                        <!-- Registro -->
                        <form action="php/register_user_be.php" method="POST" class="auth-form" id="form-register">
                            <div class="auth-field">
                                <label for="regId">Identificación</label>
                                <input type="text" id="regId" placeholder="Número de identificación" name="id" pattern="[0-9]+" required>
                            </div>

                            <div class="auth-field">
                                <label for="regNombre">Nombre y apellido</label>
                                <input type="text" id="regNombre" placeholder="Nombre y apellido" name="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" required>
                            </div>

                            <div class="auth-field">
                                <label for="regCorreo">Correo</label>
                                <input type="email" id="regCorreo" placeholder="tucorreo@ejemplo.com" name="correo" required autocomplete="email">
                            </div>

                            <div class="auth-field">
                                <label for="regUsuario">Usuario</label>
                                <input type="text" id="regUsuario" placeholder="Nombre de usuario" name="usuario" required autocomplete="username">
                            </div>

                            <div class="auth-field auth-field-pass">
                                <label for="registerPassword">Contraseña</label>
                                <input type="password" id="registerPassword" name="contraseña" required placeholder="Crea una contraseña" autocomplete="new-password">
                                <i id="toggleIcon" class="bi bi-eye toggle-eye"></i>
                            </div>

                            <div class="auth-hint">
                                <i class="bi bi-exclamation-circle"></i> Sugerencia de seguridad
                            </div>
                            <p class="auth-hint-text">Tu contraseña debe tener mínimo 8 caracteres, mayúscula, número y símbolo.</p>

                            <div class="auth-strength-track">
                                <div id="strengthLevel" class="auth-strength-fill"></div>
                            </div>
                            <small id="strengthText" class="auth-strength-text"></small>

                            <button type="submit" class="auth-submit">Registrarse</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>

    </main>


</body>
<script src="assets/js/auth-tabs.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/validaciones.js"></script>
</html>
