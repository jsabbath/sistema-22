<?php

session_start();
$usuario_reg = $_SESSION['idusuario'];
$vehiculo_id              = $_POST['id'];
$vehiculo_patente         = $_POST['patente'];
$vehiculo_descripcion     = $_POST['descripcion'];
$vehiculo_tipo            = $_POST['tipo'];

require_once("../fun_sistema.php");
$ad = new fun_sistema();
$consulta = "call actualizarvehiculo($usuario_reg,$vehiculo_id,$vehiculo_tipo,'$vehiculo_patente','$vehiculo_descripcion')";
$ad->Query($consulta);