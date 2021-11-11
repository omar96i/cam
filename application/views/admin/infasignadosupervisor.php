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
                <a href="<?= base_url('admin/Home/asignaciones') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Asignados</h2>
                                    </div>
                                </div>
								<div class="row text-center">
                                    <div class="col-12">
                                        <h2><?php echo $supervisor[0]->nombres." ".$supervisor[0]->apellidos; ?></h2>
                                    </div>
                                </div>

                                <?php if(!empty($usuarios)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Documento modelo</th>
                                                    <th>Nombres modelo</th>
                                                    <th>Apellidos modelo</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyusuarios" class="text-center">


                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
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

        <div class="modal fade" id="ModalPagesUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Paginas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div  class="table-responsive mt-1">
                            <table id="empty" class="table table-sm table-striped table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Url pagina</th>
                                        <th>Usuario</th>
                                        <th>Contraseña</th>
                                    </tr>
                                </thead>

                                <tbody id="tbodyPaginasUsuario" class="text-center">


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
<script>
    $(document).ready(function() {

    });
    function load_usuarios(valor , pagina) {
        id_supervisor = <?php echo $supervisor[0]->id_persona; ?>;
        $.ajax({
            url      : '<?= base_url('admin/home/verusuariosasignados') ?>',
            method   : 'POST',
            data     : {id_supervisor: id_supervisor},
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['apellidos']}</td>
                            <td class="align-middle">
                                <a href="" data-id_persona="${r.data[k]['id_persona']}" class="text-info btn_infoPaginas"><img src="<?php echo base_url('assets/iconos_menu/ojo.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                                <a href="" class="text-danger btn_deletepersonal" data-id_persona="${r.data[k]['id_persona']}" data-toggle="tooltip" title="Eliminar"><img src="<?php echo base_url('assets/iconos_menu/eliminar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                            </td>
                        </tr>`;
                    }
                    $('#tbodyusuarios').html(tbody);
                    $(".btn_infoPaginas").click(function(event) {
                        event.preventDefault();
                        $("#tbodyPaginasUsuario").children().remove();
                        id_usuario = $(this).data('id_persona')
                        $.ajax({
                            url: '<?= base_url('admin/home/getpagesusuario') ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {id_usuario: id_usuario},
                        })
                        .done(function(r) {
                            if (r.status) {
                                tbody = '';
                                for (var i = 0; i < r['lista'].length; i++) {
                                    tbody += `<tr>
                                        <td class="align-middle text-capitalize">${r.lista[i]['url_pagina']}</td>
                                        <td class="align-middle text-capitalize">${r.lista[i]['correo']}</td>
                                        <td class="align-middle text-capitalize">${r.lista[i]['clave']}</td>
                                    </tr>`;
                                }
                                $("#tbodyPaginasUsuario").html(tbody);
                            }
                        })
                        .fail(function(r) {
                            console.log("error");
                            console.log(r);
                        });
                        $("#ModalPagesUsuario").modal('show');

                    });


                    // Total de usuarios y la cantidad por registro
                    $("#empty").DataTable()
                }
            },
            dataType : 'json'
        });

        return false;
    }

    load_usuarios('' , 1);



    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_usuarios(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_usuarios('' , link);
    });

    $('body').on('click' , '.btn_deletepersonal' , function(e){
        e.preventDefault();

        var id_persona = $(this).data('id_persona'),
            id_supervisor = <?php echo $supervisor[0]->id_persona; ?>;
            ruta        = "<?php echo base_url('admin/home/delete_empleado') ?>";

            alertify.confirm("Gz studios" , "¿Está seguro que quiere eliminar la asignacion?",
            function(){
                $.ajax({
                    url: ruta,
                    type: 'POST',
                    dataType: 'json',
                    data: {id_persona : id_persona, id_supervisor: id_supervisor},
                })
                .done(function(r) {
                    console.log("success");
                    console.log(r);
                    if(r.status){
                        alertify.success('Registro eliminado');
                        load_usuarios('' , 1);
                        alertify.confirm().close();
                        return;
                    }

                    alertify.alert(r.msg);
                })
                .fail(function(r) {
                    console.log("error");
                    console.log(r);
                });
            },
            function(){
                alertify.confirm().close();
            });
    });
</script>
