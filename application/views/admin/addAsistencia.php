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
                <a href="<?= base_url('admin/Home/asistencias') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Agregar Asistencia</h2>
                                    </div>
                                </div>

                                <form action="" id="form_addproduct" enctype="multipart/form-data">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="nombre_a" class="col-form-label">Nombre Asistencia:</label>
                                                <input type="text" id="nombre_a" class="form-control" name="nombre_a">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="nombre_a" class="col-form-label">Descuenta el día?</label>
                                                <br/>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input mr-1" type="radio" id="si" value="Si" name="descuenta_dia">
                                                    <label class="form-check-label" for="si" style="height: 17px">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input mr-1" type="radio" id="no" value="No" name="descuenta_dia">
                                                    <label class="form-check-label" for="no" style="height: 17px">No</label>
                                                </div>
                                                <div class="text-danger error_radio" style="display: none;">Seleccione una opción</div>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_agregar_asistencia">Aceptar</button>
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
        $('.btn_agregar_asistencia').on('click' , function(e){
            e.preventDefault();
            var ruta      = "<?php echo base_url('admin/home/agregarAsistencia') ?>";
            var nombre_a = $("#nombre_a").val();
            var descuenta = $("#si").is(':checked') ? $("#si").val() : ($("#no").is(':checked') ? $("#no").val() : '');

            if (nombre_a == '') {
                $("#nombre_a").addClass('is-invalid');
            }else{
                $("#nombre_a").removeClass('is-invalid');
            }

            if (descuenta == '') {
                $(".error_radio").show();
            }else{
                $(".error_radio").hide();
            }

            if(nombre_a != '' && descuenta != '') {

                $.ajax({
                    url: ruta,
                    type: 'POST',
                    dataType: 'json',
                    data: {'nombre_a': nombre_a, 'descuenta': descuenta},

                }).done(function(r) {

                    if(r.status){
                        $('#form_addproduct').trigger('reset');
                        alertify.notify(
                            'Registro éxito', 
                            'success', 
                            2
                        );
                        return;
                    }

                    alertify.alert('Ups :(' , r.msg);

                }).fail(function(r) {
                    alertify.alert('Ups :(', 'error al conectarse con el servidor.');
                })
            }
        });
    });
</script>