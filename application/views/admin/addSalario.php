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
                <a href="<?= base_url('admin/Home/salario_empleados') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Agregar Salario</h2>
                                    </div>
                                </div>
                                <form action="" id="form_addproduct" enctype="multipart/form-data">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
	                                            <label for="tipo_empleado" class="col-form-label">Tipo de empleado:</label>
	                                            <select name="tipo_empleado" id="tipo_empleado" class="form-control">
	                                                <option value="0">Sin seleccionar</option>
                                                    <option value="administrador">Administrador</option>
                                                    <option value="talento humano">Talento humano</option>
                                                    <option value="tecnico sistemas">Supervisor</option>
                                                    <option value="supervisor">Monitor</option>
                                                    <option value="psicologa">Psicologa</option>
                                                    <option value="servicios generales">Servicios generales</option>
                                                    <option value="fotografo">Fotógrafo</option>
                                                    <option value="community manager">Community manager</option>
                                                    <option value="maquillador">Maquillador</option>
                                                    <option value="servicios generales">Servicios generales</option>
                                                    <option value="operativo">Operativo</option>
                                                    <option value="supervisor de los monitores">Supervisor de los monitores</option>
                                                    <option value="operario de mantenimiento">Operario de mantenimiento</option>
	                                            </select>
	                                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
	                                        </div>
                                            <div class="form-group">
                                                <label for="sueldo" class="col-form-label">Sueldo:</label>
                                                <input type="number" id="sueldo" class="form-control" name="sueldo">
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
            var ruta      = "<?php echo base_url('admin/home/agregarSalario') ?>";
                tipo_empleado = $("#tipo_empleado").val();
                sueldo = $("#sueldo").val();

                if ($("#tipo_empleado").val() == 0) {
                    $("#tipo_empleado").addClass('is-invalid');
                }else{
                    $("#tipo_empleado").removeClass('is-invalid');
                }
                if ($("#sueldo").val() == '') {
                    $("#sueldo").addClass('is-invalid');
                }else{
                    $("#sueldo").removeClass('is-invalid');
                }

                if( $("#tipo_empleado").val() != 0 &&
                	$("#sueldo").val() != ''
                ) {

                    $.ajax({
                        url: ruta,
                        type: 'POST',
                        dataType: 'json',
                        data: {tipo_empleado: tipo_empleado, sueldo: sueldo},
                    })
                    .done(function(r) {

                        if(r.status){
                            $('#form_addproduct').trigger('reset');
                            alertify.notify('Registro agregado con éxito', 'success', 2);
                            return;
                        }

                        alertify.alert('Ups :(');

                    });

                    return false;

                }

            return false;

        });
    });
    
</script>
