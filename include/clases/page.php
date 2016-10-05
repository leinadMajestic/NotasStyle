<?php 
/*
 * Class page V 1.0
 * Copyright 2016 Style Publicidad
 *
 * Designed and built for use all elements of a webpage, this is for use exclusive header.
 * Completely generic
 * Developer: Lic. Daniel Huerta
 * Date: 4 Octubre 2016
 * mail: programacion@stylepublicidad.com
 */
include "html.php";
class page extends html{
	public function __construct($idVendedor){
		parent::__construct($idVendedor);
	}
	//Método para crear el contenido de la pagina, es el método al que se puede accesar desde el front
	public function createPage($section=""){
		if($section == "home"){
			parent::crearNota();
		}

		$pagina = 
			$this->createPageHeader($section).
			$this->abrirBody().
				$this->createHead($section).
				$this->createContentPage($section).
			$this->cerrarBody();
		
		return $pagina;


	}
	//Método para crear el contenido de la página, va después del encabezado del contenido
	private function createContentPage($section){
		if($section == "home"){
			$var = 
			parent::abrirContenedorPrincipal().
				parent::createTitleItems().
				parent::createItems().
				parent::createSpaceComentarios().
			parent::cerrarDiv();
		}
		if($section == "login"){
			$var = '';
		}

		return $var;
	}
	private function inicio(){
		$variable = '
		
		<html lang="es-MX" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">';

		return $variable;
	}
	private function abrirHead(){
		return "<head>";
	}
	private function cerrarHead(){
		return "</head>";
	}
	private function abrirBody(){
		return "<body>";
	}
	private function cerrarBody(){
		return "</body></html>";
	}
	//Método para definir las funciones del control del cache
	private function cacheControl(){
		//header('Pragma: public');
		//header('Cache-Control: pre-check=0, post-check=0, max-age=0', false);
		//header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
		$var = '<meta http-equiv="Cache-Control" content="no-store" />';
		//header('Content-Type: text/html; charset=UTF-8');

		return $var;
	}
	//Método para incluir la meta de definicion del http
	private function metaHTML(){
		$variable = '<meta http-equiv="Content-Type" content="text/html">';

		return $variable;
	}
	//Método para las metas generales
	private function metasGenerales($section){
		$title = $section == "home" ? "Sistema de Notas Style" : "Login StylePublicidad";
		$variable = '
		<title>'.$title.'</title>
		
		<link href="'.parent::urlActual().'favicon.ico" rel="shortcut icon">
		
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta http-equiv="robots" content="all" />
		<meta name="language" content="" />
		<meta name="robots" content="Index, NoFollow" />
		<meta name="abstract" content="" />
		<base href="'.parent::urlActual().'" />
		';

		return $variable;
	}
	//Método para incluir los archivos necesarios del tipo CSS
	private function getCSS($section=""){
		if($section == "home")
			$var = '<link href="'.parent::urlActual().'css/style.css" rel="stylesheet" type="text/css">';
		if($section == "login")
			$var = '<link href="'.parent::urlActual().'css/login-style.css" rel="stylesheet" type="text/css">';

		return $var;
	}
	//Método para incluir los archivos necesarios del tipo JavaScript
	private function getJS($section){
		if($section == "home"){
			$variable = '
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
			<script type="text/javascript" src="'.parent::urlActual().'js/functions.js"></script>';	
		}
		if($section == "login"){
			$variable = "";
		}

		return $variable;
	}
	//Método para crear el encabezado principal de la pagina, donde vienen las metas
	private function createPageHeader($section){
		$var = 
			$this->inicio().
			$this->abrirHead().
			$this->metasGenerales($section).
			$this->cacheControl().
			$this->getCSS($section).
			$this->getJS($section).
			$this->cerrarHead();

		return $var;
	}
	//Método para crear el encabezado dentro del body de la pagina, esto ya es visible
	private function createHead($section){
		if($section == "home"){
			$var = 
			parent::abrirContenedorPrincipal().
				parent::showLogo().
				parent::createSpaceInfoCos().
				parent::createSpaceInfoSel().
			parent::cerrarDiv();

		}
		if($section == "login"){
			$var = 
			parent::showLogin();
		}

		return $var;
	}
}
?>