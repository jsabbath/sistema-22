<?php

session_start();
if (isset($_GET['clieprove']) && isset($_GET['mes']) && isset($_GET['ano'])) {
    $clieprove = $_GET['clieprove'];
    $idempresa = $_SESSION['empresa_def_id'];
    
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    

    $mes = $_GET['mes'];
    $ano = $_GET['ano'];
    
    $consulta = "";
    if ($clieprove == 0) {
        $sqlClieprove = "";
    } else{
        $sqlClieprove = "clieprove_id=$clieprove and";
    }
    
    if ($mes == 0) {
        $consulta = "select * from vistapagos where $sqlClieprove fecha_pago between '$ano-01-01' and '$ano-12-31' and (clieprove_id in(select clieprove from emp_clieprove where empresa=$idempresa)) and tipo=1";
    } else {
        $dias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
        $consulta = "select * from vistapagos where $sqlClieprove fecha_pago between '$ano-$mes-01' and '$ano-$mes-$dias' and (clieprove_id in(select clieprove from emp_clieprove where empresa=$idempresa)) and tipo=1";
    }
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $i = 0;
    $tabla = "";
    while ($row = mysqli_fetch_array($registro)) {
        $impr = '<button type=\"button\" onclick=\"imprimirPDF(' . $row['idpago'] . ')\" class=\"btn btn-danger btn-block btn-xs\"><span class=\"fa fa-file-pdf-o fa-fw\"></span> PDF </button>';
        $detalle = '<button type=\"button\" onclick=\"detalleEgreso(' . $row['correlativo'] . ')\" class=\"btn btn-info btn-block btn-xs\"><span class=\"fa fa-external-link fa-fw\"></span> detalle </button>';
        $tabla.='{"check":"","correlativo":"' . $row['correlativo'] . '","clieprove":"' . $row['clieprove_nombre'] . '","fecha_pago":"' . date("d/m/Y", strtotime($row['fecha_pago'])) . '","total":"<b>$' . number_format($row['total_pago'], 0) . '</b>","detalle":"' . $detalle . '","pdf":"' . $impr . '"},';
        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);
    echo '{"data":[' . $tabla . ']}';
}
?>

