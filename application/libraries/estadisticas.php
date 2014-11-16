<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
// Clase de calendario que hace todas las funciones para un calendario

class Funccalendario {
	
	function __construct() {
		$this -> CI = &get_instance();
	}
	
	function tanto_por_ciento($total, $parte) {
		// Funcion que devuelve el tanto por ciento
		
		$tanto_por_ciento = ($parte*100)/$total;
		return $tanto_por_ciento;
	}
	
	function el_mas_alto($array) {
		// Funcion que devuelve el elemento mas alto de un array
		for ($i=0; i<count($array); $i++) {
			
		}
	}
	
	function cuenta_valores($array) {
		// Funcion que cuenta el numero de veces que aparece un valor
		return array_count_values($array);
	}
	
	function producto($array) {
		// Calcula el producto de un array
		return array_product($array);
	}
	
	function buscar_array($array, $busqueda) {
		// Busca un valor en un array y devuelve su posicion
		// Devuelve FALSE si no encuentra nada
		return array_search($busqueda, $array);
	}
	
	function ordena_array($array, $como) {
		// Ordena los valores array
		if ($como==1) {
			return asort($array);
		} else {
			return arsort($array);
		}
	}
	
	function ordena_indices_array($array, $como) {
		// Ordena los indices de un array
		if ($como==1) {
			return ksort($array);
		} else {
			return krsort($array);
		}
	}
}