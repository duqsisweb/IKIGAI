<?php

header('Content-Type: text/html; charset=UTF-8');

session_start();
if (isset($_SESSION['usuario'])) {
    require 'header.php';
    require 'footer.php';
    include '../con_palmerdb.php';
?>

    <div class="container">
        <div class="text-right mt-5">
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-group list-group-horizontal">
                        <a style="text-decoration:none" href="index.php">
                            <li class="list-group-item list-group-item-success">Menú principal</li>
                        </a>
                        <li class="list-group-item list-group-item">Subir programación</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="text-right mt-5">
            <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>

                <div class="col-md-12">
                    <h3 align="center">Subir programación</h3>
                </div>

                <div class="col-md-12">
                    <hr>
                    <?php
                    include '../con_palmerdb.php';
                    $Serial = "SELECT TOP 1 [NROPROG] FROM [PLATCAPACITACIONES].[dbo].[Programacion] ORDER BY NROPROG DESC";
                    $resultado = odbc_exec($conexion, $Serial);

                    // Comprueba si la consulta fue exitosa
                    if ($resultado) {
                        // Obtiene los datos como un array asociativo
                        $fila = odbc_fetch_array($resultado);

                        // Imprime el valor de NROPROG
                        if ($fila) {
                            echo  " <strong> Último ID programación: <strong> " . $fila['NROPROG'];
                        } else {
                            echo "No se encontraron resultados";
                        }
                    } else {
                        echo "Error en la consulta SQL";
                    }
                    ?>

                    <br>
                </div>

                <div class="col-md-12">
                    <form action="../Funciones/upprogramacion.php" method="POST" class="form-register" enctype="multipart/form-data">
                        <div class="mb-3">
                            <h4><label class="form-label">Por favor, seleccione el archivo en cuestión</label></h4>
                            <input accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="form-control" type="file" name='archivo' required>
                        </div>
                        <br>
                        <div class="form-group">
                            <center><input name="EnviarDocumento" style="width: 100%" class="btn btn-success" type="submit" value="¡Cargar Información!" /></center>
                        </div>
                    </form>
                </div>

                <div class="col-md-12">
                    <hr>
                    <br>
                </div>

                <div class="col-md-12">
                    <div class="mb-3">
                        <h4 align="center"><label class="form-label">¡Descargar Maqueta!</label></h4>
                        <form method="get" action="../Maqueta/PLANTILLA-MAESTROSIKIGAI.xlsx">
                            <center><button style="width: 100%" class="btn btn-primary" type="submit">¡Descarga la maqueta aquí!</button></center>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php } else {
?><script languaje "JavaScript">
        alert("Acceso Incorrecto");
        window.location.href = "../login.php";
    </script><?php
            }
