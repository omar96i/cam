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
							<p style="font-size: 16px"><?php echo $user[0]->nombres." ".$user[0]->apellidos." Talento humano de la plataforma" ?>.</p>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="row">
									<div class="col-sm-12">
										<canvas id="grafica2"></canvas>
									</div>
								</div>
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

	<script>
		$(document).ready(function () {
			getGraficaMonitor();
		});

		
		function getGraficaMonitor(){
			$.ajax({
				url: '<?php echo base_url('admin/Home/consultarGraficaMonitor'); ?>',
				type: 'POST',
				dataType: 'json',
			})
			.done(function(r) {
				grafica2 = $("#grafica2")
				nombres = []
				tokens_meta = []
				tokens_actuales = []
				for (var i = 0; i < r['data'].length; i++) {
					nombres[i] = r['data'][i]['nombres']+" "+r['data'][i]['apellidos'];
					tokens_meta[i] = r['data'][i]['num_horas'];
					tokens_actuales[i] = r['tokens'][i]
				}
				var grafica = new Chart(grafica2,{
					type:"bar",
					data:{
						labels:nombres,
						datasets:[{
							label:'Tokens meta', 
							data: tokens_meta,
							backgroundColor: 'rgb(255, 99, 132)'
						},
						{
							label:'Tokens actuales', 
							data: tokens_actuales,
							backgroundColor: 'rgb(54, 162, 235)'
						}],
						
					},
					options:{
						plugins: {
							title: {
								display: true,
								text: 'Metas Monitor'
							}
						}
					}
				});

			})
			.fail(function(r) {
				console.log("error");
				console.log(r);
			});
		}
	</script>

