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
    $count = 0;
}
else
{
    $c = "SELECT count(id_alumno) as cant FROM alumno WHERE habilitado IS FALSE AND regional_fk=(SELECT regional_fk FROM alumno WHERE id_alumno='$id');";
    $s = pg_query($c);
    $r = pg_fetch_array($s);
    $count = $r['cant'];
    
    $success = 't';
}

$outJson = '[{
	"success":"'.$success.'",
    "cant":"'.$count.'"
}]';

pg_close($conn);

echo $outJson;

?>