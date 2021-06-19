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
                <a href="<?= base_url('admin/Home/metas') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Editar Meta</h2>
                                    </div>
                                </div>

                                <form action="" id="form_add_adelanto" enctype="multipart/form-data">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="id_meta" class="col-form-label">Id meta:</label>
                                                <input type="number" id="id_meta" value="<?php echo $meta[0]->id_meta; ?>" class="form-control" readonly name="id_meta">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion" class="col-form-label">Descripcion:</label>
                                                <textarea name="descripcion" class="form-control" id="descripcion" cols="30" rows="2"><?php echo $meta[0]->descripcion; ?></textarea>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="num_horas" class="col-form-label">Numero horas:</label>
                                                <input type="number" id="num_horas" value="<?php echo $meta[0]->num_horas; ?>" class="form-control" name="num_horas">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_agregar_asignacion">Aceptar</button>
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

        $('.btn_agregar_asignacion').on('click' , function(e){
            e.preventDefault();
            var ruta      = "<?php echo base_url('admin/Home/storeMetas') ?>";
            var form_data = new FormData($('#form_add_adelanto')[0]);

            if ($("#descripcion").val() == 0) {
                $("#descripcion").addClass('is-invalid');
            }else{
                $("#descripcion").removeClass('is-invalid');
            }
            if ($("#num_horas").val() == '') {
                $("#num_horas").addClass('is-invalid');
            }else{
                $("#num_horas").removeClass('is-invalid');
            }

            if( $("#descripcion").val() != '' &&
                $("#num_horas").val() != ''
            ) {

                $.ajax({
                    url: ruta,
                    type: 'POST',
                    dataType: 'json',
                    data: form_data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                })
                .done(function(r) {

                    if(r.status){
                        $('#form_addproduct').trigger('reset');
                        alertify.notify('Registro actualizado con éxito', 'success', 2, function(){
                           window.location.href = '../metas';
                        });
                        return;
                    }

                    alertify.alert('Ups :(' , r.msg);

                })
                .fail(function(r) {
                    console.log("error");
                    console.log(r);
                });

                return false;

            }

            return false;

        });
    });
    
</script>