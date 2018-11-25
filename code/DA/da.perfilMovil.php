<?php
    /********************************************************************************
     * Recibe datos de la logica de negocio de documentos asignados.
     *
     * @author RTP 
     * @version 1.0
     * @fecha 15/09/2015     
     ********************************************************************************/
class ClsPerfilMovil
{
	var $_mensaje="";
    var $_total=0;
    
    private $_cn	= null;
    private $_objBD = null;
    private $_ruta = "../";

	public function __construct()
	{
		require_once $this->_ruta.'BL/bl.inclusion.php';
        $this->_objBD   = $objBD;
        $this->_cn 	    = $conn;
	}
    
    /**
     * Metodo que permite listar las etiquetas que se utilizaran el los mensajes de correo
     * @param type $_key1
     * @param type $_key2
     * @param type $_inicio
     * @param type $_fin
     * @return type
     */
    function fcListarEtiqueta($_key1, $_key2, $_inicio =0 , $_fin = 10)
    {
        $sqlProc    = sprintf("CALL sp_mov_listaretiquetas(%d,'%s',%d,%d)", $_key1 , $_key2, $_inicio , $_fin);
        $refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
        $_data      = array();
        $_count     = 0;
            while ($_fila = $this->_objBD->fcExtraeFilaAsociada($refDatos)) {
                $_data[$_count] = $_fila;
                $_count++;
            }
        $this->_total = $_count;
        return $_data;
    }
    
    /**
     * Metodo que permite listar los perfiles
     * @param type $_key1
     * @param type $_key2
     * @param type $_inicio
     * @param type $_fin
     * @return type
     */
    function fcListarPerfiles($_key1, $_key2, $_inicio =0 , $_fin = 10)
    {
        $sqlProc    = sprintf("CALL sp_mov_listarPefil(%d,'%s',%d,%d)", $_key1 , $_key2, $_inicio , $_fin);
        $refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
        $_data      = array();
        $_count     = 0;
            while ($_fila = $this->_objBD->fcExtraeFilaAsociada($refDatos)) {
                $_data[$_count] = $_fila;
                $_count++;
            }
        $this->_total = $_count;
        return $_data;
        
    }
    
    /**
     * Metodo que permite listar las cabeceras de las opciones
     * @param type $_key1
     * @param type $_key2
     * @return type
     */
    function fcListarOpcionCabecera($_key1, $_key2)
    {
        $sqlProc    = sprintf("CALL sp_mov_consultarOpcionCabera('%d','%d')", $_key1 , $_key2);
        $refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
        $_data      = array();
        $_count     = 0;
            while ($_fila = $this->_objBD->fcExtraeFilaAsociada($refDatos)) {
                $_data[$_count] = $_fila;
                $_count++;
            }
        $this->_total = $_count;
        return $_data;
    }
        
        /**
         * Metodo que permite listar la opciones finales 
         * @param type $_key1
         * @param type $_key2
         * @param type $_usuario
         * @return type
         */
	function fcListarOpcionDato($_key1, $_key2, $_usuario, $_referenciaDocumento = "")
	{
            $sqlProc    = sprintf("CALL sp_mov_consultarOpcionDato(%d,%d,%d,'%s')", $_key1 , 
                                            $_key2      , $_usuario , $_referenciaDocumento);
            $refDatos   = $this->_objBD->fcEjecutarSP($sqlProc, $this->_cn, MYSQLI_STORE_RESULT);
            $_data      = array();
            $_count     = 0;

            while ($_fila = $this->_objBD->fcExtraeFilaAsociada($refDatos)) {
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

            $this->_total = $_count;
            return $_data;
	}	

}    
?>