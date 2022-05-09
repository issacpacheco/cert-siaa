<?php
$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$pos = strrpos($url, '/');
$pagina = $pos === false ? $url : substr($url, $pos + 1);

function mb_ucfirst($string, $encoding)
{
    $strlen = mb_strlen($string, $encoding);
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $then = mb_substr($string, 1, $strlen - 1, $encoding);
	$then = mb_strtolower($then, $encoding);
    return mb_strtoupper($firstChar, $encoding) . $then;
}

function Limpiar($str)
{
	$bom = pack('H*','EFBBBF');
	//$bom = pack('CCC', 0xEF, 0xBB, 0xBF);
    $str = preg_replace("/^$bom/", '', $str);
	$str = str_replace("&quot;","'",$str);
	return $str;
}
function CreaLlave()
{
	$length=3;
    $source = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if($length>0)
	{
        $rstr = "";
        $source = str_split($source,1);
        for($i=1; $i<=$length; $i++)
		{
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(1,count($source));
            $rstr .= $source[$num-1];
        }
 
    }
    return $rstr;
}
function CreaFolio()
{
	$length=3;
    $source = '1234567890';
    if($length>0)
	{
        $rstr = "";
        $source = str_split($source,1);
        for($i=1; $i<=$length; $i++)
		{
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(1,count($source));
            $rstr .= $source[$num-1];
        }
 
    }
    return $rstr;
}

function FechaFormato($f)
{
	if ($f != '0000-00-00')
	{
		return substr($f,8,2)."/". substr($f,5,2)."/".substr($f,0,4);
	}
}

function FormatoFechaReportes($f)
{
	$fecha = str_replace('/', '-',$f);

	$DateTime = DateTime::createFromFormat('d-m-Y', $fecha);
	$fecha = $DateTime->format('Y-m-d');

	return $fecha;
}

function Fecha($f)
{
	if ($f != '0000-00-00')
	{
    	$meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return substr($f,8,2)." de ". $meses[intval(substr($f,5,2))-1]." de ".substr($f,0,4);
	}
}
function FechaCorta($f)
{
	if ($f != '0000-00-00')
	{
    	$meses = array("ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic");
		return substr($f,8,2)." ". $meses[intval(substr($f,5,2))-1];
	}
}
function Mes($mes)
{
	$meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
	return $meses[$mes-1];
}
function MesCorto($mes)
{
	$meses = array("ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC");
	return $meses[$mes-1];
}
function Dia($dia)
{
	$dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	return $dias[$dia];
}
function HoraCorta($hora)
{
	return date('h:i a', strtotime($hora));
}

//ARCHIVOS
function BorrarCarpeta($dir) 
{
	$Res = false;
	if ( file_exists($dir) )
	{
		$dh = opendir($dir);
		while ($file=readdir($dh)) 
		{
			if ($file!="." && $file!="..") 
			{
				$fullpath = $dir."/".$file;
				if (!is_dir($fullpath)) 
				{
					unlink($fullpath);
				} 
				else 
				{
					BorrarCarpeta($fullpath);
				}
			}
		}
		closedir($dh);
		if (rmdir($dir)) 
		{
			$Res = true;
		} 
	}
	return $Res;
}
function esArchivo($nombreArchivo, $extensionesPermitidas ) 
{
	$extension = substr(strrchr($nombreArchivo, '.'), 1);
	foreach ($extensionesPermitidas as $extensiones)
	{
		if(!strcasecmp($extension, $extensiones)) 
		{
			return true;
		}
	}
}
function LeerImagenes($path)
{
	$dir = opendir($path);
	while ($elemento = readdir($dir)) 
	{
		if($elemento == '.' || $elemento == '..') {}
		elseif (esArchivo($elemento,array("jpeg", "jpg","png","gif"))) 
		{						
			$elementos[] = $elemento;
		}
	}
	return $elementos;
	closedir($dir); 
}

function LeerVideos($path)
{
	$dir = opendir($path);
	while ($elemento = readdir($dir)) 
	{
		if($elemento == '.' || $elemento == '..') {}
		elseif (esArchivo($elemento,array("mp4"))) 
		{						
			$elementos[] = $elemento;
		}
	}
	return $elementos;
	closedir($dir); 
}

function curPageURL() 
{
	$pageURL = 'http';
 	if ($_SERVER["HTTPS"] == "on") 
	{	
		$pageURL .= "s";
	}
 	$pageURL .= "://";
 	if ($_SERVER["SERVER_PORT"] != "80") 
	{
  		$pageURL .= $_SERVER["SERVER_NAME"];//.":".$_SERVER["SERVER_PORT"];//.$_SERVER["REQUEST_URI"];
 	} 
	else 
	{
  		$pageURL .= $_SERVER["SERVER_NAME"];//.$_SERVER["REQUEST_URI"];
 	}
 return $pageURL;
}

function br2nl ( $string )
{
    return preg_replace('/\<br(\s*)?\/?\>/i', PHP_EOL, $string);
}
function urls_amigables($url) 
{
	// Tranformamos todo a minusculas
	$url = strtolower($url);

	//Rememplazamos caracteres especiales latinos
	$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
	$repl = array('a', 'e', 'i', 'o', 'u', 'n');
	$url = str_replace ($find, $repl, $url);

	// Añaadimos los guiones
	$find = array(' ', '&', '\r\n', '\n', '+'); 
	$url = str_replace ($find, '-', $url);

	// Eliminamos y Reemplazamos demás caracteres especiales

	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);
	return $url;
}

function CalculaEdad( $fecha ) {
    $fecha_nac = new DateTime(date('Y/m/d',strtotime($fecha))); // Creo un objeto DateTime de la fecha ingresada
	$fecha_hoy =  new DateTime(date('Y/m/d',time())); // Creo un objeto DateTime de la fecha de hoy
	$edad = date_diff($fecha_hoy,$fecha_nac); // La funcion ayuda a calcular la diferencia, esto seria un objeto
	return $edad;
}

