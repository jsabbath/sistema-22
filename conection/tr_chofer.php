<?php

if (isset($_GET["chofer"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select rut,nombre,codigo,patente,clasificacion_nombre from vistachofer where estado=1 ;";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $i = 0;
    $tabla = "";

    while ($row = mysqli_fetch_array($registro)) {
        $tabla.='{"rut":"' . $row['rut'] . '","nombre":"' . $row['nombre'] . '","codigo":"<b>' . strtoupper($row['codigo']) . '</b>","patente":"' . $row['patente'] . '","clasificacion":"' . $row['clasificacion_nombre'] . '"},';
        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);

    echo '{"data":[' . $tabla . ']}';
}