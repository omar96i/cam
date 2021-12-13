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
                                        <h2 class="d-inline">Asistencia</h2>
                                        <?php if (!isset($items_asistencia)) {?>
											<h2>Fecha:</h2>
											<input type="date" class="form-control col-5" id="fecha_asistencia"><br>
                                            <a href="" class="btn btn-info" id="btn_abrir_asistencia">Abrir asistencia</a>
                                        <?php } ?>
                                    </div>
                                </div>

                                <?php if(!empty($asistencia)): ?>
                                    <div  class="table-responsive mt-1">
                                        <h2 class="d-inline"> Fecha: <?= isset($fecha) ? $fecha : '' ?></h2>
                                        <form action="">
                                            <table id="empty" class="table table-sm table-striped table-bordered">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th></th>
                                                        <th>Documento</th>
                                                        <th>Nombres</th>
                                                        <th>Apellidos</th>
                                                        <th>Estado asistencia</th>
                                                        <th>Motivo inasistencia</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>

                                                <tbody id="tbodyasistencia" class="text-center">
                                                    <?php foreach ($items_asistencia as $key => $value) {?>
                                                        <tr>
                                                            <td class="align-middle text-capitalize">
                                                                <?php if ($value->estado == "sin registrar") {?>
                                                                    <input type="checkbox" data-id_empleado="<?php echo $value->id_persona ?>" class="btn_chek">

                                                                <?php }else{ ?>
                                                                    <input type="checkbox" data-id_empleado="<?php echo $value->id_persona ?>" class="btn_chek" checked>
                                                                <?php } ?> 
                                                            </td>

                                                            <td class="align-middle text-capitalize"><?php echo $value->documento; ?></td>
                                                            <td class="align-middle text-capitalize"><?php echo $value->nombres; ?></td>
                                                            <td class="align-middle text-capitalize"><?php echo $value->apellidos; ?></td>
                                                            <td class="align-middle text-capitalize td_estado"><?php echo $value->estado; ?></td>

                                                            <td class="align-middle text-capitalize">
                                                                <select class="form-control" style="display:<?= $value->estado=="sin registrar" ? 'block' : 'none'?>">
                                                                    <option value="0" <?= empty($value->motivo) ? 'selected' : ''?> disabled>Seleccionar motivo</option>
                                                                    <?php foreach ($motivos as $motivo): ?>
                                                                        <option <?= $value->motivo==$motivo->id_motivo?'selected':'' ?> value="<?= $motivo->id_motivo ?>"><?= $motivo->nombre ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </td>
															<td>
															<a href="" data-id_empleado="<?php echo $value->id_persona ?>" data-id_asistencia="<?php echo (isset($items_asistencia))?$items_asistencia[0]->id_asistencia:''; ?>" class="btn_eliminar_modelo"><img src="<?php echo base_url('assets/iconos_menu/eliminar.png') ?>" alt="" style="width: 25px;"></a>
															</td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <td class="align-middle text-capitalize" colspan="6"><button type="button" id="btn_registrar_asistencia" class="btn btn-info mb-2 ml-1">Registrar</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay asistencia</span></p>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>

                        <div class="chart position-relative" id="traffic-sources"></div>
                    </div>
                </div>
            </div>
        </div>

<script>
	$(document).ready(function () {
		$(".btn_eliminar_modelo").click(function (e) { 
			e.preventDefault();
			id = $(this).data('id_empleado')
			id_asistencia = $(this).data('id_asistencia')
			alertify.confirm("Nomina" , "Estas seguro de eliminar la modelo?",
			function(){
				EliminarModelo(id, id_asistencia)
			},
			function(){
				alertify.confirm().close();
			});
		});
	});
	function EliminarModelo(id, id_asistencia){
		
		$.ajax({
			url: '<?= base_url('supervisor/VerAsistencia/eliminarModeloAsistencia') ?>',
			type: 'POST',
			dataType: 'json',
			data: {id_empleado: id, id_asistencia: id_asistencia},
		})
		.done(function(r) {
			if(r.status){
				alertify.notify('Modelo eliminada', 'success', 1, function(){
					window.location.href = '../Home/asistencia';
				});
				return;
			}
			alertify.alert(r.msg);
		})
		.fail(function(r) {
			console.log("error");
			console.log(r);
		});
	}


    $("#btn_registrar_asistencia").on('click', function(e) {
        alertify.confirm("Nomina" , "Estas seguro de finalizar la asistencia?",
        function(){
			datos = [];
			filas = $("#tbodyasistencia tr");
			for (var i = 0; i < filas.length-1; i++) {
				items = [];
				if($(filas[i]).find('.btn_chek').is(':checked')) {
					items[0] = "registrado";
					items[1] = '';

				}else{
					items[0] = "sin registrar";
					items[1] = $(filas[i]).find('select').val();
				}

				items[2] = $(filas[i]).find('.btn_chek').data('id_empleado');
				datos[i] = items;
			}

			items_usuario = JSON.stringify(datos);
			id_asistencia = <?php echo (isset($items_asistencia))?$items_asistencia[0]->id_asistencia:''; ?>

			$.ajax({
				url: '<?= base_url('supervisor/Home/actualizarAsistencia') ?>',
				type: 'POST',
				dataType: 'json',
				data: {items_usuario: items_usuario, id_asistencia: id_asistencia},
			})
			.done(function(r) {
				if(r){
					id_asistencia = <?php echo (isset($items_asistencia)) ? $items_asistencia[0]->id_asistencia : ''; ?>

					$.ajax({
						url: '<?= base_url('supervisor/Home/finalizarAsistencia') ?>',
						type: 'POST',
						dataType: 'json',
						data: {id_asistencia: id_asistencia},
					})
					.done(function(r) {
						if(r.status){
							alertify.notify('Asistencia finalizada', 'success', 2, function(){
							window.location.href = '../Home/asistencia';
							});
							return;
						}

						alertify.alert("Ocurrio un error al finalizar lista");
					})
					.fail(function(r) {
						console.log("error");
						console.log(r);

					});
				}
			})
			.fail(function(r) {
				console.log("error");
				console.log(r);
			});
			

		},
        function(){
            alertify.confirm().close();
        });

    });
    $("#btn_abrir_asistencia").on('click', function(e) {
        e.preventDefault();
		fecha_asistencia = $("#fecha_asistencia").val()
		
        alertify.confirm("Nomina" , "¿Abrir nueva asistencia?",
        function(){
			if(fecha_asistencia == ""){
				alertify.alert("Selecciona una fecha");
				return;
			}
			$.ajax({
				url: '<?= base_url('supervisor/Home/verificarAsistencia') ?>',
				type: 'POST',
				dataType: 'json',
				data: {fecha_asistencia: fecha_asistencia},
			})
			.done(function(r) {
					if(r.status){
						alertify.notify('Lista creada', 'success', 2, function(){
							window.location.href = '../Home/asistencia';
						});
						return;
					}
					if (r.mensaje == "Asistencia ya creada") {
						alertify.alert("Asistencia ya creada");
						return;
					}

					alertify.alert("No dispones con empleados asignados");
			})
			.fail(function(r) {
				console.log("error");
				console.log(r);
			});
        },
        function(){
            alertify.confirm().close();
        });

    });

    $(".btn_chek").on('change', function(e) {
        $(this).parents('tr').find('select').toggle();
    })


</script>
