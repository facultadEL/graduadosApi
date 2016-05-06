<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$c = "SELECT * FROM provincia ORDER BY nombre ASC";
$s = pg_query($c);

$outJson = '[{"val":"0","name":"Seleccione una provincia"}';
while($r = pg_fetch_array($s))
{
    $id = $r['id'];
    $nombre = $r['nombre'];
    if($id == '0')
    {
        continue;
    }
    
    if($outJson != "[")
    {
        $outJson .= ',';
    }
    
    $outJson .= '{
       "val":"'.$id.'",
       "name":"'.$nombre.'" 
    }';
}

$outJson .= "]";

echo $outJson;

?>