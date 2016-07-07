<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
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

$c = "SELECT p.*,r.nombre as regional,r.abreviatura FROM posgrado p INNER JOIN regional r ON(r.id = p.regional_fk) WHERE activo IS TRUE $condition AND p.id NOT IN $excIds ORDER BY p.fecha_creacion DESC;";
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