<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once 'conexion.php';
$sqlGuardar = '';
$id = $_REQUEST['id'];
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

$celId = $_REQUEST['celId'];
$fijoId = $_REQUEST['fijoId'];

$create = false;

if($id != "-1")
{
	$cUpdate = "UPDATE alumno SET primer_login='FALSE' ";

	if($nombre != '') $cUpdate.= ",nombre_alumno='$nombre' ";
	if($apellido != '') $cUpdate.= ",apellido_alumno='$apellido' ";
	if($dni != '') $cUpdate.= ",numerodni_alumno='$dni' ";
	if($email != '') $cUpdate.= ",mail_alumno='$email' ";
	if($username != '') $cUpdate.= ",username='$username' ";
	if($password != '')
	{
		$password = md5($password);
		$cUpdate.= ",pass='$password' ";
	}

	$cUpdate .= "WHERE id_alumno='$id';";

	$cTel = "";
	
	if($celId != '-1')
	{
		$cTel .= "UPDATE telefonos_del_alumno SET duenio_del_telefono='Cel', caracteristica_alumno='$caracCel',telefono_alumno='$cel' WHERE id_telefonos_del_alumno='$celId';";
	}
	else
	{
		if($caracCel != '' && $cel != '')
		{
			$cTel .= "INSERT INTO telefonos_del_alumno(duenio_del_telefono,caracteristica_alumno,telefono_alumno,alumno_fk) VALUES('Cel','$caracCel','$cel','$id');";
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
			$cTel .= "INSERT INTO telefonos_del_alumno(duenio_del_telefono,caracteristica_alumno,telefono_alumno,alumno_fk) VALUES('Fijo','$caracFijo','$fijo','$id');";
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

	$cCreate = "INSERT INTO alumno(id_alumno,primer_login,nombre_alumno,apellido_alumno,numerodni_alumno,mail_alumno,username,pass) VALUES('$idAl','FALSE','$nombre','$apellido','$dni','$email','$username','$password');";

	$cTel = "";

	if($caracCel != '' && $cel != '')
	{
		$cTel .= "INSERT INTO telefonos_del_alumno(duenio_del_telefono,caracteristica_alumno,telefono_alumno,alumno_fk) VALUES('Cel','$caracCel','$cel','$idAl');";
	}

	if($caracFijo != '' && $fijo != '')
	{
		$cTel .= "INSERT INTO telefonos_del_alumno(duenio_del_telefono,caracteristica_alumno,telefono_alumno,alumno_fk) VALUES('Fijo','$caracFijo','$fijo','$idAl');";
	}
	
	$sqlGuardar = $cCreate.$cTel;
	$create = true;
}

$success = true;

$outJson = '[{
	"success":"'.$success.'",
	"sql":"'.$sqlGuardar.'",
	"created":"'.$create.'"
}]';

echo $outJson;

?>