//Correos
function mandar_correo($correos,$nombres,$asunto,$mensaje,$archivos)
{
	$message = '
	<!doctype html>
		<html>
		<head>
		<meta charset="utf-8">
		<title></title>
		</head>
		<body style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; background-color:#ffffff; margin:0; padding:0; color:#333333;">

		<table width="100%" bgcolor="#112c46" cellpadding="0" cellspacing="0" border="0" id="tabla_principal" style="padding:30px 0">
			<tbody>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0" width="600" border="0" align="center" bgcolor="#ffffff">
							<tbody>					
								<tr>
									<td>
										<table cellpadding="0" cellspacing="0" border="0" width="100%">
											<tbody>
												<tr>
													<td width="100%" align="center" bgcolor="#fff" style="padding:24px; text-align:center">
														<img src="'.$GLOBALS['config_host'].'/assets/images/logos/logo_mail.png">
													</td>	
												</tr>										
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<table cellpadding="0" cellspacing="0" border="0" width="100%">
											<tbody>
												<tr>
													<td width="100%" height="200" style="padding: 20px 5px" align="center">
													'.$mensaje.'
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>	
					</td>
				</tr>
			</tbody>
		</table>
		</body>
		</html>';

		
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->CharSet = 'UTF-8';
	$mail->IsHTML(true);

	$mail->Host = $GLOBALS['config_mail_host'];
	$mail->Port = $GLOBALS['config_mail_port'];
	$mail->Username = $GLOBALS['config_mail_username'];
	$mail->Password = $GLOBALS['config_mail_password'];

	$mail->setFrom( "noreply@cert.edu.mx","Centro Educativo Rodríguez Tamayo"  );
	$mail->Subject = $asunto;
	
	//Correos
	for ($c=0;$c<count($correos);$c++)
	{
		$mail->addAddress($correos[$c], $nombres[$c]);
	}
	
	for ($c=0; $c<count($archivos);$c++)
	{
		$mail->addAttachment($archivos[$c]);
	}
	
	$mail->MsgHTML($message);
	$mail->Send();
		
}


