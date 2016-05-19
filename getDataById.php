<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$id = $_REQUEST['id'];

if($id != -1)
{
	//$id = 1;

	$c = "SELECT * FROM alumno WHERE id_alumno='$id';";
	$s = pg_query($c);

	$outJson = "[";
	while($r = pg_fetch_array($s))
	{
		if($outJson != "[")
		{
			$outJson .= ',';
		}

		$id = $r['id_alumno'];
		$nombre = ucwords(strtolower($r['nombre_alumno']));
		$apellido = ucwords(strtolower($r['apellido_alumno']));
		$dni = (empty($r['numerodni_alumno'])) ? '' : (strlen($r['numerodni_alumno']) > 5 ? $r['numerodni_alumno'] : '');
		$localidadId = $r['localidad_viviendo_alumno'];
		$fechaNac = $r['fechanacimiento_alumno'];
		$regional = $r['regional_fk'];
		
		$cLoc = "SELECT l.nombre as loc,p.nombre as prov FROM localidad l INNER JOIN provincia p ON(l.fk_provincia = p.id) WHERE l.id='$localidadId';";
		$sLoc = pg_query($cLoc);
		$rLoc = pg_fetch_array($sLoc);
		
		$l = ucwords(strtolower($rLoc['loc']));
		$p = ucwords(strtolower($rLoc['prov']));
		
		$localidad = $l.' - '.$p;
		
		$email = empty($r['mail_alumno']) ? '' : $r['mail_alumno'];
		$username = $r['username'];
		$pass = '';
		$primerLogin = $r['primer_login'];

		$cTel = "SELECT * FROM telefonos_del_alumno WHERE alumno_fk='$id';";
		$sTel = pg_query($cTel);

		$caracCel = "";
		$cel = "";
		$celId = "-1";
		$caracFijo = "";
		$fijo = "";
		$fijoId = "-1";

		while($rTel = pg_fetch_array($sTel))
		{
			$tipo = strtolower($rTel['duenio_del_telefono']);
			if(strpos($tipo, "fijo") > -1)
			{
				if($fijoId == "-1")
				{
					$fijoId = $rTel['id_telefonos_del_alumno'];
					$caracFijo = $rTel['caracteristica_alumno'];
					$fijo = $rTel['telefono_alumno'];
				}
			}
			else
			{
				if(strpos($tipo, "cel") > -1)
				{
					if($celId == "-1")
					{
						$celId = $rTel['id_telefonos_del_alumno'];
						$caracCel = $rTel['caracteristica_alumno'];
						$cel = $rTel['telefono_alumno'];
					}
				}
			}
		}


		$outJson .= '{
			"id":"'.$id.'",
			"nombre":"'.$nombre.'",
			"apellido":"'.$apellido.'",
			"dni":"'.$dni.'",
			"localidad":"'.$localidad.'",
			"regional":"'.$regional.'",
			"email":"'.$email.'",
			"username":"'.$username.'",
			"pass":"'.$pass.'",
			"primerLogin":"'.$primerLogin.'",
			"fijoId":"'.$fijoId.'",
			"caracFijo":"'.$caracFijo.'",
			"fijo":"'.$fijo.'",
			"celId":"'.$celId.'",
			"caracCel":"'.$caracCel.'",
			"cel":"'.$cel.'",
			"fechaNac":"'.$fechaNac.'",
			"isset":"true"
		}';
	}

	$outJson .= "]";

	pg_close($conn);

	echo $outJson;
}
else
{
	$outJson = '[{
		"id":"-1",
		"isset":"false",
		"primerLogin":"t"
	}]';

	pg_close($conn);

	echo $outJson;
}

?>