<?
/*

	Modelo que controla todo lo necesario para la tabla reservas

*/

class Reservas_model extends CI_Model {
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
		// Cargamos la base de datos
		$this -> load -> database();
    }
	
	function add_reserva ($idsala, $inicio, $fin, $persona, $confirmado, $descripcion, $contacto) {
		// Funcion para añadir una reserva
		$sql = "INSERT INTO reservas (inicio, fin, persona, confirmado, sala, descripcion, contacto) VALUES ('".$inicio."', '".$fin."', '".$persona."', '".$confirmado."', '".$idsala."', '".$descripcion."', '".$contacto."')";
		$resultado = $this -> db -> query($sql);
	}
	
	function del_reserva ($idreserva, $pollo, $admin) {
		// Funcion que borra una reserva
		// Comprueba si el pollo que la intenta es el que lo creo SALVO, si es admin, obviamente...
		
		// Devuelve true si es si y false si es no
		
		if ($admin == false) {
			// Si no es admin, vemos si es el mismo pollo o es otro pollo tontaco piticlis
			$sql = "SELECT count(*) AS totalaco FROM reservas WHERE persona='".$pollo."' AND id_reserva='".$idreserva."'";
			$resultado = $this -> db -> query($sql);
			foreach ($resultado -> result() as $row) {
				$total = $row -> totalaco;
			}
		} else {
			// Si es admin, como nos conocemos, comprobamos que es admin del sitio en cuestion
			$sql = "SELECT count(*) AS totalaco FROM reservas INNER JOIN administradores WHERE reservas.sala=administradores.lugar AND reservas.id_reserva='".$idreserva."' AND administradores.administrador='".$pollo."'";
			$resultado = $this -> db -> query($sql);
			foreach ($resultado -> result() as $row) {
				$total = $row -> totalaco;
			}
		}
		
		if ($total==1) {
			$sql = "DELETE FROM reservas WHERE id_reserva=".$idreserva;
			$resultado = $this -> db -> query($sql);
			return true;
		} else {
			return false;
		}
	}
	
	function update_reserva ($inicio, $fin, $persona, $confirmado, $descripcion, $idreserva) {
		// Funcion que actualiza una reserva
		$sql = "UPDATE reservas SET inicio='".$inicio."', fin='".$fin."', persona='".$persona."', confirmado='".$confirmado."', descripcion='".$descripcion."' WHERE id_reserva='".$idreserva."'";
		$resultado = $this -> db -> query($sql);
	}
	
	function update_descripcion_reserva ($idreserva, $descripcion) {
		// Funcion que solo updatea la descripcion y tal
		$sql = "UPDATE reservas SET descripcion='".$descripcion."' WHERE id_reserva='".$idreserva."'";
		$resultado = $this -> db -> query($sql);
	}
	
	function update_contacto_reserva ($idreserva, $contacto) {
		// Funcion que solo updatea el contacto y tal
		$sql = "UPDATE reservas SET contacto='".$contacto."' WHERE id_reserva='".$idreserva."'";
		$resultado = $this -> db -> query($sql);
	}
	
	function update_campo_reserva ($idreserva, $campo, $contacto) {
		// Funcion que solo updatea el contacto y tal
		$sql = "UPDATE reservas SET ".$campo."='".$descripcion."' WHERE id_reserva='".$idreserva."'";
		$resultado = $this -> db -> query($sql);
	}
	
	function confirm_reserva ($idreserva) {
		// Funcion que confirma (o desconfirma) una reserva
		
		// Lo primero es leer el estado de la reserva
		$sql = "SELECT confirmado FROM reservas WHERE id_reserva='".$idreserva."'";
		$resultado = $this -> db -> query($sql);
		
		foreach ($resultado as $row) {
			$confirmado = $row->confirmado;
		}
		// Lo doy la vuelta y punto
		if ($confirmado == TRUE) {
			$conformado = FALSE;
		} else {
			$confirmado = TRUE;
		}
		
		$sql = "UPDATE reservas SET confirmado='".$confirmado."' WHERE id_reserva='".$idreserva."'";
		$resultado = $this -> db -> query($sql);
		
		return $confirmado;
	}
	
	function reservas_sin_confirmar($pollo, $administrador) {
		// Devuelve el numero TOTAL de reservar sin confirmar del usuario
		$total = 0;
		if ($administrador==true) {
			$sql = "SELECT lugar FROM administradores WHERE administrador='".$pollo."'";
			$resultado = $this -> db -> query($sql);
			//log_message("DEBUG", "SQL 1=".$sql);
			foreach ($resultado -> result() as $caca) {
				$sql = "SELECT count(*) AS total FROM reservas WHERE sala='".$caca -> lugar."' AND confirmado=false";
				$resultado2 = $this -> db -> query($sql);
				foreach ($resultado2 -> result() as $pedo) {
					$total = $total + $pedo -> total;
				}
			}
		} else {
			$sql = "SELECT count(*) AS total FROM reservas WHERE persona='".$pollo."' AND confirmado=false";
			$resultado = $this -> db -> query($sql);
			foreach ($resultado -> result() as $caca) {
				$total = $caca -> total;
			}
		}
		
		//log_message("DEBUG", "SQL = ".$sql);
		
		return $total;
	}
	
	function show_todas_reservas_pendientes ($pollo, $sala) {
		// Funcion que muestra el numero de reservas realizadas y que faltan
		// Vamos que saca el numero total de reservas que se han hecho pero que no ha pasado el dia
		$hoy = date("Y-m-d H:i");
		
		if ($sala==0) {
			$sql = "SELECT count(*) as total FROM reservas WHERE fin>='".$hoy."'";
		} else {
			$sql = "SELECT count(*) as total FROM reservas WHERE fin>='".$hoy."' AND sala='".$sala."'";
		}
		
		$resultado = $this -> db -> query($sql);
		
		foreach ($resultado -> result() as $row) {
			$total = $row -> total;
		}
		
		return $total;
	}
	
	function show_reservas_pendientes_array($pollo, $mes, $ano, $sala) {
		// Funcion que devuelve todas las reservas pendientes de una sala
		// Dejamos el SELECT con * por si ampliamos los campos que nunca se sabe en esta vida
		$sql = "SELECT * FROM reservas WHERE confirmado=false AND inicio>='".$ano."-".$mes."-01 00:00' AND fin<='".$ano."-".$mes."-31 23:59' and sala=".$sala;
		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
	
	function show_reservas_pollo ($sala, $mes, $ano, $pollo) {
		// Funcion que devuelve las reservas de que tiene un pollo para un mes
		$sql = "SELECT id_reserva, inicio, fin, descripcion FROM reservas WHERE sala='".$sala."' AND inicio>='".$ano."-".$mes."-01 00:00:00' and fin<='".$ano."-".$mes."-31 00:00:00' AND persona='".$pollo."' ORDER BY inicio";
		$resultado = $this -> db -> query($sql);
		return $resultado -> result();
	}
	
	function show_reservas_sala ($sala, $mes) {
		// Funcion que muestra los dias de las reservas de un sitio y un mes
		$sql = "SELECT id_reserva, inicio, fin, descripcion, sala FROM reservas WHERE confirmado=true AND sala='".$sala."' AND inicio>='".date("Y")."-".$mes."-01 00:00:00' and fin<='".date("Y")."-".$mes."-31 00:00:00' ORDER BY inicio";
		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
	
	function show_reservas_sala_ano ($sala, $mes, $ano) {
		// Funcion que muestra los dias de las reservas de un sitio y un mes
		// Ponemos en la busqueda un * para sacar todo
		$sql = "SELECT * FROM reservas WHERE confirmado=true AND sala='".$sala."' AND inicio>='".$ano."-".$mes."-01 00:00:00' and fin<='".$ano."-".$mes."-31 00:00:00' ORDER BY inicio";
		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
	
	function show_reservas_dia($sala, $dia) {
		// Funcion que devuelve las reservas de un dia determinado
		// Ponemos en la busqueda un * por si acaso
		$sql = "SELECT * FROM reservas WHERE confirmado=true AND sala='".$sala."' AND inicio>='".$dia." 00:00' AND fin<='".$dia." 23:59'";
		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
	
	function show_reserva($id_reserva) {
		// Funcion que devuelve TODOS los datos de una reserva
		// Lo hacemos con el (*) por si algun dia crece la bd, que nunca se sabe
		$sql = "SELECT * FROM reservas WHERE id_reserva=".$id_reserva;
		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
	
	function show_todas_reservas_pollo($pollo) {
		// Funcion que devuelve todas las reservas de un pollo (hay que separarlas por paginas)
		// Las muestra ordenadas por fecha a la inversa
		$sql = "SELECT id_reserva, inicio, fin, descripcion, confirmado, sala FROM reservas WHERE persona='".$pollo."' ORDER BY fin DESC";
		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
	
	function show_sala_por_reserva($id_reserva) {
		// Funcion que devuelve la sala segun la reserva...
		$sql = "SELECT sala FROM reservas WHERE id_reserva=".$id_reserva;
		$resultado = $this -> db -> query($sql);
		
		foreach ($resultado -> result() as $row) {
			$sala = $row -> sala;
		}
		return $sala;
	}
	
	function buscar($texto) {
		// Funcion que busca por la descripcion de una reserva
		$sql = "SELECT reservas.id_reserva, reservas.descripcion, salas.nombre FROM reservas INNER JOIN salas ON salas.id_sala = reservas.sala WHERE reservas.confirmado=true AND";
		for ($i=0; $i<count($texto)-1; $i++) {
			$sql = $sql." reservas.descripcion like '%".$texto[$i]."%' OR";
		}
		$sql = $sql." reservas.descripcion like '%".$texto[count($texto)-1]."%'";

		$resultado = $this -> db -> query($sql);
		
		return $resultado -> result();
	}
	
	function coindice_persona_con_reserva($id_reserva, $pollo_a_comprobar) {
		// Funcion que devuelve
		// TRUE si el $pollo_a_comprobar ES el dueño de la reserva $id_reserva
		// FALSE si el $pollo_a_comprobar NO ES el dueño de la reserva $id_reserva
		
		$sql = "SELECT persona FROM reservas WHERE id_reserva = ".$id_reserva;
		$resultado = $this -> db -> query ($sql);
		//log_message("DEBUG", "SQL = ".$sql);
		
		foreach ($resultado -> result() as $row) {
			if ($pollo_a_comprobar==$row -> persona) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}
}