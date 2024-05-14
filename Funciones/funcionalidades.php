<?php

// TipoMVTO 204

/**
 * Clase que devuelve los parametros de la lista de meses
 */
class Funciones
{

	// obtener arreglo de los meses del año
	public function ListMeses($tipo, $mes)
	{
		$Meses[] = array('Mes' => 1, 'NombMes' => '01-Enero');
		$Meses[] = array('Mes' => 2, 'NombMes' => '02-Febrero');
		$Meses[] = array('Mes' => 3, 'NombMes' => '03-Marzo');
		$Meses[] = array('Mes' => 4, 'NombMes' => '04-Abril');
		$Meses[] = array('Mes' => 5, 'NombMes' => '05-Mayo');
		$Meses[] = array('Mes' => 6, 'NombMes' => '06-Junio');
		$Meses[] = array('Mes' => 7, 'NombMes' => '07-Julio');
		$Meses[] = array('Mes' => 8, 'NombMes' => '08-Agosto');
		$Meses[] = array('Mes' => 9, 'NombMes' => '09-Septiembre');
		$Meses[] = array('Mes' => 10, 'NombMes' => '10-Octubre');
		$Meses[] = array('Mes' => 11, 'NombMes' => '11-Noviembre');
		$Meses[] = array('Mes' => 12, 'NombMes' => '12-Diciembre');

		switch ($tipo) {
			case 1:
				return $Meses;
				break;

			case 2:
				return $Meses[$mes - 1]['NombMes'];
				break;
		}
	}

	public function ListSelectProgra($tipoSelect)
	{
		include "con_palmerdb.php";
		switch ($tipoSelect) {
			case '1':
				$opts = "SELECT OPCION, ID FROM PLATCAPACITACIONES.dbo.OpcionesProgramacion WHERE TIPOOPCION = 1";
				break;

			case '2':
				$opts = "SELECT OPCION, ID FROM PLATCAPACITACIONES.dbo.OpcionesProgramacion WHERE TIPOOPCION = 2";
				break;
		}

		$Dat = odbc_exec($conexion, $opts);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		print_r($arr);
		return $arr;
	}

