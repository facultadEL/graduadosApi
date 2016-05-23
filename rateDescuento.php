<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
function sentence_case($string) { 
	$sentences = preg_split('/([.?!]+)/', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE); 
	$new_string = ''; 
	foreach ($sentences as $key => $sentence) { 
		$new_string .= ($key & 1) == 0? 
			ucfirst(strtolower(trim($sentence))) : 
			$sentence.' '; 
	} 
	return trim($new_string); 
} 
include_once "conexion.php";

$id = $_REQUEST['id'];
$idDescuento = $_REQUEST['idDescuento'];
$puntaje = $_REQUEST['puntaje'];
$comentario = sentence_case($_REQUEST['comentario']);

$cControl = "SELECT count(id) as cant FROM puntaje WHERE descuento_fk='$idDescuento' AND alumno_fk='$id';";
$sControl = pg_query($cControl);
$rControl = pg_fetch_array($sControl);
$cant = $rControl['cant'];
if($cant == 0) //Creo
{
    $cNuevo = "INSERT INTO puntaje(puntuacion,comentario,alumno_fk,descuento_fk) VALUES('$puntaje','$comentario','$id','$idDescuento');";
    $sqlGuardar = $cNuevo;
}
else //Modifico
{
    $cMod = "UPDATE puntaje SET puntuacion='$puntaje',comentario='$comentario' WHERE alumno_fk='$id' AND descuento_fk='$idDescuento';";
    $sqlGuardar = $cMod;
}

$error = 0;
if (!pg_query($sqlGuardar)){
	$errorpg = pg_last_error($conn);
	$termino = "ROLLBACK";
	$error=1;
}else{
	$termino = "COMMIT";
}
pg_query($termino);

if($error == 1)
{
	$success = false;
    $pReturn = 0;
}
else
{
    $success = true;
    $pReturn = $puntaje;   
}

$outJson = '[{
	"success":"'.$success.'",
    "puntaje":"'.$pReturn.'",
    "idDescuento":"'.$idDescuento.'",
    "s":"'.$sqlGuardar.'"
}]';

pg_close($conn);

echo $outJson;

?>