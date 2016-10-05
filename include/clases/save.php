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
			$sql = 
		$campo == "concepto" 
			?  
				($dat['IdProducto'] == 0 
					? 
						$this->insertProduct($valor, $ncampo, $nota, $pos, 1, $dat['IdItems']) 
					: 
						$this->updateProduct($valor, $dat['IdProducto'])
				) 
			: 
				($campo == "proveedor" 
					? 
						($dat['IdProveedor'] == 0 
							?
								$this->insertSupplier($valor, $ncampo, $nota, $pos, 1, $dat['IdItems']) 
							:
								$this->updateSupplier($valor, $dat['IdProveedor'])
						) 
					: 
						($campo == "cliente" 
							? 
								$this->updatePrices($valor, $dat['IdItems'], $nota) 
							: 
								$this->updateItem($valor, $dat['IdItems'], $ncampo)
						)
				);

		parent::query($sql);
		$this->updatePriceNote($nota);
	}
	public function saveCliente($nota, $valor){
	}
	public function saveComentarios($nota, $valor){
	}
	//Método para crear la nota, en caso de que no exista
	private function createNote(){
		$sql = 'INSERT INTO ad_notas (Fecha, Status, IdUsuario) VALUES ("'.parent::fechaActual().'", 1, "'.$this->idV.'")';
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
	private function insertItem(){
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
		$subtotal = $valor / 1.16;
		$IVA = $valor - $subtotal;

		$array = array(
			"iva" => $IVA,
			"subtotal" => $subtotal,
		);

		return $array;

	}
}
?>