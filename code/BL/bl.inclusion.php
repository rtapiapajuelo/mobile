<?php
	$_ruta = "../";
	$objBD = null;
	$conn = null;
   	require_once($_ruta."DA/daMYSQLI.php");
   	
	if ($objBD==null){
	   	$objBD 		= ClsBd::getInstance();
	   	$conn		= $objBD->fcConectar();
   	}   	
?>