<?
/*

	Modelo que controla todo lo necesario para la tabla recursos

*/

class Recursos_model extends CI_Model {
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
		// Cargamos la base de datos
		$this -> load -> database();
    }

	function recursos_sala($idsala) {
		// Funcion que devuelve los recursos de una sala
		$sql = "SELECT recurso FROM recursos_salas WHERE id_sala=".$idsala;
		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
}