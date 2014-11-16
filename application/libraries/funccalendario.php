<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
// Clase de calendario que hace todas las funciones para un calendario

class Funccalendario {
	
	function __construct() {
		$this -> CI = &get_instance();
	}

	public function Bisiesto($ano) {
		// Funcion que comprueba si el año es bisiesto y tal
		// Retorna true si lo es y false, sino
		if (($ano % 4 == 0) && (($ano % 100 != 0) || ($ano % 400 == 0))) {
			return true;
		} else {
			return false;
		}
	}
	
	public function Ultimo_dia_mes($mes, $ano) {
		// Devuelve cual es el ultimo dia del mes (30, 31, 28 o 29)
		$esbisiesto = $this -> Bisiesto($ano);
		if ($mes==1 || $mes==3 || $mes==5|| $mes==7 || $mes==8 || $mes==10 || $mes==12) {
			return 31;
		} elseif ($mes==2 && $esbisiesto==true) {
			return 29;
		} elseif ($mes==2 && $esbisiesto==false) {
			return 28;
		} else {
			return 30;
		}
	}
	
	public function Pasos_calendario($inicio, $fin, $step) {
		// Funcion que te devuelve el numero de celdas que ha de rellenar
		$hora_inicio = substr($inicio, 10,2);
		$minuto_inicio = substr($inicio, 13, 2);
		
		$hora_inicio = $hora_inicio + (1/(60/$minuto_inicio));
		
		$hora_fin = substr($fin, 10, 2);
		$minuto_fin = substr($fin, 13, 2);
		
		$hora_fin = $hora_fin + (1/(60/$minuto_fin));
		
		$pasos = ($hora_inicio - $hora_fin)/(60/$step);
		
		return $pasos;
	}
	
	public function Ocupado($fechaincio, $fechafin, $actual, $strtotime) {
		// Funcion que devuelve si esta ocupado o no o como lo pinta
		// Primero lo pasamos a tiempo de este mundial o como quieras llamarlo
		// Con $strtotime controlamos si le pasamos ya con strtotime o no
		
		if ($strtotime==true) {
			// Lo dejo por si acaso y tal, que nunca se sabe, pero es una chapu
		} else {
			$fechainicio = strtotime($fechainicio);
			$fechafin = strtotime($fechafin);
			$actual = strtotime($actual);
		}
		
		if (($fechaincio == $actual) || ($fechafin > $actual && $fechaincio < $actual) || ($fechafin == $actual)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function devuelve_fecha_formateada($fecha) {
		// Funcion que devuelve la fecha por trozos (dia/mes/año/hora/minuto)
		// Lo devuelve en un array
			
		$dia = substr($fecha, 8, 2);
		$mes = substr($fecha, 5, 2);
		$ano = substr($fecha, 0, 4);
		$hora = substr($fecha, 11, 2);
		$minuto = substr($fecha, 14, 2);
		
		$fecha_enviar = array ("dia" => $dia, "mes" => $mes, "ano" => $ano, "hora" => $hora, "minuto" => $minuto);
		return $fecha_enviar;
	}
	
	public function devuelve_fecha_ics($fecha) {
		// Funcion que devuelve una fecha ideal para usar en el ICS
		$dia = substr($fecha, 8, 2);
		$mes = substr($fecha, 5, 2);
		$ano = substr($fecha, 0, 4);
		$hora = substr($fecha, 11, 2);
		$minuto = substr($fecha, 14, 2);
		
		//return $ano.$mes.$dia."T".$hora.$minuto."00Z";  ESTO VALDRIA PARA UTC que va a ser que mejor no
		return $ano.$mes.$dia."T".$hora.$minuto."00";
	}
	
	public function muestra_dia_hoy($tipo) {
		// Función que muestra el día de hoy de diferentes formas
		switch ($tipo) {
			case "largo": 
				return date("l").", ".date("j")." de ".date("F")." de ".date("Y");
				break;
			case "corto":
				return date("j")." de ".date("M")." de ".date("Y");
				break;
			case "small":
				return date("j")."/".date("M")."/".date("Y");
				break;
			case "minimal":
				return date("d")."/".date("m")."/".date("y");
				break;
		}
	}

	public function devuelve_mes_letras($mes) {
		switch ($mes) {
			case 1:
				$mes = "enero";
				break;
			case 2:
				$mes = "febrero";
				break;
			case 3:
				$mes = "marzo";
				break;
			case 4:
				$mes = "abril";
				break;
			case 5:
				$mes = "mayo";
				break;
			case 6:
				$mes = "junio";
				break;
			case 7:
				$mes = "julio";
				break;
			case 8:
				$mes = "agosto";
				break;
			case 9:
				$mes = "septiembre";
				break;
			case 10:
				$mes = "octubre";
				break;
			case 11:
				$mes = "noviembre";
				break;
			case 12:
				$mes = "diciembre";
				break;
		}
		return $mes;
	}
	
	public function menor_de_10($dato) {
		// Funcion que pone un 0 delante si es menor de 10
		if ($dato<10) {
			return "0".$dato;
		} else {
			return $dato;
		}
	}
}