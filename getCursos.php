<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$c = "SELECT c.*,r.nombre as regional,r.abreviatura FROM curso c INNER JOIN regional r ON(r.id = c.regional_fk) WHERE activo IS TRUE;";
$s = pg_query($c);

$outJson = "[";

while($r = pg_fetch_array($s))
{

	if($outJson != "[")
	{
		$outJson .= ",";
	}

	$id = $r['id'];
	$nombre = $r['nombre'];
	$descripcion = $r['descripcion'];
	$profesor = $r['profesor'];
	$fechaInicio = $r['fecha_inicio'];
	$duracion = $r['duracion'];
	$descripcionCertificacion = $r['descripcion_certificacion'];
	$costo = $r['costo'];
	$regional = $r['regional'];
	$regionalAbreviatura = $r['abreviatura'];
	
	$cH = "SELECT * FROM horario_curso WHERE curso_fk='$id';";
	$sH = pg_query($cH);

	$horario = "[";

	while($rH = pg_fetch_array($sH))
	{
		if($horario != "[")
		{
			$horario .= ",";
		}

		$dia = $rH['dia'];
		$hDesde = $rH['hora_desde'];
		$hHasta = $rH['hora_hasta'];

		$horario .= '{
			"dia":"'.$dia.'",
			"desde":"'.$hDesde.'",
			"hasta":"'.$hHasta.'"
		}';
	}

	$horario .= "]";

	$outJson .= '{
		"id":"'.$id.'",
		"nombre":"'.$nombre.'",
		"descripcion":"'.$descripcion.'",
		"profesor":"'.$profesor.'",
		"fechaInicio":"'.$fechaInicio.'",
		"duracion":"'.$duracion.'",
		"descriptionCertificacion":"'.$descripcionCertificacion.'",
		"costo":"'.$costo.'",
		"regional":"'.$regional.'",
		"regionalAbreviatura":"'.$regionalAbreviatura.'",
		"horario":'.$horario.'
	}';
}

$outJson .= "]";

pg_close($conn);

echo $outJson;
?>