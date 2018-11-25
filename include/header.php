<nav class="navbar navbar-inverse  navbar-fixed-top" style="    background: #ffffff">    
    <div class="container">
        
        <div class="navbar-header" style="background: #ffffff;color:#cc0000">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" style=" background: #335285; margin-left: 15px;;float: left;">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#" style="color: #335285;font-weight: bold;"><?php echo _MODULO_;?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-right top-nav">
                <li class="active"><a href="index.php">Inicio</a></li>
                <li><a href="#contact">Contactenos</a></li>
                <?php
                    if (isset($_SESSION['idUsuario']))
                    {
                ?>
                <li><a href="logout.php">Cerrar sesi&oacute;n</a></li>
                <?php
                    }
                ?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>