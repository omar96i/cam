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
                <a href="<?= base_url('admin/Home/penalizaciones') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Editar Penalizacion</h2>
                                    </div>
                                </div>

                                <form action="" id="form_editusuary">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="nombre_p" class="col-form-label">Nombre Penalizacion:</label>
                                                <input type="text" id="nombre_p" value="<?php echo $penalizaciones[0]->nombre_penalizacion ?>" class="form-control" name="nombre_p">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="puntos" class="col-form-label">Puntos:</label>
                                                <input type="number" id="puntos" value="<?php echo $penalizaciones[0]->puntos ?>" class="form-control" name="puntos">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                       </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_edit_pagina">Editar</button>
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
    $('.btn_edit_pagina').on('click' , function(e){
        e.preventDefault();
        var nombre_p = $("#nombre_p").val()
        var puntos = $("#puntos").val()
            ruta = "<?php echo base_url('admin/home/storePenalizacion'); ?>"
            id_penalizacion = <?php echo $penalizaciones[0]->id_penalizacion; ?>;

        if($("#nombre_p").val() == '') {
            $("#nombre_p").addClass('is-invalid');
        }
        else {
            $("#nombre_p").removeClass('is-invalid');
        }
        if($("#puntos").val() == '') {
            $("#puntos").addClass('is-invalid');
        }
        else {
            $("#puntos").removeClass('is-invalid');
        }

                   
        if( $("#nombre_p").val() != '' &&
			$("#puntos").val() != '' 
        ){
            
            $.ajax({
                url: ruta,
                type: 'POST',
                dataType: 'json',
                data: {nombre_p : nombre_p , puntos : puntos, id_penalizacion : id_penalizacion},
            })
            .done(function(r) {
                if(r.status){
                    alertify.notify('Registro actualizado', 'success', 2, function(){
                        window.location.href = '../penalizaciones';
                    });
                    return;
                }
                alertify.alert('Ups :(' , r.msg);

            })
            .fail(function(r) {
                alertify.alert('Ups :(' , r.msg);
            })
            return false;

        }

        return false;


    });
    
</script>