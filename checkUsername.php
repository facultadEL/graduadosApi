<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once 'conexion.php';

$username = $_REQUEST['username'];
$id = $_REQUEST['id'];

$c = "SELECT count(id_alumno) FROM alumno WHERE username='$username'";
$c .= ($id != '-1') ? "AND id_alumno <> '$id'" : '';
$s = pg_query($c);
$r = pg_fetch_array($s);
$repetido = 'f';

if($r['count'] > 0)
{
    $repetido = 't';
}

$outJson = '[{
    "repetido":"'.$repetido.'"
}]';

pg_close($conn);

echo $outJson;

?>