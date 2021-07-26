<?php
	include_once('xajax_funct_temporal.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//__$_POST
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	$nom = $_REQUEST["nom"];
	$ape = $_REQUEST["ape"];
	$codigo = $_REQUEST["codigo"];
	//--
	$boton = $_REQUEST["boton"];
	$boton = ($boton != "")?$boton:"G";
	
if($tipo_usuario != "" && $nombre != ""){ 	
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
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
   <link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    

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
                       <li>
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li>
									<a href="FRMgestor_temportal.php">
										<i class="fa fa-paste"></i> Depurador de Temporales
									</a>
                                </li>
								<li>
									<a href="FRMsincronizacion.php">
										<i class="fa fa-refresh"></i> Sincronizaci&oacute;n
									</a>
                                </li>
								<hr>
								<li>
                                    <a href="CPBOLETAS/FRMboleta_temporal.php">
									<i class="fa fa-money"></i> Depurador de Boletas Temporales
									</a>
                                </li>
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
			<form name = "f1" id = "f1" method="get">
            <div class="panel panel-default">
				<div class="panel-heading"><label>Formulario Depurador de Alumnos Temporales</label></div>
                <div class="panel-body" id = "formulario">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Pensum:</label> <span class = "text-danger">*</span></div>
						<div class="col-xs-5"><label>Nivel:</label> <span class = "text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo pensum_html("pensum","xajax_Pensum_Nivel(this.value,'nivel','divnivel','Combo_Grado();');"); ?>
							<?php if($pensum != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("pensum").value = '<?php echo $pensum; ?>';
							</script>
							<?php } ?>
						</div>
						<div class="col-xs-5" id = "divnivel">
							<?php
								if($pensum != ""){
									echo nivel_html($pensum,"nivel","Combo_Grado();");
								}else{
									echo combos_vacios("nivel");
								}	
							?>
							<?php if($nivel != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("nivel").value = '<?php echo $nivel; ?>';
							</script>
							<?php } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Grado:</label> <span class = "text-danger">*</span></div>
						<div class="col-xs-5"><label>Secci&oacute;n:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1" id = "divgrado">
							<?php if($pensum != "" && $nivel != ""){
									echo grado_html($pensum,$nivel,"grado","Combo_Seccion();");
								}else{
									echo combos_vacios("grado");
								}	
							?>
							<?php if($grado != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("grado").value = '<?php echo $grado; ?>';
							</script>
							<?php } ?>
						</div>
                        <div class="col-xs-5" id = "divseccion">
							<?php if($pensum != "" && $nivel != "" && $grado != ""){
									echo seccion_html($pensum,$nivel,$grado,'',"seccion","Submit();");
								}else{
									echo combos_vacios("seccion");
								}	
							?>
							<?php if($seccion != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("seccion").value = '<?php echo $seccion; ?>';
							</script>
							<?php } ?>
						</div>
                    </div>
					<hr>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>C&oacute;digo Interno:</label> <span class = "text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = " codigo" id = "codigo"  value = "<?php echo $codigo; ?>" onkeyup = "enteros(this)" maxlength = "15" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Nombre:</label> <span class = "text-danger">*</span></div>
						<div class="col-xs-5"><label>Apellido:</label> <span class = "text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "nom" id = "nom"  value = "<?php echo $nom; ?>" onkeyup = "texto(this)" />
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "ape" id = "ape"  value = "<?php echo $ape; ?>" onkeyup = "texto(this);" />
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
							<?php
								if($boton == "G"){
									$hidden_grabar = "";
									$hidden_modificar = "hidden";
								}else if($boton == "M"){
									$hidden_grabar = "hidden";
									$hidden_modificar = "";
								}	
							?>
							<button type="button" class="btn btn-primary <?php echo $hidden_grabar; ?>" id = "gra" onclick = "Grabar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
							<button type="button" class="btn btn-primary <?php echo $hidden_modificar; ?>" id = "mod" onclick = "Modificar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
							<input type = "hidden" name = "boton" id = "boton" value = "<?php echo $boton; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<?php
								if($nivel != "" && $grado != ""){
									echo tabla_gestor_alumnos_temporales('','','',$pensum,$nivel,$grado,$seccion);
								}
							?>
						</div>
						<div class="col-lg-6">
							<?php
								if($nivel != "" && $grado != ""){
									echo tabla_gestor_seccion_alumnos($pensum,$nivel,$grado,$seccion);
								}	
							?>
						</div>
					</div>
				</div>
            </div>
             <!-- /.panel-default -->
			</form>
		</div>
        <!-- /#page-wrapper -->

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
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/temporal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example1').DataTable({
				responsive: true
			});
		});
		
		$(document).ready(function() {
			$('#dataTables-example2').DataTable({
				responsive: true
			});
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