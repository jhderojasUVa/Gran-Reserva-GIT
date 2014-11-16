<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mis extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
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
				'show_next_prev'	=> 'true',
				'next_prev_url'   => 'http://www5.uva.es/gran_reserva/index/'
			 );
		
		$this -> load -> library("SSOUVa");
		$this -> load -> library("calendar", $prefs_calendario);
		$this -> load -> library("Funccalendario");
		
		// Paginacion salida de paginacion y su configuacion - La configuacion esta en config.php
		$config['base_url'] = "http://tuti.ges.uva.es/gran_reserva/index,php/mis";
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		//Para filtrar los nombres de los ficheros
		$this->load->helper('security');
		
		$this->load->library("LDAP");
		$this -> load -> library("sesiones_usuarios");
		
		$this -> load -> config("calendario");
	 }
	 
	 public function index() {
	 	// Controlar que controla toda la parte de "mi"
		
		$usuario = $this -> ssouva -> login();
		// Enviamos el enif a la pagina
		$datos["usuario"] = $usuario;
		
		// Comprobamos si es administrador
		if ($this -> administradores_model -> es_administrador($usuario) == true) {
			$this -> sesiones_usuarios -> que_es("si", "si");
		} else {
			$this -> sesiones_usuarios -> que_es("no", "si");
		}
		
		// Esto hay que cambiarlo
		if ($this -> input -> get("sala")) {
			$datos["sala"] = $this -> input -> get("sala");
		} else {
			$datos["sala"] = 1;
		}
		
		$datos["sala_nombre"] = $this -> salas_model -> nombre_sala ($datos["sala"]);
		
		$datos["lugares"] = $this -> lugares_model -> show_todos_lugar();
		
		$datos["identificado"]=TRUE;
		
		$datos["mis_reservas"] = $this -> reservas_model -> show_todas_reservas_pollo($usuario);
		$this -> load -> view("principal", $datos);
		
		$this -> load -> view("mis/mis_reservas_view", $datos);
		
		$this -> load -> view("pie_view");
	 }
	 
	 public function ics() {
	 	// Esto es para crear los ICS
		
		$usuario = $this -> ssouva -> login();
		// Enviamos el enif a la pagina
		$datos["usuario"] = $usuario;
		
		$datos["datos_usuario"] = $this -> ldap -> get_user_data($usuario);
		
		// Cogemos a ver si es un evento o muchos
		if ($this -> input -> get("id_reserva")) {
			// Una unica reserva
			$id_reserva = $this -> input -> get("id_reserva");
			$datos["mis_reservas"] = $this -> reservas_model -> show_reserva($id_reserva);
		} else {
			$datos["mis_reservas"] = $this -> reservas_model -> show_todas_reservas_pollo($usuario);
		}
		
		//print_r($datos["datos_usuario"]);
		
		$this -> load -> view("mis/ics", $datos);
	 }
	 
	 public function borrado_masivo() {
	 }
}