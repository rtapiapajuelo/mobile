<?php
    /********************************************************************************
     * Recibe datos de la logica de negocio de control dato.
     *
     * @author RTP 
     * @version 1.0
     * @fecha 15/09/2015     
     ********************************************************************************/
class ClsControlDato
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
            require_once $this->_ruta.'BL/bl.inclusion3.php';
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

    function fcListarControlDato($_key1, $_key2)
    {
        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("CALL sp_mov_consultarControlDato('%d','%d')", $_key1 , $_key2);
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
    
    function fcListarConsulta($_sql)
    {
        $_data      = array();
        $_count     = 0;
        $_fila      = null;
        $sqlProc    = sprintf("%s",$_sql);
        echo    $sqlProc;    
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

    function fcListarOpcionDatosGen($_id )
    {
        $sqlProc    = sprintf("CALL sp_mov_consultarOpcionDato(%d,%d,%d,'%s')", 0 , $_id, 0,"");
        //$refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
        $_data      = array();        
        $_count     = 0;
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn)){
            do{
                if ($result = $this->_cn->store_result()) {
                    while ($_fila = $this->_objBD->fcExtraeFilaAsociada($result)) {
                        $_data[$_count]['mov_int_iddato_opciones_app']  = $_fila['mov_int_iddato_opciones_app'];
                        $_data[$_count]['mov_int_idopciones_app']       = $_fila['mov_int_idopciones_app'];
                        $_data[$_count]['mov_vch_dato_opciones_app']    = utf8_encode($_fila['mov_vch_dato_opciones_app']);
                        $_data[$_count]['mov_vch_alias_dato']           = utf8_encode($_fila['mov_vch_alias_dato']);
                        $_data[$_count]['mov_chr_tipo']                 = ($_fila['mov_chr_tipo']);
                        $_data[$_count]['mov_vch_codincidencia']        = ($_fila['mov_vch_codincidencia']);
                        $_data[$_count]['mov_vch_ctrincidencia']        = ($_fila['mov_vch_ctrincidencia']);
                        $_data[$_count]['mov_chr_correo']               = ($_fila['mov_chr_correo']);
                        $_data[$_count]['nreg']                         = ($_fila['nreg']);
                        $_data[$_count]['editar']                       = ($_fila['editar']);
                        $_data[$_count]['repetitivo']                   = ($_fila['repetitivo']);
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
        
        
        //$refDatos->close();
        $this->_total = $_count;
        return $_data;
    }
    
    
    function fcConsultaQuery($_sql)
    {
        $sqlProc    = sprintf("%s",$_sql);
        $refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
        $_data      = array();
        
        $_count     = 0;       
        
        while ($_fila = $this->_objBD->fcExtraeFilaAsociada($refDatos)) 
        {
            $_data[$_count] = $_fila;
            $_count++;
        }
        $refDatos->close();
        $this->_total = $_count;
        return $_data;
    }
    /**
     * BUscar la opcion con sus datos generales
     * @param type $_id
     * @return type
     */
    function fcListarOpcionDato($_id )
    {
        $sqlProc    = sprintf("CALL sp_mov_consultarOpcionDato(%d,%d,%d,'%s')", 0 , $_id, 0,"");        
        $_data      = array();        
        $_count     = 0;  
        if ($this->_objBD->fcEjecutarSP2($sqlProc, $this->_cn)){
            do{
                if ($result = $this->_cn->store_result()) {
                    while ($_fila = $this->_objBD->fcExtraeFilaAsociada($result)) {
                        $_data[$_count]['mov_int_iddato_opciones_app']  = $_fila['mov_int_iddato_opciones_app'];
                        $_data[$_count]['mov_int_idopciones_app']       = $_fila['mov_int_idopciones_app'];
                        $_data[$_count]['mov_vch_dato_opciones_app']    = utf8_encode($_fila['mov_vch_dato_opciones_app']);
                        $_data[$_count]['mov_vch_alias_dato']           = utf8_encode($_fila['mov_vch_alias_dato']);
                        $_data[$_count]['mov_chr_tipo']                 = ($_fila['mov_chr_tipo']);
                        $_data[$_count]['mov_vch_codincidencia']        = ($_fila['mov_vch_codincidencia']);
                        $_data[$_count]['mov_vch_ctrincidencia']        = ($_fila['mov_vch_ctrincidencia']);
                        $_data[$_count]['mov_chr_correo']               = ($_fila['mov_chr_correo']);
                        $_data[$_count]['nreg']                         = ($_fila['nreg']);
                        $_data[$_count]['editar']                       = ($_fila['editar']);
                        $_data[$_count]['repetitivo']                   = ($_fila['repetitivo']);
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
        
}    
?>