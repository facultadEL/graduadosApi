<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$vId = explode('/--/',$_REQUEST['idHabilitar']);

$c = "";

for($i = 0; $i < (count($vId) - 1);$i++)
{
    $id = $vId[$i];
    $c .= "UPDATE alumno SET habilitado=TRUE WHERE id_alumno='$id';";
}


$error = 0;
if (!pg_query($c)){
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
else
{
    $success = 't';
}

$outJson = '[{
	"success":"'.$success.'"
}]';

pg_close($conn);

echo $outJson;

?>