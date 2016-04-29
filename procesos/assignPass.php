<?php

include_once '../conexion.php';

$c = "SELECT id_alumno,numerodni_alumno FROM alumno;";
$s = pg_query($c);
while($r = pg_fetch_array($s))
{
	$id = $r['id_alumno'];
	$dni = $r['numerodni_alumno'];
	if(strlen($dni) > 6)
	{
		$user = $dni;
		$pass = '';
		for($i = 0; $i <= 9; $i++)
		{
			$pass .= rand(0,9);
		}

		$sqlGuadar = "UPDATE alumno SET username='$user',pass='$pass' WHERE id_alumno='$id';";
		echo $sqlGuadar;
		echo '<br/>';
	}
}


?>