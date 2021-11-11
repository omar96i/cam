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
                                        <h2 class="d-inline">Modelos</h2>
                                        <a href="#" class="btn btn-info mb-2 ml-1 btn_registrar_dolar">Ver / Registrar dolar</a>
                                    </div>
									<div class="col-6">
										<div class="alert alert-danger" role="alert">
											Recuerda que antes de empezar a generar la nomina, Se debe establecer el valor del dolar!
										</div>
									</div>
                                </div>

                                <?php if(!empty($empleados)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Tokens sin verificar</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyempleados" class="text-center">

                                            </tbody>
                                        </table>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay modelos</span></p>
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
        <div class="modal fade" id="modalRegistroDolar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Registro dolar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
						<div class="alert alert-success" role="alert">
							<h6 class="valor_dolar">Valor dolar: </h6>
						</div>
                        <div class="form-group">
                            <label for="valor_dolar" class="col-form-label">Nuevo valor del dolar:</label>
                            <input type="number" id="valor_dolar" class="form-control" name="valor_dolar">
                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn_registro_dolar">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

<script>
    $(document).ready(function() {
        $(".btn_registro_dolar").click(function(event) {
            valor_dolar = $("#valor_dolar").val();
            $.ajax({
                url: '<?= base_url('talento_humano/Home/registrodolar') ?>',
                type: 'POST',
                dataType: 'json',
                data: {valor_dolar: valor_dolar},
            })
            .done(function(r) {
                if(r.status){
                    $("#valor_dolar").val("");
                    $("#modalRegistroDolar").modal('hide');

                    alertify.success('Registro exitoso');
                    alertify.confirm().close();
                    return;
                }

                alertify.alert(r.msg);
            })
            .fail(function(r) {
                console.log("error");
                console.log(r);
            });
            
        });
        $(".btn_registrar_dolar").click(function(event) {
            $("#modalRegistroDolar").modal('show');
            $.ajax({
                url: '<?= base_url('talento_humano/Home/getvalordolar') ?>',
                dataType: 'json',
            })
            .done(function(r) {
                if (!r.status) {
                    $(".valor_dolar").html("Valor dolar: Sin registrar")
                }else{
                    $(".valor_dolar").html("Valor Actual Dolar: "+r.lista['valor_dolar']);
                }

            })
            .fail(function(r) {
                console.log("error");
                console.log(r);
            });
            
        });
    });
    function load_empleados(valor , pagina) {
        $.ajax({
            url      : '<?= base_url('talento_humano/Home/verempleados') ?>',
            method   : 'POST',
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['apellidos']}</td>
                            <td class="align-middle text-capitalize">${r.can_registros[k]}</td>
                            <td class="align-middle">
                                <a href="<?php echo site_url('talento_humano/Home/verhoras/') ?>${r.data[k]['id_persona']}" class="text-dark"><img src="<?php echo base_url('assets/iconos_menu/reloj.png') ?>"</a>
                                <a href="<?php echo site_url('talento_humano/Home/verPenalizaciones/') ?>${r.data[k]['id_persona']}" class="text-warning"><img src="<?php echo base_url('assets/iconos_menu/alerta.png') ?>" alt=""></a>
                            </td>
                        </tr>`;
                    }
                    $('#tbodyempleados').html(tbody);
                    
                }
				$('#empty').DataTable( {
					"order": [[ 3, "desc" ]]
				} );
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
