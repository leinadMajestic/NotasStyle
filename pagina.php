<?php 
include "include/clases/sesion.php";
$sesion = new sesion();
$section = $_GET['section'];
$sesion->validar($section);?>


<?= $sesion->createPage($section);?>