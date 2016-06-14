<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$c = "SELECT t.*,r.nombre as regional,r.abreviatura,e.nombre as empresa FROM empleo t INNER JOIN regional r ON(r.id = t.regional_fk) INNER JOIN empresa e ON(t.empresa_fk = e.id) WHERE t.activo IS TRUE ORDER BY t.fecha_creacion DESC;";
$s = pg_query($c);

$outJson = "[";

while($r = pg_fetch_array($s))
{

	if($outJson != "[")
	{
		$outJson .= ",";
	}

	$id = $r['id'];
	$puesto = $r['puesto'];
	$detalle = $r['detalle'];
	$requisitos = $r['requisitos'];
	$regional = $r['regional'];
	$regionalAbreviatura = $r['abreviatura'];
	$empresa = $r['empresa'];
	
	$outJson .= '{
		"id":"'.$id.'",
		"puesto":"'.$puesto.'",
		"detalle":"'.$detalle.'",
		"requisitos":"'.$requisitos.'",
		"regional":"'.$regional.'",
		"regionalAbreviatura":"'.$regionalAbreviatura.'",
		"empresa":"'.$empresa.'"
	}';
}

$outJson .= "]";

pg_close($conn);

echo $outJson;
?>