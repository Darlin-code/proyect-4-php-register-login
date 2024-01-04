<?php
    session_start();
    require_once("pdo.php");

    if (isset($_POST["cancelar"])) {
        header("Location: index.php");
        return;
    }

    //Validación de los datos.
    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"])) {
        if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"])) {
            $_SESSION["error"] = "<p style='color: red;'>Error: Todos los campos son obligatorios.</p>";
            header("Location: register.php");
            return;
        } elseif ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error"] = "<p style='color: red;'>Error: El formato del correo es incorrecto.</p>";
            header("Location: register.php");
            return;
        }

        //Solicitando email que se intenta registrar.
        $sql_verify = "SELECT COUNT(*) exist FROM users WHERE email = :em";
        $verify = $pdo -> prepare($sql_verify);
        $verify -> execute(array(
            'em' => htmlentities($_POST["email"])
        ));
        $exist = $verify -> fetch(PDO::FETCH_ASSOC);
        
        //Verificar si el email existe, si no, contunua.
        if (! $exist["exist"] < 1) {
            $_SESSION["error"] = "<p style='color: red;'>Error: El correo ya existe.</p>";
            header("Location: register.php");
            return;
        } else {
            $sql = "INSERT INTO users (name, email, password) VALUES (:na, :em, :ps);";
            $register = $pdo -> prepare($sql);
            $register -> execute(array(
                ':na' => htmlentities($_POST["name"]),
                ':em' => htmlentities($_POST["email"]),
                ':ps' => htmlentities($_POST["password"])
            ));
            header("Location: login.php");
            return;
        }
    }

    if (! isset($_SESSION["USER_AUTH"])) { ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registrarse</title>
            <link rel="stylesheet" href="../css/style-lr.css">
        </head>
        <body>
            <div class="container">
                <form action="" method="POST">
                    <div class="form-content">
                        <div class="header-form">
                            <h1>Registrarse</h1>
                            <span>Ingrese los datos solicitados para registrarse.</span>
                        </div>
                        <div class="body-form">
                            <div class="body-form-content">
                                <label for="name">
                                    Ingrese su nombre: <input type="text" name="name" id="name" placeholder="Nombre...">
                                </label>
                                <label for="email">
                                    Ingrese su correo: <input type="email" name="email" id="email" placeholder="Correo...">
                                </label>
                                <label for="password">
                                    Ingrese su contraseña: <input type="password" name="password" id="password" placeholder="Contraseña...">
                                </label>
                                <?php
                                    if (isset($_SESSION["error"])) {
                                        echo $_SESSION["error"];
                                        unset($_SESSION["error"]);
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="buttons-form">
                            <button type="submit">Registrarme</button>
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