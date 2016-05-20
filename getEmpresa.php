<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$id = $_REQUEST['id'];

$c = "SELECT e.id,e.nombre as empresa FROM empresa e WHERE regional_fk=(SELECT g.regional_fk FROM alumno g WHERE g.id_alumno='$id');";
$s = pg_query($c);

$outJson = "[";

while($r = pg_fetch_array($s))
{
    if($outJson != "[")
    {
        $outJson .= ",";
    }
    
    $nombre = $r['empresa'];
    $id = $r['id'];
    
    $outJson .= '{
       "val":"'.$id.'",
       "name":"'.$nombre.'" 
    }';
}

$outJson .= "]";

pg_close($conn);

echo $outJson;

?>