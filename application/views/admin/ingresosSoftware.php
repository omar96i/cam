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
                                        <h2 class="d-inline">Ingresos a la pagina</h2>
                                    </div>
                                </div>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Tipo de cuenta</th>
                                                    <th>Fecha de ingreso</th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyingresos" class="text-center">

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
    function load_ingresos(pagina) {


        $.ajax({
            url      : '<?= base_url('admin/IngresosSoftware/getIngresos') ?>',
            method   : 'POST',
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    for(var k=0; k<r.data.length; k++) {
						if(r.data[k]['tipo_cuenta'] == "supervisor"){
							r.data[k]['tipo_cuenta'] = "monitor"
						}else if(r.data[k]['tipo_cuenta'] == "tecnico sistemas"){
							r.data[k]['tipo_cuenta'] = "supervisor"

						}
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['apellidos']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['tipo_cuenta']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha']}</td>
                            </tr>`;
                    }
                    $('#tbodyingresos').html(tbody);

                    // Total de Usuarios y la cantidad por registro
					
                }
				$("#empty").DataTable( {
					"order": [[ 4, "desc" ]]
				} )
            },
            dataType : 'json'
        });

        return false;
    }

    load_ingresos(1);

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_ingresos(link);
    });
    
</script>
