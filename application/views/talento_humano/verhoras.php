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

	

    <div class="content-header mt-1 mr-3"> 
        <div class="row">
            <div class="col-md-12">
                <a href="<?= base_url('talento_humano/Home/usuarios') ?>" class="btn btn-info float-right">Retroceder</a>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <!-- /page header -->

	

    <div class="content pt-1">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

						<div class="row">
							<div class="col-12 text-center my-2">
									<h5><?php echo $datos_personales[0]->nombres." ".$datos_personales[0]->apellidos ?></h5>
							</div>
							<div class="col-4">
								<div class="alert alert-success text-center" role="alert">
									<h6>Tokens Verificados General</h6>
									<p class="tokens_general"></p>
								</div>
							</div>
							<div class="col-4">
								<div class="alert alert-success text-center" role="alert">
									<h6>Tokens Verificados Bongacams</h6>
									<p class="tokens_bonga"></p>
								</div>
							</div>
							<div class="col-4">
								<div class="alert alert-success text-center" role="alert">
									<h6>Total tokens verificados</h6>
									<p class="tokens_total"></p>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-12 text-center">
								<a href="<?php echo site_url('talento_humano/Home/verhoras/').$usuario.'/'.'sin_registrar' ?>" class="btn <?php echo ($tipo == "sin_registrar")? "btn-success": "btn-info"; ?> ">Sin verificar</a>
								<a href="<?php echo site_url('talento_humano/Home/verhoras/').$usuario.'/'.'verificado' ?>" class="btn <?php echo ($tipo == "verificado")? "btn-success": "btn-info"; ?> ">Verificados</a>
								<a href="<?php echo site_url('talento_humano/Home/verhoras/').$usuario.'/'.'registrado' ?>" class="btn <?php echo ($tipo == "registrado")? "btn-success": "btn-info"; ?> ">Registrados</a>
							</div>
						</div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-6">
                                        <h2 class="d-inline">Pagina</h2>
                                        <a href="#" class="btn btn-info mb-2 ml-1 btn_generar_nomina">Generar Nomina</a>
                                        <a href="#" class="btn btn-info mb-2 ml-1 btn_verificar_nomina">Verificar Tokens</a>
                                    </div>
                                </div>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
													<th>Estado registro</th>
                                                    <th>Url pagina</th>
                                                    <th>Usuario</th>
                                                    <th>Contraseña</th>
                                                    <th>Cantidad Tokens</th>
													<th>Fecha registro</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyregistro_horas" class="text-center">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="chart position-relative" id="traffic-sources"></div>
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
                            <label for="fecha_inicial" class="col-form-label feIn_nomina">Fecha inicial: <?= $fecha_inicial; ?></label>
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

        <div class="modal fade" id="ModalVerificarHoras" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Verificar Horas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fecha_inicial_v" class="col-form-label">Fecha inicial:</label>
                            <input type="date" id="fecha_inicial_v" class="form-control" name="fecha_inicial_v">
                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="fecha_final_v" class="col-form-label">Fecha final:</label>
                            <input type="date" id="fecha_final_v" class="form-control" name="fecha_final_v">
                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn_verificar_horas">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

