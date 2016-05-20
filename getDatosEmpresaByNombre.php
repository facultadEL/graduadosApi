<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$nombre = strtolower($_REQUEST['name']);

$c = "SELECT e.id,e.nombre as empresa,e.imagen FROM empresa e WHERE LOWER(e.nombre)='$nombre';";
$s = pg_query($c);

$outJson = "[";
$entro = false;

while($r = pg_fetch_array($s))
{
	$entro = true;
	
	$id = $r['id'];
	$imagen = $r['imagen'];
	$empresa = $r['empresa'];
	
	$outJson .= '{
		"id":"'.$id.'",
		"imagen":"'.$imagen.'",
		"empresa":"'.$empresa.'"
	}';
	
}
if(!$entro)
{
	$outJson .= '{
	   "id":"-1" 
	}';
}

$outJson .= "]";

pg_close($conn);

echo $outJson;

?>