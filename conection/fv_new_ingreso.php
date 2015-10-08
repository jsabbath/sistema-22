<?php
session_start();
//obtener correlativo actual de los egresos
if (isset($_POST['corre_ingreso'])) {
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select correlativo from corre where codigo='in';";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    if ($registro) {
        if ($rs = mysqli_fetch_array($registro)) {
            $_SESSION['corre_ingreso'] = $rs[0];
            echo '{"corre":' . $rs[0] . '}';
        } else {
            echo '{"corre":0}';
        }
    }
}

//setear array de facturas seleccionadas en una variable session
if (isset($_POST['facturas'])) {
    $listado_facturas = $_POST['facturas'];
    $_SESSION['facturasIngreso'] = $listado_facturas;
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select DISTINCT d.clieprove,cl.id as prove_id,cl.nombre as prove_nombre from documento d inner join clieprove cl on cl.id=d.clieprove where d.iddocumento in($listado_facturas);";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $cont = 0;
    if ($registro) {
        while ($rs = mysqli_fetch_array($registro)) {
            $cont++;
            $_SESSION['prove_id'] = $rs['prove_id'];
            $_SESSION['prove_nombre'] = $rs['prove_nombre'];
        }
        if ($cont == 1) {
            echo '{"estado":1}';
        } else {
            echo '{"estado":2}';
        }
    }
}

//agregar factura al array
if (isset($_POST['new_fact'])) {
    $facturas = explode(",", $_SESSION['facturasIngreso']);
    $idproveedor = $_SESSION['prove_id'];
    $new_fact = $_POST['new_fact'];

    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select * from documento where clieprove=$idproveedor and ndoc=$new_fact and estado=1";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $filas = mysqli_num_rows($registro);
    if ($filas) {
        if ($row = mysqli_fetch_array($registro)) {
            if (!in_array($row[0], $facturas)) {         //consultar si existe id de nueva factura en las anteriores
                $_SESSION['facturasIngreso'] .= "," . $row[0];
                echo '{"estado":1}';
            } else {
                echo '{"estado":2}';
            }
        }
    } else {
        echo '{"estado":0}';
    }
}

//eliminar numero de factura del array actual

if (isset($_POST['fact_eli_ingreso'])) {
    $fac_eli = $_POST['fact_eli_ingreso'];
    $listado_facturas = $_SESSION['facturasIngreso'];
    $resultado = str_replace($fac_eli, '0', $listado_facturas);
    $_SESSION['facturasIngreso'] = $resultado;
    echo '{"estado":1,"listado":"' . $_SESSION['facturasIngreso'] . '"}';
}

//obtener tabla desde un array de facturas
if (isset($_GET['tabla_factura_in'])) {
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select * from vistafactura where iddocumento in(" . $_SESSION['facturasIngreso'] . ")";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $filas = mysqli_num_rows($registro);
    $i = 0;
    $tabla = "";
    $total_contador = 0;
    //1 pendiente, 2 pagada , 3 eliminada
    if ($registro) {
        while ($row = mysqli_fetch_array($registro)) {
            if ($filas == 1) {
                $eliminar = '<button type=\"button\" class=\"btn btn-default btn-block btn-xs\"><span class=\"fa fa-times fa-fw\"></span> Eliminar </button>';
            } else {
                $eliminar = '<button type=\"button\" onclick=\"eliminarIngreso(' . $row['iddocumento'] . ')\" class=\"btn btn-danger btn-block btn-xs\"><span class=\"fa fa-times fa-fw\"></span> Eliminar </button>';
            }
            //$eliminar = '<button onclick=\"eliminar(' . $row['iddocumento'] . ')\" class=\"btn btn-danger btn-block btn-xs\" id=\"btn_modal\" name=\"btn_modal\">Eliminar</button>';
            $check = "<input name='" . $row['iddocumento'] . "' id='" . $row['iddocumento'] . "' type='checkbox' disabled checked>";
            $tabla.='{"check":"' . $check . '","ndoc":"Factura Nº ' . $row['ndoc'] . '","total":"' . "$" . number_format($row['total'], 0) . '","eliminar":"' . $eliminar . '"},';
            $i++;
            $total_contador = $total_contador + $row['total'];
        }

        $tabla.='{"check":"","ndoc":"<b>TOTAL<b>","total":"<b id=\"total\">' . "$" . number_format($total_contador, 0) . '</b>","eliminar":""},';
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        $_SESSION['total_egreso'] = $total_contador;
        echo '{"data":[' . $tabla . ']}';
    }
}

//obtener el monto total de la tabla de facturas
if (isset($_GET['fact_monto'])) {
    $facturas = $_GET['fact'];
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select sum(total) as total from vistafactura where iddocumento in(" . $facturas . ")";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    //1 pendiente, 2 pagada , 3 eliminada
    if ($row = mysqli_fetch_array($registro)) {
        $total = $row['total'];
    }
    echo '{"total":' . $total . '}';
}

if (isset($_POST['cancelar'])) {
    $_SESSION['facturas'] = "";
    echo '{"estado":1}';
}
