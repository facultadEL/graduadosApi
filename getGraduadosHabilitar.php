<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$id = $_REQUEST['id'];
$c = "SELECT a.* FROM alumno a WHERE a.habilitado IS FALSE AND a.regional_fk = (SELECT r.regional_fk FROM alumno r WHERE r.id_alumno='$id');";
$s = pg_query($c);
$outJson = "[";
while($r = pg_fetch_array($s))
{
	if($outJson != "[")
	{
		$outJson .= ",";
	}
	
	$id = $r['id_alumno'];
	$nombre = ucwords(strtolower($r['nombre_alumno']));
	$apellido = ucwords(strtolower($r['apellido_alumno']));
	$dni = $r['numerodni_alumno'];
	
	$outJson .= '{
		"id":"'.$id.'",
		"nombre":"'.$nombre.'",
		"apellido":"'.$apellido.'",
		"dni":"'.$dni.'"
	}';
}

$outJson .= "]";

pg_close($conn);

echo $outJson;
?>