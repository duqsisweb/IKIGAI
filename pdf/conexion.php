<?php
$conexion = new mysqli("localhost","root","","Gym");
if ($conexion -> connect_errno)
{
	die("Fallo conexion:(".$conexion -> mysqli_connect_errno().")".$conexion -> mysqli_connect_errno());
}
?>