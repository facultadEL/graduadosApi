<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$id = empty($_REQUEST['id']) ? '-1' : $_REQUEST['id'];
$asunto = empty($_REQUEST['asunto']) ? '' : $_REQUEST['asunto'];
$descripcion = empty($_REQUEST['mensaje']) ? '' : $_REQUEST['mensaje'];

$cM = "SELECT nombre_alumno,apellido_alumno,mail_alumno FROM alumno WHERE id_alumno='$id';";
$sM = pg_query($cM); 
$rM = pg_fetch_array($sM);

//$to = 'graduadosutnvillamaria@gmail.com';
$to = 'eze.olea.f@gmail.com';

$n = $rM['nombre_alumno'];
$a = $rM['apellido_alumno'];
$m = $rM['mail_alumno'];

require ("PHPMailer_5.2.1/class.phpmailer.php");

$cuerpo = "Se ha generado una nueva consulta del graduado <b>$a, $n</b>, con mail <i>$m</i>.<br><b>Asunto de la consulta:</b>$asunto<br><b>Consulta:</b>$descripcion";
$asunto = 'Nueva consulta - Graduados APP';
$sendFrom = 'graduadosutnvillamaria@gmail.com';
$from_name = 'Graduados App - FRVM';

include_once "datosMail.php";

for($i = 0; $i < 5;$i++)
{
    $exito = $mail->Send(); // Envía el correo.1
    if($exito)
    {
        $i=5;
    }
}

$e = ($exito) ? 't' : 'f';

$outJson = '[{
    "exito": "'.$e.'"
}]';

pg_close($conn);

echo $outJson;
?>