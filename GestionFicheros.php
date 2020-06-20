<?php

/*
Clase para gestionar el objeto fichero. Contiene ls atributos del 
 * objeto GestionFicheros y los metodos para trabajrar con el
 */

/**
 * 
 *
 * @author luisa
 */
class GestionFicheros {

    protected $tipo;
    protected $nombre;
    protected $origen;
    protected $destino;
            

    function __construct($fichero) {
        $this->nombre = $fichero['name'];
        $this->tipo = $fichero['type'];
        $this->origen = $fichero['tmp_name'];
        $tipo_fichero = explode('/', $fichero['type'])[0];

            //el destino del fichero viene determiado por su extension
        switch ($tipo_fichero) {

            case 'audio':
                $this->destino = 'musica';

                break;
            case 'image':
                $this->destino = 'imagenes';
                break;
            case 'application':
                if (explode('/', $fichero['type'])[1] == "pdf") {
                    $this->destino = 'pdf';
                }
                break;
            default:
                $this->destino = 'otros';
                break;
        }
    }

    function subirFichero($base) {//metodo para subir el fichero a la 
        //carpeta indicada . Se queda en el index , comunica si lo ha subido o no.

        if (move_uploaded_file($this->origen, "$base/$this->destino/$this->nombre")) {
            header("Location:index.php?mensaje=Fichero subido correctamente");
            exit();
        } else {
            header("Location:index.php?mensaje=Error subiendo archivo");
            exit();
        }
    }

    function subirFicheroAcceder($base) {//si el fichero se sube directamente se irá a la 
        //página de descargas, mostrará mensaje diciendo que se ha subido correctamente y las 
        //descargas disponibles
        if (!move_uploaded_file($this->origen, "$base/$this->destino/$this->nombre")) {
            header("Location:index.php?mensaje=Error moviendo archivo");
            exit();
        }else{
            return "Fichero subido correctamente, para poder visualizarlo tendrá que esperar a que"
            . " el adimistrador lo autorice. Disfrute hasta entonces de las descargas disponibles, gracias.";
        }
    }

    function getNombre() {
        return $this->nombre;
    }

            

    static function imprimir_ficheros_pantalla($subcarpeta) {
        //este método muestra los ficheros en la página dentro de la referencia
        //a la carpeta a la que tiene que ir. Utilizare el método una vez por
        //carpeta,y así se muestra el nombre de la carpeta escrito correctamente.
        $base = "./descarga/donwload/$subcarpeta";
        $dir = scandir($base);
        foreach ($dir as $fichero) {

            if ($fichero != "." && $fichero != "..") {
                $lista .= "<li><a href='descarga/donwload/$subcarpeta/$fichero'>$fichero</a></li>";
            }
        }return $lista;
    }

   
    


    static function ficherosParaAutorizar($subcarpeta) {
        //hacemos una checkbox para seleccionar los archivos a subir
        $base = "./descarga/upload/$subcarpeta";
        $dir = scandir($base);
        $array_paraChecks = $subcarpeta .'[]';//le añado al nombre de la subcarpeta [] para poder recoger
        //los valores
        foreach ($dir as $fichero) {
            if ($fichero != "." && $fichero != "..") {
                $lista .= "<input type=checkbox   name= $array_paraChecks   value='$fichero'>$fichero<br>";
            }
        } return $lista;
    }

    static function formularioSubir($base) {

            //se hace un formulario para recoger los chechbox y poder seleccionarlo
        $dir = scandir($base);
        $lista .= " <h2>Ficheros para autorizar subida</h2><form method=POST action=descarga.php>";
        foreach ($dir as $subdir) {
            if ($subdir != "." && $subdir != "..") {
                $mostrar = self::ficherosParaAutorizar($subdir);
                $lista .= "<h3>$subdir</h3>$mostrar";
            }
        }
        $lista .= "<input type=submit name=submit value=Subir></form>";
        return $lista;
    }

    static function seleccionarFicheros($base) {//este método es para mover los
        //archivos de upload a download
        $dir = scandir($base);
        foreach ($dir as $subdir) {
            if ($dir != "." && dir != "..") {
                $array_seleccionados = $_POST[$subdir];
                foreach ($array_seleccionados as $fichero) {
                    if (rename("./descarga/upload/$subdir/$fichero", "./descarga/donwload/$subdir/$fichero")) {
                    Log::ficherolog('admin', 'admin', $fichero,'autorizado a su visualización y descarga');
                        $respuesta .= "El fichero $fichero se ha movido correctamente";
                    } else {
                        Log::ficherolog('admin', 'admin', $fichero,'autorizado a su visualización y descarga');
                        $respuesta .= "Error: el fichero  $fichero  del directorio $subdir no ha sido movido<br/>";
                    }
                }
            }
        }return $respuesta;
    }

}
