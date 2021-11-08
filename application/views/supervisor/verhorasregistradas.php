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
                                    <div class="col-6">
                                        <h2 class="d-inline">Registro de tokens</h2>
                                    </div>
                                </div>

                                <?php if(!empty($paginas)): ?>
                                    <div  class="table-responsive mt-1">
                                        <table id="empty" class="table table-sm table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Url pagina</th>
                                                    <th>Usuario</th>
                                                    <th>Contraseña</th>
                                                    <th>Tokens</th>
                                                    <th>Estado</th>
                                                    <th>Fecha</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="tbodypaginas" class="text-center">

                                            </tbody>
                                        </table>

                                        <div class="pagination_usuarios mt-2">

                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo base_url('assets/images/empty_folder.png') ?>" alt="emptyfolder" style="width: 350px">
                                            <p><span class="text-muted">No hay paginas</span></p>
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
            load_paginas(usuario , 1);
        });
        $("#fecha_final_buscar").change(function(event) {
            usuario = $(".search_usuarios").val();
            load_paginas(usuario , 1);
        });
    });
    function load_paginas(valor , pagina) {
        id_usuario = <?php echo $usuario; ?>;
        $.ajax({
            url      : '<?= base_url('supervisor/home/gethoras') ?>',
            method   : 'POST',
            data     : {valor : valor , pagina : pagina, id_usuario: id_usuario},
            success  : function(r){
                if(r.status){
					data = _.filter(r.data, ['estado_registro', 'sin registrar']);
                    var tbody = '';
                    
                    for(var k=0; k<data.length; k++) {
                        tbody += `<tr>
                            <td class="align-middle text-capitalize">${data[k]['url_pagina']}</td>
                            <td class="align-middle text-capitalize">${data[k]['correo']}</td>
                            <td class="align-middle text-capitalize">${data[k]['clave']}</td>
                            <td class="align-middle text-capitalize">${data[k]['cantidad_horas']}</td>
                            <td class="align-middle text-capitalize">${data[k]['estado_registro']}</td>
                            <td class="align-middle text-capitalize">${data[k]['fecha_registro']}</td>`;
                        if (r.data[k]['estado_registro'] == 'sin registrar') {
                            tbody += `<td class="align-middle">
                                <a href="<?php echo site_url('supervisor/Home/editarhoras/') ?>${data[k]['id_registro_horas']+'/'+<?= $this->uri->segment(4) ?>}" class="text-info"><i class="icon-pencil5"></i></a>
                            </td>`;
                        }else{
							tbody += `<td class="align-middle">
                            </td>`;
						}



                        tbody += `</tr>`;
                    }
                    $('#tbodypaginas').html(tbody);

					$('#empty').DataTable( {
						"order": [[ 5, "desc" ]]
					} );
                }
            },
            dataType : 'json'
        });

        return false;
    }

    load_paginas('' , 1);

    $('.search_usuarios').on('keyup' , function() {
        var search = $(this).val();
        load_paginas(search , 1);
    });

    $('body').on('click' , '.pagination li a' , function(e){
        e.preventDefault();
        var link = $(this).attr('href');
            load_paginas('' , link);
    });

    $('body').on('click' , '.btn_generar_registro' , function(e){
        e.preventDefault();
        console.log("entrando aqui")
        alertify.confirm("Nomina" , "Generar registro",
        function(){
            $.ajax({
                url      : ruta,
                method   : 'POST',
                data     : {id_persona : id_persona},
                success  : function(r){
                    if(r.status){
                        alertify.success('Registro eliminado');
                        load_personal('' , 1);
                        alertify.confirm().close();
                        return;
                    }

                    alertify.alert(r.msg);
                },
                dataType : 'json'
            });

            return false;
        },
        function(){
            alertify.confirm().close();
        });
    });
</script>
