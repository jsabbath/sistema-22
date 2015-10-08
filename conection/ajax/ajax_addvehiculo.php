<?php

session_start();
$usuario_reg = $_SESSION['idusuario'];
$vehiculo_patente       = $_POST['patente'];
$vehiculo_descripcion   = $_POST['descripcion'];
$vehiculo_tipo          = $_POST['tipo'];
$vehiculo_km            = $_POST['km'];

require_once("../fun_sistema.php");
$ad = new fun_sistema();
$consulta = "call insertarvehiculo($usuario_reg,$vehiculo_tipo,'$vehiculo_patente','$vehiculo_descripcion','$vehiculo_km');";
$conexion = $ad->Query($consulta);