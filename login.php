
<?php 
header('Content-Type: text/html; charset=UTF-8');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Plataforma de capacitaciones para Gestion Humana" />
    <meta name="author" content="José Luis Casilimas Martinez" />
    <title>Ikigai</title> 
    <link rel="icon" type="image/x-icon" href="assets/Icono.ico" /> 
    <link href="css/stylesLogin.css" rel="stylesheet" />
</head>

<body>
    <div class="containerLogin">
        <div class="containerLogo">
            <img src="./imagenes/Gestión_humana-removebg-preview.png">
        </div>

        <div class="containerForm">
            <div class="tituloBienvenidos"><strong>¡BIENVENIDOS A IKIGAI!</strong></div>
                <div class="formularioLogin">
                    <form autocomplete="off" action="aute.php" method="POST">
                        <label class="labelOne">Usuario</label>
                        <input name= "usuario" class="inputLogin" type="text" placeholder="Ingrese su usuario" required>

                        <label class="labelTwo">Contraseña</label>
                        <input name="password" class="inputLogin" type="password" placeholder="Ingrese su contraseña" required>
                        <input type="submit" name="login" class="btnLogin" value="Ingresar"/>
                    </form> 
                </div>
            </div>
        </div>
    </div> 
</body>

</html>