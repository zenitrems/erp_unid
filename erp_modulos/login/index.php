<?php
require_once "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?php echo constant("URL") ?>/vendor/components/jquery/jquery.min.js"></script>
</head>

<body>
    <section>
        <div class="container">
            <form id="login-form">
                <h1>Iniciar Sesión</h1>
                <div class="textbox">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <input type="text" name="correo" placeholder="Correo" id="correo">
                </div>
                <div class="textbox">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                    <input type="password" name="password" placeholder="Password" id="password">
                </div>
                <input class="btn" type="button" value="ENTRAR" id="btn-login">
            </form>
        </div>
    </section>
    <script src="<?php echo constant("URL") ?>/erp_modulos/login/main.js"></script>
</body>

</html>