<?php
	require '../Funciones/funcionalidades.php';
	$Func = new Funciones;
if (isset($_GET['costo'])) {
    $selectedCosto = $_GET['costo'];
    $cargos = $Func->ListCargo($selectedCosto);

    echo '<option value="">Seleccione Cargo</option>';

    // Generar las opciones de "Cargo" basadas en la consulta
    foreach ($cargos as $cargo) {
        echo '<option value="' . $cargo['CODCARGO'] . '">' . $cargo['CARGO'] . '</option>';
    }
}
?>