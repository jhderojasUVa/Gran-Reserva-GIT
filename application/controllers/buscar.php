<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buscar extends CI_Controller {

	// Controlador para el area de buscar
	 
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
		
		//Para filtrar los nombres de los ficheros
		$this->load->helper('security');
		
		//$this->load->helper('cadenas');
		
		$this->load->library("LDAP");
		$this -> load -> library("sesiones_usuarios");
		
		$this -> load -> config("calendario");
	 }
	 
	 
	 public function index() {
	 	// Controlador base que busca en todo y saca algo
		
		// SSO y login
		$usuario = $this -> ssouva -> login();
		// Enviamos el enif a la pagina
		$datos["usuario"] = $usuario;
		
		// Comprobamos si es administrador
		if ($this -> administradores_model -> es_administrador($usuario) == true) {
			$this -> sesiones_usuarios -> que_es("si", "si");
		} else {
			$this -> sesiones_usuarios -> que_es("no", "si");
		}
		
		// Cogemos el texto a buscar y le quitamos las cosicas
		$texto = trim($this -> input -> post("buscar"));
		$datos["busqueda"] = $texto;
		
		// Separamos por espacios para buscar del todo
		$texto_array = explode(" ", $texto);
		
		// Primero lugares
		$datos["lugares"] = $this -> lugares_model -> buscar($texto_array);
		// Luego las salas
		$datos["salas"] = $this -> salas_model -> buscar($texto_array);
		// Y por ultimo las reservas
		$datos["reservas"] = $this -> reservas_model -> buscar($texto_array);
		
		$usuario = $this -> ssouva -> login();
		// Enviamos el enif a la pagina
		$datos["usuario"] = $usuario;
		
		// Comprobamos si es administrador
		if ($this -> administradores_model -> es_administrador($usuario) == true) {
			$datos["permisos"] = 1;
		} else {
			$datos["permisos"] = 2;
		}
		$datos["identificado"]=TRUE;
		
		$this -> load -> view("principal",$datos);
		
		$this -> load -> view("buscar", $datos);
		
		$this -> load -> view("pie_view");
	 }
}