function mandar_correo_prospectos($correo,$nombre,$asunto,$nivel,$oferta,$archivos)
{
	$message = '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>'.$asunto.'</title>
        
    <style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		.mcnPreviewText{
			display:none !important;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit !important;
			text-decoration:none !important;
			font-size:inherit !important;
			font-family:inherit !important;
			font-weight:inherit !important;
			line-height:inherit !important;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage,.mcnRetinaImage{
			vertical-align:bottom;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto !important;
		}
		.mcnDividerBlock{
			table-layout:fixed !important;
		}
	
		body,#bodyTable,#templateFooter{
			background-color:#FAFAFA;
		}
	
		#bodyCell{
			border-top:0;
		}
	
		h1{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:32px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-1px;
			text-align:center;
		}
	
		h2{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:26px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-.75px;
			text-align:left;
		}
	
		h3{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:18px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-.5px;
			text-align:left;
		}
	
		h4{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:16px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}
	
		#templatePreheader{
			background-color:#142b44;
			border-top:0;
			border-bottom:0;
		}
	
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			color:#FAFAFA;
			font-family:Helvetica;
			font-size:10px;
			line-height:125%;
			text-align:left;
		}
	
		.preheaderContainer .mcnTextContent a{
			color:#FAFAFA;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateHeader{
			background-color:#FAFAFA;
			border-top:0;
			border-bottom:0;
		}
	
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:14px;
			line-height:150%;
			text-align:left;
		}
	
		.headerContainer .mcnTextContent a{
			color:#26ABE2;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateBody{
			background-color:#FAFAFA;
			border-top:0;
			border-bottom:0;
		}
	
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:14px;
			line-height:150%;
			text-align:left;
		}
	
		.bodyContainer .mcnTextContent a{
			color:#26ABE2;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateFooter{
			border-top:0;
			border-bottom:0;
		}
	
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:10px;
			line-height:125%;
			text-align:left;
		}
	
		.footerContainer .mcnTextContent a{
			color:#202020;
			font-weight:normal;
			text-decoration:underline;
		}
	@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.templateContainer{
			max-width:600px !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnRetinaImage{
			max-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImage{
			height:auto !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
			max-width:100% !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
			padding:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
			padding-top:0 !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
			padding-top:9px !important;
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
			padding-right:18px !important;
			padding-bottom:0 !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
			display:none !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h1{
			font-size:24px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h2{
			font-size:20px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h3{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h4{
			font-size:16px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		#templatePreheader{
			display:block !important;
		}

}	@media only screen and (max-width: 480px){
	
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			font-size:14px !important;
			line-height:115% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			font-size:14px !important;
			line-height:115% !important;
		}

}</style></head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        <span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">CERT</span>
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell" style="padding-bottom:40px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templatePreheader">
                                        <tr>
                                        	<td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="preheaderContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; font-size: 10px; text-align: center;">
                        
                            Para más información visita <a href="http://cert.edu.mx" target="_blank">CERT.edu.mx</a>
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>                                            
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateHeader">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="headerContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://mcusercontent.com/0c5b9dd31812dd0b9be5bd313/images/c9b17625-6042-07d3-3215-9633f9db6bf9.png" width="604" style="max-width:1200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            &nbsp;
<h1 class="mc-toc-title"><span style="font-size:38px"><span style="font-family:noticia text,georgia,times new roman,serif">¡Hola!<br>'.mb_strtoupper($nombre,'UTF-8').'<br>Gracias por interesarte en la '.$nivel.' en '.$oferta.'.</span></span></h1>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="bodyContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            Estamos emocionados de que puedas formar parte de esta gran familia CERT. Si deseas conocer más sobre nosotros haz click en el siguiente enlace. 
							
							<br><br>
							
							<a title="Familia CERT" href="http://3.15.207.243/ver?token=docs&recurso=PRESENTACION_CERT.pdf" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #000;">Familia CERT</a>
														
							<br><br>
							En la parte de abajo encontrarás un archivo adjunto con la información sobre la licenciatura que deseas estudiar. 
							<br><br>
							Si tienes dudas o deseas más información no dejes de contactarnos.

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
   
	<tbody class="mcnBoxedTextBlockOuter">
        <tr>
            <td valign="top" class="mcnBoxedTextBlockInner">
                
				
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnBoxedTextContentContainer">
                    <tbody><tr>
                        
                        <td style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                        
                            <table border="0" cellspacing="0" class="mcnTextContentContainer" width="100%" style="min-width: 100% !important;background-color: #CACACA;">
                                <tbody><tr>
                                    <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-family: Helvetica;font-size: 14px;font-weight: normal;text-align: center;">
                                        <span style="font-family:merriweather,georgia,times new roman,serif">Teléfono:&nbsp;9991 26 71 06<br>
											Correo: contacto@cert.edu.mx</span>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://mcusercontent.com/0c5b9dd31812dd0b9be5bd313/images/f6bd4703-5376-1d1f-3137-29905c0aabfa.png" width="604" style="max-width:1200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
    <tbody><tr>
        <td align="center" style="padding-left:9px;padding-right:9px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnFollowContent">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td align="center" valign="top">
                                   
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="https://www.facebook.com/CERTMeridaCaucel/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-facebook-48.png" alt="Facebook Oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="cert.edu.mx" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-link-48.png" alt="Página oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                       
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:0; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="https://www.instagram.com/certmeridacaucel/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-instagram-48.png" alt="Instagram Oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                      
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateFooter">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="footerContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px 18px 36px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 1px solid #DDDDDD;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </center>
    <script type="text/javascript"  src="/FUoqn-CQD/perPqAr/QfhfG6N/qmTY/iSicGmLkaD/MmhnbHgB/EX/BCVBwrZGw"></script></body>
</html>';

		
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->CharSet = 'UTF-8';
	$mail->IsHTML(true);

	$mail->Host = $GLOBALS['config_mail_host'];
	$mail->Port = $GLOBALS['config_mail_port'];
	$mail->Username = $GLOBALS['config_mail_username'];
	$mail->Password = $GLOBALS['config_mail_password'];

	$mail->setFrom( "noreply@cert.edu.mx","Centro Educativo Rodríguez Tamayo"  );
	$mail->Subject = $asunto;
	
	//Correos
	$mail->addAddress($correo, $nombre);
	
	for ($c=0; $c<count($archivos);$c++)
	{
		$mail->addAttachment($archivos[$c]);
	}
	
	$mail->MsgHTML($message);
	$mail->Send();
		
}

//Valiación de documentos
function mandar_correo_validacion1($correo,$nombre,$asunto,$archivos)
{
	$message = '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>'.$asunto.'</title>
        
    <style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		.mcnPreviewText{
			display:none !important;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit !important;
			text-decoration:none !important;
			font-size:inherit !important;
			font-family:inherit !important;
			font-weight:inherit !important;
			line-height:inherit !important;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage,.mcnRetinaImage{
			vertical-align:bottom;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto !important;
		}
		.mcnDividerBlock{
			table-layout:fixed !important;
		}
	body,#bodyTable,#templateFooter{
			background-color:#FAFAFA;
		}
	
		#bodyCell{
			border-top:0;
		}
	
		h1{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:32px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-1px;
			text-align:center;
		}
	
		h2{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:26px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-.75px;
			text-align:left;
		}
	
		h3{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:18px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-.5px;
			text-align:left;
		}
	
		h4{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:16px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}
	
		#templatePreheader{
			background-color:#142b44;
			border-top:0;
			border-bottom:0;
		}
	
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			color:#FAFAFA;
			font-family:Helvetica;
			font-size:10px;
			line-height:125%;
			text-align:left;
		}
	
		.preheaderContainer .mcnTextContent a{
			color:#FAFAFA;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateHeader{
			background-color:#FAFAFA;
			border-top:0;
			border-bottom:0;
		}
	
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:14px;
			line-height:150%;
			text-align:left;
		}
	
		.headerContainer .mcnTextContent a{
			color:#26ABE2;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateBody{
			background-color:#FAFAFA;
			border-top:0;
			border-bottom:0;
		}
	
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:14px;
			line-height:150%;
			text-align:left;
		}
	
		.bodyContainer .mcnTextContent a{
			color:#26ABE2;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateFooter{
			border-top:0;
			border-bottom:0;
		}
	
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:10px;
			line-height:125%;
			text-align:left;
		}
	
		.footerContainer .mcnTextContent a{
			color:#202020;
			font-weight:normal;
			text-decoration:underline;
		}
	@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.templateContainer{
			max-width:600px !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnRetinaImage{
			max-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImage{
			height:auto !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
			max-width:100% !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
			padding:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
			padding-top:0 !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
			padding-top:9px !important;
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
			padding-right:18px !important;
			padding-bottom:0 !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
			display:none !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h1{
			font-size:24px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h2{
			font-size:20px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h3{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h4{
			font-size:16px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		#templatePreheader{
			display:block !important;
		}

}	@media only screen and (max-width: 480px){
	
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			font-size:14px !important;
			line-height:115% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			font-size:14px !important;
			line-height:115% !important;
		}

}
		</style>
                    <script>var w=window;if(w.performance||w.mozPerformance||w.msPerformance||w.webkitPerformance){var d=document;AKSB=w.AKSB||{},AKSB.q=AKSB.q||[],AKSB.mark=AKSB.mark||function(e,_){AKSB.q.push(["mark",e,_||(new Date).getTime()])},AKSB.measure=AKSB.measure||function(e,_,t){AKSB.q.push(["measure",e,_,t||(new Date).getTime()])},AKSB.done=AKSB.done||function(e){AKSB.q.push(["done",e])},AKSB.mark("firstbyte",(new Date).getTime()),AKSB.prof={custid:"222777",ustr:"",originlat:"0",clientrtt:"56",ghostip:"23.47.59.117",ipv6:false,pct:"10",clientip:"187.189.90.246",requestid:"5131ee61",region:"39398",protocol:"h2",blver:14,akM:"x",akN:"ae",akTT:"O",akTX:"1",akTI:"5131ee61",ai:"199322",ra:"false",pmgn:"",pmgi:"",pmp:"",qc:""},function(e){var _=d.createElement("script");_.async="async",_.src=e;var t=d.getElementsByTagName("script"),t=t[t.length-1];t.parentNode.insertBefore(_,t)}(("https:"===d.location.protocol?"https:":"http:")+"//ds-aksb-a.akamaihd.net/aksb.min.js")}</script>
                    </head>
					<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        
		<span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">CERT</span>
		
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell" style="padding-bottom:40px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templatePreheader">
                                        <tr>
                                        	<td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="preheaderContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; font-size: 10px; text-align: center;">
                        
                            Para más información visita CERT.edu.mx
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>                                            
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateHeader">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="headerContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://mcusercontent.com/0c5b9dd31812dd0b9be5bd313/images/77aac38c-2730-f14f-f7da-8bc196a9b030.png" width="604" style="max-width:1200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            &nbsp;
<h1 class="mc-toc-title"><span style="font-size:38px"><span style="font-family:noticia text,georgia,times new roman,serif">Tu documentación ha sido validada correctamente.</span></span></h1>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="bodyContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: left;"><font face="merriweather, georgia, times new roman, serif"><span style="font-size:16px">Estamos emocionados de que hayas decidido dar el primer paso para estudiar con nosotros.<br><br>Ahora ingresa a tu perfil para presentar el examen psicométrico y agendar una fecha para tu examen diagnóstico. <br><br>Recuerda que una vez que hayas recibido este correo tienes hasta 2 días naturales para realizar tu examen psicométrico y hasta 3 días naturales para agendar tu examen diagnóstico. </span></font><br>
&nbsp;</div>

                        </td>
						
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
    <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 4px;background-color: #2E9B9B;">
                    <tbody>
                        <tr>
                            <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Arial; font-size: 16px; padding: 18px;">
                                <a class="mcnButton " title="Agenda tu examen diagnóstico " href="http://3.15.207.243/admisiones/perfil" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Ingresa al perfil de aspirante</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: left;"><font face="merriweather, georgia, times new roman, serif"><span style="font-size:16px">Para tus exámenes te recomendamos usar una computadora con conexión estable. (De preferencia con conexión LAN) 
<br><br>Para más información sobre los exámenes consulta la guía de estudio que te adjuntamos en este correo. 
<br>
<br>Para dudas o más información contacta a un asesor de admisiones en horario de lunes a viernes de 9:00 am a 5:00 pm y los sábados de 9:00 am a 1:30 pm. </span></font></div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
<tbody class="mcnBoxedTextBlockOuter">
        <tr>
            <td valign="top" class="mcnBoxedTextBlockInner">
                
				
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnBoxedTextContentContainer">
                    <tbody><tr>
                        
                        <td style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                        
                            <table border="0" cellspacing="0" class="mcnTextContentContainer" width="100%" style="min-width: 100% !important;background-color: #CACACA;">
                                <tbody><tr>
                                    <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-family: Helvetica;font-size: 14px;font-weight: normal;text-align: center;">
                                        <span style="font-family:merriweather,georgia,times new roman,serif">Teléfono:&nbsp;9991 26 76 06<br>Correo: contacto@cert.edu.mx</span>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://mcusercontent.com/0c5b9dd31812dd0b9be5bd313/images/44a5d516-01a4-1229-714a-2cfffb40c6c0.png" width="604" style="max-width:1200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
    <tbody><tr>
        <td align="center" style="padding-left:9px;padding-right:9px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnFollowContent">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td align="center" valign="top">
                                   
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="https://www.facebook.com/CERTMeridaCaucel/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-facebook-48.png" alt="Facebook Oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
											
											<table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="cert.edu.mx" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-link-48.png" alt="Página oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
											
											<table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:0; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="https://www.instagram.com/certmeridacaucel/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-instagram-48.png" alt="Instagram Oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
											
											</td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>

 </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateFooter">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="footerContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </center><script type="text/javascript"  src="/FUoqn-CQD/perPqAr/QfhfG6N/qmTY/iSicGmLkaD/MmhnbHgB/EX/BCVBwrZGw"></script></body>
</html>';

		
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->CharSet = 'UTF-8';
	$mail->IsHTML(true);

	$mail->Host = $GLOBALS['config_mail_host'];
	$mail->Port = $GLOBALS['config_mail_port'];
	$mail->Username = $GLOBALS['config_mail_username'];
	$mail->Password = $GLOBALS['config_mail_password'];

	$mail->setFrom( "noreply@cert.edu.mx","Centro Educativo Rodríguez Tamayo"  );
	$mail->Subject = $asunto;
	//$mail->addBCC("christhian.sosa@gmail.com");
	//$mail->addBCC("arturosolis@cert.edu.mx");
	
	//Correos
	$mail->addAddress($correo, $nombre);
	
	for ($c=0; $c<count($archivos);$c++)
	{
		$mail->addAttachment($archivos[$c]);
	}
	
	$mail->MsgHTML($message);
	$mail->Send();
		
}

//Validación de éxamenes presentados
function mandar_correo_validacion2($correo,$nombre,$asunto)
{
	$message = '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>'.$asunto.'</title>
        
    <style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		.mcnPreviewText{
			display:none !important;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit !important;
			text-decoration:none !important;
			font-size:inherit !important;
			font-family:inherit !important;
			font-weight:inherit !important;
			line-height:inherit !important;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage,.mcnRetinaImage{
			vertical-align:bottom;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto !important;
		}
		.mcnDividerBlock{
			table-layout:fixed !important;
		}
	body,#bodyTable,#templateFooter{
			background-color:#FAFAFA;
		}
	
		#bodyCell{
			border-top:0;
		}
	
		h1{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:32px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-1px;
			text-align:center;
		}
	
		h2{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:26px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-.75px;
			text-align:left;
		}
	
		h3{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:18px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-.5px;
			text-align:left;
		}
	
		h4{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:16px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}
	
		#templatePreheader{
			background-color:#142b44;
			border-top:0;
			border-bottom:0;
		}
	
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			color:#FAFAFA;
			font-family:Helvetica;
			font-size:10px;
			line-height:125%;
			text-align:left;
		}
	
		.preheaderContainer .mcnTextContent a{
			color:#FAFAFA;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateHeader{
			background-color:#FAFAFA;
			border-top:0;
			border-bottom:0;
		}
	
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:14px;
			line-height:150%;
			text-align:left;
		}
	
		.headerContainer .mcnTextContent a{
			color:#26ABE2;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateBody{
			background-color:#FAFAFA;
			border-top:0;
			border-bottom:0;
		}
	
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:14px;
			line-height:150%;
			text-align:left;
		}
	
		.bodyContainer .mcnTextContent a{
			color:#26ABE2;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateFooter{
			border-top:0;
			border-bottom:0;
		}
	
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:10px;
			line-height:125%;
			text-align:left;
		}
	
		.footerContainer .mcnTextContent a{
			color:#202020;
			font-weight:normal;
			text-decoration:underline;
		}
	@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.templateContainer{
			max-width:600px !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnRetinaImage{
			max-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImage{
			height:auto !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
			max-width:100% !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
			padding:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
			padding-top:0 !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
			padding-top:9px !important;
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
			padding-right:18px !important;
			padding-bottom:0 !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
			display:none !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h1{
			font-size:24px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h2{
			font-size:20px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h3{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h4{
			font-size:16px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		#templatePreheader{
			display:block !important;
		}

}	@media only screen and (max-width: 480px){
	
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			font-size:14px !important;
			line-height:115% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			font-size:14px !important;
			line-height:115% !important;
		}

}
		</style>
                    <script>var w=window;if(w.performance||w.mozPerformance||w.msPerformance||w.webkitPerformance){var d=document;AKSB=w.AKSB||{},AKSB.q=AKSB.q||[],AKSB.mark=AKSB.mark||function(e,_){AKSB.q.push(["mark",e,_||(new Date).getTime()])},AKSB.measure=AKSB.measure||function(e,_,t){AKSB.q.push(["measure",e,_,t||(new Date).getTime()])},AKSB.done=AKSB.done||function(e){AKSB.q.push(["done",e])},AKSB.mark("firstbyte",(new Date).getTime()),AKSB.prof={custid:"222777",ustr:"",originlat:"0",clientrtt:"56",ghostip:"23.47.59.117",ipv6:false,pct:"10",clientip:"187.189.90.246",requestid:"5131ee61",region:"39398",protocol:"h2",blver:14,akM:"x",akN:"ae",akTT:"O",akTX:"1",akTI:"5131ee61",ai:"199322",ra:"false",pmgn:"",pmgi:"",pmp:"",qc:""},function(e){var _=d.createElement("script");_.async="async",_.src=e;var t=d.getElementsByTagName("script"),t=t[t.length-1];t.parentNode.insertBefore(_,t)}(("https:"===d.location.protocol?"https:":"http:")+"//ds-aksb-a.akamaihd.net/aksb.min.js")}</script>
                    </head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        
		<span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">CERT</span>
		
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell" style="padding-bottom:40px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templatePreheader">
                                        <tr>
                                        	<td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="preheaderContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; font-size: 10px; text-align: center;">
                        
                            Para más información visita CERT.edu.mx
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>                                            
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateHeader">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="headerContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://mcusercontent.com/0c5b9dd31812dd0b9be5bd313/images/77aac38c-2730-f14f-f7da-8bc196a9b030.png" width="604" style="max-width:1200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            &nbsp;
<h1 class="mc-toc-title"><span style="font-size:38px"><span style="font-family:noticia text,georgia,times new roman,serif">¡MUCHAS FELICIDADES '.$nombre.'!</span></span></h1>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="bodyContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: left;"><font face="merriweather, georgia, times new roman, serif"><span style="font-size:16px">Estamos muy contentos de que hayas finalizado tus exámenes. Ya eres parte de la familia CERT. Ahora comienzas una nueva etapa en tu vida y estamos emocionados de que hayas decidido llevarla a cabo con nosotros. <br><br>A partir de la llegada de este correo tienes 7 días hábiles para acudir a las instalaciones de la institución a realizar el pago de tu inscripción y tu credencial. 
</span></font><br>
&nbsp;</div>

                        </td>
						
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: left;"><font face="merriweather, georgia, times new roman, serif"><span style="font-size:16px">Para dudas o más información contacta a un asesor de admisiones en horario de lunes a viernes de 9:00 am a 5:00 pm y los sábados de 9:00 am a 1:30 pm. </span></font></div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
    
	<tbody class="mcnBoxedTextBlockOuter">
        <tr>
            <td valign="top" class="mcnBoxedTextBlockInner">
                
				
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnBoxedTextContentContainer">
                    <tbody><tr>
                        
                        <td style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                        
                            <table border="0" cellspacing="0" class="mcnTextContentContainer" width="100%" style="min-width: 100% !important;background-color: #CACACA;">
                                <tbody><tr>
                                    <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-family: Helvetica;font-size: 14px;font-weight: normal;text-align: center;">
                                        <span style="font-family:merriweather,georgia,times new roman,serif">Teléfono:&nbsp;9991 26 76 06<br>Correo: contacto@cert.edu.mx</span>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://mcusercontent.com/0c5b9dd31812dd0b9be5bd313/images/44a5d516-01a4-1229-714a-2cfffb40c6c0.png" width="604" style="max-width:1200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
    <tbody><tr>
        <td align="center" style="padding-left:9px;padding-right:9px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnFollowContent">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td align="center" valign="top">
                                   
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="https://www.facebook.com/CERTMeridaCaucel/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-facebook-48.png" alt="Facebook Oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        
                                      
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="cert.edu.mx" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-link-48.png" alt="Página oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        
                                       
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:0; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="https://www.instagram.com/certmeridacaucel/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-instagram-48.png" alt="Instagram Oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        
                                       
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateFooter">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="footerContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </center>
    <script type="text/javascript"  src="/FUoqn-CQD/perPqAr/QfhfG6N/qmTY/iSicGmLkaD/MmhnbHgB/EX/BCVBwrZGw"></script></body>
</html>';

		
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->CharSet = 'UTF-8';
	$mail->IsHTML(true);

	$mail->Host = $GLOBALS['config_mail_host'];
	$mail->Port = $GLOBALS['config_mail_port'];
	$mail->Username = $GLOBALS['config_mail_username'];
	$mail->Password = $GLOBALS['config_mail_password'];

	$mail->setFrom( "noreply@cert.edu.mx","Centro Educativo Rodríguez Tamayo"  );
	$mail->Subject = $asunto;
	
	//Correos
	$mail->addAddress($correo, $nombre);
	
	$mail->MsgHTML($message);
	$mail->Send();
		
}

//Validación de documentos de médico cirujano
function mandar_correo_validacion22($correo,$nombre,$asunto)
{
	$message = '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
    	
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>'.$asunto.'</title>
        
    <style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		.mcnPreviewText{
			display:none !important;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit !important;
			text-decoration:none !important;
			font-size:inherit !important;
			font-family:inherit !important;
			font-weight:inherit !important;
			line-height:inherit !important;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage,.mcnRetinaImage{
			vertical-align:bottom;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto !important;
		}
		.mcnDividerBlock{
			table-layout:fixed !important;
		}
	body,#bodyTable,#templateFooter{
			background-color:#FAFAFA;
		}
	
		#bodyCell{
			border-top:0;
		}
	
		h1{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:32px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-1px;
			text-align:center;
		}
	
		h2{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:26px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-.75px;
			text-align:left;
		}
	
		h3{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:18px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-.5px;
			text-align:left;
		}
	
		h4{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:16px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}
	
		#templatePreheader{
			background-color:#142b44;
			border-top:0;
			border-bottom:0;
		}
	
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			color:#FAFAFA;
			font-family:Helvetica;
			font-size:10px;
			line-height:125%;
			text-align:left;
		}
	
		.preheaderContainer .mcnTextContent a{
			color:#FAFAFA;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateHeader{
			background-color:#FAFAFA;
			border-top:0;
			border-bottom:0;
		}
	
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:14px;
			line-height:150%;
			text-align:left;
		}
	
		.headerContainer .mcnTextContent a{
			color:#26ABE2;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateBody{
			background-color:#FAFAFA;
			border-top:0;
			border-bottom:0;
		}
	
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:14px;
			line-height:150%;
			text-align:left;
		}
	
		.bodyContainer .mcnTextContent a{
			color:#26ABE2;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateFooter{
			border-top:0;
			border-bottom:0;
		}
	
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:10px;
			line-height:125%;
			text-align:left;
		}
	
		.footerContainer .mcnTextContent a{
			color:#202020;
			font-weight:normal;
			text-decoration:underline;
		}
	@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.templateContainer{
			max-width:600px !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnRetinaImage{
			max-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImage{
			height:auto !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
			max-width:100% !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
			padding:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
			padding-top:0 !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
			padding-top:9px !important;
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
			padding-right:18px !important;
			padding-bottom:0 !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
			display:none !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h1{
			font-size:24px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h2{
			font-size:20px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h3{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h4{
			font-size:16px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		#templatePreheader{
			display:block !important;
		}

}	@media only screen and (max-width: 480px){
	
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			font-size:14px !important;
			line-height:115% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			font-size:14px !important;
			line-height:115% !important;
		}

}</style></head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        <span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">CERT</span>
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell" style="padding-bottom:40px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templatePreheader">
                                        <tr>
                                        	<td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="preheaderContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; font-size: 10px; text-align: center;">
                        
                            Para más información visita CERT.edu.mx
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>                                            
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateHeader">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="headerContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://mcusercontent.com/0c5b9dd31812dd0b9be5bd313/images/08c4d010-a500-8615-31fb-dd12a8ea287f.png" width="604" style="max-width:1200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            &nbsp;
<h1 class="mc-toc-title"><span style="font-size:38px"><span style="font-family:noticia text,georgia,times new roman,serif">Hola '.$nombre.'.<br>Tu documentación ha sido validada satisfactoriamente.</span></span></h1>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="bodyContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: left;"><span style="font-family:merriweather,georgia,times new roman,serif"><span style="font-size:16px">Estamos emocionados de que hayas decidido dar el primer paso para estudiar con nosotros.</span></span></div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: left;"><font face="merriweather, georgia, times new roman, serif"><span style="font-size:16px">Ahora&nbsp;da click en el siguiente botón para ingresar a tu perfil. Ahí encontrarás el link para presentar tu examen psicométrico&nbsp;(Tienes 5&nbsp;días naturales para realizarlo una vez que hayas recibido este correo).&nbsp;</span></font><br>
&nbsp;</div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
    <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 4px;background-color: #2E9B9B;">
                    <tbody>
                        <tr>
                            <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Arial; font-size: 16px; padding: 18px;">
                                <a class="mcnButton " title="Mi perfil" href="http://3.15.207.243/admisiones/perfil" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Mi perfil</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
    
	<tbody class="mcnBoxedTextBlockOuter">
        <tr>
            <td valign="top" class="mcnBoxedTextBlockInner">
                
				
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnBoxedTextContentContainer">
                    <tbody><tr>
                        
                        <td style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                        
                            <table border="0" cellspacing="0" class="mcnTextContentContainer" width="100%" style="min-width: 100% !important;background-color: #CACACA;">
                                <tbody><tr>
                                    <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-family: Helvetica;font-size: 14px;font-weight: normal;text-align: center;">
                                        <span style="font-family:merriweather,georgia,times new roman,serif">Si tienes alguna duda o deseas más información puedes contactar a un asesor:&nbsp;<br>
Mérida:&nbsp;9999 98 80 04&nbsp; &nbsp; &nbsp;Ticul: 9971 32 71 04<br>
Correo: contacto@cert.edu.mx</span>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://mcusercontent.com/0c5b9dd31812dd0b9be5bd313/images/44a5d516-01a4-1229-714a-2cfffb40c6c0.png" width="604" style="max-width:1200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
    <tbody><tr>
        <td align="center" style="padding-left:9px;padding-right:9px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnFollowContent">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td align="center" valign="top">
                                    
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="https://www.facebook.com/CERTMeridaCaucel/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-facebook-48.png" alt="Facebook Oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                       
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="cert.edu.mx" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-link-48.png" alt="Página oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        
                                       
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:0; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="https://www.instagram.com/certmeridacaucel/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-instagram-48.png" alt="Instagram Oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                       
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateFooter">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="footerContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px 18px 36px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 1px solid #DDDDDD;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </center>
    <script type="text/javascript"  src="/e8qbSG/FiP/SNW/Kx0PgZYl/X1pO4SGzSEiD/XHgJa1FGaAI/KjJyIDg/zOQE"></script></body>
</html>';

		
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->CharSet = 'UTF-8';
	$mail->IsHTML(true);

	$mail->Host = $GLOBALS['config_mail_host'];
	$mail->Port = $GLOBALS['config_mail_port'];
	$mail->Username = $GLOBALS['config_mail_username'];
	$mail->Password = $GLOBALS['config_mail_password'];

	$mail->setFrom( "noreply@cert.edu.mx","Centro Educativo Rodríguez Tamayo"  );
	$mail->Subject = $asunto;
	
	//Correos
	$mail->addAddress($correo, $nombre);
	
	$mail->MsgHTML($message);
	$mail->Send();
		
}

//Validación con matricula para presentar CENEVAL para Médico Cirujano
function mandar_correo_validacion_ceneval($correo,$nombre,$asunto)
{
	$message = '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
    	
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>'.$asunto.'</title>
        
    <style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		.mcnPreviewText{
			display:none !important;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit !important;
			text-decoration:none !important;
			font-size:inherit !important;
			font-family:inherit !important;
			font-weight:inherit !important;
			line-height:inherit !important;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage,.mcnRetinaImage{
			vertical-align:bottom;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto !important;
		}
		.mcnDividerBlock{
			table-layout:fixed !important;
		}
	
		body,#bodyTable,#templateFooter{
			background-color:#FAFAFA;
		}
	
		#bodyCell{
			border-top:0;
		}
	
		h1{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:32px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-1px;
			text-align:center;
		}
	
		h2{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:26px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-.75px;
			text-align:left;
		}
	
		h3{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:18px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-.5px;
			text-align:left;
		}
	
		h4{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:16px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}
	
		#templatePreheader{
			background-color:#142b44;
			border-top:0;
			border-bottom:0;
		}
	
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			color:#FAFAFA;
			font-family:Helvetica;
			font-size:10px;
			line-height:125%;
			text-align:left;
		}
	
		.preheaderContainer .mcnTextContent a{
			color:#FAFAFA;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateHeader{
			background-color:#FAFAFA;
			border-top:0;
			border-bottom:0;
		}
	
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:14px;
			line-height:150%;
			text-align:left;
		}
	
		.headerContainer .mcnTextContent a{
			color:#26ABE2;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateBody{
			background-color:#FAFAFA;
			border-top:0;
			border-bottom:0;
		}
	
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:14px;
			line-height:150%;
			text-align:left;
		}
	
		.bodyContainer .mcnTextContent a{
			color:#26ABE2;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateFooter{
			border-top:0;
			border-bottom:0;
		}
	
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:10px;
			line-height:125%;
			text-align:left;
		}
	
		.footerContainer .mcnTextContent a{
			color:#202020;
			font-weight:normal;
			text-decoration:underline;
		}
	@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.templateContainer{
			max-width:600px !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnRetinaImage{
			max-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImage{
			height:auto !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
			max-width:100% !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
			padding:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
			padding-top:0 !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
			padding-top:9px !important;
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
			padding-right:18px !important;
			padding-bottom:0 !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
			display:none !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h1{
			font-size:24px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h2{
			font-size:20px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h3{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h4{
			font-size:16px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		#templatePreheader{
			display:block !important;
		}

}	@media only screen and (max-width: 480px){
	
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			font-size:14px !important;
			line-height:115% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			font-size:14px !important;
			line-height:115% !important;
		}

}</style>
                    <script>var w=window;if(w.performance||w.mozPerformance||w.msPerformance||w.webkitPerformance){var d=document;AKSB=w.AKSB||{},AKSB.q=AKSB.q||[],AKSB.mark=AKSB.mark||function(e,_){AKSB.q.push(["mark",e,_||(new Date).getTime()])},AKSB.measure=AKSB.measure||function(e,_,t){AKSB.q.push(["measure",e,_,t||(new Date).getTime()])},AKSB.done=AKSB.done||function(e){AKSB.q.push(["done",e])},AKSB.mark("firstbyte",(new Date).getTime()),AKSB.prof={custid:"222777",ustr:"",originlat:"0",clientrtt:"49",ghostip:"23.205.103.149",ipv6:false,pct:"10",clientip:"187.189.90.246",requestid:"bdd8ac3",region:"43883",protocol:"h2",blver:14,akM:"x",akN:"ae",akTT:"O",akTX:"1",akTI:"bdd8ac3",ai:"199322",ra:"false",pmgn:"",pmgi:"",pmp:"",qc:""},function(e){var _=d.createElement("script");_.async="async",_.src=e;var t=d.getElementsByTagName("script"),t=t[t.length-1];t.parentNode.insertBefore(_,t)}(("https:"===d.location.protocol?"https:":"http:")+"//ds-aksb-a.akamaihd.net/aksb.min.js")}</script>
                    </head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        <span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">CERT</span>
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell" style="padding-bottom:40px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templatePreheader">
                                        <tr>
                                        	<td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="preheaderContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; font-size: 10px; text-align: center;">
                        
                            Para más información visita CERT.edu.mx
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>                                            
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateHeader">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="headerContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://mcusercontent.com/0c5b9dd31812dd0b9be5bd313/images/4a62255e-6019-af08-cf9e-b643589f88be.png" width="604" style="max-width:1200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <h1 class="mc-toc-title" style="text-align: center;"><span style="font-size:30px"><span style="font-family:merriweather,georgia,times new roman,serif">Gracias por presentar tu examen psicométrico.</span></span></h1>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="bodyContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: center;"><font face="merriweather, georgia, times new roman, serif"><span style="font-size:16px">Ahora ingresa a tu perfil donde encontrarás tu matrícula y el link para generar tu pase de ingreso al EXANI II.</span></font></div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: center;"><font face="merriweather, georgia, times new roman, serif"><span style="font-size:16px">Sigue las instrucciones para generar tu pase de ingreso.<br>
Recuerda descargarlo y subirlo a tu perfil del CERT.</span></font><br>
&nbsp;</div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
    <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 12px;background-color: #CA2647;">
                    <tbody>
                        <tr>
                            <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Arial; font-size: 16px; padding: 18px;">
                                <a class="mcnButton " title="Mi perfil" href="http://3.15.207.243/admisiones/perfil" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Mi perfil</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
    
	<tbody class="mcnBoxedTextBlockOuter">
        <tr>
            <td valign="top" class="mcnBoxedTextBlockInner">
                
				
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnBoxedTextContentContainer">
                    <tbody><tr>
                        
                        <td style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                        
                            <table border="0" cellspacing="0" class="mcnTextContentContainer" width="100%" style="min-width: 100% !important;background-color: #CACACA;">
                                <tbody><tr>
                                    <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-family: Helvetica;font-size: 14px;font-weight: normal;text-align: center;">
                                        <span style="font-size:16px"><span style="font-family:times new roman,times,baskerville,georgia,serif">Si tienes alguna duda o deseas más información puedes contactar a un asesor:&nbsp;<br>
Mérida:&nbsp;9999 98 80 04&nbsp; &nbsp; &nbsp;Ticul: 9971 32 71 04<br>
Correo: contacto@cert.edu.mx</span></span>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://mcusercontent.com/0c5b9dd31812dd0b9be5bd313/images/788fa448-86a3-1ef6-900c-f19f556d7d63.png" width="604" style="max-width:1200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
    <tbody><tr>
        <td align="center" style="padding-left:9px;padding-right:9px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnFollowContent">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td align="center" valign="top">
                                   
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="https://www.facebook.com/CERTMeridaCaucel/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-facebook-48.png" alt="Facebook Oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        
                                      
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="cert.edu.mx" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-link-48.png" alt="Página oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        
                                       
                                        
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:0; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="https://www.instagram.com/certmeridacaucel/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-instagram-48.png" alt="Instagram Oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        
                                       
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateFooter">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="footerContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px 18px 36px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 1px solid #DDDDDD;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </center>
    <script type="text/javascript"  src="/e8qbSG/FiP/SNW/Kx0PgZYl/X1pO4SGzSEiD/XHgJa1FGaAI/KjJyIDg/zOQE"></script></body>
</html>';

		
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->CharSet = 'UTF-8';
	$mail->IsHTML(true);

	$mail->Host = $GLOBALS['config_mail_host'];
	$mail->Port = $GLOBALS['config_mail_port'];
	$mail->Username = $GLOBALS['config_mail_username'];
	$mail->Password = $GLOBALS['config_mail_password'];

	$mail->setFrom( "noreply@cert.edu.mx","Centro Educativo Rodríguez Tamayo"  );
	$mail->Subject = $asunto;
	
	//Correos
	$mail->addAddress($correo, $nombre);
	
	$mail->MsgHTML($message);
	$mail->Send();
		
}



//Validación de documentos de Educación Preescolar y Primaria
function mandar_correo_validacion_lic_educacion($correo,$nombre,$asunto)
{
	$message = '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
    	
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>'.$asunto.'</title>
        
    <style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		.mcnPreviewText{
			display:none !important;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit !important;
			text-decoration:none !important;
			font-size:inherit !important;
			font-family:inherit !important;
			font-weight:inherit !important;
			line-height:inherit !important;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage,.mcnRetinaImage{
			vertical-align:bottom;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto !important;
		}
		.mcnDividerBlock{
			table-layout:fixed !important;
		}
	body,#bodyTable,#templateFooter{
			background-color:#FAFAFA;
		}
	
		#bodyCell{
			border-top:0;
		}
	
		h1{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:32px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-1px;
			text-align:center;
		}
	
		h2{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:26px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-.75px;
			text-align:left;
		}
	
		h3{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:18px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:-.5px;
			text-align:left;
		}
	
		h4{
			color:#202020 !important;
			font-family:Helvetica;
			font-size:16px;
			font-style:normal;
			font-weight:normal;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}
	
		#templatePreheader{
			background-color:#142b44;
			border-top:0;
			border-bottom:0;
		}
	
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			color:#FAFAFA;
			font-family:Helvetica;
			font-size:10px;
			line-height:125%;
			text-align:left;
		}
	
		.preheaderContainer .mcnTextContent a{
			color:#FAFAFA;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateHeader{
			background-color:#FAFAFA;
			border-top:0;
			border-bottom:0;
		}
	
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:14px;
			line-height:150%;
			text-align:left;
		}
	
		.headerContainer .mcnTextContent a{
			color:#26ABE2;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateBody{
			background-color:#FAFAFA;
			border-top:0;
			border-bottom:0;
		}
	
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:14px;
			line-height:150%;
			text-align:left;
		}
	
		.bodyContainer .mcnTextContent a{
			color:#26ABE2;
			font-weight:normal;
			text-decoration:underline;
		}
	
		#templateFooter{
			border-top:0;
			border-bottom:0;
		}
	
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:10px;
			line-height:125%;
			text-align:left;
		}
	
		.footerContainer .mcnTextContent a{
			color:#202020;
			font-weight:normal;
			text-decoration:underline;
		}
	@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.templateContainer{
			max-width:600px !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnRetinaImage{
			max-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImage{
			height:auto !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
			max-width:100% !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
			padding:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
			padding-top:0 !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
			padding-top:9px !important;
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
			padding-right:18px !important;
			padding-bottom:0 !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
			display:none !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h1{
			font-size:24px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h2{
			font-size:20px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h3{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		h4{
			font-size:16px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		#templatePreheader{
			display:block !important;
		}

}	@media only screen and (max-width: 480px){
	
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			font-size:14px !important;
			line-height:115% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			font-size:14px !important;
			line-height:115% !important;
		}

}</style></head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        <span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">CERT</span>
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell" style="padding-bottom:40px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templatePreheader">
                                        <tr>
                                        	<td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="preheaderContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; font-size: 10px; text-align: center;">
                        
                            Para más información visita CERT.edu.mx
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>                                            
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateHeader">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="headerContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://mcusercontent.com/0c5b9dd31812dd0b9be5bd313/images/08c4d010-a500-8615-31fb-dd12a8ea287f.png" width="604" style="max-width:1200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            &nbsp;
<h1 class="mc-toc-title"><span style="font-size:38px"><span style="font-family:noticia text,georgia,times new roman,serif">Hola '.$nombre.'.<br>Tu documentación ha sido validada satisfactoriamente.</span></span></h1>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="bodyContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: left;"><span style="font-family:merriweather,georgia,times new roman,serif"><span style="font-size:16px">Estamos emocionados de que hayas decidido dar el primer paso para estudiar con nosotros.</span></span></div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: left;"><font face="merriweather, georgia, times new roman, serif"><span style="font-size:16px">Ingresa a tu perfil de aspirante del CERT donde encontrarás la matrícula y el enlace para el portal del CENEVAL. Ahí deberás llenar correctamente la información solicitada, contestar el cuestionario de contexto e imprimir tu PASE DE INGRESO.</span></font><br>
&nbsp;</div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
    <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 4px;background-color: #2E9B9B;">
                    <tbody>
                        <tr>
                            <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Arial; font-size: 16px; padding: 18px;">
                                <a class="mcnButton " title="Mi perfil" href="http://3.15.207.243/admisiones/perfil" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Mi perfil</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
    
	<tbody class="mcnBoxedTextBlockOuter">
        <tr>
            <td valign="top" class="mcnBoxedTextBlockInner">
                
				
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnBoxedTextContentContainer">
                    <tbody><tr>
                        
                        <td style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                        
                            <table border="0" cellspacing="0" class="mcnTextContentContainer" width="100%" style="min-width: 100% !important;background-color: #CACACA;">
                                <tbody><tr>
                                    <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-family: Helvetica;font-size: 14px;font-weight: normal;text-align: center;">
                                        <span style="font-family:merriweather,georgia,times new roman,serif">Si tienes alguna duda o deseas más información puedes contactar a un asesor:&nbsp;<br>
Mérida:&nbsp;9999 98 80 04&nbsp; &nbsp; &nbsp;Ticul: 9971 32 71 04<br>
Correo: contacto@cert.edu.mx</span>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://mcusercontent.com/0c5b9dd31812dd0b9be5bd313/images/44a5d516-01a4-1229-714a-2cfffb40c6c0.png" width="604" style="max-width:1200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
    <tbody><tr>
        <td align="center" style="padding-left:9px;padding-right:9px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnFollowContent">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td align="center" valign="top">
                                    
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="https://www.facebook.com/CERTMeridaCaucel/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-facebook-48.png" alt="Facebook Oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                       
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="cert.edu.mx" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-link-48.png" alt="Página oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        
                                       
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:0; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="https://www.instagram.com/certmeridacaucel/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-instagram-48.png" alt="Instagram Oficial CERT" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                       
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateFooter">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="640" class="templateContainer">
                                                    <tr>
                                                        <td valign="top" class="footerContainer" style="padding-top:9px; padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px 18px 36px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 1px solid #DDDDDD;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </center>
    <script type="text/javascript"  src="/e8qbSG/FiP/SNW/Kx0PgZYl/X1pO4SGzSEiD/XHgJa1FGaAI/KjJyIDg/zOQE"></script></body>
</html>';

		
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->CharSet = 'UTF-8';
	$mail->IsHTML(true);

	$mail->Host = $GLOBALS['config_mail_host'];
	$mail->Port = $GLOBALS['config_mail_port'];
	$mail->Username = $GLOBALS['config_mail_username'];
	$mail->Password = $GLOBALS['config_mail_password'];

	$mail->setFrom( "noreply@cert.edu.mx","Centro Educativo Rodríguez Tamayo"  );
	$mail->Subject = $asunto;
	
	//Correos
	$mail->addAddress($correo, $nombre);
	
	$mail->MsgHTML($message);
	$mail->Send();
		
}



?>