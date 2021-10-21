<?php
	header("Cache-Control: no-cache, must-revalidate");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv='cache-control' content='no-cache'>
	<meta http-equiv='expires' content='0'>
	<meta http-equiv='pragma' content='no-cache'>
	<title>Admin</title>
	<link href="<?php echo base_url('assets/images/favicon.png') ?>" rel="shortcut icon" type="image/x-icon">
	<!-- Global stylesheets -->

	<link rel="stylesheet" href="<?php echo base_url('assets/admin/css/css.css') ?>">
	<link href="<?php echo base_url('assets/admin/global_assets/css/icons/icomoon/styles.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/admin/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/admin/css/bootstrap_limitless.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/admin/css/layout.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/admin/css/components.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/admin/css/colors.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/admin/css/colors.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/datatables.min.css') ?>" rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/alertify.min.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/themes/bootstrap.min.css') ?>">
	<link href="<?php echo base_url('assets/waitMe/waitMe.min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/glDatePicker/styles/glDatePicker.default.css') ?>" rel="stylesheet">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
	<script src="<?php echo base_url('assets/admin/global_assets/js/main/jquery.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/admin/global_assets/js/main/bootstrap.bundle.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/admin/global_assets/js/main/bootstrap.bundle.min.js') ?>"></script>

	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="<?php echo base_url('assets/admin/js/app.js') ?>"></script>
	<script src="<?php echo base_url('assets/alertifyjs/alertify.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/waitMe/waitMe.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/glDatePicker/glDatePicker.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/datatables.min.js') ?>" type="text/javascript"></script>



	<!-- /theme JS files -->
