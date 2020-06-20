

<?php
session_start();
            
            
spl_autoload_register(function($clase) {
    require "$clase.php";
});

$msj = "Intruduce los datos que se solicitan";//l mensaje inicial que aparece en el index para
//pedir los datos
            

if (isset($_POST['submit'])) {
    $descarga = Directorio::crearDirectorioPrincipal('descarga');//Lo primero si no existe creo el directorio
    Directorio::crearEstructuraFicheros(Directorio::crearDirectorioPrincipal("$descarga/donwload"));
    Directorio:: crearEstructuraFicheros(Directorio::crearDirectorioPrincipal("$descarga/upload"));
    if (!isset($_SESSION['usuario']) || !isset($_SESSION['password'])) {//si no existe la sesión
        //recojo los datos en el index y la creo
        $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
        $_SESSION['usuario'] = $usuario;
        $_SESSION['password'] = $password;
    } else {//si existe
        $usuario = $_SESSION['usuario'];
        $password = $_SESSION['password'];
    }
    $fichero = $_FILES['seleccionaFichero'];//selecciono el fichero
    //toda la descripcion del fichero//
    $ficheroTrabajo = new GestionFicheros($fichero);//creo un objeto GestionFicheros
    $tipoUsuario = Autorizacion::clasificarUsuarios($usuario, $password);//clasificio el 
    //tipo de usuario que es
    if ($tipoUsuario == "usuario_no_valido") {
        header("Location:index.php?mensaje=Introduce un usuario y contraseña");
        session_destroy();//si falta algún dato me quedo en index
        exit();
    } else {

        $base = "./descarga/upload";//para admin y demás usuarios creo una direccion
        //base luego elegire los diferentes destinos
        //a partir de aquí cada botón realiza su función acudiendo a los
        //métodos de la clase GestionFicheros, el boton Acceder no realiza ninguna acción
        //mas allá de ir a la página descargas.php
        switch ($_POST['submit']) {
            case 'SubirFichero':
                $ficheroTrabajo->subirFichero($base);
                break;
            case 'SubirFicheroAcceder':
                $estado=$ficheroTrabajo->subirFicheroAcceder($base);
                break;
            
            case 'Subir':
                $estado = GestionFicheros::seleccionarFicheros($base);
                break;
            case 'CerrarSesion':
                session_destroy();
                header("Location:index.php?mensaje=Se ha cerrado la sesion");
                exit();
                break;
            default:
                break;
        }//log donde guardo la información
        Log::ficherolog($usuario, $password, $ficheroTrabajo->getNombre(),'subido');
        
        //a partir de aquí gestiono lo que se muestra en pantalla
        if ($tipoUsuario === "admin") {//si el tipo de usuario es admin la variable
            //$lista contiene el formulario con el checkbox con los archivos a subir, 
            
            $lista = GestionFicheros::formularioSubir($base);
        }
    }
    //y estos son los ficheros ya ordenados y listos para ejecutar que visualizarán
    //todos los usuarios.
   $listaMusicaD = GestionFicheros::imprimir_ficheros_pantalla('musica');
   $listaImagenesD = GestionFicheros::imprimir_ficheros_pantalla('imagenes');
   $listaPdfD = GestionFicheros::imprimir_ficheros_pantalla('pdf');
   $listaOtrosD = GestionFicheros::imprimir_ficheros_pantalla('otros');
}
?>

<!DOCTYPE html>
 
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?= Autorizacion::casillaIdentificacion($usuario);
//al comienzo de la página aparece una casilla con el nombre del
//usuario al que pertenece la sesión?>
        <h2><?= $estado ?></h2>
        <fieldset><legend>
                <h2>Ficheros listos para descargar</h2></legend>
         <h3>Música</h3>
        <ul><?= $listaMusicaD ?>
        </ul>
        <hr>
        <h3>Imágenes</h3>
        <ul> <?= $listaImagenesD ?></ul>
        <hr>
        <h3>PDF</h3>
        <ul><?= $listaPdfD ?></ul>
        <hr>
        <h3>Otros</h3>
        <ul><?= $listaOtrosD ?> </ul>
        </fieldset>
        <!--botón para volver al index -->
        <form method="POST" action="index.php">
            <button type="submit">Volver</button>
        </form>
        <!-- la variable solo tiene contenido si el usuario es admin-->
        <?php echo $lista ?>
       


    </body>
</html>
