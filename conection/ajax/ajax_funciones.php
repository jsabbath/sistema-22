<?php

if (isset($_POST['fecha']) && $_POST['dias']) {
    $fecha = cambiaf_a_mysql($_POST['fecha']);
    $dias = $_POST['dias'];
    $nuevafecha = date('d/m/Y', strtotime("$fecha + $dias day"));
    echo '{"fecha":"' . $nuevafecha . '"}';
}

function cambiaf_a_mysql($fecha) {
    ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
    $lafecha = $mifecha[3] . "-" . $mifecha[2] . "-" . $mifecha[1];
    return $lafecha;
}

if(isset($_POST['fecha_1']) && $_POST['fecha_2']) {
    require_once("../fun_sistema.php");
    $ad = new fun_sistema();
    $dias = $ad->dias_transcurridos($_POST['fecha_2'], $_POST['fecha_1']);
    echo '{"dias":'.$dias.'}';
}
