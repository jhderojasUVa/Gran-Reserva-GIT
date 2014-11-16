<?php
/*
 * Copyright 2008 Jorge López Pérez <jorgelp@us.es>
 *
 *    This file is part of Consigna.
 *
 *    Consigna is free software: you can redistribute it and/or modify it
 *    under the terms of the GNU Affero General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    Consigna is distributed in the hope that it will be useful, but
 *    WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *    Affero General Public License for more details.
 *
 *    You should have received a copy of the GNU Affero General Public
 *    License along with Consigna.  If not, see
 *    <http://www.gnu.org/licenses/>.
 */

class LDAP {
	var $CI;

	function LDAP() {
		$this->CI =& get_instance();
		$this->CI->config->load('ldap');
	}

	/**
	 * Lleva a cabo la autenticación contra LDAP
	 *
	 * @return	-1 si falla, 1 si es correcto. El identificador de usuario
	 * final se envía en $id
	 */
	function login_action(&$err, &$id) {
		$opciones = $this->CI->config->item('ldap');

		 $ds = @ldap_connect($opciones["host"], $opciones["puerto"]);
		 if (!$ds) {
			log_message('error', 'No se puede conectar a LDAP');
			$err = 'Existe un problema temporal con la autenticación. '
				 .'Por favor, pruebe más tarde.';
			return -1;
		 }

		 // Recogida de valores y comprobación de
		 // validez
		 $usuario = $this->CI->input->post('usuario');
		 $passwd = $this->CI->input->post('passwd');

		 $id = $usuario;


		 // Búsqueda del DN del usuario, para posteriormente hacer bind
		 // con él
		if (@ldap_bind($ds, $opciones['dnadmin'],
					$opciones['passwdadmin']) !== TRUE) {
			log_message('error', 'No se pudo hacer bind. Revise la configuración');
			$err = 'Existe un problema temporal con la autenticación. '
				 .'Por favor, pruebe más tarde.';
			return -1;
		}
		// Modificado por Tuti
		 $atributos = array('dn' , 'sn', 'givenName', 'mail');
		 //$atributos = array('dn' , 'sn', 'cn', 'mail');
		 $res = @ldap_search($ds, $opciones['base'],
				 	$opciones['uidattr'].'='.$usuario, $atributos);
		 if ($res === FALSE) {
			 $err = 'Nombre de usuario o contraseña erróneos';
			 return -1;
		 }
		 
		 $info = @ldap_get_entries($ds, $res);

		 if ($info['count'] == 0) {
			 $err = 'Nombre de usuario o contraseña erróneos';
			 return -1;
		 }

		 // Comprobamos que tenga todos los datos
		 if ($info[0]['count'] < 3) {
			 $err = 'Sus datos de usuario están incompletos. Por favor, '
				 .'póngase en contacto con '
				 . $this->CI->config->item('texto_contacto');
			 return -1;
		 }

		 // Una vez conocido el DN, intentamos hacer bind de nuevo
		 $dn_usuario = $info[0]['dn'];
		 $id = $dn_usuario;

		 $ret = @ldap_bind($ds, $dn_usuario, $passwd);
		 @ldap_unbind($ds);

		 if ($ret !== FALSE) {
			 return 1;
		 } else {
			 $err = 'Nombre de usuario o contraseña erróneos';
			 return -1;
		 }
	}

	/**
	 * Extrae la información asociada a un DN de LDAP
	 *
	 * @param 	string dn 
	 * @return	FALSE si falla, o un array con los datos del usuario
	 */

	function get_user_data($id) {
		//log_message("debug","-->get_user_data ($id)");
		$opciones = $this->CI->config->item('ldap');
		$ds = @ldap_connect($opciones["host"], $opciones["puerto"]);
		if (!$ds) {
			log_message('error', 'No se puede conectar a LDAP');
			return FALSE;
		}

		if (@ldap_bind($ds, $opciones['dnadmin'],
					$opciones['passwdadmin']) !== TRUE) {
			log_message('error', 'No se pudo hacer bind. Revise la configuración');
			return FALSE;
		}

		// Modificado por Tuti,
		 $atributos = array('dn' , 'uid', 'cn', 'givenName');
		 //$atributos = array('dn' , 'sn', 'cn', 'mail');

		$res = ldap_search($ds, $opciones["base"], "uid=".$id.")"); //);
		log_message("DEBUG", "LDAP: ds=".$ds." opciones=".$opciones["base"]." filtro=(uid=".$id.")");
		$info = @ldap_get_entries($ds, $res);

		if ($info['count'] == 0) {
			log_message('error', 'Búsqueda en LDAP de usuario inexistente: '
					. $id);
			return FALSE;
		}

		@ldap_unbind($ds);

		//print_r($info);

		// Ponemos los datos como deseamos
		$datos = array(
				'id' => $info[0]['dn'],
				// By Tuti, cambiado de givenname a cn
				'name' => ucwords(strtolower($info[0]['cn'][0]
				//'name' => ucwords(strtolower($info[0]['cn'][0] 
						. ' ' .  $info[0]['sn'][0])),
				'mail' => $info[0]['mail'][0],
				//'uvaNIF' => $info[0]['uvanif'][0],
				'timestamp' => time(),
		);

		return $datos;
	}

	/**
	 * Expira las entradas en la caché que tengan más de 12h
	 * TODO tiempo configurable
	 */
	function cache_expiration() {
		$fechaexp = time() - 12 * 60 * 60;
		$this->CI->db->where('timestamp <=', $fechaexp);
		$this->CI->db->delete('usercache'); 
	}

	/**
	 * Form fields
	 */

	function has_form() {
		return TRUE;
	}

	/**
	 * Logout
	 */
	function logout() {
	}
	
	function sacar_datos_ldap($idusuario) {
		// Funcion que devuelve los datos del usuario
		
		$uid = $idusuario;
		
		// Primero nos conectamos
		$opciones = $this->CI->config->item('ldap');
		$ds = @ldap_connect($opciones["host"], $opciones["puerto"]);
		if (!$ds) {
			log_message('error', 'No se puede conectar a LDAP');
			return FALSE;
		}

		if (@ldap_bind($ds, $opciones['dnadmin'],
					$opciones['passwdadmin']) !== TRUE) {
			log_message('error', 'No se pudo hacer bind. Revise la configuración');
			return FALSE;
		}
		
		$atributos = array("sn", "givenName", "mail", "telephonenumber", "uvacolectivos");
		//$sr = ldap_search ($idconexion, "ou=personal,dc=uva,dc=es", "(&(uid=".$uid.")(uvaDominioCorreo=uva.es)(|(uvaColectivos=2)(uvaColectivos=3)(uvaColectivos=9)))", $atributos);
		$sr = ldap_search ($ds, "ou=personal,dc=uva,dc=es", "uid=".$idusuario, $atributos);
		//log_message("DEBUG", "ldap_search ".$ds." | ou=personal,dc=uva,dc=es | (uid=".$idusuario.")");
		$busqueda = ldap_get_entries ($ds, $sr);

		$datos = array("nombre" => $busqueda[0]["givenname"][0], "mail" => $busqueda[0]["mail"][0], "extension" => $busqueda[0]["telephonenumber"][0], "colectivo" =>$busqueda[0]["uvacolectivos"][0]);
		//print_r($busqueda);

		return $datos;
	}
}

?>
