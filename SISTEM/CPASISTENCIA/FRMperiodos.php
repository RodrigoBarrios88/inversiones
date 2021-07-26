<?php
	include_once('xajax_funct_asistencia.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//_$POST
	$maestro = $_REQUEST["maestro"];
	$dia = $_REQUEST["dia"];
	$hoy = date("w");
	$dia = ($dia != "")?$dia:$hoy;
	//--
	$ClsMae = new ClsMaestro();
	$ClsAsi = new ClsAsignacion();
	$ClsAcadem = new ClsAcademico();
	
	if($tipo_usuario == 5){
		$result_maestro = $ClsMae->get_maestro('','','',1);
	}else if($tipo_usuario == 1){
		$result = $ClsAcadem->get_grado_otros_usuarios($pensum,'','',$tipo_codigo);
		if(is_array($result)){
			$nivel = "";
			$grado = "";
			foreach($result as $row){
				$nivel.= $row["gra_nivel"].",";
				$grado.= $row["gra_codigo"].",";
			}
			$nivel = substr($nivel, 0, -1);
			$grado = substr($grado, 0, -1);
		}
		$result = $ClsMae->get_grado_maestro($pensum,$nivel,$grado,'');
		if(is_array($result)){
			$maestros = "";
			foreach($result as $row){
				$maestros.= "'".$row["mae_cui"]."',";
			}
			$maestros = substr($maestros, 0, -1);
		}
		$result_maestro = $ClsMae->get_maestro_IN($maestros); 
	}else if($tipo_usuario == 2){
		$result_maestro = $ClsMae->get_maestro($tipo_codigo,'','',1);
		$maestro = $tipo_codigo;
	}
	
if($tipo_usuario != "" && $usunombre != "" && $valida != ""){	
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
    
	 <!-- Estilos Utilitarios -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
    
	<!-- Datepicker Bootstrap v3.0 -->
	<script type="text/javascript" src="../assets.3.6.2/bower_components/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    
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
                                <?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="FRMperiodos.php">
									<i class="fa fa-list"></i> Listar Periodos
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="FRMlist_seccion.php">
									<i class="fa fa-search"></i> Asistencia por Grado/Secci&oacute;n
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="FRMlista_alumnos.php">
									<i class="fa fa-search"></i> Asistencia por Alumno
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="FRMlist_maestros.php">
									<i class="fa fa-search"></i> Asistencia por Maestro
									</a>
                                </li>
                                <?php } ?>
                                <?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="CPREPORTES/FRMrepasistencia.php">
									<i class="fa fa-print"></i> Reporte de Asitencia por materia
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
            <div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading"> 
							<span class="fa fa-calendar" aria-hidden="true"></span>
							Horario por Maestro
						</div>
						<div class="panel-body">
						<form id = "f1" name = "f1" method="get">
							<div class="row">
								<div class="col-lg-12">
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1"><label>Maestro:</label></div>
										<div class="col-xs-5"><label>D&iacute;a:</label> <span class = "text-danger">*</span></div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1">
											<?php echo combos_html_onclick($result_maestro,"maestro",'mae_cui','mae_nombre_completo',"Submit();") ?>
											<?php if($maestro != ""){ ?>
											<script type = "text/javascript">
												document.getElementById("maestro").value = '<?php echo $maestro; ?>';
												<?php if($tipo_usuario == 2){ ?>
												document.getElementById("maestro").disabled = true;
												<?php } ?>
											</script>
											<?php } ?>
										</div>
										<div class="col-xs-5" id = "divnivel">
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
								</div>
							</div>
						</form>
						</div>
					</div>
					<!-- /.panel-default -->
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-12">
					<?php
						if($maestro != "" && $dia != ""){
							echo tabla_horario_maestro($maestro,$dia);
						}
					?>
				</div>
			</div>		
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
    
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    
    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/academico/asistencia.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				responsive: true
			});
		});
		
		$(function () {
            $('#fecha').datetimepicker({
                format: 'DD/MM/YYYY HH:mm'
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