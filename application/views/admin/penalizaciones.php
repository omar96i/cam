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
                                        <h2 class="d-inline">Penalizaciones</h2>
                                        <a href="<?php echo base_url('admin/Home/addpenalizaciones') ?>" class="btn btn-info mb-2 ml-1">Agregar</a>
                                    </div>
                                </div>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Nombre Penalizacion</th>
                                                    <th>Tokens</th>
                                                    <th>Estado</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodypenalizaciones" class="text-center">

                                            </tbody>
                                        </table>

                                    </div>

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
        $.ajax({
            url      : '<?= base_url('admin/home/verpenalizaciones') ?>',
            method   : 'POST',
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['nombre_penalizacion']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['puntos']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['estado']}</td>
                            <td class="align-middle">
                                <a href="<?php echo site_url('admin/Home/editarPenalizaciones/') ?>${r.data[k]['id_penalizacion']}" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                                <a href="" class="text-danger btn_deletepersonal" data-id_persona="${r.data[k]['id_penalizacion']}" data-toggle="tooltip" title="Eliminar"><img src="<?php echo base_url('assets/iconos_menu/eliminar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                            </td>
                        </tr>`;
                    }
                    $('#tbodypenalizaciones').html(tbody);

                }
				$("#empty").DataTable()
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
                            load_penalizaciones('' , 1);
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
