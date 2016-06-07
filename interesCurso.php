<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$id = empty($_REQUEST['id']) ? '-1' : $_REQUEST['id'];
$idCurso = empty($_REQUEST['idCurso']) ? '' : $_REQUEST['idCurso'];
$nombre = empty($_REQUEST['nombre']) ? '' : $_REQUEST['nombre'];

$cM = "SELECT nombre_alumno,apellido_alumno,mail_alumno FROM alumno WHERE id_alumno='$id';";
$sM = pg_query($cM); 
$rM = pg_fetch_array($sM);

$to = 'graduadosutnvillamaria@gmail.com';

$n = $rM['nombre_alumno'];
$a = $rM['apellido_alumno'];
$m = $rM['mail_alumno'];

require ("PHPMailer_5.2.1/class.phpmailer.php");

$cuerpo = "El alumno <b>$a, $n</b>, con mail <i>$m</i> ha mostrado interés en el curso <b>$nombre</b>.";
$asunto = 'Interés en curso - Graduados APP';
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