<!-- Main content -->
<div class="content-wrapper">
	<!-- Content area -->
	<div class="content" id="imprimir_text">
		<!-- Main charts -->
		<div class="row">
			<div class="col-xl-12">
				<!-- Traffic sources -->
				<div class="text-center container">
					<img width="100%" src="<?php echo base_url('assets/images/titulo.png'); ?>">
				</div>
				<h4 class="my-3 text-center"><strong>NIT 901034209-7</strong></h4>
				<div class="container">
					<p style="font-size: 1.4em;">Dosquebradas, <span class="dia"></span> de <span class="mes"></span> de <span class="year"></span></p>
					<h4 class="my-3"><strong>A quien le interese:</strong></h4><br>
					<p style="font-size: 1.4em;">
						Cordial saludo, <br><br>
						Por medio de la presente, certificamos que la señora <?php echo $consulta1[0]->nombres." ".$consulta1[0]->apellidos ?> identificada con cédula 
						de ciudadanía N° <?php echo $consulta1[0]->documento ?> labora con nuestra compañía desde el día 
						<?php echo $consulta1[0]->fecha_entrada ?> desempeñándose como <?php if(!is_null($consulta1[0]->cargo_aux)){ echo $consulta1[0]->cargo_aux; }else if($consulta1[0]->tipo_cuenta == "empleado"){ echo "modelo"; }else if($consulta1[0]->tipo_cuenta == "supervisor"){ echo "monitor"; }else if($consulta1[0]->tipo_cuenta == "tecnico_sistemas"){ echo "supervisor"; }else{ echo $consulta1[0]->tipo_cuenta; } ?>, con un salario básico 
						de $ <?php echo $consulta1[0]->sueldo_aux ?> <br><br>
						Para constancia se firma en Dosquebradas a los <span class="dia"></span> días del mes de <span class="mes"></span> de <span class="year"></span>.
					</p><br>
					<p class="mt-3" style="font-size: 1.4em;">Cordialmente,</p>
					<div class="col-2">
						<img src="<?php echo base_url('assets/images/firma.png'); ?>">
					</div>
					<p style="font-size: 1.4em;">
						Andrés Felipe García Zapata		<br>			
						Director General. 			<br>			
						CC 18.523.877 de Dosquebradas		<br>		
						Cel 316 7545148	
					</p>
				</div>
				
					
				<!-- /traffic sources -->
			</div>
		</div>
		<!-- /main charts -->
	</div>

	<div class="container text-center my-2">
		<button class="btn btn-success" id="imprimir">PDF</button>
	</div>


<script>
	$(document).ready(function () {
		document.title = "<?php echo $consulta1[0]->nombres. " " . $consulta1[0]->apellidos;  ?>";
		Fecha();
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

	function Fecha(){
		fecha = new Date();
		hoy = fecha.getDate();
		mesActual = fecha.getMonth() + 1;
		añoActual = fecha.getFullYear();
		if(mesActual == 1){
			mesActual = "enero"
		}else if(mesActual == 2){
			mesActual = "febrero"
		}else if(mesActual == 3){
			mesActual = "marzo"
		}else if(mesActual == 4){
			mesActual = "abril"
		}else if(mesActual == 5){
			mesActual = "mayo"
		}else if(mesActual == 6){
			mesActual = "junio"
		}else if(mesActual == 7){
			mesActual = "julio"
		}else if(mesActual == 8){
			mesActual = "agosto"
		}else if(mesActual == 9){
			mesActual = "septiembre"
		}else if(mesActual == 10){
			mesActual = "octubre"
		}else if(mesActual == 11){
			mesActual = "noviembre"
		}else if(mesActual == 12){
			mesActual = "diciembre"
		}

		$(".dia").html(hoy);
		$(".mes").html(mesActual);
		$(".year").html(añoActual);

	}
</script>


