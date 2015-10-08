<?php

if (isset($_POST['extraeradjunto'])) {
    session_start();
    require_once("../fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select archivo from vistaarchivo where idadjunto=".$_POST['extraeradjunto'].";";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $filas = mysqli_num_rows($registro);
    if ($filas) {
        while ($rs = mysqli_fetch_array($registro)) {
            $datos_array['archivo'] = $_SESSION['path_adjuntos'] . "" .$rs[0];
        }
        echo json_encode($datos_array);
    } else {
        echo '{"estado":0}';
    }
}