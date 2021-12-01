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
                                </div>

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
            url      : '<?= base_url('fotografo/Citas/getCitas') ?>',
            method   : 'POST',
            success  : function(r){
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
                                <a href="<?php echo site_url('psicologa/EditarCita/editCita/') ?>${r.data[k]['id_citas']}" class="text-dark"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                                <a href="" class="text-danger btn_delete_cita" data-id_cita="${r.data[k]['id_citas']}" data-toggle="tooltip" title="Eliminar"><img src="<?php echo base_url('assets/iconos_menu/eliminar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a>
                            </td>
                            </tr>`;
                        }else{
							tbody += `<td class="align-middle"></td>
                            </tr>`;
						}
                    }
                    $('#tbodycitas').html(tbody);
					
                }
				$("#empty").DataTable( {
					"order": [[ 6, "desc" ]]
				} )
            },
            dataType : 'json'
        });

        return false;
    }

    load_citas(1);

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
