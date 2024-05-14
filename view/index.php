<?php

header('Content-Type: text/html; charset=UTF-8');

error_reporting(0);
session_start();
date_default_timezone_set('America/Bogota');

if (isset($_SESSION['usuario'])) {
  require 'header.php';
  require 'footer.php';
  require '../Funciones/funcionalidades.php';
  $Func = new Funciones;

  if (!isset($_GET['dashboard'])) {
    $Anio = DATE("Y");
    $Mes = DATE("m");
  } else {
    $Anio = $_GET['Anio'];
    $Mes = $_GET['Mes'];
  }
  /*Barras*/
  $Barras = $Func->DashBoard($Anio, $Mes);


?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
    var DatoJST = <?php echo json_encode($Barras); ?>

    google.charts.load('current', {
      'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable(DatoJST);
      var options = {
        chart: {
          title: 'Graficacion de resultados del año <?php echo $Anio ?> y mes <?php echo $Func->ListMeses(2, $Mes) ?>',
          subtitle: 'Reporte generado a las <?php echo DATE("Y-m-d H:i:s") ?>',
        },

        colors: ['#198754']
      };

      var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
      chart.draw(data, google.charts.Bar.convertOptions(options));
    }
  </script>

  <div class="container">
    <div class="text-right mt-5">
      <div class="row">
        <div class="col-md-12">
          <ul class="list-group list-group-horizontal">
            <li class="list-group-item list-group-item-success">Menú principal</li>
            <?php if (isset($_GET['dashboard'])) { ?>
              <li class="list-group-item ">Resultados para <strong><?php echo $Anio ?></strong> y mes <strong><?php echo $Func->ListMeses(2, $Mes) ?></strong></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <form method="GET">
    <div class="container">
      <div class="row">
        <div class="col-md-12"><br></div>


        <!-- se corriguen los campos de fechas año y mes , cuand ose haga la consulta los datos queden alli  -->
        <div class="col-md-1" align="right">
          <div class="form-group">
            <label>Año <font color="red"><strong>*</strong></font> </label>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <select list="Anio" class="form-control" type="text" name="Anio" required>
              <?php for ($i = 2022; $i <= Date("Y"); $i++) {
                $selected = ($_GET['Anio'] == $i) ? 'selected' : '';
                echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
              } ?>
            </select>

          </div>
        </div>

        <div class="col-md-1" align="right">
          <div class="form-group">
            <label>Mes <font color="red"><strong>*</strong></font> </label>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <select list="Mes" class="form-control" type="text" name="Mes" required>
              <option></option>
              <?php foreach ($Func->ListMeses(1, 0) as $admon) {
                $selected = ($_GET['Mes'] == $admon['Mes']) ? 'selected' : '';
                echo '<option value="' . $admon['Mes'] . '" ' . $selected . '>' . $admon['NombMes'] . '</option>';
              } ?>
            </select>
          </div>
        </div>

        <div class="col-md-4">
          <center><input name="dashboard" style="width: 100%" class="btn btn-success" type="submit" value="Cargar Dashboard" /></center>
        </div>
      </div>
    </div>
  </form>

  <div class="container">
    <div class="row">
      <div class="col-md-12"><br></div>


      <?php
      $Programados = odbc_result($Func->EstaGeneral(1, $Anio, $Mes), 'TOTALPROG');
      $Asistidos = odbc_result($Func->EstaGeneral(2, $Anio, $Mes), 'CANTIDADASIS');
      $Eficacia = odbc_result($Func->EstaGeneral(3, $Anio, $Mes), 'Prom');
      $Cob = $Func->EstaGeneral(4, $Anio, $Mes);
      $NroProg = $Cob[0];
      $NroPLlv = $Cob[1];
      $Cobertura = $Cob[2];

      $porCumplimiento = ($NroProg == 0 OR $NroPLlv == 0 ) ? 0 : ($NroProg/$NroPLlv) * 100;
      $porCobertura = ($Programados == 0 OR $Asistidos == 0 ) ? 0 : ($Programados/$Asistidos) * 100;
      $porEficacia = ($Eficacia == 0) ? 0 : ($Eficacia / 5) * 100;
      $TotalPromedio = ($porCumplimiento + $porEficacia + $porCobertura) / 3;
      $ClaseTotal = $Func->ClaseTotal($TotalPromedio); ?>

      <div class="col-md-3">
        <div class="card text-white bg-success mb-3" style="max-width: 100%;">
          <div class="card-header" align="center">Cumplimiento</div>
          <div class="card-body">Se agenda <strong><?php echo round($NroProg, 0) ?></strong> encuentros, de los cuales <strong><?php echo round($NroPLlv, 0) ?></strong> se llevaron a cabo. Obteniendo un <strong><?php echo round($porCumplimiento, 0) ?>%</strong> de cumplimiento.
          </div>
        </div>
      </div>


      <div class="col-md-3">
        <div class="card text-white bg-success mb-3" style="max-width: 100%;">
          <div class="card-header" align="center">Cobertura</div>
          <div class="card-body">Personas programadas: <strong><?php echo round($Programados, 0) ?><br></strong> Personas que asistieron: <strong><?php echo round($Asistidos, 0) ?></strong>, para una cobertura de <strong><?php echo round($porCobertura, 0) ?>%.</strong>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-white bg-success mb-3" style="max-width: 100%;">
          <div class="card-header" align="center">Eficacia</div>
          <div class="card-body">La capacitacion tuvo una calificacion promedio de <strong><?php echo round($Eficacia, 2) ?></strong>, significando un <strong><?php echo round($porEficacia, 0) ?>%</strong> (Sobre 5.0) de eficacia.
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="<?php echo $ClaseTotal; ?>" style="max-width: 100%;">
          <div class="card-header" align="center">Nota</div>
          <div class="card-body" align="center">
            <h1><strong><?php echo round($Eficacia, 2) ?></strong></h1>
          </div>
        </div>
      </div>
    </div>


    <div class="col-md-12">
      <div id="columnchart_material" style="width: 100%; height: 400px;"></div>
    </div>

    <div class="col-md-12"><br></div>

  </div>
  </div>


<?php } else {
  ?><script languaje "JavaScript">
    alert("Acceso Incorrecto");
    window.location.href = "../login.php";
  </script><?php
}
