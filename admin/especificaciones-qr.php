<?php
include( "includes/config.php" );
include("class/allClass.php");
$codigo = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

use nsalmacen\almacen;
use nsfunciones\funciones;

$fn = new funciones();
$almacen = new almacen();


$info 			= $almacen -> obtener_material($codigo);
$fotos          = $almacen -> obtener_fotos_prestamo('upload/materiales/'.$codigo);
if($fotos == "no existe"){
    $cont = 0;
}else{
    $cont = count($fotos['archivo']);
}
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
	<link rel="stylesheet" type="text/css" href="plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
	<!-- blueimp Gallery styles -->
	<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <link href="plugins/jQuery-File-Upload-9.12.1/css/jquery.fileupload.css" rel="stylesheet" >
	<link href="plugins/jQuery-File-Upload-9.12.1/css/jquery.fileupload-ui.css" rel="stylesheet" >
	<!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link href="plugins/jQuery-File-Upload-9.12.1/css/jquery.fileupload-noscript.css" rel="stylesheet" ></noscript>
    <noscript><link href="plugins/jQuery-File-Upload-9.12.1/css/jquery.fileupload-ui-noscript.css" rel="stylesheet" ></noscript>
</head>

<body class="hold-transition">

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
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h2 class="text-center">Información del codigo QR</h2>
                        </div>
                        <div class="panel-body">
                            <h1 class="text-center"><?php echo $info['nombre'][0] ?></h1>
                            <hr />
                            <div class="panel-heading">
                                <div class="profile-avatar-container">
                                    <div  id="crop-avatar" class="profile-avatar">
                                        <!-- Current avatar -->
                                        <div class="demo-gallery">
											<div class="container-fluid">
												<div class="row text-center justify-content-center nopadding">
													<div class="row text-center justify-content-center nopadding">
														<?php for($i = 0; $i < $cont; $i++){ ?>
														<div class="col-md-2 col-12 text-start mbottom10 bg-naranja nopadding">
															<a data-fancybox="gallery" data-src="" data-caption="" >
																<img src="<?php echo $fotos["archivo"][$i]; ?>" class="img-fluid zoom" alt="" title="" width="300" height="300"/>
															</a>
														</div>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>		
                                        <br>
                                        <!-- Loading state -->
                                        <div class="loading" aria-label="Cargando..." role="img" tabindex="-1"></div>
                                    </div>
                            </div>
                            <div class="row panel-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
											<th scope="col">ID Material</th>
											<th scope="col">Nombre</th>
											<th scope="col">Descripcion</th>
											<th scope="col">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row"><?php echo $info['id'][0]; ?></th>
                                            <td><?php echo $info['nombre'][0]; ?></td>
                                            <td><?php echo $info['descripcion'][0]; ?></td>
                                            <td><?php echo $info['cantidad'][0]; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php if($_SESSION['nivel'] == 1){ ?>
                            <div class="row panel-body">
                                <div class="col-sm-6">
                                    <h3 class="text-center">Historial de prestamos</h3>
                                    <div class="panel-body">
                                        <div class="left full relative paddingtop15" id="content">
                                            <table class="table table-success table-striped" id="tabla1">
                                                <thead>
                                                    <tr>
                                                        <th> # </th>
                                                        <th> Solicitante </th>
                                                        <th> Fecha de solicitud </th>
                                                        <th> Hora de solicitud </th>
                                                        <th> Clave de solicitud </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php for($i = 0,$a=0; $i < $csolicitudes; $i++){ $a = $a+1; ?>
                                                    <tr onclick="universalLoad(this)" data-postload="0" data-returnpage="pr-inicio" data-form="" data-page="salida-prestamo-edit" data-carpeta="ajax-edit" data-load="contenedor" data-valores="" data-id="<?php echo $solicitudes['clave_solicitud'][$i]; ?>">
                                                        <td class="btn-info"><?php echo $a; ?></td>
                                                        <td class="btn-info"><?php echo $solicitudes['nombre'][$i]; ?></td>
                                                        <td class="btn-info"><?php echo $solicitudes['fecha'][$i]; ?></td>
                                                        <td class="btn-info"><?php echo $solicitudes['hora'][$i]; ?></td>
                                                        <td class="btn-info"><?php echo $solicitudes['clave_solicitud'][$i]; ?></td>
                                                    </tr>
                                                <?php } ?>    
                                                </tbody>    
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h3 class="text-center">Listado de materiales por agotarse o agotados</h3>
                                    <div class="panel-body">
                                        <div class="left full fondoblanco relative paddingtop15" id="content">
                                            <table class="table table-success table-striped" id="tabla2">
                                                <thead>
                                                    <tr>
                                                        <th> # </th>
                                                        <th> Producto/Material </th>
                                                        <th> Cantidad </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php for($i = 0,$a=0; $i < $cstock; $i++){ $a = $a+1; ?>
                                                    <tr>
                                                        <td class="btn-danger"><?php echo $a; ?></td>
                                                        <td class="btn-danger"><?php echo $stock['nombre'][$i]; ?></td>
                                                        <td class="btn-danger"><?php echo $stock['cantidad'][$i]; ?></td>
                                                    </tr>
                                                <?php } ?>    
                                                </tbody>    
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
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
		<!-- The template to display files available for upload -->
		<script src="plugins/jQuery-File-Upload-9.12.1/js/vendor/jquery.ui.widget.js"></script>
		<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
		<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
		<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
		<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
		<script src="plugins/jQuery-File-Upload-9.12.1/js/jquery.iframe-transport.js"></script>
		<script src="plugins/jQuery-File-Upload-9.12.1/js/jquery.fileupload.js"></script>
		<script src="plugins/jQuery-File-Upload-9.12.1/js/jquery.fileupload-process.js"></script>
		<script src="plugins/jQuery-File-Upload-9.12.1/js/jquery.fileupload-image.js"></script>
		<script src="plugins/jQuery-File-Upload-9.12.1/js/jquery.fileupload-audio.js"></script>
		<script src="plugins/jQuery-File-Upload-9.12.1/js/jquery.fileupload-video.js"></script>
		<script src="plugins/jQuery-File-Upload-9.12.1/js/jquery.fileupload-validate.js"></script>
		<script src="plugins/jQuery-File-Upload-9.12.1/js/jquery.fileupload-ui.js"></script>
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