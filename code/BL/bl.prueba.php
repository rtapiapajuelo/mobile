<?php
    /********************************************************************************
     * Prueba
     *
     * @author RTP 
     * @version 1.0
     * @fecha 15/09/2015     
     ********************************************************************************/

	$_ruta = "../";
	require_once  $_ruta . "DA/da.proceso.php";
    require_once  $_ruta . "DA/da.documentoAsignado.php";
	//$objClase	= new ClsProceso();

    $objClase                   = ClsDocumentoAsignado::getInstance();
    $resultadoD                 = $objClase->fcListarDocumentoAsignado(6, 2);
    $objClase                   = null;
    if (sizeof($resultadoD)==1){
        $_serieDoc  = $resultadoD[0]['mov_vch_serie'];
        $_numeroDoc = $resultadoD[0]['mov_vch_numero'];
        $_aliasDoc  = $resultadoD[0]['mov_vch_alias'];
        if ($_aliasDoc=="OS"){
            $_documentoCompleto = substr($_serieDoc, -2) . "/" . $_numeroDoc;
        }else{
            $_documentoCompleto = $_serieDoc . "-" . $_numeroDoc;
        }
    }
    $resultadoD = null;
    echo $_documentoCompleto . "<br>";
    
    echo "<br>Primero<br>";
    $_idDatoOpcion = 5;
    $_tipoInstruccion = "";
    $_dataBase = "";
    $_tabla = "";
    $_idProcesoDato = 0;
    $objClase   = ClsProceso::getInstance();
    $resultado = $objClase->fcListarProcesoDato($_idDatoOpcion, $_tipoInstruccion, $_dataBase, $_tabla, $_idProcesoDato);
    $objClase  = null;
    echo json_encode($resultado);
    echo "<br>Segundo<br>";
    $_idDatoOpcion = 5;
    $_tipoInstruccion = "INSERT";
    $_dataBase = "agencia";
    $_tabla = "tbl_cli_incidencias";
    $_idProcesoDato = 0;
    $objClase   = ClsProceso::getInstance();    
    $resultado = $objClase->fcListarProcesoDato($_idDatoOpcion, $_tipoInstruccion, $_dataBase, $_tabla, $_idProcesoDato);
    echo json_encode($resultado);    
    $objClase = null;    
?>