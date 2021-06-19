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

                                    <div class="col-4">
                                        <?php if(!empty($usuarios)): ?>
                                            <div class="input-group">
                                                <input type="text" class="form-control search_usuarios" placeholder="Buscar (por nombre)..." aria-label="Search usuarios">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if(!empty($usuarios)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered" style="border-radius: 50%;">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Foto</th>
                                                    <th>Nombre</th>
                                                    <th>Documento</th>
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
                                    <div class="pagination_usuarios mt-2">

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

<script>
    $(document).ready(function() {
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
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['id_persona']}</td>
                            <td class="align-middle text-capitalize"><img style="width: 50px; height: 50px; border-radius: 50%;" src="<?php echo base_url('assets/images/imagenes_usuario/'); ?>${r.data[k]['foto']}"></td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>}
                            <td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_nacimiento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['sexo']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['ciudad']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['correo']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['tipo_cuenta']}</td>

                            <td class="align-middle ">
                                <a href="<?php echo site_url('admin/Home/editarusuarios/') ?>${r.data[k]['id_persona']}" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                                <a href="" class="text-danger btn_deletepersonal" data-id_persona="${r.data[k]['id_persona']}" data-toggle="tooltip" title="Eliminar"><img src="<?php echo base_url('assets/iconos_menu/eliminar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                            </td>
                        </tr>`;
                    }
                    $('#tbodyusuarios').html(tbody);


                    // Total de Usuarios y la cantidad por registro
                    var cantidad        = r.cantidad,
                        total_registros = r.total_registros,
                        numero_links    = Math.ceil(total_registros / cantidad),
                        link_seleccion  = pagina;

                        pagination = '<nav aria-label="Paginador usuarios"><ul class="pagination justify-content-center">';                    
                        for(var i = 1; i <= numero_links; i++) {
                            if(i == link_seleccion) {
                                pagination += `<li class="page-item active"><a class="page-link" href="#">${i}</a></li>`;
                            }
                            else {
                                pagination += `<li class="page-item"><a class="page-link" href="${i}">${i}</a></li>`;

                            }
                        }
                        pagination += '</ul></nav>';

                        $('.pagination_usuarios').html(pagination);
                    false;
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