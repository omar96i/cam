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
										<p style="font-size: 16px">Este es el administrador de la plataforma. Desde este apartado usted podrá visualizar un resumen de su negocio actual.</p>
									</div>
									<div id="colores">
									  
									</div>
								</div>
							</div>
							<div class="chart position-relative" id="traffic-sources"></div>
						</div>
						<!-- /traffic sources -->
					</div>
				</div>
				<!-- /main charts -->
				<div class="row">
					<div class="col-xl-12">
						<!-- Traffic sources -->
						<div class="card">
							<div class="card-header header-elements-inline">
								<h1 class="card-title">Consultar Nomina General!</h1>
								<a href="#" class="btn btn-info" id="id_consultar_nomina">Consultar Nomina</a>
							</div>

							<div class="card-body">
								<div class="row">
									<div class="col-sm-12">
										<div  class="table-responsive mt-1">
										    <table id="empty" class="table table-sm table-striped table-bordered">
										        <thead class="text-center">
										            <tr>
										                <th>TOTAL NOMINA</th>
										                <th>RANGO DE FECHA INICIO</th>
										                <th>RANGO DE FECHA FINAL</th>
										            </tr>
										        </thead>

										        <tbody id="tbodyfactura" class="text-center">
										        	<tr>
										        		<td id="td_total_nomina"></td>
										        		<td id="td_fecha_inicio"></td>
										        		<td id="td_fecha_final"></td>
										        	</tr>
										        </tbody>
										    </table>

										    <div class="pagination_usuarios mt-2">

										    </div>
										</div>
									</div>
								</div>
							</div>
							<div class="chart position-relative" id="traffic-sources"></div>
						</div>
						<!-- /traffic sources -->
						<div class="card">
							<div class="card-header header-elements-inline">
								<h1 class="card-title">Graficas</h1>
								<div class="col-4">
                                    <div class="input-group">
                                        <input type="date" class="form-control" aria-label="Search penalizaciones" id="fecha_inicial">
                                        <input type="date" class="form-control" aria-label="Search penalizaciones" id="fecha_final">
                                    </div>
	                            </div>

							</div>

							<div class="card-body">
								<div class="row">
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-12 imprimir_grafica">
												<canvas id="grafica1" width="400" height="200"></canvas>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="chart position-relative" id="traffic-sources"></div>
						</div>
					</div>
				</div>
				<!-- /main charts -->
			</div>
			<div class="modal fade" id="ModalConsultarNominaGeneral" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			    <div class="modal-dialog modal-dialog-centered" role="document">
			        <div class="modal-content">
			            <div class="modal-header">
			                <h5 class="modal-title" id="exampleModalLongTitle">Generar Nomina</h5>
			                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                    <span aria-hidden="true">&times;</span>
			                </button>
			            </div>
			            <div class="modal-body">
			                <div class="form-group">
			                    <label for="fecha_inicial" class="col-form-label">Fecha inicial:</label>
			                    <input type="date" id="fecha_inicial" class="form-control" name="fecha_inicial">
			                    <div class="invalid-feedback">El campo no debe quedar vacío</div>
			                </div>
			                
			                <div class="form-group">
			                    <label for="fecha_final" class="col-form-label">Fecha final:</label>
			                    <input type="date" id="fecha_final" class="form-control" name="fecha_final">
			                    <div class="invalid-feedback">El campo no debe quedar vacío</div>
			                </div>
			            </div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			                <button type="button" class="btn btn-primary btn_generar_factura">Registrar</button>
			            </div>
			        </div>
			    </div>
			</div>



			

			<script>
			    $(document).ready(function() {
			    	$("#fecha_inicial").change(function(event) {
			    		Getgrafica();
			    	});
			    	$("#fecha_final").change(function(event) {
			    		Getgrafica();
			    	});

			    	Getgrafica();

			        $("#id_consultar_nomina").click(function(event) {
			        	event.preventDefault();
			            $("#ModalConsultarNominaGeneral").modal('show');
			        });
			       
			    });

			    var colores=[];

			    function getRandomColor() {
			        var num=(Math.floor(Math.random()*4)*4).toString(16);
			        var letters = ['0','F',num];
			        var color = '#';
			        
			        for (var i = 0; i < 3; i++ ) {
			            let pos=Math.floor(Math.random() * letters.length);
			            color += letters[pos];
			            letters.splice(pos,1);
			        }
			        
			        //para evitar que se repitan colores 
			        if(colores.includes(color))
			          return getRandomColor();
			        else
			          colores.push(color)

			        return color;
			    }
			    $('body').on('click' , '.btn_generar_factura' , function(e){
			        e.preventDefault();
			        fecha_inicial = $("#fecha_inicial").val();
			        fecha_final = $("#fecha_final").val();
			    
			        ruta = "<?php echo base_url('admin/Home/consultarNominaGeneral'); ?>";
		            $.ajax({
		                url: ruta,
		                type: 'POST',
		                dataType: 'json',
		                data: {fecha_inicial: fecha_inicial, fecha_final: fecha_final},
		            })
		            .done(function(r) {
		                $("#td_total_nomina").html(r);
		                $("#td_fecha_inicio").html(fecha_inicial);
		                $("#td_fecha_final").html(fecha_final);
		                $("#ModalConsultarNominaGeneral").modal('hide');
		            })
		            .fail(function(r) {
		                console.log("error");
		                console.log(r);
		            });

			        return false;
			    });


			    function Getgrafica(){
			    	$("#grafica1").remove();
		    		grafica = "<canvas id='grafica1' width='400' height='200'></canvas>";
		    		$(".imprimir_grafica").append(grafica);

			    	fecha_inicial = $("#fecha_inicial").val();
			    	fecha_final = $("#fecha_final").val();

			    	$.ajax({
			    		url: '<?php echo base_url('admin/Home/consultarGrafica'); ?>',
			    		type: 'POST',
			    		dataType: 'json',
			    		data: {fecha_inicial: fecha_inicial, fecha_final: fecha_final},
			    	})
			    	.done(function(r) {


			    		console.log("success");
			    		console.log(r);
			    		nombre_paginas = [];
			    		cantidad_horas = [];
			    		colores = [];
			    		for (var i = 0; i < r.length; i++) {
			    			nombre_paginas[i] = r[i][0]['url_pagina'];
			    			cantidad_horas[i] = r[i][0]['cantidad_horas'];
			    			colores[i] = ""+getRandomColor();
			    		}

			    		ctx = $("#grafica1");

			    		var myChart = new Chart(ctx,{
			    			type:"bar",
			    			data:{
			    				labels:nombre_paginas,
			    				datasets:[{
			    					label:'Horas', 
			    					data: cantidad_horas,
			    					backgroundColor: colores
			    				}]
			    			},
			    			options:{
			    				scales:{
			    					yAxes:[{
			    						ticks:{
			    							beginAtZero:true
			    						}
			    					}]
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

