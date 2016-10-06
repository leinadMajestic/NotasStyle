<?php
/*
 * Class page V 1.0
 * Copyright 2016 Style Publicidad
 *
 * Designed and built to set all data connection to the MySQL database.
 * Completely generic
 * Developer: Lic. Daniel Huerta
 * Date: 4 Octubre 2016
 * mail: programacion@stylepublicidad.com
 */
include "config.php";
class MySQL extends config{
	public function __construct($idVendedor){
		parent::__construct();		
		$this->idV = $idVendedor;		
		$this->link = (mysql_connect(parent::getServer(), parent::getUser(), parent::getPassword())) or die(mysql_error());
		mysql_select_db(parent::getDataBase(), $this->link) or die(mysql_error());
	}
	//Devuelve el Nombre del Vendedor
	public function getNameSeller($idVendedor){
		$sql = 'SELECT Nombre, Apellidos FROM in_usuarios WHERE IdUsuarios = "'.$idVendedor.'"';
		$dato = $this->fetch_array($this->query($sql));

		return $dato['Nombre']." ".$dato['Apellidos'];
	}
	//Devuelve el nivel del Vendedor
	public function getLevelSeller($idVendedor){
		$sql = 'SELECT Nivel FROM in_usuarios WHERE IdUsuarios = "'.$idVendedor.'"';
		$dato = $this->fetch_array($this->query($sql));

		return $dato['Nivel'];
	}
	//Devuelve el teléfono del Vendedor
	public function getPhoneSeller($idVendedor){
		$sql = 'SELECT Telefono FROM in_usuarios WHERE IdUsuarios = "'.$idVendedor.'"';
		$dato = $this->fetch_array($this->query($sql));

		return $dato['Telefono'];
	}
	public function getFolio(){
		$sql = 'SELECT IdNotas FROM ad_Notas ORDER BY IdNotas DESC LIMIT 1';
		$dato = $this->fetch_array($this->query($sql));

		return $dato['IdNotas'];
	}
	//Devuelve el Email del vendedor
	public function getEmailSeller($idVendedor){
		$sql = 'SELECT Email FROM in_usuarios WHERE IdUsuarios = "'.$idVendedor.'"';
		$dato = $this->fetch_array($this->query($sql));

		return $dato['Email'];
	}
	//Devuelve los estatus que existen en una cadena
	public function getStatus(){
		$sql = $this->query('SELECT * FROM in_estatus WHERE Estatus = 1');
		$x=0;
		while($dat = $this->fetch_array($sql)){
			$separador = $x==0 ? "" : ";;";
			$estatus .= $separador.$dat['IdEstatus']."::".$dat['Nombre'];
			$x++;
		}

		return $estatus;

	}
	public function crearNota(){
		$sql = 'INSERT INTO ad_notas (Fecha, Status, IdUsuario) VALUES ("'.parent::fechaActual().'", 1, "'.$this->idV.'")';

		//echo $sql;
		$this->query($sql);
	}
	public function query($value){
		$this->total_query++;
		$result = mysql_query($value,$this->link);
		if (!$result){
			echo 'MySQL Error: '.mysql_error();
			exit;
		}
		return $result;
	}
	public function fetch_array($value){
		return mysql_fetch_array($value);
	}
	public function num_rows($value){
		return mysql_num_rows($value);
	}
	public function fetch_row($value){
		return mysql_fetch_row($value);
	}
	public function fetch_assoc($value){
		return mysql_fetch_assoc($value);
	}
}
?>