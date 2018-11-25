<?php
    /********************************************************************************
     * Recibe datos de la logica de negocio de proceso y registra los datos ingresados.
     *
     * @author RTP 
     * @version 1.0
     * @fecha 15/09/2015     
     ********************************************************************************/
class ClsProceso
{
    var $_mensaje="";
    var $_total=0;
    
    private $_cn    = null;
    private $_objBD = null;
    private $_ruta = "../";
    public static $_instance = null; //The single instance

    public function __construct()
    {   
        if ($this->_objBD===null){
            require_once $this->_ruta.'BL/bl.inclusion2.php';
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
     * Metodo que permite listar los correos a donde se enviaran loc correos de confirmacion
     * @param type $_incidencia
     * @param type $_nrodocumento
     * @param type $_tipo
     * @param type $_idcorreo
     * @return type
     */
    function fcListarCorreoEmail( $_incidencia , $_nrodocumento , $_tipo , $_idcorreo , $_idOpcion)
    {
        
        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("CALL sp_mov_correonotificacion('%s','%s', %d, %d, %d)", $_incidencia   , $_nrodocumento    , 
                                                                                 $_tipo         , $_idcorreo        , $_idOpcion);        
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn)){
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
        else {
            printf("First Error: %s", $this->_cn->error);
        }
        $this->_total = $_count;
        return $_data;
    }
    
    function fcListarProcesoDato($_key1, $_key2, $_key3, $_key4, $_key5)
    {
        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("CALL sp_mov_consultarProcesoDato(%d,'%s','%s','%s',%d)", $_key1, $_key2, $_key3, $_key4, $_key5);
        
         
        
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn)){
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
        else {
            printf("First Error: %s", $this->_cn->error);
        }
        //$refDatos->free();
        $this->_total = $_count;
        return $_data;
    }
    
        
    
    function fcProcesar($_key1, $_key2, $_key3, $_key4, $_key5, $_key6, $_key7)
    {
        $sqlProc = sprintf('CALL sp_mov_crudDinamico("%s","%s","%s","%s","%s","%s","%s")', $_key1, $_key2, $_key3, $_key4, $_key5, $_key6, $_key7);
        $refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
        $_count     = 1;
        $this->_total = $_count;
        return $refDatos;
    }
    
    
    function fcGrabarEtiqueta($_codigo , $_etiqueta ,$_descripcion , $_variable , $_tipovalor , $_fuente ,  $_tipoO=1)
    {
        $sqlProc = sprintf('CALL sp_mov_crudEtiqueta(%i,"%s","%s","%s",%i,"%s",%i)', $_codigo , $_etiqueta ,$_descripcion , $_variable , $_tipovalor , $_fuente ,  $_tipoO);
        $refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
        $_count     = 1;
        $this->_total = $_count;
        return $refDatos;
    }
    
    function fcGrabarOpicionaApp($_codigo , $_idopcion , $_descripcion ,$_alias     , $_tipo , $_codincidencia , 
                                $_ctrlincidencia , $_correo , $_editarIncidencia , $_repetitivo , $_tipoO )
    {
        $sqlProc = sprintf('CALL sp_mov_crudOpcionesApp(%i,%i,"%s","%s",%i,"%s","%s","%s",%i,%i,%i)', $_codigo , $_idopcion , $_descripcion ,$_alias     , $_tipo , $_codincidencia , 
                                $_ctrlincidencia , $_correo , $_editarIncidencia , $_repetitivo , $_tipoO );
        $refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
        $_count     = 1;
        $this->_total = $_count;
        return $refDatos;
    }
    
    function fcGrabarControles($_codigo , $_opciondato , $_etiqueta ,$_valor , $_tipo , $_nombreControl , $_textoayuda , $_textovalidacion ,
                               $_tipoO )
    {
        $sqlProc = sprintf('CALL sp_mov_crudControles(%i,%i,"%s","%s","%s","%s","%s","%s",%i)', $_codigo , $_opciondato , $_etiqueta ,$_valor , $_tipo , $_nombreControl , $_textoayuda , $_textovalidacion ,  $_tipoO);
        $refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
        $_count     = 1;
        $this->_total = $_count;
        return $refDatos;
    }
    
