<?php
 
session_start();
require_once("../fun_sistema.php");
$ad = new fun_sistema();

$numero = $_POST['fact_numero'];
$clieprove = $_POST['idclieprove'];
$fecha_doc = $ad->cambiaf_a_mysql($_POST['fact_fecha_doc']);
$fecha_plazo = $ad->cambiaf_a_mysql($_POST['fact_fecha_plazo']);
$usuario = $_SESSION['idusuario'];
$empresa = $_POST['empresa'];
$glosa = $_POST['fact_glosa'];
$neto = str_replace(',', '', $_POST['fact_neto']);
$iva = str_replace(',', '', $_POST['fact_iva']);
$total = str_replace(',', '', $_POST['fact_total']);

$consulta = "call insertarfactura(2,$numero,$clieprove,'$fecha_doc','$fecha_plazo',$usuario,$empresa,'$glosa',$neto,$iva,$total,1);";

$conexion = $ad->Query($consulta);

