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
                                        <h2 class="d-inline">Metas por defecto</h2>
                                        <a href="<?php echo base_url('admin/DefaultMetas/addMetaDefault') ?>" class="btn btn-info mb-2 ml-1">Agregar</a>
                                    </div>
                                </div>

                                <?php if(!empty($metas)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Tokens</th>
                                                    <th>Aumento</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyadelantos" class="text-center">

                                            </tbody>
                                        </table>

                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay Metas</span></p>
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
    function load_adelantos(valor , pagina) {
        $.ajax({
            url      : '<?= base_url('admin/DefaultMetas/verMetas') ?>',
            method   : 'POST',
            success  : function(r){
                console.log(r)
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
							<td class="align-middle text-capitalize">${r.data[k]['tokens']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['aumento']}</td>

                            <td class="align-middle">`
                            if (r.data[k]['estado'] == "activo") {
                                tbody += `<a href="<?php echo site_url('admin/DefaultMetas/editMeta/') ?>${r.data[k]['id']}" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
								<a href="" data-id="${r.data[k]['id']}" class="text-info btn_deletepersonal" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/eliminar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>`
                            }else{
                                tbody += ``

							}
                        tbody += `</td>
                        </tr>`;
                                
                            
                    }
                    $('#tbodyadelantos').html(tbody);
					$("#empty").DataTable();
                }
            },
			error: function (error) {
				console.log(error)
			},
            dataType : 'json'
        });

        return false;
    }

    load_adelantos('' , 1);

    $('body').on('click' , '.btn_deletepersonal' , function(e){
        e.preventDefault();

        var id = $(this).data('id'),
            ruta        = "<?php echo base_url('admin/DefaultMetas/delete') ?>";

            alertify.confirm("Cams" , "¿Está seguro que quiere eliminar el registro?",
            function(){
                $.ajax({
                    url      : ruta,
                    method   : 'POST',
                    data     : {id : id},
                    success  : function(r){
                        if(r.status){
                            alertify.notify('Registro eliminado', 'danger', 2, function(){
								window.location.href = 'DefaultMetas';
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
