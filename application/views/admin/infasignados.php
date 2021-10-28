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
                                        <h2 class="d-inline">Pagina</h2>
                                    </div>
                                </div>

                                <?php if(!empty($asignaciones)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nombre pagina</th>
                                                    <th>Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Nick/Usuario</th>
                                                    <th>Contraseña</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyasignaciones" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay asignaciones</span></p>
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
    function load_asignaciones(valor , pagina) {
        id_pagina = <?php echo $id_relacion[0]->id_pagina ?>;
        $.ajax({
            url      : '<?= base_url('admin/home/verasignaciones') ?>',
            method   : 'POST',
            data     : {id_pagina: id_pagina},
            success  : function(r){
                console.log(r.data);
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['id_pagina']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['url_pagina']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['apellidos']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['correo']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['clave']}</td>
                            <td class="align-middle">
                                <a href="<?php echo site_url('admin/Home/editarasignaciones/') ?>${r.data[k]['id_persona_pag']}" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                                <a href="" class="text-danger btn_deletepersonal" data-id_persona="${r.data[k]['id_persona_pag']}" data-toggle="tooltip" title="Eliminar"><img src="<?php echo base_url('assets/iconos_menu/eliminar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                            </td>
                        </tr>`;
                    }
                    $('#tbodyasignaciones').html(tbody);
					$("#empty").DataTable()
                }
            },
            dataType : 'json'
        });

        return false;
    }

    load_asignaciones('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_asignaciones(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_asignaciones('' , link);
    });

    $('body').on('click' , '.btn_deletepersonal' , function(e){
        e.preventDefault();

        var id_relacion = $(this).data('id_persona'),
            ruta        = "<?php echo base_url('admin/home/delete_relacion_pages') ?>";

            alertify.confirm("Nomina" , "¿Está seguro que quiere eliminar el registro?",
            function(){
                $.ajax({
                    url      : ruta,
                    method   : 'POST',
                    data     : {id_relacion : id_relacion},
                    success  : function(r){
                        if(r.status){
                            alertify.success('Registro eliminado');
                            alertify.confirm().close();
                            window.location.href = '../paginas';
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
