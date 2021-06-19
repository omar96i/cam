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
                <a href="<?= base_url('admin/Home/asignaciones') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Agregar asignacion</h2>
                                    </div>
                                </div>

                                <form action="" id="form_addproduct" enctype="multipart/form-data">
                                    <label for="supervisor" class="col-form-label">Recuerda que las asignaciones se deben cambiar, cuando los usuarios no tengan registros activos</label>
                                    <div class="row mt-3">

                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
	                                            <label for="supervisor" class="col-form-label">Supervisor:</label>
	                                            <select name="supervisor" id="supervisor" class="form-control">
	                                                <option value="0">Sin seleccionar</option>
	                                                <?php foreach ($lista_supervisor as $key => $value) {?>
	                                                	<option value="<?php echo $value->id_persona ?>"><?php echo $value->id_persona." / ".$value->nombres." ".$value->apellidos  ?></option>
	                                               	<?php
	                                                } ?>
	                                            </select>
	                                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
	                                        </div>
                                            <div class="form-group">
	                                            <label for="empleado" class="col-form-label">Modelo:</label>
	                                            <select name="empleado" id="empleado" class="form-control">
	                                                <option value="0">Sin seleccionar</option>
	                                                <?php foreach ($lista_empleado as $key => $value) {?>
	                                                	<option value="<?php echo $value->id_persona ?>"><?php echo $value->id_persona." / ".$value->nombres." ".$value->apellidos  ?></option>
	                                               	<?php
	                                                } ?>
	                                            </select>
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
            var ruta      = "<?php echo base_url('admin/home/addasignacionsupervisor') ?>";
                supervisor = $("#supervisor").val();
                empleado = $("#empleado").val();

                if ($("#supervisor").val() == 0) {
                    $("#supervisor").addClass('is-invalid');
                }else{
                    $("#supervisor").removeClass('is-invalid');
                }
                if ($("#empleado").val() == 0) {
                    $("#empleado").addClass('is-invalid');
                }else{
                    $("#empleado").removeClass('is-invalid');
                }

                if( $("#supervisor").val() != 0 &&
                	$("#empleado").val() != 0 
                ) {

                    $.ajax({
                        url: ruta,
                        type: 'POST',
                        dataType: 'json',
                        data: {supervisor: supervisor, empleado: empleado},
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
                    .fail(function(r) {
                        console.log("error");
                        console.log(r)
                    });

                    return false;

                }

            return false;

        });
    });
    
    
</script>