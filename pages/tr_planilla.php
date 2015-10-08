<?php
require_once("sistema/cabecera.php");
if ($_SESSION['tr_planilla'] == 0) {
    header("location:index.php");
}
?>
<!DOCTYPE html>

<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Control de combustible</title>
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
            @import url(http://fonts.googleapis.com/css?family=Montserrat:400,700);
            .h4, .h5, .h6, h4, h5, h6 {
                margin-top: 8px;
                margin-bottom: 4px;
            }
            .subtitulo{
                font-size: 16px;
            }
            #patente{
                font-size: 45px;//52px;
                font-family: 'Montserrat', sans-serif;
            }
            .modal-dialog.modal-lg {
                width: 93%;
            }
            #obs{
                resize: none;
            }
        </style>
        <!--[if lt IE 9]>
                <script src="assets/javascripts/ie.min.js"></script>
        <![endif]-->

    </head>

    <body class="<?php echo $_SESSION['template'] ?> main-menu-animated main-navbar-fixed main-menu-fixed">

        <script>var init = [];</script>

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
                <ul class="breadcrumb breadcrumb-page">
                    <div class="breadcrumb-label text-light-gray" >Tu estas aqui: </div>
                    <li><a href="#">Factura de compra</a></li>
                    <li><a href="fc_compra.php">Ingreso</a></li>
                    <!--                    <li class="active"><a href="#">Dashboard</a></li>-->
                </ul>
                <div class="page-header">
                    <h1><span class="text-light-gray">Factura de compra / </span>Ingreso</h1>
                    <div class="col-lg-4 pull-right" id="grupo_obs">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-fire fa-fw menu-icon"></i> Estanque</span>
                            <select id="estanque" class="form-control">
                            </select>
                        </div>
                    </div>
                </div> <!-- / .page-header -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-4 col-xs-8">
                                        <div class="input-group" id="grupo_busqueda" name="grupo_rut">
                                            <input id="busqueda" name="busqueda" type="text" class="form-control" placeholder="Codigo del chofer" maxlength="13">
                                            <span class="input-group-btn">
                                                <button class="btn btn-success" type="button" name="buscar" id="buscar" onclick="Consulta($('#busqueda').val())" >
                                                    <i class="fa fa-sign-in" title="seleccionar proveedor"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>  
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-4 col-sm-4 col-xs-4"></div>
                                    <div class="col-lg-2 col-sm-4 col-xs-4"  align="center">
                                        <h4><b><?php echo date("d/m/Y"); ?></b></h4>
                                    </div>
                                </div>
                            </div>     
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="panel panel panel-yellow">
                                    <div class="panel-heading" align="center">
                                        <b class="subtitulo">INGRESO DE DATOS</b>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group" id="grupo_km">
                                                    <label for="km"> Km</label>
                                                    <input type="text"class="form-control" placeholder=""  name="km" id="km" required maxlength="11">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group" id="grupo_lt">
                                                    <label for="lt"> Consumo LT</label>
                                                    <input type="text" class="form-control" placeholder=""  name="lt" id="lt"  required maxlength="11">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group" id="grupo_km_anterior">
                                                    <label for="km_anterior"> Km anterior</label>
                                                    <input type="text" class="form-control" placeholder=""  name="km_anterior" id="km_anterior" required maxlength="11" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group" id="grupo_rendimiento">
                                                    <label for="rendimiento"> Rendimiento</label>
                                                    <input type="text"  class="form-control" placeholder=""  name="rendimiento" id="rendimiento" required maxlength="11" readonly="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 form-group" id="grupo_obs">
                                                <label>Observacion</label>
                                                <textarea class="form-control" rows="4" name="obs" id="obs"></textarea>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <button class="btn btn-success btn-block" id="btn_reg" name="btn_reg" onclick="registrarPlanilla();">Registrar</button>
                                            </div>  
                                            <div class="col-lg-6">
                                                <button class="btn btn-primary btn-block" id="btn_resert" name="btn_reset" onclick="resetPlanilla();">Limpiar Datos </button>
                                            </div>  
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="panel panel panel-primary">
                                    <div class="panel-heading" align="center">
                                        <b class="subtitulo">DATOS VEHICULO Y CHOFER</b>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group" id="grupo_tipo_vehiculo">
                                                    <label for="tipo_vehiculo">Tipo Vehiculo</label><br>
                                                    <select id="tipo_vehiculo" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group" id="grupo_vehiculo">
                                                    <label for="vehiculo">Vehiculo</label><br>
                                                    <select id="vehiculo" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6" align="center">
                                                <span id="patente">-- -- --</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group" id="grupo_chofer">
                                                    <label for="chofer">Chofer</label><br>
                                                    <select id="chofer" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group" id="grupo_clasificacion">
                                                    <label for="clasificacion">Clasificacion</label><br>
                                                    <select id="clasificacion" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>

                                <div class="panel panel panel-primary">
                                    <div class="panel-heading" align="center">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <b class="subtitulo">ULTIMOS REGISTROS</b>
                                            </div>
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-5">
                                                <button class="btn btn-xs btn-info btn-block" id="btn_reg" onclick="abrirRegistros($('#vehiculo').val());">VER TODOS LOS REGISTROS</button>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12 table-primary">
                                                <table id="tabla_registro" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 10%;">Fecha</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 25%;">Chofer</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 10%;">Km</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 5%;">Consumo</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 5%;">Rendimiento</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 5%;">detalle</th>
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
                    </div>
                </div>
                <input type="hidden" name="idvehi" id="idvehi" value="0">
            </div> <!-- / #content-wrapper -->
            <div id="main-menu-bg"></div>
        </div> <!-- / #main-wrapper -->
        <?php
        require("modal/modal_loadPlanilla.php");
        require("modal/modal_showPlanillaVehiculo.php");
        ?>

        <div class="modal fade" id="modal_factura_repetida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Factura Existente</h4>
                    </div>
                    <div class="modal-body">
                        <p align="center"> Este numero de factura ya se encuentra registrado para el proveedor <label id="modal_factura_repetida_rut"></label> </p>
                    </div>
                    <div class="modal-footer">
                        <button  id="cerrar_modal_rut"  type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <!-- <button id="cerrar_modal_rut" type="button" class="btn btn-primary">Save changes</button> -->
                    </div>
                </div>
                <!-- /.modal-content -->
            </div> 
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal_error_rut" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Rut Incorrecto</h4>
                    </div>
                    <div class="modal-body">
                        <p align="center"> El rut ingresado no existe o no esta vinculado con la empresa <br> <?php echo $_SESSION['empresa_def_nom'] ?> </p>
                    </div>
                    <div class="modal-footer">
                        <button  id="cerrar_modal_rut"  type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <!-- <button id="cerrar_modal_rut" type="button" class="btn btn-primary">Save changes</button> -->
                    </div>
                </div>
                <!-- /.modal-content -->
            </div> 
            <!-- /.modal-dialog -->
        </div>


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
        <script src="../js/paginas/tr_planilla.js" ></script>
        <script src="../js/carga_base.js" ></script>
        <script src="../js/bootstrap-typeahead.js"></script>
        <script type="text/javascript">
            init.push(function () {


            });
            window.LanderApp.start(init);
        </script>

    </body>
</html>