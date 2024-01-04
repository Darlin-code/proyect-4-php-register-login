<?php
    session_start();
    require_once("pdo.php");

    if (isset($_POST["cancelar"])) {
        header("Location: index.php");
        return;
    }

    if (isset($_POST["email"]) && !empty($_POST["email"])) {
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            //Solicitando datos
            $sql = "SELECT * FROM users WHERE email = :em";
            $query = $pdo -> prepare($sql);
            $query -> execute(array(
                ':em' => htmlentities($_POST["email"])
            ));
            $email = $query -> fetch(PDO::FETCH_ASSOC);

            //Verificando que el email existe.
            $sql_count = "SELECT COUNT(*) total FROM users WHERE email = :em";
            $query_count = $pdo -> prepare($sql_count);
            $query_count -> execute(array(
                ':em' => htmlentities($_POST["email"])
            ));
            $total = $query_count -> fetch(PDO::FETCH_ASSOC);

            if ($total["total"] < 1) {
                $_SESSION["error"] = "<p style='color: red;'>Error: El correo no existe.</p>";
                header("Location: login.php");
                return; 
            } else {
                $_SESSION["pre-email"] = htmlentities($email["email"]);
                header("Location: login-confirm.php");
                return;
            }
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
                            <span>Ingrese los datos solicitados para iniciar sesión.</span>
                        </div>
                        <div class="body-form">
                            <div class="body-form-content">
                                <label for="email">
                                    Ingrese su correo: <input type="email" name="email" id="email" placeholder="Correo...">
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
                            <button type="submit">Continuar</button>
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