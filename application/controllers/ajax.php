<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {
	// Control para todas las peticiones de ajax y tal y pascual
	
	public function __construct() {
		parent::__construct();
		
		// Carga de modelos y librerias
		$this -> load -> model("lugares_model");
		$this -> load -> model("reservas_model");
		$this -> load -> model("salas_model");
		$this -> load -> model("horarios_model");
		
		$this -> load -> model("administradores_model");
		
		$prefs_calendario = array (
			   'start_day'    => 'monday',
			   //'month_type'   => 'long',
			   'day_type'     => 'abr',
			  'show_next_prev'	=> 'true'
		);
		
		$this -> load -> library("SSOUVa");
		$this -> load -> library("calendar", $prefs_calendario);
		
		//Para filtrar los nombres de los ficheros
		$this->load->helper('security');
		
		//$this->load->helper('cadenas');
		
		$this -> load -> library("LDAP");
		$this -> load -> library("sesiones_usuarios");
	}

	public function index() {
		echo "<script>location.href='/'</script>";
	}
	
	public function mostrar_sitios() {
	 	// Funcion que muestra un sitio segun un lugar
		
		// Recogemos por POST $lugar
		$lugar = $this -> input -> post("lugar");
		
		// El lugar para el form
		$datos["lugar_estoy"] = $lugar;
		
		$datos["lugares"] = $this -> lugares_model -> show_todos_lugar();
		// Si es admin, sacamos todas, sino no, pues no
		//log_message("DEBUG", "ES ADMIN = ".$_SESSION["es_admin"]." | FUE ADMIN = ".$_SESSION["fue_admin"]);
		if ($_SESSION["es_admin"]==true || $_SESSION["fue_admin"]==true) {
			$datos["salas"] = $this -> salas_model -> show_salas_lugares_admin($lugar);
		} else {
			$datos["salas"] = $this -> salas_model -> show_salas_lugares($lugar);
		}
		
		$this -> load -> view("ajax/mostrar_salas_view", $datos);
	 }
	 
	public function cambiar_nombre_sala() {
		// Funcion que cambia el nombre de una sala por ajax
		$antiguo = $this -> input -> post("orig_value");
		$nuevo = $this -> input -> post("new_value");
		$id = substr($this -> input -> post("id"), 6 , strlen($this -> input -> post("id"))-6);
		
		$cambio = $this -> salas_model -> update_campo($id, "nombre", $nuevo);
		
		$vuelta = array("is_error" => false, "error_text" => "ha habido un error", "html" => $nuevo);
		
		echo json_encode($vuelta);
	}
	
	public function cambiar_descripcion_sala() {
		// Funcion que cambia la descripcion de una sala por ajax
		$antiguo = $this -> input -> post("orig_value");
		$nuevo = $this -> input -> post("new_value");
		$id = substr($this -> input -> post("id"), 11 , strlen($this -> input -> post("id"))-11);
		
		$cambio = $this -> salas_model -> update_campo($id, "descripcion", $nuevo);
		
		$vuelta = array("is_error" => false, "error_text" => "ha habido un error", "html" => $nuevo);
		
		echo json_encode($vuelta);
	}
	
	public function cambiar_gestion_sala() {
		// Funcion que cambia si esta gestionado o no una sala por ajax
		$antiguo = $this -> input -> post("orig_value");
		$nuevo = $this -> input -> post("new_value");
		$id = substr($this -> input -> post("id"), 7 , strlen($this -> input -> post("id"))-7);
	
		$cambio = $this -> salas_model -> update_campo($id, "gestion", $nuevo);
		
		if ($nuevo==1) {
			$nuevo = "SI";
		} else {
			$nuevo = "NO";
		}
		
		$vuelta = array("is_error" => false, "error_text" => "ha habido un error", "html" => $nuevo);
		
		echo json_encode($vuelta);
		
	}
}
?>