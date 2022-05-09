<?php
$hoy = date("Y-m-d");
$hora = date('H:i:s');
$device = new Mobile_Detect;

//CONFIG
$GLOBALS['config_host'] = 'http://3.15.207.243/';
$GLOBALS['hoy'] = $hoy;
$GLOBALS['hora'] = $hora;
$GLOBALS['device'] = $device;

//MAIL
$GLOBALS['config_mail_host'] = 'vishnu.hosting-mexico.net';
$GLOBALS['config_mail_port'] = 465;
$GLOBALS['config_mail_username'] = 'noreply@leafseven.com.mx';
$GLOBALS['config_mail_password'] = 'LeafSeven2021';
?>