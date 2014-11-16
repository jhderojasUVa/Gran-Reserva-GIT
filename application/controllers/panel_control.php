<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel_control extends CI_Controller { //Principal { //CI_Controller {
	
	// Este controlador incorpora todo lo necesario (o casi todo, que narices) para el panel de control de un usuario
	// con derechos de administrador

	public function __construct() {
		parent::__construct();
		
		// Carga de modelos y librerias
		$this -> load -> model("lugares_model");
		$this -> load -> model("reservas_model");
		$this -> load -> model("salas_model");
		$this -> load -> model("horarios_model");
		
		$this -> load -> model("administradores_model");
		$this -> load -> model("observaciones_model");
		
		$prefs_calendario = array (
				'start_day'    => 'monday',
				//'month_type'   => 'long',
				'day_type'     => 'abr',
				'show_next_prev'	=> 'true',
				'next_prev_url'   => 'http://www5.uva.es/gran_reserva/index.php/principal/index'
			 );
		
		$this -> load -> library("SSOUVa");
		$this -> load -> library("calendar", $prefs_calendario);
		
		//Para filtrar los nombres de los ficheros
		$this->load->helper('security');
		
		//$this->load->helper('cadenas');
		
		$this->load->library("LDAP");
		
		$this -> load -> library("funccalendario");
		$this -> load -> library("sesiones_usuarios");
		$this -> load -> library("Mail_UVa");
		
	}
	
	public function index() {
		// Funcion por defecto
		// Cargamos la pagina
		
		// La inyeccion de lo basico esta aqui
		$usuario = $this -> ssouva -> login();
		// Enviamos el enif a la pagina
		$datos["usuario"] = $usuario;
		
		// Comprobamos si es administrador
		if ($this -> administradores_model -> es_administrador($usuario) == true) {
			$this -> sesiones_usuarios -> que_es("si", "si");
		} else {
			$this -> sesiones_usuarios -> que_es("no", "si");
		}
		
		$datos["lugares"] = $this -> lugares_model -> show_todos_lugar();
		
		$datos["identificado"]=TRUE;
		
		if ($this -> input -> get("sala")) {
			$datos["sala"] = $this -> input -> get("sala");	
		} elseif ($this -> input -> post("sala")) {
			$datos["sala"] = $this -> input -> post("sala");
		} else {
			$datos["sala"] = $this -> administradores_model -> sala_defecto($usuario);
		}
		
		$this -> load -> view("principal",$datos);
		
		// Sacamos lo necesario segun el pollo que sea
		if ($_SESSION["es_admin"]==true) {
			$datos["mis_lugares"] = $this -> lugares_model -> soy_admin_de($usuario);
			$datos["sin_confirmar_total"] = $this -> reservas_model -> reservas_sin_confirmar($usuario, true);
			$datos["todas_reservas_pendientes"] = $this -> reservas_model -> show_todas_reservas_pendientes($usuario, $datos["sala"]);
			$this -> load -> view("panel_control_view",$datos);
		} else {
			$datos["sin_confirmar_total"] = $this -> reservas_model -> reservas_sin_confirmar($usuario, false);
			$this -> load -> view("calendario",$datos);
		}
		// Fin de la inyeccion de lo basico
		
		// Cargamos el pie
		$this -> load -> view("pie_view");
		
	}
	
	public function mostrar_lugares() {
		// Control que mostrara los sitios a los que el administrador tiene acceso con algunos resumenes de cosas
		// como las reservas sin confirmar o cosas asi
	}
	
	public function sin_confirmar() {
		// Control que muestra las reservas sin confirmar
		
		$usuario = $this -> ssouva -> login();
		// Enviamos el enif a la pagina
		$datos["usuario"] = $usuario;
		
		// Esto se puede meter en una funcion
		if ($this -> input -> get("sala")) {
			$datos["sala"] = $this -> input -> get("sala");	
		} elseif ($this -> input -> post("sala")) {
			$datos["sala"] = $this -> input -> post("sala");
		} else {
			$datos["sala"] = $this -> administradores_model -> sala_defecto($usuario);
		}
		
		// Para la fecha
		if ($this -> input -> get("mes")) {
			$mes = $this -> input -> get("mes");
		} elseif ($this -> input -> post("mes")) {
			$mes = $this -> input -> post("mes");
		} else {
			$mes = date("m");
		}
		
		if ($this -> input -> get("ano")) {
			$ano = $this -> input -> get("ano");
		} elseif ($this -> input -> post("ano")) {
			$ano = $this -> input -> post("ano");
		} else {
			$ano = date("Y");
		}
		
		
		if ($this -> input -> post("confirmando")==1) {
			// Ha confirmado y la cambiamos de estado
			$id_reserva = $this -> input -> post("id_res");
			$confirmado = $this -> reservas_model -> confirm_reserva($id_reserva);
			
			// Sacamos los datos de la reserva para enviar el correo
			$datos_reserva = $this -> reservas_model -> show_reserva($id_reserva);
			
			foreach ($datos_reserva as $row) {
				$usuario_reserva = $row -> persona;
				$sala_tmp = $row -> sala;
				$inicio = $row -> inicio;
				$fin = $row -> fin;
			}
		
			$sala = $this -> salas_model -> nombre_sala($sala_tmp);
			
			$usuario_mail = $this -> ldap -> sacar_datos_ldap($usuario_reserva);
			
			// Enviamos el correo de confirmacion
			$mensaje = "Estimado ".$usuario_mail["nombre"]."\r\n\r\nLe confirmamos que su reserva para ".$sala." para el ".$inicio." ha sido confirmada por el administrador de la sala.\r\nPor favor, pongase en contaco con la conserjeria del edificio antes de la celebración del acto o la reunión.\r\nNo se requiere de ninunga otra accion por su parte.";
			$this -> mail_uva -> envia_mail($usuario_mail["mail"], "Confirmacion de su reserva en ".$sala, $mensaje);
		}
		
		$datos["mes"] = $mes;
		$datos["ano"] = $ano;
		
		$datos["mis_lugares"] = $this -> lugares_model -> soy_admin_de($usuario);
		$datos["sin_confirmar_total"] = $this -> reservas_model -> reservas_sin_confirmar($usuario, true);
		$datos["todas_reservas_pendientes"] = $this -> reservas_model -> show_todas_reservas_pendientes($datos["usuario"], $datos["sala"]);
		$datos["nombre_sala"] = $this -> salas_model -> nombre_sala($datos["sala"]);
		
		// Sacamos una lista de las reservas que estan pendientes para mostrarlas
		$datos["sin_confirmar"] = $this -> reservas_model -> show_reservas_pendientes_array($datos["usuario"], $mes, $ano, $datos["sala"]);
		
		$this -> load -> view("principal", $datos);
		
		$this -> load -> view("panel_control_view",$datos);
		$this -> load -> view("panel_control/confirmar", $datos);
		$this -> load -> view("pie_view");
		
	}
	
	public function confirmar() {
		/*
		
		ACTUALMENTE EN DESUSO
		
		// Funcion que confirma una reserva en una sala
		
		log_message("DEBUG", ">>>>>>>>>>>>>>>>>>>>>> Estoy en CONFIRMAR");
		
		$usuario = $this -> ssouva -> login();
		// Enviamos el enif a la pagina
		$datos["usuario"] = $usuario;
		
		$id_reserva = $this -> input -> post("id_res");
		$sala = $this -> input -> post("sala");
		$mes = $this -> input -> post("mes");
		$ano = $this -> input -> post("ano");
		
		$datos_reserva = $this -> reservas_model -> show_reserva($id_reserva);
		$usuario_reserva = $datos_reserva -> persona;
		$sala = $this -> salas_model -> nombre_sala($datos_reserva -> sala);
		
		$confirmado = $this -> reservas_model -> confirm_reserva($id_reserva);
		
		// Enviamos el correo de confirmacion
		$mensaje = "Estimado ".$usuario_reserva."\r\n\r\nLe confirmamos que su reserva para ".$sala." para el ".$datos_reserva -> inicio." ha sido confirmada por el administrador de la sala.\r\nNo se requiere de ninunga otra accion por su parte.";
		$this -> mail_uva -> envia_mail($usuario_reserva, "Confirmacion de su reserva en ".$sala, $mensaje);
		
		// Cargamos la otra vista
		$datos["mes"] = $mes;
		$datos["ano"] = $ano;
		
		$datos["mis_lugares"] = $this -> lugares_model -> soy_admin_de($usuario);
		$datos["sin_confirmar_total"] = $this -> reservas_model -> reservas_sin_confirmar($usuario, true);
		$datos["todas_reservas_pendientes"] = $this -> reservas_model -> show_todas_reservas_pendientes($datos["usuario"], $datos["sala"]);
		$datos["nombre_sala"] = $this -> salas_model -> nombre_sala($datos["sala"]);
		
		// Sacamos una lista de las reservas que estan pendientes para mostrarlas
		$datos["sin_confirmar"] = $this -> reservas_model -> show_reservas_pendientes_array($datos["usuario"], $mes, $ano, $datos["sala"]);
		
		$this -> load -> view("principal", $datos);
		
		$this -> load -> view("panel_control_view",$datos);
		$this -> load -> view("panel_control/confirmar", $datos);
		$this -> load -> view("pie_view");
		
		// Deberiamos enviar un mail al usuario....
		*/
		
	}
	
	public function entrar_como_user_normal() {
		$usuario = $this -> ssouva -> login();
		// Enviamos el enif a la pagina
		$datos["usuario"] = $usuario;
		
		$this -> sesiones_usuarios -> cambiar_tipo();
		
		// Recargamos la web del todo
		header('Location: http://www5.uva.es/gran_reserva/');
	}
	
	public function missitios() {
		// Control de que pinta los sitios de un pollo

		$usuario = $this -> ssouva -> login();
		// Enviamos el enif a la pagina
		$datos["usuario"] = $usuario;
		$datos["identificado"]=TRUE;
		
		if ($this -> administradores_model -> es_administrador($usuario) == true) {
			$this -> sesiones_usuarios -> que_es("si", "si");
		} else {
			$this -> sesiones_usuarios -> que_es("no", "si");
		}
		
		if ($this -> input -> get("sala")) {
			$datos["sala"] = $this -> input -> get("sala");	
		} elseif ($this -> input -> post("sala")) {
			$datos["sala"] = $this -> input -> post("sala");
		} else {
			$datos["sala"] = $this -> administradores_model -> sala_defecto($usuario);
		}
		
		$datos["mis_lugares"] = $this -> lugares_model -> soy_admin_de($usuario);
		$datos["sin_confirmar_total"] = $this -> reservas_model -> reservas_sin_confirmar($usuario, true);
		$datos["todas_reservas_pendientes"] = $this -> reservas_model -> show_todas_reservas_pendientes($usuario, $datos["sala"]);
		
		// Cargamos las vistas
		$this -> load -> view("principal",$datos);
		
		$datos["mis_lugares"] = $this -> lugares_model -> soy_admin_de($usuario);
		$datos["sitios"] = $this -> salas_model -> show_todas_salas_usuario($usuario);
		
		$this -> load -> view("panel_control_view", $datos);
		$this -> load -> view("panel_control/sitios.php", $datos);
		
		$this -> load -> view("pie_view");
	}
	
	public function sitio() {
		// Funcion que te lleva a un sitio para ver las reservas de ese sitio (obviamente).
		
		$usuario = $this -> ssouva -> login();
		// Enviamos el enif a la pagina
		$datos["usuario"] = $usuario;
		
		// El sitio ES OBLIGATORIO
		$sala = $this -> input -> get ("id");
		$datos["sala"] = $sala;
		
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
		
		$datos["reservas_pollo"] = $this -> reservas_model -> show_reservas_sala_ano($sala, $mes, $ano);
		
		// Comprobamos si es administrador
		if ($this -> administradores_model -> es_administrador($usuario) == true) {
			$this -> sesiones_usuarios -> que_es("si", "si");
		} else {
			$this -> sesiones_usuarios -> que_es("no", "si");
		}
		
		$datos["lugares"] = $this -> lugares_model -> show_todos_lugar();
		
		$this -> load -> view("principal",$datos);
		
		// Sacamos lo necesario segun el pollo que sea
		if ($this -> sesiones_usuarios -> es_admin() == true) {
			$datos["mis_lugares"] = $this -> lugares_model -> soy_admin_de($usuario);
			$datos["sin_confirmar_total"] = $this -> reservas_model -> reservas_sin_confirmar($usuario, true);
			$datos["todas_reservas_pendientes"] = $this -> reservas_model -> show_todas_reservas_pendientes($usuario, $datos["sala"]);
			$this -> load -> view("panel_control_view",$datos);
		} else {
			$datos["sin_confirmar_total"] = $this -> reservas_model -> reservas_sin_confirmar($usuario, false);
			$this -> load -> view("calendario",$datos);
		}
		
		$this -> load -> view("panel_control/lista_reservas_sitios", $datos);
		
		$this -> load -> view("pie_view");
	}
		
	public function imprimir() {
		// Funcion para imprimir una lista de un mes
		$usuario = $this -> ssouva -> login();
		// Enviamos el enif a la pagina
		$datos["usuario"] = $usuario;
		
		$sala = $this -> input -> get ("id");
		$datos["sala"] = $sala;
		
		$datos["datos_sala"] = $this -> salas_model -> nombre_sala($datos["sala"]);
		
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
		$datos["mes_letras"] = $this -> funccalendario -> devuelve_mes_letras($mes);
		
		
		$datos["reservas_pollo"] = $this -> reservas_model -> show_reservas_sala_ano($sala, $mes, $ano);
		
		$this -> load -> view("panel_control/imprimir", $datos);
	}

	public function estadisticas() {
		// Control que saca las estadisticas
	}
	
	public function comentar() {
		// Funcion para poner comentarios a los usuarios de forma interna
		// SSO siempre lo primero
		$usuario = $this -> ssouva -> login();
		$datos["usuario"] = $usuario;
		
		if ($this -> input -> get("idreserva")) {
			$datos["reserva_denuncia"] = $this -> input -> get("idreserva");
		} elseif ($this -> input -> post("idreserva")) {
			$datos["reserva_denuncia"] = $this -> input -> post("idreserva");
		}
		
		// Metemos las variables para si viene de vacio
		$datos["usuario_denuncia"] = "";
		$datos["observaciones"] = "";
		
		if ($this -> input -> get("iduser")) {
			$datos["usuario_denuncia"] = $this -> input -> get("iduser");
		} elseif ($this -> input -> post("iduser")) {
			$datos["usuario_denuncia"] = $this -> input -> post("iduser");
		}
		
		if ($datos["usuario_denuncia"]<>"") {
			$datos["observaciones"] = $this -> observaciones_model -> show_observacion($datos["usuario"]);
		}
		
		if ($this -> input -> post("enviado")==1) {
			// Si hemos enviado chicha le creamos la observacion
			
			// Comprobamos si el pollo tiene una
			if ($this -> observaciones_model -> usuario_tiene_observacion($datos["usuario"])==true) {
				// Tiene una, la updateamos con lo que hayan puesto
				$observacion = $this -> input -> post("observaciones");
			$this -> observaciones_model -> update_observacion($usuario, $observacion);
				$datos["observaciones"] = $observacion;
				//echo "usuario: ".$usuario." | observaciones: ".$observacion;
			} else {
				// No tiene anterior le metemos caña
				$observacion = $this -> input -> post("observaciones");
				$this -> observaciones_model -> add_observacion($usuario, $observacion);
				$datos["observaciones"] = $observacion;
				//echo "usuario: ".$usuario." | observaciones: ".$observacion;
			}
		}
		
		$this -> load -> view("panel_control/observaciones",$datos);
	}
}