<?php
    /********************************************************************************
     * Recibe datos de la logica de negocio de documentos asignados.
     *
     * @author RTP 
     * @version 1.0
     * @fecha 15/09/2015     
     ********************************************************************************/
class ClsDocumentoAsignado
{
	var $_mensaje="";
    var $_total=0;
    
    private $_cn	= null;
    private $_objBD = null;
    private $_ruta = "../";
    public static $_instance = null; //The single instance
    
    public function __construct()
    {    
        if ($this->_objBD===null){
            require_once $this->_ruta.'BL/bl.inclusion.php';
            $this->_objBD   = $objBD;
            $this->_cn      = $conn;            
        }
    }

    public function __destruct()
    {
    //code
    }

    /*Evitamos el clonaje del objeto. Patrón Singleton*/
    private function __clone()
    {
    //code
    }

    /*Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos*/
    public static function getInstance(){
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;    
    }
    
    /**
     * Metodod que permite registrar o actualizar la asignacion de usuarios y documentos
     * @param type $_tipo
     * @param type $_idDocumento
     * @param type $_idPerfil
     * @param type $_idUsuario
     * @param type $_idUsuReg
     * @param type $_serie
     * @param type $_numeroDoc
     * @param type $_idDOcumentoAsignado
     * @return type
     */
    function fcDocumentoAsignado(   $_tipo      , $_idDocumento , $_idPerfil    , $_idUsuario   ,
                                    $_idUsuReg  , $_serie       , $_numeroDoc   , $_idDOcumentoAsignado)
    {
        $sqlProc    = sprintf("CALL sp_mov_crudDocumentoAsignado(%d, %d, %d, %d, %d, '%s','%s', %d)", 
                            $_tipo      , $_idDocumento , $_idPerfil    , $_idUsuario   ,
                                    $_idUsuReg  , $_serie       , $_numeroDoc   , $_idDOcumentoAsignado );
        $refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
        $_count     = 1;
        $this->_total = $_count;
        return $refDatos;
        
    }
    
