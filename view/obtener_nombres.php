<?php
require '../Funciones/funcionalidades.php';
$Func = new Funciones;

if (isset($_GET['cargo'])) {
    $selectedCargo = $_GET['cargo'];
    $nombres = $Func->ListEMPL($selectedCargo);

    echo '<option value="">Seleccione Nombre</option>';

    foreach ($nombres as $nombre) {
        $codigo = trim($nombre['CODIGO']);
         echo '<option value="' . $codigo . '">' .utf8_encode($nombre['NOMBRE']) . '</option>';
    }
}
?>