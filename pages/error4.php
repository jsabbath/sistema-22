<?php require_once("sistema/cabecera.php"); ?>
<!DOCTYPE html>
<html lang="es">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Error</title>

        <!-- Bootstrap Core CSS -->
        <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="../dist/css/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        
    </head>

    <body>

        <div id="wrapper">

            <?php require_once("sistema/menu.php"); ?>


            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                      <h1 class="page-header"> <img src="../adj/sistema/dino.gif" alt="" width="100px"/><!--<i class="fa fa-frown-o fa-2x"></i> --><b> Error al procesar informacion ...</b></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Error inesperado
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" align="center">
                            <p>Se han tomado los datos de sus session y el evento que genero el error para su posterior revision.</p>
                            <div id="CuentaAtras" class="alert alert-danger">

                            </div>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <h2><p id="CuentaAtras"><p></h2>

                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>
        <!-- Carga base de java script internos -->
        <script src="../js/carga_base.js"></script>
        <script>
            
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

<!--
     <a class="thumbnail">
     <img src="../bower_components/images/logo.png" alt="logo sistema">
</a> -->