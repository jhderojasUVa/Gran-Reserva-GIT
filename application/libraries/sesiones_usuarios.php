<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
// Clase de calendario que hace todas las funciones para un calendario

class Sesiones_usuarios {
	
	function __construct() {
		$this -> CI = &get_instance();
		session_start();
	}
	
	function que_es($admin, $usuario) {
		// Funcion para meter en sesiones si es administrador o usuario
		// Funciona con un si/no
		
		if ($admin=="si") {
			$_SESSION["es_admin"] = true;
			$_SESSION["fue_admin"] = true;
		} else {
			$_SESSION["es_admin"] = false;
			$_SESSION["fue_admin"] = false;
		}
		
		if ($usuario=="si") {
			$_SESSION["usuario_normal"] = true;
		} else {
			$_SESSION["usuario_normal"] = false;
		}
		
		return TRUE;
	}
	
	function cambiar_tipo() {
		// Funcion que cambia de admin a user normal y viceversa
		// Esta funcion se usa para cambiar los privilegios de un admin y que pueda hacer reservas por el metodo normal
		
		// Lo comprobamos por si hay algun listo que entra y lo ejecuta a piñon... que nunca se sabe
		if ($_SESSION["es_admin"] == true) {
			$_SESSION["es_admin"] = false;
		} elseif ($_SESSION["es_admin"] == false) {
			$_SESSION["es_admin"] = true;
		}
	}
	
	function es_admin() {
		// Funcion que responde si es admin o no
		if ($_SESSION["es_admin"] == true) {
			return true;
		} else {
			return false;
		}
	}
	
	function es_user() {
		// Funcion que devuelve si es un usuario o no (vamos, si esta identificado)
		if ($_SESSION["usuario_normal"] == true) {
			return true;
		} else {
			return false;
		}
	}
	
	function fue_admin() {
		// Funcion que devuelve si fue admin o no
		if ($_SESSION["fue_admin"] == true) {
			return true;
		} else {
			return false;
		}
	}
}