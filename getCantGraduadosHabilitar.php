<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$id = $_REQUEST['id'];

$c = "SELECT count(a.id_alumno) AS cant FROM alumno a WHERE a.habilitado IS FALSE AND a.regional_fk = (SELECT r.regional_fk FROM alumno r WHERE r.id_alumno='$id');";
$s = pg_query($c);
$r = pg_fetch_array($s);
$count = $r['cant'];

$outJson = '[{"cantidad":"'.$count.'"}]';

pg_close($conn);

echo $outJson;
?>