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
                                        <h2 class="d-inline">Metas</h2>
                                    </div>

                                    <div class="col-4">
                                        <?php if(!empty($metas)): ?>
                                            <div class="input-group">
                                                <input type="text" class="form-control search_usuarios" placeholder="Buscar (por nombre)..." aria-label="Search metas">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if(!empty($metas)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Tipo de usuario</th>
                                                    <th>Numero de Tokens</th>
                                                    <th>Descripcion</th>
                                                    <th>Estado</th>
                                                    <th>Fecha registro</th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodymetas" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay metas</span></p>
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
        <!-- <div class="modal fade" id="modalMetasEmpleados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Metas empleados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div  class="table-responsive mt-1">
                            <table id="empty" class="table table-sm table-striped table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Documento</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Numero de horas</th>
                                        <th>Descripcion</th>
                                        <th>Estado</th>
                                        <th>Fecha registro</th>
                                    </tr>
                                </thead>

                                <tbody id="tbodyMetasEmpleados" class="text-center">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div> -->

<script>

    function load_metas(valor , pagina) {

        $.ajax({
            url      : '<?= base_url('admin/home/verMetasSupervisor') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina},
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['apellidos']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['tipo_cuenta']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['num_horas']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['descripcion']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['estado']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_registro']}</td>
                        </tr>`;
                                    
                    }
                    $('#tbodymetas').html(tbody);

                    // $(".btn_consultar_horas").click(function(e) {
                    //     e.preventDefault();
                    //     $("#modalMetasEmpleados").modal('show');
                    //     id_supervisor = $(this).data('id_supervisor');
                    //     $.ajax({
                    //         url: '<?= base_url('admin/home/consultarMetasEmpleados') ?>',
                    //         type: 'POST',
                    //         dataType: 'json',
                    //         data: {id_supervisor: id_supervisor},
                    //     })
                    //     .done(function(r) {
                    //         console.log("success");
                    //         console.log(r)
                    //         var tbody = '';
                            
                    //         for(var k=0; k<r.length; k++) {
                    //             tbody += `<tr>
                    //                 <td class="align-middle text-capitalize">${r[k]['documento']}</td>
                    //                 <td class="align-middle text-capitalize">${r[k]['nombres']}</td>
                    //                 <td class="align-middle text-capitalize">${r[k]['apellidos']}</td>
                    //                 <td class="align-middle text-capitalize">${r[k]['num_horas']}</td>
                    //                 <td class="align-middle text-capitalize">${r[k]['descripcion']}</td>
                    //                 <td class="align-middle text-capitalize">${r[k]['estado']}</td>
                    //                 <td class="align-middle text-capitalize">${r[k]['fecha_registro']}</td>
                    //             </tr>`;
                                            
                    //         }
                    //         $("#tbodyMetasEmpleados").html(tbody);
                    //     })
                    //     .fail(function(r) {
                    //         console.log("error");
                    //         console.log(r)
                    //     });
                        
                    // });


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

    load_metas('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_metas(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_metas('' , link);
    });

    // $('body').on('click' , '.btn_deletepersonal' , function(e){
    //     e.preventDefault();

    //     var id_meta     = $(this).data('id_meta'),
    //         ruta        = "<?php echo base_url('admin/home/deteleMeta') ?>";

    //         alertify.confirm("Nomina" , "¿Está seguro que quiere eliminar el registro?",
    //         function(){
    //             $.ajax({
    //                 url      : ruta,
    //                 method   : 'POST',
    //                 data     : {id_meta : id_meta},
    //                 success  : function(r){
    //                     if(r.status){
    //                         alertify.success('Registro eliminado');
    //                         alertify.confirm().close();
    //                         load_metas('', 1);
    //                         return;
    //                     }

    //                     alertify.alert(r.msg);
    //                 },
    //                 dataType : 'json'
    //             });

    //             return false;
    //         },
    //         function(){
    //             alertify.confirm().close();
    //         }); 
    // });
</script>