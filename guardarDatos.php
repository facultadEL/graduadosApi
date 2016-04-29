<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once 'conexion.php';

$id = $_REQUEST['id'];
$nombre = $_REQUEST['nombre'];
$apellido = $_REQUEST['apellido'];

$cUpdate = "UPDATE alumno SET primer_login='FALSE', nombre_alumno='$nombre', apellido_alumno='$apellido' WHERE id_alumno='$id';";

?>