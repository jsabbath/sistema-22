<?php

session_start();
$usuario_reg = $_SESSION['idusuario'];
$tipoVehiculo  = $_POST['tipoVehiculo'];
                        
require_once("../fun_sistema.php");
$ad = new fun_sistema();
$consulta = "insert into tipo_vehi(descrip) values('$tipoVehiculo');";
$conexion = $ad->Query($consulta);