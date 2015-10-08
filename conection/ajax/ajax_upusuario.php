<?php

session_start();
$usuario_reg = $_SESSION['idusuario'];
$id = $_POST['idusuario'];
$rut = $_POST['rut'];
$usuario = $_POST['usuario'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$perfil = $_POST['perfil'];
$empresa = $_POST['empresa'];
$fono = $_POST['fono'];
$pass="";
if ($_POST['pass']) {
    $pass = md5($_POST['pass']);
} else {
    $pass = "null";
}

require_once("../fun_sistema.php");
$ad = new fun_sistema(); 
$consulta = "call actualizarusuario($usuario_reg,$id,'$rut','$nombre','$usuario','$pass','$correo','$fono',$perfil,$empresa)";
$ad->Query($consulta);
