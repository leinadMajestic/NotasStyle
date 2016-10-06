<?php 
include_once "../include/clases/login.php";

$func 		= $_POST['func'];
$usuario 	= $_POST['usuario'];
$clave 		= $_POST['clave'];

$login = new login($usuario, $clave);
if($func == "login"){	
	echo $login->loguear();
}
?>