	// Se obtiene los datos para mostrar en la tabla capacitaciones
	public function ListProgramacion($Anio, $Mes)
	{
		include "con_palmerdb.php";
		$Da = "SELECT NROPROG, IIF(TFORM = 1, 'Interna', 'Externa') AS TFORM, IIF(P.CumpLegal = 1, 'Sí', 'No') AS Cumpleg, p.CAPACITACION, TP1.OPCION AS SUBTIPO, TP2.OPCION AS CATEGORIA, P.CAPACITADOR, P.CANTIDADPROG,P.CANTIDADASIS, IIF(RTRIM(MP.NOMBRE) IS NULL, IIF(RTRIM(ME.NOMBRE) = 0, CONCAT(RTRIM(ME.NOMBRE), ' ', RTRIM(ME.NOMBRE2), ' ', RTRIM(ME.APELLIDO), ' ', RTRIM(ME.APELLIDO2)), 'CAPACITADOR EXTERNO'), RTRIM(MP.NOMBRE)) AS NOMCAP
		FROM PLATCAPACITACIONES.dbo.Programacion P LEFT JOIN PLATCAPACITACIONES..OpcionesProgramacion TP1 ON TP1.ID = P.SUBTIPO LEFT JOIN PLATCAPACITACIONES..OpcionesProgramacion TP2 ON TP2.ID = P.CATEGORIA LEFT JOIN PALMERAS2013.dbo.MTPROCLI MP ON MP.NIT = P.CAPACITADOR LEFT JOIN PALMERAS2013.dbo.MTEMPLEA ME ON ME.CODIGO = P.CAPACITACION 
		WHERE P.ANIO = $Anio AND P.MES = $Mes";

		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	public function ListCostosMayor()
	{
		include "con_palmerdb.php";
		$Da = "SELECT distinct substring(CODCC ,1, 1) CentroMayor , NOMBRE FROM PALMERAS2013..CENTCOS WHERE LEN (CODCC) = 1 AND CODCC NOT IN (0,4 ,7, 8)";
		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	public function CostosMayorFiltro($COSTOCC)
	{
		include "con_palmerdb.php";
		return $Da = odbc_exec($conexion, "SELECT NOMBRE FROM PALMERAS2013..CENTCOS WHERE LEN (CODCC) = 1 AND CODCC NOT IN (0,4 ,7, 8) AND CODCC = '$COSTOCC' ");
	}

	public function ListCargo($COSTOCC)
	{
		include "con_palmerdb.php";
		$Da = "SELECT CARGO , CODCARGO FROM PALMERAS2013..MTEMPLEA WHERE CONVERT(VARCHAR, FECRETIRO, 23) = '2100-12-31' AND
		substring(CODCC ,1, 1) = '$COSTOCC' GROUP BY CARGO, CODCARGO, substring (CODCC , 1, 1)";
		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	public function Cargo($COSTOCC, $CODIGO)
	{
		include "con_palmerdb.php";
		return $Da = odbc_exec($conexion, "SELECT CARGO , CODCARGO FROM PALMERAS2013..MTEMPLEA WHERE CONVERT(VARCHAR, FECRETIRO, 23) = '2100-12-31' AND
		substring(CODCC ,1, 1) = '$COSTOCC' AND CODIGO = '$CODIGO' GROUP BY CARGO, CODCARGO, substring (CODCC , 1, 1)");
	}

	public function ListEMPL($CARGO)
	{
		include "con_palmerdb.php";
		$Da = "SELECT CONCAT(RTRIM(MTE.NOMBRE), ' ', RTRIM(MTE.NOMBRE2), ' ', RTRIM(MTE.APELLIDO), ' ', RTRIM(MTE.APELLIDO2)) AS NOMBRE, MTE.CARGO AS CARGOEMP , MTE.CODIGO AS CODIGO FROM PALMERAS2013..MTCARGOS MC INNER JOIN PALMERAS2013..MTEMPLEA MTE ON MC.CODCARGO = MTE.CODCARGO
		WHERE MC.CODCARGO = '$CARGO' AND CONVERT(VARCHAR, MTE.FECRETIRO, 23) = '2100-12-31'";
		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	public function ListTodosEmpl()
	{
		include "con_palmerdb.php";
		$Da = "SELECT CONCAT(RTRIM(CEDULA),' - ', RTRIM(NOMBRE), ' ', RTRIM(NOMBRE2), ' ', RTRIM(APELLIDO), ' ', RTRIM(APELLIDO2)) AS NOMBRE, CEDULA
		FROM PALMERAS2013..MTEMPLEA WHERE CONVERT(VARCHAR, FECRETIRO, 23) = '2100-12-31'";
		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	public function ListAsistentes($NROPROG)
	{
		include "con_palmerdb.php";
		$Da = "SELECT CP.CODIGOEMPL , IIF(CP.APRUEBA IS NULL, 0 , CP.APRUEBA) AS NOTA,
		IIF(TIPOUSUARIO = 1, 'Si', 'No') AS TIPOUSUARIO, RTRIM(MP.NOMBRE)+' '+RTRIM(MP.NOMBRE2)+' '+RTRIM(MP.APELLIDO)+' '+RTRIM(MP.APELLIDO2) AS NOMCAP
		FROM PALMERAS2013.dbo.MTEMPLEA MP LEFT JOIN PLATCAPACITACIONES.dbo.Capacitaciones CP ON MP.CODIGO = CP.CODIGOEMPL
		WHERE CP.NROPRGC = '$NROPROG' AND CP.REPROBADO = 2 ORDER BY NOMCAP";

		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	public function ListAsistentesReprogramados($NROPROG)
	{
		include "con_palmerdb.php";
		$Da = "SELECT RP.CODIGOEMPL , IIF(RP.NOTA IS NULL, 0 , RP.NOTA) AS NOTAEMPL,
		IIF(C.TIPOUSUARIO = 1, 'Si', 'No') AS TIPOUSUARIO, RTRIM(MP.NOMBRE)+' '+RTRIM(MP.NOMBRE2)+' '+RTRIM(MP.APELLIDO)+' '+RTRIM(MP.APELLIDO2) AS NOMCAP
		FROM PALMERAS2013.dbo.MTEMPLEA MP 
		LEFT JOIN PLATCAPACITACIONES.dbo.REPROGRAMACION RP ON MP.CODIGO = RP.CODIGOEMPL 
		LEFT JOIN PLATCAPACITACIONES.dbo.Capacitaciones C ON MP.CODIGO = C.CODIGOEMPL 
		WHERE RP.NROPROG = $NROPROG AND RP.ESTADOEMPL = 1 AND C.REPROBADO = 3";

		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	//Nos retorna los valores ya registrados en la capacitacion seleccionada y los muestra en el form
	public function ProgModifacion($NROPROG)
	{
		include "con_palmerdb.php";
		return $Dat = odbc_exec($conexion, "SELECT Bitacora, CumpLegal, TFORM, CAPACITACION, CAPACITADOR, ANIO, MES, TP1.OPCION AS SUPTIPO, TP1.ID AS ID1, TP2.OPCION AS CATEGORIA, TP2.ID AS ID2, CANTIDADPROG
		FROM PLATCAPACITACIONES.dbo.Programacion P LEFT JOIN PLATCAPACITACIONES..OpcionesProgramacion TP1 ON TP1.ID = P.SUBTIPO AND TP1.TIPOOPCION = '2'
		LEFT JOIN PLATCAPACITACIONES..OpcionesProgramacion TP2 ON TP2.ID = P.CATEGORIA AND TP2.TIPOOPCION = '1'
		WHERE NROPROG = '$NROPROG'");
	}

	//Filtro de capacitaciones para buscar por empleados,codigo de costos
	public function ListFiltro($Filtro)
	{
		include "con_palmerdb.php";

		switch ($Filtro) {
			case 'CODALLEMP':
				$Da = "SELECT RTRIM(M.CODIGO) AS COD, CONCAT(RTRIM(M.NOMBRE), ' ', RTRIM(M.NOMBRE2), ' ', RTRIM(M.APELLIDO), ' ', RTRIM(M.APELLIDO2)) AS NOMB FROM PALMERAS2013.dbo.MTEMPLEA M";
				break;

			case 'CODLUGAR':
				$Da = "SELECT FINCACODI , FINCADESC FROM PALMERAS2013..FINCAS WHERE NOT FINCACODI IN ('12', '51', '71', '90' ,'91' ,'95' ,'96' ,'97')";
				break;
		}

		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	// Me trae todas las capacitaciones a las que pertenesca el nit

	public function ListCapCompletas($Filtrado)
	{
		include "con_palmerdb.php";

		$Da = "SELECT TP1.OPCION NCategoria, TP2.OPCION NSubtipo, P.Anio, P.Mes, P.NROPROG, IIF(P.TFORM = 1, 'Interna', 'Externa') AS TFORM, IIF(P.CumpLegal = 1, 'Sí', 'No') 
		AS Cumpleg, P.CAPACITACION, P.PRECIO, P.CANTIDADASIS, P.CAPACITADOR 
		FROM PLATCAPACITACIONES.dbo.Programacion P 
		INNER JOIN PLATCAPACITACIONES.dbo.Capacitaciones C ON C.NROPRGC = P.NROPROG 
		LEFT  JOIN PLATCAPACITACIONES.dbo.CalCapacitador L ON L.NROPROG = P.NROPROG 
		INNER JOIN PALMERAS2013.dbo.MTEMPLEA M ON M.CODIGO = C.CODIGOEMPL 
		LEFT JOIN PLATCAPACITACIONES..OpcionesProgramacion TP1 ON TP1.ID = P.CATEGORIA 
		LEFT JOIN PLATCAPACITACIONES..OpcionesProgramacion TP2 ON TP2.ID = P.SUBTIPO WHERE M.CODIGO LIKE '$Filtrado%' 
		GROUP BY TP1.OPCION, TP2.OPCION, P.NROPROG, P.TFORM, P.CumpLegal, P.CAPACITACION, P.PRECIO, P.CANTIDADASIS, P.CAPACITADOR, L.Nota, P.Anio, P.Mes order by P.Anio ASC ";

		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	public function ListCapCompletasTrim($Anio, $Trimestre, $CODIGO, $Categoria, $Subtipo, $Sexo, $COSTOCC)
	{
		include "con_palmerdb.php";


		if ($Subtipo == NULL or $Subtipo == '') {
			$sub = '';
		} else {
			$sub = ' P.CATEGORIA = ' . $Subtipo . ' AND ';
		}

		if ($Categoria == NULL or $Categoria == '') {
			$cat = '';
		} else {
			$cat = ' P.SUBTIPO = ' . $Categoria . ' AND ';
		}

		if ($CODIGO == NULL or $CODIGO == '') {
			$Cargo = '';
		} else {
			$Cargo = ' ME.CODCARGO = ' . $CODIGO . ' AND ';
		}

		if ($Sexo == NULL or $Sexo == '') {
			$VerSexo = '';
		} else {
			$VerSexo = " ME.SEXO = '$Sexo' AND ";
		}

		if ($COSTOCC == NULL or $COSTOCC == '') {
			$VerCC = '';
		} else {
			$VerCC = " SUBSTRING(ME.CODCC, 1 , 1) = '$COSTOCC' AND ";
		}

		if ($Trimestre == 1) {
			$Rango = 'P.ANIO = ' . $Anio . ' AND P.Mes IN (1, 2, 3) AND';
		} elseif ($Trimestre == 2) {
			$Rango = 'P.ANIO = ' . $Anio . ' AND P.Mes IN (4, 5, 6) AND';
		} elseif ($Trimestre == 3) {
			$Rango = 'P.ANIO = ' . $Anio . ' AND P.Mes IN (7, 8,  9) AND';
		} elseif ($Trimestre == 4) {
			$Rango = 'P.ANIO = ' . $Anio . ' AND P.Mes IN (10, 11, 12) AND';
		}

		$Da = "SELECT TP1.OPCION NCategoria, TP2.OPCION NSubtipo, P.NROPROG, P.ANIO, P.MES, IIF(TFORM = 1, 'Interna', 'Externa') AS TFORM, 
		IIF(P.CumpLegal = 1, 'Sí', 'No') AS Cumpleg, 
		p.CAPACITACION, TP1.OPCION AS SUBTIPO, TP2.OPCION AS CATEGORIA, 
		P.CAPACITADOR, P.CANTIDADPROG,P.CANTIDADASIS, ISNULL(Mujer.Cantidad, 0) Mujeres, ISNULL(Hombre.Cantidad, 0) Hombres, P.PRECIO
	FROM PLATCAPACITACIONES.dbo.Programacion P 
		INNER JOIN PLATCAPACITACIONES..Capacitaciones CP ON CP.NROPRGC = P.NROPROG
		INNER JOIN PLATCAPACITACIONES..OpcionesProgramacion TP1 ON TP1.ID = P.SUBTIPO --AND TP1.TIPOOPCION = '2'
		INNER JOIN PLATCAPACITACIONES..OpcionesProgramacion TP2 ON TP2.ID = P.CATEGORIA --AND TP2.TIPOOPCION = '1' 
		LEFT JOIN PALMERAS2013.dbo.MTPROCLI MP ON MP.NIT = P.CAPACITADOR 
		LEFT JOIN PALMERAS2013.dbo.MTEMPLEA ME ON ME.CODIGO = CP.CODIGOEMPL 
		LEFT JOIN PALMERAS2013.dbo.MTCARGOS MC ON MC.CODCARGO = ME.CODCARGO
		LEFT JOIN (
			SELECT 
				COUNT(M.SEXO) Cantidad, C.NROPRGC, M.SEXO
			FROM 
				PLATCAPACITACIONES..Capacitaciones C 
				INNER JOIN PALMERAS2013..MTEMPLEA M ON M.CODIGO = C.CODIGOEMPL	
			GROUP BY C.NROPRGC, M.SEXO
		) AS Mujer ON Mujer.NROPRGC = CP.NROPRGC AND Mujer.SEXO = 'F'
		LEFT JOIN (
			SELECT 
				COUNT(M.SEXO) Cantidad, C.NROPRGC, M.SEXO
			FROM 
				PLATCAPACITACIONES..Capacitaciones C 
				INNER JOIN PALMERAS2013..MTEMPLEA M ON M.CODIGO = C.CODIGOEMPL	
			GROUP BY C.NROPRGC, M.SEXO
		) AS Hombre ON Hombre.NROPRGC = CP.NROPRGC AND Hombre.SEXO = 'M'
	WHERE $Rango $Cargo $cat $sub $VerSexo $VerCC P.Estado = 1
	GROUP BY P.NROPROG, P.ANIO, P.MES, P.TFORM, P.CumpLegal, P.CAPACITACION, TP1.OPCION, TP2.OPCION, P.CAPACITADOR, P.CANTIDADPROG, P.CANTIDADASIS, P.PRECIO, TP1.OPCION, TP2.OPCION, mujer.Cantidad, Hombre.Cantidad";

		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	// Los tres tipos de estadisticas

	public function Estadisticas($TipoIndicador, $NROPROG)
	{
		include "con_palmerdb.php";
		switch ($TipoIndicador) {
			case 1:
				return $Dat = odbc_exec($conexion, "SELECT CANTIDADPROG FROM PLATCAPACITACIONES.dbo.Programacion WHERE NROPROG = $NROPROG");
				break;

			case 2:
				return $Dat = odbc_exec($conexion, "SELECT COUNT(*) AS Nro FROM PLATCAPACITACIONES.dbo.Capacitaciones WHERE NROPRGC = $NROPROG");
				break;

			case 3:
				return $Dat = odbc_exec($conexion, "SELECT COUNT(*) AS Nro FROM PLATCAPACITACIONES.dbo.Capacitaciones WHERE NROPRGC = $NROPROG AND APRUEBA >= 35.00");
				break;
		}
	}

	// Datos de la cabezera de cada capacitacion segun el usuario a consultar o la capacitacion

	public function CabCap($NROPROG)
	{
		include "con_palmerdb.php";
		return $Dat = odbc_exec($conexion, "SELECT P.Bitacora,TP1.OPCION AS SUBTIPO, TP2.OPCION AS CATEGORIA, P.CAPACITACION, CB.HINICIO, CB.HFINAL, DATEDIFF(MINUTE, CB.HINICIO, CB.HFINAL)/60 as DURACION,
		CB.FECHA, CB.LUGAR, P.CAPACITADOR, IIF(MP.NOMBRE IS NULL, ME.NOMBRE, MP.NOMBRE)  AS Capacit, IIF(P.TFORM = 1, 'Interna', 'Externa') AS TFORM,
		CB.DESCRIPCION, C.Nota, P.PRECIO 
		FROM PLATCAPACITACIONES.dbo.Programacion P 
		LEFT JOIN PLATCAPACITACIONES.dbo.CalCapacitador C ON C.NROPROG = P.NROPROG
		INNER JOIN PLATCAPACITACIONES.dbo.CabeceraCap CB ON CB.NROPROG = P.NROPROG 
		LEFT JOIN PALMERAS2013.dbo.MTEMPLEA ME ON ME.CODIGO = P.CAPACITADOR 
		LEFT JOIN PALMERAS2013.dbo.MTPROCLI MP ON MP.NIT = P.CAPACITADOR 
		LEFT JOIN PLATCAPACITACIONES..OpcionesProgramacion TP1 ON TP1.ID = P.SUBTIPO AND TP1.TIPOOPCION = '2'
		LEFT JOIN PLATCAPACITACIONES..OpcionesProgramacion TP2 ON TP2.ID = P.CATEGORIA AND TP2.TIPOOPCION = '1' WHERE P.NROPROG = '$NROPROG'");

		//Tener en cuenta y validar, cambiar los parametros de horas de TIME a DATETIME y hacer conversino a SECOND 
	}

	public function PartiCapac($NROPROG, $CODEMPLEADO)
	{
		include "con_palmerdb.php";

		if ($CODEMPLEADO == NULL or $CODEMPLEADO == '') {
			$Codempl = '';
		} else {
			$Codempl = "AND C.CODIGOEMPL = '$CODEMPLEADO'";
		}

		$Da = "SELECT CONCAT(RTRIM(M.NOMBRE), ' ', RTRIM(M.APELLIDO)) AS NOMBRE, CONCAT(RTRIM(M.NOMBRE), ' ', RTRIM(M.NOMBRE2), ' ', RTRIM(M.APELLIDO), ' ', RTRIM(M.APELLIDO2)) AS NOM, CARGO = (SELECT CARGO FROM PALMERAS2013..MTEMPLEA WHERE CEDULA = C.CODIGOEMPL AND YEAR(FECRETIRO) = 2100), M.CEDULA,M.CODIGO, M.SEXO, C.APRUEBA, C.Observaciones FROM PLATCAPACITACIONES.dbo.Programacion P INNER JOIN PLATCAPACITACIONES.dbo.Capacitaciones C ON C.NROPRGC = P.NROPROG LEFT JOIN PLATCAPACITACIONES.dbo.CalCapacitador L ON L.NROPROG = P.NROPROG LEFT JOIN PALMERAS2013.dbo.MTEMPLEA M ON M.CODIGO = C.CODIGOEMPL WHERE P.NROPROG = $NROPROG $Codempl";
		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	public function infoReprogEmpleado($NROPROG, $CODEMPLEADO)
	{
		include "con_palmerdb.php";

		$Da = "SELECT CONCAT(RTRIM(M.NOMBRE), ' ', RTRIM(M.NOMBRE2), ' ', RTRIM(M.APELLIDO), ' ', RTRIM(M.APELLIDO2)) AS NOMBRE, M.CARGO, M.CEDULA,M.CODIGO, RE.NOTA, RE.Observacion, RE.FECHAMOD
		FROM PLATCAPACITACIONES.dbo.Programacion P 
		INNER JOIN PLATCAPACITACIONES..REPROGRAMACION RE ON RE.NROPROG = P.NROPROG 
		INNER JOIN PALMERAS2013..MTEMPLEA M ON M.CODIGO = RE.CODIGOEMPL
		WHERE RE.NROPROG = '$NROPROG' AND RE.CODIGOEMPL = '$CODEMPLEADO'";
		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	public function validarBoton($NROPROG, $CODEMPLEADO)
	{
		include "con_palmerdb.php";
		return $Dat = odbc_exec($conexion, "SELECT COUNT(*) AS CANTIDAD FROM PLATCAPACITACIONES..REPROGRAMACION WHERE CODIGOEMPL = '$CODEMPLEADO' AND NROPROG = $NROPROG");
	}

	public function CalcularPrecio($NROPROG)
	{
		include "con_palmerdb.php";
		$TotalCap = 0;
		$Da = "SELECT C.CODIGOEMPL FROM PLATCAPACITACIONES.dbo.Capacitaciones C WHERE C.NROPRGC = $NROPROG";
		$Dat = odbc_exec($conexion, $Da);
		while ($llave = odbc_fetch_array($Dat)) {
			$codemp = $llave['CODIGOEMPL'];
			$Vh = "SELECT ME.VALORHORA FROM PALMERAS2013..MTEMPLEA ME WHERE ME.CODIGO = '$codemp'";
			$Dat2 = odbc_exec($conexion, $Vh);
			$ValorHora = odbc_result($Dat2, 'VALORHORA');
			$Dr = "SELECT DATEDIFF(HOUR, HINICIO, HFINAL) Tiempo FROM PLATCAPACITACIONES..CabeceraCap WHERE NROPROG = $NROPROG";
			$Dat3 = odbc_exec($conexion, $Dr);
			$Duracion = odbc_result($Dat3, 'Tiempo');
			$Valtot = $ValorHora * $Duracion;
			$TotalCap = $TotalCap + $Valtot;
		}
		return $TotalCap;
	}

	public function ValorHoraEmpleado($CODEMPLEADO)
	{
		include 'con_palmerdb.php';
		return odbc_result(odbc_exec($conexion, "SELECT ME.VALORHORA FROM PALMERAS2013..MTEMPLEA ME WHERE ME.CODIGO = '$CODEMPLEADO'"), 'VALORHORA');
	}


	public function EMPLREPROG($NROPROG)
	{
		include "con_palmerdb.php";

		$Da = "SELECT IIF(NOTA IS NULL, '0.0' , NOTA) AS NOTA, P.CAPACITACION,MTE.CODIGO, CONCAT(RTRIM(MTE.CODIGO), ' - ',RTRIM(MTE.NOMBRE), ' ', RTRIM(MTE.NOMBRE2), ' ', RTRIM(MTE.APELLIDO), ' ', RTRIM(MTE.APELLIDO2)) AS NOMBRE,
			RPG.NROPROG,RPG.Observacion, RPG.USUARIOCALIF
			FROM PLATCAPACITACIONES..REPROGRAMACION AS RPG 
			INNER JOIN PALMERAS2013..MTEMPLEA AS MTE ON MTE.CODIGO = RPG.CODIGOEMPL
			INNER JOIN PLATCAPACITACIONES..Programacion AS P ON P.NROPROG = RPG.NROPROG
			WHERE RPG.NROPROG = '$NROPROG' AND ESTADOEMPL = 1";
		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	public function CAPACITACIONESREPRO($añoInicial, $añofinal)
	{
		include "con_palmerdb.php";

		$Da = "SELECT P.CAPACITACION, P.CAPACITADOR,P.NROPROG,P.ANIO, P.MES, COUNT(RP.CODIGOEMPL) AS CANTIDAD FROM PLATCAPACITACIONES..REPROGRAMACION AS RP INNER JOIN PLATCAPACITACIONES..Programacion AS P ON RP.NROPROG = P.NROPROG
		WHERE RP.ESTADOEMPL = 1 AND RP.FECHAMOD BETWEEN '$añoInicial' AND '$añofinal' GROUP BY P.CAPACITACION, P.CAPACITADOR, P.NROPROG ,P.ANIO, P.MES";
		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	//index
	public function ClaseTotal($TotalPromedio)
	{

		if ($TotalPromedio <= 25) {
			$ClaseTotal = "card text-white bg-danger mb-3";
		} elseif ($TotalPromedio >= 26 and $TotalPromedio <= 50) {
			$ClaseTotal = "card text-white bg-warning mb-3";
		} elseif ($TotalPromedio >= 51 and $TotalPromedio <= 75) {
			$ClaseTotal = "card text-white bg-secondary mb-3";
		} elseif ($TotalPromedio >= 76) {
			$ClaseTotal = "card text-white bg-success mb-3";
		}

		return $ClaseTotal;
	}

	public function EstaGeneral($TipoIndicador, $Anio, $Mes)
	{
		include "con_palmerdb.php";
		switch ($TipoIndicador) {
			case 1:
				return $Dat = odbc_exec($conexion, "SELECT SUM(CANTIDADPROG) AS TOTALPROG FROM PLATCAPACITACIONES.dbo.Programacion WHERE ANIO = $Anio and MES = $Mes");
				break;

			case 2:
				return $Dat = odbc_exec($conexion, "SELECT SUM(CANTIDADASIS) AS CANTIDADASIS FROM PLATCAPACITACIONES.dbo.Programacion P WHERE ANIO = $Anio and MES = $Mes");
				break;

			case 3:
				return $Dat = odbc_exec($conexion, "SELECT AVG(APRUEBA) PROM FROM PLATCAPACITACIONES..Capacitaciones WHERE NROPRGC IN (SELECT DISTINCT NROPROG FROM PLATCAPACITACIONES.dbo.Programacion P WHERE ANIO = $Anio and MES = $Mes AND CATEGORIA = 1)");
				break;

			case 4:
				$Prog = odbc_exec($conexion, "SELECT COUNT(P.NROPROG) Uno FROM PLATCAPACITACIONES..Programacion P WHERE ANIO = $Anio and MES = $Mes ");
				$Progp = odbc_result($Prog, 'Uno');


				$Cap = odbc_exec($conexion, "SELECT DISTINCT C.NROPRGC Dos FROM PLATCAPACITACIONES..Programacion P LEFT JOIN PLATCAPACITACIONES..Capacitaciones C ON P.NROPROG = C.NROPRGC WHERE ANIO = $Anio and MES = $Mes ");
				$Capp = odbc_num_rows($Cap);

				$Resultado = ($Progp == 0 or $Capp == 0) ? 0 : ($Progp / $Capp) * 100;

				return $Datos[] = array($Progp, $Capp, $Resultado);

				break;
		}
	}

	public function DashBoard($Anio, $Mes)
	{
		include "con_palmerdb.php";
		$nDatos[] = array('CC Mayor', 'Cantidad');
		$Da = "SELECT COUNT(CP.CODIGOEMPL) AS Cantidad, SUBSTRING(rtrim(MT.CODCC), 1, 1) AS CCMayor, IIF(RTRIM(CC.NOMBRE) = 'ADMINISTRACION', 'ADMON', RTRIM(CC.NOMBRE)) AS CC FROM PLATCAPACITACIONES.dbo.Capacitaciones CP INNER JOIN PALMERAS2013.dbo.MTEMPLEA MT ON MT.CODIGO = CP.CODIGOEMPL INNER JOIN PALMERAS2013.dbo.CENTCOS CC ON CC.CODCC = SUBSTRING(rtrim(MT.CODCC), 1, 1) WHERE CP.NROPRGC IN (SELECT P.NROPROG AS Tot FROM PLATCAPACITACIONES.dbo.Programacion P WHERE P.ANIO = $Anio AND P.Mes = $Mes) GROUP BY SUBSTRING(rtrim(MT.CODCC), 1, 1), RTRIM(CC.NOMBRE)";
		$Dat = odbc_exec($conexion, $Da);
		$ndatos = odbc_num_rows($Dat);
		if ($ndatos != 0) {
			while ($Dos = odbc_fetch_array($Dat)) {
				$arr[] = $Dos;
			}
			foreach ($arr as $in) {
				$nDatos[] = array($in['CC'], intval($in['Cantidad']));
			}
		}
		return $nDatos;
	}

	// Maestros
	public function DetalleCentroMayor($Anio, $Trimestre)
	{
		include "con_palmerdb.php";

		if ($Trimestre == 1) {
			$Rango = 'AND P.ANIO = ' . $Anio . ' AND P.Mes IN (1, 2, 3)';
		} elseif ($Trimestre == 2) {
			$Rango = 'AND P.ANIO = ' . $Anio . ' AND P.Mes IN (4, 5, 6)';
		} elseif ($Trimestre == 3) {
			$Rango = 'AND P.ANIO = ' . $Anio . ' AND P.Mes IN (7, 8,  9)';
		} elseif ($Trimestre == 4) {
			$Rango = 'AND P.ANIO = ' . $Anio . ' AND P.Mes IN (10, 11, 12)';
		}

		$nDatos[] = array('CC Mayor', 'Personas');
		$Da = "SELECT COUNT(CP.CODIGOEMPL) AS Cantidad, SUBSTRING(rtrim(MT.CODCC), 1, 1) AS CCMayor, IIF(RTRIM(CC.NOMBRE) = 'ADMINISTRACION', 'ADMON', RTRIM(CC.NOMBRE)) AS CC FROM PLATCAPACITACIONES.dbo.Capacitaciones CP  INNER JOIN PALMERAS2013.dbo.MTEMPLEA MT ON MT.CODIGO = CP.CODIGOEMPL INNER JOIN PALMERAS2013.dbo.CENTCOS CC ON CC.CODCC = SUBSTRING(rtrim(MT.CODCC), 1, 1) WHERE CP.NROPRGC IN (SELECT P.NROPROG AS Tot FROM PLATCAPACITACIONES.dbo.Programacion P WHERE P.ANIO = $Anio $Rango) GROUP BY SUBSTRING(rtrim(MT.CODCC), 1, 1), RTRIM(CC.NOMBRE) ";
		$Dat = odbc_exec($conexion, $Da);
		$ndatos = odbc_num_rows($Dat);
		if ($ndatos != 0) {
			while ($Dos = odbc_fetch_array($Dat)) {
				$arr[] = $Dos;
			}
			foreach ($arr as $in) {
				$nDatos[] = array($in['CC'], intval($in['Cantidad']));
			}
		}

		return $nDatos;
	}

	public function NumCapact($Estado, $Trimestre, $Anio)
	{
		include "con_palmerdb.php";

		if ($Trimestre == 1) {
			$Rango = 'AND P.ANIO = ' . $Anio . ' AND P.Mes IN (1, 2, 3)';
		} elseif ($Trimestre == 2) {
			$Rango = 'AND P.ANIO = ' . $Anio . ' AND P.Mes IN (4, 5, 6)';
		} elseif ($Trimestre == 3) {
			$Rango = 'AND P.ANIO = ' . $Anio . ' AND P.Mes IN (7, 8,  9)';
		} elseif ($Trimestre == 4) {
			$Rango = 'AND P.ANIO = ' . $Anio . ' AND P.Mes IN (10, 11, 12)';
		}

		$Dat = odbc_exec($conexion, "SELECT COUNT(P.NROPROG) AS Tot FROM PLATCAPACITACIONES.dbo.Programacion P WHERE Estado = $Estado $Rango");
		return odbc_result($Dat, 'Tot');
	}

	public function generarExcelProgramaciones($fecha1, $fecha2)
	{
		include "con_palmerdb.php";

		$Da = "SELECT
			P.NROPROG, P.FECHA, P.CANTIDADPROG, P.CANTIDADASIS, P.CAPACITACION, P.CAPACITADOR, P.ANIO, P.MES, IIF(TP2.OPCION IS NULL,'Sin datos',TP2.OPCION) AS CATEGORIA, IIF(TP1.OPCION IS NULL,'Sin datos',TP1.OPCION) AS SUBTIPO, IIF(CB.LUGAR IS NULL,'Sin datos',CB.LUGAR) AS LUGAR, IIF(CB.FECHA IS NULL,'Sin datos',CONVERT(VARCHAR,CB.FECHA,23)) AS FECHAEVENT, IIF(CB.DESCRIPCION IS NULL,'Sin datos',CB.DESCRIPCION) AS DESCRIPCION, IIF(TFORM = 1, 'Interna', 'Externa') AS TFORM, 
			IIF(P.CumpLegal = 1, 'Sí', 'No') AS Cumpleg, CONCAT(P.CAPACITADOR,' - ',IIF(RTRIM(MP.NOMBRE) IS NULL, IIF(RTRIM(ME.NOMBRE) = 0, CONCAT(RTRIM(ME.NOMBRE), ' ', RTRIM(ME.NOMBRE2), ' ', RTRIM(ME.APELLIDO), ' ', RTRIM(ME.APELLIDO2)), 'CAPACITADOR EXTERNO'), RTRIM(MP.NOMBRE))) AS CAPACITADORNOM, CB.HINICIO, CB.HFINAL, DATEDIFF(MINUTE, CB.HINICIO, CB.HFINAL) DURACION, 
			
			FEMENINO = (SELECT COUNT(case when ME.SEXO = 'F' then 1 end) FROM PALMERAS2013..MTEMPLEA ME LEFT JOIN PLATCAPACITACIONES.dbo.Capacitaciones Cap ON Cap.CODIGOEMPL = ME.CODIGO INNER JOIN PLATCAPACITACIONES.dbo.Programacion Pi ON Cap.NROPRGC = Pi.NROPROG WHERE Pi.NROPROG = P.NROPROG),

			MASCULINO = (SELECT COUNT(case when ME.SEXO = 'M' then 1 end) FROM PALMERAS2013..MTEMPLEA ME LEFT JOIN PLATCAPACITACIONES.dbo.Capacitaciones Cap ON Cap.CODIGOEMPL = ME.CODIGO INNER JOIN PLATCAPACITACIONES.dbo.Programacion Pi ON Cap.NROPRGC = Pi.NROPROG WHERE Pi.NROPROG = P.NROPROG),
			CAP.CODIGOEMPL AS CEDULA, APRUEBA, IIF(EM.NOMBRE IS NULL, 'CEDULA INCORRECTA', CONCAT(LTRIM(RTRIM(EM.NOMBRE)), ' ', LTRIM(RTRIM(EM.APELLIDO)), ' ', LTRIM(RTRIM(EM.APELLIDO2)))) AS NOMBRE_COMPLETO,  IIF(EM.NOMBRE IS NULL, 'CEDULA INCORRECTA', EM.SEXO) SEXO 
		FROM PLATCAPACITACIONES.dbo.Programacion P 
			LEFT JOIN PLATCAPACITACIONES..Capacitaciones as cap on p.NROPROG = cap.NROPRGC
			LEFT JOIN PLATCAPACITACIONES..OpcionesProgramacion TP1 ON TP1.ID = P.SUBTIPO
			LEFT JOIN PLATCAPACITACIONES..OpcionesProgramacion TP2 ON TP2.ID = P.CATEGORIA
			LEFT JOIN PALMERAS2013.dbo.MTPROCLI MP ON MP.NIT = P.CAPACITADOR
			LEFT JOIN PALMERAS2013.dbo.MTEMPLEA ME ON ME.CODIGO = P.CAPACITACION 
			LEFT JOIN PALMERAS2013.dbo.MTEMPLEA EM ON CAP.CODIGOEMPL = EM.CODIGO 
			LEFT JOIN PLATCAPACITACIONES..CabeceraCap CB ON CB.NROPROG = P.NROPROG
		WHERE P.FECHA BETWEEN '$fecha1' AND '$fecha2'";
		
		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}


	public function ListMaestrosT()
	{
		include "con_palmerdb.php";
		$Da = "SELECT  [ID] ,[OPCION] ,[TIPOOPCION] FROM [PLATCAPACITACIONES].[dbo].[OpcionesProgramacion] WHERE TIPOOPCION = '1'";

		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}

	public function ListMaestrosC()
	{
		include "con_palmerdb.php";
		$Da = "SELECT  [ID] ,[OPCION] ,[TIPOOPCION] FROM [PLATCAPACITACIONES].[dbo].[OpcionesProgramacion] WHERE TIPOOPCION = '2'";

		$Dat = odbc_exec($conexion, $Da);
		while ($Dos = odbc_fetch_array($Dat)) {
			$arr[] = $Dos;
		}
		return $arr;
	}
} // Cierre de la clase principal