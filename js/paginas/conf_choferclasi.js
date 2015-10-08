$(document).ready(function () {
    cargarChoferes();       //tabla de choferes
    cargarClasificacion();  //tabla de clasificaciones
    ComboClasificacion();   //combo que contiene las clasificaciones
    ComboTipo();            //combo con tipos de vehiculos
    ComboVehiculo(0); // combo con vehiculos
    $("#addchofer_tipo_vehiculo").change(function () {
        ComboVehiculo($(this).val(), 0);
    });
    $("#showchofer_tipo_vehiculo").change(function () {
        ComboVehiculo($(this).val(), 0);
    });
    //verificar rut
    $('#addchofer_rut').Rut({
        on_error: function ()
        {
            $("#addchofer_rut").val("");
            $("#rut_grupo").addClass("has-error");
            $("#addchofer_rut").focus();
            $("#addchofer_rut").attr("placeholder", "Error! Rut Incorrecto");
        }
        ,
        format_on: 'keyup'
        ,
        on_success: function ()
        {
            $("#rut_grupo").removeClass("has-error");
            $("#rut_grupo").addClass("has-success");
        }
    });
});

function recargarChoferes() {
    $('#listado_chofer').dataTable().fnDestroy();
    cargarChoferes();
}
function recargarClasificacion() {
    $('#listado_clasificacion').dataTable().fnDestroy();
    cargarClasificacion();
}

function ComboTipo() {
    $.ajax({
        url: "../conection/tr_planilla.php",
        type: "POST",
        data: 'combo_tipo=1',
        success: function (opciones) {
            $("#addchofer_tipo_vehiculo").html(opciones);
            $("#showchofer_tipo_vehiculo").html(opciones);
        }
    });
}

function ComboVehiculo(tipo, select) {
    $.ajax({
        url: "../conection/conf_choferclasi.php",
        type: "POST",
        data: 'combo_vehi=1&tipo_vehi=' + tipo + '&select=' + select,
        success: function (opciones) {
            $("#addchofer_vehiculo").html(opciones);
            $("#showchofer_vehiculo").html(opciones);
        }
    });
}

function cargarChoferes() {
    $('#listado_chofer').dataTable({
        "ajax": "../conection/conf_choferclasi.php?listado_chofer=1",
        "columns": [
            {"data": "codigo"},
            {"data": "nombre"},
            {"data": "clasificacion"},
            {"data": "vehiculo"},
            {"data": "detalle"}
        ],
        "pageLength": 7,
        "bPaginate": true,
        "bFilter": true,
        "bSort": true,
        "language": {
            "url": "../js/dataTable_es.txt"
        }
    });
}

