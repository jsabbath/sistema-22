<?php

session_start();
$usuario_reg    = $_SESSION['idusuario'];

$km_anterior             = $_POST['km_anterior'];
$km             = $_POST['km'];
$lt             = $_POST['lt'];
$rendimiento    = $_POST['rendimiento'];
$vehiculo       = $_POST['vehiculo'];
$chofer         = $_POST['chofer'];
$clasificacion  = $_POST['clasificacion'];
$obs            = $_POST['obs'];

require_once("../fun_sistema.php");
$ad = new fun_sistema();

$consulta = "call insertarplanilla($usuario_reg,$vehiculo,$chofer,$clasificacion,$km_anterior,$km,$lt,$rendimiento,'$obs');";
$conexion = $ad->Query($consulta);

