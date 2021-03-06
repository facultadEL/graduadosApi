<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once 'conexion.php';
$sqlGuardar = '';
$id = empty($_REQUEST['id']) ? '-1' : $_REQUEST['id'];
$nombre = empty($_REQUEST['nombre']) ? '' : ucwords(strtolower($_REQUEST['nombre']));
$apellido = empty($_REQUEST['apellido']) ? '' : ucwords(strtolower($_REQUEST['apellido']));
$dni = empty($_REQUEST['dni']) ? '' : $_REQUEST['dni'];
$localidad = empty($_REQUEST['localidad']) ? '' : $_REQUEST['localidad'];
$email = empty($_REQUEST['email']) ? '' : $_REQUEST['email'];
$caracCel = empty($_REQUEST['caracCel']) ? '' : $_REQUEST['caracCel'];
$cel = empty($_REQUEST['cel']) ? '' : $_REQUEST['cel'];
$caracFijo = empty($_REQUEST['caracFijo']) ? '' : $_REQUEST['caracFijo'];
$fijo = empty($_REQUEST['fijo']) ? '' : $_REQUEST['fijo'];
$username = empty($_REQUEST['username']) ? '' : $_REQUEST['username'];
$passRequired = empty($_REQUEST['passRequired']) ? '' : $_REQUEST['passRequired'];
$password = empty($_REQUEST['password']) ? '' : $_REQUEST['password'];
$fechaNac = empty($_REQUEST['birthDate']) ? '1900-01-01' : $_REQUEST['birthDate'];
$localidadId = empty($_REQUEST['localidadId']) ? '0' : $_REQUEST['localidadId'];
$regional = empty($_REQUEST['regional']) ? '0' : $_REQUEST['regional'];
$especialidad = empty($_REQUEST['especialidad']) ? '0' : $_REQUEST['especialidad'];

$celId = $_REQUEST['celId'];
$fijoId = $_REQUEST['fijoId'];

$create = 'f';

