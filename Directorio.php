<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Clase para crear directorios
 *
 * @author luisa
 */
class Directorio {
   static function crearEstructuraFicheros($dire) {
       if(!file_exists("imagenes"))//crea las 4 subcarpetas, dentro de donde le diga
    mkdir("$dire/imagenes", 0777);     
       if(!file_exists('musica'))
    mkdir("$dire/musica", 0777);
       if(!file_exists('pdf') )
    mkdir("$dire/pdf", 0777);
       if(!file_exists('otros'))
    mkdir("$dire/otros", 0777);
}

static function crearDirectorioPrincipal($nombre) {
    if (!file_exists($ruta)) {//me crea una ruta principal, vale tanto para la carpeta
        //descarga como para upload y donwload
        $ruta= mkdir($nombre, 0777);
        
    } return "./$nombre";
    
}
}
