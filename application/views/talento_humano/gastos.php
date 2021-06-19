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
                                </div>

                                <div class="row">
                                    <div class="col-8">
                                        <a href="<?php echo base_url('talento_humano/AddGasto') ?>" class="btn btn-info mb-2 ml-1">Agregar Gastos</a>
                                        <a href="" class="btn btn-info mb-2 ml-1 btn_consulta_gastos">Ver gasto</a>
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
                                            </tr>
                                        </thead>

                                        <tbody id="tbodygastos" class="text-center">

                                        </tbody>
                                    </table style="border-radius: 50%;">

                                    <div class="pagination_gastos mt-2">

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

        $(".btn_consulta_gastos").click(function(event) {
            event.preventDefault();
            load_gastos('', 1);
        });
    });
    function load_gastos(valor , pagina) {
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

</script>