</head>
<body>
	<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-dark">
		<div class="navbar-brand">
			 <a href="<?php echo base_url() ?>" class="d-inline-block">
				<img src="<?php echo base_url('assets/images/logo.jpg') ?>" style="width: 40px; height: 35px;" alt="logotipo">
			</a>
		</div>

		<div class="d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
			
			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="navbar-mobile">
		
			<ul class="navbar-nav">

				<li class="nav-item">
					<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>
			</ul>

			<span class="navbar-text ml-md-3 mr-md-auto">
				
			</span>

			

			<ul class="navbar-nav">
				<?php if ($this->session->userdata('usuario')["tipo"]=='empleado') {?>
					<li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown" href="#">
							<img width="20" src="<?php echo base_url('assets/iconos_menu/bombilla.png') ?>" alt="">
							<span class="badge badge-warning navbar-badge" style="padding: 1px 2px 1px 2px; vertical-align: super;">
								<?php echo ($cant_notificaciones=="vacio") ? "0" : count($cant_notificaciones); ?>
							</span>
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
							<div class="caja_notificaciones" style="height:150px; overflow-y: scroll;">
								<?php if ($notificaciones != "vacio") {
									foreach ($notificaciones as $i => $valor){?>
										<div class="container">
											<a  href="<?php echo base_url('empleado/Notificaciones/verNotificacion/').$valor->id_citas; ?>" class="text-dark">
												<h4 class="m-0"><?php echo ($valor->estado == "pendiente")?"Cita Programada":"Cita Finalizada"; ?></h4>
												<strong><?php echo $valor->fecha; ?> / </strong><strong><?php echo $valor->hora; ?></strong>
											</a>
										</div>
									
										<div class="dropdown-divider">
										</div>
									<?php } 
								}else{ ?>
									<div class="container">
										<p>Sin notificaciones</p>
									</div>
								<?php } ?>
							</div>
						</div>
					</li>
				<?php } ?>
				
				<li class="nav-item dropdown dropdown-user">
					<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">

						<span class="text-capitalize">
							<?php echo $_SESSION['usuario']['nombre'] ?>
						</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a href="<?php echo base_url('Pdf/getInfPdf/').$this->session->userdata('usuario')["id_usuario"] ?>" class="dropdown-item">
							<i class=""></i>Generar carta laboral
						</a>
						<a href="<?php echo base_url('admin/Home/logout') ?>" class="dropdown-item btn_logout">
							<i class="icon-switch2"></i>Cerrar sesión
						</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">
			<!-- Sidebar mobile toggler -->
			<div class="sidebar-mobile-toggler text-center">
				<a href="#" class="sidebar-mobile-main-toggle">
					<i class="icon-arrow-left8"></i>
				</a>
				Navigation
				<a href="#" class="sidebar-mobile-expand">
					<i class="icon-screen-full"></i>
					<i class="icon-screen-normal"></i>
				</a>
			</div>
			<!-- /sidebar mobile toggler -->

			<!-- Sidebar content -->
			<div class="sidebar-content">
				<!-- User menu -->
				<div class="sidebar-user">
					<div class="card-body">
						<div class="media">
							<div class="mr-3 mt-2">
								<a href="<?= $this->session->userdata('usuario')['tipo']=='administrador'?base_url():'#' ?>">
									<?php if ($this->session->userdata('usuario')["tipo"]=='empleado'): ?>
										<img id="imagen_perfil" src="<?php echo base_url('assets/images/imagenes_empleado/').$_SESSION['usuario']['foto']; ?>" width="38" height="38" class="rounded-circle" alt="">
									<?php endif ?>
									<?php if ($this->session->userdata('usuario')["tipo"]!='empleado'): ?>
										<img src="<?php echo base_url('assets/images/imagenes_usuario/').$_SESSION['usuario']['foto']; ?>" width="38" height="38" class="rounded-circle" alt="">
									<?php endif ?>
									
								</a>
							</div>

							<div class="media-body">
							<img >
								<div class="media-title font-weight-semibold">
									<?= $this->session->userdata('usuario')['tipo']=='administrador' ? 'Admin | Gz Studios': 'Gz Studios' ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /user menu -->

				<!-- Main navigation -->
				<div class="card card-sidebar-mobile">
					<ul class="nav nav-sidebar" data-nav-type="accordion">
						<!-- Main -->
						<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">
							Opciones
						</div> <i class="icon-menu" title="Main"></i></li>

						<?php if ($this->session->userdata('usuario')["tipo"]=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano'){ ?>
							<li class="nav-item">
								<a href="<?php echo base_url() ?>" class="nav-link">
									<img src="<?php echo base_url('assets/iconos_menu/casa.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> 
									<span>
										Inicio
									</span>
								</a>
							</li>
							<?php if ($this->session->userdata('usuario')["tipo"]=='administrador') { ?>
							<li class="nav-item">
								<a href="<?php echo base_url('admin/Home/usuarios') ?>" class="nav-link"><img src="<?php echo base_url('assets/iconos_menu/user-protection.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;">  <span>Crear Usuario</span></a>
							</li>
							<li class="nav-item">
								<a href="<?php echo base_url('admin/Home/empleados') ?>" class="nav-link"><img src="<?php echo base_url('assets/iconos_menu/mujer.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;">  <span>Crear Modelos</span></a>
							</li>
							<li class="nav-item">
								<a href="<?php echo base_url('admin/Home/paginas') ?>" class="nav-link"><img src="<?php echo base_url('assets/iconos_menu/buscador-web_blanco.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;">  <span>Crear Paginas</span></a>
							</li>
							<?php } ?>
							<li class="nav-item nav-item-submenu">
								<a href="#" class="nav-link"><img src="<?php echo base_url('assets/iconos_menu/engranaje_white.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;">  <span>Configuracion</span></a>
								<ul class="nav nav-group-sub" data-submenu-title="Configuracion">
									<li class="nav-item">
										<li class="nav-item nav-item-submenu">
											<a href="#" class="nav-link"><span>Metas</span></a>
											<ul class="nav nav-group-sub" data-submenu-title="Configuracion">
												<li class="nav-item">
													<a href="<?php echo base_url('admin/Home/metas') ?>" class="nav-link">Modelos</a>
												</li>
												<li class="nav-item">
													<a href="<?php echo base_url('admin/Home/metasSupervisor') ?>" class="nav-link">Monitor</a>
												</li>
												<li class="nav-item">
													<a href="<?php echo base_url('admin/MetasSupervisor') ?>" class="nav-link">Supervisor</a>
												</li>
												<li class="nav-item">
													<a href="<?php echo base_url('admin/DefaultMetas') ?>" class="nav-link">Metas por defecto</a>
												</li>
											</ul>
										</li>
									</li>
									<li class="nav-item">
										<li class="nav-item nav-item-submenu">
											<a href="#" class="nav-link"><span>Nomina</span></a>
											<ul class="nav nav-group-sub" data-submenu-title="Configuracion">
												<li class="nav-item">
													<a href="<?php echo base_url('admin/Home/nomina') ?>" class="nav-link">Modelos</a>
												</li>
												<li class="nav-item">
													<a href="<?php echo base_url('admin/Home/factura_supervisor') ?>" class="nav-link">Monitor</a>
												</li>
												<li class="nav-item">
													<a href="<?php echo base_url('admin/FacturaMonitor') ?>" class="nav-link">Supervisor</a>
												</li>
												<li class="nav-item">
													<a href="<?php echo base_url('admin/Home/factura_general') ?>" class="nav-link">General</a>
												</li>
											</ul>
										</li>
									</li>
									
									
									
									<?php if ($this->session->userdata('usuario')["tipo"]=='administrador') { ?>
									<li class="nav-item">
										<a href="<?php echo base_url('admin/Home/asignaciones') ?>" class="nav-link">Asignaciones</a>
									</li>
									<?php } ?>

									<li class="nav-item">
										<a href="<?php echo base_url('admin/Home/adelantos') ?>" class="nav-link">Adelantos</a>
									</li>

									<li class="nav-item">
										<a href="<?php echo base_url('admin/Home/penalizaciones') ?>" class="nav-link">Penalizaciones</a>
									</li>

									<li class="nav-item">
										<a href="<?php echo base_url('admin/Home/asistencias') ?>" class="nav-link">Asistencias</a>
									</li>

									<li class="nav-item">
										<a href="<?php echo base_url('admin/Gastos') ?>" class="nav-link">Gastos / Ingresos</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('admin/Reportes') ?>" class="nav-link">Reportes tecnicos</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('admin/IngresosSoftware') ?>" class="nav-link">Ingresos a la pagina</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('admin/Citas') ?>" class="nav-link">Citas</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('admin/DescuentosDias') ?>" class="nav-link">Descuentos de dias</a>
									</li>
								</ul>
							</li>
							
							<li class="nav-item nav-item-submenu">
								<a href="#" class="nav-link"><img src="<?php echo base_url('assets/iconos_menu/porcentaje.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> <span>Porcentajes</span></a>
								<ul class="nav nav-group-sub" data-submenu-title="Configuracion">
									<li class="nav-item">
										<a href="<?php echo base_url('admin/Home/diasPorcentajes') ?>" class="nav-link">Dias</a>
									</li>
								</ul>
							</li>
							<li class="nav-item nav-item-submenu">
								<a href="#" class="nav-link"><img src="<?php echo base_url('assets/iconos_menu/sueldos.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;">  <span>Registro paga</span></a>
								<ul class="nav nav-group-sub" data-submenu-title="Configuracion">
									<li class="nav-item">
										<a href="<?php echo base_url('admin/Home/salario_empleados') ?>" class="nav-link">Usuarios</a>
									</li>
								</ul>
							</li>

						<?php }
						 else if ($this->session->userdata('usuario')["tipo"]=='administrador' and $this->session->userdata('usuario')["email"]=='wiky@hotmail.com'){ ?>
							<li class="nav-item">
								<a href="<?php echo base_url() ?>" class="nav-link">
									<img src="<?php echo base_url('assets/iconos_menu/casa.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> 
									<span>
										Inicio
									</span>
								</a>
							</li>
							<!--<li class="nav-item">
										<a href="<?php echo base_url('admin/Home/usuarios') ?>" class="nav-link"><img src="<?php echo base_url('assets/iconos_menu/user-protection.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;">  <span>Crear Usuario</span></a>
									</li>-->
									<li class="nav-item">
										<a href="<?php echo base_url('admin/Home/empleados') ?>" class="nav-link"><img src="<?php echo base_url('assets/iconos_menu/mujer.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;">  <span>Crear Modelos</span></a>
									</li>
									
						<?php }else if($this->session->userdata('usuario')["tipo"]=='supervisor'){ ?>
							<li class="nav-item">
								<a href="<?php echo base_url() ?>" class="nav-link">
									<img src="<?php echo base_url('assets/iconos_menu/casa.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> 
									<span>
										Inicio
									</span>
								</a>
							</li>

							<li class="nav-item nav-item-submenu">
								<a href="#" class="nav-link"><img src="<?php echo base_url('assets/iconos_menu/engranaje_white.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;">  <span>Configuracion</span></a>
								<ul class="nav nav-group-sub" data-submenu-title="Configuracion">
									<li class="nav-item">
										<a href="<?php echo base_url('supervisor/Home/empleados') ?>" class="nav-link">Modelos</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('supervisor/Home/asistencia') ?>" class="nav-link">Registrar Asistencia</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('supervisor/VerAsistencia/index') ?>" class="nav-link">Ver Asistencia</a>
									</li>
								</ul>
							</li>
							
						<?php } ?>

						<?php if ($this->session->userdata('usuario')["tipo"]=='talento humano'){ ?>

							<li class="nav-item nav-item-submenu">
								<a href="#" class="nav-link"><img src="<?php echo base_url('assets/iconos_menu/engranaje_white.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> <span>Configuracion talento humano</span></a>
								<ul class="nav nav-group-sub" data-submenu-title="Configuracion">
									<li class="nav-item">
										<a href="<?php echo base_url('talento_humano/Home/usuarios') ?>" class="nav-link">Modelos</a>
									</li>

									<li class="nav-item">
										<a href="<?php echo base_url('talento_humano/Home/facturas') ?>" class="nav-link">Facturas</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('talento_humano/Asistencia') ?>" class="nav-link">Asistencia</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('talento_humano/Gastos') ?>" class="nav-link">Gastos</a>
									</li>
								</ul>
							</li>

						<?php } 
						if ($this->session->userdata('usuario')["tipo"]=='tecnico sistemas'){ ?>
							<li class="nav-item">
								<a href="<?php echo base_url() ?>" class="nav-link">
									<img src="<?php echo base_url('assets/iconos_menu/casa.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> 
									<span>
										Inicio
									</span>
								</a>
							</li>

							<li class="nav-item nav-item-submenu">
								<a href="#" class="nav-link"><img src="<?php echo base_url('assets/iconos_menu/engranaje_white.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> <span>Configuracion</span></a>
								<ul class="nav nav-group-sub" data-submenu-title="Configuracion">
									<li class="nav-item">
										<a href="<?php echo base_url('tecnico_sistemas/Reportes') ?>" class="nav-link">Reportes</a>
									</li>
									<li class="nav-item">
										<li class="nav-item nav-item-submenu">
											<a href="#" class="nav-link"><span>Metas</span></a>
											<ul class="nav nav-group-sub" data-submenu-title="Configuracion">
												<li class="nav-item">
													<a href="<?php echo base_url('admin/Home/metas') ?>" class="nav-link">Modelos</a>
												</li>
												<li class="nav-item">
													<a href="<?php echo base_url('admin/Home/metasSupervisor') ?>" class="nav-link">Monitor</a>
												</li>
												<li class="nav-item">
													<a href="<?php echo base_url('admin/MetasSupervisor') ?>" class="nav-link">Supervisor</a>
												</li>
												
											</ul>
										</li>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('supervisor/Home/asistencia') ?>" class="nav-link">Registrar Asistencia</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('supervisor/VerAsistencia/index') ?>" class="nav-link">Ver Asistencia</a>
									</li>
								</ul>
							</li>

									
						<?php } 
						if ($this->session->userdata('usuario')["tipo"]=='fotografo'){ ?>
							<li class="nav-item">
								<a href="<?php echo base_url() ?>" class="nav-link">
									<img src="<?php echo base_url('assets/iconos_menu/casa.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> 
									<span>
										Inicio
									</span>
								</a>
							</li>

							<li class="nav-item nav-item-submenu">
								<a href="#" class="nav-link"><img src="<?php echo base_url('assets/iconos_menu/engranaje_white.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> <span>Configuracion</span></a>
								<ul class="nav nav-group-sub" data-submenu-title="Configuracion">
									<li class="nav-item">
										<a href="<?php echo base_url('fotografo/Citas') ?>" class="nav-link">Citas</a>
									</li>
								</ul>
							</li>
									
						<?php }
						if ($this->session->userdata('usuario')["tipo"]=='psicologa'){?>
							<li class="nav-item">
								<a href="<?php echo base_url() ?>" class="nav-link">
									<img src="<?php echo base_url('assets/iconos_menu/casa.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> 
									<span>
										Inicio
									</span>
								</a>
							</li>

							<li class="nav-item nav-item-submenu">
								<a href="#" class="nav-link"><img src="<?php echo base_url('assets/iconos_menu/engranaje_white.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> <span>Configuracion</span></a>
								<ul class="nav nav-group-sub" data-submenu-title="Configuracion">
									<li class="nav-item">
										<a href="<?php echo base_url('psicologa/Citas') ?>" class="nav-link">Citas</a>
									</li>
								</ul>
							</li>
						<?php } 
						if ($this->session->userdata('usuario')["tipo"]=='empleado'){ ?>
							<li class="nav-item">
								<a href="<?php echo base_url() ?>" class="nav-link">
									<img src="<?php echo base_url('assets/iconos_menu/casa.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> 
									<span>
										Inicio
									</span>
								</a>
							</li>

							<li class="nav-item nav-item-submenu">
								<a href="#" class="nav-link"><img src="<?php echo base_url('assets/iconos_menu/engranaje_white.png') ?>" alt="" style="width: 20px; height: 20px; margin-right: 5px;"> <span>Configuracion</span></a>
								<ul class="nav nav-group-sub" data-submenu-title="Configuracion">
									<li class="nav-item">
										<a href="<?php echo base_url('empleado/Home/consultarhoras') ?>" class="nav-link">Consultar Horas</a>
									</li>
								</ul>
							</li>
									
						<?php }?>

					</ul>
				</div>
				<!-- /main navigation -->
			</div>
			<!-- /sidebar content -->
		</div>
		<!-- /main sidebar -->
