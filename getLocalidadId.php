<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$localidad = strtolower($_REQUEST['localidad']);
$provincia = strtolower($_REQUEST['provincia']);

$c = "SELECT l.id FROM localidad l INNER JOIN provincia p ON(l.fk_provincia = p.id) WHERE LOWER(l.nombre)='$localidad' AND LOWER(p.nombre)='$provincia' LIMIT 1;";
$s = pg_query($c);

$outJson = "[";

while($r = pg_fetch_array($s))
{
    $id = $r['id'];
    $outJson .= '{
        "id":"'.$id.'"
    }';
}

$outJson .= "]";

echo $outJson;
?>