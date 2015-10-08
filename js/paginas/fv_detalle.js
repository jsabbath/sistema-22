$(document).ready(function () {
    $("#btn_save").addClass("disabled");
    cargarArchivos();
    cargarFactura();
    $("#example").popover();
    $(".messages").hide();
    //queremos que esta variable sea global
    var fileExtension = "";
    //función que observa los cambios del campo file y obtiene información
    $(':file').change(function ()
    {
        //obtenemos un array con los datos del archivo
        var file = $("#imagen")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = "fv_" + file.name;

        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        $(".messages").html("").show();
        $(".messages").html("<span class='info'>peso del archivo: " + fileName + "" + fileSize + " bytes.</span>");
    });

    //al enviar el formulario
    $('#upload').click(function () {
        //información del formulario
        var formData = new FormData($(".formulario")[0]);
        var message = "";
        //hacemos la petición ajax  
        $.ajax({
            dataType: "json",
            url: '../conection/ajax/subirArchivoFventa.php',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function () {
                $(".messages").html("").show();
                $(".messages").html("<span class='before'>Subiendo el archivo, por favor espere...</span>");
                $(".showImage").html("").hide();
            },
            //una vez finalizado correctamente
            success: function (r) {
                if (r.estado == 0) {
                    $(".messages").html("").show();
                    $(".messages").html("<span class='success'>El archivo ha subido correctamente. [" + r.msg + "] </span>");
                    $(".showImage").html("").show();
                    $(".showImage").html("<img id='checkmark' src='../adj/sistema/loadOk.png' width='100px' />");
                    cargarDataTable();
                } else if (r.estado != 1) {
                    $(".messages").html("").show();
                    $(".messages").html("<span class='success'>" + r.msg + "</span>");
                    $(".showImage").html("").show();
                    $(".showImage").html("<img id='checkmark' src='../adj/sistema/loadError.png' width='100px' />");
                }
            },
            //si ha ocurrido un error
            error: function () {
                $(".messages").html("").show();
                $(".messages").html("<span class='error'>Ha ocurrido un error.</span>");
            }
        });
    });
});
var correlativo_factura;
function mascara(o, f) {
    v_obj = o;
    v_fun = f;
    setTimeout("execmascara()", 1);
}
function execmascara() {
    v_obj.value = v_fun(v_obj.value);
}
function cpf(v) {
    v = v.replace(/([^0-9]+)/g, '');
    v = v.replace(/^[\.]/, '');
    v = v.replace(/[\.][\.]/g, '');
    v = v.replace(/\.(\d)(\d)(\d)/g, '.$1$2');
    v = v.replace(/\.(\d{1,2})\./g, '.$1');
    v = v.toString().split('').reverse().join('').replace(/(\d{3})/g, '$1,');
    v = v.split('').reverse().join('').replace(/^[\,]/, '');
    return v;
}
function calcular() {
    var varMonto;
    var varIva;
    var varSubTotal;
    varMonto = document.getElementById("fact_neto").value;
    varMonto = varMonto.replace(/[\,]/g, '');

    varIva = parseFloat(varMonto).toFixed(2) * 0.19;
    document.getElementById("fact_iva").value = addCommas(parseFloat(varIva).toFixed(0));

    varSubTotal = parseFloat(varMonto) + parseFloat(varIva);
    document.getElementById("fact_total").value = addCommas(parseFloat(varSubTotal).toFixed(0));
}
function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
function extraerFactura(fact_num, prove_rut) {
    // Realizar la petición
    var parametros = {
        numfact_detalle: fact_num,
        idprove: prove_rut
    };
    var post = $.post("../conection/ajax/ajax_getfactura.php", parametros, imprimirFactura, 'json');

    post.error(Error);
}
function Error() {
    location.href = "error.php";
}
function ErrorProve(e) {
    $('#modal_error').modal("show");
}
function imprimirFactura(r) {

    if (r.estado !== 0) {
        $("#id_fact").val(r.iddocumento);
        $("#fact_fecha_doc").val(r.fecha_doc);
        $("#fact_fecha_plazo").val(r.fecha_plazo);
        $("#fact_prove_nom").val(r.clieprove_nombre);
        $("#fact_neto").val(r.neto);
        $("#fact_iva").val(r.iva);
        $("#fact_total").val(r.total);
        $("#fact_glosa").val(r.glosa);
        if (r.estado == 1) {
            $("#panel_estado").html("Pendiente");
            $("#boton_pago").attr("disabled", "yes");
            $("#panel_icono").removeClass("fa-check-circle");
            $("#panel_icono").addClass("fa-exclamation-circle");
            $("#panel_icono").attr("style", "color: #F3A73B");
            $("#panel_alerta").removeClass("panel-green");
            $("#panel_alerta").addClass("panel-yellow");
        } else if (r.estado == 2) {
            $("#btn_edit").addClass("disabled");
            $("#btn_save").addClass("disabled");
            $("#btn_eli_fv").addClass("disabled");
            $("#btn_eli_fv").attr("onclick", "''");
            $("#panel_estado").html("Pagada");
            $("#boton_pago").removeAttr("disabled");
            $("#panel_icono").attr("style", "color:green");
            $("#panel_icono").removeClass("fa-exclamation-circle");
            $("#panel_icono").addClass("fa-check-circle");
            $("#panel_alerta").removeClass("panel-yellow");
            $("#panel_alerta").addClass("panel-green");
            $.ajax({
                url: "../conection/ajax/ajax_getfactura.php?tipo_doc=2",
                type: "POST",
                data: 'correlativo_factura=' + r.iddocumento,
                success: function (opciones) {
                    correlativo_factura = opciones;
                }
            });
        }
    } else {
        location.href = "error.php";
    }

}
$("#boton_pago").click(function () {
    window.open("fv_ingreso_detalle.php?corre_in=" + correlativo_factura, '_blank');
});
function editar() {
    $("#btn_edit").addClass("disabled");
    $("#btn_save").removeClass("disabled");

    $("#fact_fecha_doc").removeAttr("disabled");
    $("#fact_fecha_plazo").removeAttr("disabled");
    $("#fact_neto").removeAttr("disabled");
    $("#fact_glosa").removeAttr("disabled");
}
function guardar() {

    var f_doc = false;
    var f_plazo = false;
    var n = false;
    var g = false;
    var idfactura = $("#id_fact").val();
    var fecha_doc = $("#fact_fecha_doc").val();
    var fecha_plazo = $("#fact_fecha_plazo").val();
    var neto = $("#fact_neto").val();
    var iva = $("#fact_iva").val();
    var total = $("#fact_total").val();
    var glosa = $("#fact_glosa").val();
    if (!fecha_doc) {
        f_doc = false;
        $('#f_doc_grupo').addClass("has-error");
        $('#fact_fecha_doc').val("");
    } else {
        f_doc = true;
        $('#f_doc_grupo').removeClass("has-error");
        $('#fact_fecha_doc').attr('placeholder', 'Rut');
    }
    if (!fecha_plazo) {
        f_plazo = false;
        $('#f_plazo_grupo').addClass("has-error");
        $('#fact_fecha_plazo').val("");
    } else {
        f_plazo = true;
        $('#f_plazo_grupo').removeClass("has-error");
    }
    if (!neto) {
        n = false;
        $('#neto_grupo').addClass("has-error");
        $('#fact_neto').val("");
        $('#fact_neto').focus();
    } else {
        n = true;
        $('#neto_grupo').removeClass("has-error");
    }
    if (f_doc && f_plazo && n) {

        var datos = {
            idfactura: idfactura,
            fecha_doc: fecha_doc,
            fecha_plazo: fecha_plazo,
            neto: neto,
            iva: iva,
            total: total,
            glosa: glosa
        };
        $.ajax({
            url: "../conection/ajax/ajax_upfactura.php",
            type: "POST",
            data: datos,
            success: function (r) {

                $('#modal_facturamensaje').modal('show');
                $("#btn_edit").removeClass("disabled");
                $("#btn_save").addClass("disabled");
                if (r == "correcto") {
                    $('#modal_mensaje_titulo').html('Datos actualizados!');
                    $('#modal_mensaje_msg').html('los datos de la factura se han actualizado correctamente.');
                } else {
                    $('#modal_mensaje_titulo').html('Error');
                    $('#modal_mensaje_msg').html('Error al procesar la informacion ...');
                }
                $('#fact_fecha_doc').attr("disabled", "yes");
                $('#fact_fecha_plazo').attr("disabled", "yes");
                $('#fact_neto').attr("disabled", "yes");
                $('#fact_glosa').attr("disabled", "yes");
            }
        });
    }
}
function eliminarFactura() {
    $('#modal_deletefactura').modal('show');
}
function confirmarFactura(idfact) {
    $.ajax({
        url: "../conection/ajax/ajax_deletefactura.php",
        type: "POST",
        data: {idfact: idfact},
        success: function (r) {
            location.href = "fv_listado.php";
        }
    });
}
function cargarDataTable() {
    $('#factura_archivos').dataTable().fnDestroy();
    cargarArchivos();
    cargarFactura();
}
function volver() {
    location.href = "fv_listado.php";
}
$("[data-toggle=popover]").popover();
function abrirAdjuntar() {
    $(".messages").html("");
    $("#adjunto_glosa").val("");
    //$(":file").filestyle('clear');
    $(".showImage").html("");
    $("#modal_adjunto").modal("show");
}
function mostrarModal(modal) {
    $modal = $(modal);
    $modal.modal('show');
}
function exportar(tipo) {
    window.open('../conection/exportar.php', '_blank');
}

