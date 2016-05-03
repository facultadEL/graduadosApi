<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once 'conexion.php';

$dni = $_REQUEST['dni'];
$c = "SELECT * FROM alumno WHERE numerodni_alumno='$dni' LIMIT 1;";
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
		$localidad = $r['localidad_viviendo_alumno'];
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
			"isset":"true"
		}';
}

$outJson .= "]";

echo $outJson;

?>