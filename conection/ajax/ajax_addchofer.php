<?php

session_start();
$usuario_reg = $_SESSION['idusuario'];
$chofer_rut             = $_POST['rut'];
$chofer_codigo          = $_POST['codigo'];
$chofer_nombre          = $_POST['nombre'];
$chofer_clasificacion   = $_POST['clasificacion'];
$chofer_vehiculo       = $_POST['vehiculo'];

require_once("../fun_sistema.php");
$ad = new fun_sistema();
$consulta = "call insertarchofer($usuario_reg,'$chofer_rut','$chofer_nombre','$chofer_codigo',$chofer_clasificacion,$chofer_vehiculo);";
$conexion = $ad->Query($consulta);