<?
/*

	Modelo que controla todo lo necesario para la tabla salas

*/

class Salas_model extends CI_Model {
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
		// Cargamos la base de datos
		$this -> load -> database();
    }
	
	function add_sala ($nombre, $lugar, $descripcion, $gestion, $responsable, $precio, $horario) {
		// Funcion que añade una nueva sala al sistema
		$sql = "INSERT INTO salas (nombre, lugar, descripcion, gestion, responsable, precio, horario) VALUES ('".$nombre."', '".$descripcion."', '".$gestion."', '".$responsable."', '".$precio."', '".$horario."')";
		$resultado = $this -> db -> query($sql);
	}
	
	function del_sala ($idsala) {
		// Funcion para eliminar una sala
		// ATENCION: Todas las reservas de dicha sala seran borradas (¿deberiamos informar al usuario?)
		
		// Borramos las reservas
		$sql = "DELETE FROM reservas WHERE sala='".$idsala."'";
		$resultado = $this -> db -> query($sql);
		
		// Borrado de la sala
		$sql = "DELETE FROM salas WHERE id_sala='".$idsala."'";
		$resultado = $this -> db -> query($sql);
		
		//return $resultado -> result();
	}
	
	function update_sala ($nombre, $lugar, $descripcion, $gestion, $responsable, $precio, $horario, $idsala) {
		// Funcion que actualiza los datos de una sala
		$sql = "UPDATE salas SET nombre='".$nombre."', lugar='".$lugar."', descripcion='".$descripcion."', gestion='".$gestion."', responsable='".$responsable."', precio='".$precio."', horario='".$horario."' WHERE id_sala='".$idsala."'";
		$resultado = $this -> db -> query($sql);
	}
	
	function update_campo($id_sala, $campo, $nuevo) {
		// Funcion que updatea un campo determinado
		$sql = "UPDATE salas SET ".$campo."='".$nuevo."' WHERE id_sala=".$id_sala;
		
		$resultado = $this -> db -> query($sql);
		
		//return $resultado -> result();
	}
	
	function show_sala ($idsala) {
		// Funcion que devuelve todos los datos de una sala
		// Ponemos un * por si aumenta el asunto
		$sql = "SELECT * FROM salas WHERE id_sala='".$idsala."'";
		$resultado = $this -> db -> query($sql);
		return $resultado -> result();
	}
	
	function nombre_sala ($idsala) {
		// Funcion que devuelve el nombre de una sala
		$sql = "SELECT nombre FROM salas WHERE id_sala='".$idsala."'";
		$resultado = $this -> db -> query($sql);
		foreach ($resultado -> result() as $row) {
			$nombre_sala = $row -> nombre;
		}
		
		return $nombre_sala;
	}
	
	function show_todas_salas ($orden) {
		// Funcion que devuelve el ID y el nombre las salas ordenadas por...
		
		if ($orden=="N") {
			// Por nombre
			$sql = "SELECT id_sala, nombre FROM salas ORDER BY nombre";
		} elseif ($orden=="L") {
			// Por lugar
			$sql = "SELECT id_sala, nombre FROM salas ORDER BY lugar";
		} elseif ($orden=="G") {
			// Por tipo de gestion
			$sql = "SELECT id_sala, nombre FROM salas ORDER BY gestion";
		} elseif ($orden=="R") {
			// Por responsable
			$sql = "SELECT id_sala, nombre FROM salas ORDER BY responsable";
		} elseif ($orden=="P") {
			// Por precio
			$sql = "SELECT id_sala, nombre FROM salas ORDER BY precio";
		} elseif ($orden=="H") {
			// Por horario
			$sql = "SELECT id_sala, nombre FROM salas ORDER BY horario";
		}
		$resultado = $this -> db -> query($sql);
	}
	
	function show_salas_lugares($idlugar) {
		// Funcion que muestra las salas que pertenecen a un lugar
		$sql = "SELECT id_sala, nombre FROM salas WHERE lugar=".$idlugar." AND privada=0 ORDER BY nombre";
		$resultado = $this -> db -> query($sql);
		return $resultado -> result();
	}
	
	function show_salas_lugares_admin($idlugar) {
		// Funcion que muestra las salas que pertenecen a un lugar
		$sql = "SELECT id_sala, nombre FROM salas WHERE lugar=".$idlugar." ORDER BY nombre";
		$resultado = $this -> db -> query($sql);
		return $resultado -> result();
	}
	
	function buscar($texto) {
		// Funcion que devuelve el nombre de las salas para las busquedas
		$sql = "SELECT id_sala, nombre FROM salas WHERE";
		for ($i=0; $i<count($texto)-1; $i++) {
			$sql = $sql." nombre like '%".$texto[$i]."%' OR";
		}
		$sql = $sql." nombre like '%".$texto[count($texto)-1]."%'";
		//log_message("DEBUG", "Salas SQL=".$sql);
		$resultado = $this -> db -> query($sql);
		return $resultado -> result();
	}
	
	function show_todas_salas_usuario($pollo) {
		// Funcion que muestra todas las salas de un usuario
		$sql = "SELECT lugar FROM administradores WHERE administrador='".$pollo."'";
		$resultado_salas = $this -> db -> query($sql);
		
		foreach ($resultado_salas -> result() as $row) {
			$sql2 = "SELECT id_sala, nombre, descripcion, gestion FROM salas WHERE id_sala=".$row -> lugar;
			$resultado_tmp = $this -> db -> query($sql2);
			foreach ($resultado_tmp -> result() as $row2) {
				$devolver[] = array ("id" => $row -> lugar, "nombre" => $row2 -> nombre, "descripcion" => $row2 -> descripcion, "gestion" => $row2 -> gestion);
			}
		}
		
		return $devolver;
	}
	
	function sala_gestionada($idsala) {
		// Funcion que devuelve true si una sala es gestionada
		// y por lo tanto necesita confirmar cuando se reserva
		$sql = "SELECT gestion FROM salas WHERE id_sala=".$idsala;
		$resultado = $this -> db -> query($sql);
		foreach ($resultado -> result() as $row) {
			if ($row -> gestion == true) {
				//log_message("DEBUG",">>>>>>>>>>>> SALA GESTIONADA<<<<<<<<<<<<<<");
				return true;
			} else {
				//log_message("DEBUG",">>>>>>>>>>>> SALA NOOOOOOOO GESTIONADA<<<<<<<<<<<<<<");
				return false;
			}
		}
	}
	
	function quien_admin_sala($idsala) {
		// Funcion que devuelve quien es el administrador de una sala
		
		$sql = "SELECT administrador FROM administradores WHERE lugar = ".$idsala;
		
		//$sql = "SELECT administrador.administradores FROM administradores INNER JOIN administrador.lugar = responsable.salas WHERE salas.id_sala = ".$idsala;
		$resultado = $this -> db -> query ($sql);
		foreach ($resultado->result() as $row) {
			$administrador = $row -> administrador;
		}
		
		return $administrador;
	}
}