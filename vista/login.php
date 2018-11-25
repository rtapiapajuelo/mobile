<?php   
    $_ruta = "../";
    require_once $_ruta . "include/config.php"; 
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <!-- Metas y Links -->
    <?php require_once  $_ruta . "include/links.php"; ?>    
  
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="../js/html5shiv.js"></script>
        <script src="../js/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">        
        <!-- Navigation -->
        <?php require_once  $_ruta . "include/header.php"; ?>

        <div id="page-wrapper" class="capa" syle="background-color:#ffffff">
            
            <div class="row">
                <div class="col-lg-12">            
                    <div align="center">
                    <?php
                            $_paginaCargada=$_SERVER['PHP_SELF'];
                            $_paginaCargada= str_replace("/mobile/vista/","",$_paginaCargada);
                            $_paginaCargada= str_replace("/lynxwm/vista/","",$_paginaCargada);
                            
                            if ($_paginaCargada=="login.php")
                            {
                                echo "<img src='".$_ruta."images/logo/logo.png' id='logo'/><br/>";
                                
                            }                            
                    ?>
                    </div>
                    <form role="form" id="frmLogin" name="frmLogin">
                        <input type="hidden" name="action" id="action" value="validar">
                        
                        <div class="form-group">
                            <label for="inputUsuario">Usuario</label>
                            <input type="text" title="Debe ingresar el nombre del usuario." id="txtUsuario" name="txtUsuario" class="form-control" placeholder="Nombre de usuario" required="" autofocus="" />
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Contrase&ntilde;a</label>
                            <input type="password" title="Debe ingresar la contrase&ntilde;a del usuario." id="txtClave" name="txtClave" class="form-control" placeholder="Contrase&ntilde;a" required="" />
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="remember-me" /> Acu&eacute;rdate de m&iacute;
                            </label>
                        </div>
                        <input name="btnAcceder" id="btnAcceder" type="submit" class="btn btn-lg btn-primary btn-block" value="Acceder" />
                        <div id="mensaje"></div>
                    </form>                    
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->    
    </div>
    <!-- /#wrapper -->

    <!-- Footer -->
    <?php require_once  $_ruta . "include/footer.php"; ?>

    <!-- Scripts -->
    <?php require_once  $_ruta . "include/scripts.php"; ?>

    <script type="text/javascript">
        $(function(){
            $("#frmLogin").submit(function(){
                event.preventDefault();
                var formulario = $("#frmLogin").serializeArray();
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "../code/BL/bl.login.php",
                    data: formulario,
                    error   : function (xhr, ajaxOptions, thrownError){
                        alert(xhr.status);
                        alert(thrownError);
                    },
                    success: function(data){
                        if(data=="Ingreso") {
                            var url = "index.php"; 
                            $(location).attr('href',url);
                        }
                        else if(data=="IngresoA") {
                            var url = "admin/index.php"; 
                            $(location).attr('href',url);
                        }
                        else{
                            toAppend = "<font color='red'>Los datos ingresados son incorrectos, intente nuevamente.</font>"
                            $("#mensaje").html(toAppend);
                        }
                    },
                });
            });
        });
    </script>

</body>

</html>
