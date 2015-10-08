$(document).ready(function () {
    $('#addusuario_rut').Rut({
        on_error: function ()
        {
            document.getElementById("addusuario_rut").value = "";
            $("#rut_grupo").addClass("has-error");
            $("#addusuario_rut").focus();
            $("#addusuario_rut").attr("placeholder", "Error! Rut Incorrecto").placeholder();
        }
        ,
        format_on: 'keyup'
        ,
        on_success: function ()
        {
            $("#addusuario_rut").removeClass("has-error");
            $("#addusuario_rut").addClass("has-success");
        }
    });
    cargarUsuarios();
    cargarPerfiles();
    $('#eli_confirmar').hide();
});
$('#eli_confirmar').click(function () {
    var idusuario = $('#modusuario_id_input').val();
    var parametros =
            {idusuario_estado: idusuario, estado: 3};
    $.ajax({
        url: "../conection/conf_usuario.php",
        type: "POST",
        data: parametros,
        success: function (r) {
            $('#modal_showUsuario').modal('hide');
            reCargaUsuarios();
            $('#modal_showUsuarioEliminado').modal('show');
        }
    });
});
function UsuarioEliminadoOK() {

}
$('#eliminar_usu').click(function () {
    $('#eliminar_usu').attr('disabled', true);
    $('#eli_confirmar').show();
});
function reCargaUsuarios() {
    $('#listado_usuarios').dataTable().fnDestroy();
    cargarUsuarios();
}
function cargarUsuarios() {
    $('#listado_usuarios').dataTable({
        "ajax": "../conection/conf_usuario.php?usuarios=1",
        "columns": [
            {"data": "usuario"},
            {"data": "nombre"},
            {"data": "perfil"},
            {"data": "detalle"},
            {"data": "estado"}
        ],
        "pageLength": 7,
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "language": {
            "url": "../js/dataTable_es.txt"
        }
    });
    // "order": [[4, "desc"]],
}
function reCargaPerfiles() {
    $('#listado_perfiles').dataTable().fnDestroy();
    cargarPerfiles();
}
function cargarPerfiles() {
    $('#listado_perfiles').dataTable({
        "ajax": "../conection/conf_usuario.php?perfiles=1",
        "columns": [
            {"data": "nombre"},
            {"data": "detalle"}
        ],
        "pageLength": 7,
        "bPaginate": false,
        "bFilter": false,
        "language": {
            "url": "../js/dataTable_es.txt"
        }
    });
}
function volver() {
    location.href = "factura_list.php";
}
function abrirModalUsuario() {
    $('#btn_reg_ok').hide();
    $('#btn_reg').show();
    $('#estado_registro').hide();
    $('#cuerpo_modal').show();
    $('#btn_reg').removeAttr('disabled');
    resetearModal();
    mostrarModal('#modal_addUsuario');
}
function mostrarModal(modal) {
    $modal = $(modal);
    $modal.modal('show');
}
$('#addusuario_rut').focusout(function () {
    var rutUsuario = $('#addusuario_rut').val();
    validarRut(rutUsuario);
});
function validarRut(rut) {
    var parametros = {
        verificar_rut: rut
    };
    if (parametros) {
        var post = $.post("../conection/conf_usuario.php", parametros, resultadoRut, 'json');
        post.error(errorRut);
    }
}
function errorRut() {
    alert("Error");
}
function resultadoRut(r) {
    if (r.contador) {
        $('#rut_grupo').addClass("has-error");
        $('#addusuario_rut').val("");
        $('#addusuario_rut').attr('placeholder', 'Rut existente');
    } else {
        $('#rut_grupo').removeClass("has-error");
        $('#addusuario_rut').attr('placeholder', 'Rut del usuario');
    }
}
// comprobar nombre de usuario
$('#addusuario_usuario').focusout(function () {
    var usuario = $('#addusuario_usuario').val().toLowerCase();
    validarUsu(usuario);
});
function validarUsu(usuario) {
    var parametros = {
        verificar_usuario: usuario
    };
    if (parametros) {
        var post = $.post("../conection/conf_usuario.php", parametros, resultadoUsuario, 'json');
        post.error(errorUsuario);
    }
}
function errorUsuario() {
    alert("Error al procesar la informacion del usuario ... contactar con el administrador");
}
function resultadoUsuario(r) {
    if (r.contador == 1) {
        $('#usuario_grupo').addClass("has-error");
        $('#addusuario_usuario').val("");
        $('#addusuario_usuario').attr('placeholder', 'Nombre de usuario existente');
    } else {
        $('#usuario_grupo').removeClass("has-error");
        $('#addusuario_usuario').attr('placeholder', 'Nombre del usuario');
    }
}
$('#addusuario_correo').focusout(function () {
    var largo = $("#addusuario_correo").val().length;
    var correo = $('#addusuario_correo').val();
    if (largo > 5) {
        var re = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/;
        if (!re.exec(correo)) {
            $('#correo_grupo').addClass("has-error");
            $('#addusuario_correo').val("");
            $('#addusuario_correo').attr('placeholder', 'correo no valido');
            $('#addusuario_correo').focus();
        } else {
            $('#correo_grupo').removeClass("has-error");
            $('#addusuario_correo').attr('placeholder', 'ejemplo@gmail.com');
        }
    }
});
function resetearModal() {
    $('#addusuario_rut').val("");
    $('#rut_grupo').removeClass("has-error");

    $('#addusuario_usuario').val("");
    $('#usuario_grupo').removeClass("has-error");

    $('#addusuario_nombre').val("");
    $('#usuario_nombre_grupo').removeClass("has-error");

    $('#addusuario_correo').val("");
    $('#correo_grupo').removeClass("has-error");

    $('#addusuario_fono').val("");
    $('#fono_grupo').removeClass("has-error");

    $('#addusuario_pass1').val("");
    $('#pass1_grupo').removeClass("has-error");

    $('#addusuario_pass2').val("");
    $('#pass2_grupo').removeClass("has-error");

    $('#perfil_grupo').removeClass("has-error");
    $('#empresa_grupo').removeClass("has-error");
}
function detalleUsuario(idusuario) {
    /////
    $('#eli_confirmar').hide();
    $('#eliminar_usu').attr('disabled', false);
    $('#btn_reg_mod').attr('disabled', false);
    $('#btn_reg_save').attr('disabled', true);
    llenarComboEmpresasUsuario(idusuario);
    llenarComboEmpresas(idusuario);
    disabledUsuario();
    var parametros = {idusuario_detalle: idusuario};
    if (parametros) {
        var post = $.post("../conection/conf_usuario.php", parametros, abrirDetalleUsuario, 'json');
        post.error(errorUsuario);
    }
    listadoEmpUsuario(idusuario);
    mostrarModal('#modal_showUsuario');
}
function llenarComboEmpresas(idusuario) {
    $.ajax({
        url: "../conection/conf_usuario.php",
        type: "POST",
        data: "idusuario_empresas=" + idusuario,
        success: function (opciones) {
            $("#usuario_empresa_add").html(opciones);
        }
    });
}
function llenarComboEmpresasUsuario(idusuario) {
    var idtemp = $('#modusuario_empresa').val();
    $.ajax({
        url: "../conection/conf_usuario.php",
        type: "POST",
        data: "idusuario_empresas_defecto=" + idusuario,
        success: function (opciones) {
            $("#modusuario_empresa").html(opciones);
            $('#modusuario_empresa').val(idtemp);
        }
    });
}
function listadoEmpUsuario(idusuario) {
    //// funcion para obtener empresas del usuario
    $('#empresas_usuario').dataTable().fnDestroy();
    $('#empresas_usuario').dataTable({
        "ajax": "../conection/conf_usuario.php?usuario_empresa=" + idusuario,
        "columns": [
            {"data": "defecto"},
            {"data": "nombre"},
            {"data": "eliminar"}
        ],
        "order": [[0, "desc"]],
        "pageLength": 5,
        "bLengthChange": false,
        "bPaginate": true,
        "bFilter": false,
        "bSort": true,
        "language": {
            "url": "../js/dataTable_es.txt"
        }
    });
}
function abrirDetalleUsuario(r) {
    $('#modusuario_id_input').val(r.idusuario);
    $('#modusuario_id').html(r.idusuario);

    $('#modusuario_rut').val(r.usuario_rut);
    $('#modrut_grupo').removeClass("has-error");

    $('#modusuario_usuario').val(r.usuario_login);
    $('#modusuario_grupo').removeClass("has-error");

    $('#modusuario_nombre').val(r.usuario_nombre);
    $('#modnombre_grupo').removeClass("has-error");

    $('#modusuario_correo').val(r.usuario_correo);
    $('#modcorreo_grupo').removeClass("has-error");

    $('#modusuario_fono').val(r.usuario_fono);
    $('#modfono_grupo').removeClass("has-error");

    $('#modusuario_pass1').val('');
    $('#modpass1_grupo').removeClass("has-error");

    $('#modusuario_pass2').val('');
    $('#modpass2_grupo').removeClass("has-error");
    $('#modusuario_pass1').attr('placeholder', 'Contraseña');
    $('#modusuario_pass2').attr('placeholder', 'Repetir contraseña');

    $('#modusuario_perfil').val(r.usuario_rol_id);
    $('#modperfil_grupo').removeClass("has-error");

    $('#modusuario_empresa').val(r.empresa_id);
    $('#modempresa_grupo').removeClass("has-error");

    if (r.usuario_estado == 1) {
        $('#modusuario_estado').bootstrapToggle('on');
    } else if (r.usuario_estado == 2) {
        $('#modusuario_estado').bootstrapToggle('off');
    }
}
function modificarUsuario() {
    $('#btn_reg_mod').attr('disabled', true);
    $('#btn_reg_save').attr('disabled', false);
    $('#modusuario_rut').removeAttr('readonly');
    $('#modusuario_usuario').removeAttr('readonly');
    $('#modusuario_nombre').removeAttr('readonly');
    $('#modusuario_correo').removeAttr('readonly');
    $('#modusuario_fono').removeAttr('readonly');
    $('#modusuario_pass1').removeAttr('readonly');
    $('#modusuario_pass2').removeAttr('readonly');
    $('#modusuario_perfil').removeAttr('disabled');
    $('#modusuario_empresa').removeAttr('disabled');
    $('.btn-group.bootstrap-select').removeAttr('disabled');
    //$('.btn.dropdown-toggle').removeClass('disabled');
}
function disabledUsuario() {
    $('#modusuario_rut').attr('readonly', true);
    $('#modusuario_usuario').attr('readonly', true);
    $('#modusuario_nombre').attr('readonly', true);
    $('#modusuario_correo').attr('readonly', true);
    $('#modusuario_fono').attr('readonly', true);
    $('#modusuario_pass1').attr('readonly', true);
    $('#modusuario_pass2').attr('readonly', true);
    $('#modusuario_perfil').attr('disabled', true);
    $('#modusuario_empresa').attr('disabled', true);
    $('.btn-group.bootstrap-select').addClass('disabled');
    //$('.btn.dropdown-toggle').addClass('disabled', true);
}
$(function () {

    $('#modusuario_estado').change(function () {
        var idusuario = $('#modusuario_id_input').val();
        var estado = $(this).prop('checked');
        if (estado == true) {
            estado = 1;
        } else {
            estado = 2;
        }
        var parametros =
                {idusuario_estado: idusuario, estado: estado};
        $.ajax({
            url: "../conection/conf_usuario.php",
            type: "POST",
            data: parametros,
            success: function (r) {
                reCargaUsuarios();
            }
        });
    });
});
function detallePerfil(rol) {
    mostrarModal('#modal_showRol');
}
function guardarUsuario() {
    
    var u_pass = false;
    var idusuario = false;
    var u_rut = false;
    var u_usuario = false;
    var u_nombre = false;
    var u_correo = false;
    var u_perfil = false;
    var u_empresa = false;
    var u_pass1 = false;
    var u_pass2 = false;
    var txt_idusuario = $('#modusuario_id_input').val();
    var usuario_rut = $('#modusuario_rut').val();
    var usuario_usuario = $('#modusuario_usuario').val();
    var usuario_nombre = $('#modusuario_nombre').val();
    var usuario_correo = $('#modusuario_correo').val();
    var usuario_perfil = $('#modusuario_perfil').val();
    var usuario_empresa = $('#modusuario_empresa').val();
    var usuario_fono = $('#modusuario_fono').val();
    var usuario_pass1 = $('#modusuario_pass1').val();
    var usuario_pass2 = $('#modusuario_pass2').val();
    //validar ingreso de rut 
    if (!usuario_rut) {
        u_rut = false;
        $('#modrut_grupo').addClass("has-error");
        $('#modusuario_rut').val("");
        $('#modusuario_rut').attr('placeholder', 'Falta rut');
    } else {
        u_rut = true;
        $('#modrut_grupo').removeClass("has-error");
        $('#modusuario_rut').attr('placeholder', 'Rut del usuario');
    }
    //validar nombre del usuario
    if (!usuario_nombre) {
        u_nombre = false;
        $('#modusuario_nombre_grupo').addClass("has-error");
        $('#modusuario_nombre').val("");
        $('#modusuario_nombre').attr('placeholder', 'Falta nombre');
    } else {
        u_nombre = true;
        $('#modusuario_nombre_grupo').removeClass("has-error");
        $('#modusuario_nombre').attr('placeholder', 'Nombre del usuario');
    }
    //validar nombre de login
    if (!usuario_usuario) {
        u_usuario = false;
        $('#modusuario_grupo').addClass("has-error");
        $('#modusuario_usuario').val("");
        $('#modusuario_usuario').attr('placeholder', 'Falta nombre');
    } else {
        u_usuario = true;
        $('#modusuario_nombre_grupo').removeClass("has-error");
        $('#modusuario_nombre').attr('placeholder', 'Nombre del usuario');
    }
    //validar correo
    if (!usuario_correo) {
        u_correo = false;
        $('#modcorreo_grupo').addClass("has-error");
        $('#modusuario_correo').val("");
        $('#modusuario_correo').attr('placeholder', 'Falta correo');
    } else {
        u_correo = true;
        $('#modcorreo_grupo').removeClass("has-error");
        $('#modusuario_correo').attr('placeholder', 'ejmplo@gmail.com');
    }
    //validar pass 1
    if (usuario_pass1 || usuario_pass2) {
        u_pass = false;
        if (!usuario_pass1) {
            u_pass1 = false;
            $('#modpass1_grupo').addClass("has-error");
            $('#modusuario_pass1').val("");
            $('#modusuario_pass1').attr('placeholder', 'Falta contraseña');
        } else {
            u_pass1 = true;
            $('#modpass1_grupo').removeClass("has-error");
            $('#modusuario_pass1').attr('placeholder', 'Contraseña');
        }
        //validar pass 2
        if (!usuario_pass1) {
            u_pass2 = false;
            usuario_pass1 = "";
            $('#modpass2_grupo').addClass("has-error");
            $('#modusuario_pass2').val("");
            $('#modusuario_pass2').attr('placeholder', 'Falta contraseña');
        } else {
            u_pass2 = true;
            $('#modpass2_grupo').removeClass("has-error");
            $('#modusuario_pass2').attr('placeholder', 'Repetir contraseña');
        }

        if (u_pass1 && u_pass2) {
            var contra1 = hex_md5(usuario_pass1);
            var contra2 = hex_md5(usuario_pass2);
            if (contra1 === contra2) {
                u_pass = true;
                $('#modpass1_grupo').removeClass("has-error");
                $('#modpass2_grupo').removeClass("has-error");
                $('#modusuario_pass1').attr('placeholder', '');
                $('#modusuario_pass2').attr('placeholder', '');

            } else {
                u_pass = false;
                $('#modpass1_grupo').addClass("has-error");
                $('#modpass2_grupo').addClass("has-error");
                $('#modusuario_pass1').val("");
                $('#modusuario_pass2').val("");
                $('#modusuario_pass1').attr('placeholder', 'Contraseña Incorrecta');
                $('#modusuario_pass2').attr('placeholder', 'Contraseña Incorrecta');
            }
        }
    } else {
        u_pass = true;
        $('#modpass1_grupo').removeClass("has-error");
        $('#modpass2_grupo').removeClass("has-error");
        $('#modusuario_pass1').attr('placeholder', 'Contraseña');
        $('#modusuario_pass2').attr('placeholder', 'Repetir contraseña');

    }
    //validar perfil
    if (usuario_perfil == 0) {
        u_perfil = false;
        $('#modperfil_grupo').addClass("has-error");
    } else {
        u_perfil = true;
        $('#modperfil_grupo').removeClass("has-error");
    }
    //validar empresa
    if (usuario_empresa == 0) {
        u_empresa = false;
        $('#modempresa_grupo').addClass("has-error");
    } else {
        u_empresa = true;
        $('#modempresa_grupo').removeClass("has-error");
    }



    if (u_rut && u_usuario && u_nombre && u_correo && u_perfil && u_pass && u_empresa) {
        var datos = {
            idusuario: txt_idusuario,
            rut: usuario_rut,
            usuario: usuario_usuario,
            nombre: usuario_nombre,
            correo: usuario_correo,
            perfil: usuario_perfil,
            empresa: usuario_empresa,
            fono: usuario_fono,
            pass: usuario_pass1
        };
        $.ajax({
            url: "../conection/ajax/ajax_upusuario.php",
            type: "POST",
            data: datos,
            success: function () {
                listadoEmpUsuario(txt_idusuario);
                $('#btn_reg_mod').attr('disabled', false);
                $('#btn_reg_save').attr('disabled', true);
                $('#modusuario_rut').attr('readonly', 'yes');
                $('#modusuario_usuario').attr('readonly', 'yes');
                $('#modusuario_nombre').attr('readonly', 'yes');
                $('#modusuario_correo').attr('readonly', 'yes');
                $('#modusuario_fono').attr('readonly', 'yes');
                $('#modusuario_pass1').attr('readonly', 'yes');
                $('#modusuario_pass2').attr('readonly', 'yes');
                $('#modusuario_perfil').attr('readonly', 'yes');
                $('#modusuario_empresa').attr('readonly', 'yes');
                $('.btn-group.bootstrap-select').attr('disabled', 'yes');

            }
        });
    }

}