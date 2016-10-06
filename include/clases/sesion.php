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
include "page.php";
 class sesion extends page{
 	public function __construct(){
 		session_start();
 		parent::__construct();
 	}
 	public function validar($section){
 		if($section == "login" && $_SESSION['autorizado'] == "SI")
 			$this->sesionAbierta();
 		elseif($_SESSION['autorizado'] != "SI" && $section != "login")
 			$this->cerrarSesion();
 	}
 	public function cerrarSesion(){
 		session_destroy();
 		header("location: login.html");
 	}
 	public function sesionAbierta(){
 		header("location: inicio.html");	
 	}
 }
 ?>