    /**
     * Metodo que permite ver el detalle de una opcion
     * @param type $_idOpcion
     */
    function fcDetalleOpcion($_idOpcion )
    {
        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("CALL sp_mov_verdetralle(%d)", $_idOpcion );
        
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn))
        {
            do{
                if ($result = $this->_cn->store_result()) {
                    while ($_fila = $this->_objBD->fcExtraeFilaAsociada($result)) {
                        $_data[$_count] = $_fila;
                        $_count++;
                    }
                    //$result->free();
                    $result->close();
                }                
            } 
            while ($this->_cn->more_results() && $this->_cn->next_result());
        }
        else 
        {
            printf("First Error: %s", $this->_cn->error);
        }
        $this->_total = $_count;
        return $_data;
    }
    /**
     * Metodo que permite listar las opciones de la aplicacion
     * @param type $_nombre
     * @param type $_codigo
     * @param type $_inicio
     * @param type $_fin
     * @return type
     */
    function fcListarOpciones($_nombre, $_codigo, $_inicio=0,$_fin=10)
    {
        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("CALL sp_mov_listarOpciones(%d,'%s',%d,%d)", $_codigo ,$_nombre , $_inicio,$_fin);
        
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn))
        {
            do{
                if ($result = $this->_cn->store_result()) {
                    while ($_fila = $this->_objBD->fcExtraeFilaAsociada($result)) {
                        $_data[$_count] = $_fila;
                        $_count++;
                    }
                    //$result->free();
                    $result->close();
                }                
            } 
            while ($this->_cn->more_results() && $this->_cn->next_result());
        }
        else 
        {
            printf("First Error: %s", $this->_cn->error);
        }
        $this->_total = $_count;
        return $_data;
    }
    
    function fcVerResumen($_idDocumento , $_idUsuario)
    {
        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("CALL sp_mov_resumen(%d,%d)",  $_idUsuario , $_idDocumento );
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn))
        {
            do{
                if ($result = $this->_cn->store_result()) {
                    while ($_fila = $this->_objBD->fcExtraeFilaAsociada($result)) {
                        $_data[$_count] = $_fila;
                        $_count++;
                    }
                    $result->close();
                }                
            } 
            while ($this->_cn->more_results() && $this->_cn->next_result());
        }
        else 
        {
            printf("First Error: %s", $this->_cn->error);
        }
        $this->_total = $_count;
        return $_data;
    }
         
    
    /**
     * Metodo para consultar los tipos de documentos
     * @param type $_nombre
     * @param type $_codigo
     * @param type $_inicio
     * @param type $_fin
     */
    function fcListarDocumento($_nombre, $_codigo, $_inicio=0,$_fin=10)
    {
        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("CALL sp_mov_listarDocumento('%s',%d,%d,%d)", $_nombre, $_codigo, $_inicio,$_fin);
        
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn))
        {
            do{
                if ($result = $this->_cn->store_result()) {
                    while ($_fila = $this->_objBD->fcExtraeFilaAsociada($result)) {
                        $_data[$_count] = $_fila;
                        $_count++;
                    }
                    //$result->free();
                    $result->close();
                }                
            } 
            while ($this->_cn->more_results() && $this->_cn->next_result());
        }
        else 
        {
            printf("First Error: %s", $this->_cn->error);
        }
        $this->_total = $_count;
        return $_data;
    }
    
    /**
     * Tipo de respuesta por id de tipo o cuenta de usuario
     * @param type $_usuario
     * @param type $_tipo
     * @param type $_tipoRpta 0=html opciones 1=array de datos
     */
    function fcCargarTipo($_usuario , $_tipo=0 , $_tipoRpta =0)
    {
        $_data      = array();
        $_html      = "";
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("CALL sp_mov_listarTipoDoc(%d,%d)", $_usuario , $_tipo);
        
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn))
        {
            do{
                if ($result = $this->_cn->store_result()) {
                    while ($_fila = $this->_objBD->fcExtraeFilaAsociada($result)) {
                        if ($_tipoRpta==1)
                        {
                            $_data[$_count] = $_fila;
                        }
                        else
                        {
                            $_html = $_html."<option value='".$_fila['codigo']."'>".$_fila['nombre']."</option>";
                        }
                        $_count++;
                    }
                    //$result->free();
                    $result->close();
                }                
            } 
            while ($this->_cn->more_results() && $this->_cn->next_result());
        }
        else 
        {
            printf("First Error: %s", $this->_cn->error);
        }
        $this->_total = $_count;
        if ($_tipoRpta==1)
        {
            return $_data;
        }
        else
        {
            return $_html;
        }
        
    }
    
    /**
     * Listar documentos asignados
     * @param type $_key1
     * @param type $_key2
     * @param type $_estado
     * @return type
     */
    function fcListarDocumentoAsignado($_key1, $_key2, $_estado=1,  $_inicio = 0, $_fin =10, $_ncolumna = 0 , $_ndocumento="", $_tipodoc=0)
    {
    

        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("CALL sp_mov_listarDocumentosAsignado(%d,%d,%d,%d,%d,%d,'%s',%d)", $_key1, $_key2, $_estado, $_inicio , $_fin, $_ncolumna , $_ndocumento, $_tipodoc);
        
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn))
        {
            do{
                if ($result = $this->_cn->store_result()) {
                    while ($_fila = $this->_objBD->fcExtraeFilaAsociada($result)) {
                        $_data[$_count] = $_fila;
                        $_count++;
                    }
                    //$result->free();
                    $result->close();
                }                
            } 
            while ($this->_cn->more_results() && $this->_cn->next_result());
        }
        else 
        {
            printf("First Error: %s", $this->_cn->error);
        }
        $this->_total = $_count;
        return $_data;
    }
    
    /**
     * Metodo que permite listar las etiquetas a reemplazara
     * @param type $_idLeyenda
     */
    function fcListarLeyenda($_idLeyenda)
    {
        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("CALL sp_listarleyenda(%d)", $_idLeyenda);
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn))
        {
            do{
                if ($result = $this->_cn->store_result()) {
                    while ($_fila = $this->_objBD->fcExtraeFilaAsociada($result)) {
                        $_data[$_count] = $_fila;
                        $_count++;
                    }
                    $result->close();
                }                
            } 
            while ($this->_cn->more_results() && $this->_cn->next_result());
        }
        else 
        {
            printf("First Error: %s", $this->_cn->error);
        }
        $this->_total = $_count;
        return $_data;
    }
    

    /**
     * LIstar los correos segun opcion , incidencia y ruc
     * @param type $_codigo
     * @param type $_ruc
     * @param type $_opcion
     * @param type $_incidencia
     * @param type $_tipo
     * @return type
     */
    function fcListarIncidenciaMail(  $_codigo , $_ruc , $_opcion , $_incidencia , $_tipo )
    {
        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("CALL sp_mov_listarincidenciamail(%d,'%s',%d,'%s',%d)",  
                                        $_codigo , $_ruc , $_opcion , $_incidencia , $_tipo);
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn))
        {
            do{
                if ($result = $this->_cn->store_result()) {
                    while ($_fila = $this->_objBD->fcExtraeFilaAsociada($result)) {
                        $_data[$_count] = $_fila;
                        $_count++;
                    }
                    $result->close();
                }                
            } 
            while ($this->_cn->more_results() && $this->_cn->next_result());
        }
        else 
        {
            printf("First Error: %s", $this->_cn->error);
        }
        $this->_total = $_count;
        return $_data;
    }
    
    /**
     * 
     * @param type $_codigo
     * @param type $_nombre
     * @param type $_instruccion
     * @param type $_tipo
     * @param type $_columnas
     * @param type $_estado
     * @param type $_tipoo
     * @return type
     */
    function fcOrigenDatos(   $_codigo      , $_nombre , $_instruccion    , $_tipo   ,
                                $_columnas  , $_estado , $_tipoo      )
    {
        $sqlProc    = sprintf("CALL sp_mov_crudDocumentoAsignado(%d, '%s','%s', %d, '%s',%d, %d)", 
                                $_codigo      , $_nombre , $_instruccion    , $_tipo   ,
                                $_columnas  , $_estado , $_tipoo     );
        $refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
        $_count     = 1;
        $this->_total = $_count;
        return $refDatos;
        
    }

    
    /**
     * Permite registrar los coreos que se emitiran por ruc , opcion e incidencia
     * @param type $_codigo
     * @param type $_ruc
     * @param type $_incidencia
     * @param type $_nombre
     * @param type $_plantilla
     * @param type $_usuario
     * @param type $_correos
     * @param type $_opcion
     * @param type $_estado
     * @param type $_tipo
     * @return type
     */
    function fcIncidenciaMail(   $_codigo      , $_ruc , $_incidencia , $_nombre , $_plantilla    , $_usuario  ,
                                $_correos  , $_opcion , $_estado, $_tipo      )
    {
        $sqlProc    = sprintf("CALL sp_mov_crudDocumentoAsignado(%d, '%s','%s', '%s', %d,%d,'%s' ,%d,%d,%d)", 
                                $_codigo      , $_ruc , $_incidencia , $_nombre , $_plantilla    , $_usuario  ,
                                $_correos  , $_opcion , $_estado, $_tipo     );
        $refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
        $_count     = 1;
        $this->_total = $_count;
        return $refDatos;
        
    }

    /**
     * Listar Origen de datos
     * @param type $_codigo
     * @param type $_nombre
     * @param type $_tipo
     * @return type
     */    
    function fcListarOrigenDatos(  $_codigo , $_nombre ,  $_tipo )
    {
        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("CALL sp_mov_listarincidenciamail(%d,'%s',%d)",  
                                        $_codigo , $_nombre ,  $_tipo );
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn))
        {
            do{
                if ($result = $this->_cn->store_result()) {
                    while ($_fila = $this->_objBD->fcExtraeFilaAsociada($result)) {
                        $_data[$_count] = $_fila;
                        $_count++;
                    }
                    $result->close();
                }                
            } 
            while ($this->_cn->more_results() && $this->_cn->next_result());
        }
        else 
        {
            printf("First Error: %s", $this->_cn->error);
        }
        $this->_total = $_count;
        return $_data;
    }

    
    
    /**
     * Consulta eñ historial
     * @param type $_tipo
     * @param type $_nombre
     * @param type $_usuario
     * @param type $_codigo
     * @return type
     */
    function fcHistorial( $_tipo, $_nombre, $_usuario, $_codigo)
    {
        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("CALL sp_his_consultar(%d,'%s',%d,%d)", $_tipo ,$_nombre, $_usuario, $_codigo );
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn))
        {
            do{
                if ($result = $this->_cn->store_result()) {
                    while ($_fila = $this->_objBD->fcExtraeFilaAsociada($result)) {
                        $_data[$_count] = $_fila;
                        $_count++;
                    }
                    $result->close();
                }                
            } 
            while ($this->_cn->more_results() && $this->_cn->next_result());
        }
        else 
        {
            printf("First Error: %s", $this->_cn->error);
        }
        $this->_total = $_count;
        return $_data;
    }
    
    function fcListarUsuario($_nombre)
    {
        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("CALL sp_mov_listarUsuario('%s')", $_nombre);
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn))
        {
            do{
                if ($result = $this->_cn->store_result()) {
                    while ($_fila = $this->_objBD->fcExtraeFilaAsociada($result)) {
                        $_data[$_count] = $_fila;
                        $_count++;
                    }
                    $result->close();
                }                
            } 
            while ($this->_cn->more_results() && $this->_cn->next_result());
        }
        else 
        {
            printf("First Error: %s", $this->_cn->error);
        }
        $this->_total = $_count;
        return $_data;
    }
}
?>