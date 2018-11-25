<?php
    /********************************************************************************
     * Perfil Movil de acuerdo al perfil del documento seleccionado
     *
     * @author RTP 
     * @version 1.0
     * @fecha 15/09/2015     
     ********************************************************************************/
        
	$_ruta = "../";
	require_once  $_ruta . "DA/da.perfilMovil.php";
        require_once $_ruta."BL/bl.sesion.ctrl.php";
	if ($_POST){
		//code
	}elseif ($_GET){
		$action = sprintf("%s",$_GET['action']);
		$objClase	= new ClsPerfilMovil();    	
        if($action=="cargarCabecera"){
        	$_idPerfil = sprintf("%d",$_GET['idPerfil']);
			$_idPadre = sprintf("%d",$_GET['idPadre']);
        	$resultado = $objClase->fcListarOpcionCabecera($_idPerfil, $_idPadre);
            $objClase  = null;
            echo json_encode($resultado);
        }
        if($action=="cargarDetalle"){
        	$_idPadre = sprintf("%d",$_GET['idPadre']);
                $_referenciaDoc = $_SESSION['ORDEN']['DOCUMENTO'];
                
        	$_idDato = 0;
                $_idusuario  = isset($_SESSION['idUsuario'])?intval($_SESSION['idUsuario']):0;
        	$resultado = $objClase->fcListarOpcionDato($_idPadre, $_idDato, $_idusuario,$_referenciaDoc);
            $objClase  = null;
            echo json_encode($resultado);
        }
	}
?>