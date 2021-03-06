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
					<h1 class="card-title">Cita <?php echo ($notificacion[0]->tipo == "fotografo")  ? "Fotografica" : "Psicologica" ?></h1>
						<?php  $notificacion[0]->tipo = ($notificacion[0]->tipo == "fotografo" ) ? $notificacion[0]->tipo = "Fotografo" : $notificacion[0]->tipo = "Psicologa"; ?>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<p style="font-size: 16px"><strong><?php  echo $notificacion[0]->tipo ?>: </strong><?php echo $notificacion[0]->nombres." ".$notificacion[0]->apellidos; ?></p>
								<p style="font-size: 16px"><strong>Descripcion: </strong><?php echo $notificacion[0]->descripcion; ?></p>
								<p style="font-size: 16px"><strong>Fecha: </strong><?php echo $notificacion[0]->fecha; ?></p>
								<p style="font-size: 16px"><strong>Hora: </strong><?php echo $notificacion[0]->hora; ?></p>
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

