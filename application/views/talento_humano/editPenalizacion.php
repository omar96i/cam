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
                <a href="<?= base_url('talento_humano/Home/verPenalizaciones/'.$id_modelo) ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Editar Penalizacion</h2>
                                    </div>
                                </div>

                                <form action="" id="form_editusuary">
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="penalizacion" class="col-form-label">Penalizacion:</label>
                                                <select name="penalizacion" id="penalizacion" class="form-control">
                                                	<?php foreach ($penalizaciones as $key => $value): ?>
                                                		<option value="<?php echo $value->id_penalizacion ?>" <?php echo ($penalizacion[0]->id_penalizacion==$value->id_penalizacion)?"selected":""; ?>><?php echo $value->id_penalizacion." / ".$value->nombre_penalizacion ?></option>
                                                	<?php endforeach ?>
                                                </select>
                                                
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion" class="col-form-label">Observacion:</label>
                                                <textarea name="descripcion" id="descripcion" class="form-control" cols="30" rows="2"><?php echo $penalizacion[0]->descripcion ?></textarea>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="fecha" class="col-form-label">Fecha:</label>
                                                <input type="date" class="form-control" id="fecha" value="<?php echo $penalizacion[0]->fecha_registrado ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_editusuary" data-id_usuario="">Editar</button>
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
    $('.btn_editusuary').on('click' , function(e){
        e.preventDefault();
        

        ruta         = "<?php echo base_url('talento_humano/home/storePenalizacion') ?>"
        id_penalizacon = $("#penalizacion").val();
        id_relacion = <?php echo $penalizacion[0]->id_empleado_penalizacion ?>;
        descripcion = $("#descripcion").val();
        fecha = $("#fecha").val();


        $.ajax({
            url: ruta,
            type: 'POST',
            dataType: 'json',
            data: {id_penalizacon: id_penalizacon, id_relacion: id_relacion, descripcion:descripcion, fecha:fecha},
        })
        .done(function(r) {
            if(r.status){
                alertify.notify('Registro actualizado', 'success', 2, function(){
                    window.location.href = '<?php echo base_url('talento_humano/Home/usuarios') ?>';
                });
                return;
            }

        })
        .fail(function(r) {
            console.log("error");
            console.log(r);
        });
            

    });
</script>