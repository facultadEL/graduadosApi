<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$id = $_REQUEST['id'];

$c = "SELECT d.nombre as titulo,d.detalle,d.url as url,e.imagen,e.nombre as empresa FROM descuento d INNER JOIN empresa e ON(d.empresa_fk=e.id) WHERE e.regional_fk=(SELECT regional_fk FROM alumno WHERE id_alumno='$id');";
$s = pg_query($c);

$outJson = "[";
while($r = pg_fetch_array($s))
{
    if($outJson != "[")
    {
        $outJson .= ",";
    }
    
    $titulo = $r['titulo'];
    $url = $r['url'];
    $imagen = $r['imagen'];
    $empresa = $r['empresa'];
    $detalle = $r['detalle'];
    
    $outJson .= '{
        "titulo":"'.$titulo.'",
        "url":"'.$url.'",
        "imagen":"'.$imagen.'",
        "empresa":"'.$empresa.'",
        "detalle":"'.$detalle.'"
    }';
}

$outJson .= "]";

pg_close($conn);

echo $outJson;

?>