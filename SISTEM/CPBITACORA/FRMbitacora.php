<?php
	include_once('html_fns_bitacora.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	
if($nivel != "" && $nombre != "" && $empCodigo != ""){ 	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
    <!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Personal CSS -->
    <link href="../assets.3.6.2/css/dhtmlgoodies_calendar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php echo $_SESSION["rotulos_colegio"]; ?>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
               <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Perfil de Usuario</a></li>
                        <li class="divider"></li>
                        <li><a href="../logout.php"><i class="glyphicon glyphicon-off fa-fw"></i> Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-question-sign fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="glyphicon glyphicon-question-sign fa-fw"></i> Ayuda</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                       <li>
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
					<a href="FRMbitacora.php">
						<i class="glyphicon glyphicon-file"></i> Bit&aacute;cora del Sitema
					</a>
                                </li>
				<li>
					<a href="../menu.php">
						<i class="glyphicon glyphicon-list"></i> Men&uacute; Principal
					</a>
				</li>
                            </ul>
			    <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
	<form name = "f1" id = "f1" action="REPbitacora.php" method="post" target = "_blank">
            <br>
            <div class="panel panel-default">
		<div class="panel-heading"><label>Bit&aacute;cora del Sitema</label></div>
                    <div class="panel-body">
			<div class="row">
			    <div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
			</div>
                        <div class="row">
                            <div class="col-xs-2"><label>Empresa: </label> <span class="text-danger">*</span></div>
                            <div class="col-xs-4"><?php echo Empresas_html(); ?></div>
                            <div class="col-xs-2"><label>Usuario: </label> <span class="text-danger">*</span></div>
                            <div class="col-xs-4"><input type = "text" class="form-control" name = "usu" id = "usu" onkeyup = "texto(this)" /></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2"><label>M&oacute;dulo: </label> <span class="text-danger">*</span></div>
                            <div class="col-xs-4">
				<select id = "mod" name = "mod" class = "form-control">
					<option value = "">Seleccione</option>
					<option value = "ING">INGRESOS</option>
					<option value = "USU">USUARIOS</option>
					<option value = "REG">GESTORES</option>
					<option value = "REG">INFORMACI&Oacute;N</option>
				</select>
			    </div>
                            <div class="col-xs-2"><label>Acci&oacute;n: </label> <span class="text-danger">*</span></div>
                            <div class="col-xs-4">
				<select id = "acc" name = "acc" class = "form-control">
					<option value = "">Seleccione</option>
					<option value = "E">INGRESOS AL SISTEMA</option>
					<option value = "I">GRABAR O AGREGAR</option>
					<option value = "U">MODIFICAR O ACTUALIZAR</option>
				</select>
			    </div>
                        </div>
			<div class="row">
                            <div class="col-xs-2"><label>Desde: </label> <span class="text-danger">*</span></div>
                            <div class="col-xs-4">
				<div class='input-group date'>
					<input type="date" class="form-control" id="fini" name="fini" onclick="displayCalendar(this,'dd/mm/yyyy', this)" title="Click para seleccionar la fecha" style="cursor:pointer" readonly >
					<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('fini'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
				</div>
			    </div>
                            <div class="col-xs-2"><label>Hasta: </label> <span class="text-danger">*</span></div>
                            <div class="col-xs-4">
				<div class='input-group date'>
					<input type="date" class="form-control" id="ffin" name="ffin" onclick="displayCalendar(this,'dd/mm/yyyy', this)" title="Click para seleccionar la fecha" style="cursor:pointer" readonly >
					<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('ffin'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
				</div>
			    </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="button" class="btn btn-default" onclick = "Limpiar()"><span class="fa fa-eraser"></span> Limpiar</button>
                                <button type="button" class="btn btn-primary" onclick = "Buscar();"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
            </div>
             <!-- /.panel-default -->
	</form>	
        </div>
        <!-- /#page-wrapper -->
        
        <!-- //////////////////////////////// -->
        <!-- .footer -->
        <footer class="footer-login">
		<div class="container">
		      <img src = "../../CONFIG/images/logo.png" style= "width:28px" >
		      <p>
			    Powered by ID Web Development Team.
                            Copyright &copy; <?php echo date("Y"); ?>.
		      </p>
		      
		</div>
	</footer>
        <!-- /.footer -->

    </div>
    <!-- /#wrapper -->
    
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?></h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<img src = "../../CONFIG/images/img-loader.gif" width="100px" /><br>
		<label align ="center">Transaccion en Proceso...</label>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
		</div>
	      </div>
	      <div class="modal-body" id= "Pcontainer">
		
	      </div>
	    </div>
	  </div>
	</div>
    <!-- Modal -->
    
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/seguridad/bitacora.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/dhtmlgoodies_calendar.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>

</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	//echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>