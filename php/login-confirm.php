<?php
    session_start();
    require_once("pdo.php");

    if (isset($_POST["cancelar"])) {
        session_destroy();
        header("Location: index.php");
        return;
    }

    if (isset($_POST["password"]) && !empty($_POST["password"])) {
        $sql = "SELECT email FROM users WHERE password = :ps";
        $login = $pdo -> prepare($sql);
        $login -> execute(array(
            ':ps' => htmlentities($_POST["password"])
        ));
        $email = $login -> fetch(PDO::FETCH_ASSOC);

        if ($email["email"] === $_SESSION["pre-email"]) {
            $_SESSION["USER_AUTH"] = $email["email"];
            header("Location: index.php");
            return;
        } else {
            $_SESSION["error"] = "<p style='color: red;'>Error: Contraseña incorrecta.</p>";
            header("Location: login-confirm.php");
            return;
        }
    }

    if (! isset($_SESSION["USER_AUTH"])) { ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Iniciar sesión</title>
            <link rel="stylesheet" href="../css/style-lr.css">
        </head>
        <body>
            <div class="container">
                <form action="" method="POST">
                    <div class="form-content">
                        <div class="header-form">
                            <h1>Iniciar sesión</h1>
                            <span>Un último paso, <?= $_SESSION["pre-email"] . "."; ?></span>
                        </div>
                        <div class="body-form">
                            <div class="body-form-content">
                                <label for="password">
                                    Ingrese su contraseña: <input type="password" name="password" id="password" placeholder="Contraseña...">
                                </label>
                            </div>
                        </div>
                        <?php
                            if (isset($_SESSION["error"])) {
                                echo $_SESSION["error"];
                                unset($_SESSION["error"]);
                            }
                        ?>
                        <div class="buttons-form">
                            <button type="submit">Entrar</button>
                            <button type="submit" name="cancelar">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="footer">
                <span>©2024 -  Darlin Daniel Arias Méndez</span>
            </div>
        </body>
        </html>
    <?php } else { 
        header("Location: index.php");
        return;
    } 
?>