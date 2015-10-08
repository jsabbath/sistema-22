function abrirProve(id) {
    ExtrarProveedor(id);
    $modal = $("#modal_info_prove");
    $modal.modal('show');
}

function addProve(id) {
    $modal = $("#modal_add_prove");
    $modal.modal('show');
}

function imprimiProve(r) {
    document.getElementById("modal_rut_prove").value = r.rut;
    document.getElementById("modal_nombre_prove").value = r.nombre;
    document.getElementById("modal_fono_prove").value = r.fono;
    document.getElementById("modal_rsocial_prove").value = r.rsocial;
    document.getElementById("modal_giro_prove").value = r.giro;
    document.getElementById("modal_direccion_prove").value = r.direccion;
    document.getElementById("modal_comuna_prove").value = r.comuna;
    document.getElementById("modal_provincia_prove").value = r.provincia;
    document.getElementById("modal_region_prove").value = r.region;
    document.getElementById("modal_fecha_prove").value = r.fecha;
    document.getElementById("modal_mod_prove").value = r.ultimo_mod + " - " + r.fecha_mod;

}

function ErrorProve(e) {
    alert('Ocurrió un error al realizar la petición: ' + e.statusText);
}

function ExtrarProveedor(id) {
    // Realizar la petición
    var parametros = {
        id: id
    };
    var post = $.post("../conection/ajax/ajax_getprove.php", parametros, imprimiProve, 'json');

    post.error(ErrorProve); 
}
     