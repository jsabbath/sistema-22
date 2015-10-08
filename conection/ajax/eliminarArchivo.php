<?php

if (isset($_POST['eliminar_archivo']) && isset($_POST['adjunto_eliminar'])) {
    session_start();
    $usuario_reg = $_SESSION['idusuario'];
    $idadjunto = $_POST['eliminar_archivo'];
    require_once("../fun_sistema.php");
    $ad = new fun_sistema();
    $fichero = "../" .  $_POST['adjunto_eliminar'];
    unlink($fichero);
    $consulta = "call eliminarAdjunto ($usuario_reg,$idadjunto);";

    $conexion = $ad->Query($consulta);
}
