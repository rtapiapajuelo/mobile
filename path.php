<?php
    echo base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5("ingresocli"), "admin", MCRYPT_MODE_CBC, md5(md5("ingresocli"))));
    phpinfo();
?>