if($id != "-1")
{
	$cUpdate = "UPDATE alumno SET primer_login='FALSE' ";

	if($nombre != '') $cUpdate.= ",nombre_alumno='$nombre' ";
	if($apellido != '') $cUpdate.= ",apellido_alumno='$apellido' ";
	if($dni != '') $cUpdate.= ",numerodni_alumno='$dni' ";
	if($email != '') $cUpdate.= ",mail_alumno='$email' ";
	if($username != '') $cUpdate.= ",username='$username' ";
	if($localidadId != '0') $cUpdate.= ",localidad_viviendo_alumno='$localidadId' ";
	if($fechaNac != '') $cUpdate.= ",fechanacimiento_alumno='$fechaNac' ";
	if($password != '')
	{
		$password = md5($password);
		$cUpdate.= ",pass='$password' ";
	}
	if($regional != '0') $cUpdate.= ",regional_fk='$regional' ";
	if($especialidad != '0') $cUpdate.= ",carrera_alumno='$especialidad' ";

	$cUpdate .= "WHERE id_alumno='$id';";

	$cTel = "";
	
	$cTelId = "SELECT max(id_telefonos_del_alumno) FROM telefonos_del_alumno;";
	$sTelId = pg_query($cTelId);
	$rTelId = pg_fetch_array($sTelId);
	$maxTelId = $rTelId['max'];
	
	if($celId != '-1')
	{
		$cTel .= "UPDATE telefonos_del_alumno SET duenio_del_telefono='Cel', caracteristica_alumno='$caracCel',telefono_alumno='$cel' WHERE id_telefonos_del_alumno='$celId';";
	}
	else
	{
		if($caracCel != '' && $cel != '')
		{
			$maxTelId++;
			$cTel .= "INSERT INTO telefonos_del_alumno(id_telefonos_del_alumno,duenio_del_telefono,caracteristica_alumno,telefono_alumno,alumno_fk) VALUES('$maxTelId','Cel','$caracCel','$cel','$id');";
		}
	}
	
	if($fijoId != '-1')
	{
		$cTel .= "UPDATE telefonos_del_alumno SET duenio_del_telefono='Fijo', caracteristica_alumno='$caracFijo',telefono_alumno='$fijo' WHERE id_telefonos_del_alumno='$fijoId';";
	}
	else
	{
		if($caracFijo != '' && $fijo != '')
		{
			$maxTelId++;
			$cTel .= "INSERT INTO telefonos_del_alumno(id_telefonos_del_alumno,duenio_del_telefono,caracteristica_alumno,telefono_alumno,alumno_fk) VALUES('$maxTelId','Fijo','$caracFijo','$fijo','$id');";
		}
	}
	
	$sqlGuardar = $cUpdate.$cTel;
}
else
{
	
	$cId = "SELECT max(id_alumno) FROM alumno";
	$sId = pg_query($cId);
	$rId = pg_fetch_array($sId);
	$idAl = $rId['max'] + 1;

	$password = md5($password);

	$cCreate = "INSERT INTO alumno(id_alumno,primer_login,nombre_alumno,apellido_alumno,numerodni_alumno,mail_alumno,username,pass,fechanacimiento_alumno,localidad_viviendo_alumno,regional_fk,carrera_alumno) VALUES('$idAl','FALSE','$nombre','$apellido','$dni','$email','$username','$password','$fechaNac','$localidadId','$regional','$especialidad');";

	$cTel = "";

	$cTelId = "SELECT max(id_telefonos_del_alumno) FROM telefonos_del_alumno;";
	$sTelId = pg_query($cTelId);
	$rTelId = pg_fetch_array($sTelId);
	$maxTelId = $rTelId['max'];

	if($caracCel != '' && $cel != '')
	{
		$maxTelId++;
		$cTel .= "INSERT INTO telefonos_del_alumno(id_telefonos_del_alumno,duenio_del_telefono,caracteristica_alumno,telefono_alumno,alumno_fk) VALUES('$maxTelId','Cel','$caracCel','$cel','$idAl');";
	}

	if($caracFijo != '' && $fijo != '')
	{
		$maxTelId++;
		$cTel .= "INSERT INTO telefonos_del_alumno(id_telefonos_del_alumno,duenio_del_telefono,caracteristica_alumno,telefono_alumno,alumno_fk) VALUES('$maxTelId','Fijo','$caracFijo','$fijo','$idAl');";
	}
	
	$sqlGuardar = $cCreate.$cTel;
	$create = 't';
}

$success = 't';

$error = 0;
if (!pg_query($sqlGuardar)){
	$errorpg = pg_last_error($conn);
	$termino = "ROLLBACK";
	$error=1;
}else{
	$termino = "COMMIT";
}
pg_query($termino);

if($error == 1)
{
	$success = 'f';
}
else if($create == 't')
{
	$to = 'graduadosutnvillamaria@gmail.com';
	
	require ("PHPMailer_5.2.1/class.phpmailer.php");

	$cuerpo = "Este mensaje es generado por la aplicación de graduados<br>Se ha registrado un graduado nuevo. Sus datos son:<br><b>Nombre:</b> $nombre<br><b>Apellido: </b>$apellido<br><b>DNI: </b>$dni<br>Para habilitarlo haga click <a href='http://extension.frvm.utn.edu.ar/graduadosApi/habilitarByMail.php?idHabilitar=".$idAl."' target='_blank'>aquí</a>.";
	$asunto = 'Nuevo graduado';
	$sendFrom = 'graduadosutnvillamaria@gmail.com';
	$from_name = 'Graduados - FRVM';

	include_once "datosMail.php";

	for($i = 0; $i < 5;$i++)
	{
		$exito = $mail->Send(); // Envía el correo.1
		if($exito)
		{
			$i=5;
		}
	}
}

$outJson = '[{
	"success":"'.$success.'",
	"created":"'.$create.'",
	"query":"'.$sqlGuardar.'"
}]';

pg_close($conn);

echo $outJson;

?>