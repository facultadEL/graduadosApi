<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$id = empty($_REQUEST['idHabilitar']) ? '0' : $_REQUEST['idHabilitar'];

$c = "UPDATE alumno SET habilitado=TRUE WHERE id_alumno='$id';";

$error = 0;
if (!pg_query($c)){
	$errorpg = pg_last_error($conn);
	$termino = "ROLLBACK";
	$error=1;
}else{
	$termino = "COMMIT";
}
pg_query($termino);

if($error == 1)
{
	$success = 'f';
}
else
{
	$success = 't';
}

if($success == 't')
{
	$cM = "SELECT mail_alumno FROM alumno WHERE id_alumno='$id';";
	$sM = pg_query($cM); 
	$rM = pg_fetch_array($sM);
	
	$to = $rM['mail_alumno'];
	
	require ("PHPMailer_5.2.1/class.phpmailer.php");

	$cuerpo = "Su usuario para Graduados APP ha sido habilitado. <br> Por favor, ingrese a la aplicación para confirmar sus datos.";
	$asunto = 'Usuario aceptado - Graduados APP';
	$sendFrom = 'graduadosutnvillamaria@gmail.com';
	$from_name = 'Graduados - FRVM';

	include_once "datosMail.php";

	for($i = 0; $i < 5;$i++)
	{
		$exito = $mail->Send(); // Envía el correo.1
		if($exito)
		{
			$i=5;
		}
	}
	
	echo '<script>alert("Se habilitó correctamente el usuario")</script>';
}
else
{
	echo '<script>alert("No se pudo habilitar al usuario")</script>';
}

pg_close($conn);
?>