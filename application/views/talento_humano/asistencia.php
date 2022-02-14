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
                                    <div class="col-12">
                                        <h2 class="d-inline">Asistencias</h2>
                                    </div>
                                </div>
								<div class="container my-3">
									<div class="form-group">
										<label for="empleado" class="col-form-label">Buscar por Modelo:</label>
										<select name="empleado" id="empleado" class="form-control">
											<option value="0">Sin seleccionar</option>
											<?php foreach ($modelos as $key => $value) {?>
												<option value="<?php echo $value->id_persona ?>"><?php echo $value->documento." / ".$value->nombres." ".$value->apellidos ?></option>
											<?php
											} ?>
										</select>
										<div class="invalid-feedback">El campo no debe quedar vacío</div>
									</div>
									<div class="text-center">
										<button class="btn btn-success btn_searh">Buscar</button>
									</div>
								</div>

                                <?php if(!empty($asistencia)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
													<th>Fecha</th>
                                                    <th>Estado</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyasistencia" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay asistencia</span></p>
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

        <div class="modal fade" id="modalAsistencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modelos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div  class="table-responsive mt-1">
                            <table id="empty" class="table table-sm table-striped table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Documento</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Estado</th>
                                        <th>Motivo inasistencia</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyitems" class="text-center">


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-success" id="modificar_asistencia">Registrar</button>
                        <button type="button" class="btn btn-secondary cerrar-modal" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

<script>
    $(document).ready(function() {
        $("#fecha_inicial_buscar").change(function(event) {
            valor = $(".search_usuarios").val();
            load_asistencias(valor, 1);
        });
        $("#fecha_final_buscar").change(function(event) {
            valor = $(".search_usuarios").val();

            load_asistencias(valor, 1);
        });
        load_asistencias('', 1);

        $(".search_usuarios").keyup(function(event) {
            valor = $(".search_usuarios").val();
            load_asistencias(valor, 1);
        });

        $("#modificar_asistencia").click(function(event) {
            event.preventDefault();
            ModificarAsistencia();
        });

		$(".btn_searh").click(function (e) { 
			e.preventDefault();
			CargarAsistencia();
		});


        $("body").on('change', '.btn_chek', function(e) {
            $(this).parents('tr').find('select').toggle();
        })
    });

    function ModificarAsistencia(){
		$("#modificar_asistencia").attr('disabled', true);
        datos = [];
        filas = $("#tbodyitems tr");
        for (var i = 0; i < filas.length; i++) {
            items = [];
            if($(filas[i]).find('.btn_chek').is(':checked')) {
                items[0] = "registrado";
                items[1] = '';

            }else{
                items[0] = "sin registrar";
                items[1] = $(filas[i]).find('select').val();
            }

            items[2] = $(filas[i]).find('.btn_chek').data('id_empleado');
            datos[i] = items;
        }

        items_usuario = JSON.stringify(datos);
        id_asistencia = $(".id_asistencia").html();

        $.ajax({
            url: '<?= base_url('supervisor/Home/actualizarAsistencia') ?>',
            type: 'POST',
            dataType: 'json',
            data: {items_usuario: items_usuario, id_asistencia: id_asistencia},
        })
        .done(function(r) {
            if(r){
				$("#modificar_asistencia").removeAttr("disabled");
                alertify.notify('Asistencia actualizada', 'success');
                $("#modalAsistencia").modal('hide');
                return;
            }
        })
        .fail(function(r) {
			$("#modificar_asistencia").removeAttr("disabled");
            console.log("error");
            console.log(r);
        });
    }


    function load_asistencias(valor, pagina) {
        fecha_inicio = $("#fecha_inicial_buscar").val();
        fecha_final = $("#fecha_final_buscar").val();
        $.ajax({
            url      : '<?= base_url('talento_humano/Asistencia/getAsistencia') ?>',
            method   : 'POST',
            data     : {valor: valor, pagina : pagina, fecha_inicio: fecha_inicio, fecha_final: fecha_final},
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['apellidos']}</td>
							<td class="align-middle text-capitalize">${r.data[k]['fecha']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['estado']}</td>
                            <td>
                                <a href="" data-id_asistencia="${r.data[k]['id_asistencia']}" class="text-warning btn_asistencia"><img src="<?php echo base_url('assets/iconos_menu/ojo.png') ?>" alt=""></a>
                            </td>`;
                        tbody += `</tr>`;
                    }
                    $('#tbodyasistencia').html(tbody);

                    $(".btn_asistencia").on("click", function(event) {
                        event.preventDefault();
                        id_asistencia = $(this).data('id_asistencia');
                        $.ajax({
                            url: '<?= base_url('talento_humano/Asistencia/getItemsAsistencia') ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {id_asistencia: id_asistencia},
                        })
                        .done(function(r) {

                            body = "";
                            for (var i = 0; i < r[0].length; i++) {
                                body += `<tr>
                                    <td class="align-middle text-capitalize">${r[0][i]['documento']}</td>
									<td class="align-middle text-capitalize">${r[0][i]['nombres']}</td>
									<td class="align-middle text-capitalize">${r[0][i]['apellidos']}</td>`;

                                    if (r[0][i]['estado'] == "registrado") {
                                        body += "<td><input type='checkbox' data-id_empleado='"+r[0][i]['id_persona']+"' class='btn_chek' checked></td>";
                                    }else if(r[0][i]['estado'] == "sin registrar"){
                                        body += "<td><input type='checkbox' data-id_empleado='"+r[0][i]['id_persona']+"' class='btn_chek'></td>";
                                    }

                                    body+=`<td class="align-middle text-capitalize">
                                        <select class="form-control" style="display:${r[0][i]['estado'] == "sin registrar" ? 'block' : 'none'}">
                                            <option value="0" ${r[0][i]['motivo']==null ? 'selected' : ''} disabled>Seleccionar motivo</option>`
                                            $.each(r['motivos'], function() {
                                                body+=`<option ${this['id_motivo']==r[0][i]['motivo'] ? 'selected' : ''} value="${this['id_motivo']}">${this['nombre']}</option>`;
                                            })
                                        body+=`</select>
                                    </td>`;

                                    body += `<td class='id_asistencia'>${r[0][0]['id_asistencia']}</td>
                                </tr>`;
                            }
                            $("#tbodyitems").html(body);
                            $(".id_asistencia").hide();
                            $("#modalAsistencia").modal('show');
                        })
                        .fail(function(r) {
                            console.log("error");
                            console.log(r);
                        });
                        
                    });

					$("#empty").DataTable( {
						"order": [[ 3, "desc" ]]
					} )
                }
            },
            dataType : 'json'
        });

        return false;
    }

	function CargarAsistencia(){
		empleado = $("#empleado").val()
		if ($("#empleado").val() == 0) {
			$("#empleado").addClass('is-invalid');
			return
		}else{
			$("#empleado").removeClass('is-invalid');
		}
		$.ajax({
			type: "POST",
			url: "<?= base_url('talento_humano/Asistencia/getAsistenciasModelo') ?>",
			data: {empleado: empleado},
			dataType: "json",
			success: function (r) {
				if(r.status){
					tbody = ''
					for(var k=0; k<r.asistencias.length; k++) {
						tbody += `<tr>
							<td class="align-middle text-capitalize">${r.asistencias[k]['documento']}</td>
							<td class="align-middle text-capitalize">${r.asistencias[k]['nombres']}</td>
							<td class="align-middle text-capitalize">${r.asistencias[k]['apellidos']}</td>
							<td class="align-middle text-capitalize">${r.asistencias[k]['fecha']}</td>
							<td class="align-middle text-capitalize">${r.asistencias[k]['estado']}</td>
							<td>
								<a href="" data-id_asistencia="${r.asistencias[k]['id_asistencia']}" class="text-warning btn_asistencia"><img src="<?php echo base_url('assets/iconos_menu/ojo.png') ?>" alt=""></a>
							</td>`;
						tbody += `</tr>`;
					}
					table = $('#empty').DataTable()
					table.destroy()
                    $('#tbodyasistencia').html(tbody);

					$(".btn_asistencia").on("click", function(event) {
                        event.preventDefault();
                        id_asistencia = $(this).data('id_asistencia');
                        $.ajax({
                            url: '<?= base_url('talento_humano/Asistencia/getItemsAsistencia') ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {id_asistencia: id_asistencia},
                        })
                        .done(function(r) {

                            body = "";
                            for (var i = 0; i < r[0].length; i++) {
                                body += `<tr>
                                    <td class="align-middle text-capitalize">${r[0][i]['documento']}</td>
									<td class="align-middle text-capitalize">${r[0][i]['nombres']}</td>
									<td class="align-middle text-capitalize">${r[0][i]['apellidos']}</td>`;

                                    if (r[0][i]['estado'] == "registrado") {
                                        body += "<td><input type='checkbox' data-id_empleado='"+r[0][i]['id_persona']+"' class='btn_chek' checked></td>";
                                    }else if(r[0][i]['estado'] == "sin registrar"){
                                        body += "<td><input type='checkbox' data-id_empleado='"+r[0][i]['id_persona']+"' class='btn_chek'></td>";
                                    }

                                    body+=`<td class="align-middle text-capitalize">
                                        <select class="form-control" style="display:${r[0][i]['estado'] == "sin registrar" ? 'block' : 'none'}">
                                            <option value="0" ${r[0][i]['motivo']==null ? 'selected' : ''} disabled>Seleccionar motivo</option>`
                                            $.each(r['motivos'], function() {
                                                body+=`<option ${this['id_motivo']==r[0][i]['motivo'] ? 'selected' : ''} value="${this['id_motivo']}">${this['nombre']}</option>`;
                                            })
                                        body+=`</select>
                                    </td>`;

                                    body += `<td class='id_asistencia'>${r[0][0]['id_asistencia']}</td>
                                </tr>`;
                            }
                            $("#tbodyitems").html(body);
                            $(".id_asistencia").hide();
                            $("#modalAsistencia").modal('show');
                        })
                        .fail(function(r) {
                            console.log("error");
                            console.log(r);
                        });
                        
                    });

					$("#empty").DataTable( {
						"order": [[ 3, "desc" ]]
					} )
				}
				
			}
		});
	}

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        valor = $(".search_usuarios").val();

        var link = $(this).attr('href');
            load_asistencias(valor, link);
    });
</script>
