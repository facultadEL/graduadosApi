<?php
header('Access-Control-Allow-Origin: *'); //Esto va cada vez para asegurarse que permita las conexiones de afuera
include_once "conexion.php";

$id = $_REQUEST['id'];
$lastLogin = $_REQUEST['lastLogin'];

$c = "SELECT count(id) AS cant FROM empleo WHERE fecha_creacion >= '$lastLogin';";
$s = pg_query($c);
$r = pg_fetch_array($s);
$cEmpleo = $r['cant'];

$c = "SELECT count(id) AS cant FROM descuento WHERE fecha_creacion >= '$lastLogin';";
$s = pg_query($c);
$r = pg_fetch_array($s);
$cDescuento = $r['cant'];

$c = "SELECT count(id) AS cant FROM posgrado WHERE fecha_creacion >= '$lastLogin';";
$s = pg_query($c);
$r = pg_fetch_array($s);
$cPosgrado = $r['cant'];

$c = "SELECT count(id) AS cant FROM curso WHERE fecha_creacion >= '$lastLogin';";
$s = pg_query($c);
$r = pg_fetch_array($s);
$cCurso = $r['cant'];

$c = "SELECT count(id) AS cant FROM novedad WHERE fecha_creacion >= '$lastLogin';";
$s = pg_query($c);
$r = pg_fetch_array($s);
$cNovedad = $r['cant'];

$outJson = '[{
    "cEmpleo":"'.$cEmpleo.'",
    "cDescuento":"'.$cDescuento.'",
    "cPosgrado":"'.$cPosgrado.'",
    "cCurso":"'.$cCurso.'",
    "cNovedad":"'.$cNovedad.'"
}]';

pg_close($conn);

echo $outJson;
?>