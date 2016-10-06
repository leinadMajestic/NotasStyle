<?php 
/*
 * Class page V 1.0
 * Copyright 2016 Style Publicidad
 *
 * Designed and built to ensure access to the system, validating user data from the login.
 * Completely generic
 * Developer: Lic. Daniel Huerta
 * Date: 4 Octubre 2016
 * mail: programacion@stylepublicidad.com
 */
include "MySQL.php";
class login extends MySQL{
	public function __construct($user, $pass){
		session_start();
		parent::__construct();
		$this->usuario = $user;
		$this->clave = $pass;
	}
	public function loguear(){
		$sql = 'SELECT IdUsuarios FROM in_usuarios WHERE Usuario = "'.$this->usuario.'" AND Clave = "'.sha1($this->clave).'"';
		$dato = parent::fetch_array(parent::query($sql));
		if($dato['IdUsuarios'] != ""){//Sesion iniciada correctamente
			$this->firmar($dato['IdUsuarios']);
			return "1";
		}
		else{//Sesion no iniciada
			$this->cerrar();
			return "0";
		}
	}
	private function firmar($idVendedor){
		
		$_SESSION['Usuario']= $this->usuario;
		$_SESSION['nivel'] 	= parent::getLevelSeller($idVendedor);
		$_SESSION['autorizado'] = "SI";
	}
	private function cerrar(){
		session_destroy();
	}
}
?>