<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/

session_start();

require("./cfg/mysql.php");
require("./inc/functions.inc.php");
require("./inc/head.inc.php");

$config = include("./cfg/config.php");

if (!isset($_SESSION["username"])) {
    echo '<meta http-equiv="refresh" content="0; URL=login.php"> ';
}

date_default_timezone_set("Europe/Berlin");

$includeDir = "." . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR;
$includeDefault = $includeDir . "home.php";
if (isset($_GET["ajaxpage"]) && !empty($_GET["ajaxpage"])) {
    $_GET["ajaxpage"] = str_replace("\0", "", $_GET["ajaxpage"]);
    $includeFile = basename(realpath($includeDir . $_GET["ajaxpage"] . ".php"));
    $includePath = $includeDir . $includeFile;

    if (!empty($includeFile) && file_exists($includePath)) {
        include($includePath);
    } else {
        include($includeDefault);
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $config["name"]; ?> - Intern</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>

    <script src="dist/js/toastr.js"></script>
    <link href="dist/css/toastr.css" rel="stylesheet"/>

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $config["favicon"]; ?>">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light dark-mode">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
		
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="?s=logout" class="btn bg-gradient-danger">Ausloggen</a>
            </li>
        </ul>
    </nav>

    <?php include("./inc/sidebar.inc.php"); ?>

    <div class="dark-mode content-wrapper">
        <?php include("./inc/header.inc.php"); ?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <?php
                    if (isset($_GET["s"]) && !empty($_GET["s"])) {
                        $_GET["s"] = str_replace("\0", "", $_GET["s"]);
                        $includeFile = basename(realpath($includeDir . $_GET["s"] . ".php"));
                        $includePath = $includeDir . $includeFile;

                        if (!empty($includeFile) && file_exists($includePath)) {
                            include($includePath);
                        } else {
                            include($includeDefault);
                        }
                    } else {
                        include($includeDefault);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php include("./inc/footer.inc.php"); ?>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
</div>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>
