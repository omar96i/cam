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
                                    </div>
                                </div>

                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Documento Modelo</th>
                                                    <th>Nombres Modelo</th>
                                                    <th>Apellidos Modelo</th>
                                                    <th>Documento Fotografo</th>
                                                    <th>Nombres Fotografo</th>
                                                    <th>Apellidos Fotografo</th>
                                                    <th>Descripcion</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodycitas" class="text-center">

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
    function load_citas(pagina) {
        $.ajax({
            url      : '<?= base_url('fotografo/Citas/getCitasAdmin') ?>',
            method   : 'POST',
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    for(var k=0; k<r.data['empleado'].length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data['empleado'][k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data['empleado'][k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data['empleado'][k]['apellidos']}</td>
                            <td class="align-middle text-capitalize">${r.data['fotografo'][k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data['fotografo'][k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data['fotografo'][k]['apellidos']}</td>
                            <td class="align-middle text-capitalize">${r.data['empleado'][k]['descripcion']}</td>
                            <td class="align-middle text-capitalize">${r.data['empleado'][k]['fecha']}</td>
                            <td class="align-middle text-capitalize">${r.data['empleado'][k]['hora']}</td>

                            <td class="align-middle text-capitalize">${r.data['empleado'][k]['estado']}</td>`;
                    }
                    $('#tbodycitas').html(tbody);
                }
				$("#empty").DataTable( {
					"order": [[ 7, "desc" ]]
				} )
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
