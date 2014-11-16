<?
/*

	Modelo que controla todo lo necesario para la tabla administradores
	Incluye el modelo de la parte de observaciones ya que solo seran los admin quienes lo vean

*/

class Observaciones_model extends CI_Model {
//class lugares extends CI_Model {
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
		// Cargamos la base de datos
		$this -> load -> database();
    }
	
	function show_observacion($usuario) {
		// Funcion que muestra la observación de un pollo
		$sql = "SELECT * FROM observaciones WHERE usuario='".$usuario."'";
		$resultado = $this -> db -> query($sql);
		
		foreach ($resultado -> result() as $row) {
			$observacion = $row -> observaciones;
		}
		
		return $observacion;
	}
	
	function add_observacion($usuario, $observacion) {
		// Funcion que añade una observacion
		$sql = "INSERT INTO observaciones (usuario, observaciones) VALUES ('".$usuario."', '".$observacion."')";
		$this -> db -> query ($sql);
	}
	
	function update_observacion($usuario, $observacion) {
		// Funcion que updatea una observacion
		$sql = "UPDATE observaciones SET observaciones='".$observacion."' WHERE usuario='".$usuario."'";
		$this -> db -> query($sql);
	}
	
	function usuario_tiene_observacion($usuario) {
		// Funcion que comprueba si un usuario tiene observacion
		// Devuelve false si no tiene nada
		// Devuelve true si tiene una observacion
		$sql = "SELECT observaciones FROM observaciones WHERE usuario='".$usuario."'";
		$resultado = $this -> db -> query($sql);
		
		if ($resultado -> num_rows()>0) {
			return true;
		} else {
			return false;
		}
	}
}