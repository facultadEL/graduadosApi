<?php
header('Access-Control-Allow-Origin: *');
include_once "conexion.php";

$c = "SELECT n.*,r.nombre as regional,r.abreviatura,c.nombre_carrera as carrera FROM novedad n INNER JOIN regional r ON(r.id = n.regional_fk) INNER JOIN carrera c ON(c.id_carrera = n.carrera_fk) WHERE n.activo IS TRUE ORDER BY n.fecha_creacion DESC;";
$s = pg_query($c);

$outJson = "[";

while($r = pg_fetch_array($s))
{

	if($outJson != "[")
	{
		$outJson .= ",";
	}

	$id = $r['id'];
	$titulo = $r['titulo'];
	$detalle = $r['detalle'];
	$carrera = $r['carrera'];
	$regional = $r['regional'];
	$regionalAbreviatura = $r['abreviatura'];

	$outJson .= '{
		"id":"'.$id.'",
		"titulo":"'.$titulo.'",
		"detalle":"'.$detalle.'",
		"carrera":"'.$carrera.'",
		"regional":"'.$regional.'",
		"regionalAbreviatura":"'.$regionalAbreviatura.'"
	}';
}

$outJson .= "]";

pg_close($conn);

echo $outJson;
?>