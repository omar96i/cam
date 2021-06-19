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
                                        <h2 class="d-inline">Nomina</h2>
                                    </div>

                                    <div class="col-6">
                                        <?php if(!empty($factura)): ?>
                                            <div class="input-group">
                                                <input type="text"  class="form-control search_usuarios" placeholder="Buscar (por nombre)..." aria-label="Search factura">
                                                <input type="date" id="fecha_inicial_buscar" class="form-control" name="s_fecha_buscar">
                                                <input type="date" id="fecha_final_buscar" class="form-control" name="s_fecha_buscar">

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if(!empty($factura)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Documento Modelo</th>
                                                    <th>Nombre Modelo</th>
                                                    <th>Valor Dolar</th>
                                                    <th>Dias asistidos</th>
                                                    <th>Estado meta</th>
                                                    <th>Tokens meta</th>
                                                    <th>Porcentaje de paga</th>
                                                    <th>Descuento</th>
                                                    <th>Penalizaciones Tokens</th>
                                                    <th>Total Tokens</th>
                                                    <th>Total Pago</th>
                                                    <th>Fecha de registro</th>
                                                    <th>imprimir</th>

                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyfactura" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay factura</span></p>
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

<script>
    $(document).ready(function() {
        $("#fecha_inicial_buscar").change(function(event) {
            usuario = $(".search_usuarios").val();
            load_factura(usuario , 1);
        });
        $("#fecha_final_buscar").change(function(event) {
            usuario = $(".search_usuarios").val();
            load_factura(usuario , 1);
        });
    });
    function load_factura(valor , pagina) {
        fecha_inicio = $("#fecha_inicial_buscar").val();
        fecha_final = $("#fecha_final_buscar").val();
        
        $.ajax({
            url      : '<?= base_url('admin/Home/getfacturas') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina, fecha_inicio: fecha_inicio, fecha_final: fecha_final},
            success  : function(r){
                console.log(r);
                if(r.status){
                    var tbody = '';
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['documento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['valor_dolar']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['cant_dias']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['estado_meta']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['num_horas']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['porcentaje_paga']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['descuento']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['penalizacion_horas']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['total_horas']}</td>
                            <td class="align-middle text-capitalize">${new Intl.NumberFormat().format(r.data[k]['total_a_pagar'])}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_registrado']}</td>
                            <td class="align-middle text-capitalize">
                                <a href="<?php echo base_url('Imprimir_factura/getFacturaInf/') ?>${r.data[k]['id_factura']}" target="_blank"><img src="<?php echo base_url('assets/iconos_menu/impresora.png') ?>" alt="" style="width: 20px; height: 20px;"> </a>
                            </td>

                            <td class="align-middle">
                                <a href="<?php echo site_url('admin/Home/verRegistrosFactura/') ?>${r.data[k]['id_factura']}" class="text-dark"><img src="<?php echo base_url('assets/iconos_menu/verificar.png') ?>" alt="" style="width: 20px; height: 20px;"> </a>
                            </td>
                            </tr>`;
                    }
                    $('#tbodyfactura').html(tbody);

                    $(".btn_mirar_factura").click(function(e) {
                        e.preventDefault();
                        $("#modalVerRegistros").modal('show');

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

    load_factura('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_factura(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_factura('' , link);
    });

    
    
</script>