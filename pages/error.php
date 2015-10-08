<?php
require_once("sistema/cabecera.php");
?>
<!DOCTYPE html>

<!--[if gt IE 9]><!--> 
<!--<html class="gt-ie8 gt-ie9 not-ie">--> 
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Error</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <!-- Open Sans font from Google CDN -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&amp;subset=latin" rel="stylesheet" type="text/css">
    <!-- LanderApp's stylesheets -->
    <link href="../assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/stylesheets/landerapp.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
            <script src="assets/javascripts/ie.min.js"></script>
    <![endif]-->
</head>

<body class="<?php echo $_SESSION['template'] ?> main-menu-animated main-navbar-fixed main-menu-fixed">

    <script>var init = [];
    </script>

    <div id="main-wrapper">

        <!-- 2. $MAIN_NAVIGATION ===========================================================================
        
                Main navigation
        -->
        <?php
        require 'sistema/navbar.php';
        require 'sistema/menu.php';
        ?> <!-- / #main-menu -->
        <!-- /4. $MAIN_MENU -->

        <div id="content-wrapper">

            <div class="row">

                <div class="row">
                    <div class="col-lg-12">
                    <h2 class="page-header text-light-gray"><!--<i class="fa fa-frown-o fa-2x"></i> --> &nbsp;Error al procesar informacion ...</h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2" align="center">
                        <!-- /.panel-heading -->
                        <p>Se han tomado los datos de sus session y el evento que genero el error para su posterior revision.</p>
                        <div id="CuentaAtras" class="alert alert-danger">

                        </div>
                        <!-- .panel-body -->
                        <h2><p id="CuentaAtras"><p></h2>
                    </div>
                </div>
                <!-- /.row -->

            </div>

            <hr class="no-grid-gutter-h grid-gutter-margin-b no-margin-t">

        </div> <!-- / #content-wrapper -->
        <div id="main-menu-bg"></div>
    </div> <!-- / #main-wrapper -->

    <!-- Get jQuery from Google CDN -->
    <!--[if !IE]> -->
    <script type="text/javascript"> window.jQuery || document.write('<script src="../assets/javascripts/jquery.min.js">' + "<" + "/script>");</script>
    <!-- <![endif]-->

    <!-- LanderApp's javascripts -->
    <script src="../js/carga_base.js"></script>
    <script src="../js/paginas/error.js"></script>
    <script src="../assets/javascripts/bootstrap.min.js"></script>
    <script src="../assets/javascripts/landerapp.min.js"></script>

    <script type="text/javascript">
        init.push(function () {



        });
        window.LanderApp.start(init);
        /* Determinamos el tiempo total en segundos */
        var totalTiempo = 15;
        /* Determinamos la url donde redireccionar */
        var url = "index.php";
        function updateReloj()
        {
            document.getElementById('CuentaAtras').innerHTML = "Redireccionando al inicio en <b>" + totalTiempo + "</b> segundos <br> o puedes volver con el siguiente <a href='index.php' class='alert-link'>Link</a>";

            if (totalTiempo === 0)
            {
                window.location = url;
            } else {
                /* Restamos un segundo al tiempo restante */
                totalTiempo -= 1;
                /* Ejecutamos nuevamente la función al pasar 1000 milisegundos (1 segundo) */
                setTimeout("updateReloj()", 1000);
            }
        }
        window.onload = updateReloj;
    </script>

</body>
</html>