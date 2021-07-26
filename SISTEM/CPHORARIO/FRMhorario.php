<?php
	include_once('xajax_funct_horario.php');
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//__$_POST
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	$tipo = $_REQUEST["tipo"];
	$dia = $_REQUEST["dia"];
	
if($nombre != "" && $tipo_usuario != ""){	
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
									<a href="FRMtipo_periodo.php">
									<i class="fa fa-th"></i> Gestor de Tipos
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMperiodos.php">
									<i class="fa fa-puzzle-piece"></i> Gestor de Periodos
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMhorario.php">
									<i class="fa fa-clock-o"></i> Definir Horario
									</a>
                                </li>
                                <?php } ?>
								<hr>
								<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
                                    <a href="CPREPORTES/FRMhor_dia_seccion.php">
									<i class="fa fa-calendar"></i> Horario Diario
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
                                    <a href="CPREPORTES/FRMhor_semana_seccion.php">
									<i class="fa fa-calendar"></i> Horario Semanal
									</a>
                                </li>
                                <?php } ?>
								<hr>
								<li>
                                    <a href="../CPMENU/MENUhorario.php">
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
            <br>
			<form name = "f1" id = "f1" method="get">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-clock-o"></i>
						<label>Definici&oacute;n de Horarios por D&iacute;a</label>
					</div>
                    <div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-xs-12 text-right"><label class = " text-danger">* Campos Obligatorios</label> </div>
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
										echo nivel_html($pensum,"nivel","Combo_Grado();");;
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
							<div class="col-xs-5"><label>T&iacute;po de Secci&oacute;n:</label></div>
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
                            <div class="col-xs-5">
								<select id = "tipo" name = "tipo" class = "form-control" onchange="Combo_Seccion();">
									<option value = "">Selecciones</option>
									<option value = "A">ACAD&Eacute;MICA</option>
									<option value = "P">PR&Aacute;CTICA</option>
									<option value = "D">Deportiva</option>
								</select>
								<?php if($tipo != ""){ ?>
								<script type = "text/javascript">
									document.getElementById("tipo").value = '<?php echo $tipo; ?>';
								</script>
								<?php } ?>
							</div>
                        </div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1"><label>Secci&oacute;n:</label> <span class = "text-danger">*</span></div>
							<div class="col-xs-5"><label>D&iacute;a:</label> <span class = "text-danger">*</span></div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1" id = "divseccion">
								<?php if($pensum != "" && $nivel != "" && $grado != "" && $tipo != ""){
										echo seccion_html($pensum,$nivel,$grado,$tipo,"seccion","Submit();");
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
							<div class="col-xs-5">
								<select id = "dia" name = "dia" class = "form-control" onchange="Submit();">
									<option value = "">Selecione</option>
									<option value = "1">LUNES</option>
									<option value = "2">MARTES</option>
									<option value = "3">MIERCOLES</option>
									<option value = "4">JUEVES</option>
									<option value = "5">VIERNES</option>
									<option value = "6">SABADO</option>
									<option value = "7">DOMINGO</option>
								</select>
								<input type = "hidden" name = "cod" id = "cod" />
								<script type = "text/javascript">
									document.getElementById("dia").value = "<?php echo $dia; ?>";
								</script>
							</div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="button" class="btn btn-default" id = "limp" onclick = "location.href='FRMperiodos.php';"><span class="fa fa-eraser"></span> Limpiar</button>
                            </div>
                        </div>
                    </div>
				    <!-- /.panel-body -->
				</div>
            </form>
			 <!-- /.panel-default -->
			<br>
			<div class="panel panel-default">
			    <div class="panel-body">
					<div class="row">
						<div class="col-lg-12" id = "result">
							<?php
								if($dia != "" && $pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $tipo != ""){
									echo tabla_horario_a_definir($dia,$pensum,$nivel,$grado,$seccion,$tipo);
								}
							?>
						</div>
					</div>
				</div>
			</div>	
	     <br>
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
			<h4 class="modal-title text-left" id="myModalLabel"><img src = "../../CONFIG/images/escudo.png" width = "40px;" /> ASMS</h4>
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/horario/periodo.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				responsive: true
			});
	    });
	
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover();   
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