<?php

if ($_POST['login']) {

	header("Cache-control: private");
	include("con_palmerdb.php"); 
	$usuario1=($_POST['usuario']);
	$usuario=rtrim($usuario1);
	$password1=$_POST['password'];
	$password=rtrim($password1);

	$encabezado= "SELECT RTRIM(MV.CODUSUARIO) AS CODUSUARIO, RTRIM(MV.PASSWORD) AS CLAVE FROM CONTROL_OFIMAEnterprise.dbo.MTUSUARIO AS MV WHERE (MV.CODUSUARIO = '$usuario' AND MV.CODUSUARIO IN ('PRODRIGUEZ', 'VGUATIVA', 'YANIMERO', 'JCASILIMAS','YFGONZALEZ','SGUIILLEN')) AND MV.PASSWORD = '$password'";
	$resul = odbc_exec($conexion,$encabezado)or die(exit("Error al ejecutar consulta"));
	$re=odbc_fetch_row($resul);    
	$us=odbc_result($resul, 'CODUSUARIO');
	$usua=rtrim($us);
	$passw=odbc_result($resul, 'CLAVE');
	$pass=rtrim($passw);

	$usua=strtoupper($usua);
	$usuario=strtoupper($usuario);
	$pass=strtoupper($pass);
	$password=strtoupper($password);

	if ($usua==$usuario and $pass==$password){
		session_start();
		$_SESSION['usuario']=$usua;
		?><script>
			alert("¡Bienvenidos!");
			window.location.href="view/index.php"; 
		</script><?php 
	}else{
		?><script>
			alert("Credenciales incorrectas");
			window.location.href="login.php"; 
		</script><?php 
	}	
}else{ 
	?><script>
		alert("Ingreso Erroneo");
		window.location.href="login.php"; 
	</script><?php
}
