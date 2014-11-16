<?php
$config['ldap'] = array();

$config['ldap']['host'] = "192.168.21.23"; //"157.88.25.9";
$config['ldap']['puerto'] = 389;
//$config['ldap']['dnadmin'] = "uid=webmaster_gdocente,ou=personal,dc=uva,dc=es";
$config['ldap']['dnadmin'] = "uid=reservaaulas_uva,ou=personal,dc=uva,dc=es";
//$config['ldap']['passwdadmin'] = "Xx38EJLQ";
$config['ldap']['passwdadmin'] = "Rh2o7u6o";
$config['ldap']['base'] = "ou=personal,dc=uva,dc=es";

// Atributo donde se encuentra el identificador de usuario
// Ejemplos: uid, sAMAccountName (para Active Directory)
$config['ldap']['uidattr'] = 'uid';
?>