function descargarAdjunto(archivo){
    window.open("../conection/ajax/descargarArchivo.php?archivo="+archivo);
}
function detallearchivo(idadjunto) {
    $.ajax({
        dataType: "json",
        type: "POST",
        url: "../conection/ajax/ajax_getadjunto.php",
        data: {extraeradjunto: idadjunto},
        success: function (r) {
            if (r.estado !== 0) {
                $('#show_adjunto_id').val(idadjunto);
                $('#show_adjunto_path').val(r.archivo);
                $('#show_adjunto').attr('src', r.archivo);
            } else {
                alert("error al procesar la informacion #57");
            }
        },
        error: function (r) {
            alert("error al procesar la informacon #57");
        }
    });
    $("#modal_showAdjunto").modal("show");
}
function abrirAdjunto(archivo) {
    window.open(archivo, '_blank');

}
function eliminarAdjunto() {
    $('#eliminar_adjunto').addClass('hidden');
    $('#confirmar_eliminar_adjunto').removeClass('hidden');
}
function confirmarEliminar(id, adjunto) {
    $.ajax({
        type: "POST",
        url: "../conection/ajax/eliminarArchivo.php",
        data: {eliminar_archivo: id, adjunto_eliminar: adjunto},
        success: function (r) {
            if (r == 'correcto') {
                cargarDataTable();
                $("#modal_showAdjunto").modal("hide");
            } else {
                alert("error al procesar la informacion #57");
            }
        },
        error: function (r) {
            alert("error al procesar la informacon #57");
        }
    });
}