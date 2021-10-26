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
							<p style="font-size: 16px"><?php echo $user[0]->nombres." ".$user[0]->apellidos." Monitor de la plataforma" ?>.</p>
							</div>
						</div>
						<div class="col-sm-12">
							<?php if (!empty($meta)): ?>
								<div class="row mt-2">
                                    <div class="col-sm-12">
                                        <div class="card text-center bg-success">
                                            <div class="card-body">
                                                <h5 class="card-title">TOKENS FALTANTES PARA COMPLETAR TU META !!</h5>
                                                <p class="card-text"><?php echo ($total > 0)? $total: "Meta completa"; ?></p>
												<h5 class="card-title">Tokens actuales</h5>
                                                <p class="card-text"><?php echo $num_horas ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							<?php endif ?>
							
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
						
					</div>
					<div class="chart position-relative" id="traffic-sources"></div>
				</div>
				<!-- /traffic sources -->
			</div>
		</div>
		<!-- /main charts -->
	</div>

