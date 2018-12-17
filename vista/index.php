<?php    
    $_ruta = "../";
    require_once $_ruta . "code/BL/bl.sesion.ctrl.php";
    require_once $_ruta . "include/config.php";
    unset($_SESSION[0]);
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

        <div id="page-wrapper" class="capa" >            
            <div class="row">
                <div class="col-lg-12">
                    <form class="form-horizontal" role="form" id="frmDocumento" name="frmDocumento" action="principal.php" method="post">
                     <div class="form-group">
                        <label for="txtDato00" class="col-lg-2 control-label">
                            Tipo Documento Asignado:</label>
                        <div class="col-lg-10" id="sCapaSelect">
                            
                            <select class="form-control" id="tDocumentoAsignado" name="tDocumentoAsignado" style="width:80%" required title="Seleccione">
                            </select>
                            <div align="justify">
                                <span class="resumen">Seleccione el tipo de documento.</span>
                            </div>
                               
                        </div>
                      </div> 
                     <div class="form-group"  id="capa">
                        <label for="txtDato01" class="col-lg-2 control-label">
                            <input type="hidden"  id="nselectpadre" name="nselectpadre" value="0"/>
                                   
                            Documento Asignado:</label>
                        <div class="col-lg-10" id="sCapaSelect">
                            
                            <select class="form-control" id="sDocumentoAsignado" name="sDocumentoAsignado" 
                                           style="width:80%" required title="Seleccione" onchange="javascript:verDetalle()">
                            </select>
                            <div align="justify" id="capaResumen"></div>
                            <div align="justify">
                                <span class="resumen">Seleccione la Orden, requerimiento o el Documento que tiene asignado dentro de la lista desplegable; 
                                luego registre los datos que se les solicite de acuerdo a las opciones mostradas.</span>
                            </div>
                               
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10" align="right">
                          <button type="submit" class="btn btn-primary">Siguiente>></button>
                        </div>
                      </div>
                    </form>                        
                </div>
            </div>
            <img src="<?php echo $_ruta;?>images/aduana.jpg" id="fondopanel"/>
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
            fcCargarTD();
            
        });
        
        function fcCargarTD()
        {   var _idUsuario = "<?php echo $_SESSION['idUsuario'] ?>";
            $.post('../code/BL/bl.documentoAsignado.php',{idU : _idUsuario, action : "cargarTipo"},function(data)
            {
                $("#tDocumentoAsignado").html(data);
                fcDocumentoAsignado(-1);
            });
        }
        
        function verDetalle()
        {
            $.post("../code/BL/bl.documentoAsignado.php",{action:'verDetalle', iDoc : $("sDocumentoAsignado").val()},
            function(data)
            {
                $("#capaResumen").html(data);
            });
        }
        
        function fcDocumentoAsignado(_carga)
        {
            var idUsuario = "<?php echo $_SESSION['idUsuario'] ?>";
            
            $.getJSON('../code/BL/bl.documentoAsignado.php?action=cargarLista&tipo='+$("#tDocumentoAsignado").val(),{format: "json" }, function(data) {
                var toAppend = "";
                
                var counter = 0;
                $.each(data,function(i, item) {
                    toAppend += '<option value = \"' + data[i].mov_int_iddocumento_asignado + '\">' + data[i].mov_vch_alias + ': ' + data[i].mov_vch_serie + '-' + data[i].mov_vch_numero + '</option>';
                    counter++;
                });
                if (counter>0)
                {   toAppend = '<option value = \"' + '\">' + ' --- Seleccione Orden / Documento--- ' + '</option>'+toAppend;
                    $("#sDocumentoAsignado").empty();
                    $("#sDocumentoAsignado").html(toAppend);
                }
                else
                {
                    $("#capa").html("<center><h1>No tiene asignado documento alguno</h1>Comuniquese con al Administrador del sistema</center>");
                }    
            });  
        }
        
        /*                
        function fcDocumentoAsignado()
        {
            var idUsuario = "<?php echo $_SESSION['idUsuario'] ?>";
            
            $.getJSON('../code/BL/bl.documentoAsignado.php?action=cargarLista',{format: "json"}, function(data) {
                var toAppend = "";
                
                var counter = 0;
                $.each(data,function(i, item) {
                    toAppend += '<option value = \"' + data[i].mov_int_iddocumento_asignado + '\">' + data[i].mov_vch_alias + ': ' + data[i].mov_vch_serie + '-' + data[i].mov_vch_numero + '</option>';
                    counter++;
                });
                if (counter>0)
                {   toAppend = '<option value = \"' + '\">' + ' --- Seleccione Orden / Documento--- ' + '</option>'+toAppend;
                    $("#sDocumentoAsignado").empty();
                    $("#sDocumentoAsignado").html(toAppend);
                }
                else
                {
                    $("#capa").html("<center><h1>No tiene asignado orden/documento</h1>Comuniquese con al Administrador del sistema</center>");
                }    
            });  
        }
        */
           
           
    </script>

</body>

</html>
