<?php
    /********************************************************************************
     * Documentos asignados a un usuario determinado
     *
     * @author RTP 
     * @version 1.0
     * @fecha 15/09/2015     
     ********************************************************************************/

	$_ruta = "../";
	require_once $_ruta."DA/da.documentoAsignado.php";
        require_once $_ruta."BL/bl.sesion.ctrl.php";
	if ($_POST)
        {   $objClase	= new ClsDocumentoAsignado();
		//code
            $_action    = isset($_POST['action'])?sprintf("%s",$_POST['action']):"";
            $_iusuario  = isset($_SESSION['idUsuario'])?intval($_SESSION['idUsuario']):0;
            if ($_action=="cerrarDocumento")
            {   $_idDOcumentoAsignado = $_SESSION['ORDEN']['IDOCUMENTO'];
                $objClase->fcDocumentoAsignado(2, 0, 0, $_iusuario, $_iusuario, "", "", $_idDOcumentoAsignado);
                echo "ok";
            }
            elseif ($_action=="asignarDocumentoPerfil")
            {

            }
            elseif ($_action=="listarDocumento")
            {
                $_datos = $objClase->fcListarDocumento('');
                $_html = "<option value='0'>-- Seleccione -</option>";
                for ($_i=0; $_i<sizeof($_datos);$_i++)
                {
                    $_html .="<option value='".$_datos[$_i]['codigo']."'>".$_datos[$_i]['nombre']."</option>";
                }
                echo $_html; 
            }
            elseif ($_action=="listarUsuario")
            {
                $_datos = $objClase->fcListarUsuario('');
                $_html = "<option value='0'>-- Seleccione -</option>";
                for ($_i=0; $_i<sizeof($_datos);$_i++)
                {
                    $_html .="<option value='".$_datos[$_i]['cli_int_idusuario']."'>".$_datos[$_i]['cli_vch_nombre']."</option>";
                }
                echo $_html; 
            }
	}
        elseif ($_GET)
        {
            $actio = printf("%s",$_GET['action']);
            $objClase	= new ClsDocumentoAsignado();    	
            if($action=="cargarLista")
            {
                $_idUsuario = isset($_SESSION['idUsuario'])?intval($_SESSION['idUsuario']):0;
                $resultado = $objClase->fcListarDocumentoAsignado($_idUsuario, 0);
                $objClase  = null;
                echo json_encode($resultado);
            }
            else if($action=="cargarUno")
            {
                $_idUsuario = isset($_SESSION['idUsuario'])?intval($_SESSION['idUsuario']):0;
                $_idDocumentoAsignado = sprintf("%d",$_GET['idDocumentoAsignado']);
                $resultado = $objClase->fcListarDocumentoAsignado($_idUsuario, $_idDocumentoAsignado);
                if (sizeof($resultado)>0)
                {
                    $_SESSION['ORDEN']['TIPDOCUMENTO']= $resultado[0]['mov_int_iddocumento'];
                    if ($resultado[0]['mov_int_iddocumento']==1)
                    {
                        $_SESSION['ORDEN']['DOCUMENTO']   = substr($resultado[0]['mov_vch_serie'],-2)."/".$resultado[0]['mov_vch_numero'];
                    }
                    else
                    {
                        $_SESSION['ORDEN']['DOCUMENTO']   = $resultado[0]['mov_vch_serie']."-".$resultado[0]['mov_vch_numero'];
                    }
                }                
                $objClase  = null;
                echo json_encode($resultado);
            }
        }		
?>