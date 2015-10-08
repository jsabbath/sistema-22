<?php

session_start();
$usuario_reg = $_SESSION['idusuario'];
$clasificacion          = $_POST['clasificacion'];
                        
require_once("../fun_sistema.php");
$ad = new fun_sistema();
$consulta = "insert into clasificacion(nombre) values('$clasificacion');";
$conexion = $ad->Query($consulta);