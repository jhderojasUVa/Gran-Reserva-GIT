<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once 'opensso-uva/Net/HTTP/Client.php';
require_once 'opensso-uva/ISSO/ISSOClient.php';
require_once 'opensso-uva/ISSO/ISSOConstants.php';
require_once 'opensso-uva/ISSO/isso_config.php';


class SSOUVa {
	
	function __construct() {
		$this -> CI = &get_instance();
	}
	
	public function getLoginURL()
	{
		$isso_client = new ISSOClient();
		return $isso_client->getUrlLoginForm();
	}
	
	public function login() {
		$isso_client = new ISSOClient();
		$user = $isso_client ->verifica();
		
		if(!$user){
				// Si no hay usuario, deberiamos llevarlo a la URL
				header("Location: ".$isso_client->getUrlLoginForm());
				return;
		} else {
				//$user tiene el eXXXXX
				$id = $user;
				$this -> user = $user;
				/* Esta comprobaci<97>n es para que devuelva lo que la aplicaci<97>n necesita */
				if (empty($id)) {
						$err = "El identificador no es correcto.";
						header("Location: ".$isso_client->getUrlLoginForm());
						return -1;
				} else {
						//return 1;
						return $user;
				}
				
				return $user;
		}
				
	}
	
	public function logout($usuario, $ssoid) {
		// Funcion para hacer un logout del SSO de la UVa
		$isso_client = new ISSOClient();
		$user = $isso_client ->verifica();
		header("Location: ".$isso_client->getUrlLogoutForm($usuario, $ssoid));
	}

}