<?php
	include_once('xajax_funct_materia.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$pensum_vigente = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$pensum = $_REQUEST["pensum"];
	$pensum = ($pensum == "")?$pensum_vigente:$pensum;
	$cod = $_REQUEST["cod"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$tipo = $_REQUEST["tipo"];
	
if($usuario != "" && $nombre != "" && $valida != ""){	
?>
<!DOCTYPE html>
<html lang="en">
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
    
	<!-- Libreria de Calendarios -->
	<link type="text/css" rel="stylesheet" href ="../ $('.dataTables-example').DataTable({dhtmlgoodies_calendar.css">
	<script type="text/javascript" src="../assets.3.6.2/js/dhtmlgoodies_calendar.js"></script>	
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
	<!-- Touchspin CSS -->
	<link href="../assets.3.6.2/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">

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
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
                        <li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Formulario de Perfil de Usuarios</a></li>
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
                                <?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
                                    <a href="FRMmateria.php">
									<i class="fa fa-tag"></i> Gestor de Materias
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
                                    <a href="CPREPORTES/FRMrepmateria.php">
									<i class="fa fa-print"></i> Reporte de Materias
									</a>
                                </li>
                                <?php } ?>
								<hr>
								<li>
                                    <a href="../CPMENU/MENUacademico.php">
									<i class="fa fa-indent"></i> Men&uacute
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
		<form name = "f1" id = "f1" method="get">
            <br>
            <div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading"> 
							<span class="fa fa-tag" aria-hidden="true"></span>
							Gestor de Materias
						</div>
						<div class="panel-body"> 
						<br>
							<div class="row">
								<div class="col-xs-5 col-xs-offset-1"><label>Programa Acad&eacute;mico:</label></div>
								<div class="col-xs-5"><label>Nivel:</label></div>
							</div>
							<div class="row">
								<div class="col-xs-5 col-xs-offset-1">
									<?php echo pensum_html("pensum","Submit();"); ?>
									<?php if($pensum != ""){ ?>
									<script type = "text/javascript">
										document.getElementById("pensum").value = '<?php echo $pensum; ?>';
									</script>
									<?php } ?>
									<input type = "hidden" name = "cod" id = "cod" value="<?php echo $cod; ?>" />
								</div>
								<div class="col-xs-5" id = "divnivel">
									<?php if($pensum != ""){
										echo nivel_html($pensum,"nivel","Submit();");
									?>
									<script type = "text/javascript">
										document.getElementById("nivel").value = '<?php echo $nivel; ?>';
									</script>
									<?php }else{
											echo combos_vacios("nivel");
										}	
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-5 col-xs-offset-1"><label>Grado de los Alumnos:</label></div>
								<div class="col-xs-5"><label>T&iacute;po:</label></div>
							</div>
							<div class="row">
								<div class="col-xs-5 col-xs-offset-1" id = "divgrado">
									<?php if($pensum != "" && $nivel != ""){
											echo grado_html($pensum,$nivel,"grado","Submit();");
										}else{
											echo combos_vacios("grado");
										}	
									?>
									<?php if($pensum != "" && $nivel != ""){ ?>
									<script type = "text/javascript">
										document.getElementById("grado").value = '<?php echo $grado; ?>';
									</script>
									<?php } ?>
								</div>
								<div class="col-xs-5">
									<select id = "tipo" name = "tipo" class = "form-control">
										<option value = "">Selecciones</option>
										<option value = "1">Materia exigida por MINEDUC (Tarjeta de Calificaciones)</option>
										<option value = "0">Materia del Pensum interno del Colegio (No valida para MINEDUC)</option>
									</select>
									<script type = "text/javascript">
										document.getElementById("tipo").value = '<?php echo $tipo; ?>';
									</script>
								</div>
							</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1"><label>Categor&iacute;a:</label></div>
							<div class="col-xs-5"><label>Posici&oacute;n:</label></div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<select id = "cate" name = "cate" class = "form-control">
									<option value = "">Selecciones</option>
									<option value = "A">Acad&eacute;mica</option>
									<option value = "P">Pra&acute;ctica</option>
									<option value = "D">Deportiva</option>
								</select>
								<script type = "text/javascript">
									document.getElementById("cate").value = '<?php echo $cate; ?>';
								</script>
							</div>
							<div class="col-xs-5">
								<input type = "text" class="touchspin" name = "orden" id = "orden" maxlength="3" onkeyup="enteros(this);" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1"><label>Nombre:</label></div>
							<div class="col-xs-5"><label>Nombre Corto:</label></div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<input type = "text" class = "form-control" name = "desc" id = "desc" onkeyup="texto(this)" />
							</div>
							<div class="col-xs-5">
								<input type = "text" class = "form-control" name = "dct" id = "dct" maxlength="10" onkeyup="texto(this)" />
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-12 text-center">
								<a class="btn btn-default" href = "FRMmateria.php"><span class="fa fa-eraser"></span> Limpiar</a>
								<button type="button" class="btn btn-primary" id = "gra" onclick = "Grabar();"><span class="fa fa-save"></span> Grabar</button>
								<button type="button" class="btn btn-primary hidden" id = "mod" onclick = "Modificar();"><span class="fa fa-save"></span> Grabar</button>
							</div>
						</div>
						<br>
					</div>
					<!-- /.panel-default -->
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-12">
					<?php echo tabla_materias($pensum,$nivel,$grado,'',1); ?>
				</div>
			</div>
		</form>
		</div>
        <!-- /#page-wrapper -->
        <!-- //////////////////////////////// -->
        <!-- .footer -->

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

    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
	
	<!-- TouchSpin -->
    <script src="../assets.3.6.2/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/academico/materias.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 100,
				responsive: true
			});
	    });
		
		$(".touchspin").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white'
        });
    </script>	
    
</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>