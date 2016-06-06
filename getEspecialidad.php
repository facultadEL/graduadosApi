<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$regional = $_REQUEST['regional'];

$c = "SELECT * FROM carrera WHERE regional_fk='$regional'";
$s = pg_query($c);

$outJson = "[";
while($r = pg_fetch_array($s))
{
    if($outJson != "[")
    {
        $outJson .= ",";
    }
    
    $id = $r['id_carrera'];
    $nombre = $r['nombre_carrera'];
    
    $outJson .= '{
        "id":"'.$id.'",
        "nombre":"'.$nombre.'"
    }';
    
}

$outJson .= "]";

pg_close($conn);

echo $outJson;

?>