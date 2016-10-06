<?php 
include "../include/clases/save.php";
$save = new save();

$func = $_POST['func'];
$nota = $_POST['nota'];
$valor = $_POST['valor'];
if($func == "item"){
	$pos = $_POST['pos'];
	$campo = $_POST['campo'];
	$save->saveItem($nota, $valor, $pos, $campo);
	if($campo == "cliente"){
		$dato = $save->getValueNota($nota);

		echo $dato;
	}
}
elseif($func == "comentarios"){
	$save->saveComentarios($nota, $valor);
}
elseif($func == "cliente"){
	$save->saveCliente($nota, $valor);
}

?>