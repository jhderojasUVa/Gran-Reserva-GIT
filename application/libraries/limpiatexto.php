<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
// Clase de calendario que hace todas las funciones para un calendario

class Limpiatexto {
	
	function __construct() {
		$this -> CI = &get_instance();
	}

	public function limpiatexto($texto) {
		$texto = str_replace("á", "a", $texto);
		$texto = str_replace("é", "e", $texto);
		$texto = str_replace("í", "i", $texto);
		$texto = str_replace("ó", "o", $texto);
		$texto = str_replace("ú", "u", $texto);
		
		$texto = str_replace("Á", "A", $texto);
		$texto = str_replace("É", "E", $texto);
		$texto = str_replace("Í", "I", $texto);
		$texto = str_replace("Ó", "O", $texto);
		$texto = str_replace("Ú", "U", $texto);
		
		$texto = str_replace("ñ", "n", $texto);
		$texto = str_replace("Ñ", "N", $texto);
		
		return $texto;
	}

}