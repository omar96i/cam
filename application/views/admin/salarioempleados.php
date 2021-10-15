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
                                        <h2 class="d-inline">Salarios</h2>
                                        <a href="<?php echo base_url('admin/Home/addSalario') ?>" class="btn btn-info mb-2 ml-1">Agregar salario</a>
                                    </div>

                                    <div class="col-6">
                                        <?php if(!empty($salario)): ?>
                                            <div class="input-group">
                                                <input type="text"  class="form-control search_usuarios" placeholder="Buscar (por nombre)..." aria-label="Search salario">
                                                <input type="date" id="fecha_inicial_buscar" class="form-control" name="s_fecha_buscar">
                                                <input type="date" id="fecha_final_buscar" class="form-control" name="s_fecha_buscar">

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if(!empty($salario)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Tipo usuario</th>
                                                    <th>Salario</th>
                                                    <th>Fecha registro</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodysalario" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay salario</span></p>
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
        <div class="modal fade" id="ModalRegistroNominaGeneral" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Generar Nomina</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fecha_inicial_general" class="col-form-label">Fecha inicial:</label>
                            <input type="date" id="fecha_inicial_general" class="form-control" name="fecha_inicial_general">
                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="fecha_final_general" class="col-form-label">Fecha final:</label>
                            <input type="date" id="fecha_final_general" class="form-control" name="fecha_final_general">
                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn_generar_factura_general">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

<script>
    $(document).ready(function() {
        $(".btn_registrar_nomina_general").click(function(event) {
            $("#ModalRegistroNominaGeneral").modal('show');
        });
        $("#fecha_inicial_buscar").change(function(event) {
            usuario = $(".search_usuarios").val();
            load_salario(usuario , 1);
        });
        $("#fecha_final_buscar").change(function(event) {
            usuario = $(".search_usuarios").val();
            load_salario(usuario , 1);
        });
    });
    function load_salario(valor , pagina) {
        fecha_inicio = $("#fecha_inicial_buscar").val();
        fecha_final = $("#fecha_final_buscar").val();
        
        
        $.ajax({
            url      : '<?= base_url('admin/home/getsalarios') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina, fecha_inicio: fecha_inicio, fecha_final: fecha_final},
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    for(var k=0; k<r.data.length; k++) {
						if(r.data[k]['tipo_usuario'] == "supervisor"){
							r.data[k]['tipo_usuario'] = "monitor"
						}else if(r.data[k]['tipo_usuario'] == "tecnico sistemas"){
							r.data[k]['tipo_usuario'] = "supervisor"

						}
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['tipo_usuario']}</td>
                            <td class="align-middle text-capitalize">${"$ "+new Intl.NumberFormat().format(r.data[k]['sueldo'])}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha_registrado']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['estado']}</td>
                            </tr>`;
                    }
                    $('#tbodysalario').html(tbody);

                    $(".btn_mirar_salario").click(function(e) {
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

    load_salario('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_salario(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_salario('' , link);
    });

    

    
    
    
</script>
