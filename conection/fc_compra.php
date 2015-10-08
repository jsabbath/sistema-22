<?php
session_start();
if (isset($_REQUEST['query'])) {
    $query = $_REQUEST['query'];

    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select rut from clieprove where tipo=1 and id in(select ec.clieprove from emp_clieprove ec where ec.empresa=".$_SESSION['empresa_def_id'].") and estado=1";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $array = array();
    while ($row = mysqli_fetch_array($registro)) {
        $array[] = $row['rut'];
    }
    echo json_encode($array); //Return the JSON Array
}