<?php

$usuario= "PalmaWeb";
$clave= "BogotaCalle100";
$connection_string = 'DRIVER={SQL Server};SERVER=192.168.1.245;DATABASE=PALMERAS2013';

  if(!$conexion=odbc_connect($connection_string, $usuario, $clave)){
    die('Error al conectarse a la base de datos');
  }
  
  return $conexion; 
