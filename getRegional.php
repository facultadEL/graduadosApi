<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$c = "SELECT * FROM regional";
$s = pg_query($c);

$outJson = "[";
while($r = pg_fetch_array($s))
{
    if($outJson != "[")
    {
        $outJson .= ",";
    }
    
    $id = $r['id'];
    $nombre = $r['nombre'];
    
    $outJson .= '{
        "id":"'.$id.'",
        "nombre":"'.$nombre.'"
    }';
    
}

$outJson .= "]";

pg_close($conn);

echo $outJson;

?>