<script>
    $(document).ready(function() {
        $(".btn_generar_nomina").click(function(event) {
            $("#ModalRegistroNomina").modal('show');
        });
        $("#fecha_inicial_buscar").change(function(event) {
            usuario = $(".search_usuarios").val();
            load_registro_horas(usuario , 1);
        });
        $("#fecha_final_buscar").change(function(event) {
            usuario = $(".search_usuarios").val();
            load_registro_horas(usuario , 1);
        });
        $(".btn_verificar_nomina").click(function(event) {
            $("#ModalVerificarHoras").modal('show');
        });
        $(".btn_verificar_horas").click(function(event) {
            event.preventDefault();
            verificarHoras();
        });
       
    });

    function verificarHoras(){
		
        fecha_inicial_v = $("#fecha_inicial_v").val();
        fecha_final_v = $("#fecha_final_v").val();
        id_usuario = <?php echo $usuario; ?>;
        if($('#fecha_inicial_v').val() == '') {
            $('#fecha_inicial_v').addClass('is-invalid');
        }
        else {
            $('#fecha_inicial_v').removeClass('is-invalid');
        }
        if($('#fecha_final_v').val() == '') {
            $('#fecha_final_v').addClass('is-invalid');
        }
        else {
            $('#fecha_final_v').removeClass('is-invalid');
        }

        if ($('#fecha_inicial_v').val() != '' &&
            $('#fecha_final_v').val() != '') {
			$(".btn_verificar_horas").attr('disabled', true);
            $.ajax({
                url: '<?= base_url('talento_humano/Verhoras/verificarHoras') ?>',
                type: 'POST',
                dataType: 'json',
                data: {fecha_inicial_v: fecha_inicial_v, fecha_final_v:fecha_final_v, id_usuario:id_usuario},
            })
            .done(function(r) {
				$(".btn_verificar_horas").removeAttr("disabled");
                if (r.status) {
                    $("#fecha_inicial_v").val("");
                    $("#fecha_final_v").val("");
                    $("#ModalVerificarHoras").modal('hide');
					alertify.notify('Verificacion exitosa', 'success', 2, function(){
						window.location.reload()
					});
					return;
                }
            })
            .fail(function(r) {
				$(".btn_verificar_horas").removeAttr("disabled");
                console.log("error");
                console.log(r);

            });
            
        }
    }


    function load_registro_horas(valor , pagina) {
		tipo = "<?php echo $tipo; ?>";
        id_usuario = <?php echo $usuario; ?>;
        fecha_inicio = $("#fecha_inicial_buscar").val();
        fecha_final = $("#fecha_final_buscar").val();
        $.ajax({
            url      : '<?= base_url('supervisor/home/gethorasth') ?>',
            method   : 'POST',
            data     : {id_usuario: id_usuario, tipo: tipo},
            success  : function(r){
                if(r.status){
					horas_general = 0;
					horas_bonga = 0;
					if(tipo == "sin_registrar"){
						data = _.filter(r.data, ['estado_registro', 'sin registrar']);
					}else if(tipo == "verificado"){
						data = _.filter(r.data, ['estado_registro', 'verificado']);
					}else if(tipo == "registrado"){
						data = _.filter(r.data, ['estado_registro', 'registrado']);
					}
					tokens = _.filter(r.data, ['estado_registro', 'verificado']);
					_.forEach(tokens, function(value, key) {
						if(value['url_pagina'] == "BongaCams"){
							horas_bonga = horas_bonga + parseInt(value['cantidad_horas']) 
						}else{
							horas_general = horas_general + parseInt(value['cantidad_horas']) 
						}
					});

					$(".tokens_general").html(horas_general)
					$(".tokens_bonga").html(horas_bonga)
					$(".tokens_total").html(horas_bonga+horas_general)

                    var tbody = '';
                    
                    for(var k=0; k<data.length; k++) {
                        tbody += `<tr>
							<td class="align-middle text-capitalize">${(data[k]['estado_registro'] == 'sin registrar')? 'sin verificar': data[k]['estado_registro']}</td>
                            <td class="align-middle text-capitalize">${data[k]['url_pagina']}</td>
                            <td class="align-middle text-capitalize">${data[k]['correo']}</td>
                            <td class="align-middle text-capitalize">${data[k]['clave']}</td>
                            <td class="align-middle text-capitalize">${data[k]['cantidad_horas']}</td>
                            <td class="align-middle text-capitalize">${data[k]['fecha_registro']}</td>`;
                        if (data[k]['estado_registro'] == 'sin registrar' || data[k]['estado_registro'] == 'verificado') {
                            tbody += `<td class="align-middle">
                                <a href="<?php echo site_url('talento_humano/Home/edithoras/') ?>${data[k]['id_registro_horas']+'/'+<?= $this->uri->segment(4) ?>}" class="text-info"><i class="icon-pencil5"></i></a>
                            </td>`;
                        }else{
							tbody += `<td class="align-middle"></td>`;
						}
                        tbody += `</tr>`;
                    }
                    $('#tbodyregistro_horas').html(tbody);
					$('#empty').DataTable( {
						"order": [[ 5, "desc" ]]
					} );
                }else{
					$('#empty').DataTable();
					horas_general = 0;
					horas_bonga = 0;
					$(".tokens_general").html(horas_general)
					$(".tokens_bonga").html(horas_bonga)
					$(".tokens_total").html(horas_bonga+horas_general)
				}
            },
            dataType : 'json'
        });

        return false;
    }

    load_registro_horas('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_registro_horas(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_registro_horas('' , link);
    });

    $('body').on('click' , '.btn_generar_factura' , function(e){
        e.preventDefault();
        if ($("#fecha_final").val()=='') {
            alertify.error('Debe llenar la fecha final');
            return;
        }

        id_persona = <?php echo $usuario; ?>;
        fecha_final = $("#fecha_final").val();
        ruta = "<?php echo base_url('talento_humano/Verhoras/registrar_horas'); ?>";

        alertify.confirm("Nomina" , "¿Está seguro que quiere realizar el registro?",
        function(){
            $.ajax({
                url: ruta,
                type: 'POST',
                dataType: 'json',
                data: {id_persona : id_persona, fecha_final: fecha_final},
                success: function(r) {
                    if(r.status){
						alertify.notify('Registro de nomina realizado', 'success', 2, function(){
							window.location.reload()
						});
						return;
                    }else{
                        alertify.alert(r.msg);
                    }

                },error: function(r) {
                    console.log("error");
                    console.log(r);

                },complete: function(r) {
                    $("#fecha_final").val("");
                    $("#ModalRegistroNomina").modal('hide');
                    alertify.confirm().close();
                }
            });

            return false;
        },
        function(){
            alertify.confirm().close();
        });
            
    }); 
</script>
