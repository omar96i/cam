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
                <a href="<?= base_url('admin/Gastos') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Editar Gasto</h2>
                                    </div>
                                </div>

                                <form action="" id="form_addproduct" enctype="multipart/form-data">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
	                                            <label for="descripcion" class="col-form-label">Descripcion:</label>
                                                <input type="text" class="form-control" id="descripcion" value="<?php echo $respuesta[0]->descripcion ?>">
	                                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
	                                        </div>
                                            <div class="form-group">
	                                            <label for="valor" class="col-form-label">Valor:</label>

                                                <input type="number" id="valor" class="form-control" name="valor" value="<?php echo $respuesta[0]->valor ?>">
	                                            <div class="invalid-feedback">El campo no debe quedar vacío</div>
	                                        </div>
                                       </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="fecha" class="col-form-label">Fecha:</label>
                                                <input type="date" value="<?php echo $respuesta[0]->fecha ?>" id="fecha" class="form-control" name="fecha">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>  
                                       </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_editar_gasto" data-id_gasto="<?php echo $respuesta[0]->id_gasto ?>">Aceptar</button>
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

        $('.btn_editar_gasto').on('click' , function(e){
            e.preventDefault();
            var ruta      = "<?php echo base_url('admin/EditarGasto/EditGasto') ?>";
                descripcion = $("#descripcion").val();
                valor = $("#valor").val();
                id = $(this).data('id_gasto');
                fecha = $("#fecha").val();

                if ($("#descripcion").val() == "") {
                    $("#descripcion").addClass('is-invalid');
                }else{
                    $("#descripcion").removeClass('is-invalid');
                }
                if ($("#valor").val() == "") {
                    $("#valor").addClass('is-invalid');
                }else{
                    $("#valor").removeClass('is-invalid');
                }
                if ($("#fecha").val() == '') {
                    $("#fecha").addClass('is-invalid');
                }else{
                    $("#fecha").removeClass('is-invalid');
                }

                if( $("#descripcion").val() != '' &&
                	$("#valor").val() != '' &&
                	$("#fecha").val() != ''
                ) {

                    $.ajax({
                        url: ruta,
                        type: 'POST',
                        dataType: 'json',
                        data: {descripcion: descripcion, valor: valor, fecha: fecha, id:id},
                    })
                    .done(function(r) {
                        if(r.status){
                            alertify.notify('Gasto Actualizado', 'success', 2, function(){
                               window.location.href = '../../Gastos';
                            });
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