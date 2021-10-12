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
                <a href="<?= base_url('talento_humano/Home/verhoras/'.$id_modelo) ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Editar Registro</h2>
                                    </div>
                                </div>

                                <form action="" id="form_editusuary">
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="cantidad_horas" class="col-form-label">Cantidad Horas:</label>
                                                <input type="text" id="cantidad_horas" class="form-control" name="cantidad_horas" value="<?php echo $registro_horas[0]->cantidad_horas ?>">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="fecha_registro" class="col-form-label">Fecha Registro: </label>
                                                <input type="date" id="fecha_registro" class="form-control" name="fecha_registro" value="<?php echo $registro_horas[0]->fecha_registro ?>">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_editusuary" data-id_usuario="<?php echo $registro_horas[0]->id_registro_horas ?>">Editar</button>
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
    $('.btn_editusuary').on('click' , function(e){
        e.preventDefault();
        var cantidad_horas = $("#cantidad_horas").val()
        var fecha_registro = $("#fecha_registro").val()

            ruta         = "<?php echo base_url('supervisor/home/editRegistroHoras') ?>",
            id_registro_horas = $(this).data('id_usuario');

            if($('#cantidad_horas').val() == '') {
                $('#cantidad_horas').addClass('is-invalid');
            }
            else {
                $('#cantidad_horas').removeClass('is-invalid');
            }
            if($('#descuento').val() == '') {
                $('#descuento').addClass('is-invalid');
            }
            else {
                $('#descuento').removeClass('is-invalid');
            }
            if($('#descripcion').val() == '') {
                $('#descripcion').addClass('is-invalid');
            }
            else {
                $('#descripcion').removeClass('is-invalid');
            }
            

                   
        if( $('#cantidad_horas').val() != '' &&
			$('#descuento').val() != '' &&
			$('#descripcion').val() != '' 
        ){
            
            $.ajax({
                url: ruta,
                type: 'POST',
                dataType: 'json',
                data: {cantidad_horas: cantidad_horas, descripcion: descripcion, id_registro_horas: id_registro_horas, fecha_registro: fecha_registro},
            })
            .done(function(r) {
                if(r.status){
                    alertify.notify('Registro actualizado', 'success', 2, function(){
                        window.location.href = '<?php echo base_url('talento_humano/Home/usuarios') ?>';
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
</script>
