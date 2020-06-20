<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Clse para gestionar los ficheros log
 *
 * @author luisa
 */
class Log {
    static function  ficherolog($usuario, $pass, $nombre, $accion) {//la accion nos da información si se ha subido o se a 
    //autorizado el fichero para su subida
     //funcion para crear el registro de subidas, he hecho que se elimine cuando
        //llegue un tamaño y no permitir que se haga muy grande, he hecho muchas pruebas.
    $file_error = fopen("log.txt", "a");
    $texto = date("H:i:s d-m-Y") . "El usuario:$usuario,  pass:$pass, ha $accion el fichero:$nombre  \n";
    fwrite($file_error, $texto);
    $size = filesize("log.txt");
    if ($size > 1024) {
        unlink("log.txt");
        
    }
    fclose($file);
}

}
