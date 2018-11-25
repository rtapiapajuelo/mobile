<?php   
    session_start();
    $continuar = "ko";
    if (isset($_SESSION['usuario'])){
        $continuar = "ok";
    }
    if ($continuar=="ko"){
        header("Location: login.php");
    }
    $_ruta = "../";
    require_once $_ruta . "include/config.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Metas y Links -->
    <?php require  $_ruta . "include/links.php"; ?>    
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
        <?php require  $_ruta . "include/header.php"; ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12" id="sDatoDocumento">
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12">
                    <div id="supportNav"></div>
                </div>
            </div>
        </div>
        <!-- /#container -->    
    </div>
    <!-- /#wrapper -->

    <!-- Footer -->
    <?php require  $_ruta . "include/footer.php"; ?>

    <!-- Scripts -->
    <?php require  $_ruta . "include/scripts.php"; ?>

    <script type="text/javascript">
        /*$('ul.nav-left-ml').toggle();
        $('label.nav-toggle span').click(function () {
          $(this).parent().parent().children('ul.nav-left-ml').toggle(300);
          var cs = $(this).attr("class");
          if(cs == 'nav-toggle-icon glyphicon glyphicon-chevron-right') {
            $(this).removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down');
          }
          if(cs == 'nav-toggle-icon glyphicon glyphicon-chevron-down') {
            $(this).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
          }
        });*/
    </script>

    <script type="text/javascript">
        $(function(){
            //detectar si el navegador soporta geolocation
            navigatorSupport();
            //llamando la funcion inicial para ver trabajar la API
            obtainGeolocation();            
        });

        function navigatorSupport(){
            if(navigator.geolocation){
                return true;
            }else{
                return false;
            }
        }

        function obtainGeolocation(){
            //obtener la posición actual y llamar a la función  "localitation" cuando tiene éxito
            window.navigator.geolocation.getCurrentPosition(localitation);
        }
        function localitation(geo){
            // En consola nos devuelve el Geoposition object con los datos nuestros
            var latitude = geo.coords.latitude;
            var longitude = geo.coords.longitude;
            document.body.innerHTML =" Latitud:" +latitude+" ------ Longitud:" +longitude+""
        }


    </script>
</body>

</html>