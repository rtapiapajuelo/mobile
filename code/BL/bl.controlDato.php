<?php
    /********************************************************************************
     * Control Dato de acuerdo al dato seleccionado se muestra informacion de los controles del formulario
     *
     * @author RTP 
     * @version 1.0
     * @fecha 15/09/2015     
     ********************************************************************************/

	$_ruta = "../";
        require_once $_ruta."BL/bl.sesion.ctrl.php";
	require_once $_ruta . "DA/da.controlDato.php";
        $objClase	= new ClsControlDato(); 
    if ($_POST)
    {
        $action = sprintf("%s",$_POST['action']);
        if ($action=='asignarDatosCmpl')
        {
            $_idDatoOpcion  = sprintf("%d",$_POST['datoOpcion']);
            $_aDatos        = $objClase->fcListarOpcionDato($_idDatoOpcion);
            if (sizeof($_aDatos)>0)
            {
                $_SESSION['ORDEN']['CINCIDENCIA']   = $_aDatos[0]['mov_vch_codincidencia'];
                $_SESSION['ORDEN']['CTRL']          = $_aDatos[0]['mov_vch_ctrincidencia'];                    
                $_SESSION['ORDEN']['INCIDENCIA']    = $_aDatos[0]['mov_vch_dato_opciones_app'];
            }
            echo 'OK';
        }
	}
    elseif ($_GET)
    {
            $action = sprintf("%s",$_GET['action']);               	
            if($action=="cargarLista")
            {
                $_idDatoOpcion  = sprintf("%d",$_GET['idDatoOpcion']);
                $_idControlDato = 0;
                $resultado      = $objClase->fcListarControlDato($_idDatoOpcion, $_idControlDato);
                $_aDatos        = $objClase->fcListarOpcionDato($_idDatoOpcion);
                $_rpta = array();
                $_rpta['total']         = sizeof($_aDatos);
                $_rpta['descripcion']   = "";
                //echo sizeof($_aDatos);
                if (sizeof($_aDatos)>0)
                {
                    $_SESSION['ORDEN']['CINCIDENCIA']   = $_aDatos[0]['mov_vch_codincidencia'];
                    $_SESSION['ORDEN']['CTRL']          = $_aDatos[0]['mov_vch_ctrincidencia'];
                    $_rpta['descripcion']               = $_aDatos[0]['mov_vch_dato_opciones_app'];
                    $_rpta['codincid']                  = $_aDatos[0]['mov_vch_codincidencia'];
                    $_rpta['ctrlincid']                 = $_aDatos[0]['mov_vch_ctrincidencia'];
                    $_SESSION['ORDEN']['INCIDENCIA']    = $_aDatos[0]['mov_vch_dato_opciones_app'];

                }

                
                $_aControles = $resultado;
                if ($_idDatoOpcion>0)
                {   $_aControles = array();
                    for ($_g=0; $_g< sizeof($resultado); $_g++)
                    {   $_aControles[$_g] = $resultado[$_g];
                        $_aControles[$_g]['html']='';
                       
                        if ($resultado[$_g]['mov_vch_tipo_control']=='L' && $resultado[$_g]['codigoo']>0)
                        {   $_html  = '';
                            $_sql = "";
                            if ($resultado[$_g]['tipoo']=='1') 
                            {
                                $_sql = $resultado[$_g]['instrucciono'];
                            }
                            else if ($resultado[$_g]['tipoo']=='2') 
                            {
                                $_sql = "call ".$resultado[$_g]['instrucciono']."('".$_SESSION['ORDEN']['DOCUMENTO']."')";
                            }
                            
                            $_datosControl = $objClase->fcConsultaQuery($_sql); //$objClase->fcListarConsulta($_sql);
                            for ($_co=0 ; $_co<sizeof($_datosControl); $_co++)
                            {
                                $_html.='<option value="'.$_datosControl[$_co]['id'].'">'.$_datosControl[$_co]['texto'].
                                '</option>';
                            }   
                            $_aControles[$_g]['html']=$_html; 
                        }
                    }
                }
                

                $_rpta['controles'] = $_aControles;                
                $objClase       = null;
                //print_r($_SESSION['ORDEN']);
                echo json_encode($_rpta);
            }
	}
?>