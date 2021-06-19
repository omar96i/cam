<!-- Main content -->
<div class="content-wrapper">
	<!-- Content area -->
	<div class="content" id="imprimir_text">
		<!-- Main charts -->
		<div class="row">
			<div class="col-xl-12">
				<!-- Traffic sources -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h1 class="card-title">Factura</h1>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<p style="font-size: 16px">Documento: <?php echo $consulta1[0]->documento; ?></p>
								<p style="font-size: 16px">Nombres: <?php echo $consulta1[0]->nombres; ?></p>
								<p style="font-size: 16px">Apellidos: <?php echo $consulta1[0]->apellidos; ?></p>

							</div>
							<div class="col-sm-12">
								<h1 class="card-title">Horas Registradas</h1>
							    <div  class="table-responsive mt-1">
							        <table id="empty" class="table table-sm table-striped table-bordered">
							            <thead class="text-center">
							                <tr>
							                    <th>Horas</th>
							                    <th>Fecha</th>
							                </tr>
							            </thead>

							            <tbody class="text-center">	
                                            <?php
                                                foreach ($consulta1 as $i => $valor){?>
                                                    <tr>
                                                        <td><?php echo $valor->cantidad_horas; ?></td>
                                                        <td><?php echo $valor->horas_factura; ?></td>

                                                    </tr>
                                            <?php
                                                }
                                            ?>
							            </tbody>
							        </table>
							    </div>
							</div>

                            <div class="col-sm-12">
								<h1 class="card-title">Horas Registradas</h1>
							    <div  class="table-responsive mt-1">
							        <table id="empty" class="table table-sm table-striped table-bordered">
							            <thead class="text-center">
							                <tr>
							                    <th>Valor dolar</th>
							                    <th>Total Tokens</th>
							                    <th>Dias asistidos</th>
							                    <th>Descuentos</th>
							                    <th>Penalizaciones</th>
							                    <th>Pago total</th>

							                </tr>
							            </thead>

							            <tbody class="text-center">	
                                            <tr>
                                                <td><?php echo $consulta1[0]->valor_dolar; ?></td>
                                                <td><?php echo $consulta1[0]->total_horas; ?></td>
                                                <td><?php echo $consulta1[0]->cant_dias; ?></td>
                                                <td><?php echo $consulta1[0]->descuento; ?></td>
                                                <td><?php echo $consulta1[0]->penalizacion_horas; ?></td>
                                                <td><?php echo "$ ".number_format($consulta1[0]->total_a_pagar); ?></td>
                                            </tr>
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


