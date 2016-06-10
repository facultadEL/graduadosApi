<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$id = $_REQUEST['id'];
$loc = $_REQUEST['loc'];

$cLogin = "SELECT ultimo_login FROM alumno WHERE id_alumno='$id';";
$sLogin = pg_query($cLogin);

$outJson = "[";
while($rLogin = pg_fetch_array($sLogin))
{
	$lastLogin = $rLogin['ultimo_login'];

	$outJson .= '{
		"loc":"'.$loc.'",
		"lastLogin":"'.$lastLogin.'"
	}';
	
	$date = date('Y-m-d');
	$cUpdate = "UPDATE alumno SET ultimo_login='$date' WHERE id_alumno='$id';";
	pg_query($cUpdate);
	
}

$outJson .= "]";

pg_close($conn);

echo $outJson;

?>