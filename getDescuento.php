<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$id = $_REQUEST['id'];

$c = "SELECT d.id,d.nombre as titulo,d.detalle,e.imagen,e.nombre as empresa,r.nombre as rubro,e.url,coalesce(p.puntuacion,0) as puntuacion, coalesce((select avg(puntuacion) FROM puntaje WHERE descuento_fk=d.id),0) as promedio, (select count(id) from puntaje where descuento_fk=d.id) as cant FROM descuento d INNER JOIN empresa e ON(d.empresa_fk=e.id) INNER JOIN rubro r ON(e.rubro_fk = r.id) LEFT JOIN puntaje p ON(p.alumno_fk = '$id' AND p.descuento_fk=d.id) WHERE e.regional_fk=(SELECT regional_fk FROM alumno WHERE id_alumno='$id') ORDER BY d.fecha_creacion DESC;";
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
	$url = $r['url'];
	$imagen = $r['imagen'];
	$empresa = $r['empresa'];
	$detalle = $r['detalle'];
	$puntuacion = $r['puntuacion'];
	$promedio = $r['promedio'];
	$cantidad = $r['cant'];
	$rubro = $r['rubro'];
	
	$outJson .= '{
		"id":"'.$id.'",
		"titulo":"'.$titulo.'",
		"url":"'.$url.'",
		"imagen":"'.$imagen.'",
		"empresa":"'.$empresa.'",
		"detalle":"'.$detalle.'",
		"puntuacion":"'.$puntuacion.'",
		"promedio":"'.$promedio.'",
		"cantidad":"'.$cantidad.'",
		"rubro":"'.$rubro.'"
	}';
}

$outJson .= "]";

pg_close($conn);

echo $outJson;

?>