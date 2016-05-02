<?php
session_start();
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";
//$id = $_COOKIE["id"];
$id = 1;

$c = "SELECT * FROM alumno WHERE id_alumno='$id';";
$s = pg_query($c);

$outJson = "[";
while($r = pg_fetch_array($s))
{
	if($outJson != "[")
	{
		$outJson .= ',';
	}

	$id = $r['id_alumno'];
	$nombre = ucwords(strtolower($r['nombre_alumno']));
	$apellido = ucwords(strtolower($r['apellido_alumno']));
	$dni = (empty($r['numerodni_alumno'])) ? '' : (strlen($r['numerodni_alumno']) > 5 ? $r['numerodni_alumno'] : '');
	$localidad = $r['localidad_viviendo_alumno'];
	$email = empty($r['mail_alumno']) ? '' : $r['mail_alumno'];
	$username = $r['username'];
	$pass = '';
	$primerLogin = $r['primer_login'];

	$outJson .= '{
		"id":"'.$id.'",
		"nombre":"'.$nombre.'",
		"apellido":"'.$apellido.'",
		"dni":"'.$dni.'",
		"localidad":"'.$localidad.'",
		"email":"'.$email.'",
		"username":"'.$username.'",
		"pass":"'.$pass.'",
		"primerLogin":"'.$primerLogin.'"
	}';
}

$outJson .= "]";

echo $outJson;

?>