<!-- Main content -->
<div class="content-wrapper">
	<!-- Content area -->
	<div class="content">
		<!-- Main charts -->
		<div class="row">
			<div class="col-xl-12">
				<!-- Traffic sources -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h1 class="card-title">Solicitar adelanto</h1>
					</div>

					<div class="card-body">
						<form action="" id="form_add_adelanto" enctype="multipart/form-data">
							<div class="row mt-3">
								<div class="col-sm-12 col-md-4">
									<div class="form-group">
										<label for="descripcion" class="col-form-label">Descripcion:</label>
										<textarea name="descripcion" class="form-control" id="descripcion" cols="30" rows="2"></textarea>
										<div class="invalid-feedback">El campo no debe quedar vacío</div>
									</div>
									<div class="form-group">
										<label for="valor" class="col-form-label">Valor:</label>
										<input type="number" id="valor" class="form-control" name="valor">
										<div class="invalid-feedback">El campo no debe quedar vacío</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-4">
									<div class="form-group mt-2">
										<button class="btn btn-success btn-block btn_agregar_adelanto">Aceptar</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- /traffic sources -->
			</div>
			<div class="col-6 aling-items-center">
			
			</div>
		</div>
		<!-- /main charts -->
	</div>
	<div class="imprimir_texto">
	</div>

	<script>
		$(document).ready(function () {
			$(".btn_agregar_adelanto").click(function (e) { 
				e.preventDefault();
				descripcion = $("#descripcion").val();
				valor = $("#valor").val();

				if ($("#descripcion").val() == 0) {
             		$("#descripcion").addClass('is-invalid');
				}else{
					$("#descripcion").removeClass('is-invalid');
				}
				if ($("#valor").val() == '') {
					$("#valor").addClass('is-invalid');
				}else{
					$("#valor").removeClass('is-invalid');
				}

				if(
					$("#descripcion").val() != '' &&
                	$("#valor").val() != ''
				){
					$.ajax({
						url: '<?php echo base_url('empleado/SolicitarAdelanto/AddAdelanto') ?>',
						type: 'POST',
						dataType: 'json',
						data: { descripcion : descripcion, valor : valor},
					})
					.done(function(r) {
						$("#descripcion").val("");
						$("#valor").val("");
						if(r.status){
							
							alertify.notify(
								'Registro agregado con éxito', 
								'success', 
								2
							);
							return;
						}

						alertify.alert('Ups :(' , r.msg);
					})
					.fail(function(r) {
						console.log("error");
						console.log(r);
					});
				}

				return false;
				
			});
		});
	</script>

