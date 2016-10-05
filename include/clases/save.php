<?php 
include "MySQL.php";
class save extends MySQL{
	public function __construct(){
		parent::__construct();
	}
	public function saveItem($nota, $valor, $pos, $campo){
		$ncampo = $this->selCampos($campo);
		/*$sql = 'INSERT INTO in_productos (Nombre, SKU) VALUES ($valor)';
		$sql = 'INSERT INTO ad_items (IdNotas, ) VALUES ()';
		$sql = 'SELECT IdItems FROM ad_items WHERE IdNotas = "'.$nota.'" AND pos = "'.$pos.'" ';
		$dat = parent::fetch_array(parent::query($sql));
		if($dat['IdItems'] == ""){//INSERT
			$sql = 'INSERT INTO ';
		}
		else{//UPDATE
			$sql = 'UPDATE ad_items SET ';
		}*/
	}
	public function saveCliente($nota, $valor){

	}
	public function saveComentarios($nota, $valor){

	}
	private function selCampos($tipo){
		$array = array(
			"concepto" => "Nombre",
    		"piezas"    => "Piezas",
    		"proveedor" => "Empresa",
    		"cotizado"  => "Costo",
    		"memo" => "GastoM",
    		"luis" => "GastoL",
    		"cliente" => "Total",
		);

		return $array[$tipo];
	}
}
?>