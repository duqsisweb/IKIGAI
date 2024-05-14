<?php
session_start();
require 'funcionalidades.php';
$Func = new Funciones;

if (isset($_SESSION['usuario'])) {


    if (isset($_POST['reprogCap'])) {
        include("con_palmerdb.php");
        $cantidad = $_POST['cantidad'];
        $NROPROG = $_POST['CAPACITACION'];
        $fecha = $_POST['fecha'];

        for ($i = 1; $i <= $cantidad; $i++) {
            $COD = $_POST['cod'.$i];

            echo $COD;
            echo $fecha;

            $QryPrg3="UPDATE PLATCAPACITACIONES..REPROGRAMACION SET FECHAMOD = '$fecha' WHERE CODIGOEMPL = '$COD' AND NROPROG = $NROPROG AND ESTADOEMPL = 1";
            odbc_exec($conexion, $QryPrg3);  
        }
    ?>
        <script>
			setTimeout(function() {
				window.close();
			}, 500);
			alert("Se califico exitosamente la capacitacion");
		</script>

    <?php } else { ?>
		<script>
			alert("ocurrido un error");
		</script>
	<?php } ?>

<?php } else { ?>
	<script>
		alert("Acceso Incorrecto");
		window.location.href = "../login.php";
	</script>
<?php } ?>