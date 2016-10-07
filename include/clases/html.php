<?php 
/*
 * Class page V 1.0
 * Copyright 2016 Style Publicidad
 *
 * Designed and built for use of all elements of a web page, this is for use after body tag. 
 * Completely customized
 * Developer: Lic. Daniel Huerta
 * Date: 4 Octubre 2016
 * mail: programacion@stylepublicidad.com
 */
include "MySQL.php";
class html extends MySQL{
	public function __construct($idVendedor){
		parent::__construct($idVendedor);

		
		$this->nameSeller 	= parent::getNameSeller($idVendedor);
		$this->levelSeller 	= parent::getLevelSeller($idVendedor);
		$this->phoneSeller 	= parent::getPhoneSeller($idVendedor);
		$this->emailSeller 	= parent::getEmailSeller($idVendedor);
	}
	public function abrirContenedorPrincipal(){
		$var = '
		<div class="contPrincipal">';

		return $var;
	}
	public function abrirWorkArea(){
		$var = '
		<div class="col-xs-10 workArea">';

		return $var;	
	}
	public function cerrarDiv(){
		$var = '</div>';

		return $var;
	}
	//Devuelve el logo
	public function showLogo(){
		$var = '<div class="col-xs-2 contLogo"><img src="'.parent::urlActual().'images/logo.png" alt="Style Publicidad" width="100" /></div>';

		return $var;
	}
	//Devuelve el espacio para la informacion del cliente y vendedor
	public function createSpaceInfoCos(){
		$var = '
		<div class="col-xs-8">
			<div class="contCliente">
				<div class="col-xs-1">
					Cliente
				</div><div class="col-xs-8">
					'.$this->createInput("empresa").'
				</div><div class="col-xs-1">
					Vendedor
				</div><div class="col-xs-2">
					'.$this->createInput("vendedor", "", $this->nameSeller, "", "text", "readonly").'
				</div>
			</div>
			<div class="contCliente">
				<div class="col-xs-1">
					Solicito
				</div><div class="col-xs-5">
					'.$this->createInput("solicito").'
				</div><div class="col-xs-1">
					Correo
				</div><div class="col-xs-2">
					'.$this->createInput("correo").'
				</div><div class="col-xs-1">
					Teléfono
				</div><div class="col-xs-2">
					'.$this->createInput("telefono").'
				</div>
			</div>
		</div>';

		return $var;
	}
	//Devuelve el espacio para motrar el folio y la fecha
	public function createSpaceInfoSel(){
		$var = '
		<div class="col-xs-2">
			<div class="col-xs-12 titSup">
				Nota
			</div><div class="col-xs-12">
				'.$this->createInput("nota","", parent::getFolio(), "", "text", "readonly").'
			</div><div class="col-xs-12 titSup">
				Fecha
			</div><div class="col-xs-12">
				'.$this->createInput("fecha", "", parent::fechaActual(), "", "text", "readonly").'
			</div>
		</div>
		';

		return $var;
	}
	//Devuelve el encabezado de la lista de la descripción de los productos
	public function createTitleItems(){
		$var = '
		<div class="col-xs-4">Concepto</div><div class="col-xs-1">Pzas</div><div class="col-xs-2">Proveedor</div><div class="col-xs-1">Precio lista</div><div class="col-xs-1">Cotizado</div><div class="col-xs-1">Memo</div><div class="col-xs-1">Luis</div><div class="col-xs-1">Cliente$</div>
		';

		return $var;
	}
	//Devuelve cada uno de los items que se llenan
	public function createItems(){		
		for($x=1;$x<21;$x++){
			$color = $x % 2 ? "bgGray" : "bgWhite";
			$var .= '
			<div class="contItems '.$color.'">
				<div class="col-xs-4">
					'.$this->createInput("concepto_".$x).'
				</div><div class="col-xs-1">
					'.$this->createInput("piezas_".$x).'
				</div><div class="col-xs-2">
					'.$this->createInput("proveedor_".$x).'
				</div><div class="col-xs-1">
					'.$this->createInput("precio_".$x).'
				</div><div class="col-xs-1">
					'.$this->createInput("cotizado_".$x).'
				</div><div class="col-xs-1">
					'.$this->createInput("memo_".$x).'
				</div><div class="col-xs-1">
					'.$this->createInput("luis_".$x).'
				</div><div class="col-xs-1">
					'.$this->createInput("cliente_".$x).'
				</div>
			</div>';	
		}

		return $var;
	}
	//Devuelve el espacio para llenar los comentarios
	public function createSpaceComentarios(){
		$var = '
		<div class="col-xs-6">
			<div class="col-xs-2 textarea">Comentarios</div><div class="col-xs-10 textarea">'.$this->createTextArea("comentarios").'</div>
		</div><div class="col-xs-1">
			<div class="col-xs-12 titSup">
				Subtotal
			</div><div class="col-xs-12">
				'.$this->createInput("Subtotal", 0, "", "", "text", "readonly").'
			</div>
		</div><div class="col-xs-1">
			<div class="col-xs-12 titSup">
				IVA
			</div><div class="col-xs-12">
				'.$this->createInput("IVA", 0, "", "", "text", "readonly").'
			</div>
			
		</div><div class="col-xs-1">
			<div class="col-xs-12 titSup">
				Total
			</div><div class="col-xs-12">
				'.$this->createInput("Total", 0, "", "", "text", "readonly").'
			</div>
		</div><div class="col-xs-1">
			<div class="col-xs-12 titSup">
				Factura
			</div><div class="col-xs-12">
				Si '.$this->createInput("factura", 0, "1", "", "radio").' 
				No '.$this->createInput("factura", 0, "0", "", "radio").'
			</div>
		</div><div class="col-xs-2">
			<div class="col-xs-12 titSup">
				Estatus
			</div><div class="col-xs-12">
				'.$this->createSelectEstatus().'
			</div>
		</div>';

		return $var;
	}
	//Devuelve un input generico
	private function createInput($id, $focus="1", $value="", $placeholder="", $type="text", $disabled=""){
		$class= $type=="radio" ? "radiobutton" : "";

		$var = '<input type="'.$type.'" class="'.$class.'" value="'.$value.'" name="'.$id.'" id="'.$id.'" placeholder="'.$placeholder.'" '.$disabled;
		$var .= $focus == 1 ? 'onfocusout="save(this.id)"/>' : "/>";

		return $var;
	}
	//Devuelve  un textarea personalizado
	private function createTextArea($id, $focus="1", $value="", $placeholder="", $disabled=""){
		$var = '<textarea name="'.$id.'" id="'.$id.'" placeholder="'.$placeholder.'" '.$disabled.' class="full"';
		$var .= $focus == 1 ? 'onfocusout="save(this.id)" >' : ">";
		$var .= $value.'</textarea>';

		return $var;
	}
	//Devuelve un select generico
	private function createSelectEstatus(){
		$select = '<select id="estatus"><option value="">-- Seleccione</option>';
		$estatus = parent::getStatus();
		$option = explode(";;",$estatus);
		foreach($option AS $data){
			$dato = explode("::", $data);
			$select .= '<option value="'.$dato[0].'">'.$dato[1].'</option>';
		}
		$select .= '</select>';

		return $select;
	}
	//Método que devuelve el login
	public function showLogin(){
		$var = '
		<div class="container">
			<section id="content">
				<form>
					<h1>Iniciar sesión</h1>
					<div>
						'.$this->createInput("username", "", "", "Usuario", "text", "required").'
						
					</div>
					<div>
						'.$this->createInput("password", "", "", "Contraseña", "password", "required").'
						
					</div>
					<div>
						<input type="button" value="Entrar" id="enviar"/>
					</div>
				</form>
			</section>
		</div>';

		return $var;
	}
	//Método para crear el menú, sidebar
	public function showMenu($section){
		$var = '
		<div class="col-xs-2 sidebar">
			<div class="'; if($section == "addNote") $var .='active'; $var .=' submenu" id="addNota">Crear nota</div>
			<!--<div class="'; if($section == "searchNote") $var .='active'; $var .=' submenu" id="buscar">Buscar nota</div>-->
			<div class="'; if($section == "activeNotes") $var .='active'; $var .=' submenu" id="vActivas">Ver Activas</div>
			<div class="'; if($section == "deliveredNotes") $var .='active'; $var .=' submenu" id="vEntregadas">Ver Entregadas</div>
			<div class="'; if($section == "paidNotes") $var .='active'; $var .=' submenu" id="vPagadas">Ver Pagadas</div>
			<div class="'; if($section == "cutNotes") $var .='active'; $var .=' submenu" id="corte">Hacer corte</div>
			<div class="submenu" id="cerrarSesion">Cerrar Sesión</div>
		</div>';

		return $var;
	}
	//Método para crear un header en la página
	public function showHeader(){
		$var = '
		<div class="con-xs-12" id="contenedorHeader">
		</div>';

		return $var;
	}
	//Método que devuelve una lista de notas, en base a un status
	public function showListNotes($section){
		$status = parent::fetch_array(parent::query('SELECT IdEstatus, Nombre FROM in_estatus WHERE Section = "'.$section.'"'));
		$sql = '
		SELECT ad_Notas.IdNotas, ad_Notas.Fecha, ad_Notas.Total, in_clientes.Empresa, CONCAT(in_usuarios.Nombre," ",in_usuarios.Apellidos) AS Vendedor
		FROM ad_Notas 
		INNER JOIN in_usuarios ON in_usuarios.IdUsuarios = ad_Notas.IdUsuario
		LEFT JOIN in_clientes ON in_clientes.IdCliente = ad_Notas.IdCliente
		WHERE ad_Notas.Status = "'.$status['IdEstatus'].'"';
		$var = $this->createTitleTable();

		$dat = parent::query($sql);
		while($dato = parent::fetch_array($dat)){
			$color = $x == 0 ? "gray" : "";
			$var .= $this->createLineTable($color, $dato['IdNotas'], $dato['Fecha'], $dato['Total'], $dato['Empresa'], $dato['Vendedor'], $status['Nombre']);
			$x = $x == 0 ? 1 : 0;
		}

		return $var;
	}
	//Método para crear una línea del título de la lista para hacerlo recursivo
	private function createTitleTable(){
		$var = '<div class="tableTitleBorder"><div class="col-xs-1">ID</div><div class="col-xs-2">Fecha</div><div class="col-xs-1">Precio Total</div><div class="col-xs-3">Empresa</div><div class="col-xs-3">Vendedor</div><div class="col-xs-1">Estatus</div><div class="col-xs-1">Ver</div></div>';

		return $var;
	}
	//Método para crear una línea recursiva que contiene la información necesaria para hacerse recursivo
	private function createLineTable($color, $id, $fecha, $precio, $empresa, $vendedor, $status){
		$fecha = $fecha == "" ? "&nbsp;" : $fecha;
		$precio = $precio == "" ? "&nbsp;" : $precio;
		$empresa = $empresa == "" ? "&nbsp;" : $empresa;
		$vendedor = $vendedor == "" ? "&nbsp;" : $vendedor;

		$var = '<div class="tableBorder '.$color.'"><div class="col-xs-1">'.$id.'</div><div class="col-xs-2">'.$fecha.'</div><div class="col-xs-1">'.$precio.'</div><div class="col-xs-3">'.$empresa.'</div><div class="col-xs-3">'.$vendedor.'</div><div class="col-xs-1">'.$status.'</div><div class="col-xs-1">ver</div></div>';

		return $var;
	}
}
?>