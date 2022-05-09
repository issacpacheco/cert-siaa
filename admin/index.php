<?php
include( "includes/config.php" );
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<title>Panel de administración | SIA</title>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link rel="shortcut icon" href="images/favicon.png"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300" rel="stylesheet" type="text/css"/>
    
    <!-- Styling -->
    <link rel="stylesheet" href="addons/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.0/css/all.css">
    <link rel="stylesheet" href="styles/style.css"/>
	<link rel="stylesheet" href="styles/<?php echo $theme;?>" class="theme" />
    <!-- End of Styling -->
	<link rel="stylesheet" href="scripts/dropzone-5.7.0/dist/dropzone.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.css"/>
	<!-- DataTables CSS -->
	<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css" rel="stylesheet">
	<!-- Select2 -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<!----Charts---->
	<script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/item-series.js"></script>
	<!--ihover-->
	<link rel="stylesheet" href="plugins/ihover/ihover.css">
	<!-- Cropper-->
	<link href="plugins/cropper-master/dist/cropper.min.css" rel="stylesheet">
	<link href="css/crop_avatar.css?v=<?php echo rand();?>" rel="stylesheet">
</head>

<body class="hold-transition"  onload="nobackbutton();">

	<!-- Header -->
	<?php include("includes/header.php");?>
	<!-- End of Header -->

	<!-- Navigation -->
	<?php include("includes/menu.php");?>
	<!-- End of Navigation -->

	<!-- Scroll up button -->
	<a class="scroll-up"><i class="fas fa-chevron-up"></i></a>
	<!-- End of scroll up button -->

	<!-- Main content-->
	<div class="content">
		<div class="container-fluid" id="contenedor">
            <?php include("ajax-show/pr-inicio.php"); ?>
        </div>
		
		<!-- Footer -->
		<?php include("includes/footer.php");?>
		<!-- End of Footer -->
	</div>
	<!-- End of Main content-->
	<div class="alertas cajaAlertaRoja">
		<span class="fas fa-exclamation-triangle iconoalertas"></span>
		<p>
			Este es un mensaje de alerta para notificar a los usuarios que necesiten algo.
		</p>
	</div>
	<div class="alertas cajaAlertaVerde">
		<span class="fas fa-exclamation-triangle iconoalertas"></span>
		<p>
			Se ha guardado con exito
		</p>
	</div> 

	<div id="portapopups" class="oscuro oculto">
		<div id="popup" style="z-index:1000;"></div>
	</div>

	<div class="scripts">
        <!-- Addons -->
        <script src="addons/jquery/jquery.min.js"></script>
        <script src="addons/jquery-ui/jquery-ui.min.js"></script>
        <script src="addons/bootstrap/js/bootstrap.min.js"></script>
		<script src="addons/fullcalendar/lib/moment.min.js"></script>
        <script src="addons/pacejs/pace.min.js"></script>
        <!-- scripts -->
        <script src="addons/scripts.js"></script>
		<!-- Funciones -->
		<script src="js/generales.js"></script>
		<script src="js/loads.js"></script>
		<script src="js/funciones.js"></script>
		<!--Select2-->
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<!-- InputMask -->
		<script src="plugins/input-mask/jquery.inputmask.js"></script>
		<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
		<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
		<!-- DataTables JS -->
		<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>    
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.js"></script>
		<!-- Current page scripts -->
        <div class="current-scripts">

        </div>

    </div>
	<script>
		$(document).ready(function(){	
			$('#tabla1').DataTable( {
				"language": { url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},
				"ordering": true,
				"paging": true,
				"searching": true,
				"info": true,
				"fixedHeader": true,
				"autoFill": false,
				"colReorder": false,
				"fixedColumns": false,
				"responsive": true,
				"dom": 'Bfrtip',
				"pageLength": 5,
				"order": [[ 2, "desc" ]],
				"buttons": [
					// {
					// 	extend: 'excel',
					// 	exportOptions: {
					// 		columns: [0,1,2,3,4]
					// 	},
					// 	text: 'Excel <i class="fal fa-file-excel"></i>',
					// 	messageTop: '',
					// 	footer: true
					// },
					// {
					// 	extend: 'pdfHtml5',
					// 	orientation: 'landscape',
					// 	exportOptions: {
					// 		columns: [0,1,2,3,4]
					// 	},
					// 	text: 'PDF <i class="fal fa-file-pdf"></i>',
					// 	messageTop: 'LISTA DE alumnos REGISTRADOS',
					// 	footer: true
					// },
					// {
					// 	extend: 'print',
					// 	exportOptions: {
					// 		columns: [0,1,2,3,4]
					// 	},
					// 	text: 'Imprimir <i class="fal fa-print"></i>',
					// 	messageTop: '',
					// 	footer: true
					// },
				]
			} );
			$('#tabla2').DataTable( {
				"language": { url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},
				"ordering": true,
				"paging": true,
				"searching": true,
				"info": true,
				"fixedHeader": true,
				"autoFill": false,
				"colReorder": false,
				"fixedColumns": false,
				"responsive": true,
				"dom": 'Bfrtip',
				"pageLength": 5,
				"order": [[ 2, "desc" ]],
				"buttons": [
					// {
					// 	extend: 'excel',
					// 	exportOptions: {
					// 		columns: [0,1,2,3,4]
					// 	},
					// 	text: 'Excel <i class="fal fa-file-excel"></i>',
					// 	messageTop: '',
					// 	footer: true
					// },
					// {
					// 	extend: 'pdfHtml5',
					// 	orientation: 'landscape',
					// 	exportOptions: {
					// 		columns: [0,1,2,3,4]
					// 	},
					// 	text: 'PDF <i class="fal fa-file-pdf"></i>',
					// 	messageTop: 'LISTA DE alumnos REGISTRADOS',
					// 	footer: true
					// },
					// {
					// 	extend: 'print',
					// 	exportOptions: {
					// 		columns: [0,1,2,3,4]
					// 	},
					// 	text: 'Imprimir <i class="fal fa-print"></i>',
					// 	messageTop: '',
					// 	footer: true
					// },
				]
			} );
			$('#tabla3').DataTable( {
				"language": { url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},
				"ordering": true,
				"paging": true,
				"searching": true,
				"info": true,
				"fixedHeader": true,
				"autoFill": false,
				"colReorder": false,
				"fixedColumns": false,
				"responsive": true,
				"dom": 'Bfrtip',
				"pageLength": 5,
				"order": [[ 2, "desc" ]],
				"buttons": [
					// {
					// 	extend: 'excel',
					// 	exportOptions: {
					// 		columns: [0,1,2,3,4]
					// 	},
					// 	text: 'Excel <i class="fal fa-file-excel"></i>',
					// 	messageTop: '',
					// 	footer: true
					// },
					// {
					// 	extend: 'pdfHtml5',
					// 	orientation: 'landscape',
					// 	exportOptions: {
					// 		columns: [0,1,2,3,4]
					// 	},
					// 	text: 'PDF <i class="fal fa-file-pdf"></i>',
					// 	messageTop: 'LISTA DE alumnos REGISTRADOS',
					// 	footer: true
					// },
					// {
					// 	extend: 'print',
					// 	exportOptions: {
					// 		columns: [0,1,2,3,4]
					// 	},
					// 	text: 'Imprimir <i class="fal fa-print"></i>',
					// 	messageTop: '',
					// 	footer: true
					// },
				]
			} );
			$('#tabla4').DataTable( {
				"language": { url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},
				"ordering": true,
				"paging": true,
				"searching": true,
				"info": true,
				"fixedHeader": true,
				"autoFill": false,
				"colReorder": false,
				"fixedColumns": false,
				"responsive": true,
				"dom": 'Bfrtip',
				"pageLength": 5,
				"order": [[ 2, "desc" ]],
				"buttons": [
					// {
					// 	extend: 'excel',
					// 	exportOptions: {
					// 		columns: [0,1,2,3,4]
					// 	},
					// 	text: 'Excel <i class="fal fa-file-excel"></i>',
					// 	messageTop: '',
					// 	footer: true
					// },
					// {
					// 	extend: 'pdfHtml5',
					// 	orientation: 'landscape',
					// 	exportOptions: {
					// 		columns: [0,1,2,3,4]
					// 	},
					// 	text: 'PDF <i class="fal fa-file-pdf"></i>',
					// 	messageTop: 'LISTA DE alumnos REGISTRADOS',
					// 	footer: true
					// },
					// {
					// 	extend: 'print',
					// 	exportOptions: {
					// 		columns: [0,1,2,3,4]
					// 	},
					// 	text: 'Imprimir <i class="fal fa-print"></i>',
					// 	messageTop: '',
					// 	footer: true
					// },
				]
			} );
		});
		function generarreporte(clave){
			window.location.href = "../admin/upload/pdf/reportes-transferencia.php?clave="+clave;
		}
		function validarviaje(clave){
			$.ajax({
				type: 'post',
				url: 'ajax-save/validar-viaje',
				data: {clave: clave},
				success: function(response){
					$('#validacion').css({ display: "none" })
				}
			})
		}
	</script>
</body>

</html>