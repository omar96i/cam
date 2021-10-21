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
                                        <h2 class="d-inline">Paginas</h2>
                                        <a href="<?php echo base_url('admin/Home/addpaginas') ?>" class="btn btn-info mb-2 ml-1">Agregar</a>
                                        <a href="<?php echo base_url('admin/Home/asignarpaginas') ?>" class="btn btn-info mb-2 ml-1">Asignar</a>
                                    </div>
                                </div>

                                <?php if(!empty($paginas)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Url pagina</th>
                                                    <th>Estado</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodypaginas" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay paginas</span></p>
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
    function load_paginas(valor , pagina) {
        $.ajax({
            url      : '<?= base_url('admin/home/verpaginas') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina},
            success  : function(r){
                console.log(r.data);
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['id_pagina']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['url_pagina']}</td>}
                            <td class="align-middle text-capitalize">${r.data[k]['estado']}</td>
                            <td class="align-middle">
                                <a href="<?php echo site_url('admin/Home/editarpaginas/') ?>${r.data[k]['id_pagina']}" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                                <a href="<?php echo site_url('admin/Home/infasignados/') ?>${r.data[k]['id_pagina']}" class="text-info"><img src="<?php echo base_url('assets/iconos_menu/ojo.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                            </td>
                        </tr>`;
                    }
                    $('#tbodypaginas').html(tbody);
					$("#empty").DataTable()

                    // Total de Usuarios y la cantidad por registro
                    
                }
            },
            dataType : 'json'
        });

        return false;
    }

    load_paginas('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_paginas(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_paginas('' , link);
    });

    $('body').on('click' , '.btn_deletepersonal' , function(e){
        e.preventDefault();

        var id_producto = $(this).data('id_persona'),
            ruta        = "<?php echo base_url('admin/home/detele_personal') ?>";

            alertify.confirm("Psicologia Integral" , "¿Está seguro que quiere eliminar el registro?",
            function(){
                $.ajax({
                    url      : ruta,
                    method   : 'POST',
                    data     : {id_persona : id_persona},
                    success  : function(r){
                        if(r.status){
                            alertify.success('Registro eliminado');
                            load_personal('' , 1);
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
