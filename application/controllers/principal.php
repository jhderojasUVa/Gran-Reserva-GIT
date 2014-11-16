<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends CI_Controller {

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
		$this -> load -> model("recursos_model");
		
		$this -> load -> model("administradores_model");
		
		$prefs_calendario = array (
				'start_day'    => 'monday',
				//'month_type'   => 'long',
				'day_type'     => 'abr',
				'show_next_prev'	=> 'true',
				'next_prev_url'   => 'http://www5.uva.es/gran_reserva/index.php/principal/index'
			 );
		
		$this -> load -> library("SSOUVa");
		$this -> load -> library("calendar", $prefs_calendario);
		$this -> load -> library("Funccalendario");
		$this -> load -> library("sesiones_usuarios");
		
		//Para filtrar los nombres de los ficheros
		$this->load->helper('security');
		
		//$this->load->helper('cadenas');
		
		$this->load->library("LDAP");
		
		$this -> load -> config("calendario");
	 }
	 
	public function index()	{		
		// Cargamos la pagina
		$usuario = $this -> ssouva -> login();
		// Enviamos el enif a la pagina
		$datos["usuario"] = $usuario;
		
		// Comprobamos si es administrador
		if ($_SESSION["fue_admin"] == false) {
			if ($this -> administradores_model -> es_administrador($usuario) == true) {
				$this -> sesiones_usuarios -> que_es("si", "si");
			} else {
				$this -> sesiones_usuarios -> que_es("no", "si");
			}
		}
		
		$datos["lugares"] = $this -> lugares_model -> show_todos_lugar();
		
		$this -> load -> view("principal",$datos);
		
		// Generacion del calendario para otras fechas
		$ano = $this -> input -> get("ano", true);
		$mes = $this -> input -> get("mes", true);
		
		if (!$ano || !$mes) {
			$ano = $this->uri->segment(3);
			$mes = $this->uri->segment(4);
		}
		
		// Esto hay que cambiarlo
		if ($this -> input -> get("sala") || $this -> input -> post("sala")) {
			if ($this -> input -> get("sala")) {
				$datos["sala"] = $this -> input -> get("sala");
				$datos["lugar_estoy"] = $this -> input -> get("lugar");
			} else {
				$datos["sala"] = $this -> input -> post("sala");
				$datos["lugar_estoy"] = $this -> input -> post("lugar");
			}
		} else {
			$datos["sala"] = 1;
			$datos["lugar_estoy"] = 1;
		}
		
		$datos["sala_nombre"] = $this -> salas_model -> nombre_sala ($datos["sala"]);
		
		$datos["datos_horario"] = $this -> horarios_model -> saca_horario_sala($datos["sala"]);
		$datos["paso_horario"] = $this -> horarios_model -> calcula_paso_horario_desde_sala($datos["sala"]);
		
		// Sacamos lo necesario segun el pollo que sea
		if ($_SESSION["es_admin"]==true) {
			$datos["mis_lugares"] = $this -> lugares_model -> soy_admin_de($usuario);
			$datos["sin_confirmar_total"] = $this -> reservas_model -> reservas_sin_confirmar($usuario, true);
			$datos["todas_reservas_pendientes"] = $this -> reservas_model -> show_todas_reservas_pendientes($usuario, $datos["sala"]);
			
			foreach ($datos["mis_lugares"] as $row) {
				$datos["reservas"][] = $this -> reservas_model -> show_reservas_sala($row -> id_sala, date("m"));
			}
			
			if ($this -> input -> get("mes")) {
				$mes =$this -> input -> get("mes");
			} else {
				$mes = date("m");
			}
			
			if ($this -> input -> get("ano")) {
				$ano = $this -> input -> get("ano");
			} else {
				$ano = date("Y");
			}
			
			$datos["mes"] = $mes;
			$datos["ano"] = $ano;
			
			$datos["reservas_pollo"] = $this -> reservas_model -> show_reservas_sala_ano($datos["sala"], $mes, $ano);
			//log_message("DEBUG", "fecha: ".$mes."-".$ano." sala ".$datos["sala"]);
			$this -> load -> view("panel_control_view", $datos);
			$this -> load -> view("panel_control/inicio", $datos);
		} else {
			$datos["recursos_sala"] = $this -> recursos_model -> recursos_sala($datos["sala"]);
			$datos["sin_confirmar_total"] = $this -> reservas_model -> reservas_sin_confirmar($usuario, false);
			$this -> load -> view("calendario",$datos);
		}
		
		// Cargamos el pie
		$this -> load -> view("pie_view");
	}
	
	function logout() {
		// Funcion que hace el logout del SSO
		
		// Primero los datos necesarios
		$usuario = $this -> ssouva -> login();
		$ssoid = $_COOKIE["isotrol_sso_cookie"];
		
		// Ahora el logout
		session_destroy();
		$this -> ssouva -> logout($usuario, $ssoid);
	}
	
}