<?php
include '../con_palmerdb.php';
session_start();
$usu = $_SESSION['usuario'];

if (isset($_POST['dataToSend'])) {
    $NROPROG = $_POST['NROPROG'];
    $usu = $_POST['usu'];
    $dataToSend = $_POST['dataToSend'];

    $AnioHidden = $_POST['AnioHidden'];
    $LinkDriveHidden = $_POST['LinkDriveHidden'];
    $MesHidden = $_POST['MesHidden'];
    $CapacitacionHidden = $_POST['CapacitacionHidden'];
    $CategoriaHidden = $_POST['CategoriaHidden'];
    $CapacitadorHidden = $_POST['CapacitadorHidden'];
    $TemaHidden = $_POST['TemaHidden'];
    $CANTPROGRAMADOSHidden = $_POST['CANTPROGRAMADOSHidden'];
    $NROPROG = $_POST['NROPROG'];


    // Itera sobre los datos y realiza la validación y el INSERT si es necesario
    foreach ($dataToSend as $row) {
        $centroCosto = $row['centroCosto'];
        $cargo = $row['cargo'];
        $nombre = $row['nombre'];
        $tipoInvitacion = $row['tipoInvitacion'];

        // Realiza una consulta para verificar si el registro ya existe
        $queryExistencia = "SELECT CODIGOEMPL FROM PLATCAPACITACIONES.dbo.Capacitaciones WHERE NROPRGC = '$NROPROG' AND CODIGOEMPL = '$nombre'";
        $resultExistencia = odbc_exec($conexion, $queryExistencia);

        if (odbc_fetch_row($resultExistencia)) {
            // El registro ya existe, puedes manejarlo como desees, por ejemplo, mostrar un mensaje de error
            echo "El registro para $nombre ya existe. No se realizará la inscripcion.";
        } else {
            // El registro no existe, realiza el INSERT
            if (!empty($nombre)) {
                // Realiza la inserción
                $QryPrg = "INSERT INTO PLATCAPACITACIONES.dbo.Capacitaciones (NROPRGC, CODIGOEMPL, APRUEBA, Observaciones, FECCARGA, USUARIO, TIPOUSUARIO, ESTADOASIS, REPROBADO) 
                            VALUES ('$NROPROG', '$nombre', NULL, 'No tiene observación', GETDATE(), '$usu', '$tipoInvitacion', 2, 2)";
                $Dato = odbc_exec($conexion, $QryPrg);
            } else {
                echo "El valor de nombre es inválido.";
            }
        }
    }




    $queryUpdate = "UPDATE PLATCAPACITACIONES.dbo.Programacion SET 
    Anio = '$AnioHidden',
    Bitacora = '$LinkDriveHidden',
    Mes = '$MesHidden',
    Capacitacion = '$CapacitacionHidden',
    CATEGORIA = '$CategoriaHidden',
    SUBTIPO = '$TemaHidden',
    CAPACITADOR = '$CapacitadorHidden',
    CANTIDADPROG = '$CANTPROGRAMADOSHidden'
    WHERE NROPROG = '$NROPROG'";

    $ResultUpdate = odbc_exec($conexion, $queryUpdate);

    // Verificar si la actualización fue exitosa
    if ($ResultUpdate) {
        echo "Actualización realizada con éxito.";
    } else {
        echo "Error en la actualización.";
    }
}
