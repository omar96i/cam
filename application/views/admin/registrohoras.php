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
                <a href="<?= base_url('admin/Home/nomina') ?>" class="btn btn-info float-right">Retroceder</a>
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

                                    <div class="col-6">
                                        <?php if(!empty($registro_horas)): ?>
                                            <div class="input-group">
                                                <input type="text"  class="form-control search_usuarios" placeholder="Buscar (por nombre)..." aria-label="Search registro_horas">
                                                <input type="date" id="fecha_inicial_buscar" class="form-control" name="s_fecha_buscar">
                                                <input type="date" id="fecha_final_buscar" class="form-control" name="s_fecha_buscar">

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if(!empty($registro_horas)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Nombre pagina</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Cantidad Tokens</th>
                                                    <th>Descripcion</th>
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
                                            <p><span class="text-muted">No hay registro_horas</span></p>
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
       <!--  <div class="modal fade" id="ModalEditRegistro" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Editar Registro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="cantidad_horas" class="col-form-label">Cantidad Horas:</label>
                            <input type="text" id="cantidad_horas" class="form-control" name="cantidad_horas" >
                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                        </div>
                        <div class="form-group">
                            <label for="descuento" class="col-form-label">Descuento:</label>
                            <input type="text" id="descuento" class="form-control" name="descuento" >
                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-form-label">Descripcion: </label>
                            <input type="text" id="descripcion" class="form-control" name="descripcion" >
                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                        </div>
                        <div class="form-group">
                            <label for="fecha_registro" class="col-form-label">Fecha Registro: </label>
                            <input type="date" id="fecha_registro" class="form-control" name="fecha_registro">
                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn_modificar_registro">Registrar</button>
                    </div>
                </div>
            </div>
        </div> -->

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
       $(".btn_modificar_registro").click(function(event) {
           UpdateRegistro();
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
                console.log(r.data);
                if(r.status){
                    var tbody = '';
                    console.log(r);
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['url_pagina']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['apellidos']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['cantidad_horas']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['descripcion']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_registro']}</td>`;
                        tbody += `</tr>`;
                    }
                    $('#tbodyregistro_horas').html(tbody);

                    $(".btn_editar_registro").click(function(event) {
                        $("#ModalEditRegistro").modal('show');
                        id_registro = $(this).data('id_registro');
                        traerDatosFactura(id_registro);
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

    // function traerDatosFactura(id){
    //     $.ajax({
    //         url: '<?= base_url('admin/home/getDatosRegistros') ?>',
    //         type: 'POST',
    //         dataType: 'json',
    //         data: {id: id},
    //     })
    //     .done(function(r) {
    //         $("#cantidad_horas").val(r['data'][0]['cantidad_horas']);
    //         $("#descuento").val(r['data'][0]['descuento']);
    //         $("#descripcion").val(r['data'][0]['descripcion']);
    //         $("#fecha_registro").val(r['data'][0]['fecha_registro']);
    //         $(".btn_modificar_registro").removeAttr('id_registro');
    //         $(".btn_modificar_registro").attr('id_registro', id);
    //     })
    //     .fail(function(r) {
    //         console.log(r);
    //     });
        
    // }

    // function UpdateRegistro(){
    //     cantidad_horas = $("#cantidad_horas").val();
    //     descuento = $("#descuento").val();
    //     descripcion = $("#descripcion").val();
    //     fecha_registro = $("#fecha_registro").val();
    //     id_registro = $(".btn_modificar_registro").attr('id_registro');
    //     id_factura = <?php echo $id_factura; ?>;

    //     $.ajax({
    //         url: '<?= base_url('admin/home/updateDatosRegistros') ?>',
    //         type: 'POST',
    //         dataType: 'json',
    //         data: {id_factura:id_factura,cantidad_horas:cantidad_horas,descuento:descuento,descripcion:descripcion,fecha_registro:fecha_registro,id_registro:id_registro},
    //     })
    //     .done(function(r) {
    //         if (r.status) {
    //             $("#ModalEditRegistro").modal('hide');
    //             alertify.success('Registro Exitoso');
    //             load_registro_horas('' , 1);
    //             alertify.confirm().close();
    //             return;
    //         }
    //         alertify.alert("Error en modificar");
    //         $("#ModalEditRegistro").modal('hide');


    //     })
    //     .fail(function(r) {
    //         console.log("error");
    //         console.log(r);

    //     });
        
    // }
    
    
</script>