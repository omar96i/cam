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
                                    <div class="col-6">
                                        <h2 class="d-inline">Asistencias</h2>
                                    </div>
                                    <div class="col-6">
                                        <?php if(!empty($asistencia)): ?>
                                            <div class="input-group">
                                                <input type="text" class="form-control search_usuarios" placeholder="Buscar (por nombre)..." aria-label="Search asistencia">
                                                <input type="date" id="fecha_inicial_buscar" class="form-control" name="s_fecha_buscar">
                                                <input type="date" id="fecha_final_buscar" class="form-control" name="s_fecha_buscar">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if(!empty($asistencia)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Estado</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyasistencia" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay asistencia</span></p>
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

        <div class="modal fade" id="modalAsistencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Metas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div  class="table-responsive mt-1">
                            <table id="empty" class="table table-sm table-striped table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Nombre Modelo</th>
                                        <th>Estado</th>
                                        <th>Motivo inasistencia</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyitems" class="text-center">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

<script>
    $(document).ready(function() {
        $("#fecha_inicial_buscar").change(function(event) {
            load_asistencias(1);
        });
        $("#fecha_final_buscar").change(function(event) {
            load_asistencias(1);
        });
        load_asistencias(1);



        
    });


    function load_asistencias(pagina) {
        fecha_inicio = $("#fecha_inicial_buscar").val();
        fecha_final = $("#fecha_final_buscar").val();

        
        
        $.ajax({
            url      : '<?= base_url('supervisor/VerAsistencia/getAsistencias') ?>',
            method   : 'POST',
            data     : {pagina : pagina, fecha_inicio: fecha_inicio, fecha_final: fecha_final},
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['estado']}</td>
                            <td>
                                <a href="" data-id_asistencia="${r.data[k]['id_asistencia']}" class="text-warning btn_asistencia"><img src="<?php echo base_url('assets/iconos_menu/ojo.png') ?>" alt=""></a>
                            </td>`;
                        tbody += `</tr>`;
                    }
                    $('#tbodyasistencia').html(tbody);

                    $(".btn_asistencia").on('click', function(event) {
                        event.preventDefault();
                        id_asistencia = $(this).data('id_asistencia');
                        $.ajax({
                            url: '<?= base_url('supervisor/VerAsistencia/getItemsAsistencia') ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {id_asistencia: id_asistencia},
                        })
                        .done(function(r) {
                            body = "";
                            for (var i = 0; i < r.length; i++) {
                                body += `<tr>
                                    <td class="align-middle text-capitalize">${r[i]['nombres']}</td>
                                    <td class="align-middle text-capitalize">${r[i]['estado']}</td>
                                    <td class="align-middle text-capitalize">${r[i]['nombre']==null ? '' : r[i]['nombre']}</td>
                                </tr>`;
                            }
                            $("#tbodyitems").html(body);
                            $("#modalAsistencia").modal('show');
                        })
                        .fail(function(r) {
                            console.log("error");
                            console.log(r);
                        });
                        
                    });


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

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_asistencias(link);
    });
</script>