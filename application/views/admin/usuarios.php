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
                                    <div class="col-8">
                                        <h2 class="d-inline">Usuarios</h2>
                                        <a href="<?= base_url('admin/Home/addusuario') ?>" class="btn btn-info mb-2 ml-1">Agregar</a>
                                    </div>
                                </div>
								<hr>
                                <?php if(!empty($usuarios)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-striped table-bordered" style="border-radius: 50%;">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Foto</th>
                                                    <th>Nombre</th>
                                                    <th>Apellidos</th>
                                                    <th>Fecha de Nacimiento</th>
                                                    <th>Sexo</th>
                                                    <th>Ciudad</th>
                                                    <th>Email</th>
                                                    <th>Tipo usuario</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyusuarios" class="text-center">

                                            </tbody>
                                        </table>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay usuarios</span></p>
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
		<div class="modal fade" id="ModalGenerarPDF" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Generar pdf</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fecha_ingreso" class="col-form-label">Fecha de ingreso</label>
                            <input type="date" id="fecha_ingreso" class="form-control">
                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                        </div>
                        
                        <div class="form-group ocultar">
                            <label for="salario_aux" class="col-form-label">Salario</label>
                            <input type="number" id="salario_aux" class="form-control">
                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn_registrar_valores">Registrar</button>
                        <a class="btn btn-primary btn_generar_pdf">Generar PDF</a>
                    </div>
                </div>
            </div>
        </div>

<script>
    $(document).ready(function() {

		$(".btn_registrar_valores").click(function (e) { 
			e.preventDefault();
			id_persona = $(this).data('id_persona')
			actualizarUsuario(id_persona);
		});
		
        $('.search_usuarios').on('keyup' , function() {
            var search = $(this).val();
            load_usuarios(search , 1);
        });

        $('body').on('click' , '.pagination li a' , function(e){
            e.preventDefault();
            var link = $(this).attr('href');
                load_usuarios('' , link);
        });
    });

	function actualizarUsuario(id_persona){
		fecha_ingreso = $("#fecha_ingreso").val()
		salario_aux = $("#salario_aux").val()
		tipo_cuenta = $(".btn_registrar_valores").data('tipo_cuenta')

		$.ajax({
            url      : '<?= base_url('admin/home/actualizarDatosUsuario') ?>',
            method   : 'POST',
            data     : {fecha_ingreso : fecha_ingreso , salario_aux : salario_aux, id_persona : id_persona, tipo_cuenta: tipo_cuenta},
            success  : function(r){
				if(r.status){
					alertify.notify('Usuario actualizado', 'success', 2, function(){
					window.location.href = '../Home/usuarios';
					});
					return;
				}
            },
            dataType : 'json'
        });
	}

    function load_usuarios(valor , pagina) {
        $.ajax({
            url      : '<?= base_url('admin/home/viewusuarios') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina},
            success  : function(r){
                if(r.status){
                    console.log(r);
                    var tbody = '';
                    for(var k=0; k<r.data.length; k++) {
						if(r.data[k]['tipo_cuenta'] == "tecnico sistemas"){
							r.data[k]['tipo_cuenta'] = "supervisor"
						}else if(r.data[k]['tipo_cuenta'] == "supervisor"){
							r.data[k]['tipo_cuenta'] = "monitor"
						}
                        tbody += `<tr>
							<td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize"><img style="width: 50px; height: 50px; border-radius: 50%;" src="<?php echo base_url('assets/images/imagenes_usuario/'); ?>${r.data[k]['foto']}"></td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['apellidos']}</td>

                           
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_nacimiento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['sexo']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['ciudad']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['correo']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['tipo_cuenta']}</td>
                            <td class="align-middle ">
                                <a href="<?php echo site_url('admin/Home/editarusuarios/') ?>${r.data[k]['id_persona']}" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                                <a href="" class="text-danger btn_deletepersonal" data-id_persona="${r.data[k]['id_persona']}" data-toggle="tooltip" title="Eliminar"><img src="<?php echo base_url('assets/iconos_menu/eliminar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
								<a href="" class="text-info modalPdf" data-tipo_cuenta="${r.data[k]['tipo_cuenta']}" data-id_persona="${r.data[k]['id_persona']}" data-fecha_entrada="${r.data[k]['fecha_entrada']}" data-sueldo_aux="${r.data[k]['sueldo_aux']}"><img src="<?php echo base_url('assets/iconos_menu/pdf.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                            </td>
                        </tr>`;
                    }
                    $('#tbodyusuarios').html(tbody);
					$('#empty').DataTable();
					$(".modalPdf").click(function (e) { 
						e.preventDefault();
						
						$("#fecha_ingreso").val($(this).data('fecha_entrada'))
						$("#salario_aux").val($(this).data('sueldo_aux'))
						$(".btn_registrar_valores").data('id_persona', $(this).data('id_persona'))
						$(".btn_registrar_valores").data('tipo_cuenta', $(this).data('tipo_cuenta'))
						$(".btn_generar_pdf").data('id_persona', $(this).data('id_persona'))
						tipo_cuenta = $(".btn_registrar_valores").data('tipo_cuenta')
						id_user = $(this).data('id_persona')
						if(tipo_cuenta == "supervisor" || tipo_cuenta == "tecnico sistemas"){
							$(".ocultar").show()
						}else{
							$(".ocultar").hide()
						}
						hred = "<?php echo base_url('Pdf/getInfPdf/') ?>"+id_user+""
						$(".btn_generar_pdf").attr('href', hred);
						$("#ModalGenerarPDF").modal('show')
					});
                }
            },
            dataType : 'json'
        });

        return false;
    }

    load_usuarios('' , 1);

    

    $('body').on('click' , '.btn_deletepersonal' , function(e){
        e.preventDefault();

        var id_persona = $(this).data('id_persona'),
            ruta        = "<?php echo base_url('admin/home/detele_personal') ?>";

            alertify.confirm("Nomina" , "¿Está seguro que quiere eliminar el registro?",
            function(){
                $.ajax({
                    url      : ruta,
                    method   : 'POST',
                    data     : {id_persona : id_persona},
                    success  : function(r){
                        if(r.status){
                            alertify.success('Registro eliminado');
                            load_usuarios('' , 1);
                            alertify.confirm().close();
                            return;
                        }

                        alertify.alert(r.msg);
                    },
                    dataType : 'json'
                });

                return false;
            },
            function(){
                alertify.confirm().close();
            });

            
    });
</script>
