<?php
    $_ruta = "../../";
    $_lPanel = 1;
    
    require_once $_ruta . "code/BL/bl.sesion.ctrl.php";
    require_once $_ruta . "include/config.php";
?>
<html lang="es">
    <head>
    <!-- Metas y Links -->
    <?php require  $_ruta . "include/links.php"; ?> 
     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="<?php echo $_ruta; ?>js/html5shiv.js"></script>
        <script src="<?php echo $_ruta; ?>js/respond.min.js"></script>
    <![endif]-->
    <?php require  $_ruta."include/scripts.php"; ?>
    
    <style type="text/css">
	.navbar{
		margin-top: 10px;
	}
        body {
            margin-top: 0px;
        }
        .container 
        {
            width: 100%;
        }
        .navbar-inverse 
        {
            background-color: #000000;
            border-color: #080808;
        }

</style>
    </head>
    <body>
        <div id="page-wrapper" class="capa" syle="background-color:#ffffff">
            <div class="row">
                <div class="col-lg-12">                  
                        <div class="col-xs-6">
                          <form class="form-horizontal" role="form" id="frmBanner" name="frmBanner" action="_control/banner.ctrl.php" method="post"  enctype="multipart/form-data">
                          <div class="form-group">
                          <h1>CONFIGURACION DE CORREO</h1>
                          </div>
                          <div class="form-group">
                            <div class="col-lg-10" id="idBanner"></div>
                          </div>
                          <div class="form-group">                              
                              
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">RUC :</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" id="txtRuc" name="txtRuc" placeholder="Ingrese RUC " />
                            </div>
                          </div>
                              <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Incidencia :</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" id="txtIncidencia" name="txtIncidencia" placeholder="Ingrese codigo" style="width:30%"/>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Nombre de incidencia :</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" id="txtNIncidencia" name="txtNIncidencia" placeholder="Ingrese nombre" style="width:60%" />
                            </div>
                          </div>  
                           
                          <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Correo :</label>
                            <div class="col-lg-10">
                                <textarea name="txtACorreos" id="txtACorreos" rows="8" cols="30" 
                                          placeholder="correo@dominio.com, correo1@dominio.com, correo2@dominio.com"></textarea>
                            </div>
                          </div>
                               <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Plantilla :</label>
                            <div class="col-lg-10">
                                <select name="sPlantilla" id="sPlantilla">                                    
                                </select>                                
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                              <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                          </div>
                        </form>
                        </div>
                        <div class="col-xs-6" align="right">
                            <a href='#' onclick='javascript:fcNuevaCorreo()' title="Nuevo" alt="Nuevo"><img src='<?php echo $_ruta;?>images/nuevo.png' title="Nuevo" alt="Nuevo"/></a>
                    </div>
                        <div class="col-xs-6">
                        <table id="dtBanner" class="table table-striped table-condensed">
                            <thead>
                                    <tr>
                                    <th>N</th>
                                    <th>RUC</th>
                                    <th>INCIDENCIA</th>
                                    <th>NOMBRE</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
	
                </div>
            </div>
        </div>
        
    </body>
</html>

