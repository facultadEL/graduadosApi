<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$c = "SELECT p.*,r.nombre as regional,r.abreviatura FROM posgrado p INNER JOIN regional r ON(r.id = p.regional_fk) WHERE activo IS TRUE;";
$s = pg_query($c);

$outJson = "[";

while($r = pg_fetch_array($s))
{

	if($outJson != "[")
	{
		$outJson .= ",";
	}

	$id = $r['id'];
	$nombre = $r['titulo'];
	$descripcion = $r['descripcion'];
	$duracion = $r['duracion'];
	$regional = $r['regional'];
	$regionalAbreviatura = $r['abreviatura'];
	
	$outJson .= '{
		"id":"'.$id.'",
		"nombre":"'.$nombre.'",
		"descripcion":"'.$descripcion.'",
		"duracion":"'.$duracion.'",
		"regional":"'.$regional.'",
		"regionalAbreviatura":"'.$regionalAbreviatura.'"
	}';
}

$outJson .= "]";

pg_close($conn);

echo $outJson;
?>