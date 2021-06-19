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

                                    <div class="col-4">
                                        <?php if(!empty($adelantos)): ?>
                                            <div class="input-group">
                                                <input type="text" class="form-control search_usuarios" placeholder="Buscar (por nombre)..." aria-label="Search adelantos">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if(!empty($adelantos)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Id Adelanto</th>
                                                    <th>Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Descripcion</th>
                                                    <th>Valor</th>
                                                    <th>Estado</th>
                                                    <th>Fecha</th>

                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyadelantos" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay adelantos</span></p>
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
            url      : '<?= base_url('admin/home/veradelantos') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina},
            success  : function(r){
                console.log(r)
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['id_adelanto']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['descripcion']}</td>
                            <td class="align-middle text-capitalize">${"$ "+new Intl.NumberFormat().format(r.data[k]['valor'])}</td>

                            <td class="align-middle text-capitalize">${r.data[k]['estado']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_registrado']}</td>

                            <td class="align-middle">`
                            if (r.data[k]['estado'] == "sin registrar") {
                                tbody += `<a href="<?php echo site_url('admin/Home/editaradelantos/') ?>${r.data[k]['id_adelanto']}" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>`
                            }
                        tbody += `</td>
                        </tr>`;
                                
                            
                    }
                    $('#tbodyadelantos').html(tbody);


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