<?php

if (isset($_POST['idfactura'])) {
    session_start();
    $usuario_reg = $_SESSION['idusuario'];
    $id = $_POST['idfactura'];
    $fecha_doc = $_POST['fecha_doc'];
    $fecha_plazo = $_POST['fecha_plazo'];
    $neto = str_replace(',','',$_POST['neto']);
    $iva = str_replace(',','',$_POST['iva']);
    $total = str_replace(',','',$_POST['total']);
    $glosa = $_POST['glosa'];

    require_once("../fun_sistema.php");
    $ad = new fun_sistema();
    $consulta = "call actualizarfactura($usuario_reg,$id,'$fecha_doc','$fecha_plazo','$glosa',$neto,$iva,$total);";

    $conexion = $ad->Query($consulta);
}
