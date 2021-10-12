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
                <a href="<?= base_url('admin/Home/diasPorcentajes') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Editar porcentajes</h2>
                                    </div>
                                </div>

                                <form action="" id="form_editusuary">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="dias" class="col-form-label">Cantidad Dias :</label>
                                                <input type="text" id="dias" value="<?php echo $porcentaje[0]->cantidad_dias ?>" class="form-control" name="dias">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="valor" class="col-form-label">% :</label>
                                                <input type="number" id="valor" value="<?php echo $porcentaje[0]->valor ?>" class="form-control" name="valor">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
											<div class="form-group">
                                                <label for="valor_multiplicar" class="col-form-label">Valor a multiplicar :</label>
                                                <input type="number" id="valor_multiplicar" value="<?php echo $porcentaje[0]->valor_multiplicar ?>" class="form-control" name="valor_multiplicar">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="estado_meta" class="col-form-label">Estado Meta :</label>
                                                <select name="estado_meta" id="estado_meta" class="form-control">
                                                    <option value="completa" <?php echo ($porcentaje[0]->estado_meta=='completa')?'selected':''; ?>>completa</option>
                                                    <option value="incompleta" <?php echo ($porcentaje[0]->estado_meta=='incompleta')?'selected':''; ?>>incompleta</option>
                                                </select>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
											<div class="form-group">
                                                <label for="tipo" class="col-form-label">Tipo</label>
                                                <select name="tipo" id="tipo" class="form-control">
                                                    <option value="general" <?php echo ($porcentaje[0]->tipo=='general')?'selected':''; ?>>General</option>
                                                    <option value="bomgacams" <?php echo ($porcentaje[0]->tipo=='bomgacams')?'selected':''; ?>>Bomgacams</option>
                                                </select>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="estado" class="col-form-label">Estado :</label>
                                                <select name="estado" id="estado" class="form-control">
                                                	<option value="activo" <?php echo ($porcentaje[0]->estado=='activo')?'selected':''; ?>>activo</option>
                                                	<option value="inactivo" <?php echo ($porcentaje[0]->estado=='inactivo')?'selected':''; ?>>inactivo</option>
                                                </select>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                       </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_edit_pagina">Editar</button>
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
    $('.btn_edit_pagina').on('click' , function(e){
        e.preventDefault();

    	dias = $("#dias").val();
    	valor = $("#valor").val();
    	estado = $("#estado").val();
        estado_meta = $("#estado_meta").val();
        valor_multiplicar = $("#valor_multiplicar").val();
        tipo = $("#tipo").val();


    	id_porcentajes = <?php echo $porcentaje[0]->id_porcentajes_dias; ?>;

        ruta = "<?php echo base_url('admin/home/storePorcentajeDias'); ?>"
        

        if($("#dias").val() == '') {
            $("#dias").addClass('is-invalid');
        }
        else {
            $("#dias").removeClass('is-invalid');
        }
        if($("#valor").val() == '') {
            $("#valor").addClass('is-invalid');
        }
        else {
            $("#valor").removeClass('is-invalid');
        }
        if($("#estado").val() == '') {
            $("#estado").addClass('is-invalid');
        }
        else {
            $("#estado").removeClass('is-invalid');
        }
        if ($("#estado_meta").val() == '') {
            $("#estado_meta").addClass('is-invalid');
        }else{
            $("#estado_meta").removeClass('is-invalid');
        }
		if ($("#valor_multiplicar").val() == '') {
			$("#valor_multiplicar").addClass('is-invalid');
		}else{
			$("#valor_multiplicar").removeClass('is-invalid');
		}
		if ($("#tipo").val() == '') {
			$("#tipo").addClass('is-invalid');
		}else{
			$("#tipo").removeClass('is-invalid');
		}


                   
        if( $("#dias").val() != '' &&
			$("#valor").val() != '' &&
			$("#estado").val() != '' &&
            $("#estado_meta").val() != '' && 
			$("#valor_multiplicar").val() != '' &&
			$("#tipo").val() != ''
        ){
            
            $.ajax({
                url: ruta,
                type: 'POST',
                dataType: 'json',
                data: {dias : dias , valor : valor, estado : estado, id_porcentajes: id_porcentajes, estado_meta:estado_meta, valor_multiplicar: valor_multiplicar, tipo: tipo},
            })
            .done(function(r) {
                if(r.status){
                    alertify.notify('Registro actualizado', 'success', 2, function(){
                        window.location.href = '../diasPorcentajes';
                    });
                    return;
                }
                alertify.alert('Ups :(' , r.msg);

            })
            .fail(function(r) {
                alertify.alert('Ups :(' , r.msg);
            })
            return false;

        }

        return false;


    });
    
</script>
