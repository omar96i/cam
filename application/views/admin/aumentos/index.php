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
						<div class="row mb-3">
							<div class="col-12 text-center">
								<a href="<?php echo site_url('admin/Aumentos/Aumentos/index/').'sin_registrar' ?>" class="btn <?php echo ($tipo == "sin_registrar")? "btn-success": "btn-info"; ?> ">Sin registrar</a>
								<a href="<?php echo site_url('admin/Aumentos/Aumentos/index/').'registrados' ?>" class="btn <?php echo ($tipo == "registrados")? "btn-success": "btn-info"; ?> ">Registrados</a>
							</div>
						</div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-8">
                                        <h2 class="d-inline">Aumentos</h2>
                                        <a href="<?php echo base_url('admin/Aumentos/Aumentos/addAumento') ?>" class="btn btn-info mb-2 ml-1">Agregar</a>
                                    </div>
                                </div>

                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Descripcion</th>
                                                    <th>Valor</th>
													<th>Fecha</th>
                                                    <th>Estado</th>
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
    function loadDataTable() {
        $.ajax({
            url      : '<?= base_url('admin/Aumentos/Aumentos/getDataTable') ?>',
            method   : 'POST',
            success  : function(r){
                if(r.status){
					tipo = "<?php echo $tipo; ?>";
					if(tipo == "sin_registrar"){
						data = _.filter(r.data, ['estado', 'sin registrar']);
					}else if(tipo == "registrados"){
						data = _.filter(r.data, ['estado', 'registrado']);
					}
                    var tbody = '';
                    
                    for(var k=0; k<data.length; k++) {
                        tbody += `<tr>
							<td class="align-middle text-capitalize">${data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${data[k]['apellidos']}</td>
							<td class="align-middle text-capitalize">${data[k]['descripcion']}</td>
                            <td class="align-middle text-capitalize">${data[k]['valor']}</td>
                            <td class="align-middle text-capitalize">${data[k]['estado']}</td>
                            <td class="align-middle text-capitalize">${data[k]['fecha']}</td>

                            <td class="align-middle">`
                            if (data[k]['estado'] == "sin registrar") {
                                tbody += `<a href="<?php echo site_url('admin/Aumentos/Aumentos/edit/') ?>${data[k]['id']}" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
								<a href="" data-id_aumento="${data[k]['id']}" class="text-info btn_delete_aumento" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/eliminar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>`
                            }else{
                                tbody += ``

							}
                        tbody += `</td>
                        </tr>`;
                                
                            
                    }
                    $('#tbodyadelantos').html(tbody);
                }
				$("#empty").DataTable({
					"order": [[ 6, "desc" ]]
				} );
            },
			error: function (error) {
				console.log(error)
			},
            dataType : 'json'
        });

        return false;
    }

    loadDataTable();

    $('body').on('click' , '.btn_delete_aumento' , function(e){
        e.preventDefault();

        var id = $(this).data('id_aumento'),
            ruta        = "<?php echo base_url('admin/Aumentos/Aumentos/delete') ?>";

            alertify.confirm("Cams" , "¿Está seguro que quiere eliminar el registro?",
            function(){
                $.ajax({
                    url      : ruta,
                    method   : 'POST',
                    data     : {id : id},
                    success  : function(r){
                        if(r.status){
                            alertify.notify('Registro eliminado', 'danger', 2, function(){
								window.location.href = 'Aumentos';
							});
                            return;
                        }

                        alertify.alert(r.msg);
                    },
					error: function (error) {
						console.log(error)
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
