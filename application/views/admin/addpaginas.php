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
                <a href="<?= base_url('admin/Home/paginas') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Agregar Paginas</h2>
                                    </div>
                                </div>

                                <form action="" id="form_addproduct" enctype="multipart/form-data">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="url_pagina" class="col-form-label">Url pagina:</label>
                                                <input type="text" id="url_pagina" class="form-control" name="url_pagina">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_agregar_pagina">Aceptar</button>
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
        $('.btn_agregar_pagina').on('click' , function(e){
            e.preventDefault();
            var ruta      = "<?php echo base_url('admin/home/addpage') ?>";
                url_pagina = $("#url_pagina").val();

                if ($("#url_pagina").val() == '') {
                    $("#url_pagina").addClass('is-invalid');
                }else{
                    $("#url_pagina").removeClass('is-invalid');
                }

                if( $("#url_pagina").val() != '') {

                    $.ajax({
                        url: ruta,
                        type: 'POST',
                        dataType: 'json',
                        data: {url_pagina: url_pagina},
                    })
                    .done(function(r) {

                        if(r.status){
                            $('#form_addproduct').trigger('reset');
                            alertify.notify(
                                'Pagina agregada con éxito', 
                                'success', 
                                2
                            );
                            return;
                        }

                        alertify.alert('Ups :(' , r.msg);

                    })

                    return false;

                }

            return false;

        });
    });
</script>