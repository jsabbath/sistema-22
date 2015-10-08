<?php
require_once("sistema/cabecera.php");

if (!isset($_GET['corre_in'])) {
    header("location:fv_ingresos.php");
} else {
    $corre_in = $_GET['corre_in'];
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
        <title>Detalle del Ingreso <?php echo $corre_eg; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

        <!-- Open Sans font from Google CDN -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&amp;subset=latin" rel="stylesheet" type="text/css">
        <script src="../js/carga_base.js" ></script>

        <!-- LanderApp's stylesheets -->
        <link href="../assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/landerapp.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">
        <style>
            #radio_plazo{
                margin-top: 4%;
            }
            #numero_factura{
                margin-top: 3%;
                margin-bottom: -7%;
                font-size: 20pt;
            }
            #panel_estado{
                font-size: 20pt;
            }
        </style>
        <!--[if lt IE 9]>
                <script src="assets/javascripts/ie.min.js"></script>
        <![endif]-->

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

            <?php
            require 'sistema/menu.php';
            ?> <!-- / #main-menu -->
            <!-- /4. $MAIN_MENU -->


            <div id="content-wrapper">
                <ul class="breadcrumb breadcrumb-page">
                    <div class="breadcrumb-label text-light-gray" >Tu estas aqui: </div>
                    <li><a href="#">Ingreso de venta</a></li>
                    <li><a href="fv_ingreso_detalle.php<?php echo"?idfact=$idfactura&fact=$factura&prove=$prove" ?>">Detalle</a></li>
                    <!--                    <li class="active"><a href="#">Dashboard</a></li>-->
                </ul>
                <div class="page-header">
                    <div class="pull-left col-sm-4">
                        <h1><span class="text-light-gray">Ingreso de venta / </span>Detalle</h1> 
                        <br>
                        <h1 id="numero_factura"><b>Nº <?php echo $corre_in; ?></b></h1>
                    </div>
                </div> <!-- / .page-header -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="row">

                                    <div class="col-sm-1">
                                        <div class="btn-toolbar ">
                                            <button type="button" onclick="volver()" class="btn btn-info btn-block">
                                                <span class="fa fa-arrow-left fa-fw"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-1 col-sm-1 col-xs-3">
                             <div class="btn-toolbar ">
                                 <button type="button" onclick="" class="btn btn-warning btn-block" <?php
                                    if ($_SESSION['fact_mod'] == 0) {
                                        echo "disabled";
                                    }
                                    ?>>
                                     <span class="fa fa-edit fa-fw"></span> 
                                 </button>
                             </div>
                         </div>
                         <div class="col-lg-1 col-sm-1 col-xs-3">
                             <div class="btn-toolbar ">
                                 <button type="button" onclick="" class="btn btn-success btn-block" <?php
                                    if ($_SESSION['fact_mod'] == 0) {
                                        echo "disabled";
                                    }
                                    ?>>
                                     <span class="fa fa-save fa-fw"></span> 
                                 </button>
                             </div>
                         </div>
                         <div class="col-lg-1 col-sm-1 col-xs-3">
                             <div class="btn-toolbar ">
                                 <button type="button" onclick="" class="btn btn-danger btn-block" <?php
                                    if ($_SESSION['fact_mod'] == 0) {
                                        echo "disabled";
                                    }
                                    ?>>
                                     <span class="fa fa-trash-o fa-fw"></span> 
                                 </button>
                             </div>
                         </div> -->

                                    <div class="col-lg-1 col-sm-1 col-xs-3">
                                        <div class="btn-toolbar " >
                                            <button type="button" onclick="" class="btn btn-danger btn-block"<?php
                                            if ($_SESSION['fact_pdf'] == 0) {
                                                echo "disabled";
                                            }
                                            ?>>   PDF 
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-sm-1"></div>
                                    <div class="col-lg-1 col-sm-1"></div>
                                    <div class="col-lg-1 col-sm-1"></div>
                                    <div class="col-lg-1 col-sm-1"></div>
                                    <div class="col-lg-1 col-sm-1"></div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-6"> <!-- panel izquierda -->
                                    <div class="col-lg-12  well">
                                        <div class="row">  
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group">
                                                    <label>Fecha Pago</label>
                                                    <input type="date" name="ingreso_fecha" class="form-control" id="ingreso_fecha" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-xs-8">
                                                <div class="form-group">
                                                    <label>Documento Pago</label>
                                                    <input type="text" name="ingreso_documento" class="form-control" id="ingreso_documento" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">  
                                            <div class="col-lg-6 col-sm-4 col-xs-4">
                                                <div class="form-group" id="tipo_grupo">
                                                    <label for="ingreso_tipo_pago">Tipo Pago</label><br>
                                                    <select id="ingreso_tipo_pago" class="form-control" disabled>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-4 col-xs-4">
                                                <div class="form-group">
                                                    <label>Total</label>
                                                    <input type="text" name="ingreso_total_pago" class="form-control" id="ingreso_total_pago" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">  
                                            <div class="col-lg-10 col-sm-8 col-xs-8">
                                                <div class="form-group">
                                                    <label>Proveedor Nombre</label>
                                                    <input type="text" name="ingreso_prove_nombre" class="form-control" id="ingreso_prove_nombre" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">  
                                            <br>
                                            <div class="col-lg-12  col-sm-12 col-xs-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon" ><b>Glosa</b></span>
                                                    <textarea class="form-control" rows="3" name="ingreso_glosa" id="ingreso_glosa" readonly></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <div class="row"> 
                                                        <div class="col-lg-6" >
                                                            <b id="subtitulo">Adjuntos</b>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-1">
                                                            <div class="btn-toolbar " >
                                                                <button type="button" onclick="cargarDataTableIngresoDetalle();" class="btn btn-default btn-block">
                                                                    <span class="fa  fa-refresh fa-fw "></span> 
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-1">
                                                            <div class="btn-toolbar " >
                                                                <button type="button" onclick="abrirAdjuntar();" class="btn btn-primary btn-block">
                                                                    <span class="fa  fa-upload fa-fw "></span> 
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-primary">
                                                        <table id="ingreso_adjuntos" class="table table-striped table-bordered dataTable no-footer" cellspacin="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 6%;">tipo</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 40%;">Nombre</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 10%;">fecha</th>
                                                                    <th  aria-controls="example" rowspan="1" colspan="1" style="width: 10%;">Accion</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>  
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6"> <!-- panel derecha -->
                                    <div class="col-lg-12">
                                        <div class="row"> 
                                            <div class="col-lg-6" >
                                                <b id="subtitulo">Facturas</b>
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <table id="ingreso_facturas" class="table table-striped table-bordered dataTable no-footer" cellspacin="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 6%;">Abrir</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 40%;">NºFactura</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 10%;">Neto</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 10%;">Iva</th>
                                                        <th  aria-controls="example" rowspan="1" colspan="1" style="width: 10%;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>  
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- / #content-wrapper -->
                <div id="main-menu-bg"></div>
            </div> <!-- / #main-wrapper -->

            <?php
            require('modal/modal_addAdjunto.php');
            require('modal/modal_showAdjunto.php');
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
            <script src="../assets/javascripts/bootstrap-datepicker.min.js" ></script>
            <script src="../js/paginas/fv_ingreso_detalle.js"></script>
            <script src="../js/carga_base.js" ></script>
            <script src="../js/dataTables.bootstrap.js" ></script>
            <script src="../js/dataTables.tableTools.js" ></script>

            <script type="text/javascript">
                init.push(function () {
                });
                $(document).ready(function () {
                    //cargarArchivos();
                    extraerIngreso("<?php echo $corre_in; ?>");
                    //$("#example").popover();
                });
                window.LanderApp.start(init);
            </script>

    </body>
</html>