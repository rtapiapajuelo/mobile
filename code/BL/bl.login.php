<?php
    /********************************************************************************
     * Recibe datos del formulario de login y genera la session.
     *
     * @author SISTEMAS CLI
     * @version 1.0
     * @fecha 15/09/2015     
     ********************************************************************************/
        session_start();
	$_ruta = "../";
	require_once  $_ruta . "DA/da.login.php";
        require_once  $_ruta . "DA/da.encriptador.php";
	if ($_POST){
		$action = sprintf("%s",$_POST['action']);

            if($action == "validar")
            {
                $usuario    = (isset($_POST['txtUsuario'])?sprintf("%s",trim($_POST['txtUsuario'])):"");
                $clave    = (isset($_POST['txtClave'])?sprintf("%s",trim($_POST['txtClave'])):"");
                        
                
                if(trim($usuario)!=""){
                $resultado = json_decode(file_get_contents('http://35.237.183.247/api/login-app/'.$usuario.'/'.$clave),true);
                if ( $resultado['respuesta']==true)
                {       
	            	
	            	$_SESSION['idUsuario'] 		= $resultado['data']['lynx_int_idusuario'];
	            	$_SESSION['usuario'] 		= $resultado['data']['lynx_vch_aliascuenta'];
	            	$_SESSION['usuarioOperaciones'] = $resultado['data']['lynx_vch_aliascuenta'];
                        $_SESSION['codigoes']           = $resultado['data']['lynx_int_codigoes'];
                        $_SESSION['email']              = $resultado['data']['lynx_vch_email'];
                        $_SESSION['accesomobile']       = $resultado['data']['lynx_int_accesomobile'];
                        $_SESSION['sessionid']          = $resultado['data']['lynx_str_sessionId'];
                        if ($_SESSION['accesomobile']>1)
                        {
                            echo json_encode("IngresoA");
                        }
                        else
                        {
                            echo json_encode("Ingreso");
                        }            		
                }else{
            		echo json_encode("Incorrecto ");
            	}
            }
            else
            {
		        echo json_encode("rpta=500");    
            }
	}
	}elseif ($_GET){
		$action = sprintf("%s",$_GET['action']);
	}
?>