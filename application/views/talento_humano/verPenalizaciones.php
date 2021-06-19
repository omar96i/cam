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
                <a href="<?= base_url('talento_humano/Home/usuarios') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Penalizaciones</h2>
                                    </div>

                                    <div class="col-4">
                                        <?php if(!empty($penalizaciones)): ?>
                                            <div class="input-group">
                                                <input type="text" class="form-control search_usuarios" placeholder="Buscar (por nombre)..." aria-label="Search penalizaciones">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if(!empty($penalizaciones)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Nombre penalizacion</th>
                                                    <th>Observacion</th>
                                                    <th>Fecha</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodypenalizaciones" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay penalizaciones</span></p>
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
    function load_penalizaciones(valor , pagina) {
        id_usuario = <?php echo $id_usuario; ?>;
        $.ajax({
            url      : '<?= base_url('talento_humano/Home/getPenalizaciones') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina, id_usuario:id_usuario},
            success  : function(r){
                console.log(r);
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['id_empleado_penalizacion']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombre_penalizacion']}</td>

                            <td class="align-middle text-capitalize">${r.data[k]['descripcion']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_registrado']}</td>
                            
                            <td class="align-middle">
                                <a href="<?php echo site_url('talento_humano/Home/editPenalizacion/') ?>${r.data[k]['id_empleado_penalizacion']+'/'+<?= $this->uri->segment(4) ?>}" class="text-dark"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt=""></a>
                            </td>
                        </tr>`;
                    }
                    $('#tbodypenalizaciones').html(tbody);


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

    load_penalizaciones('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_penalizaciones(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_penalizaciones('' , link);
    });



    
</script>