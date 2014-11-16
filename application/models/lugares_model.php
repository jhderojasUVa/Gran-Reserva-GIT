<?
/*

	Modelo que controla todo lo necesario para la tabla lugares

*/

class Lugares_model extends CI_Model {
//class lugares extends CI_Model {
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
		// Cargamos la base de datos
		$this -> load -> database();
    }
	
	function add_lugar($facultad, $descripcion) {
		// Funcion que añade un lugar nuevo
		$sql = "INSERT INTO lugares (facultad, descripcion) VALUES ('".$facultad."', '".$descripcion."')";
		$resultado = $this -> db -> query ($sql);
		return $resultado;
	}
	
	function del_lugar($idlugar) {
		// Funcion que elimina un lugar
		// ATENCION: Borrara reservas y salas asociadas
		
		// Primero las Salas
		// Lo primero es sacar que salas son de ese lugar para borrar sus reservas
		$sql = "SELECT id_sala FROM salas where lugar='".$idlugar;
		$lugares = $this -> db -> query($sql);
		
		foreach ($lugares as $row) {
			// Borramos las reservas
			$sql = "DELETE FROM reservas WHERE sala='".$row->id_sala."'";
			$reserva_borrada = $this -> db -> query($sql);
		}
		
		// Ahora borramos las salas
		$sql = "DELETE FROM salas WHERE id_sala='".$idlugar."'";
		$resultado = $this -> db -> query ($sql);
		
		// Y ahora el lugar
		$sql = "DELETE FROM lugares WHERE id_lugar='".$idlugar."'";
		$resultado = $this -> db -> query ($sql);
		return $resultado;
	}
	
	function update_lugar($facultad, $descripcion, $idlugar) {
		// Actualiza los datos de un lugar
		$sql = "UPDATE lugares SET facultad='".$facultad."', descripcion='".$descripcion."' WHERE id_lugar='".$idlugar."'";
		$resultado = $this -> db -> query ($sql);
		return $resultado;
	}
	
	function show_todos_lugar() {
		// Funcion que muestra TODOS los lugares
		$sql = "SELECT id_lugar, facultad FROM lugares ORDER BY facultad";
		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
	
	function soy_admin_de($pollo) {
		// Version 2, con inner join
		$sql = "SELECT nombre, id_sala FROM salas INNER JOIN administradores WHERE administradores.lugar=salas.id_sala AND administradores.administrador='".$pollo."'";
		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
	
	function buscar($texto) {
		// Funcion para las busquedas que devuelve si hay un lugar
		$sql = "SELECT facultad, id_lugar FROM lugares WHERE";
		for ($i=0; $i<count($texto)-1; $i++) {
			$sql = $sql." facultad like '%".$texto[$i]."%' OR";
		}
		$sql = $sql." facultad like '%".$texto[count($texto)-1]."%'";
		//log_message("DEBUG", "Lugares SQL=".$sql);
		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
}