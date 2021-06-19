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
                            <div class="col-sm-12 caja_resultados">
                                <div class="row">
                                    <div class="col-8">
                                        <h2 class="d-inline">Asistencias</h2>
                                        <a href="<?php echo base_url('admin/Home/addasistencia') ?>" class="btn btn-info mb-2 ml-1">Agregar</a>
                                    </div>

                                    <div class="col-4 caja_buscador">
                                        <?php if(!empty($asistencias)): ?>
                                            <div class="input-group">
                                                <input type="text" class="form-control search_usuarios" placeholder="Buscar (por nombre)..." aria-label="Search asistencias">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if(!empty($asistencias)): ?>
                                    <div  class="table-responsive mt-1 caja_tabla">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Id Asistencia</th>
                                                    <th>Nombre</th>
                                                    <th>Descuenta día</th>
                                                    <th>Estado</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyasistencias" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center">
                                        <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                        <p><span class="text-muted">No hay asistencias</span></p>
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
    function load_asistencias(valor , pagina) {
        $.ajax({
            url      : '<?= base_url('admin/home/verasistencias') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina},
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['id_motivo']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombre']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['descuenta']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['estado']}</td>
                            <td class="align-middle">
                                <a href="<?php echo site_url('admin/Home/editarAsistencia/') ?>${r.data[k]['id_motivo']}" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                                <a href="" class="text-danger btn_deletepersonal" data-id_persona="${r.data[k]['id_motivo']}" data-toggle="tooltip" title="Eliminar"><img src="<?php echo base_url('assets/iconos_menu/eliminar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                            </td>
                        </tr>`;
                    }
                    $('#tbodyasistencias').html(tbody);


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

                }else{
                    $(".caja_buscador, .caja_tabla").remove();
                    $(".caja_resultados").append(`<div class="text-center">
                        <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                        <p><span class="text-muted">No hay asistencias</span></p>
                    </div>`);
                }
            },
            dataType : 'json'
        });
    }

    load_asistencias('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_asistencias(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_asistencias($('.search_usuarios').val(), link);
    });

    $('body').on('click' , '.btn_deletepersonal' , function(e){
        e.preventDefault();

        var id_asistencia = $(this).data('id_persona');
        var ruta = "<?php echo base_url('admin/home/deleteAsistencia') ?>";

        alertify.confirm("GZ Studios" , "¿Está seguro que quiere eliminar el registro?",
        function(){
            $.ajax({
                method   : 'POST',
                data     : {id_asistencia : id_asistencia},
                dataType : 'json',
                url      : ruta,
                success  : function(r){
                    if(r.status){
                        alertify.success('Registro eliminado');
                        load_asistencias('' , 1);
                        alertify.confirm().close();
                        return;
                    }

                    alertify.alert(r.msg);

                },error: function(r) {
                    alertify.alert('Ups :(', 'error al conectarse con el servidor.');
                }
            });
        },
        function(){
            alertify.confirm().close();
        }); 
    });
</script>