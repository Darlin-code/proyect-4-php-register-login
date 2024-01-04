<?php
    session_start();
    require_once("pdo.php");

    if (! isset($_SESSION["USER_AUTH"])) { ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Inicio</title>
            <link rel="stylesheet" href="../css/style-iac.css">
            <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        </head>
        <body>
            <div class="header">
                <div class="nav">
                    <a href="index.php">Inicio</a>
                    <a href="#">Sobre mí</a>
                    <a href="#">Contacto</a>
                </div>
                <div class="spacing">
                </div>
                <div class="user">
                    <a href="register.php">Registrarse</a>
                    <a href="login.php">Iniciar Sesión</a>
                </div>
            </div>
            <div class="container">
                <div class="no-login">
                    <h1>Bienvenido!</h1>
                    <span>Para acceder al contenido de la página, <a href="register.php">registrate</a>
                    o <a href="login.php">inicia sesión</a>.</span>
                </div>
            </div>
            <div class="footer">
                <span>©2024 -  Darlin Daniel Arias Méndez</span>
            </div>
        </html>
    <?php } else { ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Inicio</title>
            <link rel="stylesheet" href="../css/style-iac.css">
            <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        </head>
        <body>
            <div class="header">
                <div class="nav">
                    <a href="index.php">Inicio</a>
                    <a href="#">Sobre mí</a>
                    <a href="#">Contacto</a>
                </div>
                <div class="user">
                    <a href="logout.php">Cerrar Sesión</a>
                </div>
            </div>
            <div class="container">
                <div class="content">
                    <h1>Bienvenido!</h1>
                    <span>Actualmente no hay contenido.</span>
                </div>
            </div>
            <div class="footer">
                <span>©2024 -  Darlin Daniel Arias Méndez</span>
            </div>
        </body>
        </html>
    <?php }
?>
