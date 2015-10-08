<?php

if (isset($_GET['idfact'])) {
    $idfactura = $_GET['idfact'];

    require("fun_sistema.php");
    $ad = new fun_sistema();

    $conexion = $ad->conectarBD();

    //Creamos la consulta
    $consulta = "select * from vistaarchivo where idpadre=$idfactura and (tabla_padre='fc' and estado=1);";
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
/* 
//subir_archivo
if ($_FILES["imagen"]["error"] > 0) {
    echo "error";
} else {
    //ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
    //y que el tamano del archivo no exceda los 100kb
    $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
    $limite_kb = 100;

    if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024) {
        //esta es la ruta donde copiaremos la imagen
        //recuerden que deben crear un directorio con este mismo nombre
        //en el mismo lugar donde se encuentra el archivo subir.php
        $ruta = "../adjuntos/factura/" . $_FILES['imagen']['name'];
        //comprovamos si este archivo existe para no volverlo a copiar.
        //pero si quieren pueden obviar esto si no es necesario.
        //o pueden darle otro nombre para que no sobreescriba el actual.
        if (!file_exists($ruta)) {
            //aqui movemos el archivo desde la ruta temporal a nuestra ruta
            //usamos la variable $resultado para almacenar el resultado del proceso de mover el archivo
            //almacenara true o false
            $resultado = @move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta);
            if ($resultado) {
                echo "el archivo ha sido movido exitosamente";
            } else {
                echo "ocurrio un error al mover el archivo.";
            }
        } else {
            echo $_FILES['imagen']['name'] . ", este archivo existe";
        }
    } else {
        echo "archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
    }
}
?> */