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
                <a href="<?= base_url('supervisor/Home/empleados') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                    <div class="col-4">
                                        <h2 class="d-inline">Informes</h2>
                                    </div>
                                </div>

                                <?php if(!empty($lista_informes)): ?>
                                    <div class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Empleado</th>
                                                    <th>Fecha</th>
                                                    <th>Descripcion</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodyinformes" class="text-center">

                                            </tbody>
                                        </table>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay Informes</span></p>
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
    function load_informes(pagina) {
        
        id_usuario = <?php echo $id_empleado; ?>;
        $.ajax({
            url      : '<?= base_url('supervisor/VerInformes/getInformes') ?>',
            method   : 'POST',
            data     : {id_usuario: id_usuario},
            success  : function(r){
                if(r.status){
                    var tbody = '';
                    
                    for(var k=0; k<r.data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${r.data[k]['nombres']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['fecha']}</td>
                            <td class="align-middle text-capitalize">${r.data[k]['descripcion']}</td>`;

                        if ("<?php echo $tipo_usuario ?>" != "administrador") {
                            tbody += `<td class="align-middle">
                                    <a href="<?php echo site_url('supervisor/EditarInforme/editInforme/') ?>${r.data[k]['id_informe_empleado']+'/'+<?= $this->uri->segment(4) ?>}" class="text-dark"><img src="<?php echo base_url('assets/iconos_menu/editar.png') ?>" alt=""></a>
                                </td>
                            </tr>`;
                        }
                        
                    }
                    $('#tbodyinformes').html(tbody);

					$('#empty').DataTable();

                   
                }
            },
            dataType : 'json'
        });

        return false;
    }

    load_informes(1);
    $("#fecha_inicial").change(function (e) {
        load_informes(1);
    });
    $("#fecha_final").change(function (e) { 
        load_informes(1);
    });
    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_informes(link);
    });
</script>
