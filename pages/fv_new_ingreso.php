<?php
require_once("sistema/cabecera.php");
if (!$_SESSION['facturasIngreso']) {
    header("location:fv_listado.php");
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
        <title>Registro de nuevo ingreso</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

        <!-- Open Sans font from Google CDN -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&amp;subset=latin" rel="stylesheet" type="text/css">

        <!-- LanderApp's stylesheets -->
        <link href="../assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/landerapp.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">

    </head>

    <body class="<?php echo $_SESSION['template'] ?> main-menu-animated main-navbar-fixed main-menu-fixed" >

        <script>var init = [];</script>

        <div id="main-wrapper">

            <?php
            require 'sistema/navbar.php';
            require 'sistema/menu.php';
            ?> 

            <div id="content-wrapper">
                <div class="page-header">
                    <div class="pull-left col-sm-4">
                        <h1><span class="text-light-gray">Factura de venta / </span>Nuevo Ingreso</h1> 
                        <br>
                        <h1 id="numero_factura"><b>Nº <b id="correlativo"></b></b></h1>
                    </div>
                </div> <!-- / .page-header -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel panel-primary">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="input-group form-group">
                                            <span class="input-group-addon" ><b>Fecha</b></span>
                                            <input type="date" name="fact_fecha" class="form-control" value="<?php echo date("Y-m-d"); ?>" id="fact_fecha_ingreso" readonly="yes">
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="input-group form-group">
                                            <span class="input-group-addon" ><b>Tipo Pago</b></span>
                                            <select id="combo_pago_ingreso" class="form-control" >
                                                <?php $fun->getTipoPago(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 " id="ingreso_numero_documento">
                                        <div class="input-group form-group" id="ndocs_grupo">
                                            <span class="input-group-addon"><b>Nº de documento</b></span>
                                            <input type="text" class="form-control" name="ingreso_docu" id="ingreso_docu" maxlength="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8 ">
                                        <div class="input-group form-group">
                                            <span class="input-group-addon" ><b>Proveedor</b></span>
                                            <input type="hidden" class="form-control" name="ingreso_proveedor_id" id="ingreso_proveedor_id" readonly="" value="<?php echo $_SESSION['prove_id']; ?>">
                                            <input type="text" class="form-control" name="ingreso_proveedor_id" id="ingreso_proveedor" readonly="" value="<?php echo $_SESSION['prove_nombre']; ?>">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group form-group">
                                            <span class="input-group-addon" ><b>Glosa</b></span>
                                            <input type="text" class="form-control" name="ingreso_glosa" id="ingreso_glosa" maxlength="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-primary">
                                            <table id="tabla_facturas_ingreso" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 5%;"></th>
                                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 45%;">Detalle</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 20%;">Valor</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 10%; font: red;">Eliminar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>  
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon"><b>agregar factura</b></span>
                                            <input type="text" class="form-control" name="ingreso_add_factura" id="ingreso_add_factura" maxlength="45">
                                            <span class="input-group-btn">
                                                <button class="btn btn-success" type="button" onclick="agregarFactura($('#ingreso_add_factura').val());"> <span class="fa fa-plus-circle fa-fw"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4"> 
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" onclick="cancelarNewIngreso();"class="btn btn-danger btn-block">
                                            <span class="fa fa-arrow-left fa-fw"></span>Cancelar
                                        </button>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="btn-toolbar">
                                            <button type="button" onclick="registrarIngreso();" class="btn btn-success btn-block">
                                                <span class="fa fa-save fa-fw "></span> Registrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="main-menu-bg"></div>
            </div> <!-- / #main-wrapper -->
            <?php
            require('modal/error_modal.php');
            require("modal/modal_loadNewIngreso.php");
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
            <script src="../js/paginas/fv_new_ingreso.js" ></script>
            <script src="../js/carga_base.js" ></script>
            <script src="../js/dataTables.bootstrap.js" ></script>
            <script src="../js/dataTables.tableTools.js" ></script>

            <script type="text/javascript">
                init.push(function () {
                    //$(":file").filestyle({buttonName: "btn-primary", buttonText: "Seleccionar Archivo"});
                });


                window.LanderApp.start(init);
            </script>

    </body>
</html>