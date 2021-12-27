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
                                    <div class="col-6">
                                        <h2 class="d-inline">Modelos</h2>
                                        <a href="#" class="btn btn-info mb-2 ml-1 btn_registrar_dolar">Ver / Registrar dolar</a>
										<a href="#" class="btn btn-info mb-2 ml-1 btn_generar_nomina">Generar nomina</a>
										<a href="#" class="btn btn-info mb-2 ml-1 btn_ver_errores">ver errores</a>

                                    </div>
									<div class="col-6">
										<div class="alert alert-danger" role="alert">
											Recuerda que antes de empezar a generar la nomina, Se debe establecer el valor del dolar!
										</div>
										<div class="alert alert-success" role="alert">
											Recuerda que puedes simular la nomina en caso de creer que te falten datos por agregar!
										</div>
									</div>
                                </div>

                                <?php if(!empty($empleados)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Tokens sin verificar</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyempleados" class="text-center">

                                            </tbody>
                                        </table>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay modelos</span></p>
                                        </div>
                                    <?php endif; ?>
									<div class="ocultar">
										<div class="row my-5">
											<div class="col-12 text-center">
												<h2 class="d-inline">Simulacion</h2>
											</div>
										</div>
										<div  class="table-responsive mt-1">
											<table id="TableNomina" class="table table-sm table-striped table-bordered">
												<thead class="text-center">
													<tr>
														<th class="important">Documento</th>
														<th class="important">Nombres</th>
														<th class="important">Apellidos</th>
														<th class="important">Dias asistidos</th>
														<th class="important">Estado meta</th>
														<th class="important">Porcentaje de paga</th>
														<th class="important">Descuento</th>
														<th class="important">Aumentos</th>
														<th class="important">Penalizaciones Tokens</th>
														<th class="important">Total Tokens</th>
														<th class="important">Total Pago</th>
														<th class="important">Fecha inicial</th>
														<th class="important">Fecha final</th>
													</tr>
												</thead>

												<tbody id="tbodynomina" class="text-center">

												</tbody>
											</table>
										</div>
									</div>
									
                                </div>
                            </div>
                        </div>

                        <div class="chart position-relative" id="traffic-sources"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalRegistroDolar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Registro dolar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
						<div class="alert alert-success" role="alert">
							<h6 class="valor_dolar">Valor dolar: </h6>
						</div>
                        <div class="form-group">
                            <label for="valor_dolar" class="col-form-label">Nuevo valor del dolar:</label>
                            <input type="number" id="valor_dolar" class="form-control" name="valor_dolar">
                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn_registro_dolar">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

		<div class="modal fade" id="ModalRegistroNomina" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                            <label for="fecha_inicio" class="col-form-label">Fecha final:</label>
                            <input type="date" id="fecha_inicio" class="form-control" name="fecha_inicio">
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
                        <button type="button" class="btn btn-primary btn_generar_prefactura">Simular Nomina</button>
                        <button type="button" class="btn btn-primary btn_generar_factura">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

		<div class="modal fade" id="ModalReporteErrores" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Reporte de errores</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
						<table id="TableError" class="table table-sm table-striped table-bordered">
							<thead class="text-center">
								<tr>
									<th>Documento</th>
									<th>Nombres</th>
									<th>Apellidos</th>
									<th>Error</th>
								</tr>
							</thead>

							<tbody id="tbodyerrores" class="text-center">
							</tbody>
						</table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

<script>
    $(document).ready(function() {
		$(".ocultar").hide()
        $(".btn_registro_dolar").click(function(event) {
            valor_dolar = $("#valor_dolar").val();
            $.ajax({
                url: '<?= base_url('talento_humano/Home/registrodolar') ?>',
                type: 'POST',
                dataType: 'json',
                data: {valor_dolar: valor_dolar},
            })
            .done(function(r) {
                if(r.status){
                    $("#valor_dolar").val("");
                    $("#modalRegistroDolar").modal('hide');

                    alertify.success('Registro exitoso');
                    alertify.confirm().close();
                    return;
                }

                alertify.alert(r.msg);
            })
            .fail(function(r) {
                console.log("error");
                console.log(r);
            }); 
        });
        $(".btn_registrar_dolar").click(function(event) {
            $("#modalRegistroDolar").modal('show');
            $.ajax({
                url: '<?= base_url('talento_humano/Home/getvalordolar') ?>',
                dataType: 'json',
            })
            .done(function(r) {
                if (!r.status) {
                    $(".valor_dolar").html("Valor dolar: Sin registrar")
                }else{
                    $(".valor_dolar").html("Valor Actual Dolar: "+r.lista['valor_dolar']);
                }

            })
            .fail(function(r) {
                console.log("error");
                console.log(r);
            });
            
        });

		$(".btn_generar_nomina").click(function (e) { 
			e.preventDefault();
			$("#ModalRegistroNomina").modal('show');
		});
		$(".btn_ver_errores").click(function (e) { 
			e.preventDefault();
			$("#ModalReporteErrores").modal('show');
		});
		$(".btn_generar_prefactura").click(function (e) { 
			e.preventDefault();
			RegistrarPreNomina();
		});
		$(".btn_generar_factura").click(function (e) { 
			e.preventDefault();
			RegistrarNomina();
		});
    });

	function RegistrarPreNomina(){
		fecha_inicio = $("#fecha_inicio").val()
		fecha_final = $("#fecha_final").val()
		alertify.confirm("Nomina" , "¿Está seguro que quiere realizar el registro?",
        function(){
			$.ajax({
				url : '<?= base_url('talento_humano/Home/GenerarPreNominaModelos') ?>',
				data : { fecha_inicio : fecha_inicio, fecha_final: fecha_final },
				type : 'POST',
				dataType : 'json',
				success : function(r) {
					if(r.status){
						table = $("#TableNomina").DataTable();
						table.destroy()
						var tbody = '';
						for(var k=0; k<r.data.length; k++) {
							tbody += `<tr>
								<td class="align-middle text-capitalize">${r.data[k]['modelo']['documento']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['modelo']['nombres']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['modelo']['apellidos']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['nominas']['cant_dias']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['nominas']['estado_meta']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['nominas']['porcentaje_paga']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['nominas']['descuento']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['nominas']['aumentos']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['nominas']['penalizacion_horas']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['nominas']['total_horas']}</td>
								<td class="align-middle text-capitalize">${new Intl.NumberFormat('en-US').format(r.data[k]['nominas']['total_a_pagar'])}</td>
								<td class="align-middle text-capitalize">${r.data[k]['nominas']['fecha_inicio']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['nominas']['fecha_final']}</td>
							</tr>`
						}
						$('#tbodynomina').html(tbody);
						$(".ocultar").show()
						table = $("#TableNomina").DataTable();
						$("#ModalRegistroNomina").modal('hide')
						alertify.notify(
							'Simulacion creada', 
								'success', 
							2
						);
                    }else{
						table = $("#TableError").DataTable();
						table.destroy()
						var tbody = '';
                    
						for(var k=0; k<r.data.length; k++) {
							tbody += `<tr>
								<td class="align-middle text-capitalize">${r.data[k]['modelo']['documento']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['modelo']['nombres']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['modelo']['apellidos']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['error']}</td>
							</tr>`;
						}
						$('#tbodyerrores').html(tbody);
						$("#TableError").DataTable();
						$("#fecha_inicio").val('')
						$("#fecha_final").val('')
						$("#ModalRegistroNomina").modal('hide')
						$("#ModalReporteErrores").modal('show')
                        alertify.alert(r.msg);
                    }
				},
				error : function(xhr, status) {
					console.log(status)
					console.log(xhr)
				}
			});
                    

        },
        function(){
            alertify.confirm().close();
        });
		
	}

	function RegistrarNomina(){
		fecha_inicio = $("#fecha_inicio").val()
		fecha_final = $("#fecha_final").val()
		alertify.confirm("Nomina" , "¿Está seguro que quiere realizar el registro?",
        function(){
			$.ajax({
				url : '<?= base_url('talento_humano/Home/GenerarNominaModelos') ?>',
				data : { fecha_inicio : fecha_inicio, fecha_final: fecha_final },
				type : 'POST',
				dataType : 'json',
				success : function(r) {
					if(r.status){
						$("#ModalRegistroNomina").modal('hide')
						alertify.notify('Nomina Generada', 'success', 2, function(){
							window.location.reload();
						});
                    }else{
						table = $("#TableError").DataTable();
						table.destroy()
						var tbody = '';
						for(var k=0; k<r.data.length; k++) {
							tbody += `<tr>
								<td class="align-middle text-capitalize">${r.data[k]['modelo']['documento']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['modelo']['nombres']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['modelo']['apellidos']}</td>
								<td class="align-middle text-capitalize">${r.data[k]['error']}</td>
							</tr>`;
						}
						$('#tbodyerrores').html(tbody);
						$("#TableError").DataTable();
						$("#fecha_inicio").val('')
						$("#fecha_final").val('')
						$("#ModalRegistroNomina").modal('hide')
						$("#ModalReporteErrores").modal('show')

                        alertify.alert(r.msg);
                    }
				},
				error : function(xhr, status) {
					console.log(status)
					console.log(xhr)
				}
			});
        },
        function(){
            alertify.confirm().close();
        });
		
	}

    function load_empleados(valor , pagina) {
        $.ajax({
            url      : '<?= base_url('talento_humano/Home/verempleados') ?>',
            method   : 'POST',
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['apellidos']}</td>
                            <td class="align-middle text-capitalize">${r.can_registros[k]}</td>
                            <td class="align-middle">
                                <a href="<?php echo site_url('talento_humano/Home/verhoras/') ?>${r.data[k]['id_persona']}" class="text-dark"><img src="<?php echo base_url('assets/iconos_menu/reloj.png') ?>"</a>
                                <a href="<?php echo site_url('talento_humano/Home/verPenalizaciones/') ?>${r.data[k]['id_persona']}" class="text-warning"><img src="<?php echo base_url('assets/iconos_menu/alerta.png') ?>" alt=""></a>
                            </td>
                        </tr>`;
                    }
                    $('#tbodyempleados').html(tbody);
                    
                }
				$('#empty').DataTable( {
					"order": [[ 3, "desc" ]]
				} );
            },
            dataType : 'json'
        });

        return false;
    }

    load_empleados('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_empleados(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_empleados('' , link);
    });



    
</script>
