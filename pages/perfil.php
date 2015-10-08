<?php require_once("sistema/cabecera.php"); ?>
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
        <title>Perfil</title>
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
    <body class="<?php echo $_SESSION['template'] ?> main-menu-animated main-navbar-fixed main-menu-fixed" >

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
                    <li><a href="perfil.php">Perfil</a></li>
                    <!--                    <li class="active"><a href="#">Dashboard</a></li>-->
                </ul>
                <div class="page-header">
                    <div class="pull-left col-sm-4">
                        <h1><span class="text-light-gray">Perfil </span></h1> 
                    </div>
                </div> <!-- / .page-header -->

                <div class="row">
                    
                     <div class="col-lg-6">
                        <div class="panel panel panel-default">
                            <div class="panel-heading">
                                <b class="subtitulo">Datos personales</b>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group" id="grupo_rut">
                                            <label for="perfil_rut"> Rut</label>
                                            <input type="text" class="form-control"  name="perfil_rut" id="perfil_rut" maxlength="11" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group" id="grupo_usuario">
                                            <label for="perfil_usuario"> Usuario</label>
                                            <input type="text" class="form-control"  name="perfil_usuario" id="perfil_usuario"   maxlength="11" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group" id="grupo_nombre">
                                            <label for="perfil_nombre"> Nombre</label>
                                            <input type="text" class="form-control"  name="perfil_nombre" id="perfil_nombre"   maxlength="11" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group" id="grupo_correo">
                                            <label for="perfil_correo"> Correo</label>
                                            <input type="email" class="form-control"  name="perfil_correo" id="perfil_correo" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group" id="grupo_fono">
                                            <label for="perfil_fono"> Fono</label>
                                            <input onKeyPress="return soloNumeros(event);" class="form-control" name="perfil_fono" id="perfil_fono"  maxlength="8" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button class="btn btn-warning btn-block" id="btn_mod" name="btn_reg" onclick="modificarPerfil();">Modificar</button>
                                    </div>  
                                    <div class="col-lg-6">
                                        <button class="btn btn-success btn-block" id="btn_reg" name="btn_reset" onclick="actualizarUsuario();">Guardar</button>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="panel panel panel-red">
                            <div class="panel-heading">
                                <b class="subtitulo">Cambio de clave</b>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group" id="grupo_rut">
                                            <label for="perfil_pass"> Clave actual</label>
                                            <input type="password" class="form-control"  name="perfil_pass" id="perfil_pass">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group" id="grupo_usuario">
                                            <label for="perfil_pass1"> Nueva clave</label>
                                            <input type="password" class="form-control"  name="perfil_pass1" id="perfil_pass1"  placeholder="Nueva clave" maxlength="11" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group" id="grupo_nombre">
                                            <label for="perfil_pass2"> Nueva clave</label>
                                            <input type="password" class="form-control"  name="perfil_pass2" id="perfil_pass2"  placeholder="Reingresar nueva clave" maxlength="11">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button class="btn btn-success btn-block" id="btn_reg" name="btn_reset" onclick="actualizarUsuario();">Cambiar Clave</button>
                                    </div>  
                                </div>
                            </div>
                        </div>
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
            <script src="../assets/javascripts/bootstrap-datepicker.min.js" ></script>
            <script src="../js/paginas/perfil.js" ></script>
            <script src="../js/carga_base.js" ></script>

            <script type="text/javascript">
                init.push(function () {
                    //$(":file").filestyle({buttonName: "btn-primary", buttonText: "Seleccionar Archivo"});
                });
                window.LanderApp.start(init);
            </script>

    </body>
</html>