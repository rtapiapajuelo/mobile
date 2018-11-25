<?php
    /********************************************************************************
     * Recibe datos del formulario de proceso recibiendo los datos para el proceso.
     *
     * @author RTP 
     * @version 1.0
     * @fecha 01/01/2016     
     ********************************************************************************/
	
    $_ruta = "../";
    require_once $_ruta."BL/bl.variables.php";
    require_once $_ruta."BL/bl.sesion.ctrl.php";
    require_once $_ruta."DA/da.documentoAsignado.php";
    require_once $_ruta."DA/da.controlDato.php";
    require_once $_ruta."DA/da.proceso.php";
    //fcListarOpcionDato($_id )
    require_once $_ruta."FNC/fnc.basica.php";
    $_resultado     = "";
    $_aEtiquetas    = array();
    $objClaseP      = ClsProceso::getInstance();
    $objClaseD      = ClsDocumentoAsignado::getInstance();
    $objControlDato = ClsControlDato::getInstance();
    $_documentoCompleto = "";
    $_SESSION['ORDEN']['RCLIENTE'] = "";
    $_SESSION['ORDEN']['REGIMEN']  = "";
    $_SESSION['ORDEN']['ADUANA']   = "";
    /**
     * Funcion para extraer datos en base al nombre
     * @param type $_arrayNombres
     * @param type $_referencia
     */
    function fcExtraerValor($_arrayNombres , $_referencia, $_documento, $_perfil)     
    {  global $_SESSION;
       global $objClaseP;
       $_valor = $_referencia;       
       for ($_i=0; $_i<sizeof($_arrayNombres); $_i++)
       {    
           if (strpos($_referencia,$_arrayNombres[$_i]['mov_vch_etiqueta'])!== false)
           {              
               if ($_arrayNombres[$_i]['mov_int_tipovalor']=="1")
                {
                    $_valor = str_replace($_arrayNombres[$_i]['mov_vch_etiqueta'],${"".$_arrayNombres[$_i]['mov_vch_variable'].""},$_referencia);
               }
               else if ($_arrayNombres[$_i]['mov_int_tipovalor']=="2")
               {
                   $_valorRefrencial = $_arrayNombres[$_i]['mov_vch_variable'];
                   eval(' $_valor = str_replace($_arrayNombres[$_i][\'mov_vch_etiqueta\'],'.$_valorRefrencial.',$_referencia);');                   
               }
               else if ($_arrayNombres[$_i]['mov_int_tipovalor']=="3")
               {
                   $_valor = $objClaseP->fcObtenValorFuncion($_documento , $_arrayNombres[$_i]['mov_vch_fuente'],$_perfil,1 );
                   
               }                                 
               else if ($_arrayNombres[$_i]['mov_int_tipovalor']=="4")
               {
                   $_valor = $objClaseP->fcObtenValorFuncion('',$_arrayNombres[$_i]['mov_vch_fuente'],0,2);
               }              
           }         
                                                
       }
       return $_valor;
    }
    
    
        
    if ($_POST)
    {   $_aLeyenda= $objClaseD->fcListarLeyenda(0);
        $action = sprintf("%s",$_POST['action']);
        if($action == "procesar")
        {
            $_idDocumentoSeleccionado           = utf8_encode(isset($_POST['idDocumentoSeleccionado'])?(trim($_POST['idDocumentoSeleccionado'])):"0");
            $_idDatoOpcion			= utf8_encode(isset($_POST['idDatoOpcion'])?(trim($_POST['idDatoOpcion'])):"0");
            $_codIncidencia			= utf8_encode(isset($_POST['codIncidencia'])?(trim($_POST['codIncidencia'])):"");
            $_ctrIncidencia			= utf8_encode(isset($_POST['ctrIncidencia'])?(trim($_POST['ctrIncidencia'])):"0");
            $_envCorreo				= utf8_encode(isset($_POST['envCorreo'])?(trim($_POST['envCorreo'])):"N");
            $_latitud				= utf8_encode(isset($_POST['varLATITUD'])?(trim($_POST['varLATITUD'])):"0");
            $_longitud				= utf8_encode(isset($_POST['varLONGITUD'])?(trim($_POST['varLONGITUD'])):"0");
            $_fechaHoraM			= utf8_encode(isset($_POST['varFECHAHORA'])?(trim($_POST['varFECHAHORA'])):date("Y-m-d H:i:s"));
            $_fechaM 				= utf8_encode(isset($_POST['varFECHA'])?(trim($_POST['varFECHA'])):date("Y-m-d"));
            $_horaM				= utf8_encode(isset($_POST['varHORA'])?(trim($_POST['varHORA'])):date("H:i:s"));
            $_editar                            = isset($_POST['editar'])?intval($_POST['editar']):0;
            $_descripcionIncid                  = isset($_SESSION['ORDEN']['INCIDENCIA'])?$_SESSION['ORDEN']['INCIDENCIA']:"";
            if ($_editar>0)
            {
                $_descripcionIncid               = strtoupper(isset($_POST['txtEDITAR'])?sprintf("%s",$_POST['txtEDITAR']):$_SESSION['ORDEN']['INCIDENCIA'] );
                $_SESSION['ORDEN']['INCIDENCIA'] = $_descripcionIncid;
            }
            if (isset($_SESSION['ORDEN']['CINCIDENCIA'])) { if ($_codIncidencia=="") { $_codIncidencia =$_SESSION['ORDEN']['CINCIDENCIA'];} }
            $_fechaHoraA			= utf8_encode(date("Y-m-d H:i:s"));
            $_fechaA 				= utf8_encode(date("Y-m-d"));
            $_horaA				= utf8_encode(date("H:i:s"));
            $_ipRemoto				= utf8_encode(getRealIP());
            $_idUsuario				= $_SESSION['idUsuario'];
            $_usuario 				= $_SESSION['usuario'];
            $_usuarioOperaciones    = $_SESSION['usuarioOperaciones'];
            $objClaseDA   			= $objClaseD;
            $resultadoD 			= $objClaseDA->fcListarDocumentoAsignado($_idUsuario, $_idDocumentoSeleccionado);
            $_pefilUsu              = 0;             
            $objClase 				= null;
            if (sizeof($resultadoD)==1)
            {
                $_SESSION['ORDEN']['SERIE'] 	= $resultadoD[0]['mov_vch_serie'];
                $_serieDoc                      = $resultadoD[0]['mov_vch_serie'];
                $_numeroDoc                     = $resultadoD[0]['mov_vch_numero'];
                $_SESSION['ORDEN']['NUMERO']    = $resultadoD[0]['mov_vch_numero'];
                $_aliasDoc	                    = $resultadoD[0]['mov_vch_alias'];
                $_pefilUsu                      = $resultadoD[0]['mov_int_idperfil_app'];
                $_precision                     = $resultadoD[0]['mov_int_presicionserie'];
                if ($_precision<>0)
                {
                    $_serieDoc=substr($_serieDoc, $_precision);
                    // substr($_serieDoc, -2)
                }

                if ($_aliasDoc=="OS")
                {
                        $_documentoCompleto = $_serieDoc . "/" .str_pad($_numeroDoc, 8, "0", STR_PAD_LEFT); 
                }
                else
                {
                        $_documentoCompleto = $_serieDoc . "-" . $_numeroDoc;
                }
            }
            $resultadoD = null;
            if (trim($_idDocumentoSeleccionado)!="0" && trim($_idDatoOpcion)!="0")
            {
                //$_idDatoOpcion
                $_enviaCorreoE      = "N";
                $_SESSION['ORDEN']['RCLIENTE'] = fcExtraerValor($_aLeyenda , "[RCLIENTE]", $_documentoCompleto,$_pefilUsu) ; 
                $_aOD=$objControlDato->fcListarOpcionDatosGen($_idDatoOpcion );//fcListarOpcionDato
                
                if (sizeof($_aOD)>0)
                {
                    $_enviaCorreoE      = $_aOD[0]['mov_chr_correo'];
                }
                
                $_idProcesoDato     = 0;
                $_tipoInstruccion   = "";
                $_tipoIInstruccion   = 0;
                $_dataBase          = "";
                $_tabla             = "";
                //echo "-->>>>";
                $resultadoG         = $objClaseP->fcListarProcesoDato($_idDatoOpcion, $_tipoInstruccion, $_dataBase, $_tabla, $_idProcesoDato);
                //print_r($resultadoG);
                //$objClase           = null;
                $totalRegG  = (sizeof($resultadoG) - 1);
                // for para extrae item de procesamiento de datos
                $_separador = "";
                for ($y=0; $y<=$totalRegG; $y++)
                {
                    $_tipoInstruccion 	= $resultadoG[$y]['mov_vch_tipoinstruccion'];
                    $_dataBase 		= $resultadoG[$y]['mov_vch_database'];
                    $_tabla		= $resultadoG[$y]['mov_vch_tabla'];
                    $_columnaIns = "";
                    $_columnaVal = "";
                    $_columnaUpd = "";
                    $_columnaWhere = "";
                    $_andWhere     = " ";
                    $_comaInsert   = "";
                    $_comaUdp      = "";
                    //$objClase 	= ClsProceso::getInstance();
                    $resultado =$objClaseP->fcListarProcesoDato($_idDatoOpcion, $_tipoInstruccion, $_dataBase, $_tabla, $_idProcesoDato);
                    
                    $totalReg  = (sizeof($resultado) - 1);
		            for ($x=0; $x<=$totalReg; $x++)
                            {   $_separador = "";
                                if ($resultado[$x]['mov_vch_tipovalor']=="CADENA" || 
                                                (($resultado[$x]['mov_vch_tipovalor']=="FECHAHORA" || $resultado[$x]['mov_vch_tipovalor']=="HORA" || $resultado[$x]['mov_vch_tipovalor']=="FECHA") 
                                                 && $resultado[$x]['mov_vch_valorautomatico']=="N") ) { $_separador="'"; }
		            	if ($_tipoInstruccion=="INSERT")
                                {
                                    $_tipoIInstruccion = 1;
                                    $_columnaIns	.= $_comaInsert.$resultado[$x]['mov_vch_columna']."";
                                    if ($resultado[$x]['mov_int_tipoentrada']=="2")
                                    {
                                        $_columnaVal	.= $_comaInsert.$_separador.fcExtraerValor($_aLeyenda,$resultado[$x]['mov_vch_valorcampo'],$_documentoCompleto,$_pefilUsu ).$_separador;
                                    }
                                    else if($resultado[$x]['mov_vch_valorcampo']!="" && $resultado[$x]['mov_int_tipoentrada']!="3" )
                                    {       

                                            switch ($resultado[$x]['mov_vch_valorcampo']) 
                                            {
                                                case "varDOCUMENTO":
                                                    $_columnaVal	.= $_comaInsert.$_separador. $_documentoCompleto.$_separador."";
                                                    break;
                                                case "varCODINCIDENCIA":
                                                    $_columnaVal	.= $_comaInsert.$_separador.$_codIncidencia. "".$_separador;
                                                    break;
                                                case "varIP":
                                                    $_columnaVal	.= $_comaInsert.$_separador.$_ipRemoto . "".$_separador;
                                                    break;
                                                case "varUSUARIO":
                                                    $_columnaVal	.= "'" . $_usuario . "',";
                                                    break;
                                                case "varUSUARIOO":
                                                    $_columnaVal	.= $_comaInsert.$_separador.$_usuarioOperaciones . "".$_separador;
                                                    break;							        
                                                case "varUSUARIOFH":
                                                    $_columnaVal	.= $_comaInsert.$_separador.$_usuario . "*" . $_fechaM . "*" . $_horaM . "".$_separador;
                                                    break;
                                                case "varUSUARIOOFH":
                                                    $_columnaVal	.= "'" . $_usuarioOperaciones . "*" . $_fechaM . "*" . $_horaM . "',";
                                                    break;							        								    
                                                default;
                                                    $_columnaVal	.= $_comaInsert.$_separador.utf8_encode(isset($_POST[$resultado[$x]['mov_vch_valorcampo']])?(trim($_POST[$resultado[$x]['mov_vch_valorcampo']])):$resultado[$x]['mov_vch_valorcampo']).$_separador;
                                                    break;								    

                                            }
                                    }
                                    else
                                    {   
                                        $_columnaVal	.= $_comaInsert.$_separador.$resultado[$x]['mov_vch_valorcampo'].$_separador;
                                    }   
                                    $_comaInsert=",";
		            	    }
                             elseif ($_tipoInstruccion=="UPDATE")
                             {    
                                    $_tipoIInstruccion = 2;                   
                                    if($resultado[$x]['mov_vch_valorcampo']!="")
                                    {
                                        if ($resultado[$x]['mov_vch_valorautomatico']=="C")
                                        {
                                            if ($resultado[$x]['mov_vch_valorcampo']=="varDOCUMENTO")
                                            {
                                                $_columnaWhere .= $_andWhere.$resultado[$x]['mov_vch_columna'] . "=" . $_separador."". $_documentoCompleto ."".$_separador;
                                            }
                                            else
                                            {
                                                if ($resultado[$x]['mov_int_tipoentrada']=="2")
                                                {
                                                    $_columnaWhere .= $_andWhere.$resultado[$x]['mov_vch_columna'] . "=". $_separador.fcExtraerValor($_aLeyenda,$resultado[$x]['mov_vch_valorcampo'],$_documentoCompleto,$_pefilUsu).$_separador;
                                                }
                                                else
                                                {   $_valorAsignado = ($resultado[$x]['mov_vch_valorcampo']=="varIP")?$_ipRemoto:
                                                                (($resultado[$x]['mov_vch_valorcampo']=="varUSUARIOFH")?$_usuario . "*" . $_fechaM . "*" . $_horaM . ""
                                                                    :utf8_encode(isset($_POST[$resultado[$x]['mov_vch_valorcampo']])?(trim($_POST[$resultado[$x]['mov_vch_valorcampo']])):$resultado[$x]['mov_vch_valorcampo']));
                                                    $_columnaWhere .= $_andWhere.$resultado[$x]['mov_vch_columna'] . "=" . $_separador.$_valorAsignado.$_separador;
                                                }
                                            }                                            
                                            $_andWhere = " and ";                                            
                                        } 
                                        else
                                        {
                                            if ($resultado[$x]['mov_vch_valorcampo']=="varDOCUMENTO")
                                            {
                                                $_columnaUpd .= $_comaUdp.$resultado[$x]['mov_vch_columna']."=".$_separador."". $_documentoCompleto ."".$_separador;
                                            }
                                            else
                                            {
                                                if ($resultado[$x]['mov_int_tipoentrada']=="2")
                                                {
                                                    $_columnaUpd.= $_comaUdp.$resultado[$x]['mov_vch_columna'] . "=". $_separador.fcExtraerValor($_aLeyenda,$resultado[$x]['mov_vch_valorcampo'],$_documentoCompleto,$_pefilUsu ).$_separador;
                                                }                                                
                                                else
                                                {
                                                    $_valorAsignado = ($resultado[$x]['mov_vch_valorcampo']=="varIP")?$_ipRemoto:
                                                                (($resultado[$x]['mov_vch_valorcampo']=="varUSUARIOFH")?$_ipRemoto.$_usuario . "*" . $_fechaM . "*" . $_horaM . ""
                                                                    :(($resultado[$x]['mov_vch_valorcampo']=="varUSUARIO")?$_usuario
                                                                        :utf8_encode(isset($_POST[$resultado[$x]['mov_vch_valorcampo']])?(trim($_POST[$resultado[$x]['mov_vch_valorcampo']])):$resultado[$x]['mov_vch_valorcampo'])));
                                                    $_columnaUpd.= $_comaUdp.$resultado[$x]['mov_vch_columna'] . "=". $_separador.$_valorAsignado.$_separador;
                                                }                                                
                                            }                                            
                                            $_comaUdp  = ",";
                                        }
                                        
                                    }                                                       
                                                        
		            	         }
		                    }
                            //$_columnaIns = substr($_columnaIns, 0, -1);
                            //$_columnaVal = substr($_columnaVal, 0, -1);
                            //$_columnaUpd = substr($_columnaUpd, 0, -1);
                            //$_columnaWhere = substr($_columnaWhere, 0, -3);
                            //$objClase 	= ClsProceso::getInstance();
			    $resultadoP = $objClaseP->fcProcesar($_tipoInstruccion, $_dataBase, $_tabla, $_columnaIns, $_columnaVal, $_columnaUpd, $_columnaWhere);
                            if ($objClaseP->_total==1)
                            {
                                    $_resultado = "resultadoOK";
                            }  
                            if ($_tipoIInstruccion ==1)
                            {
                                $_slqFinal = " insert ".$_dataBase.".".$_tabla."(".$_columnaIns.") value(".$_columnaVal.")";
                            }
                            else
                            {
                                $_slqFinal = " update ".$_dataBase.".".$_tabla." set ".$_columnaUpd." where ".$_columnaWhere." ";
                            }
                            $objClaseP->fcGrabarHistorico(     $_tipoIInstruccion , $_idUsuario , $_slqFinal , $_ipRemoto, $_idDatoOpcion ,$_documentoCompleto);
	        	} // fin de for para extraer procesamiento datos
                        
                        
	        	$_aCorreo = $objClaseP->fcListarCorreoEmail($_codIncidencia , (isset($_SESSION['ORDEN']['RCLIENTE'])?$_SESSION['ORDEN']['RCLIENTE']:"") 
                                                                    , 2 , 0 , $_idDatoOpcion);
                            
                        if (sizeof($_aCorreo)>0)
                        {
                            for ($_cr=0; $_cr<sizeof($_aCorreo); $_cr++)
                            {
                                // adicionamos phpmailer para enviar mensaje
                                $_correos = $_aCorreo[$_cr]['correos'];
                                $_cuerpo  = $_aCorreo[$_cr]['plantilla'];
                                if ($_enviaCorreoE=='S')
                                {
                                    require_once ($_ruta.'LIB/PHPMailer/class.phpmailer.php');
                                    $mail = new PHPMailer;                                      
                                    $mail->Host=$_host;                
                                    $mail->Timeout=30;
                                    $mail->IsSMTP();
                                    $mail->Port=25;
                                    $mail->From = trim($_de."@".$_dominio);
                                    $mail->FromName = $_nombreRemitente;
                                    $mail->isHTML(true);
                                    $mail->AddEmbeddedImage($_ruta.'../images/logoMSG.gif', 'logo');
                                    $mail->AddEmbeddedImage($_ruta.'../images/pie.gif', 'pie');
                                    $_listaCorreos = explode(",", $_correos);
                                    for ($_em = 0; $_em < sizeof($_listaCorreos); $_em++)
                                    {
                                        $mail->AddAddress(trim($_listaCorreos[$_em]));
                                    }


                                    for ($_l = 0 ; $_l < sizeof($_aLeyenda); $_l++)
                                    {
                                        $posicion_coincidencia = strpos($_cuerpo , $_aLeyenda[$_l]['mov_vch_etiqueta']);                                    
                                        if (intval($posicion_coincidencia)>-1)
                                        {   
                                            $_valorET = fcExtraerValor($_aLeyenda, $_aLeyenda[$_l]['mov_vch_etiqueta'],$_documentoCompleto,$_pefilUsu );                                        
                                            $_cuerpo = str_replace($_aLeyenda[$_l]['mov_vch_etiqueta'],$_valorET,$_cuerpo);                                      

                                        }
                                    }

                                    $mail->Subject = $_documentoCompleto."- ".$_tituloCorreoMSG.(($_codIncidencia<>"")?" - INCIDENCIA ":"");;                        
                                    $mail->Body    = ($_cuerpo);
                                    if (!$mail->Send()) 
                                    {  echo  $mail->ErrorInfo; } 

                                }
                            }
                                               
                            
                        }
		    }
                    else
                    {
		        //echo json_encode(utf8_encode("rpta=500"));
		          }
		      }
		      echo json_encode($_resultado);
            }
          /*  
            elseif ($_GET)
            {
		$action = sprintf("%s",$_GET['action']);

		if($action == "procesar"){
			$_idDocumentoSeleccionado	= utf8_encode(isset($_GET['idDocumentoSeleccionado'])?(trim($_GET['idDocumentoSeleccionado'])):"0");
			$_idDatoOpcion				= utf8_encode(isset($_GET['idDatoOpcion'])?(trim($_GET['idDatoOpcion'])):"0");
			$_codIncidencia				= utf8_encode(isset($_GET['codIncidencia'])?(trim($_GET['codIncidencia'])):"0");
			$_ctrIncidencia				= utf8_encode(isset($_GET['ctrIncidencia'])?(trim($_GET['ctrIncidencia'])):"0");
			$_envCorreo					= utf8_encode(isset($_GET['envCorreo'])?(trim($_GET['envCorreo'])):"N");
			$_latitud					= utf8_encode(isset($_GET['varLATITUD'])?(trim($_GET['varLATITUD'])):"0");
			$_longitud					= utf8_encode(isset($_GET['varLONGITUD'])?(trim($_GET['varLONGITUD'])):"0");
			$_fechaHoraM				= utf8_encode(isset($_GET['varFECHAHORA'])?(trim($_GET['varFECHAHORA'])):date("Y-m-d H:i:s"));
			$_fechaM 					= utf8_encode(isset($_GET['varFECHA'])?(trim($_GET['varFECHA'])):date("Y-m-d"));
			$_horaM						= utf8_encode(isset($_GET['varHORA'])?(trim($_GET['varHORA'])):date("H:i:s"));
			$_fechaHoraA				= utf8_encode(date("Y-m-d H:i:s"));
			$_fechaA 					= utf8_encode(date("Y-m-d"));
			$_horaA						= utf8_encode(date("H:i:s"));
			$_ipRemoto					= utf8_encode(getRealIP());
			$_idUsuario					= $_SESSION['idUsuario'];
			$_usuario 					= $_SESSION['usuario'];
			$_usuarioOperaciones		= $_SESSION['usuarioOperaciones'];
			$_vacio						= "";
			
			$resultadoD 				= $objClase->fcListarDocumentoAsignado($_idUsuario, $_idDocumentoSeleccionado);
        	$objClase 					= null;
			if (sizeof($resultadoD)==1){
				$_serieDoc 	= $resultadoD[0]['mov_vch_serie'];
				$_numeroDoc = $resultadoD[0]['mov_vch_numero'];
				$_aliasDoc	= $resultadoD[0]['mov_vch_alias'];
				if ($_aliasDoc=="OS"){
					$_documentoCompleto = substr($_serieDoc, -2) . "/" . $_numeroDoc;
				}else{
					$_documentoCompleto = $_serieDoc . "-" . $_numeroDoc;
				}
			}
			$resultadoD = null;
			if(trim($_idDocumentoSeleccionado)!="0" && trim($_idDatoOpcion)!="0"){
	            $_idProcesoDato = 0;
	            $_tipoInstruccion = "";
	            $_dataBase = "";
	            $_tabla = "";
	            $objClase 	= ClsProceso::getInstance();
	        	$resultadoG 	= $objClase->fcListarProcesoDato($_idDatoOpcion, $_tipoInstruccion, $_dataBase, $_tabla, $_idProcesoDato);
	        	$objClase 	= null;
	        	$totalRegG  = (sizeof($resultadoG) - 1);
	        	for ($y=0; $y<=$totalRegG; $y++){
	            	$_tipoInstruccion 	= $resultadoG[$y]['mov_vch_tipoinstruccion'];
					$_dataBase 			= $resultadoG[$y]['mov_vch_database'];
					$_tabla				= $resultadoG[$y]['mov_vch_tabla'];
		            $_columnaIns = "";
		            $_columnaVal = "";
		            $_columnaUpd = "";
		            $_columnaWhere = "";
		            $objClase 	= ClsProceso::getInstance();
		        	$resultado =$objClase->fcListarProcesoDato($_idDatoOpcion, $_tipoInstruccion, $_dataBase, $_tabla, $_idProcesoDato);
		        	$objClase = null;
		        	$totalReg  = (sizeof($resultado) - 1);
		            for ($x=0; $x<=$totalReg; $x++){
		            	if ($_tipoInstruccion=="INSERT"){
							$_columnaIns	.= " " . $resultado[$x]['mov_vch_columna'] . ",";
							if($resultado[$x]['mov_vch_valorcampo']!=""){
								switch ($resultado[$x]['mov_vch_valorcampo']) {
								    case "varDOCUMENTO":
								        $_columnaVal	.= "'" . $_documentoCompleto . "',";
								        break;
								    case "varCODINCIDENCIA":
								        $_columnaVal	.= "'" . $_codIncidencia . "',";
								        break;
								    case "varIP":
								        $_columnaVal	.= "'" . $_ipRemoto . "',";
								        break;
									case "varUSUARIO":
								        $_columnaVal	.= "'" . $_usuario . "',";
								        break;
									case "varUSUARIOO":
								        $_columnaVal	.= "'" . $_usuarioOperaciones . "',";
								        break;							        
									case "varUSUARIOFH":
								        $_columnaVal	.= "'" . $_usuario . "*" . $_fechaM . "*" . $_horaM . "',";
								        break;
									case "varUSUARIOOFH":
								        $_columnaVal	.= "'" . $_usuarioOperaciones . "*" . $_fechaM . "*" . $_horaM . "',";
								        break;							        
								    case "varCTRINCIDENCIA";
								        $_columnaVal	.= "'" . $_ctrIncidencia . "',";
								        break;
								    case "varNROINCIDENCIA";
								        $_columnaVal	.= "'" . $sVar06 . "',";
								        break;
								    case "varINCIDENCIA";
								        $_columnaVal	.= "'" . $sVar07 . "',";
								        break;
									case "varVACIO";
								        $_columnaVal	.= "'" . $_vacio . " ',";
								        break;
									case "varFECHAHORA";
								        $_columnaVal	.= "'" . $_fechaHoraM . " ',";
								        break;
									case "varFECHA";
								        $_columnaVal	.= "'" . $_fechaM . " ',";
								        break;
									case "varHORA";
								        $_columnaVal	.= "'" . $_horaM . " ',";
								        break;
								    case "varLATITUD";
								        $_columnaVal	.= "'" . $_latitud . " ',";
								        break;
								    case "varLONGITUD";
								        $_columnaVal	.= "'" . $_longitud . " ',";
								        break;							        							    
								}
							}else{
								switch ($resultado[$x]['mov_vch_tipovalor']) {
									case "FECHAHORA";
								        $_columnaVal	.= "'" . $_fechaHoraA . " ',";
								        break;
									case "FECHA";
								        $_columnaVal	.= "'" . $_fechaA . " ',";
								        break;
									case "HORA";
								        $_columnaVal	.= "'" . $_horaA . " ',";
								        break;
								}								
							}
		            	}elseif ($_tipoInstruccion=="UPDATE"){

		            	}
		            }
					$_columnaIns = substr($_columnaIns, 0, -1);
					$_columnaVal = substr($_columnaVal, 0, -1);
					$_columnaUpd = substr($_columnaUpd, 0, -1);
					$_columnaWhere = substr($_columnaWhere, 0, -3);
					
					$objClase 	= ClsProceso::getInstance();
			        $resultadoP = $objClase->fcProcesar($_tipoInstruccion, $_dataBase, $_tabla, $_columnaIns, $_columnaVal, $_columnaUpd, $_columnaWhere);
	            	if ($objClase->_total==1){
						$_resultado = "resultadoOK";
	            	}
	            	$objClase = null;
	        	}
	        	$objClase = null;
		    }else{
		        //echo json_encode(utf8_encode("rpta=500"));
		    }
		}
		echo json_encode($_resultado);
	}
        */
?>