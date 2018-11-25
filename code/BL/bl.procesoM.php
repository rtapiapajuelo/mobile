<?php
/********************************************************************************
 * Recibe datos del formulario de proceso recibiendo los datos para el proceso.
 *
 * @author RTP 
 * @version 1.0
 * @fecha 15/09/2015     
 ********************************************************************************/
	
$_ruta = "../";
require_once $_ruta."BL/bl.sesion.ctrl.php";
require_once $_ruta . "DA/da.documentoAsignado.php";
require_once $_ruta . "DA/da.proceso.php";
require_once $_ruta . "FNC/fnc.basica.php";
$_resultado     = "";
$_aEtiquetas    = array();
$objClaseD      = ClsDocumentoAsignado::getInstance();
//if ($_POST)
//{
$_aLeyenda= $objClaseD->fcListarLeyenda(0);
$action = isset($_POST['action'])?sprintf("%s",$_POST['action']):sprintf("%s",$_GET['action']);
if($action == "procesar")
{
    $_idDocumentoSeleccionado   = utf8_encode(isset($_POST['idDocumentoSeleccionado'])?(trim($_POST['idDocumentoSeleccionado'])):
                                                 (isset($_GET['idDocumentoSeleccionado'])?(trim($_GET['idDocumentoSeleccionado'])):"0"));
    $_idDatoOpcion		= utf8_encode(isset($_POST['idDatoOpcion'])?(trim($_POST['idDatoOpcion'])):
                                            (isset($_GET['idDatoOpcion'])?(trim($_GET['idDatoOpcion'])):"0"));
    $_codIncidencia		= utf8_encode(isset($_POST['codIncidencia'])?(trim($_POST['codIncidencia'])):
                                        (isset($_GET['codIncidencia'])?(trim($_GET['codIncidencia'])):"0"));
    $_ctrIncidencia		= utf8_encode(isset($_POST['ctrIncidencia'])?(trim($_POST['ctrIncidencia'])):
                                                (isset($_GET['ctrIncidencia'])?(trim($_GET['ctrIncidencia'])):"0"));
    $_envCorreo			= utf8_encode(isset($_POST['envCorreo'])?(trim($_POST['envCorreo'])):
                                                (isset($_GET['envCorreo'])?(trim($_GET['envCorreo'])):"N"));
    $_latitud			= utf8_encode(isset($_POST['varLATITUD'])?(trim($_POST['varLATITUD'])):
                                        (isset($_GET['varLATITUD'])?(trim($_GET['varLATITUD'])):"0"));
    $_longitud			= utf8_encode(isset($_POST['varLONGITUD'])?(trim($_POST['varLONGITUD'])):
                                        (isset($_GET['varLONGITUD'])?(trim($_GET['varLONGITUD'])):"0"));
    $_fechaHoraM		= utf8_encode(isset($_POST['varFECHAHORA'])?(trim($_POST['varFECHAHORA'])):
                                               (isset($_GET['varFECHAHORA'])?(trim($_GET['varFECHAHORA'])):date("Y-m-d H:i:s")));
    $_fechaM                    = utf8_encode(isset($_POST['varFECHA'])?(trim($_POST['varFECHA'])):
                                        (isset($_GET['varFECHA'])?(trim($_GET['varFECHA'])):date("Y-m-d")));
    $_horaM			= utf8_encode(isset($_POST['varHORA'])?(trim($_POST['varHORA'])):
                                            (isset($_GET['varHORA'])?(trim($_GET['varHORA'])):date("H:i:s")));
    $_editar                    = isset($_POST['editar'])?intval($_POST['editar']):0;
    $_descripcionIncid          = $_SESSION['ORDEN']['INCIDENCIA'];
    if ($_editar>0)
    {
        $_descripcionIncid              = isset($_POST['txtEDITAR'])?sprintf("%s",$_POST['txtEDITAR']):$_SESSION['ORDEN']['INCIDENCIA'] ;
        $_SESSION['ORDEN']['INCIDENCIA']= $_descripcionIncid;
    }
    $_fechaHoraA			= utf8_encode(date("Y-m-d H:i:s"));
    $_fechaA 				= utf8_encode(date("Y-m-d"));
    $_horaA				= utf8_encode(date("H:i:s"));
    $_ipRemoto				= utf8_encode(getRealIP());
    $_idUsuario				= $_SESSION['idUsuario'];
    $_usuario 				= $_SESSION['usuario'];
    $_usuarioOperaciones                = $_SESSION['usuarioOperaciones'];        
    $resultadoD                         = $objClaseD->fcListarDocumentoAsignado($_idUsuario, $_idDocumentoSeleccionado);
    if (sizeof($resultadoD)>0)
    {
        $_serieDoc 	= $resultadoD[0]['mov_vch_serie'];
        $_numeroDoc     = $resultadoD[0]['mov_vch_numero'];
        $_aliasDoc	= $resultadoD[0]['mov_vch_alias'];
        if ($_aliasDoc=="OS")
        {
            $_documentoCompleto = substr($_serieDoc, -2) . "/" .str_pad($_numeroDoc, 8, "0", STR_PAD_LEFT); 
        }
        else
        {
            $_documentoCompleto = $_serieDoc . "-" . $_numeroDoc;
        }
        
        if ($_idDatoOpcion!="0")
        {
            $_idProcesoDato     = 0;
            $_tipoInstruccion   = "";
            $_dataBase          = "";
            $_tabla             = "";
            $objProceso           = ClsProceso::getInstance();
            $resultadoG         = $objProceso->fcListarProcesoDato($_idDatoOpcion   , $_tipoInstruccion , $_dataBase    , 
                                                                   $_tabla          , $_idProcesoDato                   );
            $totalRegG  = (sizeof($resultadoG) - 1);
            for ($y=0; $y<=$totalRegG; $y++)
            {
                $_tipoInstruccion 	= $resultadoG[$y]['mov_vch_tipoinstruccion'];
                $_dataBase 		= $resultadoG[$y]['mov_vch_database'];
                $_tabla                 = $resultadoG[$y]['mov_vch_tabla'];
                $_columnaIns            = "";
                $_columnaVal            = "";
                $_columnaUpd            = "";
                $_columnaWhere          = "";
                $_tipoLimitador         = "";
                $_comaInsert            = "";
                $_comaUpdate            = "";
                $resultado              = $objProceso->fcListarProcesoDato($_idDatoOpcion     , $_tipoInstruccion     , 
                                                              $_dataBase  , $_tabla           , $_idProcesoDato     );                
                $totalReg  = (sizeof($resultado) - 1);
                for ($x=0; $x<=$totalReg; $x++)
                {   
                    $_tipoLimitador     = "";
                    if (($resultado[$x]["mov_vch_valorautomatico"]=="S" &&
                        $resultado[$x]["mov_vch_tipovalor"]=="CADENA") || 
                        (($resultado[$x]["mov_vch_valorautomatico"]=="N" ||
                           $resultado[$x]["mov_vch_valorautomatico"]=="C") &&
                         ($resultado[$x]["mov_vch_tipovalor"]=="CADENA" ||
                          $resultado[$x]["mov_vch_tipovalor"]=="HORA"   ||
                          $resultado[$x]["mov_vch_tipovalor"]=="FECHA"  || 
                          $resultado[$x]["mov_vch_tipovalor"]=="FECHAHORA" ) ) )
                    {
                        $_tipoLimitador = "'";
                    }
                    
                    if ($_tipoInstruccion=="INSERT")
                    {   
                        $_columnaIns	.= " " . $resultado[$x]['mov_vch_columna'] . ",";
                        if($resultado[$x]['mov_vch_valorcampo']!="")
                        {
                            if (parseint($resultado[$x]['mov_int_tipoentrada'])==3)
                            {
                                $_columnaVal	.=  $_comaInsert."".$_tipoLimitador."".
                                                    $resultado[$x]['mov_vch_valorcampo']."".$_tipoLimitador."";
                            }
                            else if (parseint($resultado[$x]['mov_int_tipoentrada'])==2)
                            {
                                $_columnaVal	.= $_comaInsert."".$_tipoLimitador."".
                                                  $objProceso->fcUbicarEtiqueta($resultado[$x]['mov_vch_valorcampo'],
                                                            $_aLeyenda)."".$_tipoLimitador."";
                            }
                            else
                            {
                                $_columnaVal	.= $_comaInsert."".$_tipoLimitador."".(utf8_encode(isset($_POST[$resultado[$x]['mov_vch_valorcampo']])?
                                                                                                            (trim($_POST[$resultado[$x]['mov_vch_valorcampo']])):
                                                                                                (isset($_GET[$resultado[$x]['mov_vch_valorcampo']])?
                                                                                                $_GET[$resultado[$x]['mov_vch_valorcampo']]:""))).
                                                                "".$_tipoLimitador."";
                            }
                            $_comaInsert = ",";
                        }
                        else
                        {
                            $_columnaVal.=  $_comaInsert."".$_tipoLimitador."".$_tipoLimitador."";
                        }
                    }
                    else if ($_tipoInstruccion=="UPDATE")
                    {
                        if ($resultado[$x]['mov_vch_valorcampo']=="varDOCUMENTO" )
                        {
                            
                        }
                    }
                }
                
                $resultadoP = $objProceso->fcProcesar($_tipoInstruccion, $_dataBase, $_tabla, $_columnaIns, $_columnaVal, $_columnaUpd, $_columnaWhere);           
                if ($objClase->_total==1)
                {
                    $_resultado = "resultadoOK";
	        }
            }
        }

    }


}
//}

?>