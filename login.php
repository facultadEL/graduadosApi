<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$user = $_REQUEST['username'];
$pass = md5($_REQUEST['pass']);

$cLogin = "SELECT * FROM alumno WHERE username='$user' AND pass='$pass';";
$sLogin = pg_query($cLogin);

$outJson = "["
while($rLogin = pg_fetch_array($sLogin))
{

	$first = $rLogin['primer_login'];
	$id = $rLogin['id_alumno'];

	$outJson .= '{
		"success":true,
		"first":"'.$first.'",
		"id":"'.$id.'"
	}';

	if($first == 't')
	{
		$cUpdate = "UPDATE alumno SET primer_login='FALSE' WHERE id_alumno='$id';";
		pg_query($cUpdate);
	}
}

$outJson .= "]";

echo $outJson;

?>