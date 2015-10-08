<?php

if (isset($_GET["desde"]) || isset($_GET["hasta"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();

    $w ='';
    if ($_GET["desde"] && $_GET["hasta"]) {

        //feha desde y hasta
        $desde = $ad->cambiaf_a_mysql($_GET["desde"]);
        $hasta = $ad->cambiaf_a_mysql($_GET["hasta"]);

        //consulta 
        $w .= "where (fecha between '$desde' and '$hasta') ";
    } 
    if($_GET["accion"]){
        if($w){
            $w.=" and (accion='".$_GET["accion"]."') ";
        }else{
            $w.=" where (accion='".$_GET["accion"]."') ";
        }
    }
    if($_GET["usuario"]){
        if($w){
            $w.=" and (usuario_id=".$_GET["usuario"].") ";
        }else{
            $w.=" where (usuario_id=".$_GET["usuario"].") ";
        }
    }
       
    $consulta = "select * from vistahistorial $w order by idhistorial;";

    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $i = 0;
    $tabla = "";

    while ($row = mysqli_fetch_array($registro)) {
        $view = '<button onclick=\"detallearchivo(' . $row['idhistorial'] . ')\" class=\"btn btn-success disabled btn-block btn-xs\" id=\"btn_modal\" name=\"btn_modal\">Detalle </button>';
        $tabla.='{"fecha":"' . date("d/m/Y", strtotime($row['fecha'])) . '","accion":"' . $row['accion'] . '","afectado":"' . $row['tipo'] . '","descripcion":"' . $row['descrip'] . '","usuario":"' . $row['usuario_nombre'] . '","detalle":"' . $view . '"},';
        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);

    echo '{"data":[' . $tabla . ']}';
}
