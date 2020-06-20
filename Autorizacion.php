<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Autorizacion
 *
 * @author alumno
 */
class Autorizacion {
  //este método clasifica los usuarios en las tres clases que me pedia el 
    //enunciado, no vàlido, admin y resto de usuarios.
    public static function clasificarUsuarios($usuario, $password) {
        if (!$usuario || !$password) {
            return 'usuario_no_valido';
        } else if ($usuario === 'admin' && $password === 'admin') {
            return 'admin';
        } else {
            return 'usuario';
        }
    }
    //con este método creo un mensaje en la parte superior de la página que
    //nos muestra de quien es la sesión.
public static function casillaIdentificacion($usuario){
    if(!isset($_SESSION['usuario']))
  return "<div id=identificador><p>Sesión no iniciada</p></div>";
    else
        return "<div id=identificador><p>Ususario identificado como $usuario</p></div>";
}
}
