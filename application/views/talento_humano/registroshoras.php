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
                <a href="<?= base_url('talento_humano/Home/facturas') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                    <div class="col-6">
                                        <h2 class="d-inline">Registros</h2>
                                        <a href="#" class="btn btn-info mb-2 ml-1 btn_consultar_asistencia">Asistencia</a>
                                    </div>
                                </div>

                                <?php if(!empty($registro_horas)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Url pagina</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Cantidad Tokens</th>
                                                    <th>Fecha registro</th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyregistro_horas" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay registro Tokens</span></p>
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
        <div class="modal fade" id="modalAsistencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Asistencia</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div  class="table-responsive mt-1">
                            <table id="empty" class="table table-sm table-striped table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Motivo inasistencia</th>
                                        <th>Descuenta día</th>
                                    </tr>
                                </thead>

                                <tbody id="tbodyasistencia" class="text-center">

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
        $("#fecha_inicial_buscar").change(function(event) {
            usuario = $(".search_usuarios").val();
            load_registro_horas(usuario , 1);
        });
        $("#fecha_final_buscar").change(function(event) {
            usuario = $(".search_usuarios").val();
            load_registro_horas(usuario , 1);
        });
       $(".btn_consultar_asistencia").click(function(event) {
           event.preventDefault();
           consultarAsistencia();
       });
    });

    function consultarAsistencia(){
        $("#modalAsistencia").modal('show');
        id_factura = <?php echo $id_factura; ?>;
        $.ajax({
            url: '<?= base_url('talento_humano/RegistroHoras/ConsultarAsistencia') ?>',
            type: 'POST',
            dataType: 'json',
            data: {id_factura: id_factura},
        })
        .done(function(r) {
            console.log("success");
            console.log(r);
            var tbody = '';
            
            for(var k=0; k<r.length; k++) {
                tbody += `<tr>
                    <td class="align-middle text-capitalize">${r[k]['fecha']}</td>
                    <td class="align-middle text-capitalize">${r[k]['estado']}</td>
                    <td class="align-middle text-capitalize">${r[k]['nombre']==null ? '' : r[k]['nombre']}</td>
                    <td class="align-middle text-capitalize">${r[k]['descuenta']==null && r[k]['estado']=='sin registrar' ? 'Si' : (
                        r[k]['estado']=='registrado' ? '' : r[k]['descuenta'])}</td>
                </tr>`;
            }
            $('#tbodyasistencia').html(tbody);
        })
        .fail(function(r) {
            console.log("error");
            console.log(r);
        });
        
    }


    function load_registro_horas(valor , pagina) {
        fecha_inicio = $("#fecha_inicial_buscar").val();
        fecha_final = $("#fecha_final_buscar").val();
        id_factura = <?php echo $id_factura; ?>;
        
        $.ajax({
            url      : '<?= base_url('talento_humano/home/getRegistrosFactura') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina, id_factura: id_factura, fecha_inicio: fecha_inicio, fecha_final: fecha_final},
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['url_pagina']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['apellidos']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['cantidad_horas']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_registro']}</td>`;
                        tbody += `</tr>`;
                    }
                    $('#tbodyregistro_horas').html(tbody);

					$("#empty").DataTable( {
						dom: 'Bfrtip',
						buttons: [
							'copy', 'excel'
						]
					} )
                }
            },
            dataType : 'json'
        });

        return false;
    }

    load_registro_horas('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_registro_horas(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_registro_horas('' , link);
    });


    
</script>
