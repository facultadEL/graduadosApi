<?php

include_once '../conexion.php';

$vUsers = array();

$c = "SELECT id_alumno,apellido_alumno,numerodni_alumno FROM alumno ORDER BY id_alumno;";
$s = pg_query($c);
while($r = pg_fetch_array($s))
{
	$id = $r['id_alumno'];
	$dni = $r['numerodni_alumno'];
	$user = '';
	$exit = false;
	$apellido_alumno = strtolower($r['apellido_alumno']);
	do
	{
		$user = rand(0,9).rand(0,9).rand(0,9).rand(0,9);
		
		//$user ='1234';
		if(in_array($user, $vUsers))
		{
			$exit = false;
		}
		else
		{
			$exit = true;
			$vUsers[] = $user;
		}
	}while($exit == false);

	$pass = $apellido_alumno.$id;
	/*
	for($i = 0; $i <= 9; $i++)
	{
		$pass .= rand(0,9);
	}
	*/
	$pass = md5($pass);
	$sqlGuadar = "UPDATE alumno SET username='$user',pass='$pass' WHERE id_alumno='$id';";
	echo $sqlGuadar;
	echo '<br/>';
}


?>