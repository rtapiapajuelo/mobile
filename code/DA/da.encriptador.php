<?php
/**
 * Clase que permite encriptar en mdo hash segun llave 
 */
    class ClsEncriptador
    {   private $_llave = "ingresocli";
        /**
         * Metodo que permite encriptar
         * @param type $_clave
         * @return type
         */
        function fcEncriptar($_clave)
        {
            return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($this->_llave), $_clave, MCRYPT_MODE_CBC, md5(md5($this->_llave))));
        }
    }
?>