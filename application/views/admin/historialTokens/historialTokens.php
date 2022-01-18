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
                <a href="<?= base_url() ?>" class="btn btn-info float-right">Retroceder</a>
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
                                    <div class="col-6">
                                        <h2 class="d-inline">Tokens</h2>
                                    </div>
                                </div>
								<form class="container my-4">
									<div class="row">
										<div class="col-4">
											<label for="modelo">Modelos</label>
											<select name="modelo" id="modelo" class="form-control">
												<option value="0">Sin seleccionar</option>
												<?php foreach ($modelos as $key => $value) {?>
													<option value="<?php echo $value->id_persona ?>" <?php echo ($id_empleado == $value->id_persona)? "selected": ""; ?>><?php echo $value->documento." / ".$value->nombres." ".$value->apellidos ?></option>
												<?php
												} ?>
											</select>
											<div class="invalid-feedback">El campo no debe quedar vacío</div>
										</div>
										<div class="col-4">
											<label for="monitor">Monitores</label>
											<select name="monitor" id="monitor" class="form-control">
												<option value="0">Sin seleccionar</option>
												<?php foreach ($monitores as $key => $value) {?>
													<option value="<?php echo $value->id_persona ?>" <?php echo ($id_supervisor == $value->id_persona)? "selected": ""; ?>><?php echo $value->documento." / ".$value->nombres." ".$value->apellidos ?></option>
												<?php
												} ?>
											</select>
											<div class="invalid-feedback">El campo no debe quedar vacío</div>
										</div>
										<div class="col-4">
											<label for="estado_registro">Estado del registro</label>
											<select name="estado_registro" id="estado_registro" class="form-control">
												<option value="0">Sin seleccionar</option>
												<option value="sin_registrar" <?php echo ($estado_registro == "sin_registrar")? "selected": ""; ?>>Sin Verificar</option>
												<option value="verificado" <?php echo ($estado_registro == "verificado")? "selected": ""; ?>>Verificado</option>
												<option value="registrado" <?php echo ($estado_registro == "registrado")? "selected": ""; ?>>Registrado</option>
											</select>
											<div class="invalid-feedback">El campo no debe quedar vacío</div>
										</div>
										<div class="col-6">
											<label for="fecha_inicio">Fecha inicial</label>
											<input type="date" value="<?php echo $fecha_inicial ?>" class="form-control fecha_inicial" required>
											<div class="invalid-feedback">El campo no debe quedar vacío</div>
										</div>
										<div class="col-6">
											<label for="fecha_final">Fecha final</label>
											<input type="date" value="<?php echo $fecha_final ?>" class="form-control fecha_final" required>
											<div class="invalid-feedback">El campo no debe quedar vacío</div>
										</div>
									</div>
									<div class="col-12 text-center my-3">
										<button type="submit" class="btn btn-success btn_filtro">Buscar</button>
										<button type="submit" class="btn btn-danger btn_resetear">Resetear</button>

									</div>
								</form>
                                <div  class="table-responsive mt-1">
									<table id="empty" class="table table-sm table-striped table-bordered">
										<thead class="text-center">
											<tr>
												<th>Modelo</th>
												<th>Url pagina</th>
												<th>Cantidad Tokens</th>
												<th>Estado</th>
												<th>Fecha</th>
												<th>Fecha de registro</th>
												
											</tr>
										</thead>

										<tbody id="tbodyregistro_horas" class="text-center">

										</tbody>
									</table>
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

		$(".btn_filtro").click(function(event){
			event.preventDefault();
			searchBy()
		});

		$("#modelo").change(function (e) { 
			e.preventDefault();
			$("#monitor").val('0')
		});

		$("#monitor").change(function (e) { 
			e.preventDefault();
			$("#modelo").val('0')
		});

		$(".btn_resetear").click(function(event){
			event.preventDefault();
			ruta = "<?php echo base_url('admin/HistorialTokens/HistorialTokens') ?>"
			window.location.href = ruta;
		});

		load_tokens()
    });

    function load_tokens() {

		id_modelo = ($("#modelo").val() == 0)? false : $("#modelo").val()
		id_monitor = ($("#monitor").val() == 0)? false : $("#monitor").val()
		estado_registro = ($("#estado_registro").val() == 0)? false : $("#estado_registro").val()
		fecha_inicial = $(".fecha_inicial").val()
		fecha_final = $(".fecha_final").val()

        $.ajax({
            url      : '<?= base_url('admin/HistorialTokens/HistorialTokens/getDataTable') ?>',
            method   : 'POST',
            data     : {'id_modelo': id_modelo, 'id_monitor': id_monitor, 'estado_registro':estado_registro, 'fecha_inicial':fecha_inicial, 'fecha_final':fecha_final},
            success  : function(r){
				if(r.status){
					var tbody = '';
				
					for(var k=0; k<r.data.length; k++) {
						tbody += `<tr>
							<td class="align-middle text-capitalize">${r.data[k]['nombres']+' '+r.data[k]['apellidos']}</td>
							<td class="align-middle text-capitalize">${r.data[k]['url_pagina']}</td>
							<td class="align-middle text-capitalize">${r.data[k]['cantidad_horas']}</td>
							<td class="align-middle text-capitalize">${(r.data[k]['estado_registro'] == 'sin registrar')? 'sin verificar': r.data[k]['estado_registro']}</td>
							<td class="align-middle text-capitalize">${r.data[k]['fecha_registro']}</td>
							<td class="align-middle text-capitalize">${r.data[k]['created_at']}</td>`;
						tbody += `</tr>`;
					}
					$('#tbodyregistro_horas').html(tbody);
					
				}
				$('#empty').DataTable( {
					"order": [[ 4, "desc" ]]
				} );
				
            },
            dataType : 'json'
        });

        return false;
    }

	function searchBy(){

		id_modelo = $("#modelo").val()
		id_monitor = $("#monitor").val()
		estado_registro = $("#estado_registro").val()
		fecha_inicial = $(".fecha_inicial").val()
		fecha_final = $(".fecha_final").val()

		if ($(".fecha_inicial").val() == '') {
			$(".fecha_inicial").addClass('is-invalid');
		}else{
			$(".fecha_inicial").removeClass('is-invalid');
		}

		if ($(".fecha_final").val() == '') {
			$(".fecha_final").addClass('is-invalid');
		}else{
			$(".fecha_final").removeClass('is-invalid');
		}

		if(fecha_inicial == "" || fecha_final == ""){
			return
		}
		
		ruta = "<?php echo base_url('admin/HistorialTokens/HistorialTokens/index/') ?>"+fecha_inicial+"/"+fecha_final+"/"+id_monitor+"/"+id_modelo+"/"+estado_registro
		window.location.href = ruta;
	}


</script>
