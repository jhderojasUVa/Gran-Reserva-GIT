<?
/*

	Modelo que controla todo lo necesario para la tabla horarios

*/

class Horarios_model extends CI_Model {
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
		// Cargamos la base de datos
		$this -> load -> database();
    }
	
	function muestra_datos($idhorario) {
		// Muestra todos los datos de un horario determinado
		$sql = "SELECT id_horario, nombre, hora_inicio, hora_fin, tiempo FROM horarios WHERE id_horario=".$idhorario;
		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
	
	function add_horario($nombre, $hora_inicio, $hora_fin, $tiempo) {
		// Inserta un horario nuevo
		$sql = "INSERT INTO horarios (nombre, hora_inicio, hora_fin, tiempo) VALUES ('".$nombre."','".$hora_inicio."','".$hora_fin."','".$tiempo."')";
		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
	
	function del_horario($idhorario, $idhorario_default) {
		// Borra un horario determinado
		// ATENCION: esta función deja las salas con horario default
		// Es necesario un horario default, que se ha de controlar desde el controlador (redundanteeee)
		
		
		// Pasamos las salas a horario default
		$sql = "UPDATE salas SET horario='".$idhorario_default."' WHERE horario='".$idhorario."'";
		$resultado = $this -> db -> query($sql);
		
		// Primero el horario
		$sql = "DELETE FROM horarios WHERE id_horario=".$idhorario;
		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
	
	function update_horario($nombre, $hora_incio, $hora_fin, $tiempo, $idhorario) {
		// Actualiza los datos de un horario
		$sql = "UPDATE horarios SET nombre='".$nombre."', hora_inicio='".$hora_inicio."', hora_fin='".$hora_fin."', tiempo='".$tiempo."' WHERE id_horario='".$idhorario."'";
		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
	
	function calcula_paso_horario($idhorario) {
		// Funcion que calcula el paso (el numero de pasos) entre hora y hora
		$sql = "SELECT tiempo FROM horarios WHERE id_horario='".$idhorario."'";
		echo $sql;
		$resultado = $this -> db -> query($sql);
		
		foreach ($resultado -> result() as $row) {
			$paso = (60/$row -> tiempo);
		}
		
		//echo "PASO = ".$paso." result = ".$row->tiempo;
		
		return $paso;
	}
	
	function calcula_paso_horario_desde_sala($idsala) {
		// Funcion que calcula el paso (el numero de pasos) entre hora y hora
		$sql = "SELECT horario FROM salas WHERE id_sala='".$idsala."'";
		$resultado = $this -> db -> query($sql);
		
		foreach ($resultado -> result() as $row) {
			$idhorario = $row -> horario;
		}
		
		$sql = "SELECT tiempo FROM horarios WHERE id_horario='".$idhorario."'";
		$resultado = $this -> db -> query($sql);
		
		foreach ($resultado -> result() as $row) {
			$paso = (60/$row -> tiempo);
		}
		
		return $paso;
	}
	
	function saca_horario_sala($idsala) {
		// Funcion que devuelve todos los datos de un horario segun la sala seleccionada
		$sql = "SELECT horario FROM salas WHERE id_sala='".$idsala."'";
		$resultado = $this -> db -> query($sql);
		
		foreach ($resultado -> result() as $row) {
			$sql = "SELECT hora_inicio, hora_fin, nombre, tiempo FROM horarios WHERE id_horario='".$row->horario."'";
		}
		$resultado = $this -> db -> query($sql);
		return $resultado -> result();
	}
}