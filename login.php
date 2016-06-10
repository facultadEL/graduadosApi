<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$user = $_REQUEST['user'];
$pass = md5($_REQUEST['pass']);

$cLogin = "SELECT primer_login,id_alumno,habilitado,administrador,ultimo_login FROM alumno WHERE username='$user' AND pass='$pass';";
$sLogin = pg_query($cLogin);

$outJson = "[";
while($rLogin = pg_fetch_array($sLogin))
{
	$first = $rLogin['primer_login'];
	$id = $rLogin['id_alumno'];
	$habilitado = $rLogin['habilitado'];
	$administrador = $rLogin['administrador'];
	$ultimoLogin = $rLogin['ultimo_login'];

	$outJson .= '{
		"success":true,
		"first":"'.$first.'",
		"id":"'.$id.'",
		"habilitado":"'.$habilitado.'",
		"administrador":"'.$administrador.'",
		"ultimoLogin":"'.$ultimoLogin.'"
	}';
	
	$date = date('Y-m-d');
	$cUpdate = "UPDATE alumno SET ultimo_login='$date' WHERE id_alumno='$id';";
	pg_query($cUpdate);
	
}

$outJson .= "]";

pg_close($conn);

echo $outJson;

?>