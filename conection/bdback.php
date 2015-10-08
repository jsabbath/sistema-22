<?php

echo cambiaf_a_mysql("20/07/2015");

function cambiaf_a_mysql($fecha){ 
ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha); 
$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1]; 
return $lafecha; 
}