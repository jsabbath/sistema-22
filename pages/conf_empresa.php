<?php
require_once("sistema/cabecera.php");
if ($_SESSION['config'] == 0) {
    header("location:index.php");
}
?>
<!DOCTYPE html>


    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Ajustes de Clientes y proveedores</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

        <!-- Open Sans font from Google CDN -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&amp;subset=latin" rel="stylesheet" type="text/css">

        <!-- LanderApp's stylesheets -->
        <link href="../assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/landerapp.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/bootstrap-toggle.min.css" rel="stylesheet" type="text/css"/>
        <style>
            .dataTables_filter{
                text-align: right;
            }
            .dataTables_paginate{
                text-align: right;
            }
        </style>
        <!--[if lt IE 9]>
                <script src="assets/javascripts/ie.min.js"></script>
        <![endif]-->

    </head>

    <body class="<?php echo $_SESSION['template'] ?> main-menu-animated main-navbar-fixed main-menu-fixed">

        <script>var init = [];</script>

        <div id="main-wrapper">

            <?php
            require 'sistema/navbar.php';

            require 'sistema/menu.php';
            ?> <!-- / #main-menu -->

            <div id="content-wrapper">
                <ul class="breadcrumb breadcrumb-page">
                    <div class="breadcrumb-label text-light-gray" >Tu estas aqui: </div>
                    <li><a href="">Configuracion</a></li>
                    <li><a href="conf_empresa.php">Empresas</a></li>
                    <!--                    <li class="active"><a href="#">Dashboard</a></li>-->
                </ul>
                <div class="page-header">
                    <div class="pull-left col-sm-4">
                        <h1><span class="text-light-gray">Configuracion / </span>Empresas</h1> 
                    </div>
                </div> <!-- / .page-header -->

                <div class="row">
                     <div class="col-lg-12 ">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row"> 
                                    <div class="col-lg-8 col-sm-8" >
                                    </div>
                                    <div class="col-lg-2 col-sm-2" >
                                        <button type="button" onclick="abrirModalUsuario();" class="btn btn-success btn-block">
                                            <span class="fa fa-plus-circle fa-fw "></span>Agregar Empresa 
                                        </button>
                                    </div>
                                    <div class="col-lg-2 col-sm-2" >
                                        <button type="button" onclick="reCargaUsuarios();" class="btn btn-default btn-block">
                                            <span class="fa  fa-refresh fa-fw "></span> Recargar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body" id="tabla_empresas">
                            </div>
                            <!-- .panel-body -->
                        </div>
                    </div>
                   
                </div> <!-- / #content-wrapper -->
                <div id="main-menu-bg"></div>
            </div> <!-- / #main-wrapper -->
           
            <!-- Get jQuery from Google CDN -->
            <!--[if !IE]> -->
            <script type="text/javascript"> window.jQuery || document.write('<script src="../assets/javascripts/jquery.min.js">' + "<" + "/script>");</script>
            <!-- <![endif]-->


            <!-- LanderApp's javascripts -->
            <script src="../js/carga_base.js" ></script>
            <script src="../assets/javascripts/bootstrap.min.js"></script>
            <script src="../assets/javascripts/landerapp.min.js"></script>
            <script src="../assets/javascripts/bootstrap-datepicker.min.js" ></script>
            <script src="../js/paginas/conf_empresa.js" ></script>

            <script type="text/javascript">
                init.push(function () {
                    //$(":file").filestyle({buttonName: "btn-primary", buttonText: "Seleccionar Archivo"});
                });
                window.LanderApp.start(init);
            </script>

    </body>
</html>