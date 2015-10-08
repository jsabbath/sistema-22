<?php
require_once("sistema/cabecera.php");

if ($_SESSION['fact_add'] == 0) {
    header("location:index.php");
}
?>
<!DOCTYPE html>


<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Sistema interno</title>
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
        </style>
    </head>

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
                </div> <!-- / .page-header -->

                <div class="row">
                    <div class="col-sm-12" id="fact_registro">
                        <div class="panel panel-primary">
<!--                            <div class="panel-heading">
                                Encabezado
                            </div>                 -->
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group" id="grupo_ndoc">
                                            <label for="fact_numero">NºFactura</label>
                                            <input onKeyPress="return soloNumeros(event);" class="form-control" placeholder="Numero de factura"  name="fact_numero" id="fact_numero" required maxlength="11" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="fact_rut">Rut Proveedor</label>
                                         <!--   <button type="button" class="btn btn-primary"><p class="fa fa-search"></p></button>    -->
                                            <div class="input-group" id="grupo_rut" name="grupo_rut">

                                                <input id="fact_rut" name="fact_rut" type="text" class="form-control" placeholder="Rut del proveedor" maxlength="13">

                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="button" id="buscar_prove" <?php echo 'onclick="consultarProveedor(' . $_SESSION['empresa_def_id'] . ')"' ?> >
                                                        <i class="fa fa-sign-in" title="seleccionar proveedor"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group" id="grupo_prove">
                                            <label >Nombre proveedor</label>
                                            <div class="input-group "> 
                                                <input id="fact_prove" name="fact_prove" type="text" class="form-control" placeholder="" readOnly="true">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="button" id="btn_info_prove" disabled>
                                                        <i class="fa fa-external-link" title="Ver informacion del proveedor"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>  
                                    </div>
                                </div>

                                <!-- segunda fila -->
                                <div class="row">

                                    <div class="col-lg-3 form-group" id="grupo_fecha_e">
                                        <label>fecha emision</label>
                                        <input type="text" class="form-control" name="fact_fecha_doc" id="fact_fecha_doc" onblur="calcular_plazo()" value="<?php echo date("j/m/Y"); ?>" readonly="">
                                    </div>
                                    <div class="col-lg-3 form-group" id="grupo_fecha_p">
                                        <label>fecha plazo</label>
                                        <input type="text" name="fact_fecha_plazo" class="form-control" id="fact_fecha_plazo" disabled>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <p id="radio_plazo">
                                            <label class="checkbox-inline">
                                                <input type="radio" class="px" name="fact_radio_plazo"  onclick="calcular_plazo()" value="30">
                                                <span class="lbl">30 dias</span>
                                            </label>
                                            <label class="checkbox-inline">
                                                <input type="radio" class="px" name="fact_radio_plazo" onclick="calcular_plazo()" value="60">
                                                <span class="lbl">60 dias</span>
                                            </label>
                                            <label class="checkbox-inline">
                                                <input type="radio" class="px" name="fact_radio_plazo" onclick="calcular_plazo()" value="90">
                                                <span class="lbl">90 dias</span>
                                            </label>
                                            <label class="checkbox-inline">
                                                <input type="radio" class="px" name="fact_radio_plazo" onclick="calcular_plazo()" value="120">
                                                <span class="lbl">120 dias</span>
                                            </label>
                                            <label class="checkbox-inline">
                                                <input type="radio" class="px" name="fact_radio_plazo" onclick="calcular_plazo()" value="0">
                                                <span class="lbl">Manual</span>
                                            </label>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 form-group" id="grupo_neto">
                                        <label>Neto</label>
                                        <input id="fact_neto" name="fact_neto" type="numeric" class="form-control" onblur="calcular();" onkeypress="mascara(this, cpf)" onpaste="return false">                                            
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <label>Iva (19%)</label>
                                        <input id="fact_iva" name="fact_iva" type="numeric" class="form-control" readOnly="true">                                            
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <label>Total</label>
                                        <input id="fact_total" name="fact_total" type="numeric" class="form-control" readOnly="true">                                            
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label>Glosa</label>
                                        <input id="fact_glosa" name="fact_glosa" type="textarea" class="form-control" maxlength="200">                                            
                                    </div>

                                </div>  
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <button class="btn btn-lg btn-primary btn-block" id="btn_resert" name="btn_reset" type="reset">Limpiar Datos </button>
                            </div>  
                            <div class="col-lg-6">
                                <button class="btn btn-lg btn-success btn-block" id="btn_reg" name="btn_reg" type="submit">Registrar</button>
                            </div>  
                        </div>
                        <!-- inputs ocultos que contienen el id de la empresa y el id del usuario actual -->
                        <input type="hidden" name="usuario" id="usuario" <?php echo "value='" . $_SESSION['idusuario'] . "'"; ?>><br>
                        <input type="hidden" name="empresa" id="empresa" <?php echo "value='" . $_SESSION['empresa_def_id'] . "'"; ?>><br>
                        <input type="hidden" name="idclieprove" id="idclieprove"><br>
                        <!-- -->
                        <!-- /.row (nested) -->
                    </div>
                </div>

            </div> <!-- / #content-wrapper -->
            <div id="main-menu-bg"></div>
        </div> <!-- / #main-wrapper -->
        <?php
        require("modal/modal_facturamensaje.php");
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
        <script src="../assets/locales/bootstrap-datepicker.es.min.js" ></script>
        <script src="../js/paginas/fc_compra.js" ></script>
        <script src="../js/carga_base.js" ></script>
        <script src="../js/bootstrap-typeahead.js"></script>
        <script type="text/javascript">
            init.push(function () {
                $('.fact_rut').typeahead('destroy');
                $('#fact_rut').typeahead({
                    ajax: '../conection/fc_compra.php'
                });

            });
            $("#fact_rut").focusout(function () {
                $('#fact_prove').val("");
                if ($("#fact_rut").val().length > 9) {
                    consultarProveedor(<?php echo $_SESSION['empresa_def_id'] ?>);
                }
            });
            window.LanderApp.start(init);
        </script>

    </body>
</html>