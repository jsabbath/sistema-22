<?php
 session_start();
if (isset($_POST['reset'])) {
    $correlativo = $_SESSION['corre_ingreso'];
    $_SESSION['corre_ingreso'] = "";
    $_SESSION['total_egreso'] = "";
    $_SESSION['facturasIngreso'] = "";
    echo $correlativo;
} else {
   
    $usuario_reg = $_SESSION['idusuario'];
    $corre_egreso = $_SESSION['corre_ingreso'];
    $total_egreso = $_SESSION['total_egreso'];
    $tipo_pago = $_POST['tipo_pago'];
    $docs = $_POST['docs'];
    $proveedor_id = $_POST['proveedor_id'];
    $glosa = $_POST['glosa'];
    $facturas = $_POST['facturas'];


    require_once("../fun_sistema.php");
    $ad = new fun_sistema();
    $consulta = "call insertarNewIngreso($usuario_reg,$proveedor_id,$tipo_pago,'$docs','$glosa',$total_egreso,$corre_egreso,2);";
    $conexion = $ad->Query($consulta);


    $conexion = $ad->conectarBD();
    $consulta = "SELECT MAX(idpago) AS id FROM pago";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $idpago = 0;
    while ($rs = mysqli_fetch_array($registro)) {
        $idpago = $rs[0];
    }

    $listado = explode(",", $facturas);
    foreach ($listado as $iddocumento) {
        if ($iddocumento != 0) {
            $consulta = "call insertarNewPagoDetalle($idpago,$iddocumento);";
            $ad->Ejecutar($consulta);
        }
    }
}