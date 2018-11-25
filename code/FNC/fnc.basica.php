<?php
	//Funcion que permite obtener IP Remota
	function getRealIP(){
	  if (!empty($_SERVER['HTTP_CLIENT_IP']))
	      return $_SERVER['HTTP_CLIENT_IP'];
	     
	  if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	      return $_SERVER['HTTP_X_FORWARDED_FOR'];

	  return $_SERVER['REMOTE_ADDR'];
	}

	//Funcion que permite evitar la inyeccion en las cadenas
	function inyection($cadena){
		$cadena = htmlspecialchars($cadena);
		$cadena = trim($cadena);
		return $cadena;
	}

?>