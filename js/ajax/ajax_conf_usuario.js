function registrarEmpresaUsuario() {
    var empresa = $('#usuario_empresa_add').val();
    var idusuario = $('#modusuario_id_input').val();
    if (empresa != 0) {
        var parametros =
                {usuario: idusuario, empresa: empresa};
        $.ajax({
            url: "../conection/conf_usuario.php",
            type: "POST",
            data: parametros,
            success: function (r) {
                listadoEmpUsuario(idusuario);
                llenarComboEmpresas(idusuario);
                llenarComboEmpresasUsuario(idusuario);
            }
        });

    }
}
function eliminarUsuEmp(idempresa){
    var idusuario = $('#modusuario_id_input').val();
    var parametros =
                {eli_usuario: idusuario, eli_empresa: idempresa};
        $.ajax({
            url: "../conection/conf_usuario.php",
            type: "POST",
            data: parametros,
            success: function (r) {
                listadoEmpUsuario(idusuario);
                llenarComboEmpresas(idusuario);
                llenarComboEmpresasUsuario(idusuario);
            }
        });
}
function registrarUsuario() {
    var u_rut = false;
    var u_usuario = false;
    var u_nombre = false;
    var u_correo = false;
    var u_perfil = false;
    var u_empresa = false;
    var u_pass1 = false;
    var u_pass2 = false;
    var usuario_rut = $('#addusuario_rut').val();
    var usuario_usuario = $('#addusuario_usuario').val();
    var usuario_nombre = $('#addusuario_nombre').val();
    var usuario_correo = $('#addusuario_correo').val();
    var usuario_perfil = $('#addusuario_perfil').val();
    var usuario_empresa = $('#addusuario_empresa').val();
    var usuario_fono = $('#addusuario_fono').val();
    var usuario_pass1 = $('#addusuario_pass1').val();
    var usuario_pass2 = $('#addusuario_pass2').val();
    //validar ingreso de rut 
    if (!usuario_rut) {
        u_rut = false;
        $('#rut_grupo').addClass("has-error");
        $('#addusuario_rut').val("");
        $('#addusuario_rut').attr('placeholder', 'Falta rut');
    } else {
        u_rut = true;
        $('#rut_grupo').removeClass("has-error");
        $('#addusuario_rut').attr('placeholder', 'Rut del usuario');
    }

    //validar nombre del usuario
    if (!usuario_nombre) {
        u_nombre = false;
        $('#usuario_nombre_grupo').addClass("has-error");
        $('#addusuario_nombre').val("");
        $('#addusuario_nombre').attr('placeholder', 'Falta nombre');
    } else {
        u_nombre = true;
        $('#usuario_nombre_grupo').removeClass("has-error");
        $('#addusuario_nombre').attr('placeholder', 'Nombre del usuario');
    }

    //validar nombre de login
    if (!usuario_usuario) {
        u_usuario = false;
        $('#usuario_grupo').addClass("has-error");
        $('#addusuario_usuario').val("");
        $('#addusuario_usuario').attr('placeholder', 'Falta nombre');
    } else {
        u_usuario = true;
        $('#usuario_nombre_grupo').removeClass("has-error");
        $('#addusuario_nombre').attr('placeholder', 'Nombre del usuario');
    }

    //validar correo
    if (!usuario_correo) {
        u_correo = false;
        $('#correo_grupo').addClass("has-error");
        $('#addusuario_correo').val("");
        $('#addusuario_correo').attr('placeholder', 'Falta correo');
    } else {
        u_correo = true;
        $('#correo_grupo').removeClass("has-error");
        $('#addusuario_correo').attr('placeholder', 'ejmplo@gmail.com');
    }
    //validar pass 1
    if (!usuario_pass1) {
        u_pass1 = false;
        $('#pass1_grupo').addClass("has-error");
        $('#addusuario_pass1').val("");
        $('#addusuario_pass1').attr('placeholder', 'Falta contraseña');
    } else {
        u_pass1 = true;
        $('#pass1_grupo').removeClass("has-error");
        $('#addusuario_pass1').attr('placeholder', '');
    }
    //validar pass 2
    if (!usuario_pass1) {
        u_pass2 = false;
        $('#pass2_grupo').addClass("has-error");
        $('#addusuario_pass2').val("");
        $('#addusuario_pass2').attr('placeholder', 'Falta contraseña');
    } else {
        u_pass2 = true;
        $('#pass2_grupo').removeClass("has-error");
        $('#addusuario_pass2').attr('placeholder', '');
    }

    //validar perfil
    if (usuario_perfil == 0) {
        u_perfil = false;
        $('#perfil_grupo').addClass("has-error");
    } else {
        u_perfil = true;
        $('#perfil_grupo').removeClass("has-error");
    }
    //validar empresa
    if (usuario_empresa == 0) {
        u_empresa = false;
        $('#empresa_grupo').addClass("has-error");
    } else {
        u_empresa = true;
        $('#empresa_grupo').removeClass("has-error");
    }

    var u_pass = false;
    if (u_pass1 && u_pass2) {
        var contra1 = hex_md5(usuario_pass1);
        var contra2 = hex_md5(usuario_pass2);
        if (contra1 === contra2) {
            u_pass = true;
            $('#pass1_grupo').removeClass("has-error");
            $('#pass2_grupo').removeClass("has-error");
            $('#addusuario_pass1').attr('placeholder', '');
            $('#addusuario_pass2').attr('placeholder', '');

        } else {
            u_pass = false;
            $('#pass1_grupo').addClass("has-error");
            $('#pass2_grupo').addClass("has-error");
            $('#addusuario_pass1').val("");
            $('#addusuario_pass2').val("");
            $('#addusuario_pass1').attr('placeholder', 'Contraseña Incorrecta');
            $('#addusuario_pass2').attr('placeholder', 'Contraseña Incorrecta');
        }
    }
    if (u_rut && u_usuario && u_nombre && u_correo && u_perfil && u_pass && u_empresa) {
        $('#cuerpo_modal').hide();
        $('#estado_registro').show();
        $('#btn_reg_ok').show();
        $('#btn_reg').attr('disabled', 'true');
        registroFinal();
    }

}
function registroFinal() {
    var parametros = {
        usuario_rut: $('#addusuario_rut').val(),
        usuario_usuario: $('#addusuario_usuario').val(),
        usuario_nombre: $('#addusuario_nombre').val(),
        usuario_correo: $('#addusuario_correo').val(),
        usuario_perfil: $('#addusuario_perfil').val(),
        usuario_empresa: $('#addusuario_empresa').val(),
        usuario_fono: $('#addusuario_fono').val(),
        usuario_pass: $('#addusuario_pass1').val()
    };
    if (parametros) {
        var post = $.post("../conection/ajax/ajax_addusuario.php", parametros, UsuarioError, 'json');

        $('#estado_registro').html("<div id='message' align='center'></div> \n\
                                            <br> \n\
                                          <div id='load'></div>\n\
                                             <br> \n\
                                          <div id='option'>\n\
                                          </div>");
        $('#load').html("<div class='progress'> <div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='45' aria-valuemin='0' aria-valuemax='100' style='width: 100%'> <span class='sr-only'>100% Complete</span></div>");
        $('#message').html("<h2>Espere mientras se registran los datos</h2>")
                .append("<p>Validando...</p>")
                .hide();
        post.error(UsuarioCorrecto);
    }
}
function UsuarioError() {
    $('#message').append("")
            .fadeIn(1500, function () {
                $('#message').append("<img id='checkmark' src='../imagenes/sistema/loadError.png' width='100px' />");
                $('#load').hide();
                $('#message').html("<h2>Error al ingresar los datos</h2>");
            });
}
function UsuarioCorrecto() {
    reCargaUsuarios();
    $('#message').append("")
            .fadeIn(1500, function () {
                $('#message').append("<img id='checkmark' src='../imagenes/sistema/loadOk.png' width='100px' />");
                $('#load').hide();
                $('#message').html("<h2>Usuario registrado correctamente</h2>");
            });
}
