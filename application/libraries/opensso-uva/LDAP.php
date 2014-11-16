<?php
// Objeto LDAP para conectarse al LDAP UVa

class LDAP_UVa {

	var $ds;

	// Funcion de llamada
	function LDAP_UVA() {
		// Carga de la configuraci—n del LDAP dada
		// $this->CI->config->load('ldap');
		
	}

	// Funcion para conectarse al ldap UVa
	function conectar() {
		// Carmgamos las opciones del ldap
		
		$ds = ldap_connect("157.88.25.9","389");
		
		 if (!$ds) {
			log_message('error', 'No se puede conectar a LDAP');
			$err = 'Existe un problema temporal con la autenticaci—n. '
				 .'Por favor, pruebe m‡s tarde.';
			return -1;
		 } else {
		 	// Hacemos el bind
		 	$bind = ldap_bind($ds,"uid=consigna_uva,ou=personal,dc=uva,dc=es","Vh6ATzJP");
		 	if (!$bind) {
		 		log_message('error','Imposible hacer bind con los datos proporcionados');
		 		$err = 'Existe un problema temporal con la autentificaci—n. Por favor contacte con el administrador';
		 		return -1;
		 	}
		 	
		 	return $ds;
		 }

		 // Recogida de valores y comprobaci—n de validez
		 //$usuario = $this->CI->input->post('usuario');
		 //$passwd = $this->CI->input->post('passwd');

		 //$id = $usuario;
	
	}
	
	// Funcion para sacar los atrubutos
	// Necesario pasarle el ID a buscar y el atributo a recuperar
	function atributo($id, $atributo) {
	
		// 1 consulta pa'too
		
		
		
		// Primero nos conectamos
		$conexion = $this->conectar();
		
		// Luego con el id, sacamos el atributo
		
		$sr = ldap_search($conexion,"uid=".$id.",ou=personal,dc=uva,dc=es", $atributo);
		if (!$sr) {
			log_message('error', 'No se encontro '.$atributo);
			$err = 'Existe un en la busqueda del LDAP. '
				 .'Por favor, pruebe m‡s tarde.';
			return -1;
		} else {
			// Sacamos la informaci—n del atributo y lo devolvemos
			$info = ldap_get_entries($conexion, $sr);
			return $info[0][0];
		}
	}
	
	function datos_usuario($id) {
	
		// Primero creamos un array para los atributos
		// que le pasamos a la busqueda del ldap
		
		$atributos = array ("cn", "mail", "uvacolectivos");
		
		// Luego nos conectamos
		$conexion = $this->conectar();
		
		// Luego con el id, sacamos los atributos
		
		$sr = ldap_search($conexion,"uid=".$id.",ou=personal,dc=uva,dc=es","uid=".$id ,$atributos);
		if (!$sr) {
			log_message('error', 'No se encontro '.$atributo);
			$err = 'Existe un en la busqueda del LDAP. '
				 .'Por favor, pruebe m‡s tarde.';
			return -1;
		} else {
			// Sacamos la informaci—n de los atributos y lo devolvemos
			$info = ldap_get_entries($conexion, $sr);
			
			if ($info["count"]>0) {
				// Si hay datos...
				//for ($i=0;$i<=$info["count"];$i++){

				$i=0;
					//if ($info[$i]["uvacolectivo"][0]<>3 && $info[$i]["uvacolectivo"][0]) {
						$cn = $info[$i]["cn"][0];
						$mail = $info[$i]["mail"][0];
						$colectivo = $info[$i]["uvacolectivos"][0];
						
						error_log("DN=".$id.", CN=".$cn." MAIL=".$mail." colectivo=".$colectivo);
				//	}
				//}


				//Davidrod Priorizacion de los colectivos
                		if (!empty($info[0]['uvacolectivos']))
                		{
					if (in_array("2",$info[0]['uvacolectivos']))
					{
						$colectivo=2;
					} else if (in_array("9",$info[0]['uvacolectivos']))
					{
						$colectivo=9;
					} else if (in_array("23",$info[0]['uvacolectivos']))
					{
						$colectivo=23;
					} else if (in_array("3",$info[0]['uvacolectivos']))
					{
						$colectivo=3;
					} else if (in_array("1",$info[0]['uvacolectivos']))
                        		{
						$colectivo=1;
                        		}
                		}

				return array('id' => $id,
							 'name' => $cn, 
							 'mail' => $mail, 
							 'colectivo' => $colectivo, 
							 'timestamp' => time(),
							 );
			} else {
				return -1;
			}
		}
	}
	
	function salida($id) {
	
		// Funcion para hacer un logout del SSO del usuario
		// Aunque no es necesario, pasamos el uid porque es gratis
			
	}
}
?>
