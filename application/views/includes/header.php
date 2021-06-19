<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="max-age=604800">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Psicologia Integral</title>

<link href="<?php echo base_url('assets/images/favicon.png') ?>" rel="shortcut icon" type="image/x-icon">

<script src="<?php echo base_url('assets/js/jquery-2.0.0.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/waitMe/waitMe.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/alertifyjs/alertify.min.js') ?>"></script>
<link href="<?php echo base_url('assets/css/bootstrap.css') ?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('assets/fonts/fontawesome/css/all.min.css') ?>" type="text/css" rel="stylesheet">
<link href="<?php echo base_url('assets/css/ui.css') ?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('assets/css/responsive.css') ?>" rel="stylesheet" media="only screen and (max-width: 1200px)">
<link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/alertify.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/themes/bootstrap.min.css') ?>">
<link href="<?php echo base_url('assets/waitMe/waitMe.min.css') ?>" rel="stylesheet">


</head>
<body>


<header class="section-header">

<nav class="navbar navbar-dark navbar-expand p-0 bg-primary">
<div class="container">
    <ul class="navbar-nav d-none d-md-flex mr-auto">
		<li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>">Inicio</a></li>
		<!--
		<li class="nav-item"><a class="nav-link" href="#">Delivery</a></li>
		<li class="nav-item"><a class="nav-link" href="#">Pago</a></li> 
		-->
    </ul>
    <ul class="navbar-nav">
		<!--
		<li class="nav-item"><a href="#" class="nav-link"> Celular: +51 912345678 </a></li> 
		-->
	</ul> 
  </div> 
</nav>

<section class="header-main border-bottom">
	<div class="container">
<div class="row align-items-center">
	<div class="col-lg-2 col-6">
		<a href="<?php echo base_url() ?>" class="brand-wrap">
		<img class="img-fluid" src="<?php echo base_url('assets/images/logo.jpg') ?>" alt="emptyfolder" style="width: 100px">
			<!--<img class="logo" src="<?php echo base_url('assets/images/logo1.jpg') ?>">-->
		</a> 
	</div>
	<div class="col-lg-6 col-12 col-sm-12">
		
	</div> 

	<div class="col-lg-4 col-sm-6 col-12">
		<div class="widgets-wrap float-md-right">
			<div class="widget-header  mr-3">
				<a href="<?php echo base_url('Carrito') ?>" class="icon icon-sm rounded-circle border"><i class="fa fa-th-large"></i></a>
				<span class="badge badge-pill badge-danger notify notify_cart"><?= count($this->session->userdata('carrito')['agendado']); ?></span>
			</div>
			<div class="widget-header icontext">
				<span class="icon icon-sm rounded-circle border"><i class="fa fa-user-plus"></i></span>
				<div class="text">
					
					<div> 
						<a href="<?= base_url('Registro') ?>" style="color:#b456c4;"><strong>Registro</strong></a>  
					</div>
				</div>
			</div>
			<div class="widget-header icontext">
				<span class="icon icon-sm rounded-circle border"><i class="fa fa-user"></i></span>
				<div class="text">
					
					<div> 
						<a href="<?= base_url('Login') ?>" style="color:#b456c4;"><strong>Iniciar sesión</strong></a>  
					</div>
				</div>
			</div>
		</div>
	</div> 


</div>
	</div> 
</section>
</header>

<nav class="navbar navbar-main navbar-expand-lg navbar-light border-bottom">
  <div class="container">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav" aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="main_nav">
		<ul class="navbar-nav">
			<?php foreach($categorias as $categoria): ?>
			<li class="nav-item">
	          <a class="text-capitalize nav-link <?php echo isset($id_categoria) && $id_categoria == $categoria->id_categoria ? 'disabled' : '' ?>" href="<?php echo base_url('Allproducts/index/' . $categoria->id_categoria) ?>">
	          	<?php echo $categoria->nombre ?>
	          </a>
	        </li>
	    	<?php endforeach; ?>
		
		<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa fa fa-plus-circle"></i> Servicios</a>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="#">Asesorías académicas</a>
      <a class="dropdown-item" href="#">Talleres</a>
      <a class="dropdown-item" href="#">Seminarios</a>
	  <a class="dropdown-item" href="#">Conferencias</a>
	  <a class="dropdown-item" href="#">Procesos de selección</a>
      <a class="dropdown-item" href="#">Aplicación e interpretación de pruebas psicotécnicas</a>
      <a class="dropdown-item" href="#">Evaluación de desempeño y clima organizacional</a>
      <a class="dropdown-item" href="#">Assesment center </a>
    </div>
  </li>
  </ul>
    </div> 
  </div> 
</nav>

