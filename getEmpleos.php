<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

/* Esto se deja preparado en caso de que solo se quiera traer pocas cantidades
$from = $_REQUEST['from']; //Este es el id del ultimo trabajo
$limit = $_REQUEST['limit']; //La cantidad de trabajos a traer
*/
$c = "SELECT * FROM empleo WHERE active IS TRUE";
$s = pg_query($c);

$outJson = "[";

while($r = pg_fetch_array($s))
{
	if($outJson != "[")
	{
		$outJson .= ",";
	}
	
	$nombre = $r['nombre'];
	$carrera = $r['carrera_ideal'];
	$tambienAplica = $r['tambien_aplica'];
	$descripcion = $r['descripcion'];
	$caracContacto = $r['carac_contacto'];
	$telContacto = $r['tel_contacto'];
	$mailContacto = $r['mail_contacto'];
	
	$outJson .= '{
		"nombre":"'.$nombre.'",
		"carrera":"'.$carrera.'",
		"tambienAplica":"'.$tambienAplica.'",
		"descripcion":"'.$descripcion.'",
		"caracteristica":"'.$caracContacto.'",
		"telefono":"'.$telContacto.'",
		"mail":"'.$mailContacto.'"
	}';
}

$outJson .= "]";

echo $outJson;

?>