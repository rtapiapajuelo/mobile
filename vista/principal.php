<?php       
    $_ruta = "../";
    require_once $_ruta . "code/BL/bl.sesion.ctrl.php";
    require_once $_ruta . "include/config.php";
    
    if (isset($_SESSION['ORDEN']))
    {
        unset($_SESSION['ORDEN']);
    } 
    
    if (isset($_POST['sDocumentoAsignado'])) {
        $sIdDocumentoSeleccionado        = $_POST['sDocumentoAsignado'];
        $_SESSION['ORDEN']['IDOCUMENTO'] = $sIdDocumentoSeleccionado; 
    }
    else
    {
        echo "<script type=\"text/javascript\">history.go(-1);</script>";
        exit();
    }
    
    
    //echo $sIdDocumentoSeleccionado;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Metas y Links -->
    <?php require  $_ruta . "include/links.php"; ?>   
    <?php require  $_ruta . "include/scripts.php"; ?>
    <script src="<?php echo $_ruta;?>js/bootbox.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php 
        
?>
    <div id="wrapper">

        <!-- Navigation -->
        <?php require  $_ruta . "include/header.php"; ?>
        <div id="page-wrapper" class="capa">
            <div class="row">
                <div class="col-lg-12" id="sDatoDocumento">
                </div>
                <div style="padding-left: 13px; padding-right: 13px" align="justify"><span class="resumen" >Seleccione una de las opciones de lista mostradas, para que luego grabe los datos correspondientes a
                      la orden y/o documento</span>
                    <a href="javascript:verResumen()">
                        <img src="<?php echo $_ruta."/images/_trace.png";?>" width="35" height="35" alt="Historial de registro" alt="Historial de registro"/>
                    </a>
                </div>
                
            </div>
            <!--<div align="right">
                    <button id="btng1" name="btng1" onclick="javacript:cerrarDOcumento()" class="btn btn-primary">Terminar Documento/Orden</button>
                </div>--> 
            <div class="row">
                <div class="col-lg-12">
					<ul class="nav nav-list-main" id="sMenu" style="z-index: -100">
                    </ul>
                </div>
            </div>
            <div align="right">
                    <button id="btng2" name="btng2" onclick="javacript:cerrarDOcumento()" class="btn btn-primary">Terminar Documento/Orden</button>
                </div> 
            <br/><br/><br/><br/><br/>
        </div>
        <!-- /#container -->    
    </div>
    <!-- /#wrapper -->

    <!-- Footer -->
    <?php require  $_ruta . "include/footer.php"; ?>

    <!-- Scripts -->
    

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
        
        
        var _idPerfil       = 0;
        $(function(){
            var _sContenedor    = "sMenu";
            var _idPadre        = 0;
            fcObtenerDatoDocumento('<?php echo $sIdDocumentoSeleccionado; ?>',_sContenedor, _idPadre);
            
        });
        
        function inicializarMenu(_idPerfil, _idPadre, _sContenedor)
        {
             fcOpcionCabecera(_idPerfil, _idPadre, _sContenedor);
             $('#sMenu').on('click','li.cabecera',function(event){
                event.preventDefault();
                var _idPadreH       = $(this).attr('data-idPadre');
                var _sUltimoH       = $(this).attr('data-ultimo');
                var _sContenedorH   = "sOpcion_" + _idPadreH;
                var _extendidoH     = $(this).attr('data-extendido');
                if (_extendidoH=="N")
                {  
                    if (_sUltimoH=="N"){                   
                        fcOpcionCabecera(_idPerfil, _idPadreH, _sContenedorH);                   
                    }else{
                        fcOpcionDato(_idPadreH, _sContenedorH);
                    }
                    $(this).attr('data-extendido','S');
                }
                else
                {
                    //$(this).parent().find('ul').slideToggle();
                }   
                
            });

            $('#sMenu').on('click','li.detalle',function(event){
                event.preventDefault();
                var _sEnlace = $(this).attr('data-enlace');
                document.location.href = _sEnlace;
            });
        }
        
        function isEmpty( _elemento ){
            return !$.trim(_elemento.html())
        }
        
        function cerrarDOcumento()
        {   if (confirm("Esta seguro de cerrar el documento/orden?"))
            {
                $.post("../code/BL/bl.documentoAsignado.php",{action:"cerrarDocumento"}, function(data)
                {
                    if (data=="ok")
                    {
                        window.location.href="index.php";
                    }
                });
            }
            
        }
        
        function refrescar( _idItem )
        {
            $('#sOpcion_' + _idItem + '').toggle();
            $('#sItemOpcion_' + _idItem + '').parent().parent().children('#sOpcion_' + _idItem + '').toggle(300);
            //var _idItemS = $('#sItemOpcion_' + _idItem + '').attr('data-item');
            var cs = $('#sItemOpcion_' + _idItem + '').attr("class");
            if(cs == 'nav-toggle-icon glyphicon glyphicon-chevron-right') {
                $('#sItemOpcion_' + _idItem + '').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down');
                
            $('#ipadre_' + _idItem+' span').on('click', function(e) 
            {                    
                   if ($('#sItemOpcion_' + _idItem + '').attr("class")=='nav-toggle-icon glyphicon glyphicon-chevron-down')
                   {
                       $('#sItemOpcion_' + _idItem + '').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
                       $('#sOpcion_' + _idItem).html("");
                       $('#ipadre_' + _idItem).attr('data-extendido','N');
                       $('#ipadre_' + _idItem).unbind('click');
                       e.stopPropagation();
                       //e.PreventDefault(); 
                   }
                });                
            }          
        }

        function fcOpcionCabecera(_idPerfil, _idPadre, _sContenedor)
        {
        	var toAppend = "";
            $.getJSON('../code/BL/bl.perfilMovil.php?action=cargarCabecera&idPerfil=' + _idPerfil + '&idPadre=' + _idPadre,{format: "json"}, function(data) {
                $.each(data,function(i, item) {
                    toAppend += '<li class="nav-divider"></li>';
                    toAppend += '<li class="busqueda cabecera" id="ipadre_' + data[i].mov_int_idopciones_app + '" data-idPadre=\"' + data[i].mov_int_idopciones_app + '\" data-extendido=\"N\" data-ultimo=\"' + data[i].mov_chr_ultimo + '\"><label id="lblItemOpcion_' + data[i].mov_int_idopciones_app + '\" class="nav-toggle nav-header"><span id="sItemOpcion_' + data[i].mov_int_idopciones_app + '\" data-item="' + data[i].mov_int_idopciones_app + '\" class="nav-toggle-icon glyphicon glyphicon-chevron-right"></span><span>&nbsp;' + data[i].mov_vch_opciones_app + '</span></label>';
                    //toAppend += '<nav class="nav-collapse" data-toggle="collapse" data-target=".nav-collapse">';
                    toAppend += '<ul class="nav nav-list nav-left-ml" id="sOpcion_' + data[i].mov_int_idopciones_app + '\">';
                    toAppend += '</ul>';
                    //toAppend += '</nav>';
                    toAppend += '</li>';
                });
                if (isEmpty($('#' + _sContenedor + ''))) 
                {
                    $('#' + _sContenedor + '').empty();
                    $('#' + _sContenedor + '').html(toAppend);
                    refrescar( _idPadre );
                }
                else
                {   
                    refrescar( _idPadre );
                }          
               
            });
        }
        
        function fcGrabarProceso(_datoOpcion , _tipo , _idDocumento  , _envcorreo)        
        {   
            if (confirm("Esta seguro de grabar ?"))
            {
                var _parametros =  { action : 'asignarDatosCmpl' , datoOpcion : _datoOpcion};
                var _url        = "../code/BL/bl.controlDato.php";
                $.post(_url,_parametros,function(data)
                {   
                    if (data=='OK')
                    {
                        var _parametrosG = { action       : 'procesar'      , idDocumentoSeleccionado :_idDocumento ,
                                             idDatoOpcion : _datoOpcion     , envCorreo : _envcorreo , editar : '0' ,
                                             btnProcesar  : 'Aceptar'       };
                        var _urlG = "../code/BL/bl.proceso.php";              

                        $.post(_urlG    , _parametrosG , function(datos)
                        {   var _rptaF=jQuery.parseJSON(datos);
                            if (_rptaF=='resultadoOK')
                            {   
                                window.location.href=window.location.href;
                            }
                        });

                    }
                }); 
            }
            
        }
        function fcOpcionDato(_idPadre, _sContenedor)
        {
        	var toAppend = "";
            var idDocumentoSeleccionado = "<?php echo $sIdDocumentoSeleccionado; ?>";
            $.getJSON('../code/BL/bl.perfilMovil.php?action=cargarDetalle&idPadre=' + _idPadre,{format: "json"}, function(data) {
                 
                $.each(data,function(i, item) {
                    if (parseInt(data[i].nreg)>0 && parseInt(data[i].repetitivo)==0)
                    {   // se muestra la opcion pero desabilidatada
                        toAppend += '<li class="busqueda2 detalle" data-extendido="S" >&nbsp;&nbsp;&nbsp;<i>' + data[i].mov_vch_dato_opciones_app + '</i>(Registrado)</li>';
                    }
                    else
                    {   if (data[i].mov_chr_tipo=="M" || data[i].editar=="1")
                        {
                            toAppend += '<li class="busqueda2 detalle" data-extendido="S" data-enlace="ingreso.php?tipo='+data[i].mov_chr_tipo+'&idDatoOpcion=' + data[i].mov_int_iddato_opciones_app +'&envCorreo=' + data[i].mov_chr_correo +'&editar='+data[i].editar+'"><a href="ingreso.php?tipo='+data[i].mov_chr_tipo+'&idDatoOpcion=' + data[i].mov_int_iddato_opciones_app +'&envCorreo=' + data[i].mov_chr_correo +'&editar='+data[i].editar+'">' + data[i].mov_vch_dato_opciones_app + '</a></li>';
                        }
                        else
                        {
                            toAppend += '<li class="busqueda2 detalle" data-extendido="S" data-enlace="javascript:fcGrabarProceso(\'' + data[i].mov_int_iddato_opciones_app +'\',\''+data[i].mov_chr_tipo+'\',\''+idDocumentoSeleccionado+'\',\'' + data[i].mov_chr_correo +'\')"><a href="javascript:fcGrabarProceso(\'' + data[i].mov_int_iddato_opciones_app +'\',\''+data[i].mov_chr_tipo+'\',\''+idDocumentoSeleccionado+'\',\'' + data[i].mov_chr_correo +'\')">' + data[i].mov_vch_dato_opciones_app + '</a></li>';
                        }   
                    }
                });
                //toAppend += '</ul>';
                if (isEmpty($('#' + _sContenedor + ''))) {
                    $('#' + _sContenedor + '').empty();
                    $('#' + _sContenedor + '').html(toAppend);
                    refrescar( _idPadre );
                }else{
                    refrescar( _idPadre );
                }
            });  
        }

        function fcObtenerDatoDocumento( _idDocumentoSeleccionado, _sContenedor, _idPadre)
        {
            var idUsuario = "<?php echo $_SESSION['idUsuario'] ?>";
            var toAppend = "";
            var idPerfilInt =0;
            $.getJSON('../code/BL/bl.documentoAsignado.php?action=cargarUno&idDocumentoAsignado=' + _idDocumentoSeleccionado,{format: "json"}, function(data) {
                $.each(data,function(i, item) {
                    toAppend += '<h4>' + data[i].mov_vch_alias + ':&nbsp;' + data[i].mov_vch_serie + '-' + data[i].mov_vch_numero + '</h4>';
                    idPerfilInt = data[i].mov_int_idperfil_app;
                });
                if (isEmpty($('#sDatoDocumento'))) {
                    $('#sDatoDocumento').empty();
                    $('#sDatoDocumento').html("<strong>"+toAppend+"</strong>");
                }
                inicializarMenu(idPerfilInt, _idPadre, _sContenedor);
                
            });              
        }
        
        function verResumen()
        {
            bootbox.alert("<div id='divResumen' align='justify'><center><img src='<?php echo $_ruta;?>/images/load_map.gif'><br/>Espere un momento...</center></div>");
          $.post("<?php echo $_ruta;?>code/BL/bl.documentoAsignado.php",
                {   action : "verHistorial" },
                function(data)
                {
                $("#divResumen").html(data);
                });
        }
	</script>
</body>

</html>