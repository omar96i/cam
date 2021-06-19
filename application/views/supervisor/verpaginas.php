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
                <a href="<?= base_url('supervisor/Home/empleados') ?>" class="btn btn-info float-right">Retroceder</a>
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
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-8">
                                        <h2 class="d-inline">Pagina</h2>
                                    </div>

                                    <div class="col-4">
                                        <?php if(!empty($paginas)): ?>
                                            <div class="input-group">
                                                <input type="text"  class="form-control search_usuarios" placeholder="Buscar (por nombre)..." aria-label="Search paginas">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if(!empty($paginas)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Id pagina</th>
                                                    <th>Url pagina</th>
                                                    <th>Tokens</th>
                                                    <th>Usuario</th>
                                                    <th>Contraseña</th>
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
        id_usuario = <?php echo $usuario; ?>;
        $.ajax({
            url      : '<?= base_url('supervisor/Home/getpages') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina, id_usuario: id_usuario},
            success  : function(r){
                console.log(r.data);
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['id_pagina']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['url_pagina']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['tokens']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['correo']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['clave']}</td>
                        </tr>`;
                    }
                    $('#tbodypaginas').html(tbody);


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