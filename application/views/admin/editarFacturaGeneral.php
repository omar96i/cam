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
                <a href="<?= base_url('admin/Home/adelantos') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Editar Nomina</h2>
                                    </div>
                                </div>

                                <form action="" id="form_add_adelanto" enctype="multipart/form-data">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="id_factura_general" class="col-form-label">Id:</label>
                                                <input type="number" id="id_factura_general" value="<?php echo $factura[0]->id_factura_general; ?>" class="form-control" readonly name="id_factura_general">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion" class="col-form-label">Descripcion:</label>
                                                <textarea name="descripcion" class="form-control" id="descripcion" cols="30" rows="2"><?php echo $factura[0]->descripcion; ?></textarea>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="total_a_pagar" class="col-form-label">Valor actual:</label>
                                                <input type="number" id="total_a_pagar" readonly value="<?php echo $factura[0]->total_a_pagar; ?>" class="form-control" name="total_a_pagar">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
											<div class="form-group">
                                                <label for="nuevo_valor" class="col-form-label">Valor nuevo:</label>
                                                <input type="number" id="nuevo_valor" value="<?php echo $factura[0]->nuevo_valor; ?>" class="form-control" name="nuevo_valor">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn_agregar_asignacion">Aceptar</button>
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

        $('.btn_agregar_asignacion').on('click' , function(e){
            e.preventDefault();
            var ruta      = "<?php echo base_url('admin/home/editFacturaGeneral') ?>";
            var form_data = new FormData($('#form_add_adelanto')[0]);

            if ($("#id_factura_general").val() == '') {
                $("#id_factura_general").addClass('is-invalid');
            }else{
                $("#id_factura_general").removeClass('is-invalid');
            }
            if ($("#descripcion").val() == '') {
                $("#descripcion").addClass('is-invalid');
            }else{
                $("#descripcion").removeClass('is-invalid');
            }
            if ($("#total_a_pagar").val() == '') {
                $("#total_a_pagar").addClass('is-invalid');
            }else{
                $("#total_a_pagar").removeClass('is-invalid');
            }
			if ($("#nuevo_valor").val() == '') {
                $("#nuevo_valor").addClass('is-invalid');
            }else{
                $("#nuevo_valor").removeClass('is-invalid');
            }

            if( $("#id_factura_general").val() != '' &&
                $("#descripcion").val() != '' &&
				$("#nuevo_valor").val() != '' &&
                $("#total_a_pagar").val() != '' 
            ) {
				

                $.ajax({
                    url: ruta,
                    type: 'POST',
                    dataType: 'json',
                    data: form_data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                })
                .done(function(r) {

                    if(r.status){
                        $('#form_addproduct').trigger('reset');
                        alertify.notify('Registro agregado con éxito', 'success', 2, function(){
                           window.location.href = '../factura_general';
                        });
                        return;
                    }

                    alertify.alert('Ups :(' , r.msg);

                })
                .fail(function(r) {
                    console.log("error");
                    console.log(r);
                });

                return false;

            }

            return false;

        });
    });
    
</script>
