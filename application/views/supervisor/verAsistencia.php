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
                                        <h2 class="d-inline">Asistencias</h2>
                                    </div>
                                </div>

                                <?php if(!empty($asistencia)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Estado</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyasistencia" class="text-center">

                                            </tbody>
                                        </table>
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
                                        <th>estado</th>
                                        <th>motivo inasistencia</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyitems" class="text-center">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-success" id="modificar_asistencia">Registrar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

		<div class="modal fade" id="modalModelo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Agregar Modelo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
						<label for="modelos" class="col-form-label">Modelos:</label>
						<select name="modelos" id="modelos" class="form-control">
						</select>
						<div class="invalid-feedback">El campo no debe quedar vacío</div>
						<input type="text" class="input_id_asistencia" style="display: none;">
                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-success" id="add_modelo">Registrar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

		<div class="modal fade" id="modalEliminarModelo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Agregar Modelo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
						<label for="modelos_eliminar" class="col-form-label">Modelos:</label>
						<select name="modelos_eliminar" id="modelos_eliminar" class="form-control">
						</select>
						<div class="invalid-feedback">El campo no debe quedar vacío</div>
						<input type="text" class="input_id_asistencia_eliminar" style="display: none;">
                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-danger" id="delete_model">Eliminar Modelo</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

<script>
    $(document).ready(function() {
        $("#fecha_inicial_buscar").change(function(event) {
            load_asistencias(1);
        });
        $("#fecha_final_buscar").change(function(event) {
            load_asistencias(1);
        });

		$("#modificar_asistencia").click(function(event) {
            event.preventDefault();
            ModificarAsistencia();
        });
		$("#add_modelo").click(function(event) {
            event.preventDefault();
			AddModelo();
        });

		$("#delete_model").click(function(event) {
            event.preventDefault();
			DeleteModel();
        });
        load_asistencias(1);
        
    });

	function AddModelo(){
		id_modelo = $("#modelos").val()
		id_asistencia = $(".input_id_asistencia").val()
		if ($("#modelos").val() == 0) {
			$("#modelos").addClass('is-invalid');
		}else{
			$("#modelos").removeClass('is-invalid');
		}
		if(id_modelo != 0){
			$.ajax({
				url: '<?= base_url('supervisor/VerAsistencia/AddModelo') ?>',
				type: 'POST',
				dataType: 'json',
				data: {id_asistencia: id_asistencia, id_modelo: id_modelo},
			})
			.done(function(r) {
				if(r.status){
					$("#modalModelo").modal('hide')
					alertify.notify('Modelo Agregada', 'success', 2);
					return;
				}
				alertify.alert('Ups :(' , r.msg);
			})
			.fail(function(r) {
				console.log("error");
				console.log(r);
			});
		}
	}

	function DeleteModel(){
		id_modelo = $("#modelos_eliminar").val()
		id_asistencia = $(".input_id_asistencia_eliminar").val()
		if ($("#modelos").val() == 0) {
			$("#modelos").addClass('is-invalid');
		}else{
			$("#modelos").removeClass('is-invalid');
		}
		if(id_modelo != 0){
			$.ajax({
				url: '<?= base_url('supervisor/VerAsistencia/DeleteModelo') ?>',
				type: 'POST',
				dataType: 'json',
				data: {id_asistencia: id_asistencia, id_modelo: id_modelo},
			})
			.done(function(r) {
				if(r.status){
					$("#modalEliminarModelo").modal('hide')
					alertify.notify('Modelo Eliminada', 'success', 2);
					return;
				}
				alertify.alert('Ups :(' , r.msg);
			})
			.fail(function(r) {
				console.log("error");
				console.log(r);
			});
		}
	}

    function load_asistencias(pagina) {

        $.ajax({
            url      : '<?= base_url('supervisor/VerAsistencia/getAsistencias') ?>',
            method   : 'POST',
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['estado']}</td>
                            <td>
                                <a href="" data-id_asistencia="${r.data[k]['id_asistencia']}" class="text-warning btn_asistencia"><img src="<?php echo base_url('assets/iconos_menu/ojo.png') ?>" alt=""></a>
								<a href="" data-id_asistencia="${r.data[k]['id_asistencia']}" class="btn_agregar_modelo"><img src="<?php echo base_url('assets/iconos_menu/plus.png') ?>" alt="" style="width: 25px;"></a>
								<a href="" data-id_asistencia="${r.data[k]['id_asistencia']}" class="btn_eliminar_modelo"><img src="<?php echo base_url('assets/iconos_menu/eliminar.png') ?>" alt="" style="width: 25px;"></a>
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

					$(".btn_agregar_modelo").on("click", function(event) {
                        event.preventDefault();
						id_asistencia = $(this).data('id_asistencia')
                        $.ajax({
                            url: '<?= base_url('supervisor/VerAsistencia/getModels') ?>',
                            type: 'POST',
                            dataType: 'json',
                        })
                        .done(function(r) {
							var tbody = '';
							tbody += `<option value="0">Sin seleccionar</option>`
							for(var k=0; k<r.modelos.length; k++) {
								tbody += `<option value="${r.modelos[k]['id_persona']}">${r.modelos[k]['nombres']+" "+r.modelos[k]['apellidos']}</option>`;
							}
							$(".input_id_asistencia").val(id_asistencia)
							$("#modelos").html(tbody)
							$("#modalModelo").modal('show')
                        })
                        .fail(function(r) {
                            console.log("error");
                            console.log(r);
                        });
                        
                    });

					$(".btn_eliminar_modelo").on("click", function(event) {
                        event.preventDefault();
						id_asistencia = $(this).data('id_asistencia')
                        $.ajax({
                            url: '<?= base_url('supervisor/VerAsistencia/getModels') ?>',
                            type: 'POST',
                            dataType: 'json',
                        })
                        .done(function(r) {
							var tbody = '';
							tbody += `<option value="0">Sin seleccionar</option>`
							for(var k=0; k<r.modelos.length; k++) {
								tbody += `<option value="${r.modelos[k]['id_persona']}">${r.modelos[k]['nombres']+" "+r.modelos[k]['apellidos']}</option>`;
							}
							$(".input_id_asistencia_eliminar").val(id_asistencia)
							$("#modelos_eliminar").html(tbody)
							$("#modalEliminarModelo").modal('show')
                        })
                        .fail(function(r) {
                            console.log("error");
                            console.log(r);
                        });
                        
                    });

					$('#empty').DataTable( {
						"order": [[ 0, "desc" ]]
					} );
                }
            },
            dataType : 'json'
        });

        return false;
    }

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

</script>
