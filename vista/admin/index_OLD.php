<?php
    $_ruta = "../../";
    $_lPanel = 1;
    
    require_once $_ruta . "code/BL/bl.sesion.ctrl.php";
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
        <script src="<?php echo $_ruta; ?>js/html5shiv.js"></script>
        <script src="<?php echo $_ruta; ?>js/respond.min.js"></script>
    <![endif]-->
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
    <div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                
                <a class="navbar-brand" href="panel.php"><?php echo "EMPRESA";/*_EMPRESA_;*/?> v2.0</a>
            </div>
            <!-- /.navbar-header -->

            
            
            <!-- /.navbar-static-side -->
        </nav>
        <nav role="navigation" class="navbar navbar-inverse">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand">Opciones >></a>
        </div>
        <!-- Collection of nav links, forms, and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#ETIQUETA">Etiquetas</a></li>
                
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Documentos/Ordenes <b class="caret"></b></a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="#DOCUMENTO">Documento</a></li>
                        <li class="divider"></li>
                        <li><a href="#PERFIL">Perfil</a></li>
                        <li class="divider"></li>
                        <li><a href="#DOCUMENTOA">Documentos Asignados</a></li>                  
                        
                    </ul>
                </li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <li><a href="javascript:cerrarSession">Cerrar Sesion</a></li>
            </ul>
        </div>
    </nav>
        <div id="page-wrapper" class="capa" syle="background-color:#ffffff">
            
            <div class="row">
                <div class="col-lg-12">            
                    
                   
                        <div class="col-xs-6">
                          <form class="form-horizontal" role="form" id="frmBanner" name="frmBanner" action="_control/banner.ctrl.php" method="post"  enctype="multipart/form-data">
                          <div class="form-group">
                          <a name="Ancla" id="ETIQUETA"></a><h1>ETIQUETAS</h1>
                          </div>
                          <div class="form-group">
                            <div class="col-lg-10" id="idBanner"></div>
                          </div>
                          <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Nombre</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Ingrese el Nombre " />
                            </div>
                          </div>
                              <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Descripcion</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Ingrese la descripcion" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Variable</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" id="txtVariable" name="txtVariable" placeholder="Ingrese la variable que provee valor" style="width:50%" />
                            </div>
                          </div>  
                          <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Tipo :</label>
                            <div class="col-lg-10">
                              <select class="form-control" id="stipo" name="stipo">
                                  <option value="1">Variable</option>
                                  <option value="1">Session</option>
                                  <option value="1">Extraido por una funcion</option>
                                </select> 
                            </div>      		
                          </div>  
                              <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Funcion</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" id="txtFuncion" name="txtFuncion" placeholder="Ingrese el nombre de la funcion" style="width:50%" />
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
                            <a href='#' onclick='javascript:fcNuevaEtiqueta()' title="Nuevo" alt="Nuevo"><img src='<?php echo $_ruta;?>images/nuevo.png' title="Nuevo" alt="Nuevo"/></a>
                    </div>
                        <div class="col-xs-6">
                        <table id="dtBanner" class="table table-striped table-condensed">
                            <thead>
                                    <tr>
                                    <th>N</th>
                                    <th>Nombre</th>
                                    <th>Variable</th>
                                    <th>Funcion</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
	
                </div>
            </div>
            <hr/>
            <hr/>
            <div class="row">
                <div class="col-lg-12">            
                    
                   
                        <div class="col-xs-6">
                          <form class="form-horizontal" role="form" id="frmBanner" name="frmBanner" action="_control/banner.ctrl.php" method="post"  enctype="multipart/form-data">
                          <div class="form-group">
                          <a name="Ancla" id="PERFIL"></a><h1>PERFIL</h1>
                          </div>
                          <div class="form-group">
                            <div class="col-lg-10" id="idBanner"></div>
                          </div>
                          <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Nombre</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" id="txtNombreP" name="txtNombreP" placeholder="Ingrese el Nombre " />
                            </div>
                          </div>
                             
                          
                          <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Documento :</label>
                            <div class="col-lg-10">
                              <select class="form-control" id="sDocumentoP" name="sDocumentoP">
                                  
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
                            <a href='#' onclick='javascript:fcNuevoPerfil()' title="Nuevo" alt="Nuevo"><img src='<?php echo $_ruta;?>images/nuevo.png' title="Nuevo" alt="Nuevo"/></a>
                    </div>
                        <div class="col-xs-6">
                        <table id="dtBanner" class="table table-striped table-condensed">
                            <thead>
                                    <tr>
                                    <th>N</th>
                                    <th>Nombre</th>
                                    <th>Documento</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
	
                </div>
            </div>
            <hr/>
            <hr/>
            <div class="row">
                <div class="col-lg-12">            
                    
                   
                        <div class="col-xs-6">
                          <form class="form-horizontal" role="form" id="frmBanner" name="frmBanner" action="_control/banner.ctrl.php" method="post"  enctype="multipart/form-data">
                          <div class="form-group">
                          <a name="Ancla" id="DOCUMENTO"></a><h1>DOCUMENTO</h1>
                          </div>
                          <div class="form-group">
                            <div class="col-lg-10" id="idBanner"></div>
                          </div>
                          <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Nombre</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" id="txtNombreD" name="txtNombreD" placeholder="Ingrese el Nombre " />
                            </div>
                          </div>
                             
                          
                          <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Abrev :</label>                            
                              <div class="col-lg-10">
                              <input type="text" class="form-control" id="txtAbrev" name="txtAbrev" placeholder="Ingrese la abreviatura" style="width:50%" />
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
                            <a href='#' onclick='javascript:fcNuevoDocumento()' title="Nuevo" alt="Nuevo"><img src='<?php echo $_ruta;?>images/nuevo.png' title="Nuevo" alt="Nuevo"/></a>
                    </div>
                        <div class="col-xs-6">
                        <table id="dtBanner" class="table table-striped table-condensed">
                            <thead>
                                    <tr>
                                    <th>N</th>
                                    <th>Nombre</th>
                                    <th>Abreviatura</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
	
                </div>
            </div>
            <hr/>
            <hr/>
            <div class="row">
                <div class="col-lg-12">            
                    
                   
                        <div class="col-xs-6">
                          <form class="form-horizontal" role="form" id="frmBanner" name="frmBanner" action="_control/banner.ctrl.php" method="post"  enctype="multipart/form-data">
                          <div class="form-group">
                          <a name="Ancla" id="DOCUMENTOA"></a><h1>DOCUMENTOS ASIGNADOS</h1>
                          </div>
                          <div class="form-group">
                            <div class="col-lg-10" id="idBanner"></div>
                          </div>
                          <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Documento</label>
                            <div class="col-lg-10">
                              <select class="form-control" id="sDocumentoD" name="sDocumentoD">
                                  
                                </select> 
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Perfil</label>
                            <div class="col-lg-10">
                              <select class="form-control" id="sPerfilD" name="sPerfilD">
                                  
                                </select> 
                            </div>
                          </div>   
                          
                          <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Numero:</label>                            
                              <div class="col-lg-10">
                              <input type="text" class="form-control" id="txtSerie" name="txtSerie" placeholder="Ingrese Serie" style="width:20%" />- <input type="text" class="form-control" id="txtNumero" name="txtNumero" placeholder="Ingrese Numero " style="width:60%"/>
                            </div>
                                  		
                          </div>  
                           <div class="form-group">
                            <label for="ejemplo_email_3" class="col-lg-2 control-label">Usuario</label>
                            <div class="col-lg-10">
                              <select class="form-control" id="sUsuario" name="sUsuario">
                                  
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
                            <a href='#' onclick='javascript:fcNuevoDocumento()' title="Nuevo" alt="Nuevo"><img src='<?php echo $_ruta;?>images/nuevo.png' title="Nuevo" alt="Nuevo"/></a>
                    </div>
                        <div class="col-xs-6">
                        <table id="dtBanner" class="table table-striped table-condensed">
                            <thead>
                                    <tr>
                                    <th>N</th>
                                    <th>Nombre</th>
                                    <th>Abreviatura</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
	
                </div>
            </div>
        </div>
        <nav role="navigation" class="navbar navbar-inverse">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand">Opciones >></a>
        </div>
        <!-- Collection of nav links, forms, and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#ETIQUETA">Etiquetas</a></li>
                
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Documentos/Ordenes <b class="caret"></b></a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="#DOCUMENTO">Documento</a></li>
                        <li class="divider"></li>
                        <li><a href="#PERFIL">Perfil</a></li>
                        <li class="divider"></li>
                        <li><a href="#DOCUMENTOA">Documentos Asignados</a></li>                  
                        
                    </ul>
                </li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <li><a href="javascript:cerrarSession">Cerrar Sesion</a></li>
            </ul>
        </div>
    </nav>
        <div align="center">Derechos Reservados </div>
        <!-- /#page-wrapper -->    
    </div>
    </div>
        <?php require  $_ruta . "include/scripts.php"; ?>
    </body>
</html>