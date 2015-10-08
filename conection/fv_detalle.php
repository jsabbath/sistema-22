<?php

if (isset($_GET['idfact'])) {
    $idfactura = $_GET['idfact'];

    require("fun_sistema.php");
    $ad = new fun_sistema();

    $conexion = $ad->conectarBD();

    //Creamos la consulta
    $consulta = "select * from vistaarchivo where idpadre=$idfactura and (tabla_padre='fv' and estado=1);";
    //obtenemos los registros de la consulta
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    //obtenemos el array con toda la información
    $i = 0;
    $tabla = "";

    while ($row = mysqli_fetch_array($registro)) {
        $view = '<button onclick=\"detallearchivo(' . $row['idadjunto'] . ')\" class=\"btn btn-success btn-block btn-xs\" id=\"btn_modal\" name=\"btn_modal\">Detalle </button>';
        $tabla.='{"tipo":"' . $row['archivo_tipo'] . '","archivo":"' . $row['archivo'] . '","fecha":"' . date("d/m/Y", strtotime($row['fecha'])) . '","usuario_nombre":"' . $row['usuario_nombre'] . '","detalle":"' . $view . '"},';
        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);

    echo '{"data":[' . $tabla . ']}';
}
