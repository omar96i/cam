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
                                        <h2 class="d-inline">Agregar Meta</h2>
                                    </div>
                                </div>
                                <form action="" id="form_addproduct" enctype="multipart/form-data">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
	                                            <label for="empleado" class="col-form-label">Usuarios:</label>
	                                            <select name="empleado" id="empleado" class="form-control">
	                                                <option value="0">Sin seleccionar</option>
	                                                <?php foreach ($empleados as $key => $value) {?>
	                                                	<option value="<?php echo $value->id_persona ?>"><?php echo $value->documento." / ".$value->nombres ?></option>
	                                               	<?php
	                                                } ?>
	                                            </select>
	                                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
	                                        </div>
                                            <div class="form-group">
                                                <label for="descripcion" class="col-form-label">Descripcion:</label>
                                                <input type="text" id="descripcion" class="form-control" disabled name="descripcion">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
	                                            <label for="cantidad_horas" class="col-form-label">Cantidad Tokens:</label>
	                                            <input type="number" id="cantidad_horas" class="form-control" disabled name="cantidad_horas">
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
        $("#empleado").change(function(event) {
            if ($(this).val() != 0) {
                $("#descripcion").val('');
                $("#cantidad_horas").val('');
                id_usuario = $(this).val();
                $.ajax({
                    url: '<?php echo base_url('admin/home/consultarEmpleadoMetasNull') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {id_usuario: id_usuario},
                })
                .done(function(r) {
                    if (!r) {
                        $("#descripcion").removeAttr('disabled');
                        $("#cantidad_horas").removeAttr('disabled');
                    }else{
                        $("#descripcion").attr('disabled', true);
                        $("#cantidad_horas").attr('disabled', true);
                        alertify.confirm("Nomina" , "El usuario ya dispone de un registro activo",
                        function(){
                            alertify.confirm().close();
                        },
                        function(){
                            alertify.confirm().close();
                        }); 
                    }
                });
            }else{
                $("#descripcion").attr('disabled', true);
                $("#cantidad_horas").attr('disabled', true);
            }
            
        });

        $('.btn_agregar_asignacion').on('click' , function(e){
            e.preventDefault();
            var ruta      = "<?php echo base_url('admin/home/agregarMetas') ?>";
                empleado = $("#empleado").val();
                descripcion = $("#descripcion").val();
                cantidad_horas = $("#cantidad_horas").val();

                if ($("#empleado").val() == 0) {
                    $("#empleado").addClass('is-invalid');
                }else{
                    $("#empleado").removeClass('is-invalid');
                }
                if ($("#descripcion").val() == 0) {
                    $("#descripcion").addClass('is-invalid');
                }else{
                    $("#descripcion").removeClass('is-invalid');
                }
                if ($("#cantidad_horas").val() == '') {
                    $("#cantidad_horas").addClass('is-invalid');
                }else{
                    $("#cantidad_horas").removeClass('is-invalid');
                }

                if( $("#empleado").val() != 0 &&
                	$("#descripcion").val() != '' &&
                	$("#cantidad_horas").val() != ''
                ) {

                    $.ajax({
                        url: ruta,
                        type: 'POST',
                        dataType: 'json',
                        data: {empleado: empleado, descripcion: descripcion, cantidad_horas: cantidad_horas},
                    })
                    .done(function(r) {

                        if(r.status){
                            $('#form_addproduct').trigger('reset');
                            alertify.notify(
                                'Registro agregado con éxito', 
                                'success', 
                                2
                            );
                            return;
                        }

                        alertify.alert('Ups :(' , r.msg);

                    });

                    return false;

                }

            return false;

        });
    });
    
</script>
