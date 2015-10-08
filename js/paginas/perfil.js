$(document).ready(function () {
    CargarDatosUsuario();
    $('#btn_reg').addClass("disabled");
});

function CargarDatosUsuario() {
    $.ajax({
        dataType: "json",
        url: "../conection/perfil.php",
        type: "POST",
        data: "getUsuario=1",
        success: function (r) {
            $('#perfil_rut').val(r.rut);
            $('#perfil_nombre').val(r.nombre);
            $('#perfil_usuario').val(r.login);
            $('#perfil_correo').val(r.correo);
            $('#perfil_fono').val(r.fono);
        }
    });
}

function modificarPerfil(){
            //$('#perfil_rut').removeAttr("disabled");
            $('#perfil_nombre').removeAttr("disabled");
            $('#perfil_usuario').removeAttr("disabled");
            $('#perfil_correo').removeAttr("disabled");
            $('#perfil_fono').removeAttr("disabled");
            $('#perfil_usuario').focus();
    
}
