<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendario extends CI_Controller {

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
			'next_prev_url'   => 'http://www5.uva.es/gran_reserva/index/'
		 );
		
		$this -> load -> library("SSOUVa");
		$this -> load -> library("calendar", $prefs_calendario);
		$this -> load -> library("Funccalendario");
		$this -> load -> library("sesiones_usuarios");
		
		$this -> load -> library("mail_uva");
		
		//Para filtrar los nombres de los ficheros
		$this->load->helper('security');
		
		$this->load->library("LDAP");
	 }
	 
	 public function lista() {
		// Este controlador muestra en formato lista todos las reservas "futuras" del mes en curso
		
		// Lo primero es recoger las variables
		$ano = $this -> input -> get("ano");
		$mes = $this -> input -> get("mes");
		$sala = $this -> input -> get("sala");
		
		// Luego saber el usuario
		$usuario = $this -> ssouva -> login();
		
		// Comprobamos si es administrador
		if ($_SESSION["fue_admin"] == false) {
			if ($this -> administradores_model -> es_administrador($usuario) == true) {
				$this -> sesiones_usuarios -> que_es("si", "si");
			} else {
				$this -> sesiones_usuarios -> que_es("no", "si");
			}
		}
		
		// Luego sacar las reservas del usuario de ese mes y tal
		$datos["reservas_pollo"] = $this -> reservas_model -> show_reservas_pollo($sala, $mes, $ano, $usuario);
		
		// Datos para la pagina
		$datos["usuario"] = $usuario;
		$datos["sala"] = $sala;
		$datos["sala_nombre"] = $this -> salas_model -> nombre_sala ($datos["sala"]);
		$datos["identificado"]=TRUE;
		$datos["sin_confirmar_total"] = $this -> reservas_model -> reservas_sin_confirmar($usuario, false);
		$datos["lugares"] = $this -> lugares_model -> show_todos_lugar();
		
		// Vistas
		$this -> load -> view("principal",$datos);
		$this -> load -> view("lista",$datos);
		
		// Cargamos el pie
		$this -> load -> view("pie_view");
	 }
	 
	 public function reservar_vista() {
		$datos["horario"]["dia"] = $this -> input -> get("dia");
	 	$datos["horario"]["ano"] = $this -> input -> get("ano");
		$datos["horario"]["mes"] = $this -> input -> get("mes");
		$datos["horario"]["sala"] = $this -> input -> get("sala");
		$datos["horario"]["hora"] = $this -> input -> get("hora");
		
		$usuario = $this -> ssouva -> login();
		
		$datos["identificado"]=TRUE;
		$datos["usuario"] = $usuario;
		$datos["sala"] = $datos["horario"]["sala"];
		$datos["datos_sala"] = $this -> salas_model -> show_sala($datos["sala"]);
		
		$datos["recursos_sala"] = $this -> recursos_model -> recursos_sala($datos["sala"]);
		
		$datos["paso_horario"] = $this -> horarios_model -> calcula_paso_horario_desde_sala($datos["sala"]);
		
		$this -> load -> view("reservas/reserva_formulario", $datos);
	 }
	 
	 public function reservar() {
	 	// Controlador para reservar sitios
		$usuario = $this -> ssouva -> login();
		
		// Pillamos todos los datos
		$diai = $this -> input -> post("diai");
		$mesi = $this -> input -> post("mesi");
		$anoi = $this -> input -> post("anoi");
		$horai = $this -> input -> post("horai");
		$minutoi = $this -> input -> post("minutoi");
		
		$diaf = $this -> input -> post("diaf");
		$mesf = $this -> input -> post("mesf");
		$anof = $this -> input -> post("anof");
		$horaf = $this -> input -> post("horaf");
		$minutof = $this -> input -> post("minutof");
		
		$descripcion = $this -> input -> post("descripcion");
		$sala = $this -> input -> post("sala");
		
		$contacto = $this -> input -> post("contacto");
		
		// Esto, esto, esto... siempre
		$confirmado = false;
		
		// Comprobamos que no hay reservas que coincidan (por casualidad) con esta cosa
		//log_message("DEBUG", "reserva inicial");
		
		$diai = $this -> funccalendario -> menor_de_10($diai);
		$mesi = $this -> funccalendario -> menor_de_10($mesi);
		$diaf = $this -> funccalendario -> menor_de_10($diaf);
		$mesf = $this -> funccalendario -> menor_de_10($mesf);
		
		$conjunto_reserva_i = $this -> crea_conjunto ($anoi."-".$mesi."-".$diai." ".$horai.":".$minutoi, $anof."-".$mesf."-".$diaf." ".$horaf.":".$minutof, $sala);
		
		// Vemos todas las reservas que hay y las "conjuntamos"
		$reservas_sala = $this -> reservas_model -> show_reservas_dia ($sala, $anoi."-".$mesi."-".$diai);
		
		$ocupado = 0;
		
		foreach ($reservas_sala as $row) {
			$conjunto_reserva_f = $this -> crea_conjunto($row -> inicio, $row -> fin, $sala); 
			
			if (count(array_intersect($conjunto_reserva_i, $conjunto_reserva_f))>=1) {
				$ocupado = 1;
			}
		}
		
		// Comprobamos si el sitio es con confirmacion o no para asi poner $confirmado = true o no
			if ($this -> salas_model -> sala_gestionada($sala) == true) {
				$confirmado = false;
			} elseif ($this -> salas_model -> sala_gestionada($sala) == false) { // ponemos el este entero no sea que algun pollo inyecte algo, que nunca se sabe
				$confirmado = true;
			}
			
		if ($confirmado == false) {
			$this -> reservas_model -> add_reserva ($sala, $anoi."-".$mesi."-".$diai." ".$horai.":".$minutoi.":00", $anof."-".$mesf."-".$diaf." ".$horaf.":".$minutof.":00", $usuario, $confirmado, $descripcion, $contacto);
			echo "Estado: <strong>Reserva realizada</strong>. El <strong>administrador ha de validar su reserva</strong>.";
			
			$mensaje_correo = "Existe una reserva sin confirmar en la sala ".$this -> salas_model -> nombre_sala($sala).".\r\n\r\nFecha de inicio: ".$diai."/".$mesi."/".$anoi."\r\nFecha de fin: ".$diaf."/".$mesf."/".$anof."\r\nPor favor, entre http://granreserva.uva.es y acceda con su usuario y contraseña de administrador para revisarlo.";
			$administrador = $this -> salas_model -> quien_admin_sala($sala);
			$administrador = $this -> ldap -> sacar_datos_ldap($administrador);
			
			$this -> mail_uva -> envia_mail($administrador["mail"], "Reserva de pendiende de confirmacion", $mensaje_correo); 
			
			$mensaje_correo = "Su reserva en la sala ".$this -> salas_model -> nombre_sala($sala)." esta pendiende de que el administrador de la sala la confirme.\r\nCuando sea confirmada recibira un correo.";
			
			$usuario_datos = $this -> ldap -> sacar_datos_ldap($usuario);
			
			$this -> mail_uva -> envia_mail($usuario_datos["mail"], "Reserva pendiente de confirmacion", $mensaje_correo);
		} else {
			if ($ocupado == 0) {
				$this -> reservas_model -> add_reserva ($sala, $anoi."-".$mesi."-".$diai." ".$horai.":".$minutoi.":00", $anof."-".$mesf."-".$diaf." ".$horaf.":".$minutof.":00", $usuario, $confirmado, $descripcion, $contacto);
				echo "Estado: <strong>Reserva realizada</strong>";
			} else {
				echo "Estado: <strong>Ha habido un problema con su reserva.</strong> Seguramente alguna hora este ocupada.";
			}
		}
		
	 }
	 
	 public function ver_reserva () {
	 	// Funcion que muestra una reserva
		// Por ahora a lo cutre, luego con ajax pino para que salga, pero... boh paso
		
		// Primero lo estandar, que visto lo visto lo voy a poner en una funcion
		$usuario = $this -> ssouva -> login();
		
		$datos["usuario"] = $usuario;
		$datos["sala"] = $this -> input -> get("sala");
		$datos["datos_sala"] = $this -> salas_model -> show_sala($datos["sala"]);
		
		$id_reserva = $this -> input -> get("id");
		
		$datos["duenyo_reserva"] = $this -> reservas_model -> coindice_persona_con_reserva($id_reserva,$datos["usuario"]);
		
		$datos["datos_reserva"] = $this -> reservas_model -> show_reserva($id_reserva);
		
		$this -> load -> view("reservas/show_reserva", $datos);
	 }
	 
	 public function editar_reserva() {
	 	// Funcion que saca la reserva y la edita si el pollo cambia algo y tal y pascual
		// Esto ha de ir en ajaxpino y tal y maragall y tal y tal...
		
		if ($this -> input -> get("id")) {
			$id_reserva = $this -> input -> get("id");
		} else {
			$id_reserva = $this -> input -> post("id");
		}
		
		$usuario = $this -> ssouva -> login();
		
		$datos["identificado"]=TRUE;
		$datos["usuario"] = $usuario;
		$datos["sala"] = $this -> reservas_model -> show_sala_por_reserva($id_reserva);
		$datos["datos_sala"] = $this -> salas_model -> show_sala($datos["sala"]);
		
		if ($this -> input -> get("id")) {
			$id_reserva = $this -> input -> get("id_reserva");
		} else {
			$id_reserva = $this -> input -> post("id_reserva");
		}
		
		$datos["datos_reserva"] = $this -> reservas_model -> show_reserva($id_reserva);
		
		if ($this -> input -> post("cambio")==1) {
			// Si ha cambiado algo de la reserva
			// Recogemos la mierda (solo la descripcion porque es lo unico que....
			$descripcion = $this -> input -> post("descripcion");
			$this -> reservas_model -> update_descripcion_reserva($id_reserva, $descripcion);
			log_message("DEBUG", ">>>>>>>>>>>>>>> UPDTEADO descripcion = ".$descripcion);
			$contacto = $this -> input -> post("contacto");
			$this -> reservas_model -> update_contacto_reserva($id_reserva, $contacto);
			log_message("DEBUG", ">>>>>>>>>>>>>>> UPDTEADO contacto = ".$contacto);
			
		} else {
			// Si solo la quiere mostrar y tal y pascual y maragal
			$this -> load -> view("reservas/editar_reserva", $datos);
		}
	 }
	 
	 public function borrar_reserva() {
	 	// Funcion para borrar la reserva
		// Esto tambien pal ajax... que es como los webservices que lo mismo te valen pa un cocido que pa'un costipau
		
		// Si, tiene una brecha de seguridad cojonuda, lo se
		// En la vista hay que hacer un javascript de los de "estas seguro pollo?"
		
		// Modificamos para vder si el pollo es admin y enviar el borrado como admin, total si intenta de un sitio que no tiene permisos, le mandaremos al pairo
		
		$usuario = $this -> ssouva -> login();
		
		$admin = $this -> administradores_model -> es_administrador($usuario);
		
		$id_reserva = $this -> input -> get("id");
		$confirmar = $this -> input -> get("ok");
		
		// Primero recuperamos los datos de la reserva antes de enviar el correo
		$datos_reserva = $this -> reservas_model -> show_reserva($id_reserva);
		
		foreach ($datos_reserva as $row) {
			$usuario_reserva = $row -> persona;
			$sala_tmp = $row -> sala;
			$inicio = $row -> inicio;
			$fin = $row -> fin;
		}
		
		$sala = $this -> salas_model -> nombre_sala($sala_tmp);
		$admin_sala = $this -> salas_model -> quien_admin_sala($sala_tmp);
		
		$usuario_mail = $this -> ldap -> sacar_datos_ldap($usuario_reserva);
		
		// Sacamos los datos del admin para enviarle los correos
		
		$datos_admin_sala = $this -> ldap -> sacar_datos_ldap($admin_sala);
		
		if ($id_reserva && $confirmar==1) {
			// Comprobamos que quien la borra es el mismo que quien la hace porque sino...
			if ($admin == true) {
				$vuelta = $this -> reservas_model -> del_reserva($id_reserva, $usuario, true);
			} else {
				$vuelta = $this -> reservas_model -> del_reserva($id_reserva, $usuario, false);
			}
			
			// Sacamos el error correspondiente si el pollo no puede o si se ha eliminado bien
			if ($vuelta == true) {
				echo "Eliminado con exito.";
				
				// Enviamos el correo
				if ($admin == true) {
					
					$mensaje = "Estimado ".$usuario_mail["nombre"].".\r\nLa reserva para la sala ".$sala." para la fecha ".$inicio." ha sido eliminada.\r\nNo se requiere ninguna acción adicional.\r\n\r\nGracias por usar este servicio.";
				} else {
					$mensaje = "Estimado ".$usuario_mail["nombre"].".\r\nLa reserva para la sala ".$sala." para la fecha ".$inicio." ha sido eliminada por el administrador y responsable de la sala.\r\nNo se requiere ninguna acción adicional.\r\n\r\nGracias por usar este servicio.";
				}
				$this -> mail_uva -> envia_mail($usuario_mail["mail"], "Borrado de reserva en ".$sala, $mensaje);
				// Mandamos el correo al admin de la sala
				$mensaje_admin = "La reserva del usuario: ".$usuario_mail["nombre"]." - ".$usuario_mail["mail"]."\r\nHa sido borrada para la sala ".$sala." para la fecha ".$inicio.".";
				$this -> mail_uva -> envia_mail($admin_sala["mail"], "Borrado de reserva en ".$sala, $mensaje_admin);
				
			} else {
				echo "Ha habido un error al intentar borrar la reserva. Puede que no tenga permisos para borrarla.";
			}
		}
	 }
	 
	 
	 /*
	 
	 	Funciones para todas las funciones de arriba de este controlador
	 
	 */
	 
	 function crea_conjunto ($fechai, $fechaf, $sala) {
	 	// Funcion que comprueba si hay sitio libre en la reserva
		// Lo hacemos por teoria de conjuntos, para ver si hay intersección entre los dos y por lo tanto no se puede
		
		$diai = substr($fechai, 0, 10);
		$diaf = substr($fechaf, 0, 10);
		
		$horai = substr($fechai, 11, 2);
		$minutoi = substr($fechai, 14, 2);
		$horai = $horai + ($minutoi/60);
		
		
		$horaf = substr($fechaf, 11, 2);
		$minutof = substr($fechaf, 14, 2);
		$horaf = $horaf + ($minutof/60);
		
		// Sacamos el paso horario
		$paso_horario = (1/$this -> horarios_model -> calcula_paso_horario_desde_sala($sala));
		// Calculamos para sacar el conjunto de horas
		for ($i=$horai; $i<=$horaf; $i=$i+$paso_horario) {
			$conjuntoinicio[] = $i;
		}
		
		return $conjuntoinicio;
	 }
}