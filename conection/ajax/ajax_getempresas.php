<?php
if (isset($_POST['empresas'])) {
    require_once("../fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from empresa where estado=1";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    if ($registro) {
        while ($rs = mysqli_fetch_array($registro)) {
            echo "<div class='row'> 
                    <div class='col-lg-12'> 
                        <div class='well'>
                            <div class='row'>
                              <input id='id_empresa' name='id_empresa' type='hidden' value='".$rs['idempresa']."'>
                                <div class='col-lg-8'>
                                    <div class='col-lg-12'>
                                        <h3><b>".$rs['nombre']."</b></h3>
                                    </div>
                                    <div class='col-lg-12'>
                                        <h4><b>RUT :</b>".$rs['rut']."</h4>
                                        <h4><b>EMAIL :</b>".$rs['correo']."</h4>
                                    </div>
                                    <div class='col-lg-12'>
                                        <h4><b>DESCRIPCION :</b></h4>
                                        <p>".$rs['descrip']."</p>
                                    </div>
                                </div>
                                <div class='col-lg-4'>
                                    <div class='col-lg-12'>
                                        <a class='thumbnail active' id='caja-logo'>
                                            <img src='../adj/empresas/".$rs['logo']."' alt='logo sistema' id='logo_emp' width='150px'>                        
                                        </a>
                                    </div>
                                    <div class='col-lg-12'><br>
                                            <button class='btn btn-info btn-block' id='btn_mod' name='btn_mod' onclick='modificarEmpresa(".$rs['idempresa'].");'>Editar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>";
        }
    }
}