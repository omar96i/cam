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
                                    <div class="col-4">
                                        <h2 class="d-inline">Gastos e Ingresos</h2>
                                    </div> 
                                    <div class="col-4">
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="fecha_inicio">
                                        </div>
                                    </div> 
                                    <div class="col-4">
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="fecha_final">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-6">
                                        <div class="card text-center bg-danger">
                                            <div class="card-body">
                                                <h5 class="card-title">GASTOS</h5>
                                                <p class="card-text" id="text_gastos">Sus gastos son</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card text-center bg-success">
                                            <div class="card-body">
                                                <h5 class="card-title">INGRESOS</h5>
                                                <p class="card-text" id="text_ingresos">Sus ingresos son</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card text-center bg-success card_ganancia">
                                            <div class="card-body">
                                                <h5 class="card-title">GANANCIA</h5>
                                                <p class="card-text" id="text_ganancia">Sus gastos son</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <a href="<?php echo base_url('admin/AddGasto') ?>" class="btn btn-info mb-2 ml-1">Agregar Gastos</a>
                                        <a href="" class="btn btn-info mb-2 ml-1 btn_consulta_gastos">Ver gasto</a>
                                        <a href="" class="btn btn-info mb-2 ml-1 btn_consultar_ingresos">Ver ingresos</a>
                                    </div>

                                    <div class="col-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control search_usuarios" placeholder="Buscar (por nombre)..." aria-label="Search usuarios">
                                            </div>
                                    </div>
                                </div>
                                
                                <div  class="table-responsive mt-1 tabla_gastos" style="display: none;">
                                    <table id="empty" class="table table-sm table-striped table-bordered">
                                        <thead class="text-center">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Descripcion</th>
                                                <th>Valor</th>
                                                <th>Fecha</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody id="tbodygastos" class="text-center">

                                        </tbody>
                                    </table style="border-radius: 50%;">

                                    <div class="pagination_gastos mt-2">

                                    </div>
                                </div>

                                <div  class="table-responsive mt-1 tabla_ingresos" style="display: none;">
                                    <table id="empty" class="table table-sm table-striped table-bordered">
                                        <thead class="text-center">
                                            <tr>
                                                <th>Total pagado</th>
                                                <th>Total Horas</th>
                                                <th>Porcentaje</th>

                                                <th>Fecha</th>
                                                <th>Valor Neto</th>
                                            </tr>
                                        </thead>

                                        <tbody id="tbodyingresos" class="text-center">

                                        </tbody>
                                    </table style="border-radius: 50%;">

                                    <div class="pagination_ingresos mt-2">

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
    $(document).ready(function() {
        $("#fecha_inicio").change(function(event) {
            getDataAnalisis();
        });
        $("#fecha_final").change(function(event) {
            getDataAnalisis();
        });
        getDataAnalisis()
        $(".tabla_ingresos").hide();
        $(".tabla_gastos").hide();
        $('.search_usuarios').on('keyup' , function() {
            var search = $(this).val();
            load_usuarios(search , 1);
        });

        $('body').on('click' , '.pagination_gastos li a' , function(e){
            e.preventDefault();
            var link = $(this).attr('href');
                load_gastos('' , link);
        });

        $('body').on('click' , '.paginador_ingreso li a' , function(e){
            e.preventDefault();
            var link = $(this).attr('href');
                load_ingresos('' , link);
        });

        $(".btn_consulta_gastos").click(function(event) {
            event.preventDefault();
            load_gastos('', 1);
        });

        $(".btn_consultar_ingresos").click(function(event) {
            event.preventDefault();
            load_ingresos('', 1);
        });
    });
    function load_gastos(valor , pagina) {
        $(".tabla_ingresos").hide();
        $(".tabla_gastos").show();
        $.ajax({
            url      : '<?= base_url('admin/Gastos/getGastos') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina},
            success  : function(r){
                if(r.status){
                    var tbody = '';

                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['descripcion']}</td>
                            <td class="align-middle text-capitalize">${"$ "+new Intl.NumberFormat().format(r.data[k]['valor'])}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha']}</td>
                            <td><a href="<?php echo site_url('admin/EditarGasto/index/') ?>${r.data[k]['id_gasto']}" class="text-info" data-toggle="tooltip" title="Editar"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> </a></td>
                        </tr>`;
                    }
                    $('#tbodygastos').html(tbody);

                    // Total de Usuarios y la cantidad por registro
                    var cantidad        = r.cantidad,
                        total_registros = r.total_registros,
                        numero_links    = Math.ceil(total_registros / cantidad),
                        link_seleccion  = pagina;

                        pagination = '<nav aria-label="Paginador gastos"><ul class="pagination pagination_gastos justify-content-center">';                    
                        for(var i = 1; i <= numero_links; i++) {
                            if(i == link_seleccion) {
                                pagination += `<li class="page-item active"><a class="page-link" href="#">${i}</a></li>`;
                            }
                            else {
                                pagination += `<li class="page-item"><a class="page-link" href="${i}">${i}</a></li>`;

                            }
                        }
                        pagination += '</ul></nav>';

                        $('.pagination_gastos').html(pagination);
                    false;
                }
            },
            dataType : 'json'
        });

        return false;
    }

    function getDataAnalisis(){
        fecha_inicio = $("#fecha_inicio").val();
        fecha_final = $("#fecha_final").val();
        $.ajax({
            url: '<?= base_url('admin/Gastos/getDataAnalisis') ?>',
            type: 'POST',
            dataType: 'json',
            data: {fecha_inicio: fecha_inicio, fecha_final:fecha_final},
        })
        .done(function(r) {
            $(".card_ganancia").removeClass('bg-danger');
            $(".card_ganancia").removeClass('bg-success');

            if (r['estado'] == "OK") {
                $("#text_gastos").html("$ "+new Intl.NumberFormat().format(r['gastos']));
                $("#text_ingresos").html("$ "+new Intl.NumberFormat().format(r['ingresos']));
                $("#text_ganancia").html("$ "+new Intl.NumberFormat().format(r['total']));
                $(".card_ganancia").addClass('bg-success');
            }else{
                $("#text_gastos").html("$ "+new Intl.NumberFormat().format(r['gastos']));
                $("#text_ingresos").html("$ "+new Intl.NumberFormat().format(r['ingresos']));
                $("#text_ganancia").html("$ "+new Intl.NumberFormat().format(r['total']));
                $(".card_ganancia").addClass('bg-danger');
            }
        })
        .fail(function(r) {
            console.log("error");
            console.log(r)
        });
    }

    function load_ingresos(valor , pagina) {
        $(".tabla_gastos").hide();
        $(".tabla_ingresos").show();
        $.ajax({
            url      : '<?= base_url('admin/Gastos/getIngresos') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina},
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['total_a_pagar']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['total_horas']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['porcentaje']}</td>

                            <td class="align-middle text-capitalize">${r.data[k]['fecha_registro']}</td>
                            <td class="align-middle text-capitalize">${"$ "+new Intl.NumberFormat().format(r.data[k]['valor'])}</td>
                        </tr>`;
                    }
                    $('#tbodyingresos').html(tbody);

                    // Total de Usuarios y la cantidad por registro
                    var cantidad        = r.cantidad,
                        total_registros = r.total_registros,
                        numero_links    = Math.ceil(total_registros / cantidad),
                        link_seleccion  = pagina;

                        pagination = '<nav aria-label="Paginador gastos"><ul class="pagination paginador_ingreso justify-content-center">';                    
                        for(var i = 1; i <= numero_links; i++) {
                            if(i == link_seleccion) {
                                pagination += `<li class="page-item active"><a class="page-link" href="#">${i}</a></li>`;
                            }
                            else {
                                pagination += `<li class="page-item"><a class="page-link" href="${i}">${i}</a></li>`;
                            }
                        }
                        pagination += '</ul></nav>';

                        $('.pagination_ingresos').html(pagination);
                    false;
                }
            },
            dataType : 'json'
        });

        return false;
    }
</script>