<?php
header('Access-Control-Allow-Origin: *');
include_once "conexion.php";

$id = $_REQUEST['id'];
$regional = $_REQUEST['regional'];
$excIds = $_REQUEST['excIds'];
$total = 10;

$condition = "";

if($regional == 'true')
{
    $condition = " AND r.id=(SELECT regional_fk FROM alumno WHERE id_alumno='$id') ";
}

$c = "SELECT n.*,r.nombre as regional,r.abreviatura,c.nombre_carrera as carrera FROM novedad n INNER JOIN regional r ON(r.id = n.regional_fk) INNER JOIN carrera c ON(c.id_carrera = n.carrera_fk) WHERE n.activo IS TRUE $condition AND n.id NOT IN $excIds ORDER BY n.fecha_creacion DESC LIMIT $total;";
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