<div class="modal fade" id="modal_deletefactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Eliminar Factura</h4>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="btn-toolbar" role="toolbar">
                            <button id="btn_reg" name="btn_reg" onclick="confirmarFactura($('#id_fact').val());" class="form-control btn btn-success btn-block">
                                <span class="fa fa-save fa-fw "></span> Confirmar eliminar factura
                            </button>
                        </div>
                    </div>
                </div> 
                <input type="hidden" class="form-control" placeholder="Clasificacion"  id="deleteclasi_id" required maxlength="45">

            </div>
            <div class="modal-footer">
                <button  id="cerrar_modal_rut"  type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <!-- <button id="cerrar_modal_rut" type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
        <!-- /.modal-content -->
    </div> 
    <!-- /.modal-dialog -->
</div>
