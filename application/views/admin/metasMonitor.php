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
                                        <h2 class="d-inline">Metas</h2>
                                    </div>
                                </div>
								<div class="row mb-3">
									<div class="col-12 text-center">
										<a href="<?php echo base_url('admin/MetasSupervisor/index/general') ?>" class="btn <?php echo ($tittle == "general")? "btn-success": "btn-info"; ?> mb-2 ml-1">General</a>
										<a href="<?php echo base_url('admin/MetasSupervisor/index/registrado') ?>" class="btn <?php echo ($tittle == "registrado")? "btn-success": "btn-info"; ?> mb-2 ml-1">Registradas</a>
									</div>
								</div>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Tipo de usuario</th>
                                                    <th>Numero de Tokens</th>
                                                    <th>Descripcion</th>
                                                    <th>Estado</th>
                                                    <th>Fecha registro</th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodymetas" class="text-center">

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

    function load_metas(valor , pagina) {
		tittle = "<?php echo $tittle; ?>";
        $.ajax({
            url      : '<?= base_url('admin/MetasSupervisor/verMetasSupervisor') ?>',
            method   : 'POST',
            success  : function(r){
                if(r.status){
					if(tittle == "general"){
						data = _.filter(r.data, ['estado', 'sin registrar']);
					}else{
						data = _.filter(r.data, ['estado', 'registrado']);
					}
                    var tbody = '';
                    
                    for(var k=0; k<data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${data[k]['apellidos']}</td>
                            <td class="align-middle text-capitalize">Supervisor</td>
                            <td class="align-middle text-capitalize">${data[k]['num_horas']}</td>
                            <td class="align-middle text-capitalize">${data[k]['descripcion']}</td>
                            <td class="align-middle text-capitalize">${data[k]['estado']}</td>
                            <td class="align-middle text-capitalize">${data[k]['fecha_registro']}</td>
                        </tr>`;
                                    
                    }
                    $('#tbodymetas').html(tbody);
                }
				$("#empty").DataTable( {
					"order": [[ 7, "desc" ]]
				} );
            },
            dataType : 'json'
        });

        return false;
    }

    load_metas('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_metas(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_metas('' , link);
    });
</script>
