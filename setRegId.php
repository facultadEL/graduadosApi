<?php
header('Access-Control-Allow-Origin: *');
include_once 'conexion.php';

$id = $_REQUEST['id'];
$regId = $_REQUEST['regId'];

$c = "UPDATE alumno SET registration_id='$regId' WHERE id_alumno='$id';";

$success = 't';

if (!pg_query($c)){
	$errorpg = pg_last_error($conn);
	$termino = "ROLLBACK";
	$success = 'f';
}else{
	$termino = "COMMIT";
}
pg_query($termino);

$outJson = '[{
    "success":"'.$success.'"
}]';

pg_close($conn);

echo $outJson;
//AIzaSyDLgqqU21RtAMipUjvJJiLUXDc3eQOv4l0
?>