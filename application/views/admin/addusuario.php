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
                <a href="<?= base_url('admin/Home/usuarios') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Agregar Usuario</h2>
                                    </div>
                                </div>

                                <form action="" id="form_addproduct" enctype="multipart/form-data">
									<div class="text-center mt-3 mb-3">
										<div class="text-center">
											<img src="" id="preview" width="40%" style="border-radius: 20px;"><br>
										</div>
									</div>
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="imagen" class="col-form-label">Foto:</label>
                                                <input type="file" id="imagen" class="form-control" name="imagen">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="cedula" class="col-form-label">Cedula:</label>
                                                <input type="number" id="cedula" class="form-control" name="cedula">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
											
											<div class="form-group">
                                                <label for="nombres" class="col-form-label">Nombres:</label>
                                                <input type="text" id="nombres" class="form-control" name="nombres">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
											
                                        
                                            <div class="form-group">
                                                <label for="apellidos" class="col-form-label">Apellidos:</label>
                                                <input type="text" name="apellidos" id="apellidos" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="ciudad" class="col-form-label">Ciudad:</label>
                                                <input type="text" name="ciudad" id="ciudad" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="direccion" class="col-form-label">Direccion:</label>
                                                <input type="text" name="direccion" id="direccion" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                       </div>
                                     

                                        <div class="col-sm-1-2 col-md-4">
                                            <div class="form-group">
                                                <label for="correo_personal" class="col-form-label">Correo personal:</label>
                                                <input type="text" name="correo_personal" id="correo_personal" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="sexo" class="col-form-label">Sexo:</label>
                                                <select name="sexo" id="sexo" class="form-control">
                                                    <option value="0">Seleccione una opción...</option>
                                                    <option value="masculino">masculino</option>
                                                    <option value="femenino">femenino</option>
                                                </select>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="fecha_nacimiento" class="col-form-label">Fecha Nacimiento:</label>
                                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="tipo_cuenta" class="col-form-label">Tipo cuenta:</label>
                                                <select name="tipo_cuenta" id="tipo_cuenta" class="form-control">
                                                    <option value="0">Seleccione una opción...</option>
                                                    <option value="administrador">Administrador</option>
                                                    <option value="supervisor">Supervisor</option>
                                                    <option value="talento humano">Talento Humano</option>
                                                    <option value="tecnico sistemas">Tecnico Sistemas</option>
                                                    <option value="fotografo">Fotografo</option>
                                                    <option value="psicologa">Psicologa</option>
                                                    <option value="servicios generales">Servicios generales</option>
                                                    <option value="community manager">Community manager</option>
                                                    <option value="maquillador">Maquillador</option>
                                                    <option value="operativo">Operativo</option>
													<option value="supervisor de los monitores">Supervisor de los monitores</option>
													<option value="operario de mantenimiento">Operario de mantenimiento</option>
                                                </select>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono" class="col-form-label">Telefono:</label>
                                                <input type="text" name="telefono" id="telefono" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="observaciones" class="col-form-label">Observaciones:</label>
                                                <input type="text" name="observaciones" id="observaciones" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>

                                            
                                        </div>

                                        <div class="col-sm-1-2 col-md-4">
                                            <div class="form-group">
                                                <label for="num_cuenta_banco" class="col-form-label">Numero de cuenta Banco:</label>
                                                <input type="text" name="num_cuenta_banco" id="num_cuenta_banco" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tipo_cuenta_banco" class="col-form-label">Tipo de cuenta Banco:</label>
                                                <input type="text" name="tipo_cuenta_banco" id="tipo_cuenta_banco" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name_banco" class="col-form-label">Nombre del Banco:</label>
                                                <input type="text" name="name_banco" id="name_banco" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="correo" class="col-form-label">Correo:</label>
                                                <input type="email" name="correo" id="correo" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="clave" class="col-form-label">Contraseña:</label>
                                                <input type="text" name="clave" id="clave" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_addproduct">Aceptar</button>
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
		$("#imagen").change(function (e) { 
			// Creamos el objeto de la clase FileReader
			let reader = new FileReader();

			// Leemos el archivo subido y se lo pasamos a nuestro fileReader
			reader.readAsDataURL(e.target.files[0]);

			// Le decimos que cuando este listo ejecute el código interno
			reader.onload = function(){
				$('#preview').attr('src', reader.result);
			};
		});
        $('.btn_addproduct').on('click' , function(e){
            
            e.preventDefault();
            var ruta      = "<?php echo base_url('admin/home/addnewusuario') ?>";
            var form_data = new FormData($('#form_addproduct')[0]);

            if ($("#imagen").val() == '') {
                $("#imagen").addClass('is-invalid');
            }else{
                $("#imagen").removeClass('is-invalid');
            }

            if ($("#cedula").val() == '') {
                $("#cedula").addClass('is-invalid');
            }else{
                $("#cedula").removeClass('is-invalid');
            }
            if ($("#nombres").val() == '') {
                $("#nombres").addClass('is-invalid'); 
            }else{
                $("#nombres").removeClass('is-invalid');
            }
            if ($("#apellidos").val() == '') {
                $("#apellidos").addClass('is-invalid'); 
            }else{
                $("#apellidos").removeClass('is-invalid');
            }
            if ($("#sexo").val() == 0) {
                $("#sexo").addClass('is-invalid'); 
            }else{
                $("#sexo").removeClass('is-invalid');
            }
            if ($("#fecha_nacimiento").val() == '') {
                $("#fecha_nacimiento").addClass('is-invalid'); 
            }else{
                $("#fecha_nacimiento").removeClass('is-invalid');
            }
            if ($("#tipo_cuenta").val() == 0) {
                $("#tipo_cuenta").addClass('is-invalid'); 
            }else{
                $("#tipo_cuenta").removeClass('is-invalid');
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
            if ($("#direccion").val() == '') {
                $("#direccion").addClass('is-invalid'); 
            }else{
                $("#direccion").removeClass('is-invalid');
            }
            if ($("#correo_personal").val() == '') {
                $("#correo_personal").addClass('is-invalid'); 
            }else{
                $("#correo_personal").removeClass('is-invalid');
            }
            if ($("#telefono").val() == '') {
                $("#telefono").addClass('is-invalid'); 
            }else{
                $("#telefono").removeClass('is-invalid');
            }
            if ($("#observaciones").val() == '') {
                $("#observaciones").addClass('is-invalid'); 
            }else{
                $("#observaciones").removeClass('is-invalid');
            }
            if ($("#ciudad").val() == '') {
                $("#ciudad").addClass('is-invalid'); 
            }else{
                $("#ciudad").removeClass('is-invalid');
            }


            if( $("#cedula").val() != '' &&
                $("#imagen").val() != '' &&
                $("#nombres").val() != '' &&
                $("#apellidos").val() != '' && 
                $("#sexo").val() != 0 && 
                $("#fecha_nacimiento").val() != '' && 
                $("#tipo_cuenta").val() != 0 &&
                $("#correo").val() != '' &&
                $("#clave").val() != '' &&
                $("#direccion").val() != '' &&
                $("#correo_personal").val() != '' &&
                $("#telefono").val() != '' &&
                $("#observaciones").val() != '') {

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
                        alertify.notify(
                            'Profesional agregado con éxito',
                            'success', 
                            2
                        );
                        return;
                    }

                    alertify.alert('Ups :(' , r.msg);

                })
                .fail(function(r) {
                    console.log(r);
                    console.log("error");
                });
                

                return false;

            }

            return false;

        });
    });
</script>
