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
                                        <h2 class="d-inline">Nomina General</h2>
                                        <a href="#" class="btn btn-info mb-2 ml-1 btn_registrar_nomina_general">Generar Nomina General</a>
                                    </div>
                                </div>

								<form class="container my-4">
									<div class="row">
										<div class="col">
											<label for="fecha_inicio">Fecha inicial</label>
											<input type="date" value="<?php echo $fecha_inicial ?>" class="form-control fecha_inicial" required>
											<div class="invalid-feedback">El campo no debe quedar vacío</div>
										</div>
										<div class="col">
											<label for="fecha_final">Fecha final</label>
											<input type="date" value="<?php echo $fecha_final ?>" class="form-control fecha_final" required>
											<div class="invalid-feedback">El campo no debe quedar vacío</div>
										</div>
									</div>
									<div class="col-12 text-center my-3">
										<button type="submit" class="btn btn-success btn_buscar_por_fechas">Buscar</button>
										<button type="submit" class="btn btn-danger btn_resetear">Resetear</button>

									</div>
								</form>


                                <?php if(!empty($factura)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th class="important">Documento Empleado</th>
                                                    <th class="important">Nombre Empleado</th>
                                                    <th class="important">Tipo usuario</th>
                                                    <th class="important">Descuento</th>
                                                    <th class="important">Total</th>
                                                    <th class="important">Fecha de registro</th>
                                                    <th class="important">Fecha inicio</th>
                                                    <th class="important">Fecha final</th>
													<th class="important">Descripcion</th>
													<th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyfactura" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay Nomina</span></p>
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
        <div class="modal fade" id="ModalRegistroNominaGeneral" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                            <label for="fecha_inicial_general" class="col-form-label">Fecha inicial:</label>
                            <input type="date" id="fecha_inicial_general" class="form-control" name="fecha_inicial_general">
                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="fecha_final_general" class="col-form-label">Fecha final:</label>
                            <input type="date" id="fecha_final_general" class="form-control" name="fecha_final_general">
                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn_generar_factura_general">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

<script>
    $(document).ready(function() {
        $(".btn_registrar_nomina_general").click(function(event) {
            $("#ModalRegistroNominaGeneral").modal('show');
        });
        $(".btn_buscar_por_fechas").click(function(event){
			event.preventDefault();
			fecha_inicial = $(".fecha_inicial").val()
			fecha_final = $(".fecha_final").val()
			if ($(".fecha_inicial").val() == '') {
                $(".fecha_inicial").addClass('is-invalid');
            }else{
                $(".fecha_inicial").removeClass('is-invalid');
            }
			if ($(".fecha_final").val() == '') {
                $(".fecha_final").addClass('is-invalid');
            }else{
                $(".fecha_final").removeClass('is-invalid');
            }
			if(fecha_inicial == "" || fecha_final == ""){
				return
			}
			ruta = "<?php echo base_url('admin/home/factura_general/') ?>"+fecha_inicial+"/"+fecha_final
			window.location.href = ruta;
		});
		$(".btn_resetear").click(function(event){
			event.preventDefault();
			ruta = "<?php echo base_url('admin/home/factura_general') ?>"
			window.location.href = ruta;
		});
    });
    function load_factura(valor , pagina) {
        fecha_inicio = "<?php echo $fecha_inicial; ?>";
        fecha_final = "<?php echo $fecha_final; ?>";
        
        $.ajax({
            url      : '<?= base_url('admin/Home/getfacturasGeneral') ?>',
            method   : 'POST',
			data     : {fecha_inicio: fecha_inicio, fecha_final: fecha_final},
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['tipo_cuenta']}</td>

                            <td class="align-middle text-capitalize">${r.data[k]['descuentos']}</td>`
							if(r.data[k]['nuevo_valor'] != null){
								tbody += `<td class="align-middle text-capitalize">${new Intl.NumberFormat('en-US').format(r.data[k]['nuevo_valor'])}</td>`
							}else{
								tbody += `<td class="align-middle text-capitalize">${new Intl.NumberFormat('en-US').format(r.data[k]['total_a_pagar'])}</td>`
							}
						tbody+=	`
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_registrado']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_inicial']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_final']}</td>
							<td class="align-middle text-capitalize">${r.data[k]['descripcion']}</td>
							<td class="align-middle">
                                <a href="<?php echo base_url('Imprimir_factura/getFacturaInfGeneral/') ?>${r.data[k]['id_factura_general']}" target="_blank"><img src="<?php echo base_url('assets/iconos_menu/impresora.png') ?>" alt="" style="width: 20px; height: 20px;"> </a>
								<a href="<?php echo site_url('admin/Home/editarFacturaGeneral/') ?>${r.data[k]['id_factura_general']}" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; "> </a>
                            </td>
                            </tr>`;
                    }
                    $('#tbodyfactura').html(tbody);

                    $(".btn_mirar_factura").click(function(e) {
                        e.preventDefault();
                        $("#modalVerRegistros").modal('show');

                    });
                }
				
				$("#empty").DataTable( {
					dom: 'Bfrtip',
					buttons: [
						'copy',
						{
							extend: 'excel',
							title: 'Nomina General',
							messageTop: 'Nomina',
							exportOptions: {
								columns: ['.important']
							}
						},
					]
				} );
            },
            dataType : 'json'
        });

        return false;
    }

    load_factura('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_factura(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_factura('' , link);
    });


    $('body').on('click' , '.btn_generar_factura_general' , function(e){
        e.preventDefault();
        fecha_inicial = $("#fecha_inicial_general").val();
        fecha_final = $("#fecha_final_general").val();
    
        ruta = "<?php echo base_url('admin/Home/registrarFacturasGeneral'); ?>";
        alertify.confirm("Nomina" , "¿Está seguro que quiere realizar el registro?",
        function(){
            $.ajax({
                url: ruta,
                type: 'POST',
                dataType: 'json',
                data: {fecha_inicial: fecha_inicial, fecha_final: fecha_final},
            })
            .done(function(r) {
                if(r.status){
                    $("#fecha_inicial").val("");
                    $("#fecha_final").val("");
                    $("#ModalRegistroNomina").modal('hide');
                    alertify.confirm().close();
                    alertify.notify('Registro exitoso!', 'success', 2, function(){
                        window.location.href = '<?php echo base_url('admin/Home/factura_general') ?>';
                    });
                    return;
                }

                alertify.alert(r.msg);
            })
            .fail(function(r) {
                console.log("error");
                console.log(r);
            });

            return false;
        },
        function(){
            alertify.confirm().close();
        });

            
    });
    
</script>
