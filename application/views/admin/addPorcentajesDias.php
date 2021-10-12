<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="<?php echo base_url() ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Inicio</a>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header mt-1 mr-3"> 
        <div class="row">
            <div class="col-md-12">
                <a href="<?= base_url('admin/Home/diasPorcentajes') ?>" class="btn btn-info float-right">Retroceder</a>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <!-- /page header -->

    <div class="content pt-1">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-8">
                                        <h2 class="d-inline">Agregar Porcentaje Dias</h2>
                                    </div>
                                </div>

                                <form action="" id="form_addproduct" enctype="multipart/form-data">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="dias" class="col-form-label">Dias requeridos</label>
                                                <input type="text" id="dias" class="form-control" name="dias">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="valor" class="col-form-label">%</label>
                                                <input type="number" id="valor" class="form-control" name="valor">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
											<div class="form-group">
                                                <label for="valor_multiplicar" class="col-form-label">Valor a multiplicar</label>
                                                <input type="number" id="valor_multiplicar" class="form-control" name="valor_multiplicar">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="estado_meta" class="col-form-label">Estado meta</label>
                                                <select name="estado_meta" id="estado_meta" class="form-control">
                                                    <option value="completa">completa</option>
                                                    <option value="incompleta">incompleta</option>
                                                </select>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
											<div class="form-group">
                                                <label for="tipo" class="col-form-label">Paginas</label>
                                                <select name="tipo" id="tipo" class="form-control">
                                                    <option value="general">General</option>
                                                    <option value="bongacams">Bongacams</option>
                                                </select>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_agregar_porcentaje">Aceptar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="chart position-relative" id="traffic-sources"></div>
               </div>
            </div>
        </div>
    </div>


<script>
    $(document).ready(function() {
        $('.btn_agregar_porcentaje').on('click' , function(e){
            e.preventDefault();
            var ruta      = "<?php echo base_url('admin/home/agregarPorcentajeDias') ?>";
                dias = $("#dias").val();
                valor = $("#valor").val();
                estado_meta = $("#estado_meta").val();
                valor_multiplicar = $("#valor_multiplicar").val();
                tipo = $("#tipo").val();


                if ($("#dias").val() == '') {
                    $("#dias").addClass('is-invalid');
                }else{
                    $("#dias").removeClass('is-invalid');
                }
                if ($("#valor").val() == '') {
                    $("#valor").addClass('is-invalid');
                }else{
                    $("#valor").removeClass('is-invalid');
                }
                if ($("#estado_meta").val() == '') {
                    $("#estado_meta").addClass('is-invalid');
                }else{
                    $("#estado_meta").removeClass('is-invalid');
                }
				if ($("#valor_multiplicar").val() == '') {
                    $("#valor_multiplicar").addClass('is-invalid');
                }else{
                    $("#valor_multiplicar").removeClass('is-invalid');
                }
				if ($("#tipo").val() == '') {
                    $("#tipo").addClass('is-invalid');
                }else{
                    $("#tipo").removeClass('is-invalid');
                }

                if( $("#dias").val() != '' && $("#valor").val() != '' && $("#estado_meta").val() != '' && $("#valor_multiplicar").val() != '' && $("#tipo").val() != '') {

                    $.ajax({
                        url: ruta,
                        type: 'POST',
                        dataType: 'json',
                        data: {dias: dias, valor: valor, estado_meta:estado_meta, valor_multiplicar: valor_multiplicar, tipo: tipo},
                    })
                    .done(function(r) {

                        if(r.status){
                            $('#form_addproduct').trigger('reset');
                            alertify.notify('Registro éxito', 'success', 2);
                            return;
                        }

                        alertify.alert('Upis :(' , r.msg);

                    })

                    return false;

                }

            return false;

        });
    });
</script>
