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
                <a href="<?= base_url('admin/Home/paginas') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                    <div class="col-8">
                                        <h2 class="d-inline">Agregar asignacion</h2>
                                    </div>
                                </div>

                                <form action="" id="form_addproduct" enctype="multipart/form-data">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
	                                            <label for="paginas" class="col-form-label">Nombre Paginas:</label>
	                                            <select name="paginas" id="paginas" class="form-control">
	                                                <option value="0">Sin seleccionar</option>
	                                                <?php foreach ($lista_paginas as $key => $value) {?>
	                                                	<option value="<?php echo $value->id_pagina ?>"><?php echo $value->url_pagina ?></option>
	                                               	<?php
	                                                } ?>
	                                            </select>
	                                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
	                                        </div>
                                            <div class="form-group">
	                                            <label for="usuario" class="col-form-label">Modelos:</label>
	                                            <select name="usuario" id="usuario" class="form-control">
	                                                <option value="0">Sin seleccionar</option>
	                                            </select>
	                                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
	                                        </div>
                                       </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="correo" class="col-form-label">Nick/Usuario:</label>
                                                <input type="email" id="correo" class="form-control" name="correo">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="clave" class="col-form-label">Contraseña:</label>
                                                <input type="text" id="clave" class="form-control" name="clave">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_agregar_asignacion">Aceptar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
        $("#paginas").change(function(event) {
            $("#usuario").children().first().siblings().remove();
            id = $("#paginas").val();
            if (id != 0) {
                $.ajax({
                    url: '<?php echo base_url('admin/home/verificarasignacion') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {id: id},
                })
                .done(function(r) {
                    if (r.status) {
                        texto = "";
                        for (var i = 0; i < r['lista'].length; i++) {
                            texto += "<option value='"+r['lista'][i]['id_persona']+"'>"+r['lista'][i]['id_persona']+" / "+r['lista'][i]['nombres']+"</option>"
                        }
                        $("#usuario").append(texto);
                    }
                });
            }
            
        });

        $('.btn_agregar_asignacion').on('click' , function(e){
            e.preventDefault();
            var ruta      = "<?php echo base_url('admin/home/addasignacion') ?>";
                paginas = $("#paginas").val();
                usuario = $("#usuario").val();
                correo = $("#correo").val();
                clave = $("#clave").val();

                if ($("#paginas").val() == 0) {
                    $("#paginas").addClass('is-invalid');
                }else{
                    $("#paginas").removeClass('is-invalid');
                }
                if ($("#usuario").val() == 0) {
                    $("#usuario").addClass('is-invalid');
                }else{
                    $("#usuario").removeClass('is-invalid');
                }
                if ($("#correo").val() == '') {
                    $("#correo").addClass('is-invalid');
                }else{
                    $("#correo").removeClass('is-invalid');
                }
                if ($("#clave").val() == '') {
                    $("#clave").addClass('is-invalid');
                }else{
                    $("#clave").removeClass('is-invalid');
                }

                if( $("#paginas").val() != 0 &&
                	$("#usuario").val() != 0 &&
                	$("#correo").val() != '' &&
                	$("#clave").val() != '' 
                ) {

                    $.ajax({
                        url: ruta,
                        type: 'POST',
                        dataType: 'json',
                        data: {paginas: paginas, usuario: usuario, correo: correo, clave: clave},
                    })
                    .done(function(r) {

                        if(r.status){
                            $('#form_addproduct').trigger('reset');
                            alertify.notify(
                                'Pagina agregada con éxito', 
                                'success', 
                                2
                            );
                            return;
                        }

                        alertify.alert('Ups :(' , r.msg);

                    });

                    return false;

                }

            return false;

        });
    });
    
</script>