    function fcGrabarOpcion($_codigo , $_perfil ,$_nombre , $_alias , $_padre , $_ultimaopcion ,  $_tipoO=1)
    {
        $sqlProc = sprintf('CALL sp_mov_crudOpciones(%i,%i,"%s",%i,%i,"%s",%i)', $_codigo , $_perfil ,$_nombre , $_alias , $_padre , $_ultimaopcion ,  $_tipoO);
        $refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
        $_count     = 1;
        $this->_total = $_count;
        return $refDatos;
    }
    
    function fcGrabarProceso($_codigo , $_opcioni ,$_tipoi , $_base , $_tabla , $_columna , $_tipovalor , $_valora , $_valorcampo , $_tipoentrada , $_tipoO=1)
    {
        $sqlProc = sprintf('CALL sp_mov_crudProceso(%i,%i,"%s","%s","%s","%s","%s","%s","%s",%i,%i)', $_codigo , $_opcioni ,$_tipoi , $_base , $_tabla , $_columna , $_tipovalor , $_valora , $_valorcampo , $_tipoentrada , $_tipoO);
        $refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
        $_count     = 1;
        $this->_total = $_count;
        return $refDatos;
    }
    
    
    function fcObtenValorFuncion($_documento , $_function ,$_perfil, $_tipo=1)
    {
        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        
        if ($_tipo==1)
        {
            $sqlProc    = " select ".$_function."('".$_documento."',".$_perfil.") as resultado";                    
        }
        else
        {
            $sqlProc    = " select ".$_function." as resultado";                    
        }
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn)){
            do{
                if ($result = $this->_cn->store_result()) {
                    while ($_fila = $this->_objBD->fcExtraeFilaAsociada($result)) {
                        $_data = $_fila['resultado'];
                        $_count++;
                    }                    
                    $result->close();
                }                
            } 
            while ($this->_cn->more_results() && $this->_cn->next_result());
        }
        else {
            printf("First Error: %s", $this->_cn->error);
        }
        //$refDatos->free();
        $this->_total = $_count;
        return $_data;
    }
    
    /* ejecuta funcion del servidor*/
    function fcEjecutarFuncion($_documento , $_function ,$_perfil)
    {   
        $_sql =" select ".$_function."('".$_documento."',".$_perfil.") as resultado";        
        $refDatos   = $this->_objBD->fcEjecutaObtieneFila( $_sql, $this->_cn);
        return $refDatos['resultado'];
    }

    
    function fcEjecutarFuncionBD($_function)
    {
        $_sql =" select ".$_function."() as resultado";
        $refDatos   = $this->_objBD->fcEjecutaObtieneFila( $_sql, $this->_cn);
        return $refDatos['resultado'];
    }
    
    /**
     * Metodo que permite 
     * @param type $_tipo
     * @param type $_usuario
     * @param type $_instruccion
     * @param type $_referencia     
     * @param type $_idDatoOpcion
     * @param type $_referenciaDoc
     * @return type
     */
    function fcGrabarHistorico($_tipo, $_usuario, $_instruccion, $_referencia,  $_idDatoOpcion, $_referenciaDoc )
    {
        $sqlProc = sprintf('CALL dbmobil_hist.sp_his_historico(%d,%d,"%s","%s",%d,"%s")', $_tipo, $_usuario, $_instruccion, $_referencia, 
                                                 $_idDatoOpcion, $_referenciaDoc);
        $refDatos   = $this->_objBD->fcEjecutarCRUD($sqlProc, $this->_cn);
        $_count     = 1;
        $this->_total = $_count;
        return $refDatos;        
    }
    
    function fcUbicarEtiqueta($_etiqueta , $_arrayEtiquetas)
    {
        $_valor = "";
        for ($_i=0 ; $_i < sizeof($_arrayEtiquetas); $_i++)
        {
            if ($_etiqueta==$_arrayEtiquetas[$_i]['mov_vch_etiqueta'])
            {
                $_valor = $_arrayEtiquetas[$_i]['mov_vch_variable'];  
            }
        }
    }
}    
?>