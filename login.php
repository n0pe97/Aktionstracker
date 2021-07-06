<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/

session_start();

require("./cfg/mysql.php");
require("./inc/functions.inc.php");
$config = include("./cfg/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $config["name"]; ?> - Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
</head>
<body class="hold-transition login-page dark-mode">
<div class="login-box">
    <div class="login-logo">
        <img src="<?php echo $config["logo"]; ?>"
             style="margin: 0 5px 6px 0; width: 60px; height: 60px;"><?php echo $config["name"]; ?>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Bitte logge dich mit deinen Daten ein!</p>

            <form method="POST">
                <?php
                if (isset($_POST["submit"])) {
                    checkLogin($_POST["username"], $_POST["password"]);
                }
                ?>
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Benutzername">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Passwort">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Einloggen</button>
                    </div>

                </div>
                <br>
                <p style="color: white; text-align: center;">Coded with <i style="color: red;"
                                                                             class="fas fa-heart"></i> by <a
                            style="color: #349eeb;" href="https://forum.vio-v.com/index.php?user/10095-n0pe/"
                            target="_blank">n0pe</a></p>
            </form>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
