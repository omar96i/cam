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
                                        <h2 class="d-inline">Modelos</h2>
                                        <a href="<?php echo base_url('supervisor/Home/registrarHoras') ?>" class="btn btn-info mb-2 ml-1">Registrar Tokens</a>
                                        <a href="<?php echo base_url('supervisor/Home/registrarPenalizacion') ?>" class="btn btn-info mb-2 ml-1">Registrar Penalizacion</a>
                                        <a href="<?php echo base_url('supervisor/AddInforme') ?>" class="btn btn-info mb-2 ml-1">Registrar Informe</a>
                                    </div>

                                    <div class="col-4">
                                        <?php if(!empty($empleados)): ?>
                                            <div class="input-group">
                                                <input type="text" class="form-control search_usuarios" placeholder="Buscar (por nombre)..." aria-label="Search empleados">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if(!empty($empleados)): ?>
                                    <div class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <!--<th>Id</th>-->
                                                    <th>Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Sexo</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyempleados" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay empleados</span></p>
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

        <div class="modal fade" id="modalPenalizaciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Penalizaciones</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div  class="table-responsive mt-1">
                            <table id="empty" class="table table-sm table-striped table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Nombre Penalizacion</th>
                                        <th>Descripcion</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodypenalizacion" class="text-center">

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
        <div class="modal fade" id="modalMetas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
                                        <th>Fecha de registro</th>
                                        <th>Descripcion</th>
                                        <th>Numero de tokens</th>
                                        <th>Tokens faltantes</th>
                                        <th>Tokens verificados</th>
                                        <th>Tokens por verificar</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodymeta" class="text-center">

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
    function load_empleados(valor , pagina) {
        $.ajax({
            url      : '<?= base_url('supervisor/Home/verempleados') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina},
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <!--<td class="align-middle text-capitalize">${r.data[k]['id_persona']}</td>-->
                            <td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['apellidos']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['sexo']}</td>
                            <td class="align-middle">
                                <a href="<?php echo site_url('supervisor/Home/verhoras/') ?>${r.data[k]['id_persona']}" class="text-dark"><img src="<?php echo base_url('assets/iconos_menu/reloj.png') ?>" alt=""></a>
                                <a href="" data-id_persona="${r.data[k]['id_persona']}" class="text-warning btn_penalizaciones"><img src="<?php echo base_url('assets/iconos_menu/alerta.png') ?>" alt=""></a>
                                <a href="<?php echo site_url('supervisor/VerInformes/VerInformesEmpleado/') ?>${r.data[k]['id_persona']}" class="text-info"><img width="24" src="<?php echo base_url('assets/iconos_menu/informes.jpg') ?>" alt=""></a>
                                <a href="<?php echo site_url('supervisor/Home/verpaginas/') ?>${r.data[k]['id_persona']}" class="text-info"><img src="<?php echo base_url('assets/iconos_menu/ojo.png') ?>" alt=""></a>
                                <a href="" data-id_persona="${r.data[k]['id_persona']}" class="text-info btn_metas"><img src="<?php echo base_url('assets/iconos_menu/meta.png') ?>" alt=""></a>
                            </td>
                        </tr>`;
                    }
                    $('#tbodyempleados').html(tbody);

                    $(".btn_metas").click(function(event) {
                        event.preventDefault();
                        id_empleado = $(this).data('id_persona');
                        $.ajax({
                            url: '<?php echo base_url('supervisor/Home/getMetasOnlyEmpleado') ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {id_empleado: id_empleado},
                        })
                        .done(function(r) {
                            if (r.status) {
                                var tbody = `<tr>
                                    <td class="align-middle text-capitalize">${r.data['meta']['fecha_registro']}</td>
                                    <td class="align-middle text-capitalize">${r.data['meta']['descripcion']}</td>
                                    <td class="align-middle text-capitalize">${r.data['meta']['num_horas']}</td>
                                    <td class="align-middle text-capitalize">${r.data['total']}</td>
                                    <td class="align-middle text-capitalize">${r.data['num_horas']['verificados']['cantidad_horas']}</td>
                                    <td class="align-middle text-capitalize">${r.data['num_horas']['por_verificar']['cantidad_horas']}</td>
                                </tr>`;

                                $('#tbodymeta').html(tbody);
                            }else{

                                tbody = `<tr>
                                        <td class="align-middle text-capitalize" colspan="6">Sin asignar</td>
                                    </tr>`;
                                $('#tbodymeta').html(tbody);
                            }
                        })
                        .fail(function(r) {
                            console.log(r);
                        });

                        $("#modalMetas").modal("show");
                        
                    });

                    $(".btn_penalizaciones").click(function(event) {
                        event.preventDefault();

                        id_empleado = $(this).data('id_persona');
                        $.ajax({
                            url: '<?php echo base_url('supervisor/home/getPenalizaciones') ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {id_empleado: id_empleado},
                        })
                        .done(function(r) {

                            if (r.status) {

                                var tbody = '';
                                
                                for(var k=0; k<r.data.length; k++) {
                                    tbody += `<tr>
                                        <td class="align-middle text-capitalize">${r.data[k]['nombre_penalizacion']}</td>
                                        <td class="align-middle text-capitalize">${r.data[k]['descripcion']}</td>
                                        <td class="align-middle text-capitalize">${r.data[k]['fecha_registrado']}</td>

                                        <td class="align-middle text-capitalize">${r.data[k]['estado']}</td>
                                    </tr>`;
                                }
                                $('#tbodypenalizacion').html(tbody);

                            }else{
                                var tbody = '';
                                $('#tbodypenalizacion').html(tbody);
                            }
                        })
                        .fail(function(r) {
                            console.log("error");
                            console.log(r);

                        });

                        
                        $("#modalPenalizaciones").modal('show');
                        
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

    load_empleados('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_empleados(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_empleados('' , link);
    });
</script>