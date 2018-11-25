<?php    
    $_ruta = "../";
    require_once $_ruta . "code/BL/bl.sesion.ctrl.php";
    require_once $_ruta . "include/config.php";
    $sIdDocumentoSeleccionado   = $_SESSION['ORDEN']['IDOCUMENTO'];//$_GET['idDocumentoAsignado'];
    $sIdDatoOpcion              = sprintf("%s",$_GET['idDatoOpcion']);
    //$sCodIncidencia = sprintf("%s",$_GET['codIncidencia']);
    //$sCtrIncidencia = sprintf("%s",$_GET['ctrIncidencia']);
    // cargamos datos de incidencia segun configuracion
    
    $tipo           = sprintf("%s",$_GET['tipo']);
    $sEnvCorreo     = $_GET['envCorreo'];
    $editar         = intval($_GET['editar']);    
    //$_SESSION[0]['INCIDENCIA']  = "";    
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Metas y Links -->
    <?php require  $_ruta . "include/links.php"; ?>    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper" >

        <!-- Navigation -->
        <?php require  $_ruta . "include/header.php"; ?>
        <div id="page-wrapper" class="capa">
            <div class="row">
                <div class="col-lg-12" id="sDatoDocumento">
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12" id="sContenidoForm">
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
        $(function(){
            var sSoportarGeo = ""
            var _latitude = "";
            var _longitude = "";
            fcObtenerDatoDocumento(<?php echo $sIdDocumentoSeleccionado; ?>);
            if (navigatorSupport){
                //llamando la funcion inicial para ver trabajar la API
                obtenerGeolocation();
            }else{
                sSoportarGeo ="NO SOPORTA GEOLOCALIZACION";
                fcContenidoForm(<?php echo $sIdDocumentoSeleccionado; ?>, <?php echo $sIdDatoOpcion; ?>, sSoportarGeo);
            }

        });

        function enviarFormulario()
        {
            $("#frmProceso").submit(function(){
                event.preventDefault();
                var formulario = $("#frmProceso").serializeArray();
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "../code/BL/bl.proceso.php" ,
                    data: formulario,
                    error   : function (xhr, ajaxOptions, thrownError){
                        alert(xhr.status);
                        alert(thrownError);
                        console.log(xhr);
                        console.log("Detalle: " + ajaxOptions + "\nError:" + thrownError);
                    },
                    success: function(data){
                        if(data=="resultadoOK") {
                            //alert("Proceso OK");
                            var url = "index.php"; 
                            $(location).attr('href',url);
                        }else{
                            alert("Proceso KO");
                        }
                    },
                });
            });            
        }

        function isEmpty( _elemento ){
            return !$.trim(_elemento.html())
        }

        function navigatorSupport(){
            if(navigator.geolocation){
                return true;
            }else{
                return false;
            }
        }

        function obtenerGeolocation(){
            //obtener la posición actual y llamar a la función  "localitation" cuando tiene éxito
            window.navigator.geolocation.getCurrentPosition(localitation, errorLocation, {
                maximumAge: 75000,
                timeout: 15000
            });
        }

        function localitation(geo){
            // En consola nos devuelve el Geoposition object con los datos nuestros
            _latitude = geo.coords.latitude;
            _longitude = geo.coords.longitude;
            sSoportarGeo ="SOPORTA GEOLOCALIZACION";
            fcContenidoForm(<?php echo $sIdDocumentoSeleccionado; ?>, <?php echo $sIdDatoOpcion; ?>, sSoportarGeo);
        }

        function errorLocation(error){
            switch (error.code)
            {
                case error.PERMISSION_DENIED:
                    sSoportarGeo = "No se ha permitido el acceso a la posición.";
                break;
                case error.POSITION_UNAVAILABLE:
                    sSoportarGeo = "No se ha podido acceder a la información geo.";
                break;
                case error.TIMEOUT:
                    sSoportarGeo = "El servicio ha tardado mucho tiempo en responder.";
                break;
                default:
                    sSoportarGeo = "Error desconocido.";
            }
            fcContenidoForm(<?php echo $sIdDocumentoSeleccionado; ?>, <?php echo $sIdDatoOpcion; ?>, sSoportarGeo);
        }

        function fcCancelar()
        {   
            window.location.href="index.php";
        }
        
        function fcContenidoForm( _idDocumentoSeleccionado, _idDatoOpcion, _soportarGeo)
        {
            var toAppend        = "";
            
            var _envCorreo      = <?php echo '"'.$sEnvCorreo.'"'; ?>;
            var _tipo           = <?php echo '"'.$tipo.'"'; ?>;

            $.getJSON('../code/BL/bl.controlDato.php?action=cargarLista&idDatoOpcion=' + _idDatoOpcion,{format: "json"}, function(datos) {
                toAppend += '<form role="form" id="frmProceso" name="frmProceso">';
                toAppend += '<input type="hidden" name="action" id="action" value="procesar">';
                toAppend += '<input type="hidden" name="idDocumentoSeleccionado" id="idDocumentoSeleccionado" value=\"' + _idDocumentoSeleccionado + '\">';
                toAppend += '<input type="hidden" name="idDatoOpcion" id="idDatoOpcion" value=\"' + _idDatoOpcion + '\">';
                
                toAppend += '<input type="hidden" name="envCorreo" id="envCorreo" value=\"' + _envCorreo + '\">';
                toAppend += '<input type="hidden" name="editar" id="editar" value="<?php echo intval($editar);?>">';
                <?php
                    if (intval($editar)>0)
                    {
                ?>
                    if (parseInt(datos.total)>0)
                    {
                        toAppend += '<input  type="text" class="form-control" name="txtEDITAR" id="txtEDITAR" value=\"'+datos.descripcion+'\" maxlength="250"/>';
                        toAppend += '<input type="hidden" name="codIncidencia" id="codIncidencia" value=\"' + datos.codincid+ '\">';
                        toAppend += '<input type="hidden" name="ctrIncidencia" id="ctrIncidencia" value=\"' + datos.ctrlincid + '\">';
                    }
                <?php
                    }
                ?>
                if (_soportarGeo!="NO SOPORTA GEOLOCALIZACION")
                {   if  (typeof(_latitude) != "undefined" && _latitude !== null) 
                    {
                        toAppend += '<input type="hidden" name="varLATITUD" id="varLATITUD" value=\"' + _latitude + '\">';
                    }
                    else
                    {
                        toAppend += '<input type="hidden" name="varLATITUD" id="varLATITUD" value="ERROR">';    
                    }
                    
                    if  (typeof(_longitude) != "undefined" && _longitude !== null) 
                    {
                        toAppend += '<input type="hidden" name="varLONGITUD" id="varLONGITUD" value=\"' + _longitude + '\">';
                    }
                    else
                    {
                        toAppend += '<input type="hidden" name="varLONGITUD" id="varLONGITUD" value="ERROR">';
                    }
                }
                else
                {
                    toAppend += '<input type="hidden" name="varLATITUD" id="varLATITUD" value=\"' + _soportarGeo + '\">';
                    toAppend += '<input type="hidden" name="varLONGITUD" id="varLONGITUD" value=\"' + _soportarGeo + '\">';
                }
                
                var data = datos.controles;
                $.each(data,function(i, item) 
                {
                    toAppend += '<div class="form-group">';
                    toAppend += '<label name=\"' + data[i].mov_vch_etiqueta_control + '\" id=\"' + data[i].mov_vch_etiqueta_control + '\" for=\"' + data[i].mov_vch_nombre_control + '\" >' + data[i].mov_vch_etiqueta_valor + '</label>';
                    if (data[i].mov_vch_tipo_control=="C"){
                        toAppend += '<input type="text" class="form-control" title=\"' + data[i].mov_vch_texto_validacion + '\" placeholder=\"' + data[i].mov_vch_texto_ayuda + '\" name=\"' + data[i].mov_vch_nombre_control + '\" id=\"' + data[i].mov_vch_nombre_control + '\" required  />';
                    }else if (data[i].mov_vch_tipo_control=="F"){
                        toAppend += '<input type="date" class="form-control" title=\"' + data[i].mov_vch_texto_validacion + '\" placeholder=\"' + data[i].mov_vch_texto_ayuda + '\" name=\"' + data[i].mov_vch_nombre_control + '\" id=\"' + data[i].mov_vch_nombre_control + '\" required  />';
                    }else if (data[i].mov_vch_tipo_control=="H"){
                        toAppend += '<input type="time" class="form-control" title=\"' + data[i].mov_vch_texto_validacion + '\" placeholder=\"' + data[i].mov_vch_texto_ayuda + '\" name=\"' + data[i].mov_vch_nombre_control + '\" id=\"' + data[i].mov_vch_nombre_control + '\" required  />';
                    }else if (data[i].mov_vch_tipo_control=="W"){
                        toAppend += '<input type="datetime-local" class="form-control" title=\"' + data[i].mov_vch_texto_validacion + '\" placeholder=\"' + data[i].mov_vch_texto_ayuda + '\" name=\"' + data[i].mov_vch_nombre_control + '\" id=\"' + data[i].mov_vch_nombre_control + '\" required  />';
                    }else if (data[i].mov_vch_tipo_control=="N"){
                        toAppend += '<input type="number" pattern="\d*" min="0" step="1" title=\"' + data[i].mov_vch_texto_validacion + '\" class="form-control" placeholder=\"' + data[i].mov_vch_texto_ayuda + '\" name=\"' + data[i].mov_vch_nombre_control + '\" id=\"' + data[i].mov_vch_nombre_control + '\" required  />';
                    }else if (data[i].mov_vch_tipo_control=="D"){
                        toAppend += '<input type="number" pattern="[0-9]+([\.|,][0-9]+)?" step="0.01" title=\"' + data[i].mov_vch_texto_validacion + '\" class="form-control" placeholder=\"' + data[i].mov_vch_texto_ayuda + '\" name=\"' + data[i].mov_vch_nombre_control + '\" id=\"' + data[i].mov_vch_nombre_control + '\" required  />';
                    }
                    else if (data[i].mov_vch_tipo_control=="L"){
                        toAppend += '<select title=\"' + data[i].mov_vch_texto_validacion + '\" class="form-control" placeholder=\"' + data[i].mov_vch_texto_ayuda + '\" name=\"' + data[i].mov_vch_nombre_control + '\" id=\"' + data[i].mov_vch_nombre_control + '\" required  >'+data[i].html+
                             '</select>';
                    }                    
                    else{
                        toAppend += '<input type="text" class="form-control" title=\"' + data[i].mov_vch_texto_validacion + '\" placeholder=\"' + data[i].mov_vch_texto_ayuda + '\" name=\"' + data[i].mov_vch_nombre_control + '\" id=\"' + data[i].mov_vch_nombre_control + '\" />';                        
                    }
                    toAppend += '</div>';
                });
                toAppend += '<br/><br/><br/><br/><div class="row"> <div class="col-sm-6"><input name="btnProcesar" id="btnProcesar" type="submit" class="btn  btn-primary btn-block" value="Aceptar" /></div>';
                toAppend += '<div class="col-sm-6"><input name="btnCancelar" id="btnCancelar" type="button" class="btn  btn-default btn-block" value="Cancelar" onclick=javascript:fcCancelar() /></div>';
                toAppend += '</div></form>';
                if (isEmpty($('#sContenidoForm'))) 
                {
                    $('#sContenidoForm').empty();
                    $('#sContenidoForm').html(toAppend);
                }
                enviarFormulario();
            });
        }

        function fcObtenerDatoDocumento( _idDocumentoSeleccionado)
        {
            var idUsuario = "<?php echo $_SESSION['idUsuario'] ?>";
            var toAppend = "";
            $.getJSON('../code/BL/bl.documentoAsignado.php?action=cargarUno&idDocumentoAsignado=' + _idDocumentoSeleccionado + '&idUsuario=' + idUsuario,{format: "json"}, function(data) {
                $.each(data,function(i, item) {
                    toAppend += '<h4>' + data[i].mov_vch_alias + ':&nbsp;' + data[i].mov_vch_serie + '-' + data[i].mov_vch_numero + '</h4>';
                    toAppend += '<ul class="nav nav-list-main">';
                    toAppend += '<li class="nav-divider"></li>';
                    toAppend += '</ul>';
                });
                if (isEmpty($('#sDatoDocumento'))) {
                    $('#sDatoDocumento').empty();
                    $('#sDatoDocumento').html(toAppend);
                }
            });              
        }
    </script>
</body>
</html>    