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
                                        <h2 class="d-inline">Citas</h2>
                                        <a href="<?php echo base_url('psicologa/AddCita'); ?>" class="btn btn-info mb-2 ml-1">Agregar Cita</a>
                                    </div>

                                    <div class="col-6">
                                        <?php if(!empty($citas)): ?>
                                            <div class="input-group">
                                                <input type="text" id="valor" class="form-control" name="valor" placeholder="Buscar por documento">
                                                <input type="date" id="fecha_inicial_buscar" class="form-control" name="s_fecha_buscar">
                                                <input type="date" id="fecha_final_buscar" class="form-control" name="s_fecha_buscar">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if(!empty($citas)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Descripcion</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                    <th>Estado</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodycitas" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_informes mt-2">

                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay citas programadas</span></p>
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

        $("#valor").keyup(function (e) { 
            e.preventDefault();
            load_citas(1);
        });
        $("#fecha_inicial_buscar").change(function(event) {
            load_citas(1);
        });
        $("#fecha_final_buscar").change(function(event) {
            load_citas(1);
        });
    });
    function load_citas(pagina) {
        fecha_inicio = $("#fecha_inicial_buscar").val();
        fecha_final = $("#fecha_final_buscar").val();
        valor = $("#valor").val();
        $.ajax({
            url      : '<?= base_url('fotografo/Citas/getCitas') ?>',
            method   : 'POST',
            data     : {pagina : pagina, fecha_inicio: fecha_inicio, fecha_final: fecha_final, valor: valor},
            success  : function(r){
                console.log(r);
                if(r.status){
                    var tbody = '';
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['apellidos']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['descripcion']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['hora']}</td>

                            <td class="align-middle text-capitalize">${r.data[k]['estado']}</td>`
                        if (r.data[k]['estado'] != "antigua") {
                            tbody += `<td class="align-middle">
                                <a href="<?php echo site_url('fotografo/EditarCita/editCita/') ?>${r.data[k]['id_citas']}" class="text-dark"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                                <a href="" class="text-danger btn_delete_cita" data-id_cita="${r.data[k]['id_citas']}" data-toggle="tooltip" title="Eliminar"><img src="<?php echo base_url('assets/iconos_menu/eliminar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                            </td>
                            </tr>`;
                        }
                    }
                    $('#tbodycitas').html(tbody);

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

                        $('.pagination_informes').html(pagination);
                    false;
                }
            },
            dataType : 'json'
        });

        return false;
    }

    load_citas(1);

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_citas(link);
    });

    $('body').on('click' , '.btn_delete_cita' , function(e){
        e.preventDefault();

        var id_cita = $(this).data('id_cita'),
            ruta        = "<?php echo base_url('fotografo/Citas/delete_cita') ?>";

            alertify.confirm("Nomina" , "¿Está seguro que quiere eliminar el registro?",
            function(){
                $.ajax({
                    url      : ruta,
                    method   : 'POST',
                    data     : {id_cita : id_cita},
                    success  : function(r){
                        if(r.status){
                            alertify.success('Registro eliminado');
                            load_citas(1);
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
