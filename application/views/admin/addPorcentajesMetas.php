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
    <!-- /page header -->

    <div class="content">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-8">
                                        <h2 class="d-inline">Agregar Porcentaje Metas</h2>
                                    </div>
                                </div>

                                <form action="" id="form_addproduct" enctype="multipart/form-data">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="valor" class="col-form-label">Valor %</label>
                                                <input type="text" id="valor" class="form-control" name="valor">
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
            var ruta      = "<?php echo base_url('admin/home/agregarPorcentajeMetas') ?>";
                valor = $("#valor").val();

                if ($("#valor").val() == '') {
                    $("#valor").addClass('is-invalid');
                }else{
                    $("#valor").removeClass('is-invalid');
                }

                if( $("#valor").val() != '') {

                    $.ajax({
                        url: ruta,
                        type: 'POST',
                        dataType: 'json',
                        data: {valor: valor},
                    })
                    .done(function(r) {

                        if(r.status){
                            $('#form_addproduct').trigger('reset');
                            alertify.notify('Registro éxito', 'success', 2, function(){
                               window.location.href = '../Home/metasPorcentajes';
                            });
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