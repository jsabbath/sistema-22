<?php
require_once("sistema/cabecera.php");

if (!isset($_GET['idfact']) || !isset($_GET['fact']) || !isset($_GET['prove'])) {
    header("location:fv_listado.php");
} else {
    $idfactura = $_GET['idfact'];
    $factura = $_GET['fact'];
    $prove = $_GET['prove'];
    $_SESSION['fv_adjunto_idfact'] = $idfactura;
}

if ($_SESSION['fact_add'] == 0) {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<!--


Use search to find needed section.

=============================================================

|  1. $BODY                     |  Body                     |
|  2. $MAIN_NAVIGATION          |  Main navigation          |
|  3. $NAVBAR_ICON_BUTTONS      |  Navbar Icon Buttons      |
|  4. $MAIN_MENU                |  Main menu                |
|  5. $BOOTSTRAP_DATEPAGINATOR  |  Bootstrap Datepaginator  |
|  6. $JQUERY_MINICOLORS        |  jQuery Minicolors        |
|  7. $BOOTSTRAP_DATEPICKER     |  Bootstrap Datepicker     |
|  8. $BOOTSTRAP_TIMEPICKER     |  Bootstrap Timepicker     |

=============================================================

-->


<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Detalle de Factura <?php echo $factura; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

        <!-- Open Sans font from Google CDN -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&amp;subset=latin" rel="stylesheet" type="text/css">

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
    <body class="<?php echo $_SESSION['template'] ?> main-menu-animated main-navbar-fixed main-menu-fixed" style="overflow-y:hidden">

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
                    <li><a href="#">Factura de venta</a></li>
                    <li><a href="fv_detalle.php<?php echo"?idfact=$idfactura&fact=$factura&prove=$prove" ?>">Detalle</a></li>
                    <!--                    <li class="active"><a href="#">Dashboard</a></li>-->
                </ul>
                <div class="page-header">
                    <div class="pull-left col-sm-4">
                        <h1><span class="text-light-gray">Factura de venta / </span>Detalle</h1> 
                        <br>
                        <h1 id="numero_factura"><b>Nº <?php echo $factura; ?></b></h1>
                    </div>
                    <div class="pull-right col-sm-4">
                        <div class="col-xs-3">
                            <i id="panel_icono" class="fa fa-check-circle fa-5x" ></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <div id="panel_estado"></div>
                            <div id="panel_sub_mensaje">
                                <button id="boton_pago" type="button" class="btn btn-default btn-block btn-xs"><span id="txt_boton">IR AL PAGO</span></button>
                            </div>
                        </div>
                    </div>
                </div> <!-- / .page-header -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="row">

                                    <div class="col-sm-1">
                                        <div class="btn-toolbar ">
                                            <button type="button" onclick="volver()"class="btn btn-info btn-block">
                                                <span class="fa fa-arrow-left fa-fw"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="btn-toolbar ">
                                            <button type="button" id="btn_edit" onclick="editar();" class="btn btn-warning btn-block" <?php
                                            if ($_SESSION['fact_mod'] == 0) {
                                                echo "disabled";
                                            }
                                            ?>>
                                                <span class="fa fa-edit fa-fw"></span> 
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="btn-toolbar ">
                                            <button type="button" id="btn_save" onclick="guardar();" class="btn btn-success btn-block" <?php
                                            if ($_SESSION['fact_mod'] == 0) {
                                                echo "disabled";
                                            }
                                            ?>>
                                                <span class="fa fa-save fa-fw"></span> 
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="btn-toolbar ">
                                            <button type="button" id="btn_eli_fv" onclick="eliminarFactura();" class="btn btn-danger btn-block" <?php
                                            if ($_SESSION['fact_mod'] == 0) {
                                                echo "disabled";
                                            }
                                            ?>>
                                                <span class="fa fa-trash-o fa-fw"></span> 
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="btn-toolbar " >
                                            <form method="post" enctype="multipart/form-data" action="../conection/exportar.php" target="_blank">
                                                <input type="hidden" name="id_fact" id="id_fact" >
                                                <input type="hidden" name="num_fact" id="num_fact" value="<?php echo $factura; ?>">
                                                <button type="submit" class="btn btn-danger btn-block"<?php
                                                if ($_SESSION['fact_pdf'] == 0) {
                                                    echo "disabled";
                                                }
                                                ?>>   PDF 
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1">
                                        <div class="btn-toolbar " >
                                            <button type="button" onclick="cargarDataTable();" class="btn btn-default btn-block">
                                                <span class="fa  fa-refresh fa-fw "></span> 
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="btn-toolbar " >
                                            <button type="button" onclick="abrirAdjuntar();" class="btn btn-primary btn-block">
                                                <span class="fa  fa-upload fa-fw "></span> 
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <!-- cuerpo de la pagina -->
                                <input type="hidden" name="id_fact" id="id_fact" >
                                <div class="row">  
                                    <div class="col-lg-6  well">
                                        <div class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>Fecha Factura</label>
                                                <input type="date" name="fact_fecha_doc" class="form-control" id="fact_fecha_doc" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>Fecha Plazo</label>
                                                <input type="date" name="fact_fecha_plazo" class="form-control" id="fact_fecha_plazo" disabled>
                                            </div>
                                        </div>

                                        <div class="col-lg-12  col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Proveedor</label>
                                                <input type="text" name="fact_prove_nom" class="form-control" id="fact_prove_nom" disabled>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label>Neto</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1">$</span>
                                                    <input type="text" name="fact_neto" class="form-control" id="fact_neto" onblur="calcular();" onkeypress="mascara(this, cpf)"  onpaste="return false" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label>Iva(19%)</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1">$</span>
                                                    <input type="text" name="fact_iva" class="form-control" id="fact_iva" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label>Total</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1">$</span>
                                                    <input type="text" name="fact_total" class="form-control" id="fact_total" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12  col-sm-12 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon" ><b>Glosa</b></span>
                                                <textarea class="form-control" rows="4" name="fact_glosa" id="fact_glosa" disabled></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="table-primary">
                                            <table id="factura_archivos" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 6%;">tipo</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 40%;">Nombre</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 10%;">fecha</th>
                                                        <th  aria-controls="example" rowspan="1" colspan="1" style="width: 30%;">Usuario</th>
                                                        <th  aria-controls="example" rowspan="1" colspan="1" style="width: 10%;">Accion</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>  
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2" id="respuesta">

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
            require('modal/modal_facturamensaje.php');
            require('modal/modal_deletefactura.php');
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
            <script src="../js/paginas/fv_detalle.js" ></script>
            <script src="../js/carga_base.js" ></script>
            <script src="../js/dataTables.bootstrap.js" ></script>
            <script src="../js/dataTables.tableTools.js" ></script>

            <script type="text/javascript">
                init.push(function () {
                    //$(":file").filestyle({buttonName: "btn-primary", buttonText: "Seleccionar Archivo"});
                });
                function cargarFactura() {
                    extraerFactura(<?php echo $factura . ",'" . $prove . "'"; ?>);
                }
                function cargarArchivos() {
                    $('#factura_archivos').dataTable({
                        "ajax": "../conection/fv_detalle.php?idfact=<?php echo $idfactura; ?>",
                        "columns": [
                            {"data": "tipo"},
                            {"data": "archivo"},
                            {"data": "fecha"},
                            {"data": "usuario_nombre"},
                            {"data": "detalle"}
                        ],
                        "bLengthChange": false,
                        "bPaginate": false,
                        "bFilter": false,
                        "bInfo": false,
                        "bSort": false,
                        "language": {
                            "url": "../js/dataTable_es.txt"
                        }
                    });
                }

                window.LanderApp.start(init);
            </script>

    </body>
</html>