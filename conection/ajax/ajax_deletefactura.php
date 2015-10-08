<?php

if (isset($_POST['idfact'])) {
    session_start();
    $usuario_reg = $_SESSION['idusuario'];
    $iddocumento = $_POST['idfact'];
    $_SESSION['idfactdelete'] = $iddocumento;
    require_once("../fun_sistema.php");
    $ad = new fun_sistema();
    $consulta = "delete from documento where iddocumento=$iddocumento;";

    $conexion = $ad->Query($consulta);
}


