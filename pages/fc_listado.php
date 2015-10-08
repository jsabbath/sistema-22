<?php
require_once("sistema/cabecera.php");
$_SESSION['facturas'] = "";

if ($_SESSION['idfactdelete']) {
    $idfactdelete = $_SESSION['idfactdelete'];
    $_SESSION['idfactdelete'] = "";
}
if ($_SESSION['fact_add'] == 0) {
    header("location:index.php");
}
?>
<!DOCTYPE html>

<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Listado Facturas</title>
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
            #inputs-table td {
                vertical-align: middle;
            }

            .form-controls-demo > * {
                margin-bottom: 15px;
            }
            .dataTables_filter{
                text-align: right;
            }
            .dataTables_paginate{
                text-align: right;
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
                    <!--                    <li class="active"><a href="#">Dashboard</a></li>-->
                </ul>
                <div class="page-header">
                    <h1><span class="text-light-gray">Factura de compra / </span>Listado</h1>
                </div> <!-- / .page-header -->

                <div class="row">

                    <div class="col-sm-12">

                        <!-- 5. $CONTROLS ==================================================================================
                        
                                                        Controls
                        -->
                        <div class="panel">

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="" id="egresos_prove">

                                            <select id="combo_proveedor" class="form-control">
                                                <option></option>
                                                <?php $fun->getClieproveConEmpresa($_SESSION['empresa_def_id'], 1); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="" id="egresos_ano">
                                            <select id="listado_tipo" class="form-control">
                                                <option value="1">Pendientes</option>
                                                <option value="2">Pagados</option>
                                                <option value="0">Todos</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="btn-toolbar " >
                                            <button type="button" onclick="recargar();"  class="btn btn-success btn-block">
                                                <span class="fa  fa-download fa-fw "></span> 
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="btn-toolbar " >
                                            <button type="button" id="pago" class="btn btn-danger btn-block">
                                                <span class="fa fa-money fa-fw"></span> 
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.col-lg-12 -->
                                </div>
                                <hr class="panel-wide">
                                <div class="table-primary">
                                    <table id="tabla_facturas" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th style="width: 3%;"></th>
                                                <th style="width: 10%;">NºFactura</th>
                                                <th style="width: 33%;">Proveedor</th>
                                                <th style="width: 8%;">Total</th>
                                                <th style="width: 8%;">F.doc</th>
                                                <th style="width: 8%;">F.plazo</th>
                                                <th style="width: 15%;">Usuario reg</th>
                                                <th style="width: 5%;">estado</th>
                                                <th style="width: 5%;">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>  
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /5. $CONTROLS -->
                    </div>
                </div>
            </div> <!-- / #content-wrapper -->
            <div id="main-menu-bg"></div>
        </div> <!-- / #main-wrapper -->
        <?php
        require("modal/error_listaFacturas.php");
        require('modal/modal_facturamensaje.php');
        ?>
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
        <script src="../js/paginas/fc_listado.js" ></script>
        <script src="../js/carga_base.js" ></script>
        <script src="../js/dataTables.bootstrap.js" ></script>
        <script src="../js/dataTables.tableTools.js" ></script>
        <script type="text/javascript">
            init.push(function () {
                // Javascript code here
                $("#combo_proveedor").select2({
                    allowClear: true,
                    placeholder: "Seleccionar Proveedor"
                });
            });
            window.LanderApp.start(init);
        </script>

    </body>
</html>