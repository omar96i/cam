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
                                        <h2 class="d-inline">Porcentajes Dias</h2>
                                        <a href="<?php echo base_url('admin/Home/addPorcentajesDias') ?>" class="btn btn-info mb-2 ml-1">Agregar</a>
										<a href="<?php echo base_url('admin/Home/diasPorcentajes/general') ?>" class="btn <?php echo ($tittle == "General")? "btn-success": "btn-info"; ?> mb-2 ml-1">General</a>
										<a href="<?php echo base_url('admin/Home/diasPorcentajes/bomgacams') ?>" class="btn <?php echo ($tittle == "Bongacams")? "btn-success": "btn-info"; ?> mb-2 ml-1">Bongacams</a>
                                    </div>
                                </div>
								<div class="text-center">
									<h2 class="d-inline"><?php echo $tittle ?></h2>
								</div>
								
                                <?php if(!empty($porcentajes)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <!--<th>Id Porcentaje</th>-->
                                                    <th>Dias</th>
                                                    <th>%</th>
                                                    <th>Valor a mulplicar</th>
                                                    <th>Estado Meta</th>
                                                    <th>Fecha de registro</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyporcentajes" class="text-center">

                                            </tbody>
                                        </table>

                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay registros</span></p>
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
    function load_porcentajes(valor , pagina) {
        $.ajax({
            url      : '<?= ($tittle == "General") ? base_url('admin/home/verPorcentajeDias') : base_url('admin/home/verPorcentajeDiasBomga'); ?>',

            method   : 'POST',
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <!--<td class="align-middle text-capitalize">${r.data[k]['id_porcentajes_dias']}</td>-->
                            <td class="align-middle text-capitalize">${r.data[k]['cantidad_dias']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['valor']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['valor_multiplicar']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['estado_meta']}</td>

                            <td class="align-middle text-capitalize">${r.data[k]['fecha_registro']}</td>
                            <td class="align-middle">
                                <a href="<?php echo site_url('admin/Home/editarPorcentajesDias/') ?>${r.data[k]['id_porcentajes_dias']}" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                            </td>
                        </tr>`;
                    }
                    $('#tbodyporcentajes').html(tbody);


					$('#empty').DataTable();
                }
            },
            dataType : 'json'
        });

        return false;
    }

    load_porcentajes('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_porcentajes(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_porcentajes('' , link);
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
                            load_porcentajes('' , 1);
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
