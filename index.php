<?php
 
session_start();
 
spl_autoload_register(function($clase) {
    require "$clase.php";
});
$men=  filter_input(INPUT_GET, 'mensaje');
$usuario = $_SESSION['usuario'];
$password = $_SESSION['password'];
if(isset($_SESSION['usuario'])){
    $disabled='disabled';//si la sesión esta iniciada no se puede
    //rellenar el campo usuario, y aparecera el nombre del actual
    //usuario de sesión
}

 
?> 


<!DOCTYPE html>
<!--
 
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <!-- lo primero que aparece en la página es si la sesión esta iniciada y quien es el usuario-->
        <?= Autorizacion::casillaIdentificacion($usuario) ?>
        <h2>Subida de ficheros</h2>
        <form name="practica" action= 'descarga.php' method="POST" enctype="multipart/form-data" >
            Usuario<input type="text" name="usuario" value='<?=$usuario?>' <?=$disabled ?>/><br />
            Password<input type="text" name="pass" value="" /><br >
            <input type="file" name="seleccionaFichero"   /><br />
            <input type="submit" value="SubirFicheroAcceder" name="submit"/><br />
            <input type="submit" value="SubirFichero" name="submit" />
            <input type="submit" value="Acceder" name="submit" />
            <input type="submit" value="CerrarSesion" name="submit">

        </form>
        <h3><?php echo $men?></h3>
    </body>
</html>
