<?php
	include_once('xajax_funct_helpdesk.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	///--- $_POST ---///
	$ClsInc = new ClsIncidente();
	$hashkey = $_REQUEST["hashkey"];
	$codigo = $ClsInc->decrypt($hashkey, $usuario);
	$result = $ClsInc->get_incidente($codigo);
	if(is_array($result)){
		foreach($result as $row){
			//desc
			$modulo = trim($row["inc_modulo"]);
			//desc
			$plataforma = trim($row["inc_plataforma"]);
			//tipo
			$tipo = trim($row["inc_tipo_problema"]);
			//desc
			$persona = utf8_decode($row["inc_persona"]);
			//desc
			$desc = utf8_decode($row["inc_descripcion"]);
			//prioridad
			$prioridad = trim($row["inc_prioridad"]);
		}	
	}	
	
	
if($pensum != "" && $nombre != ""){ 	
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
		<?php
		   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		   $xajax->printJavascript("..");
		 ?>	
    <!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

   <!-- DataTables CSS -->
   <link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

   <!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
						<li class="active">
						  <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
						  <ul class="nav nav-second-level">
							  <?php if($_SESSION["NEWCHEQUE"] == 1){ ?>
							  <li>
								  <a class="active" href="FRMtablero.php">
									  <i class="fa fa-tasks"></i> Tablero de Incidentes
								  </a>
							  </li>
							  <?php } ?>
							  <?php if($_SESSION["CUECONCIL"] == 1){ ?>
							  <li>
								  <a href="FRMnuevo.php">
									  <i class="fa fa-plus-circle"></i> Nuevo Incidente
								  </a>
							  </li>
							  <?php } ?>
							  <hr>
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
		<br>
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-pencil"></i> Actualizaci&oacute;n de Incidente</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-5 col-lg-offset-1 col-xs-12">
						<button type="button" class="btn btn-default" onclick = "window.history.back();"><span class="fa fa-chevron-left"></span> Atras</button>
					</div>
					<div class="col-lg-5 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<label>M&oacute;dulo: </label> <span class = "text-danger">*</span>
						<?php echo hd_modulo_html("modulo"); ?>
						<input type = "hidden" name = "cod" id = "cod" value="<?php echo $codigo; ?>" />
						<script>
							document.getElementById("modulo").value = '<?php echo $modulo; ?>';
						</script>
					</div>
					<div class="col-xs-5">
						<label>Plataforma: </label> <span class = "text-danger">*</span>
						<?php echo hd_plataforma_html("plataforma"); ?>
						<script>
							document.getElementById("plataforma").value = '<?php echo $plataforma; ?>';
						</script>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<label>T&iacute;po de Incidente: </label> <span class = "text-danger">*</span>
						<?php echo hd_tipo_incidente_html("tipo"); ?>
						<script>
							document.getElementById("tipo").value = '<?php echo $tipo; ?>';
						</script>
					</div>
					<div class="col-xs-5">
						<label>Prioridad: </label> <span class = " text-danger">*</span>
						<select id = "prioridad" name = "prioridad" class = "form-control">
							<option value = "N">Normal</option>
							<option value = "B">Baja</option>
							<option value = "A">Alta</option>
							<option value = "U">Muy Alta (Urgente)</option>
						</select>
						<script>
							document.getElementById("prioridad").value = '<?php echo $prioridad; ?>';
						</script>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1">
						<label>Persona que Reporta (Usuario Padre): </label> <span class = "text-muted">(No es obligatorio)</span>
						<input type = "text" class = "form-control" name = "persona" id = "persona" onkeyup = "texto(this);" value="<?php echo $persona; ?>" />	
					</div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1">
						<label>Descripci&oacute;n del Problema:  </label> <span class = " text-danger">*</span>
						<textarea class = "form-control" name = "desc" id = "desc" rows="5" onkeyup = "textoLargo(this);" ><?php echo $desc; ?></textarea>
					</div>	
				</div>
				<br>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
						<button type="button" class="btn btn-primary" id = "gra" onclick = "Modificar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
					</div>
			   </div>
				<br>
			</div>
		</div>
	<!-- /.panel-default -->
	<br>
	</div>
	<!-- /#page-wrapper -->
	
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		<h4 class="modal-title" id="myModalLabel"><img src = "../../CONFIG/images/escudo.png" width = "40px;" /> ASMS</h4>
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

    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/helpdesk/helpdesk.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>


</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>