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
                                        <h2 class="d-inline">Editar Asignacion</h2>
                                    </div>
                                </div>

                                <form action="" id="form_editusuary">
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="usuario" class="col-form-label">Usuario:</label>
                                                <input type="text" id="usuario" class="form-control" name="usuario" value="<?php echo $lista[0]->correo ?>">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="clave" class="col-form-label">Contraseña:</label>
                                                <input type="text" id="clave" class="form-control" name="clave" value="<?php echo $lista[0]->clave ?>">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_edit_pagina" data-id_usuario="<?php echo $id_relacion ?>">Editar</button>
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
        var usuario = $("#usuario").val()
        var clave = $("#clave").val(),
            ruta = "<?php echo base_url('admin/home/editasignacionpages'); ?>",
            id_relacion = $(this).data('id_usuario');

        if($("#usuario").val() == '') {
            $("#usuario").addClass('is-invalid');
        }
        else {
            $("#usuario").removeClass('is-invalid');
        }
        if($("#clave").val() == '') {
            $("#clave").addClass('is-invalid');
        }
        else {
            $("#clave").removeClass('is-invalid');
        }

                   
        if( $("#usuario").val() != '' &&
			$("#clave").val() != '' 
        ){
            
            $.ajax({
                url: ruta,
                type: 'POST',
                dataType: 'json',
                data: {usuario : usuario , clave : clave, id_relacion : id_relacion},
            })
            .done(function(r) {
                if(r.status){
                    alertify.notify('Registro actualizado', 'success', 2, function(){
                        window.location.href = '../paginas';
                    });
                    return;
                }
                alertify.alert('Ups :(' , r.msg);

            })
            .fail(function(r) {
                console.log(r);
                alertify.alert('Ups :(' , r.msg);
            })
            return false;

        }

        return false;


    });
    
</script>