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
		if($section == "addNote")
			parent::crearNota();

		$pagina = 
			$this->hookHeader($section).
			$this->hookBody().
				$this->hooks($section).
			$this->hookEndBody();
		return $pagina;
	}
	//Método para crear el encabezado principal de la pagina, donde vienen las metas
	private function hookHeader($section){
		$var = 
			$this->inicio().
			$this->abrirHead().
			$this->metaHTML().
			$this->metasGenerales($section).
			$this->cacheControl().
			$this->getCSS($section).
			$this->getJS($section).
			$this->cerrarHead();

		return $var;
	}
	/**<!--hookHeader-->**/
		private function inicio(){
			$variable = '
			
			<html lang="es-MX" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">';

			return $variable;
		}
		private function abrirHead(){
			return "<head>";
		}
		//Método para incluir la meta de definicion del http
		private function metaHTML(){
			$variable = '<meta http-equiv="Content-Type" content="text/html">';

			return $variable;
		}
		//Método para las metas generales
		private function metasGenerales($section){
			$title = $section == "addNote" ? "Agregar Nueva Nota Style" : ($section == "login" ? "Login StylePublicidad" : ($section == "home" ? "Sistemas de Notas Style" : ""));
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
		//Método para definir las funciones del control del cache
		private function cacheControl(){
			//header('Pragma: public');
			//header('Cache-Control: pre-check=0, post-check=0, max-age=0', false);
			//header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
			$var = '<meta http-equiv="Cache-Control" content="no-store" />';
			//header('Content-Type: text/html; charset=UTF-8');

			return $var;
		}
		//Método para incluir los archivos necesarios del tipo CSS
		private function getCSS($section=""){
			$file = $section == "login" ? "login-style" : "style";
			$var = '<link href="'.parent::urlActual().'css/'.$file.'.css" rel="stylesheet" type="text/css">';

			return $var;
		}
		//Método para incluir los archivos necesarios del tipo JavaScript
		private function getJS($section){
			$file = $section == "login" ? "login" : "functions";
			
			$variable = '
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
			<script type="text/javascript" src="'.parent::urlActual().'js/'.$file.'.js"></script>';	

			return $variable;
		}
		private function cerrarHead(){
			return "</head>";
		}
	/**<!--hookHeader-->**/
	private function hookBody(){
		return "<body>";
	}
	//Método para crear el contenido de la pagina
	private function hooks($section){
		$var = $section == "login" ? parent::showLogin() :
			parent::abrirContenedorPrincipal().
				parent::showHeader().
				parent::showMenu($section).
				parent::abrirWorkArea().
					$this->contentWorkArea($section).
				parent::cerrarDiv().
			parent::cerrarDiv();

		return $var;
	}
	private function contentWorkArea($section){
		if($section == "addNote"){
			$var = 
				parent::showLogo().
				parent::createSpaceInfoCos().
				parent::createSpaceInfoSel().
				parent::createTitleItems().
				parent::createItems().
				parent::createSpaceComentarios();
		}
		elseif($section == "home"){
			$var = '';
		}
		elseif($section == "activeNotes"){
			$var = 
			parent::showListNotes($section);
		}
		elseif($section == "deliveredNotes"){
			$var = 
			parent::showListNotes($section);
		}
		elseif($section == "paidNotes"){
			$var = 
			parent::showListNotes($section);
		}
		elseif($section == "cutNotes"){
			$var = 
			parent::showListNotes($section);
		}

		return $var;
	}
	private function hookEndBody(){
		return "</body></html>";
	}
	
	
	
	
	
}
?>