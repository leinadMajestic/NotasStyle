<?php 
include "MySQL.php";
class save extends MySQL{
	public function __construct(){
		parent::__construct();
	}
	//Método publico usado por AJAX, para guadar o actualizar los elementos del ITEM
	public function saveItem($nota, $valor, $pos, $campo){
		$ncampo = $this->selCampos($campo);
		$sql = 'SELECT IdItems, IdProducto, IdProveedor FROM ad_items WHERE IdNotas = "'.$nota.'" AND pos = "'.$pos.'" ';
		$dat = parent::fetch_array(parent::query($sql));

		if($dat['IdItems'] == "")
			$sql = $campo == "concepto" ? $this->insertProduct($valor, $ncampo, $nota, $pos, 0) : ($campo == "proveedor" ? $this->insertSupplier($valor, $ncampo, $nota, $pos, 0) : $this->insertItem($valor, $ncampo, $nota, $pos));
		else
			$sql = $campo == "concepto" ? ($dat['IdProducto'] == 0 ? $this->insertProduct($valor, $ncampo, $nota, $pos, 1, $dat['IdItems']) : $this->updateProduct($valor, $dat['IdProducto'])) : ($campo == "proveedor" ? ($dat['IdProveedor'] == 0 ? $this->insertSupplier($valor, $ncampo, $nota, $pos, 1, $dat['IdItems']) : $this->updateSupplier($valor, $dat['IdProveedor'])) : ($campo == "cliente" ? $this->updatePrices($valor, $dat['IdItems'], $nota) : $this->updateItem($valor, $dat['IdItems'], $ncampo)));

		parent::query($sql);
		$this->updatePriceNote($nota);
	}
	//Método para guardar la informacion del cliente
	public function saveCliente($nota, $valor, $campo){
		$ncampo = $this->selCampos($campo);

		$sql = 'SELECT IdCliente FROM ad_notas WHERE IdNotas = "'.$nota.'"';
		$dat = parent::fetch_array(parent::query($sql));
		if($dat['IdCliente'] == 0){//Inserta cliente nuevo
			parent::query('INSERT INTO in_clientes ('.$ncampo.') VALUES ("'.$valor.'")');
			$lastID = parent::fetch_array(parent::query('SELECT IdCliente FROM in_clientes ORDER BY IdCliente DESC LIMIT 1'));
			$sql = 'UPDATE ad_Notas SET IdCliente = "'.$lastID['IdCliente'].'" WHERE IdNotas = "'.$nota.'"';
		}
		else{//Actualizar datos de cliente
			$sql = 'UPDATE in_clientes SET '.$ncampo.' = "'.$valor.'" WHERE IdCliente = "'.$dat['IdCliente'].'"';
		}
		parent::query($sql);
	}
	//Método para guardar los comentarios de la nota
	public function saveComentarios($nota, $valor){
		$sql = 'UPDATE ad_Notas SET Comentarios = "'.$valor.'" WHERE IdNotas = "'.$nota.'"';
		$dat = parent::fetch_array(parent::query($sql));		
	}
	//Método para actualizar el campo factura, indica si lleva factura o no
	public function updateFactura($nota, $valor){
		$sql = 'UPDATE ad_Notas SET Factura = "'.$valor.'" WHERE IdNotas = "'.$nota.'"';

		parent::query($sql);
	}
	//Método para actualizar el campo estatus, en base al seleccionado
	public function updateStatus($nota, $valor){
		$sql = 'UPDATE ad_Notas SET Status = "'.$valor.'" WHERE IdNotas = "'.$nota.'"';

		parent::query($sql);
	}
	//Método que devuelve el precio total de la nota, el subtotal y el IVA
	public function getValueNota($nota){
		$suma = parent::fetch_array(parent::query('SELECT SUM(Total) AS total FROM ad_items WHERE IdNotas = "'.$nota.'"'));
		$calculo = $this->calculaIVA($suma['total']);
		$calculo['iva'] = number_format($calculo['iva'],2,".",",");
		$calculo['subtotal'] = number_format($calculo['subtotal'],2,".",",");
		$calculo['total'] = number_format($calculo['total'],2,".",",");

		return $calculo;
	}
	//Método para obtener los campos tal cual se llaman en la base de datos
	private function selCampos($tipo){
		$array = array(
			"concepto" => "IdProducto",
    		"piezas"    => "Piezas",
    		"proveedor" => "IdProveedor",
    		"precio" => "PrecioLista",
    		"cotizado"  => "Cotizado",
    		"memo" => "GastoM",
    		"luis" => "GastoL",
    		"cliente" => "Total",
    		"factura" => "Factura",
    		"telefono" => "Telefono",
    		"correo" => "Email", 
    		"empresa" => "Empresa",
    		"solicito" => "Contacto",
		);

		return $array[$tipo];
	}
	//Método para insertar productos
	private function insertProduct($valor, $ncampo, $nota, $pos, $tipo, $IdItems=0){
		parent::query('INSERT INTO in_productos (Nombre, SKU) VALUES ("'.$valor.'", "")');
		$lastID = parent::fetch_array(parent::query('SELECT IdProducto FROM in_productos ORDER BY IdProducto DESC LIMIT 1'));

		if($tipo == 0){//Nueva nota	
			$sql = 'INSERT INTO ad_items (IdNotas, pos, '.$ncampo.') VALUES ("'.$nota.'", "'.$pos.'", "'.$lastID['IdProducto'].'")';	
		}
		elseif($tipo == 1){//Nota existente 
			$sql = $this->updateItem($lastID['IdProducto'], $IdItems, $ncampo);
		}
		return $sql;
	}
	//Método para insertar proveedores
	private function insertSupplier($valor, $ncampo, $nota, $pos, $tipo, $IdItems=0){
		parent::query('INSERT INTO in_proveedores (Empresa) VALUES ("'.$valor.'")');
		$lastID = parent::fetch_array(parent::query('SELECT IdProveedor FROM in_proveedores ORDER BY IdProveedor DESC LIMIT 1'));
		if($tipo == 0){//Nueva nota
			$sql = 'INSERT INTO ad_items (IdNotas, pos, '.$ncampo.') VALUES ("'.$nota.'", "'.$pos.'", "'.$lastID['IdProveedor'].'")';
		}
		elseif($tipo == 1){//Nota existente
			$sql = $this->updateItem($lastID['IdProveedor'], $IdItems, $ncampo);
		}
		return $sql;
	}
	//Método para insertar items de forma genérica
	private function insertItem($valor, $ncampo, $nota, $pos){
		$sql = 'INSERT INTO ad_items (IdNotas, pos, '.$ncampo.') VALUES ("'.$nota.'", "'.$pos.'", "'.$valor.'")';

		return $sql;
	}
	//Método para actualizar los productos
	private function updateProduct($valor, $idProducto){
		$sql = 'UPDATE in_productos SET Nombre = "'.$valor.'" WHERE IdProducto = "'.$dIdProducto.'"';

		return $sql;
	}
	//Método para actualizar el proveedor
	private function updateSupplier($valor, $IdProveedor){
		$sql = 'UPDATE in_proveedores SET Empresa = "'.$valor.'" WHERE IdProveedor = "'.$IdProveedor.'"';

		return $sql;
	}
	//Método para actualizar el precio, IVA y subtotal
	private function updatePrices($valor, $IdItems, $nota){
		$calculo = $this->calculaIVA($valor);
		$sql = 'UPDATE ad_items SET IVA = "'.$calculo['iva'].'", Subtotal = "'.$calculo['subtotal'].'", Total = "'.$valor.'" WHERE IdItems = "'.$IdItems.'"';

		return $sql;
	}
	//Método para actualizar de forma general la informacion del ITEM
	private function updateItem($valor, $IdItems, $ncampo){
		$sql = 'UPDATE ad_items SET '.$ncampo.' = "'.$valor.'" WHERE IdItems = "'.$IdItems.'"';	

		return $sql;
	}
	//Método para actualizar el precio total de las notas
	private function updatePriceNote($nota){
		$suma = parent::fetch_array(parent::query('SELECT SUM(Total) AS total FROM ad_items WHERE IdNotas = "'.$nota.'"'));
		$calculo = $this->calculaIVA($suma['total']);

		$sql = 'UPDATE ad_Notas SET Total = "'.$suma['total'].'", IVA = "'.$calculo['iva'].'", Subtotal = "'.$calculo['subtotal'].'" WHERE IdNotas = "'.$nota.'"';

		parent::query($sql);
	}
	//Método usado para calcular desglosar el IVA, y el subtotal
	private function calculaIVA($valor){
		$subtotal = number_format($valor / 1.16, 2, ".", "");
		$IVA = number_format($valor - $subtotal, 2, ".", "");

		$array = array(
			"iva" => $IVA,
			"subtotal" => $subtotal,
			"total" => $valor,
		);

		return $array;
	}
}
?>