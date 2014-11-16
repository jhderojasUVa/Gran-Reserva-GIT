<?php

//require_once("ISSOConstants.php");
//require_once("isso_config.php");

class ISSOClient {

		var $loginServer = "sso.uva.es";
		var $loginPort = "80";
		var $isLoginPage = "/isso/isso/isLogin.action";
		var $loginForm = "https://sso.uva.es/isso/isso/login.form";
		var $logoutForm = "https://sso.uva.es/isso/isso/logout.form";
		var $agent = "cliente";
		var $dominio = "uva.es";

		// URL de retorno del cliente identificado
		// Cambiarla al final
		var $return_url = "http://www5.uva.es/gran_reserva/";

	function ISSOClient()
	{}
	
	function isLogin($id)
	{
		//global $loginServer, $loginPort, $agent, $isLoginPage;
		
		$user = null;
		// Ruta de los logs del OpenSSO UVa
		// Cambiar a donde sea necesario
		$fp = fopen("/tmp/fichero.log","a");	
		fwrite($fp,date("Ymd").": id=".$id."\n");
		fwrite($fp,date("Ymd").": agent=".$this -> agent."\n");

		if($id != null && $id != "")
		{
			$xml = "<sso id=\"".$id."\" agent=\"".$this -> agent."\"/>";
			$params = array(P_SSO_XML => $xml);
			
			
			$http = new Net_HTTP_Client();

			$http->Connect($this -> loginServer, $this -> loginPort) or die("Error al conectar conectar con el servidor SSO");
			
			$status = $http->Post($this -> isLoginPage, $params);
			if($status != 200)
			{
				die("Problema : " . $http->getStatusMessage());
			}
			else
			{
			        $responseBody = $http->getBody();
					fwrite($fp,date("Ymd").": getBody OK\n");
					fwrite($fp,date("Ymd").": responseBody ".$responseBody."\n");
					
				$http->Disconnect();

                                /*
				$dom = domxml_open_mem($responseBody);
				if(!$dom)
					die("Error al parsear el XML de respuesta");
                                	
				$root = $dom->document_element();
				
				$r_id = $root->get_attribute("id");
				$r_agent = $root->get_attribute("agent");
				$r_user = $root->get_attribute("user");
                                */

                                $posicion = strpos($responseBody, "id=\"");
                                $substring = substr($responseBody, $posicion+4);
                                $r_id = substr($substring, 0, strpos($substring, "\""));
			fwrite($fp,"r_id ".$r_id."\n");
                                $posicion = strpos($responseBody, "agent=\"");
                                $substring = substr($responseBody, $posicion+7);
                                $r_agent = substr($substring, 0, strpos($substring, "\""));
			fwrite($fp,"r_agent ".$r_agent."\n");
                                $posicion = strpos($responseBody, "user=\"");
                                $substring = substr($responseBody, $posicion+6);
                                $r_user = substr($substring, 0, strpos($substring, "\""));
			/*fwrite($fp,"r_user ".$r_user."\n");
                                if($r_id && $r_agent && $r_user && $r_id == $id && $r_agent == $agent)*/
             fwrite($fp,"r_user ".$r_user."\n");
                                if($r_id && $r_agent && $r_user && $r_id == $id && $r_agent == $this -> agent)
				{
					$user = $r_user;
				}
			}
		}
		fclose($fp);
		return $user;
	}
	
	function verifica() {
		if(isset($_COOKIE[SSO_COOKIE]))
		{
			$id = $_COOKIE[SSO_COOKIE];
		}
		else if(isset($_GET[P_SSO_ID]))
		{
			$id = $_GET[P_SSO_ID];
		}

		if(isset($id))
		{
			$user = $this->isLogin($id);
		}
		else
		{
			$user = null;
		}	
		return $user;
	}
	
	function getCurrentSSOID() 	{
		if(isset($_COOKIE[SSO_COOKIE]))
		{
			$id = $_COOKIE[SSO_COOKIE];
		}
		else if(isset($_GET[P_SSO_ID]))
		{
			$id = $_GET[P_SSO_ID];
		}
		
		return $id;
	}
	
	function getLoginForm() {
		global $loginForm;
		
		return $loginForm;
	}
	
	function getUrlLoginForm ($retorno = null) {
		//global $loginForm, $agent, $return_url;
		
		if(!$retorno)
		{
			$retorno = $this->return_url;
			error_log("Retorno = ".$retorno);
			//$retorno = this -> return_url;
		}
		
		return $this->loginForm."?".P_SSO_AGENT."=".$this->agent."&".P_SSO_RETURN."=".urlencode($this->return_url);
		//return $this ->loginForm;
	}
	
	function getLogoutForm()
	{
		//global $logoutForm;
		
		return $this->logoutForm;
	}
	
	function getUrlLogoutForm($usuario, $ssoid, $retorno = null)
	{
		global $logoutForm, $agent, $return_url;
		
		if(!$retorno)
		{
			$retorno = $return_url;
		}
		
		//return $this->logoutForm."?".P_SSO_AGENT."=".$this->agent."&".P_SSO_USER."=".$this->usuario."&".P_SSO_ID."=".$this->ssoid."&".P_SSO_RETURN."=".urlencode($this->return_url);
		return $this->logoutForm."?".P_SSO_AGENT."=".$this->getAgent()."&".P_SSO_USER."=".$this->verifica()."&".P_SSO_ID."=".$this->getCurrentSSOID()."&".P_SSO_RETURN."=".urlencode($this->return_url);
	}
	
	function getReturn_url()
	{
		global $return_url;
		
		return $return_url;
	}
	
	function getIsLoginUrl()
	{
		global $loginServer, $loginPort, $isLoginPage;
		
		return "http://".$loginServer.":".$loginPort.$isLoginPage;
	}
	
	function getLoginServer()
	{
		global $loginServer;
		
		return $loginServer;
	}
	
	function getLoginPort()
	{
		global $loginPort;
		
		return $loginPort;
	}
	
	function getIsLoginPage()
	{
		global $isLoginPage;
		
		return $isLoginPage;
	}
	
	function getAgent()
	{
		return $this -> agent;
	}
}

?>
