<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="max-age=604800" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Login</title>
<link href="<?php echo base_url('assets/images/logo.jpg') ?>" rel="shortcut icon" type="image/x-icon">
<script src="<?php echo base_url('assets/js/jquery-2.0.0.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/alertifyjs/alertify.min.js') ?>"></script>

<script src="<?php echo base_url('assets/waitMe/waitMe.min.js') ?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/css/bootstrap.css') ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('assets/fonts/fontawesome/css/all.min.css') ?>" type="text/css" rel="stylesheet">
<link href="<?php echo base_url('assets/css/ui.css') ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('assets/css/responsive.css') ?>" rel="stylesheet" media="only screen and (max-width: 1200px)">
<link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/alertify.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/themes/bootstrap.min.css') ?>">
<link href="<?php echo base_url('assets/waitMe/waitMe.min.css') ?>" rel="stylesheet">
</head>
<body>


<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-conten" style="min-height:50vh">

	<nav class="navbar navbar-dark navbar-expand p-0 bg-primary" style="background-color: #324148 !important;">
		<div class="container">
			<ul class="navbar-nav d-none d-md-flex mr-auto">
				<li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>">Inicio</a></li>
			</ul>

			<ul class="navbar-nav">
				
			</ul> 
		</div> 
	</nav>

<!-- ============================ COMPONENT LOGIN   ================================= -->
	<div id="div_login" class="card mx-auto" style="max-width: 380px; margin-top:40px;">
      <div class="card-body">

      	<div class="row mb-3">
      		<div class="col text-center">
      			<a href="<?php echo base_url() ?>" class="brand-wrap">
					<img class="img-fluid" src="<?php echo base_url('assets/images/logo.jpg') ?>" alt="emptyfolder" style="width: 200px; border-radius: 12px;">
				</a> 
      			
      		</div>
      	</div>

      <form id="form-login" action="">
          <div class="form-group">
			 <input name="email" id="email" class="form-control" placeholder="E-mail" type="text">
			 <div class="invalid-feedback">El campo no debe quedar vacío</div>
          </div> 
          <div class="form-group">
			<input name="clave" id="password" class="form-control" placeholder="Password" type="password">
			 <div class="invalid-feedback">El campo no debe quedar vacío</div>
          </div> 
          
          <div class="form-group">
              <button type="submit" id="btn_login" class="btn btn-primary btn-block btn_login" style="background-color: rgba(50,65,72,0.9) !important;"> Ingresar  </button>
          </div> 
		  <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block btn_login" style="background-color: rgba(50,65,72,0.9) !important;"> Olvido su Contraseña?  </button>
          </div> 
      </form>
      </div> 
    </div> 

<!-- ============================ COMPONENT LOGIN  END.// ================================= -->
</section>
<script>
	
	$(document).ready(function() {
		$('.btn_login').on('click' , function(e){
			e.preventDefault();

			
			var email = $('input[name="email"]').val(),
				clave = $('input[name="clave"]').val();

				if(email == '') {
					$('input[name="email"]').addClass('is-invalid');
				} 
				else {
					$('input[name="email"]').removeClass('is-invalid');
				}

				if(clave == '') {
					$('input[name="clave"]').addClass('is-invalid');
				} 
				else {
					$('input[name="clave"]').removeClass('is-invalid');
				}


				if(email != '' && clave != '') {
					$.ajax({
						url: '<?php echo base_url('Login/loguear') ?>',
						type: 'POST',
						dataType: 'json',
						data: {email: email, clave: clave},
					})
					.done(function(r) {
						if(r.status){
							$('#div_login').waitMe({
								effect   : 'rotateplane',
								waitTime : 1800,
								onClose  : function(){
									window.location.href = 'Home';
								}
							});
							return;
						}

						$('#div_login').waitMe({
							effect   : 'rotateplane',
							waitTime : 1200,
							onClose  : function(){
								alertify.alert('Ups :(' , r.msg);
							}
						});
					})
					.fail(function(r) {
						console.log("error");
						console.log(r);
					});
					

					return false;
				}

		});
	});

</script>
</body>
</html>
