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
                                        <h2 class="d-inline">Nomina Modelos</h2>
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
                                                    <th class="important">Documento</th>
                                                    <th class="important">Nombres</th>
                                                    <th class="important">Apellidos</th>
                                                    <th class="important">Valor Dolar</th>
                                                    <th class="important">Dias asistidos</th>
                                                    <th class="important">Estado meta</th>
                                                    <th class="important">Tokens meta</th>
                                                    <th class="important">Porcentaje de paga</th>
                                                    <th class="important">Descuento</th>
                                                    <th class="important">Aumentos</th>
                                                    <th class="important">Penalizaciones Tokens</th>
                                                    <th class="important">Total Tokens</th>
													<th class="important">Descripcion</th>
                                                    <th class="important">Total Pago</th>
                                                    <th class="important">Fecha inicial</th>
                                                    <th class="important">Fecha final</th>
                                                    <th>imprimir</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyfactura" class="text-center">

                                            </tbody>
                                        </table>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay factura</span></p>
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

<script>
    $(document).ready(function() {
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
			ruta = "<?php echo base_url('admin/home/nomina/') ?>"+fecha_inicial+"/"+fecha_final
			window.location.href = ruta;
		});
		$(".btn_resetear").click(function(event){
			event.preventDefault();
			ruta = "<?php echo base_url('admin/home/nomina') ?>"
			window.location.href = ruta;
		});
    });
    function load_factura(valor , pagina) {
        fecha_inicio = "<?php echo $fecha_inicial; ?>";
        fecha_final = "<?php echo $fecha_final; ?>";
        
        $.ajax({
            url      : '<?= base_url('admin/Home/getfacturas') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina, fecha_inicio: fecha_inicio, fecha_final: fecha_final},
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['apellidos']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['valor_dolar']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['cant_dias']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['estado_meta']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['num_horas']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['porcentaje_paga']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['descuento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['aumentos']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['penalizacion_horas']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['total_horas']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['descripcion']}</td>`

							if(r.data[k]['nuevo_valor'] != null){
								tbody += `<td class="align-middle text-capitalize">${new Intl.NumberFormat('en-US').format(r.data[k]['nuevo_valor'])} </td>`
							}else{
								tbody += `<td class="align-middle text-capitalize">${new Intl.NumberFormat('en-US').format(r.data[k]['total_a_pagar'])}</td>`
							}
						tbody += `
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_inicio']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_final']}</td>
                            <td class="align-middle text-capitalize">
                                <a href="<?php echo base_url('Imprimir_factura/getFacturaInf/') ?>${r.data[k]['id_factura']}" target="_blank"><img src="<?php echo base_url('assets/iconos_menu/impresora.png') ?>" alt="" style="width: 20px; height: 20px;"> </a>
                            </td>

                            <td class="align-middle">
                                <a href="<?php echo site_url('admin/Home/verRegistrosFactura/') ?>${r.data[k]['id_factura']}" class="text-dark"><img src="<?php echo base_url('assets/iconos_menu/verificar.png') ?>" alt="" style="width: 20px; height: 20px;"> </a>
								<a href="<?php echo site_url('admin/Home/editarFactura/') ?>${r.data[k]['id_factura']}" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; "> </a>
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
							title: 'Nomina modelos',
							messageTop: 'Nomina',
							exportOptions: {
								columns: ['.important']
							}
						},
					]
				} )
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

    
    
</script>
