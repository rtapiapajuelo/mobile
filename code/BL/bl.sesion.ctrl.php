<?php
/* 
 * Permite el control de sesion
 */
ini_set("session.cookie_lifetime","14400");
ini_set("session.gc_maxlifetime","14400");
session_start();
$_nivelCarpeta  = (isset($_lPanel)?"../":""); 
    $continuar = "ko";
    if (isset($_SESSION['usuario'])){
        $continuar = "ok";
    }
    if ($continuar=="ko"){
        header("Location: ".$_nivelCarpeta."login.php");
    }
?>
