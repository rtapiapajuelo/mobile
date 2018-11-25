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
            elseif ($_action=='verHistorial')
            {
                $_ndocumento    = $_SESSION['ORDEN']['DOCUMENTO'];
                $_operaciones = $objClase->fcHistorial(1, $_ndocumento  , $_iusuario , 0);
                $_html ="<ul>";
                for ($_g=0;$_g<sizeof($_operaciones);$_g++)
                {
                    $_html.="<li>";
                    $_html.="".$_operaciones[$_g]['FECHA']." ".$_operaciones[$_g]['DOCUMENTO']." - ".$_operaciones[$_g]['OPCION']
                              ."".($_operaciones[$_g]['INCIDENCIA']<>""?" ".$_operaciones[$_g]['INCIDENCIA']:"");
                    $_html.="</li>";
                }
                $_html.="<ul>";
                echo $_html;
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
            $action = sprintf("%s",$_GET['action']);
            $objClase	= new ClsDocumentoAsignado();    	
            if($action=="cargarLista")
            {
                $_idUsuario = isset($_SESSION['idUsuario'])?intval($_SESSION['idUsuario']):0;
                $resultado = $objClase->fcListarDocumentoAsignado($_idUsuario, 0 , 1, 0 , 100);
                $objClase  = null;
                echo json_encode($resultado);
            }
            elseif ($action=="listaropciones")
            {
                $page 		= isset($_GET['draw'])?$_GET['draw']:1; // get the requested page
                $limit 		= isset($_GET['length'])?$_GET['length']:10; // get how many rows we want to have into the grid
                $_inicio 	= isset($_GET['start'])?$_GET['start']:0;	
                $campoOrden	= isset($_GET['order'][0]['column'])?$_GET['order'][0]['column']:2;
                $_nombre 	= isset($_GET['search']['value'])?sprintf("%s",$_GET['search']['value']):"";	
                $nCampo         = $campoOrden;
                $_fin 		= $_inicio + $limit;               
                $resultado      = $objClase->fcListarOpciones($_nombre, 0, ($_inicio+1) , $_fin); 
                $_dataR         = array();
                              
                $_cont          = 0;
                $_totalFilas    = 0;
                
                for ($_j=0; $_j<sizeof($resultado); $_j++)
                {
                    $_dataR[$_cont]['n']       = ($resultado[$_cont]['n']);
                    $_dataR[$_cont]['nombre']  = ($resultado[$_cont]['nombre'])."<br/><b>Alias</b>".($resultado[$_cont]['alias']);
                    $_dataR[$_cont]['otros']   = "<b>Perfil :</b>".$resultado[$_cont]['nombrep'].
                                                 "<br/><b>Opcion Padre:</b>".($resultado[$_cont]['npadre']).
                                                 "<br/><b>Es ultima opcion:</b>".($resultado[$_cont]['ultimo']=='N'?"NO":"SI");                    
                    $_totalFilas               = $resultado[$_cont]['NFILA'];
                    
                    $_dataR[$_cont]['edit']    = "<a href=javascript:modificar('".$resultado[$_cont]['codigo']."')><img src='../".$_ruta."/images/edit.png' alt='Modifcar' ></a>".
                                                 "<a href=javascript:verOpciones('".$resultado[$_cont]['codigo']."')><img src='../".$_ruta."/images/view.gif' alt='Ver opciones' width='20'></a>";
                    $_cont++;
                }
                $json                       = array('data'              => $_dataR	,
                                                    'recordsTotal'      => $_totalFilas ,
                                                    'recordsFiltered'   => $_totalFilas ,
                                                    'draw'              => $page        );
                echo json_encode($json); 
            }
            elseif ($action=="listardocumentos")
            {
                $page 		= isset($_GET['draw'])?$_GET['draw']:1; // get the requested page
                $limit 		= isset($_GET['length'])?$_GET['length']:10; // get how many rows we want to have into the grid
                $_inicio 	= isset($_GET['start'])?$_GET['start']:0;	
                $campoOrden	= isset($_GET['order'][0]['column'])?$_GET['order'][0]['column']:2;
                $_nombre 	= isset($_GET['search']['value'])?sprintf("%s",$_GET['search']['value']):"";	
                $nCampo = $campoOrden;
                $_fin 		= $_inicio + $limit;               
                $resultado = $objClase->fcListarDocumento($_nombre, 0, ($_inicio+1) , $_fin); 
                $_dataR = array();
                              
                $_cont = 0;
                $_totalFilas = 0;
                
                for ($_j=0; $_j<sizeof($resultado); $_j++)
                {
                    $_dataR[$_cont]['n']       = ($resultado[$_cont]['n']);
                    $_dataR[$_cont]['nombre']  = ($resultado[$_cont]['nombre']);
                    $_dataR[$_cont]['alias']   = ($resultado[$_cont]['alias'])." <br/> Captura de logitud de serie:".
                                                 ($resultado[$_cont]['longitud']);                    
                    $_totalFilas               =  $resultado[$_cont]['NFILA'];
                    
                    $_dataR[$_cont]['edit']    = "<img src='../".$_ruta."/images/view.gif' alt='Modificar'>";
                    $_cont++;
                }
                $json                       = array('data'              => $_dataR	,
                                                    'recordsTotal'      => $_totalFilas ,
                                                    'recordsFiltered'   => $_totalFilas ,
                                                    'draw'              => $page        );
                echo json_encode($json);                
            }
            elseif ($action=="listarAsignados")
            {
                $page 		= isset($_GET['draw'])?$_GET['draw']:1; // get the requested page
                $limit 		= isset($_GET['length'])?$_GET['length']:10; // get how many rows we want to have into the grid
                $_inicio 	= isset($_GET['start'])?$_GET['start']:0;	
                $campoOrden	= isset($_GET['order'][0]['column'])?$_GET['order'][0]['column']:2;
                $nOrden 	= isset($_GET['search']['value'])?sprintf("%s",$_GET['search']['value']):"";	
                $nCampo = $campoOrden;
                $_fin 			= $_inicio + $limit;               
                
                $resultado = $objClase->fcListarDocumentoAsignado(0, 0 , 1 ,  ($_inicio+1) , $_fin , $nCampo , $nOrden);
                $_dataR = array();
                              
                $_cont = 0;
                $_totalFilas = 0;
                
                for ($_j=0; $_j<sizeof($resultado); $_j++)
                {
                    $_dataR[$_cont]['n']        = ($resultado[$_cont]['n']);
                    $_dataR[$_cont]['alias']    = ($resultado[$_cont]['mov_vch_alias'])."<br/> Asignado el <b>".$resultado[$_cont]['fecha']."</b>";
                    $_dataR[$_cont]['perfil']   = ($resultado[$_cont]['mov_vch_perfil_app'])."<br/><b>Usuario:</b>".($resultado[$_cont]['usuario']);
                    $_dataR[$_cont]['numero']   = ($resultado[$_cont]['mov_vch_numero']);
                     
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
            else if($action=="cargarUno")
            {
                $_idUsuario = isset($_SESSION['idUsuario'])?intval($_SESSION['idUsuario']):0;
                $_idDocumentoAsignado = sprintf("%d",$_GET['idDocumentoAsignado']);
                $resultado = $objClase->fcListarDocumentoAsignado($_idUsuario, $_idDocumentoAsignado);
                if (sizeof($resultado)>0)
                {
                    $_SESSION['ORDEN']['TIPDOCUMENTO']= $resultado[0]['mov_int_iddocumento'];
                    $_precision                       = $resultado[0]['mov_int_presicionserie'];
                    $_serieDoc                        = $resultado[0]['mov_vch_serie'];
                    if ($_precision<>0)
                    {
                        $_serieDoc=substr($_serieDoc, $_precision);
                        // substr($_serieDoc, -2)
                    }
                    if ($resultado[0]['mov_int_iddocumento']==1)
                    {
                        $_SESSION['ORDEN']['DOCUMENTO']   = $_serieDoc."/".$resultado[0]['mov_vch_numero'];
                    }
                    else
                    {
                        $_SESSION['ORDEN']['DOCUMENTO']   = $_serieDoc."-".$resultado[0]['mov_vch_numero'];
                    }
                }                
                $objClase  = null;
                echo json_encode($resultado);
            }
        }		
?>