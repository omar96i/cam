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
                                        <h2 class="d-inline">Tokens</h2>

                                        <a href="" class="btn btn-info mb-2 ml-1 btn_modal_penalizaciones">Penalizaciones</a>
                                        <a href="" class="btn btn-info mb-2 ml-1 btn_modal_adelantos">Adelantos</a>

                                    </div>
                                </div>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Url pagina</th>
                                                    <th>Cantidad Tokens</th>
                                                    <th>Descripcion</th>
                                                    <th>Fecha de registro</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyhoras" class="text-center">

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

        <!-- Modal -->
        <div class="modal fade" id="ModalPenalizaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Penalizaciones</h5>
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
                                    </tr>
                                </thead>

                                <tbody id="tbodypenalizaciones" class="text-center">

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

        <!-- Modal -->
        <div class="modal fade" id="ModalAdelantos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adelantos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div  class="table-responsive mt-1">
                            <table id="empty" class="table table-sm table-striped table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Descripcion</th>
                                        <th>Valor</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>

                                <tbody id="tbodyadelantos" class="text-center">

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
    $(document).ready(function() {
        $(".btn_modal_penalizaciones").click(function(event) {
            event.preventDefault();
            $("#ModalPenalizaciones").modal('show');
            load_penalizaciones('' , 1);

        });

        $(".btn_modal_adelantos").click(function(event) {
            event.preventDefault();
            $("#ModalAdelantos").modal('show');
            load_adelantos();
        });
    });
    
    function load_horas(valor , pagina) {
        $.ajax({
            url      : '<?= base_url('empleado/ConsultarHoras/verhoras') ?>',
            method   : 'POST',
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['url_pagina']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['cantidad_horas']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['descripcion']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_registro']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['estado_registro']}</td>
                        </tr>`;
                    }
                    $('#tbodyhoras').html(tbody);
                }
				$("#empty").DataTable( {
					"order": [[ 4, "desc" ]]
				} )
            },
            dataType : 'json'
        });

        return false;
    }

    load_horas('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_horas(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_horas('' , link);
    });

    function load_penalizaciones(valor , pagina) {
        
        $.ajax({
            url      : '<?php echo base_url('empleado/Home/getPenalizaciones') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina},
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['nombre_penalizacion']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['descripcion']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_registrado']}</td>
                        </tr>`;
                    }
                    $('#tbodypenalizaciones').html(tbody);
                }
            },
            dataType : 'json'
        });

        return false;
    }

    function load_adelantos() {
        
        $.ajax({
            url      : '<?php echo base_url('empleado/Home/getAdelanto') ?>',
            method   : 'POST',
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['descripcion']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['valor']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_registrado']}</td>

                        </tr>`;
                    }
                    $('#tbodyadelantos').html(tbody);
        
                }
            },
            dataType : 'json'
        });

        return false;
    }



</script>
