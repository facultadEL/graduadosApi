<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$provincia = $_REQUEST['provincia'];

$c = "SELECT l.id as id,l.nombre as loc,p.nombre as prov FROM localidad l INNER JOIN provincia p ON(p.id = l.fk_provincia)";
$s = pg_query($c);

$outJson = '[';
while($r = pg_fetch_array($s))
{
    $id = $r['id'];
    $loc = ucwords(strtolower($r['loc']));
    $prov = ucwords(strtolower($r['prov']));
    $nombre = $loc.' - '.$prov;
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