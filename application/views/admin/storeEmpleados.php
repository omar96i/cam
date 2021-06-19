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
                <a href="<?= base_url('admin/Home/empleados') ?>" class="btn btn-info float-right">Retroceder</a>
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
                                        <h2 class="d-inline">Editar Empleado</h2>
                                    </div>
                                </div>

                                <form action="" id="form_editusuary">
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="id_persona_u" class="col-form-label">id persona:</label>
                                                <input type="text" id="id_persona_u" class="form-control"  name="id_persona_u" value="<?php echo $usuarios->id_persona ?>" readonly>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="imagen" class="col-form-label">Foto:</label>
                                                <input type="file" id="imagen" class="form-control" name="imagen">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="documento_u" class="col-form-label">Cedula:</label>
                                                <input type="text" id="documento_u" class="form-control" name="documento_u" value="<?php echo $usuarios->documento ?>">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nombre_u" class="col-form-label">Nombres:</label>
                                                <input type="text" id="nombre_u" class="form-control" name="nombre_u" value="<?php echo $usuarios->nombres ?>">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="apellidos_u" class="col-form-label">Apellidos:</label>
                                                <input type="text" id="apellidos_u" class="form-control" name="apellidos_u" value="<?php echo $usuarios->apellidos ?>">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ciudad_u" class="col-form-label">Ciudad:</label>
                                                <input type="text" id="ciudad_u" class="form-control" name="ciudad_u" value="<?php echo $usuarios->ciudad ?>">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="direccion_u" class="col-form-label">Direccion:</label>
                                                <input type="text" name="direccion_u" id="direccion_u" class="form-control" value="<?php echo $usuarios->direccion ?>" cols="10" rows="3" ></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="correo_personal_u" class="col-form-label">Correo personal:</label>
                                                <input type="text" name="correo_personal_u" id="correo_personal_u" class="form-control" cols="10" value="<?php echo $usuarios->correo_personal ?>" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="sexo_u" class="col-form-label">Sexo:</label>
                                                <select name="sexo_u" class="form-control" id="sexo_u">
                                                    <option value="masculino" <?php echo ($usuarios->sexo == 'masculino')?'selected':''; ?> >masculino</option>
                                                    <option value="femenino" <?php echo ($usuarios->sexo == 'femenino')?'selected':''; ?>>femenino</option>
                                                </select>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="fecha_u" class="col-form-label">Fecha nacimiento:</label>
                                                <input type="date" id="fecha_u" class="form-control" name="fecha_u" value="<?php echo $usuarios->fecha_nacimiento ?>">
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono_u" class="col-form-label">Telefono:</label>
                                                <input type="text" name="telefono_u" id="telefono_u" value="<?php echo $usuarios->telefono ?>" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="observaciones_u" class="col-form-label">Observaciones:</label>
                                                <input type="text" name="observaciones_u" id="observaciones_u" value="<?php echo $usuarios->observaciones ?>" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            

                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="cuenta_tipo_u" class="col-form-label">Tipo cuenta:</label>
                                                <select name="cuenta_tipo_u" id="cuenta_tipo_u" class="form-control">
                                                    <option value="administrador" <?php if($usuarios->tipo_cuenta == "administrador"){ echo "selected"; } ?> >administrador</option>
                                                    <option value="supervisor" <?php if($usuarios->tipo_cuenta == "supervisor"){ echo "selected"; } ?>>supervisor</option>
                                                    <option value="empleado" <?php if($usuarios->tipo_cuenta == "empleado"){ echo "selected"; } ?>>empleado</option>
                                                    <option value="talento humano">talento humano</option>
                                                </select>
                                                <div class="invalid-feedback" <?php if($usuarios->tipo_cuenta == "talento humano"){ echo "selected"; } ?>>El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="num_cuenta_banco_u" class="col-form-label">Numero de cuenta Banco:</label>
                                                <input type="text" name="num_cuenta_banco_u" value="<?php echo $usuarios->numero_cuenta_banco ?>" id="num_cuenta_banco_u" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tipo_cuenta_banco_u" class="col-form-label">Tipo de cuenta Banco:</label>
                                                <input type="text" name="tipo_cuenta_banco_u" value="<?php echo $usuarios->tipo_cuenta_banco ?>"  id="tipo_cuenta_banco_u" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name_banco_u" class="col-form-label">Nombre del Banco:</label>
                                                <input type="text" name="name_banco_u" id="name_banco_u" value="<?php echo $usuarios->nombre_banco ?>" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="correo_u" class="col-form-label">Correo:</label>
                                                <input type="email" name="correo_u" id="correo_u" class="form-control" value="<?php echo $usuarios->correo ?>" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="clave_u" class="col-form-label">Contraseña:</label>
                                                <input type="text" name="clave_u" id="clave_u" value="<?php echo $usuarios->clave ?>" class="form-control" cols="10" rows="3"></input>
                                                <div class="invalid-feedback">El campo no debe quedar vacío</div>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mt-2">
                                                <button class="btn btn-success btn-block btn_editusuary" data-id_usuario="<?php echo $usuarios->id_persona ?>">Editar</button>
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
    

        ruta         = "<?php echo base_url('admin/home/storeempleado') ?>"
        id_usuario = $(this).data('id_usuario');
        var form_data = new FormData($('#form_editusuary')[0]);

        if($('input[name="nombre_u"]').val() == '') {
            $('input[name="nombre_u"]').addClass('is-invalid');
        }
        else {
            $('input[name="nombre_u"]').removeClass('is-invalid');
        }
        if($('input[name="documento_u"]').val() == '') {
            $('input[name="documento_u"]').addClass('is-invalid');
        }
        else {
            $('input[name="documento_u"]').removeClass('is-invalid');
        }
        if($('input[name="fecha_u"]').val() == '') {
            $('input[name="fecha_u"]').addClass('is-invalid');
        }
        else {
            $('input[name="fecha_u"]').removeClass('is-invalid');
        }
        if($('input[name="sexo_u"]').val() == '') {
            $('input[name="sexo_u"]').addClass('is-invalid');
        }
        else {
            $('input[name="sexo_u"]').removeClass('is-invalid');
        }
        if($('input[name="ciudad_u"]').val() == '') {
            $('input[name="ciudad_u"]').addClass('is-invalid');
        }
        else {
            $('input[name="ciudad_u"]').removeClass('is-invalid');
        }
        if($('input[name="correo_u"]').val() == '') {
            $('input[name="correo_u"]').addClass('is-invalid');
        }
        else {
            $('input[name="correo_u"]').removeClass('is-invalid');
        }
        if($('input[name="apellidos_u"]').val() == '') {
            $('input[name="apellidos_u"]').addClass('is-invalid');
        }
        else {
            $('input[name="apellidos_u"]').removeClass('is-invalid');
        }
        if($('input[name="cuenta_tipo_u"]').val() == '') {
            $('input[name="cuenta_tipo_u"]').addClass('is-invalid');
        }
        else {
            $('input[name="cuenta_tipo_u"]').removeClass('is-invalid');
        }

                   
        if( $('input[name="nombre_u"]').val() != '' &&
			$('input[name="fecha_u"]').val() != '' &&
			$('input[name="sexo_u"]').val() != '' &&
			$('input[name="ciudad_u"]').val() != '' &&
			$('input[name="correo_u"]').val() != '' &&
            $('input[name="documento_u"]').val() != '' &&
            $('input[name="apellidos_u"]').val() != '' &&
			$('input[name="cuenta_tipo_u"]').val() != ''
        ){      
            
            
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
                    alertify.notify('Registro actualizado', 'success', 2, function(){
                        window.location.href = '../empleados';
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
</script>