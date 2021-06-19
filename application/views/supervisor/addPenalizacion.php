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
                <a href="<?= base_url('supervisor/Home/empleados') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Registrar Penalizacion</h2>
                                    </div>
                                </div>

                                <form action="" id="form_addproduct" enctype="multipart/form-data">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
	                                            <label for="empleado" class="col-form-label">Modelos:</label>
	                                            <select name="empleado" id="empleado" class="form-control">
	                                                <option value="0">Sin seleccionar</option>
	                                                <?php foreach ($lista_usuarios as $key => $value) {?>
	                                                	<option value="<?php echo $value->id_persona ?>"><?php echo $value->documento." / ".$value->nombres." ".$value->apellidos ?></option>
	                                               	<?php
	                                                } ?>
	                                            </select>
	                                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
	                                        </div>
                                            <div class="form-group">
                                                <label for="penalizacion" class="col-form-label">Penalizacion:</label>
                                                <select name="penalizacion" id="penalizacion" class="form-control">
                                                    <option value="0">Sin seleccionar</option>
                                                    <?php foreach ($lista_penalizacion as $key => $value) {?>
                                                        <option value="<?php echo $value->id_penalizacion ?>"><?php echo $value->nombre_penalizacion ?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="fecha">Fecha</label>
                                                <input type="date" name="fecha" id="fecha" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion">Observacion</label>
                                                <textarea name="descripcion" id="descripcion" class="form-control" cols="30" rows="2"></textarea>
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
            var ruta      = "<?php echo base_url('supervisor/home/addPenalizacion') ?>";
                empleado = $("#empleado").val();
                penalizacion = $("#penalizacion").val();
                descripcion = $("#descripcion").val();
                fecha = $("#fecha").val();


                if ($("#empleado").val() == 0) {
                    $("#empleado").addClass('is-invalid');
                }else{
                    $("#empleado").removeClass('is-invalid');
                }
                if ($("#penalizacion").val() == 0) {
                    $("#penalizacion").addClass('is-invalid');
                }else{
                    $("#penalizacion").removeClass('is-invalid');
                }
                if ($("#descripcion").val() == 0) {
                    $("#descripcion").addClass('is-invalid');
                }else{
                    $("#descripcion").removeClass('is-invalid');
                }
                if ($("#fecha").val() == 0) {
                    $("#fecha").addClass('is-invalid');
                }else{
                    $("#fecha").removeClass('is-invalid');
                }
                

                if( $("#empleado").val() != 0 &&
                	$("#penalizacion").val() != 0 &&
                    $("#penalizacion").val() != '' &&
                    $("#fecha").val() != ''
                ) {

                    $.ajax({
                        url: ruta,
                        type: 'POST',
                        dataType: 'json',
                        data: {empleado: empleado, penalizacion: penalizacion, descripcion: descripcion, fecha: fecha},
                    })
                    .done(function(r) {

                        if(r.status){
                            $('#form_addproduct').trigger('reset');
                            alertify.notify('Registro exitoso', 'success', 2);
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