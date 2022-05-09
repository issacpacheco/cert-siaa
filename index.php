<!DOCTYPE html>
<html>
<head>
	<title>SISTEMA INTEGRAL DE ADMINISTRACIÓN DE ACTIVOS | Centro Educativo Rodríguez Tamayo</title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="admin/images/favicon.png"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300" rel="stylesheet" type="text/css"/>

	<!-- Styling -->
	<link rel="stylesheet" href="admin/addons/bootstrap/css/bootstrap.css"/>
	<link rel="stylesheet" href="admin/addons/toastr/toastr.min.css"/>
	<link rel="stylesheet" href="admin/addons/fontawesome/css/font-awesome.css"/>
	<link rel="stylesheet" href="admin/addons/ionicons/css/ionicons.css"/>
	<link rel="stylesheet" href="admin/addons/noUiSlider/nouislider.min.css"/>

	<link rel="stylesheet" href="admin/styles/style.css"/>
	<link rel="stylesheet" href="admin/styles/theme-green.css" class="theme"/>
	<!-- End of Styling -->

	<!--Swwetalert-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.0/dist/sweetalert2.min.css">
</head>

<body>
	<!-- Main content-->
	<div class="content" id="login-page">
		<div class="container-fluid">
			<div class="panel" id="login-panel">
				<div class="panel-heading">
					<i class="fa fa-unlock-alt vcentered"></i>
					<div class="vcentered">
						<h3> Bienvenido </h3>
						<h5> Por favor, identifícate:</h5>
					</div>
				</div>
				<div class="panel-body">
					<form class="row" method="post" action="login" id="LoginForm">
						<div class="form-wrapper col-sm-6">
							<label for="Login">Correo</label>
							<div class="form-group">
								<input type="text" class="form-control" name="usuario" placeholder="Correo">
							</div>
						</div>

						<div class="form-wrapper col-sm-6">
							<label for="Password">Contraseña</label>
							<div class="form-group">
								<input type="password" class="form-control" name="password" placeholder="Contraseña">
							</div>
						</div>

						<button type="submit" class="btn btn-lg btn-info btn-block" style="margin-top: 30px" id="boton_enviar_login" onClick="fnvalidar()"><i class="fa fa-sign-in"></i> Entrar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- End of Main content-->

	<div class="scripts">

		<!-- Addons -->
		<script src="admin/addons/jquery/jquery.min.js"></script>
		<script src="admin/addons/jquery-ui/jquery-ui.min.js"></script>
		<script src="admin/addons/bootstrap/js/bootstrap.min.js"></script>
		<script src="admin/addons/toastr/toastr.min.js"></script>

		<!-- scripts -->
		<script src="admin/addons/scripts.js"></script>
		<!-- SwwetAlert -->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
		<!-- FUNCIONES -->
        <script type="text/javascript" src="admin/js/funciones.js"></script> 
	</div>

</body>

</html>