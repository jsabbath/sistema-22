<?php

session_start();
$usuario_reg     = $_SESSION['idusuario'];
$usuario_rut     = $_POST['usuario_rut'];
$usuario_login   = $_POST['usuario_usuario'];
$usuario_nombre  = $_POST['usuario_nombre'];
$usuario_correo  = $_POST['usuario_correo'];
$usuario_rol     = $_POST['usuario_perfil'];
$usuario_empresa = $_POST['usuario_empresa'];
$usuario_fono    = $_POST['usuario_fono'];
$usuario_pass    = md5($_POST['usuario_pass']);

require_once("../fun_sistema.php");
$ad = new fun_sistema();
$consulta = "call insertarusuario($usuario_reg,'$usuario_rut','$usuario_nombre','$usuario_login','$usuario_pass','$usuario_correo',$usuario_fono,$usuario_rol,$usuario_empresa);";
$conexion = $ad->Query($consulta);

