<?php
if (isset($_POST['programacion']) && !empty($_POST['programacion'])) {
    $programacion = $_POST['programacion'];

    // Aquí debes escribir el código para insertar los datos en la base de datos
    // Utiliza las variables $programacion para acceder a los datos de cada fila

    // Ejemplo de cómo puedes acceder a los datos:
    foreach ($programacion as $row) {
        $centroCosto = $row['centroCosto'];
        $cargo = $row['cargo'];
        $nombre = $row['nombre'];
        $tipoInvitacion = $row['tipoInvitacion'];

        // Realiza la inserción en la base de datos
        // ...

        // Puedes imprimir un mensaje de éxito o cualquier otra respuesta aquí
    }
}
?>