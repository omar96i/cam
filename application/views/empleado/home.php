<!-- Main content -->
<div class="content-wrapper">
	<!-- Content area -->
	<div class="content">
		<!-- Main charts -->
		<div class="row">
			<div class="col-xl-12">
				<!-- Traffic sources -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h1 class="card-title">¡Bienvenido!</h1>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
							<p style="font-size: 16px"><?php echo $user[0]->nombres." ".$user[0]->apellidos." Modelo de la plataforma" ?>.</p>
							</div>
							<div class="col-sm-12">
								<h1 class="card-tittle">Paginas</h1>
								<select name="page" id="page" class="form-control">
									<option value="0">Sin seleccionar</option>
									<?php foreach ($paginas as $key => $value) {?>
										<option value="<?php echo $value->id_pagina ?>"><?php echo $value->url_pagina; ?></option>
									<?php
									} ?>
								</select>
								<button type="submit" class="btn btn-success my-2 btn_select_page">Aceptar</button>
								<div class="alert alert-danger" id="error-alert" role="alert" style="display: none;">
									Selecciona una pagina antes de darle al boton de la extension
								</div>
								<div class="alert alert-success" id="success-alert" role="alert" style="display: none;">
									Pagina Seleccionada, Ve a la pagina seleccionada y en el login de esta interactura con la extension
								</div>
								<div style="display: none;">
									<input type="text" id="user">
									<input type="text" id="password">
									<input type="text" id="tipo_pagina">
								</div>
							</div>
							<div class="col-sm-12">
								<h1 class="card-title">Supervisor</h1>
							    <div  class="table-responsive mt-1">
							        <table id="empty" class="table table-sm table-striped table-bordered">
							            <thead class="text-center">
							                <tr>
							                    <!--<th>Id</th>
							                    <th>Documento</th>-->
							                    <th>Nombres</th>
							                    <th>Apellidos</th>
							                </tr>
							            </thead>

							            <tbody class="text-center">	
							            	<?php if ($estado): ?>
							            		<tr>
							            			<!--<td><?php echo $supervisor[0]->id_persona; ?></td>
							            			<td><?php echo $supervisor[0]->documento; ?></td>-->
							            			<td><?php echo $supervisor[0]->nombres; ?></td>
							            			<td><?php echo $supervisor[0]->apellidos; ?></td>
							            		</tr>										            			
							            	<?php endif ?>										            		
							            	<?php if (!$estado): ?>							            		
							            		<tr>
							            			<td colspan="5">Sin asignar</td>
							            		</tr>
							            	<?php endif ?>
							            </tbody>
							        </table>
							    </div>
							</div>

							<div class="col-sm-12">
								<h1 class="card-title">Meta Actual</h1>
							    <div  class="table-responsive mt-1">
							        <table id="empty" class="table table-sm table-striped table-bordered">
							            <thead class="text-center">
							                <tr>
							                    <th>Descripcion</th>
							                    <th>Numero De Tokens</th>
							                    <th>Fecha de Registro</th>
							                </tr>
							            </thead>

							            <tbody class="text-center">	
							            	<?php if (!empty($meta)): ?>
							            		<tr>
							            			<td><?php echo $meta->descripcion; ?></td>
							            			<td><?php echo $meta->num_horas; ?></td>
							            			<td><?php echo $meta->fecha_registro; ?></td>
							            		</tr>										            			
							            	<?php else: ?>						            		
							            		<tr>
							            			<td colspan="3">Sin asignar</td>
							            		</tr>
							            	<?php endif ?>
							            </tbody>
							        </table>
							    </div>
							</div>

							<div class="col-sm-12">
							<?php if (!empty($meta)): ?>
								<div class="row mt-2">
                                    <div class="col-sm-12">
                                        <div class="card text-center bg-success">
                                            <div class="card-body">
                                                <h5 class="card-title">TOKENS FALTANTES PARA COMPLETAR TU META !!</h5>
                                                <p class="card-text"><?php echo ($total > 0)? $total : "Meta completa"; ?></p>
												<h5 class="card-title">Tokens actuales</h5>
                                                <p class="card-text"><?php echo $num_horas['verificados']->cantidad_horas ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							<?php endif ?>
							
							</div>

							<div class="col-sm-12">
								<h1 class="card-title">Ultima factura generada</h1>
							    <div  class="table-responsive mt-1">
							        <table id="empty" class="table table-sm table-striped table-bordered">
							            <thead class="text-center">
							                <tr>
												<th>Estado meta</th>
							                    <th>Dias asistidos</th>
							                    <th>Descuentos</th>
							                    <th>Penalizacion</th>
							                    <th>Total Tokens</th>
							                    <th>Porcentaje</th>
							                    <th>Total paga</th>
							                    <th>Fecha inicio</th>
							                    <th>Fecha final</th>
							                </tr>
							            </thead>

							            <tbody class="text-center">	
							            	<?php if (!$factura): ?>
							            		<tr>
							            			<td colspan="9">Sin asignar</td>
							            		</tr>						            			
							            	<?php else: ?>	
												<tr>
													<td><?php echo $factura[0]->estado_meta; ?></td>
							            			<td><?php echo $factura[0]->cant_dias; ?></td>
							            			<td><?php echo $factura[0]->descuento; ?></td>
							            			<td><?php echo $factura[0]->penalizacion_horas; ?></td>
							            			<td><?php echo $factura[0]->total_horas; ?></td>
							            			<td><?php echo $factura[0]->porcentaje_paga; ?></td>
							            			<td><?php echo (is_null($factura[0]->nuevo_valor))? "$ ".number_format($factura[0]->total_a_pagar):  "$ ".number_format($factura[0]->nuevo_valor); ?></td>
							            			<td><?php echo $factura[0]->fecha_inicio; ?></td>
							            			<td><?php echo $factura[0]->fecha_final; ?></td>
							            		</tr>						            		
							            	<?php endif ?>
							            </tbody>
							        </table>
							    </div>
								<br>
								<div class="container text-center">
									<a href="<?php echo base_url('Imprimir_factura/getFacturaInf/').$factura[0]->id_factura; ?>" target="_blank"><button class="btn btn-success" >Imprimir</button></a>
								</div>
							</div>

							<div class="col-sm-12">
								<h1 class="card-title">Adelanto sin verificar</h1>
							    <div  class="table-responsive mt-1">
							        <table id="empty" class="table table-sm table-striped table-bordered">
							            <thead class="text-center">
							                <tr>
							                    <th>Descripcion</th>
							                    <th>Valor</th>
							                </tr>
							            </thead>

							            <tbody class="text-center">	
							            	<?php if (!$adelanto): ?>
							            		<tr>
							            			<td colspan="2">Sin asignar</td>
							            		</tr>										            			
							            	<?php else: ?>						            		
							            		<tr>
							            			<td><?php echo $adelanto[0]->descripcion ?></td>
							            			<td><?php echo $adelanto[0]->valor ?></td>

							            		</tr>
							            	<?php endif ?>
							            </tbody>
							        </table>
							    </div>
							</div>
						</div>
					</div>
					<div class="chart position-relative" id="traffic-sources"></div>
				</div>
				<!-- /traffic sources -->
			</div>
			<div class="col-6 aling-items-center">
			
			</div>
		</div>
		<!-- /main charts -->
	</div>
	<div class="imprimir_texto">
	</div>

	<script>
		$(document).ready(function () {
			$(".btn_select_page").click(function (e) { 
				e.preventDefault();
				id_pagina = $("#page").val()
				getUsers(id_pagina)
			});
			$("#imprimir").click(function (e) { 
				e.preventDefault();
				id_factura = $("#imprimir").data('id_factura');
				
				$.ajax({
					url: '<?php echo base_url('Imprimir_factura/getFacturaInf') ?>',
					type: 'POST',
					dataType: 'html',
					data: {id_factura:id_factura},
				})
				.done(function(r) {
					console.log(r);
				})
				.fail(function(r) {
					console.log("error");
					console.log(r);
					$(".imprimir_texto").html(r);
				});
			});
		});

		function getUsers(id_pagina){
			$.ajax({
				url: '<?php echo base_url('empleado/Home/GetUserPage') ?>',
				type: 'POST',
				dataType: 'json',
				data: {id_pagina: id_pagina},
			})
			.done(function(r) {
				if(r.status){
					$("#user").val(r.data[0]['correo'])
					$("#password").val(r.data[0]['clave'])
					$("#tipo_pagina").val(r.data[0]['url_pagina'])
				}
			})
			.fail(function(r) {
				console.log("error");
				console.log(r);
			});
		}
	</script>

