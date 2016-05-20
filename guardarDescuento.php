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

$idEmpresa = $_REQUEST['idEmpresa'];
$id = $_REQUEST['id'];
$url = $_REQUEST['url'];
$detalle = sentence_case($_REQUEST['detalle']);
$titulo = ucwords(strtolower($_REQUEST['titulo']));

if($idEmpresa == "-1") //Creo la empresa y el descuento
{
	$empresa = ucwords(strtolower($_REQUEST['empresa']));
	
	$nombreFoto = $_FILES['image']['name'];
	$tipo_archivo = $_FILES['image']['type'];	
	$tamano_archivo = $_FILES['image']['size'];
	$archivo_foto = $_FILES['image']['tmp_name'];
	
	$nombre_foto = str_replace(" ", "-", $nombreFoto);
	$vNombreFoto = explode('.',$nombre_foto);
	
	$ext = $vNombreFoto[(count($vNombreFoto) - 1)];
	
	$foto = $empresa.rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).'.'.$ext;
	//echo $foto;
	
	//CARGO LOS DATOS DEL SERVIDOR
	
	$ftp_server = "190.114.198.126";
	$ftp_user_name = "fernandoserassioextension";
	$ftp_user_pass = "fernando2013";
	$destino_serv = "web/appFotos/".$foto;
	$destino_bd = "http://extension.frvm.utn.edu.ar/appFotos/".$foto;
	
	//conexión
	$conn_serv = ftp_connect($ftp_server); 
	// logeo
	$login_result = ftp_login($conn_serv, $ftp_user_name, $ftp_user_pass);
	// archivo a copiar/subir
	if (!empty($nombre_foto))
	{
		$upload = ftp_put($conn_serv, $destino_serv, $archivo_foto, FTP_BINARY);
	}
	// cerramos
	ftp_close($conn_serv);
	
	$c = "SELECT max(id) FROM empresa";
	$s = pg_query($c);
	$r = pg_fetch_array($s);
	$nextId = $r['max'] + 1;
	
	$c = "INSERT INTO empresa(id,nombre,regional_fk,imagen) VALUES('$nextId','$empresa',(SELECT regional_fk FROM alumno WHERE id='$id'),'$destino_bd');";
	
	$c .= "INSERT INTO descuento(nombre,url,detalle,empresa_fk) VALUES('$titulo','$url','$detalle','$nextId');";

}
else
{
	$c = "INSERT INTO descuento(nombre,url,detalle,empresa_fk) VALUES('$titulo','$url','$detalle','$idEmpresa');";
}

echo $c;

?>