$(document).ready(function () {

    $(".messages").hide();
    //queremos que esta variable sea global
    var fileExtension = "";
    //función que observa los cambios del campo file y obtiene información
    $(':file').change(function ()
    {
        //obtenemos un array con los datos del archivo
        var file = $("#imagen")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;

        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        $(".messages").html("").show();
        $(".messages").html("<span class='info'>peso del archivo: " + fileSize + " bytes.</span>");
    });

    //al enviar el formulario
    $('#upload').click(function () {
        //información del formulario
        var formData = new FormData($(".formulario")[0]);
        var message = "";
        //hacemos la petición ajax  
        $.ajax({
            dataType: "json",
            url: '../conection/ajax/subirArchivoEgreso.php',
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
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
                    cargarDataTableEgresoDetalle();
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
var idpago;
function extraerEgreso(corre) {
    // Realizar la petición
    extraerFacturas(corre);
    var parametros = {corre_egreso: corre};
    var post = $.post("../conection/ajax/ajax_getegreso.php", parametros, imprimirEgreso, 'json');
    post.error(Error);

}
function cargarDataTableEgresoDetalle() {
    $('#egreso_adjuntos').dataTable().fnDestroy();
    cargarArchivos(idpago);
}
function Error() {
    location.href = "error.php";
}
function ErrorProve(e) {
    mostrarModal('#modal_error');
}
function imprimirEgreso(r) {

    if (r.estado !== 0) {
        $("#egreso_fecha").val(r.fecha_pago);
        $("#egreso_documento").val(r.documento_pago);
        $("#egreso_total_pago").val(r.total_pago);
        $("#egreso_prove_nombre").val(r.clieprove_nombre);
        $("#egreso_glosa").val(r.glosa);
        $("#total_footer").html(r.total_pago);
        idpago = r.idpago;
        cargarArchivos(r.idpago);
        TipoPago(r.forma_pago_id);
    } else {
        location.href = "error.php";
    }

}
function extraerFacturas(corre) {
    $('#egreso_facturas').dataTable({
        "ajax": "../conection/ajax/ajax_getegreso.php?corre_facturas=" + corre,
        "columns": [
            {"data": "detalle"},
            {"data": "ndoc"},
            {"data": "neto"},
            {"data": "iva"},
            {"data": "total"}
        ],
        "bLengthChange": false,
        "bPaginate": false,
        "bFilter": false,
        "bInfo": false,
        "bSort": false,
        "language": {
            "url": "../js/dataTable_es.txt"
        }
    });
}
function cargarArchivos(idpago) {
    $('#egreso_adjuntos').dataTable({
        "ajax": "../conection/ajax/ajax_getegreso.php?idpago_adjunto=" + idpago,
        "columns": [
            {"data": "tipo"},
            {"data": "archivo"},
            {"data": "fecha"},
            {"data": "detalle"}
        ],
        "bLengthChange": false,
        "bPaginate": false,
        "bFilter": false,
        "bInfo": false,
        "bSort": false,
        "language": {
            "url": "../js/dataTable_es.txt"
        }
    });
}
function abrirFactura(iddocumento, ndoc, clieprove) {
    window.open('fc_detalle.php?idfact=' + iddocumento + '&fact=' + ndoc + '&prove=' + clieprove, '_blank');
}
function TipoPago(select) {
    $.ajax({
        url: "../conection/ajax/ajax_getegreso.php",
        type: "POST",
        data: 'combo_tipo=1&select=' + select,
        success: function (opciones) {
            $("#egreso_tipo_pago").html(opciones);
        }
    });
}
function volver() {
    location.href = "fc_egresos.php";
}
function abrirAdjuntar() {
    $(".messages").html("");
    $("#adjunto_glosa").val("");
    //$(":file").filestyle('clear');
    $(".showImage").html("");
    $("#modal_adjunto").modal("show");
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
  