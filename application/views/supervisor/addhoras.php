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
                                        <h2 class="d-inline">Registrar Tokens</h2>
                                    </div>
                                </div>

                                <form action="" id="form_addproduct" enctype="multipart/form-data">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
	                                            <label for="usuarios" class="col-form-label">Modelos:</label>
	                                            <select name="usuarios" id="usuarios" class="form-control">
	                                                <option value="0">Sin seleccionar</option>
	                                                <?php foreach ($lista_usuarios as $key => $value) {?>
	                                                	<option value="<?php echo $value->id_persona ?>"><?php echo $value->documento." / ".$value->nombres." ".$value->apellidos ?></option>
	                                               	<?php
	                                                } ?>
	                                            </select>
	                                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
	                                        </div>
                                            <div class="form-group">
	                                            <label for="paginas" class="col-form-label">Pagina:</label>
	                                            <select name="paginas" disabled id="paginas" class="form-control">
	                                                <option value="0">Sin seleccionar</option>
	                                                
	                                            </select>
	                                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
	                                        </div>
                                            
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="fecha" class="col-form-label">Fecha:</label>
                                                <input type="date" id="fecha" class="form-control" name="fecha">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
											<div class="form-group">
                                                <label for="cantidad_horas" class="col-form-label">Cantidad Tokens:</label>
                                                <input type="number" id="cantidad_horas" class="form-control" name="cantidad_horas">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
										<div class="form-group">
                                               	<label for="motivo" class="col-form-label">Tipo de tokens:</label>
	                                            <select name="motivo" id="motivo" class="form-control">
	                                                <option value="tn">Tokens normales</option>
	                                                <option value="ti">Tokens inactivos</option>
	                                            </select>
	                                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
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
            var ruta      = "<?php echo base_url('supervisor/home/addHoras') ?>";
                usuarios = $("#usuarios").val();
                paginas = $("#paginas").val();
                cantidad_horas = $("#cantidad_horas").val();
                fecha = $("#fecha").val();
				motivo = $("#motivo").val();

                if ($("#paginas").val() == 0) {
                    $("#paginas").addClass('is-invalid');
                }else{
                    $("#paginas").removeClass('is-invalid');
                }
                if ($("#usuarios").val() == 0) {
                    $("#usuarios").addClass('is-invalid');
                }else{
                    $("#usuarios").removeClass('is-invalid');
                }
                if ($("#cantidad_horas").val() == '') {
                    $("#cantidad_horas").addClass('is-invalid');
                }else{
                    $("#cantidad_horas").removeClass('is-invalid');
                }
                if ($("#fecha").val() == '') {
                    $("#fecha").addClass('is-invalid');
                }else{
                    $("#fecha").removeClass('is-invalid');
                }

                if( $("#paginas").val() != 0 &&
                	$("#usuarios").val() != 0 &&
                	$("#cantidad_horas").val() != '' &&
                    $("#fecha").val() != ''
                ) {
					$(".btn_agregar_asignacion").attr('disabled', true);
                    $.ajax({
                        url: ruta,
                        type: 'POST',
                        dataType: 'json',
                        data: {paginas: paginas, usuarios: usuarios, cantidad_horas: cantidad_horas, fecha: fecha, motivo:motivo},
                    })
                    .done(function(r) {
						$(".btn_agregar_asignacion").removeAttr("disabled");

                        if(r.status){
							
                            $('#form_addproduct').trigger('reset');
                            alertify.notify('Registro exitoso', 'success', 2);
                            return;
                        }

                        alertify.alert('Ups :(' , r.msg);

						

                    })
                    .fail(function(r) {
						$(".btn_agregar_asignacion").removeAttr("disabled");

                        console.log("error");
                        console.log(r);
                    });

                    return false;

                }

            return false;
        });

        $("#usuarios").change(function(event) {
            id_usuario = $(this).val();
            $("#paginas").attr('disabled', true);
            $("#paginas").children().first().siblings().remove();

            $.ajax({
                url: '<?php echo base_url('supervisor/home/addpages') ?>',
                type: 'POST',
                dataType: 'json',
                data: {id_usuario: id_usuario},
            })
            .done(function(r) {
                if (!r == 0) {
                    $("#paginas").removeAttr('disabled');
                    text = "";
                    for (var i = 0; i < r.length; i++) {
                        text += "<option value='"+r[i]['id_pagina']+"'>"+r[i]['url_pagina']+"</option>"
                    }
                    $("#paginas").children().first().siblings().remove();
                    $("#paginas").append(text);
                }
            })
            .fail(function(r) {
                console.log("error");
                console.log(r);
            });
            
        });
    });
    
</script>
