<?
/*

	Modelo que controla todo lo necesario para la tabla administradores
	Incluye el modelo de la parte de observaciones ya que solo seran los admin quienes lo vean

*/

class Administradores_model extends CI_Model {
//class lugares extends CI_Model {
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
		// Cargamos la base de datos
		$this -> load -> database();
    }
	
	function es_administrador_de($lugar, $pollo) {
		// Funcion que comprueba si un pollo es administrador de un sitio
		$administrador = false;
		
		$sql = "SELECT count(*) FROM administradores WHERE lugar='".$lugar."' and administrador='".$pollo."'";
		$resultado = $this -> db -> query($sql);
		
		if ($resultado -> result()) {
			$administrador = true;
		}
		return $administrador;
	}
	
	function es_administrador($pollo) {
		// Funcion que comprueba si es administrador
		$administrador = false;
		
		$sql = "SELECT count(*) as total FROM administradores WHERE administrador='".$pollo."'";
		$resultado = $this -> db -> query($sql);
		if ($resultado -> result()) {
			foreach ($resultado -> result() as $row) {
				if ($row -> total >= 1) {
					$administrador = true;
					//log_message("DEBUG", "Logeado el usuario: ".$pollo." con rol admin");
				} else {
					//log_message("DEBUG", "Logeado el usuario: ".$pollo." con rol no admin");
				}
			}
		}
		return $administrador;
	}
	
	function sala_defecto($usuario) {
		// Funcion que devuelve la primera sala que es administrador un pollo
		$sql = "SELECT lugar FROM administradores WHERE administrador='".$usuario."'";
		$resultado = $this -> db -> query($sql);
		
		foreach ($resultado -> result() as $row) {
			return $row -> lugar;
		}
	}
	
	function observaciones($usuario) {
		// Funcion que devuelve las observaciones de un usuario
		$sql = "SELECT observaciones FROM observaciones WHERE usuario='".$usuario."'";
		$resultado = $this -> db -> query($sql);
		
		foreach ($resultado -> result() as $row) {
			return $row -> observaciones;
		}
	}
}