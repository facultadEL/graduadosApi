<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once 'conexion.php';

$id = $_REQUEST['id'];
$nombre = empty($_REQUEST['nombre']) ? '' : ucwords(strtolower($_REQUEST['nombre']));
$apellido = empty($_REQUEST['apellido']) ? '' : ucwords(strtolower($_REQUEST['apellido']));
$dni = empty($_REQUEST['dni']) ? '' : $_REQUEST['dni'];
$localidad = empty($_REQUEST['localidad']) ? '' : $_REQUEST['localidad'];
$email = empty($_REQUEST['email']) ? '' : $_REQUEST['email'];
$cel = empty($_REQUEST['cel']) ? '' : $_REQUEST['cel'];
$fijo = empty($_REQUEST['fijo']) ? '' : $_REQUEST['fijo'];
$username = empty($_REQUEST['username']) ? '' : $_REQUEST['username'];
$passRequired = empty($_REQUEST['passRequired']) ? '' : $_REQUEST['passRequired'];
$password = empty($_REQUEST['password']) ? '' : $_REQUEST['password'];

$cUpdate = "UPDATE alumno SET primer_login='FALSE' ";

if($nombre != '') $cUpdate.= ",nombre_alumno='$nombre' ";
if($apellido != '') $cUpdate.= ",apellido_alumno='$apellido' ";
if($dni != '') $cUpdate.= ",numerodni_alumno='$dni' ";
if($email != '') $cUpdate.= ",mail_alumno='$email' ";
if($username != '') $cUpdate.= ",username='$username' ";
if($password != ''){
	$password = md5($password);
	$cUpdate.= ",pass='$password' ";
}

$cUpdate .= "WHERE id_alumno='$id';";

//echo $cUpdate;

$success = true;

$outJson = '[{
	"success":"'.$success.'"
}]';

echo $outJson;

?>