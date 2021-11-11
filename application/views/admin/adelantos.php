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
                                        <h2 class="d-inline">Adelantos</h2>
                                        <a href="<?php echo base_url('admin/Home/addAdelanto') ?>" class="btn btn-info mb-2 ml-1">Agregar</a>	
                                    </div>
                                </div>
								<div class="row mb-3">
									<div class="col-12 text-center">
										<a href="<?php echo base_url('admin/Home/adelantos/general') ?>" class="btn <?php echo ($tittle == "general")? "btn-success": "btn-info"; ?> mb-2 ml-1">General</a>
										<a href="<?php echo base_url('admin/Home/adelantos/sin_verificar') ?>" class="btn <?php echo ($tittle == "sin_verificar")? "btn-success": "btn-info"; ?> mb-2 ml-1">Sin verificar</a>
										<a href="<?php echo base_url('admin/Home/adelantos/pagando') ?>" class="btn <?php echo ($tittle == "pagando")? "btn-success": "btn-info"; ?> mb-2 ml-1">En proceso</a>
										<a href="<?php echo base_url('admin/Home/adelantos/registrado') ?>" class="btn <?php echo ($tittle == "registrado")? "btn-success": "btn-info"; ?> mb-2 ml-1">Registrados</a>
										<a href="<?php echo base_url('admin/Home/adelantos/cancelado') ?>" class="btn <?php echo ($tittle == "cancelado")? "btn-success": "btn-info"; ?> mb-2 ml-1">Cancelados</a>

									</div>
								</div>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Descripcion</th>
                                                    <th>Valor</th>
                                                    <th>Cantidad de cuotas</th>
                                                    <th>Valor por cuota</th>
                                                    <th>Cuotas Faltantes</th>
                                                    <th>Valor Faltante</th>
                                                    <th>Estado</th>
                                                    <th>Fecha</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyadelantos" class="text-center">

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

<script>
    function load_adelantos(valor , pagina) {
		tittle = "<?php echo $tittle; ?>";
        $.ajax({
            url      : '<?= base_url('admin/home/veradelantos') ?>',
            method   : 'POST',
            success  : function(r){
                if(r.status){
					if(tittle == "general"){
						data = _.filter(r.data, ['estado', 'sin registrar'])
					}else if(tittle == "sin_verificar"){
						data = _.filter(r.data, ['estado', 'por verificar'])
					}else if(tittle == "pagando"){
						data = _.filter(r.data, ['estado', 'pagando'])
					}else if(tittle == "registrado"){
						data = _.filter(r.data, ['estado', 'registrado'])
					}
					else if(tittle == "cancelado"){
						data = _.filter(r.data, ['estado', 'cancelado'])
					}
                    var tbody = '';
                    
                    for(var k=0; k<data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${data[k]['descripcion']}</td>
                            <td class="align-middle text-capitalize">${"$ "+new Intl.NumberFormat().format(data[k]['valor'])}</td>
                            <td class="align-middle text-capitalize">${data[k]['cuota']}</td>
                            <td class="align-middle text-capitalize">${"$ "+new Intl.NumberFormat().format(data[k]['valor']/data[k]['cuota'])}</td>
							<td class="align-middle text-capitalize">${data[k]['cuota_aux']}</td>

                            <td class="align-middle text-capitalize">${"$ "+new Intl.NumberFormat().format(data[k]['valor_aux'])}</td>

                            <td class="align-middle text-capitalize">${data[k]['estado']}</td>
                            <td class="align-middle text-capitalize">${data[k]['fecha_registrado']}</td>

                            <td class="align-middle">`
                            if (data[k]['estado'] == "sin registrar") {
                                tbody += `<a href="<?php echo site_url('admin/Home/editaradelantos/') ?>${data[k]['id_adelanto']}" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>`
                            }
							if (data[k]['estado'] == "por verificar") {
                                tbody += `<a href="<?php echo site_url('admin/Home/editaradelantos/') ?>${data[k]['id_adelanto']}/por_verificar" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>`
                            }
                        tbody += `</td>
                        </tr>`;
                                
                            
                    }
                    $('#tbodyadelantos').html(tbody);
                }
				$("#empty").DataTable( {
					"order": [[ 9, "desc" ]]
				} );
            },
            dataType : 'json'
        });

        return false;
    }

    load_adelantos('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_adelantos(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_adelantos('' , link);
    });

    $('body').on('click' , '.btn_deletepersonal' , function(e){
        e.preventDefault();

        var id_penalizacion = $(this).data('id_persona'),
            ruta        = "<?php echo base_url('admin/home/deletePenalizacion') ?>";

            alertify.confirm("Psicologia Integral" , "¿Está seguro que quiere eliminar el registro?",
            function(){
                $.ajax({
                    url      : ruta,
                    method   : 'POST',
                    data     : {id_penalizacion : id_penalizacion},
                    success  : function(r){
                        if(r.status){
                            alertify.success('Registro eliminado');
                            load_adelantos('' , 1);
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
