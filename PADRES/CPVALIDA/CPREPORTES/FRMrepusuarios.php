<?php
	include_once('html_fns_reportes.php');
	$nombre = $_SESSION["nombre"];
	$sucursal = $_SESSION["sucursal"];
	$nivel = $_SESSION["nivel"];
	$valida = $_SESSION["GRP_GPADMIN"];
	
if($nivel != "" && $nombre != "" && $sucursal != ""){	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
    <link rel="shortcut icon" href="../../images/icono.ico">
    <!-- CSS personalizado -->
    <link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../../assets.3.5.20/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.assets.3.5.20/js/1.4.2/respond.min.js"></script>
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
                <a class="navbar-brand" href="index.php">A<small>vant</small>&nbsp;  S<small>chools</small>&nbsp;  M<small>anagement</small>&nbsp;  S<small>ystem</small></a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
               <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Formulario Gestor de Usuarios</a></li>
                        <li class="divider"></li>
                        <li><a href="../../logout.php"><i class="glyphicon glyphicon-off fa-fw"></i> Salir</a>
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
                                <?php if($_SESSION["GUSU"] == 1){ ?>
				<li>
                                    <a href="../FRMusuarios.php">
					<i class="glyphicon glyphicon-user"></i> Gestor de Usuarios
				    </a>
                                </li>
                                <?php } ?>
				<?php if($_SESSION["ARUSU"] == 1){ ?>
				<li>
                                    <a href="javascript:void(0);" onclick = "Promt_Buscar_Usuarios(1);">
					<i class="glyphicon glyphicon-pawn"></i> Asignaci&oacute;n de Rol
				    </a>
                                </li>
                                <?php } ?>
				<?php if($_SESSION["ARUSU"] == 1){ ?>
				<li>
                                    <a href="javascript:void(0);" onclick = "Promt_Buscar_Usuarios(2);">
					<i class="glyphicon glyphicon-file"></i> Info. de Usuarios
				    </a>
                                </li>
                                <?php } ?>
				<?php if($_SESSION["ARUSU"] == 1){ ?>
				<li>
                                    <a href="javascript:void(0);" onclick = "Promt_Buscar_Usuarios(4);">
					<i class="glyphicon glyphicon-option-horizontal"></i> Ver Permisos de Usuario
				    </a>
                                </li>
                                <?php } ?>
				<?php if($_SESSION["ARUSU"] == 1){ ?>
				<li>
                                    <a href="javascript:void(0);" onclick = "Promt_Buscar_Usuarios(5);">
					<i class="glyphicon glyphicon-option-vertical"></i> Ver Hist. Permisos Usuario
				    </a>
                                </li>
				<?php } ?>
				<?php if($_SESSION["ARUSU"] == 1){ ?>
				<li>
                                    <a href="javascript:void(0);" onclick = "Promt_Buscar_Usuarios(3);">
					<i class="glyphicon glyphicon-asterisk"></i> Cambiar Sit. de Usuario
				    </a>
                                </li>
				<?php } ?>
				<?php if($_SESSION["ARUSU"] == 1){ ?>
				<li>
                                    <a href="FRMrepusuarios.php">
					<i class="glyphicon glyphicon-print"></i> Reporte de Usuarios
				    </a>
                                </li>
				<?php } ?>
				<li>
                                    <a href="../../menu.php">
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
	<form name = "f1" id = "f1" onsubmit = "Submit();return false;" action="REPusuarios.php" method="post" target = "_blank">
            <br>
            <div id = "cuerpo" class="panel panel-default">
		<div class="panel-heading"><label>REPORTES DE USUARIO</label></div>
                    <div class="panel-body">
			<div class="row">
			    <div class="col-xs-12 col-md-12 text-right"><label class = " text-info">* Campos de Busqueda</label></div>
			</div>
                        <div class="row">
                            <div class="col-md-2 text-right"><label>Empresa: </label>  <span class="text-info">*</span></div>
                            <div class="col-md-4"><?php echo Empresas_html(); ?><input type = "hidden" name = "cod" id = "cod" /></div>
                            <div class="col-md-2 text-right"><label>Nombre: </label>  <span class="text-info">*</span></div>
                            <div class="col-md-4 text-left"><input type = "text" class="form-control" name = "nom" id = "nom" onkeyup = "texto(this)" /></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right"><label>Usuario: </label>  <span class="text-info">*</span></div>
                            <div class="col-md-4"><input type = "text" class="form-control text-libre" name = "usu" id = "usu" onkeyup = "texto(this)" /></div>
                            <div class="col-md-2 text-right"><label>Situaci&oacute;n: </label>  <span class="text-info">*</span></div>
                            <div class="col-md-4">
				<select id = "sit" name = "sit" class = "form-control">
					<option value = "">Seleccione</option>
					<option value = "1">ACTIVO</option>
					<option value = "0">INACTIVO</option>
				</select>
			    </div>
                        </div>
			<br>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button type="button" class="btn btn-info" id = "busc" onclick = "Submit();"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                                <button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="glyphicon glyphicon-erase"></span> Limpiar</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
		    
            </div>
             <!-- /.panel-default -->
	     <br>
	</form>	
        </div>
        <!-- /#page-wrapper -->
        
        <!-- //////////////////////////////// -->
        <!-- .footer -->
        <footer class="footer-login">
		<div class="container">
		      <img src = "../../images/logo.png" style= "width:28px" >
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
		<h4 class="modal-title text-left" id="myModalLabel"><img src="../../images/logo.png" width = "60px;" /></h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<img src="../../images/img-loader.gif"/><br>
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
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/assets.3.5.20/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../bower_components/datatables/media/assets.3.5.20/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/assets.3.5.20/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.5.20/js/ejecutaModal.js"></script>
    <script type="text/javascript" src="../../assets.3.5.20/js/usuario.js"></script>
    <script type="text/javascript" src="../../assets.3.5.20/js/util.js"></script>
	
    <!-- Page-Level Los Olivos Scripts - Tables - Use for reference -->
    <script>
	$(document).ready(function() {
		$('#dataTables-example').DataTable({
			responsive: true
		});
	    });
    </script>	
    
</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../../logout.php' method='post'>";
	//echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>