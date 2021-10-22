<!-- Main content -->
<div class="content-wrapper">
	<!-- Content area -->
	<div class="content" id="imprimir_text">
		<!-- Main charts -->
		<div class="row">
			<div class="col-xl-12">
				<!-- Traffic sources -->
				<div class="card">
					<div class="text-center container">
					<img width="100%" src="<?php echo base_url('assets/images/titulo.png'); ?>">
					</div>
					<?php if ($consulta1[0]->mes == 1 ){ $consulta1[0]->mes = "ENERO"; } ?>
					<?php if ($consulta1[0]->mes == 2 ){ $consulta1[0]->mes = "FEBRERO"; } ?> 
					<?php if ($consulta1[0]->mes == 3 ){ $consulta1[0]->mes = "MARZO"; } ?> 
					<?php if ($consulta1[0]->mes == 4 ){ $consulta1[0]->mes = "ABRIL"; } ?> 
					<?php if ($consulta1[0]->mes == 5 ){ $consulta1[0]->mes = "MAYO"; } ?> 
					<?php if ($consulta1[0]->mes == 6 ){ $consulta1[0]->mes = "JUNIO"; } ?> 
					<?php if ($consulta1[0]->mes == 7 ){ $consulta1[0]->mes = "JULIO"; } ?> 
					<?php if ($consulta1[0]->mes == 8 ){ $consulta1[0]->mes = "AGOSTO"; } ?> 
					<?php if ($consulta1[0]->mes == 9 ){ $consulta1[0]->mes = "SEPTIEMBRE"; } ?> 
					<?php if ($consulta1[0]->mes == 10 ){ $consulta1[0]->mes = "OCTUBRE"; } ?> 
					<?php if ($consulta1[0]->mes == 11 ){ $consulta1[0]->mes = "NOVIEMBRE"; } ?> 
					<?php if ($consulta1[0]->mes == 12 ){ $consulta1[0]->mes = "DICIEMBRE"; } ?>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12 my-2">
								<p style="font-size: 16px">Documento: <?php echo $consulta1[0]->documento; ?></p>
								<p style="font-size: 16px">Nombres: <?php echo $consulta1[0]->nombres; ?></p>
								<p style="font-size: 16px">Apellidos: <?php echo $consulta1[0]->apellidos; ?></p>
							</div>
							<div class="table-responsive mt-1">
								<table id="empty" class="table table-sm table-striped table-bordered">
									<thead class="text-center">
										<tr>
											<th colspan="10" style="font-size: 1.2em;">DESPRENDIBLE DE NOMINA</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="1" class="col-2" style="font-size: 1.2em;">
												<strong>FECHA</strong> 
											</td>
											<td colspan="7" class="text-right" style="font-size: 1.2em;">
												<?php echo $consulta1[0]->mes ?>
											</td>
										</tr>
										<tr>
											<td colspan="1" class="col-2" style="font-size: 1.2em;"><strong>CONCEPTO</strong> </td>
											<td colspan="7" class="text-right" style="font-size: 1.2em;">NOMINA DEL <?php echo $consulta1[0]->dia1; ?> AL <?php echo $consulta1[0]->dia2 ?> DE <?php echo $consulta1[0]->mes ?> DE <?php echo $consulta1[0]->year ?></td>
										</tr>
										<tr>
											<td colspan="1" class="col-2" style="font-size: 1.2em;"><strong>CARGO</strong> </td>
											<td colspan="7" class="text-right" style="font-size: 1.2em; text-transform: uppercase;"><?php if($consulta1[0]->tipo_cuenta == "tecnico sistemas"){ echo "SUPERVISOR"; }else{ echo $consulta1[0]->tipo_cuenta; } ?></td>
										</tr>
									</tbody>
								</table>
							</div>
							    <div  class="table-responsive mt-1">
							        <table id="empty" class="table table-sm table-striped table-bordered">
							            <thead class="text-center">
							                <tr>
							                    <th>Descuentos</th>
							                    <th>Pago total</th>
							                </tr>
							            </thead>
									
							            <tbody class="text-center">	
                                            <tr>
                                                <td><?php echo $consulta1[0]->descuentos; ?></td>
                                                <td><?php echo "$ ".number_format(($consulta1[0]->nuevo_valor == null)?$consulta1[0]->total_a_pagar : $consulta1[0]->nuevo_valor); ?></td>
                                            </tr>
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

	<div class="container">
		<button class="btn btn-success" id="imprimir">IMPRIMIR</button>
	</div>


<script>
	$(document).ready(function () {
		$("#imprimir").click(function (e) { 
			e.preventDefault();
			texto = ""+$("#imprimir_text");
			console.log(texto)
			imprimirElemento(texto);
		});
	});

	function imprimirElemento(elemento){
		var contenido= document.getElementById("imprimir_text").innerHTML;
		var contenidoOriginal= document.body.innerHTML;

		document.body.innerHTML = contenido;

		window.print();

		document.body.innerHTML = contenidoOriginal;
	}

</script>


