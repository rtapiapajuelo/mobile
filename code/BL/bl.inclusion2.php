<?php
	$objBD = null;
	$conn = null;
	$_ruta = "../";
   	require_once($_ruta."DA/daMYSQLI.php");
	if ($objBD==null){
	   	//$objBD  	= new ClsBd(); // conexion para Mysql  
	   	$objBD 		= ClsBd::getInstance();
	   	$conn		= $objBD->fcConectar();
   	}   	
?>