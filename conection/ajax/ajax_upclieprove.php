<?php

session_start();
$usuario_reg = $_SESSION['idusuario'];
$id = $_POST['id'];
$tipo = $_POST['tipo'];
$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$giro = $_POST['giro'];
$fono = $_POST['fono'];
$comuna = $_POST['comuna'];


require_once("../fun_sistema.php");
$ad = new fun_sistema();
$consulta = "call actualizarclieprove($usuario_reg,$id,'$rut','$nombre','$giro','$direccion',$comuna,'$fono',$tipo);";

$conexion = $ad->Query($consulta);