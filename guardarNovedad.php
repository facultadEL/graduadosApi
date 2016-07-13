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

$idNovedad = empty($_REQUEST['id']) ? '-1' : $_REQUEST['id'];
$regional = $_REQUEST['regional'];
$especialidad = $_REQUEST['especialidad'];
$titulo = empty($_REQUEST['titulo']) ? '' : ucwords(strtolower($_REQUEST['titulo']));
$desarrollo = empty($_REQUEST['desarrollo']) ? '' : ucwords(strtolower($_REQUEST['desarrollo']));
$tipo = $_REQUEST['tipo'];
$notificationOn = empty($_REQUEST['notify']) ? 'f' : $_REQUEST['notify'];

if($idNovedad == -1)
{
    $c = "SELECT max(id) FROM novedad";
    $s = pg_query($c);
    $r = pg_fetch_array($s);
    $nextId = $r['max'] + 1;

    $c = "INSERT INTO novedad(id,titulo,detalle,tipo_fk,regional_fk,carrera_fk) VALUES($nextId,'$titulo','$desarrollo',$tipo,$regional,$especialidad);";
}
$success = 't';

$error = 0;
if (!pg_query($c)){
	$errorpg = pg_last_error($conn);
	$termino = "ROLLBACK";
	$error=1;
}else{
	$termino = "COMMIT";
}
pg_query($termino);

if($error == 1)
{
	$success = 'f';
}

if($success == 't' && $notificationOn == 't')
{
	include 'notifications.php';
	$cReg = "SELECT registration_id FROM alumno WHERE registration_id IS NOT NULL AND registration_id != '' GROUP BY registration_id;";
	$sReg = pg_query($cReg);
	$noty = new Notification();
	$noty->setData('Nueva novedad',$titulo);
	while($rReg = pg_fetch_array($sReg))
	{
		$regId = $rReg['registration_id'];
		$noty->sendPush($regId);
	}
}

$outJson = '[{
	"success":"'.$success.'"
}]';

pg_close($conn);

echo $outJson;

?>