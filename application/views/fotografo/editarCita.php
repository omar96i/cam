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
                <a href="<?= base_url('fotografo/Citas') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Editar Cita</h2>
                                    </div>
                                </div>

                                <form action="" id="form_addproduct" enctype="multipart/form-data">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
	                                            <label for="descripcion" class="col-form-label">Modelo:</label>
                                                <select name="usuarios" id="usuario" class="form-control">
	                                                <option value="0">Sin seleccionar</option>
	                                                <?php foreach ($empleados as $key => $value) {?>
	                                                	<option value="<?php echo $value->id_persona ?>" <?php echo ($citas[0]->id_empleado==$value->id_persona)?"selected":""; ?>><?php echo $value->documento." / ".$value->nombres." ".$value->apellidos ?></option>
	                                               	<?php
	                                                } ?>
	                                            </select>
	                                        </div>
                                            <div class="form-group">
	                                            <label for="descripcion" class="col-form-label">Descripcion:</label>
                                                <textarea name="descripcion" id="descripcion" class="form-control" cols="30" rows="4"><?php echo $citas[0]->descripcion; ?></textarea>
	                                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
	                                        </div>
                                            <div class="form-group">
	                                            <label for="fecha" class="col-form-label">Fecha:</label>

                                                <input type="date" id="fecha" class="form-control" name="fecha" value="<?php echo $citas[0]->fecha; ?>">
	                                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
	                                        </div>
                                            <div class="form-group">
	                                            <label for="fecha" class="col-form-label">Fecha:</label>

                                                <input type="time" id="hora" class="form-control" name="fecha" value="<?php echo $citas[0]->hora; ?>">
	                                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
	                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_agregar_reporte">Aceptar</button>
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

        $('.btn_agregar_reporte').on('click' , function(e){
            e.preventDefault();
            var ruta      = "<?php echo base_url('fotografo/EditarCita/editarOnlyCita') ?>";
                descripcion = $("#descripcion").val();
                fecha = $("#fecha").val();
                hora = $("#hora").val();
                usuario = $("#usuario").val();
                id_cita = "<?php echo $citas[0]->id_citas; ?>";

                if ($("#descripcion").val() == "") {
                    $("#descripcion").addClass('is-invalid');
                }else{
                    $("#descripcion").removeClass('is-invalid');
                }
                if ($("#fecha").val() == '') {
                    $("#fecha").addClass('is-invalid');
                }else{
                    $("#fecha").removeClass('is-invalid');
                }

                if( $("#descripcion").val() != '' &&
                	$("#fecha").val() != ''
                ) {

                    $.ajax({
                        url: ruta,
                        type: 'POST',
                        dataType: 'json',
                        data: {id_usuario:usuario, descripcion: descripcion, fecha: fecha, hora: hora, id_cita: id_cita},
                    })
                    .done(function(r) {
                        if(r.status){
                            alertify.notify('Cita Editada', 'success', 2, function(){
                               window.location.href = './../Citas';
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