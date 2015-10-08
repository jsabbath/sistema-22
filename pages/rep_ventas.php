<?php
require_once("sistema/cabecera.php");

if ($_SESSION['reporte'] == 0) {
    header("location:index.php");
}
?>
<!DOCTYPE html>

<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Historial y seguimiento</title>
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

        <style>
            .DT-lf-right{
                float: left;
            }
            #inputs-table td {
                vertical-align: middle;
            }
            .form-controls-demo > * {
                margin-bottom: 15px;
            }
        </style>

    </head>


    <!-- 1. $BODY ======================================================================================
            
            Body
    
            Classes:
            * 'theme-{THEME NAME}'
            * 'right-to-left'      - Sets text direction to right-to-left
            * 'main-menu-right'    - Places the main menu on the right side
            * 'no-main-menu'       - Hides the main menu
            * 'main-navbar-fixed'  - Fixes the main navigation
            * 'main-menu-fixed'    - Fixes the main menu
            * 'main-menu-animated' - Animate main menu
    -->
    <body class="<?php echo $_SESSION['template'] ?> main-menu-animated main-navbar-fixed main-menu-fixed">

        <script>var init = [];</script>

        <div id="main-wrapper">


            <!-- 2. $MAIN_NAVIGATION ===========================================================================
            
                    Main navigation
            -->
            <?php
            require 'sistema/navbar.php';
            ?> 
            <!-- / #main-navbar -->
            <!-- /2. $END_MAIN_NAVIGATION -->

            <!-- 4. $MAIN_MENU =================================================================================
            
                            Main menu
                            
                            Notes:
                            * to make the menu item active, add a class 'active' to the <li>
                              example: <li class="active">...</li>
                            * multilevel submenu example:
                                    <li class="mm-dropdown">
                                      <a href="#"><span class="mm-text">Submenu item text 1</span></a>
                                      <ul>
                                            <li>...</li>
                                            <li class="mm-dropdown">
                                              <a href="#"><span class="mm-text">Submenu item text 2</span></a>
                                              <ul>
                                                    <li>...</li>
                                                    ...
                                              </ul>
                                            </li>
                                            ...
                                      </ul>
                                    </li>
            -->
            <?php
            require 'sistema/menu.php';
            ?>
            <!-- / #main-menu -->
            <!-- /4. $MAIN_MENU -->


            <div id="content-wrapper">
                <ul class="breadcrumb breadcrumb-page">
                    <div class="breadcrumb-label text-light-gray" >Tu estas aqui: </div>
                    <li><a href="#">Factura de compra</a></li>
                    <li><a href="fc_listado.php">Listado</a></li>
<!--                    <div class="breadcrumb-label text-bold pull-right" ><?php echo $_SESSION['empresa_def_nom']; ?></div>-->
                    <!--                    <li class="active"><a href="#">Dashboard</a></li>-->
                </ul>
                <div class="page-header">

                    <div class="row">
                        <!-- Page header, center on small screens -->
                        <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><span class="text-light-gray">Reporte / </span>Historial</h1>

                        <div class="col-sm-8">
                            <div class="row">
                                <div class=" col-sm-8"></div>
                                <div class=" col-sm-2">

                                </div>
                                <div class=" col-sm-2">
                                    <button type="submit" class="btn btn-danger btn-block">PDF</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- / .page-header -->

                <div class="row">
                    
                </div>
            </div> <!-- / #content-wrapper -->
            <div id="main-menu-bg"></div>
        </div> <!-- / #main-wrapper -->

        <!-- Get jQuery from Google CDN -->
        <!--[if !IE]> -->
        <script type="text/javascript"> window.jQuery || document.write('<script src="../assets/javascripts/jquery.min.js">' + "<" + "/script>");</script>
        <!-- <![endif]-->
        <!--[if lte IE 9]>
                <script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
        <![endif]-->


        <!-- LanderApp's javascripts -->
        <script src="../assets/javascripts/bootstrap.min.js"></script>
        <script src="../assets/javascripts/landerapp.min.js"></script>
        <script src="../js/paginas/rep_historial.js" ></script>
        <script src="../assets/javascripts/bootstrap-datepicker.min.js" ></script>
        <script src="../assets/locales/bootstrap-datepicker.es.min.js" ></script>
        <script src="../js/carga_base.js" ></script>
        <script type="text/javascript">
            init.push(function () {
                // Javascript code here
                $('#fecha').datepicker({
                    format: "dd/mm/yyyy",
                    language: "es",
                    autoclose: true,
                    orientation: "top left"
                });
            });
            window.LanderApp.start(init);
        </script>

    </body>
</html>