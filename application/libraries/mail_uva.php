<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
// Clase de calendario que hace todas las funciones de correo

class Mail_UVa {
	
	function __construct() {
		$this -> CI = &get_instance();
		//session_start();
	}
	
	function envia_mail($usuario, $asunto, $texto) {
		// Funcion que envia un correo a un usuario con un asunto y le mete la firma chachi a traves
		// de un correo no-reply@uva.es
		
		// Devuelve true si no hay problema
		// Devuelve false si hay problema
		
		$cabecera = "From: gran_reserva_noreply@uva.es" . "\r\n" .
  					"Reply-To: noreply@uva.es" . "\r\n" .
 					"X-Mailer: PHP/" . phpversion();
		
		// Comprobaciones varias
		if (!stristr($usuario, "@uva.es")) {
			$usuario = trim($usuario)."@uva.es";
		}
		
		$firma = "\r\n\r\n\r\n".
				 "------------------------------------------------\r\n".
				 "Gran Reserva UVa\r\n".
				 "Universidad de Valladolid\r\n".
				 "http://granreserva.uva.es\r\n".
				 "\r\n".
				 "Este correo ha sido generado automaticamente.\r\n".
				 "Por favor no responda a la direccion";
		
		$texto = trim($texto)."\r\n".$firma;
	
		//mail($usuario, $asunto, $texto, $cabecera);
		//mail($usuario, $asunto, $texto, $cabecera);
		if (mail($usuario, $asunto, $texto, $cabecera)) {
			return true;
		} else {
			return false;
		}
	}
		
}