function cargarClasificacion() {
    $('#listado_clasificacion').dataTable({
        "ajax": "../conection/conf_choferclasi.php?clasificacion=1",
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

$('#btn_mod_show').click(function () {
    $('#showchofer_clasificacion').removeAttr('disabled');
    $('#showchofer_tipo_vehiculo').removeAttr('disabled');
    $('#showchofer_vehiculo').removeAttr('disabled');
    $('#showchofer_nombre').removeAttr('readonly');
    $('#btn_mod_show').attr('disabled', 'yes');
    $('#btn_reg_show').removeAttr('disabled');
});

function detalleChofer(idchofer) {
    $.ajax({
        dataType: "json",
        url: "../conection/conf_choferclasi.php",
        type: "POST",
        data: 'extraerChofer=' + idchofer,
        success: function (r) {
            if (r) {
                $('#showchofer_id').val(r.idchofer);
                $('#showchofer_rut').val(r.rut);
                $('#showchofer_nombre').val(r.nombre);
                $('#showchofer_codigo').val(r.codigo);
                $('#showchofer_clasificacion').val(r.clasificacion);
                $('#showchofer_tipo_vehiculo').val(r.tipo_vehiculo);
                ComboVehiculo(r.tipo_vehiculo, r.vehiculo);
            } else {

            }
        }
    });
    $('#showchofer_nombre').attr('readonly', 'yes');
    $('#showchofer_clasificacion').attr('disabled', 'yes');
    $('#showchofer_tipo_vehiculo').attr('disabled', 'yes');
    $('#showchofer_vehiculo').attr('disabled', 'yes');
    $('#modal_showchofer').modal('show');
    $('#btn_mod_show').removeAttr('disabled');
    $('#btn_reg_show').attr('disabled', 'yes');
    $('#btn_del_conf').hide();
    $('#btn_del').removeAttr('disabled');
    $('#clasificacion_grupo_show').removeClass("has-error");
    $('#vehiculo_grupo_show').removeClass("has-error");
    $('#nombre_grupo_show').removeClass("has-error");

}

function showaddChofer() {
    $('#addchofer_rut').val("");
    $('#rut_grupo').removeClass("has-error");
    $('#addchofer_rut').attr('placeholder', 'Rut del chofer');

    $('#addchofer_codigo').val("");
    $('#codigo_grupo').removeClass("has-error");
    $('#addchofer_codigo').attr('placeholder', 'codigo para identificar');

    $('#addchofer_nombre').val("");
    $('#nombre_grupo').removeClass("has-error");
    $('#addchofer_nombre').attr('placeholder', 'Nombre del chofer');

    $('#clasificacion_grupo').removeClass("has-error");
    $('#vehiculo_grupo').removeClass("has-error");

    //$('#btn_mod_show').attr('disabled');
    //$('#btn_reg_show').removeAttr('disabled');
    ComboClasificacion();
    ComboVehiculo(0, 0);

    $('#modal_addchofer').modal('show');
}

function ComboClasificacion() {
    
    $.ajax({
        url: "../conection/conf_choferclasi.php?clasifi=1",
        type: "POST",
        data: 'clasificacion_combo',
        success: function (opciones) {
            $("#addchofer_clasificacion").html(opciones);
            $("#showchofer_clasificacion").html(opciones);
        }
    });
}

$('#btn_del').click(function () {
    $('#btn_del_conf').show();
    $('#btn_del').attr('disabled', 'yes');
});
//// actualizacion
function updateChofer() {
    var idchofer = $('#showchofer_id').val();
    var nombre = false;
    var clasi = false;
    var vehi = false;
    var txt_nombre = $('#showchofer_nombre').val();
    var clasificacion = $('#showchofer_clasificacion').val();
    var vehiculo = $('#showchofer_vehiculo').val();
    if (!txt_nombre) {
        nombre = false;
        $('#nombre_grupo_show').addClass("has-error");
        $('#showchofer_nombre').val("");
        $('#showchofer_nombre').attr('placeholder', 'Falta Nombre');
    } else {
        nombre = true;
        $('#nombre_grupo_show').removeClass("has-error");
        $('#showchofer_nombre').attr('placeholder', 'Nombre del chofer');
    }
    if (clasificacion == 0) {
        clasi = false;
        $('#clasificacion_grupo_show').addClass("has-error");
    } else {
        clasi = true;
        $('#clasificacion_grupo_show').removeClass("has-error");
    }
    if (vehiculo == 0) {
        vehi = false;
        $('#vehiculo_grupo_show').addClass("has-error");
    } else {
        vehi = true;
        $('#vehiculo_grupo_show').removeClass("has-error");
    }
    if (nombre && clasi && vehi) {
        var parametros = {
            id: idchofer,
            nombre: txt_nombre,
            clasificacion: clasificacion,
            vehiculo: vehiculo
        };

        request = $.ajax({
            url: "../conection/ajax/ajax_upchofer.php",
            type: "POST",
            data: parametros
        });

        request.done(function (response, textStatus, jqXHR) {
            $('#modal_showchofer').modal('hide');
            $('#modal_choferMensaje').modal('show');
            if (response === "correcto") {
                recargarChoferes();
                $('#modal_mensaje_titulo').html('Actualizado!');
                $('#modal_mensaje_msg').html('El chofer ha sido actualizado correctamente..');
            } else {
                $('#modal_mensaje_titulo').html('Error');
                $('#modal_mensaje_msg').html('Error al procesar la informacion ...');
            }
        });
    }
}
//// registro
function registrarChofer() {
    var rut = false;
    var codigo = false;
    var nombre = false;
    var clasi = false;
    var vehi = false;
    var txt_rut = $('#addchofer_rut').val();
    var txt_codigo = $('#addchofer_codigo').val();
    var txt_nombre = $('#addchofer_nombre').val();
    var clasificacion = $('#addchofer_clasificacion').val();
    var vehiculo = $('#addchofer_vehiculo').val();

    if (!txt_rut) {
        rut = false;
        $('#rut_grupo').addClass("has-error");
        $('#addchofer_rut').val("");
        $('#addchofer_rut').attr('placeholder', 'Falta rut');
    } else {
        rut = true;
        $('#rut_grupo').removeClass("has-error");
        $('#addchofer_rut').attr('placeholder', 'Rut del chofer');
    }

    if (!txt_codigo) {
        codigo = false;
        $('#codigo_grupo').addClass("has-error");
        $('#addchofer_codigo').val("");
        $('#addchofer_codigo').attr('placeholder', 'Falta Codigo');
    } else {
        codigo = true;
        $('#codigo_grupo').removeClass("has-error");
        $('#addchofer_codigo').attr('placeholder', 'codigo para identificar');
    }

    if (!txt_nombre) {
        nombre = false;
        $('#nombre_grupo').addClass("has-error");
        $('#addchofer_nombre').val("");
        $('#addchofer_nombre').attr('placeholder', 'Falta Nombre');
    } else {
        nombre = true;
        $('#nombre_grupo').removeClass("has-error");
        $('#addchofer_nombre').attr('placeholder', 'Nombre del chofer');
    }
    if (clasificacion == 0) {
        clasi = false;
        $('#clasificacion_grupo').addClass("has-error");
    } else {
        clasi = true;
        $('#clasificacion_grupo').removeClass("has-error");
    }
    if (vehiculo == 0) {
        vehi = false;
        $('#vehiculo_grupo').addClass("has-error");
    } else {
        vehi = true;
        $('#vehiculo_grupo').removeClass("has-error");
    }

    if (rut && codigo && nombre && clasi && vehi) {
        var parametros = {
            rut: txt_rut,
            nombre: txt_nombre,
            codigo: txt_codigo,
            clasificacion: clasificacion,
            vehiculo: vehiculo
        };

        request = $.ajax({
            url: "../conection/ajax/ajax_addchofer.php",
            type: "POST",
            data: parametros
        });

        request.done(function (response, textStatus, jqXHR) {
            $('#modal_addchofer').modal('hide');
            $('#modal_choferMensaje').modal('show');
            if (response === "correcto") {
                recargarChoferes();
                $('#modal_mensaje_titulo').html('Agregado!');
                $('#modal_mensaje_msg').html('El chofer ha sido correctamente agregado.');
            } else {
                $('#modal_mensaje_titulo').html('Error');
                $('#modal_mensaje_msg').html('Error al procesar la informacion ...');
            }
        });
    }
}
$('#addchofer_rut').focusout(function () {
    var rutUsuario = $('#addchofer_rut').val();
    $.ajax({
        dataType: "json",
        url: "../conection/conf_choferclasi.php",
        type: "POST",
        data: 'verificar_rut=' + rutUsuario,
        success: function (r) {
            if (r.contador == 1) {
                $('#rut_grupo').addClass("has-error");
                $('#addchofer_rut').val("");
                $('#addchofer_rut').attr('placeholder', 'Este rut ya existe');
                $('#addchofer_rut').focus();
            } else {
                $('#rut_grupo').removeClass("has-error");
                $('#addchofer_rut').attr('placeholder', 'Rut del chofer');
            }
        }
    });
});
$('#addchofer_codigo').focusout(function () {
    $.ajax({
        dataType: "json",
        url: "../conection/conf_choferclasi.php",
        type: "POST",
        data: 'verificar_codigo=' + $(this).val(),
        success: function (r) {
            if (r.contador == 1) {
                $('#codigo_grupo').addClass("has-error");
                $('#addchofer_codigo').val("");
                $('#addchofer_codigo').attr('placeholder', 'Este codigo ya existe');
                $('#addchofer_codigo').focus();
            } else {
                $('#codigo_grupo').removeClass("has-error");
                $('#addchofer_codigo').attr('placeholder', 'codigo para identificar');
            }
        }
    });
});


$('#btn_del_conf').click(function () {
    var idchofer = $('#showchofer_id').val();
    var parametros =
            {idchofer: idchofer};
    $.ajax({
        url: "../conection/conf_choferclasi.php?eliminar_chofer=1",
        type: "POST",
        data: parametros,
        success: function (r) {
            recargarChoferes();
            $('#modal_showchofer').modal('hide');
            $('#modal_choferMensaje').modal('show');
            if (r === "correcto") {
                $('#modal_mensaje_titulo').html('Eliminado!');
                $('#modal_mensaje_msg').html('El chofer ha sido eliminado pero sus datos persisten.');
            } else {
                $('#modal_mensaje_titulo').html('Error');
                $('#modal_mensaje_msg').html('Error al procesar la informacion ...');
            }
        }
    });
});


function agregarClasificacion() {
    $('#modal_addClasificacion').modal('show');
}

function addClasificacion(clasificacion) {
    var parametros =
            {clasificacion: clasificacion};
    $.ajax({
        url: "../conection/ajax/ajax_addClasificacion.php",
        type: "POST",
        data: parametros,
        success: function (r) {
            recargarClasificacion();
            $('#modal_addClasificacion').modal('hide');
        }
    });
}

function eliminarClasificacion(clasificacion){
    $('#modal_deleteClasificacion').modal('show');    
    $('#deleteclasificacion_id').val(clasificacion);    
}
function confirmarEliminarClasi(clasificacion){
    var parametros =
            {idclasificacion: clasificacion};
    $.ajax({
        url: "../conection/conf_choferclasi.php?eliminar_clasificacion=1",
        type: "POST",
        data: parametros,
        success: function (r) {
            recargarClasificacion();
            $('#modal_deleteClasificacion').modal('hide');
        }
    });
}///////////////////////////////////////////////////////////////// OK
$('#eliminar_usu').click(function () {
    $('#eliminar_usu').attr('disabled', true);
    $('#eli_confirmar').show();
});
function reCargaUsuarios() {
    $('#listado_usuarios').dataTable().fnDestroy();
    cargarUsuarios();
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
        $('#addusuario_rut').focus();
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
        $('#addusuario_usuario').focus();
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
    $('#addusuario_usuario').val("");
    $('#addusuario_nombre').val("");
    $('#addusuario_correo').val("");
    $('#addusuario_fono').val("");
    $('#addusuario_pass1').val("");
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
    $('#modusuario_usuario').val(r.usuario_login);
    $('#modusuario_nombre').val(r.usuario_nombre);
    $('#modusuario_correo').val(r.usuario_correo);
    $('#modusuario_fono').val(r.usuario_fono);
    $('#modusuario_pass1').val('temporal');
    $('#modusuario_pass2').val('temporal');
    $('#modusuario_perfil').val(r.usuario_rol_id);
    $('#modusuario_empresa').val(r.empresa_id);
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
    $('.btn-group.bootstrap-select').removeClass('disabled');
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