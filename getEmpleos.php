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

$c = "SELECT t.*,r.nombre as regional,r.abreviatura,e.nombre as empresa FROM empleo t INNER JOIN regional r ON(r.id = t.regional_fk) INNER JOIN empresa e ON(t.empresa_fk = e.id) WHERE t.activo IS TRUE $condition AND t.id NOT IN $excIds ORDER BY t.fecha_creacion DESC;";
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