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
	if ($_POST)
    {
		$_action = isset($_POST['action'])?$_POST['action']:"";
        if ($_action=="cargarPerfil")
        {
            $_idDocumento = isset($_POST['documento'])?intval($_POST['documento']):0;
            $_npefil      = isset($_POST['nombre'])?sprintf("%s",$_POST['nombre']):"";
            $objClase   = new ClsPerfilMovil();  
            $_opciones = $objClase->fcListarPerfiles($_idDocumento, $_npefil); 
            $_html = "<option value=''>-- Seleccione --</option>";

            for ($_i=0; $_i<sizeof($_opciones); $_i++)
            {   
                $_fila = $_opciones[$_i];
                $_html.="<option value='".$_fila['codigo']."'>".$_fila['nombre']."</option>";
            }
            echo $_html;
        }

    }
    elseif ($_GET)
    {
	$action = sprintf("%s",$_GET['action']);
	$objClase	= new ClsPerfilMovil();   
        if ($action=="listaretiqueta")
        {
            $page 	= isset($_GET['draw'])?$_GET['draw']:1; // get the requested page
            $limit 	= isset($_GET['length'])?$_GET['length']:10; // get how many rows we want to have into the grid
            $_inicio 	= isset($_GET['start'])?$_GET['start']:0;	
            $campoOrden	= isset($_GET['order'][0]['column'])?$_GET['order'][0]['column']:2;
            $_nombre 	= isset($_GET['search']['value'])?sprintf("%s",$_GET['search']['value']):"";	
            $nCampo = $campoOrden;
            $_fin 	= $_inicio + $limit;
            $resultado = $objClase->fcListarEtiqueta(0, $_nombre , ($_inicio+1) , $_fin);
            $_dataR = array();
            $_cont = 0;
            $_totalFilas = 0;
            for ($_j=0; $_j<sizeof($resultado); $_j++)
            {
                $_dataR[$_cont]['n']            = ($resultado[$_cont]['n']);
                $_dataR[$_cont]['nombre']       = $resultado[$_cont]['mov_vch_etiqueta']."<br/>".($resultado[$_cont]['mov_vch_descripcion']);                
                $_dataR[$_cont]['variable']     = ($resultado[$_cont]['mov_vch_variable']);
                $_dataR[$_cont]['funcion']      = ($resultado[$_cont]['mov_vch_fuente'])."<br/>".
                                                  "<b>Tipo :</b>".($resultado[$_cont]['mov_int_tipovalor']==1?"Variable":$resultado[$_cont]['mov_int_tipovalor']==1?"Session":$resultado[$_cont]['mov_int_tipovalor']==3?"Funcion de BD":"").
                                                   "<br/><b>Es codigo de cliente</b>".($resultado[$_cont]['mov_int_escodigocliente']==1?"SI":"NO");
                
                $_totalFilas                = $resultado[$_cont]['NFILA'];
                $_dataR[$_cont]['edit']     = "<img src='../".$_ruta."/images/view.gif' alt='Modificar'>";
                $_cont++;
            }
            $json                       = array(  'data'      => $_dataR	,
                                                  'recordsTotal'    => $_totalFilas ,
                                                  'recordsFiltered' => $_totalFilas,
                                                  'draw'            => $page  );
            echo json_encode($json);
            
        }
        else if ($action=="listarperfil")
        {
            $page 	= isset($_GET['draw'])?$_GET['draw']:1; // get the requested page
            $limit 	= isset($_GET['length'])?$_GET['length']:10; // get how many rows we want to have into the grid
            $_inicio 	= isset($_GET['start'])?$_GET['start']:0;	
            $campoOrden	= isset($_GET['order'][0]['column'])?$_GET['order'][0]['column']:2;
            $_nombre 	= isset($_GET['search']['value'])?sprintf("%s",$_GET['search']['value']):"";	            
            $nCampo     = $campoOrden;
            $_dataR     = array();
            $_cont      = 0;
            $_totalFilas= 0;
            $_fin 	= $_inicio + $limit;
            $resultado  = $objClase->fcListarPerfiles(0, $_nombre , ($_inicio+1) , $_fin);
            for ($_j=0; $_j<sizeof($resultado); $_j++)
            {
                $_dataR[$_cont]['n']            = ($resultado[$_cont]['n']);
                $_dataR[$_cont]['nombre']       = $resultado[$_cont]['nombre'];                
                $_dataR[$_cont]['documento']    = ($resultado[$_cont]['ndocumento']);                
                
                $_totalFilas                    = $resultado[$_cont]['NFILA'];
                $_dataR[$_cont]['edit']         = "<img src='../".$_ruta."/images/view.gif' alt='Modificar'>";
                $_cont++;
            }
            $json                       = array(  'data'      => $_dataR	,
                                                  'recordsTotal'    => $_totalFilas ,
                                                  'recordsFiltered' => $_totalFilas,
                                                  'draw'            => $page  );
            echo json_encode($json);
            
            
        }
        else if ($action=="cargarCabecera")
        {
            $_idPerfil = sprintf("%d",$_GET['idPerfil']);
                    $_idPadre = sprintf("%d",$_GET['idPadre']);
            $resultado = $objClase->fcListarOpcionCabecera($_idPerfil, $_idPadre);
            $objClase  = null;
            echo json_encode($resultado);
        }
        else if($action=="cargarDetalle")
        {
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