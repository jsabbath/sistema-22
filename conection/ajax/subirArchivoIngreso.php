<?php 
session_start();
$idfactura = $_SESSION['in_adjunto_idingreso'];
$idusuario = $_SESSION['idusuario'];
$padre = 'in';
$ext = end(explode("/", $_FILES['archivo']['type']));
$comentario = $_POST['adjunto_glosa'];

$file = $idfactura . "_" . $padre . "_" . $_FILES['archivo']['name'];

if (!is_dir("../" . $_SESSION['path_adjuntos'] . "/")) {
    mkdir("../" . $_SESSION['path_adjuntos'] . "/", 0777);
}

if ($_FILES["archivo"]["error"] > 0) {
    echo "error";
} else {
    //ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
    //y que el tamano del archivo no exceda los 100kb
    $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png", "application/pdf");
    $limite_kb = 5000000;
    
    if (in_array($_FILES['archivo']['type'], $permitidos) && $_FILES['archivo']['size'] <= $limite_kb * 1024) {

        $ruta = "../" . $_SESSION['path_adjuntos'] . "/" . $file;

        if (!file_exists($ruta)) {

            $resultado = @move_uploaded_file($_FILES["archivo"]["tmp_name"], $ruta);
            if ($resultado) {
                //echo "el archivo ha sido movido exitosamente";
                require("../fun_sistema.php");
                $ad = new fun_sistema();

                $conexion = $ad->conectarBD();

                //Creamos la consulta
                $consulta = "call insertararchivo ($idfactura,'$padre',$idusuario,'$comentario','$file','$ext');";
                //obtenemos los registros de la consulta
                mysqli_set_charset($conexion, "utf8");
                $registro = mysqli_query($conexion, $consulta);


                sleep(3); //retrasamos la petición 3 segundos
                echo '{"estado":"0","msg":"'.$file.'"}'; //devolvemos el nombre del archivo para pintar la imagen
            } else {
                echo '{"estado":"1","msg":"ocurrio un error al mover el archivo"}'; //devolvemos el nombre del archivo para pintar la imagen
            }
        } else {
            echo '{"estado":"2","msg":"'.$_FILES['archivo']['name'].', este archivo existe"}';
        }
    } else {
        echo '{"estado":"3","msg":"archivo no permitido, es tipo de archivo prohibido o excede el tamano de '.$limite_kb.' Kilobytes"}';
    }
}
?>