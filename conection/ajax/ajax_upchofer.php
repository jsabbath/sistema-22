<?php

session_start();
$usuario_reg = $_SESSION['idusuario'];
$chofer_id                = $_POST['id'];
$chofer_nombre            = $_POST['nombre'];
$chofer_clasificacion     = $_POST['clasificacion'];
$chofer_vehiculo          = $_POST['vehiculo'];

require_once("../fun_sistema.php");
$ad = new fun_sistema();
$consulta = "call actualizarchofer($usuario_reg,$chofer_id,'$chofer_nombre',$chofer_clasificacion,$chofer_vehiculo);";
$ad->Query($consulta);