$(document).ready(function () {
    cargarTablaClieprove($('#combo_clieprove').val());       //tabla de choferes
    ComboRegion();
    /*cargarClasificacion();  //tabla de clasificaciones
     ComboClasificacion();   //combo que contiene las clasificaciones
     ComboTipo();            //combo con tipos de vehiculos
     ComboVehiculo(0); // combo con vehiculos
     $("#addchofer_tipo_vehiculo").change(function () {
     ComboVehiculo($(this).val(), 0);
     });
     $("#showchofer_tipo_vehiculo").change(function () {
     ComboVehiculo($(this).val(), 0);
     });*/
    //verificar rut
    $('#addclieprove_rut').Rut({
        on_error: function ()
        {
            $("#addclieprove_rut").val("");
            $("#rut_grupo").addClass("has-error");
            $("#addclieprove_rut").focus();
            $("#addclieprove_rut").attr("placeholder", "Error! Rut Incorrecto");
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
    $('#showclieprove_rut').Rut({
        on_error: function ()
        {
            $("#showclieprove_rut").val("");
            $("#rut_grupo").addClass("has-error");
            $("#showclieprove_rut").focus();
            $("#showclieprove_rut").attr("placeholder", "Error! Rut Incorrecto");
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
$('#addclieprove_rut').focusout(function () {
    $.ajax({
        dataType: "json",
        url: "../conection/conf_clieprove.php",
        type: "POST",
        data: 'verificar_rut=' + $(this).val(),
        success: function (r) {
            if (r.contador == 1) {
                $('#rut_grupo').addClass("has-error");
                $('#addclieprove_rut').val("");
                $('#addclieprove_rut').attr('placeholder', 'Este rut ya existe');
                $('#addclieprove_rut').focus();
            } else {
                $('#rut_grupo').removeClass("has-error");
                $('#addclieprove_rut').attr('placeholder', 'Rut');
            }
        }
    });
});
$('#showclieprove_rut').focusout(function () {
    var rut_actual = $('#showclieprove_rut_bak').val();
    if ($('#showclieprove_rut').val() !== rut_actual) {
        $.ajax({
            dataType: "json",
            url: "../conection/conf_clieprove.php",
            type: "POST",
            data: 'verificar_rut=' + $(this).val(),
            success: function (r) {
                if (r.contador == 1) {
                    $('#rut_grupo').addClass("has-error");
                    $('#showclieprove_rut').val("");
                    $('#swhoclieprove_rut').attr('placeholder', 'Este rut ya existe');
                    $('#showclieprove_rut').focus();
                } else {
                    $('#rut_grupo').removeClass("has-error");
                    $('#showclieprove_rut').attr('placeholder', 'Rut');
                }
            }
        });
    }
});
$('#combo_clieprove').change(function () {
    recargarTablaclieprove();
});
$('#addclieprove_region').change(function () {
    ComboProvincia($(this).val());
    $('#addclieprove_comuna').html('');
});
$('#showclieprove_region').change(function () {
    ComboProvincia($(this).val());
    $('#showclieprove_comuna').html('');
});
$('#addclieprove_provincia').change(function () {
    ComboComuna($(this).val());
});
$('#showclieprove_provincia').change(function () {
    ComboComuna($(this).val());
});
$('#btn_mod_show').click(function () {
    $('#showclieprove_rut').focus();
    $('#showclieprove_rut').removeAttr('readonly');
    $('#showclieprove_nombre').removeAttr('readonly');
    $('#showclieprove_direccion').removeAttr('readonly');
    $('#showclieprove_fono').removeAttr('readonly');
    $('#showclieprove_giro').removeAttr('readonly');
    $('#showclieprove_region').removeAttr('disabled');
    $('#showclieprove_provincia').removeAttr('disabled');
    $('#showclieprove_comuna').removeAttr('disabled');
    $('#btn_mod_show').attr('disabled', 'yes');
    $('#btn_reg_show').removeAttr('disabled');
});
$('#btn_save').click(function () {
    updateChofer();
});
function recargarTablaclieprove() {
    $('#listado_clieprove').dataTable().fnDestroy();
    cargarTablaClieprove($('#combo_clieprove').val());
}
function ComboRegion() {
    $.ajax({
        url: "../conection/conf_clieprove.php",
        type: "POST",
        data: 'combo_region=1',
        success: function (opciones) {
            $("#addclieprove_region").html(opciones);
            $("#showclieprove_region").html(opciones);
        }
    });
}
function ComboEmpresas(idclieprove) {
    $.ajax({
        url: "../conection/conf_clieprove.php",
        type: "POST",
        data: 'combo_empresas=' + idclieprove,
        success: function (opciones) {
            $("#clieprove_empresa_show").html(opciones);
        }
    });
}
function ComboProvincia(region) {
    $.ajax({
        url: "../conection/conf_clieprove.php",
        type: "POST",
        data: 'combo_provincia=' + region,
        success: function (opciones) {
            $("#addclieprove_provincia").html(opciones);
            $("#showclieprove_provincia").html(opciones);
        }
    });
}
function ComboProvinciaShow(region, select) {
    $.ajax({
        url: "../conection/conf_clieprove.php",
        type: "POST",
        data: {combo_provinciashow: region, select: select},
        success: function (opciones) {
            $("#showclieprove_provincia").html(opciones);
        }
    });
}
function ComboComuna(provincia) {
    $.ajax({
        url: "../conection/conf_clieprove.php",
        type: "POST",
        data: 'combo_comuna=' + provincia,
        success: function (opciones) {
            $("#addclieprove_comuna").html(opciones);
            $("#showclieprove_comuna").html(opciones);
        }
    });
}
function ComboComunashow(provincia, select) {
    $.ajax({
        url: "../conection/conf_clieprove.php",
        type: "POST",
        data: {combo_comunashow: provincia, select: select},
        success: function (opciones) {
            $("#showclieprove_comuna").html(opciones);
        }
    });
}
function cargarTablaClieprove(op) {
    $('#listado_clieprove').dataTable({
        "ajax": "../conection/conf_clieprove.php?clieprove=" + op,
        "columns": [
            {"data": "rut"},
            {"data": "nombre"},
            {"data": "comuna"},
            {"data": "fono"},
            {"data": "giro"},
            {"data": "detalle"}
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": true,
        "language": {
            "url": "../js/dataTable_es.txt"
        }
    });
}
function resetearModal() {
    $('#addclieprove_rut').val("");
    $('#addclieprove_nombre').val("");
    $('#addclieprove_direccion').val("");
    $('#addclieprove_giro').val("");
    $('#addclieprove_fono').val("");
    $('#addclieprove_comuna').val(0);
}
function registrarClieprove() {
    var rut = false;
    var nombre = false;
    var direccion = false;
    var giro = false;
    var comuna = false;
    var tipo = $('#addclieprove_tipo').val();
    var txt_rut = $('#addclieprove_rut').val();
    var txt_nombre = $('#addclieprove_nombre').val();
    var txt_direccion = $('#addclieprove_direccion').val();
    var txt_giro = $('#addclieprove_giro').val();
    var txt_fono = $('#addclieprove_fono').val();
    var txt_comuna = $('#addclieprove_comuna').val();

    if (!txt_rut) {
        rut = false;
        $('#rut_grupo').addClass("has-error");
        $('#addclieprove_rut').val("");
        $('#addclieprove_rut').attr('placeholder', 'Falta rut');
    } else {
        rut = true;
        $('#rut_grupo').removeClass("has-error");
        $('#addclieprove_rut').attr('placeholder', 'Rut');
    }

    if (!txt_nombre) {
        nombre = false;
        $('#nombre_grupo').addClass("has-error");
        $('#addclieprove_nombre').val("");
        $('#addclieprove_nombre').attr('placeholder', 'Falta Nombre');
    } else {
        nombre = true;
        $('#nombre_grupo').removeClass("has-error");
        $('#addclieprove_nombre').attr('placeholder', 'Nombre');
    }

    if (!txt_direccion) {
        direccion = false;
        $('#direccion_grupo').addClass("has-error");
        $('#addclieprove_direccion').val("");
        $('#addclieprove_direccion').attr('placeholder', 'Falta Direccion');
    } else {
        direccion = true;
        $('#direccion_grupo').removeClass("has-error");
        $('#addclieprove_direccion').attr('placeholder', 'Direccion');
    }
    if (!txt_giro) {
        giro = false;
        $('#giro_grupo').addClass("has-error");
        $('#addclieprove_giro').val("");
        $('#addclieprove_giro').attr('placeholder', 'Falta giro');
    } else {
        giro = true;
        $('#giro_grupo').removeClass("has-error");
        $('#addclieprove_giro').attr('placeholder', 'Giro');
    }
    if (!txt_comuna) {
        comuna = false;
        $('#comuna_grupo').addClass("has-error");
    } else {
        comuna = true;
        $('#comuna_grupo').removeClass("has-error");
    }

    if (tipo && rut && nombre && direccion && comuna && giro) {
        var parametros = {
            tipo: tipo,
            rut: txt_rut,
            nombre: txt_nombre,
            direccion: txt_direccion,
            giro: txt_giro,
            fono: txt_fono,
            comuna: txt_comuna
        };

        request = $.ajax({
            url: "../conection/ajax/ajax_addclieprove.php",
            type: "POST",
            data: parametros
        });

        request.done(function (response, textStatus, jqXHR) {
            $('#modal_addclieprove').modal('hide');
            $('#modal_clieproveMensaje').modal('show');
            if (response === "correcto") {
                recargarTablaclieprove();
                $('#modal_mensaje_titulo').html('Agregado!');
                $('#modal_mensaje_msg').html('Agregado Correctamente!!');
            } else {
                $('#modal_mensaje_titulo').html('Error');
                $('#modal_mensaje_msg').html('Error al procesar la informacion ...');
            }
        });
    }
}
function volver() {
    location.href = "factura_list.php";
}
function addClieprove() {
    $('#btn_reg_ok').hide();
    $('#btn_reg').show();
    $('#estado_registro').hide();
    $('#cuerpo_modal').show();
    $('#btn_reg').removeAttr('disabled');
    //resetearModal();
    resetearModal();
    $('#modal_addclieprove').modal('show');
}
function detalleClieprove(idclieprove) {
    $.ajax({
        dataType: "json",
        url: "../conection/conf_clieprove.php",
        type: "POST",
        data: 'extraerClieprove=' + idclieprove,
        success: function (r) {
            if (r) {
                ComboEmpresas(r.id);
                cargarEmpClieprove(r.id);
                $('#showclieprove_region').val(r.region_id);
                ComboProvincia(r.region_id);
                ComboProvinciaShow(r.region_id, r.provincia_id);
                ComboComunashow(r.provincia_id, r.comuna_id);
                $('#showclieprove_id').val(r.id);
                $('#showclieprove_rut_bak').val(r.rut);
                $('#showclieprove_rut').val(r.rut);
                $('#showclieprove_nombre').val(r.nombre);
                $('#showclieprove_direccion').val(r.direccion);
                $('#showclieprove_giro').val(r.giro);
                $('#showclieprove_fono').val(r.fono);
                $('#showclieprove_tipo').val(r.tipo);
            } else {
                $('#showclieprove_rut').val('error');
                $('#showclieprove_nombre').val('error');
                $('#showclieprove_direccion').val('error');
                $('#showclieprove_giro').val('error');
                $('#showclieprove_fono').val('error');
            }
        }
    });

    $('#showclieprove_rut').attr('readonly', 'yes');
    $('#showclieprove_nombre').attr('readonly', 'yes');
    $('#showclieprove_direccion').attr('readonly', 'yes');
    $('#showclieprove_fono').attr('readonly', 'yes');
    $('#showclieprove_giro').attr('readonly', 'yes');
    $('#showclieprove_region').attr('disabled', 'yes');
    $('#showclieprove_provincia').attr('disabled', 'yes');
    $('#showclieprove_comuna').attr('disabled', 'yes');
    $('#btn_mod_show').removeAttr('disabled');
    $('#btn_reg_show').attr('disabled', 'yes');
    $('#btn_del_conf').hide();
    $('#btn_del').removeAttr('disabled');
    $('#nombre_grupo').removeClass("has-error");
    $('#direccion_grupo').removeClass("has-error");
    $('#giro_grupo').removeClass("has-error");
    $('#fono_grupo').removeClass("has-error");
    $('#region_grupo').removeClass("has-error");
    $('#provincia_grupo').removeClass("has-error");
    $('#comuna_grupo').removeClass("has-error");
    $('#vehiculo_grupo_show').removeClass("has-error");
    $('#nombre_grupo_show').removeClass("has-error");

    $('#modal_showclieprove').modal('show');
}
function updateClieprove() {
    var rut = false;
    var nombre = false;
    var direccion = false;
    var giro = false;
    var comuna = false;
    var tipo = $('#showclieprove_tipo').val();
    var txt_rut = $('#showclieprove_rut').val();
    var txt_nombre = $('#showclieprove_nombre').val();
    var txt_direccion = $('#showclieprove_direccion').val();
    var txt_giro = $('#showclieprove_giro').val();
    var txt_fono = $('#showclieprove_fono').val();
    var txt_comuna = $('#showclieprove_comuna').val();
    var idclieprove = $('#showclieprove_id').val();

    if (!txt_rut) {
        rut = false;
        $('#rut_grupo_show').addClass("has-error");
        $('#showclieprove_rut').val("");
        $('#showclieprove_rut').attr('placeholder', 'Falta rut');
    } else {
        rut = true;
        $('#rut_grupo_show').removeClass("has-error");
        $('#showclieprove_rut').attr('placeholder', 'Rut');
    }

    if (!txt_nombre) {
        nombre = false;
        $('#nombre_grupo_show').addClass("has-error");
        $('#showclieprove_nombre').val("");
        $('#showclieprove_nombre').attr('placeholder', 'Falta Nombre');
    } else {
        nombre = true;
        $('#nombre_grupo_show').removeClass("has-error");
        $('#showclieprove_nombre').attr('placeholder', 'Nombre');
    }

    if (!txt_direccion) {
        direccion = false;
        $('#direccion_grupo_show').addClass("has-error");
        $('#showclieprove_direccion').val("");
        $('#showclieprove_direccion').attr('placeholder', 'Falta Direccion');
    } else {
        direccion = true;
        $('#direccion_grupo_show').removeClass("has-error");
        $('#showclieprove_direccion').attr('placeholder', 'Direccion');
    }
    if (!txt_giro) {
        giro = false;
        $('#giro_grupo_show').addClass("has-error");
        $('#showclieprove_giro').val("");
        $('#showclieprove_giro').attr('placeholder', 'Falta giro');
    } else {
        giro = true;
        $('#giro_grupo_show').removeClass("has-error");
        $('#showclieprove_giro').attr('placeholder', 'Giro');
    }
    if (!txt_comuna) {
        comuna = false;
        $('#comuna_grupo_show').addClass("has-error");
    } else {
        comuna = true;
        $('#comuna_grupo_show').removeClass("has-error");
    }

    if (tipo && rut && nombre && direccion && comuna && giro) {
        var parametros = {
            id: idclieprove,
            tipo: tipo,
            rut: txt_rut,
            nombre: txt_nombre,
            direccion: txt_direccion,
            giro: txt_giro,
            fono: txt_fono,
            comuna: txt_comuna
        };

        request = $.ajax({
            url: "../conection/ajax/ajax_upclieprove.php",
            type: "POST",
            data: parametros
        });

        request.done(function (response, textStatus, jqXHR) {
            $('#modal_showclieprove').modal('hide');
            $('#modal_clieproveMensaje').modal('show');
            if (response === "correcto") {
                recargarTablaclieprove();
                $('#modal_mensaje_titulo').html('Actualizado!');
                $('#modal_mensaje_msg').html('Actuaizado Correctamente!!');
            } else {
                $('#modal_mensaje_titulo').html('Error');
                $('#modal_mensaje_msg').html('Error al procesar la informacion ...');
            }
        });
    }
}
function cargarEmpClieprove(idclieprove) {
    //// funcion para obtener empresas del usuario
    $('#empresa_clieprove').dataTable().fnDestroy();
    $('#empresa_clieprove').dataTable({
        "ajax": "../conection/conf_clieprove.php?clieprove_empresa=" + idclieprove,
        "columns": [
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
function agregarEmpresaClieprove() {
    var empresa = $('#clieprove_empresa_show').val();
    var idclieprove = $('#showclieprove_id').val();
    if (empresa != 0) {
        var parametros =
                {clieprove: idclieprove, empresa: empresa};
        $.ajax({
            url: "../conection/conf_clieprove.php",
            type: "POST",
            data: parametros,
            success: function (r) {
                ComboEmpresas(idclieprove);
                cargarEmpClieprove(idclieprove);
            }
        });

    }
}
function eliminarEmpclieprove(idempresa) {
    var idclieprove = $('#showclieprove_id').val();
    var parametros =
            {eli_clieprove: idclieprove, eli_empresa: idempresa};
    $.ajax({
        url: "../conection/conf_clieprove.php",
        type: "POST",
        data: parametros,
        success: function (r) {
            ComboEmpresas(idclieprove);
            cargarEmpClieprove(idclieprove);
        }
    });
}
function confirmareliminarUsuario() {
    var idclieprove = $('#showclieprove_id').val();
    var parametros =
            {idclieprove_estado: idclieprove, estado: 2};
    $.ajax({
        url: "../conection/conf_clieprove.php",
        type: "POST",
        data: parametros,
        success: function (r) {
            $('#modal_showclieprove').modal('hide');
            $('#modal_deleteclieprove').modal('hide');
            recargarTablaclieprove();
            $('#modal_clieproveMensaje').modal('show');
            if (r === "correcto") {
                $('#modal_mensaje_titulo').html('Eliminado Correctamente!');
                $('#modal_mensaje_msg').html('Los datos asociados al cliente/proveedor aun seran visibles.');
            } else {
                $('#modal_mensaje_titulo').html('Error');
                $('#modal_mensaje_msg').html('Error al procesar la informacion ...');
            }
        }
    });
}
function deleteClieprove() {
    $('#modal_deleteclieprove').modal('show');
}
//////////////////////////////////////////////OK

$('#btn_del').click(function () {
    $('#btn_del_conf').show();
    $('#btn_del').attr('disabled', 'yes');
});
//// actualizacion

//// registro
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

function eliminarClasificacion(clasificacion) {
    $('#modal_deleteClasificacion').modal('show');
    $('#deleteclasificacion_id').val(clasificacion);
}
function confirmarEliminarClasi(clasificacion) {
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
}
///////////////////////////////////////////////////////////////// OK
$('#eliminar_usu').click(function () {
    $('#eliminar_usu').attr('disabled', true);
    $('#eli_confirmar').show();
});
function reCargaUsuarios() {
    $('#listado_usuarios').dataTable().fnDestroy();
    cargarUsuarios();
}



$('#addusuario_rut').focusout(function () {
    var rutUsuario = $('#addusuario_rut').val();
    validarRut(rutUsuario);
});



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
    $('#modal_showRol').modal("show");;
}