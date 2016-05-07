<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$userMail = strtolower($_REQUEST['userMail']);


$c = "SELECT * FROM alumno WHERE lower(username)='$userMail' OR lower(mail_alumno)='$userMail' LIMIT 1;";
$s = pg_query($c);

$found = false;
while($r = pg_fetch_array($s))
{
	$found = true;
	//$mail = $r['mail_alumno'];
	$id = $r['id_alumno'];
	$newPass = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
	$mail = 'eze.olea.f@gmail.com';
	$mdPass = md5($newPass);
	
	require ("PHPMailer_5.2.1/class.phpmailer.php");

	$cuerpo = "En este mail se agregan los datos de ingreso solicitados en la aplicación de graduados.<br/><strong>Nueva contraseña:</strong>$newPass<br/><i>Al ingresar se le solicitará nuevamente que cambie la contraseña</i>";
	$asunto = 'Datos de ingreso';
	$sendFrom = 'graduadosutnvillamaria@gmail.com';
	$from_name = 'Graduados - FRVM';
	$to = $mail;

	include_once "datosMail.php";

	for($i = 0; $i < 5;$i++)
	{
		$exito = $mail->Send(); // Envía el correo.1
		if($exito)
		{
			$i=5;
		}
	}

	if($exito)
	{
		$cU = "UPDATE alumno SET pass='$mdPass',primer_login='TRUE' WHERE id_alumno='$id';";
		pg_query($cU);
	}
	else
	{
		$found = 'false';
	}
	
	
}
$outJson = "[{";
if($found)
{
	$outJson .= '"success": "true"}]';
}
else
{
	$outJson .= '"success": "false"}]';
}
echo $outJson;

?>