<?php

require_once("ISSOClient.php");
require_once("../Net/HTTP/Client.php");

$isso_client = new ISSOClient();

$user = $isso_client->verifica();

if(!$user)
{
	header("Location: ".$isso_client->getUrlLoginForm());
}
else
{
	echo "USUARIO: ".$user."<br>";
	echo "<a href=\"".$isso_client->getUrlLogoutForm($isso_client->verifica(), $isso_client->getCurrentSSOID())."\">Logout</a>";
}


?>
