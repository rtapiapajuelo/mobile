<?php
    /********************************************************************************
     * Recibe datos de la logica de negocio del login y genera la session.
     *
     * @author SISTEMAS CLI
     * @version 1.0
     * @fecha 15/09/2015     
     ********************************************************************************/
class ClsLogin
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
     * Metodo que permite validar las credenciales de un usuario
     * @param type $_key1 usuario
     * @param type $_key2 clave
     * @return type
     */
    function fcValidarLogin($_key1, $_key2)
    {
        $sqlProc    = sprintf("CALL sp_mov_consultarUsuario('%s','%s')", $_key1, $_key2);
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
}    
?>