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
                <a href="<?= base_url('admin/Home/adelantos') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Editar Adelanto</h2>
                                    </div>
                                </div>

                                <form action="" id="form_add_adelanto" enctype="multipart/form-data">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="id_adelanto" class="col-form-label">Id Adelanto:</label>
                                                <input type="number" id="id_adelanto" value="<?php echo $adelantos[0]->id_adelanto; ?>" class="form-control" readonly name="id_adelanto">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="usuario" class="col-form-label">Empleados:</label>
												<?php if($tittle == "por_verificar"){?>
													<input type="text" name="usuario" class="form-control" readonly value="<?php echo $adelantos[0]->id_empleado ?>">
												<?php
												}else{ ?>
													<select name="usuario" id="usuario"  class="form-control">
														<option value="0">Sin seleccionar</option>
														<?php foreach ($personas as $key => $value) {?>
															<?php  
																if ($value->id_persona == $adelantos[0]->id_empleado) {?>
																	<option selected value="<?php echo $value->id_persona ?>"><?php echo $value->documento." / ".$value->nombres." / ".$value->tipo_cuenta; ?></option>
															<?php 
																}else{?>
																	<option value="<?php echo $value->id_persona ?>"><?php echo $value->documento." / ".$value->nombres." / ".$value->tipo_cuenta; ?></option>
																<?php
																}
															?>
															
														<?php
														} ?>
													</select>
												<?php
												} ?>
                                                
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion" class="col-form-label">Descripcion:</label>
                                                <textarea name="descripcion" class="form-control" id="descripcion" cols="30" rows="2"><?php echo $adelantos[0]->descripcion; ?></textarea>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="valor" class="col-form-label">Valor:</label>
                                                <input type="number" id="valor" value="<?php echo $adelantos[0]->valor; ?>" class="form-control" name="valor">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
											<div class="form-group">
                                                <label for="cuota" class="col-form-label">Cuotas:</label>
                                                <input type="number" id="cuota" value="<?php echo $adelantos[0]->cuota; ?>" class="form-control" name="cuota">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
											<div class="form-group text-center">
												<h6>Dinero por cuota</h6>
												<h7 class="cuota_aux"></h7>
											</div>
                                       </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_agregar_asignacion"><?php echo ($tittle == "por_verificar")? "Verificar": "Guardar"; ?></button>
												<?php
													if($tittle == "por_verificar"){ ?>
														<button class="btn btn-danger btn-block btn_rechazar_asignacion">Rechazar</button>
												<?php
													}
												?>
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
		if($("#valor").val() != "" && $("#cuota").val() != ""){
			setData($("#valor").val(), $("#cuota").val())
		}
		$("#valor").keyup(function (e) { 
			e.preventDefault();
			if($("#valor").val() != "" && $("#cuota").val() != ""){
				setData($("#valor").val(), $("#cuota").val())
			}
		});
		$("#cuota").keyup(function (e) { 
			e.preventDefault();
			if($("#valor").val() != "" && $("#cuota").val() != ""){
				setData($("#valor").val(), $("#cuota").val())
			}
		});

        $('.btn_agregar_asignacion').on('click' , function(e){
            e.preventDefault();
			var tittle = "<?php echo $tittle; ?>";
            var ruta      = "<?php echo ($tittle == "por_verificar") ? base_url('admin/home/verificarAdelantos'):base_url('admin/home/storeAdelantos'); ?>";
            var form_data = new FormData($('#form_add_adelanto')[0]);

            if ($("#usuario").val() == 0) {
                $("#usuario").addClass('is-invalid');
            }else{
                $("#usuario").removeClass('is-invalid');
            }
            if ($("#descripcion").val() == 0) {
                $("#descripcion").addClass('is-invalid');
            }else{
                $("#descripcion").removeClass('is-invalid');
            }
            if ($("#valor").val() == '') {
                $("#valor").addClass('is-invalid');
            }else{
                $("#valor").removeClass('is-invalid');
            }
			if ($("#cuota").val() == '') {
                $("#cuota").addClass('is-invalid');
            }else{
                $("#cuota").removeClass('is-invalid');
            }

            if( $("#usuario").val() != 0 &&
                $("#descripcion").val() != '' &&
                $("#cuota").val() != '' &&
                $("#valor").val() != '' 
            ) {

                $.ajax({
                    url: ruta,
                    type: 'POST',
                    dataType: 'json',
                    data: form_data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                })
                .done(function(r) {

                    if(r.status){
                        $('#form_addproduct').trigger('reset');
                        alertify.notify('Registro agregado con éxito', 'success', 2, function(){
							if(tittle == "por_verificar"){
								window.location.href = '../../adelantos';
								return
							}
                           window.location.href = '../adelantos';
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

		$('.btn_rechazar_asignacion').on('click' , function(e){
            e.preventDefault();
            var ruta      = "<?php echo base_url('admin/home/cancelarAdelanto') ?>";
            var form_data = new FormData($('#form_add_adelanto')[0]);


            if ($("#usuario").val() == 0) {
                $("#usuario").addClass('is-invalid');
            }else{
                $("#usuario").removeClass('is-invalid');
            }
            if ($("#descripcion").val() == 0) {
                $("#descripcion").addClass('is-invalid');
            }else{
                $("#descripcion").removeClass('is-invalid');
            }
            if ($("#valor").val() == '') {
                $("#valor").addClass('is-invalid');
            }else{
                $("#valor").removeClass('is-invalid');
            }

            if( $("#usuario").val() != 0 &&
                $("#descripcion").val() != '' &&
                $("#valor").val() != '' 
            ) {

                $.ajax({
                    url: ruta,
                    type: 'POST',
                    dataType: 'json',
                    data: form_data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                })
                .done(function(r) {
					console.log(r)
                    if(r.status){
                        $('#form_addproduct').trigger('reset');
                        alertify.notify('Adelanto rechazado', 'danger', 2, function(){
                           window.location.href = '../../adelantos';
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

	function setData(valor1, valor2){
		$(".cuota_aux").html(new Intl.NumberFormat('en-US').format(Math.round(valor1/valor2)))
	}
    
</script>
