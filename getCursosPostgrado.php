<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

//El type se usa para pedir los cursos que sean para graduados o para posgrado
//Si es 1 es graduados, si es 2, es posgrado
$type = empty($_REQUEST['tipo']) ? '1' : $_REQUEST['tipo'];

$c = "SELECT * FROM curso WHERE tipo='$type' AND active IS TRUE;";
$s = pg_query($c);

$outJson = "[";

while($r = pg_fetch_array($s))
{
	$nombre = $r['nombre'];
	$descripcion = $r['descripcion'];
	
	$outJson .= '{
		"nombre":"'.$nombre.'",
		"descripcion":"'.$descripcion.'"
	}';
}

$outJson .= "]";

echo $outJson;
?>