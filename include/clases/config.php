<?php 
/*
 * Class config V 1.0
 * Copyright 2016 Style Publicidad
 *
 * Designed and built to set all information for server
 * Completely customized
 * Developer: Lic. Daniel Huerta
 * Date: 4 Octubre 2016
 * mail: programacion@stylepublicidad.com
 */
class config{
	public function __construct(){		
		$this->url 			= "http://localhost/StyleNotas/";
		$this->MAIL_SERVER 	= "";
		$this->MAIL_PORT 	= 465;
		$this->MAIL_EMAIL 	= "";
		$this->MAIL_PASS 	= "";
		$this->MAIL_DE		= "";
		$this->fecha 		= date("Y-m-d H:i:s");
		$this->USER 		= 'styleNotes';
		$this->PASSWORD		= 'CB2ArLiuSViiBQzM';
		$this->SERVER 		= 'localhost';
		$this->PORT			= '3306';	
		$this->DATABASE 	= 'StyleNotes';
	}
	public function getUser(){
		return $this->USER;
	}
	public function getPassword(){
		return $this->PASSWORD;
	}
	public function getServer(){
		return $this->SERVER;
	}
	public function getDataBase(){
		return $this->DATABASE;
	}
	public function getMailServer(){
		return $this->MAIL_SERVER;
	}
	public function getMailPort(){
		return $this->MAIL_PORT;
	}
	public function getMailEmail(){
		return $this->MAIL_EMAIL;
	}
	public function getMailPass(){
		return $this->MAIL_PASS;
	}
	public function getMailDe(){
		return $this->MAIL_DE;
	}
	public function urlActual(){
		return $this->url;
	}
	public function fechaActual(){
		date_default_timezone_set("America/Mexico_City");

		return date("Y-m-d h:i:s");
	}
	public function fechaFormato(){
		date_default_timezone_set("America/Mexico_City");

		return date("Y-m-d");	
	}
}
?>