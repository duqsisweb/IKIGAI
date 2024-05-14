<?php
header('Content-Type: text/html; charset=UTF-8');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Plataforma de capacitaciones para Gestion Humana" />
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
    <meta name="author" content="José Luis Casilimas Martinez" /> 
    <title>Ikigai</title> 
    <link rel="icon" type="image/x-icon" href="../assets/Icono.ico" /> 
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
    <!-- <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="../vendor/jquery-easingy/jquery.min.js"></script> -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
    <!-- <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>  -->
    <script src="../vendor/chart.js/Chart.min.js"></script>
    <script src="../vendor/datatables/jquery.dataTables.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.js"></script> 
    <script src="../js/sb-admin.min.js"></script> 
    <script src="../js/sb-admin-datatables.min.js"></script>
    <script src="../js/sb-admin-charts.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>



    <!-- SUM()  Datatables-->
    <script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>

    <!-- para exportar documentos -->
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet" />



    

    <style>
        .dropbtn { background-color: #4CAF50; color: white; padding: 0px; font-size: 16px; border: none; cursor: pointer; }
        .dropdown { position: relative; display: inline-block; }
        .dropdown-content { display: none; position: absolute; background-color: #198754; min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1;}
        .dropdown-content a { color: black; padding: 12px 16px; text-decoration: none; display: block; z-index: 1;}
        .dropdown-content a:hover {background-color: #76CDA4}
        .dropdown:hover .dropdown-content { display: block; }
        .dropdown:hover .dropbtn { background-color: #76CDA4; }
    </style>
</head>
<body> 

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a href="index.php" class="navbar-brand">Ikigai</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-3 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Inicio</a></li>
                <div class="dropdown"><li class="nav-item"><a class="nav-link active" aria-current="page">Cargar información</a></li>
                    <div class="dropdown-content">
                        <a href="upinformacion.php"><font color="white">Programación</font></a>
                        <a href="upcapacitacion.php"><font color="white">Capacitaciones</font></a>
                        <a href="reprogramacion.php"><font color="white">Reprogramación</font></a>
                    </div>
                </div>
                <div class="dropdown"><li class="nav-item"><a class="nav-link active" aria-current="page">Ver información</a></li>
                    <div class="dropdown-content">
                        <a href="dwprogramacion.php"><font color="white">Programación</font></a>
                        <a href="dwinformacionGeneral.php"><font color="white">Capacitaciones General</font></a>
                        <a href="dwinformacion.php"><font color="white">Capacitaciones Empleado</font></a>
                        <a href="maestros.php"><font color="white">Maestros</font></a>
                        <a href="downExcel.php"><font color="white">Descargar información</font></a>
                    </div>
                </div>
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="../logout.php"><i class="fa fa-fw fa-sign-out"></i><strong>Salir</strong></a></li>
                
            </ul>
        </div>
    </div>
</nav> 

