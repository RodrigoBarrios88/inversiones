<?php
	include_once('xajax_funct_reportes.php');
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	$pensum_session = $_SESSION["pensum"];
	//$_POST
	$pensum = $_REQUEST["pensum"];
	$pensum = ($pensum == "")?$pensum_session:$pensum;
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	$fecha = $_REQUEST["fecha"] ;
	$materia = $_REQUEST["materia"];
	
	
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	if($tipo_usuario == 2){ //// MAESTRO
		$result_materias = $ClsAcadem->get_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,'',$tipo_codigo);
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado);
	}else if($tipo_usuario == 5){ /// ADMINISTRADOR
		$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado);
	}else{
		$valida = "";
	}
	
	if(is_array($result_materias)){
		if($tipo_usuario == 2){ //// MAESTRO
			$combo_materia = combos_html_onclick($result_materias,"materia","secmat_materia","materia_descripcion","Submit();");
		}else if($tipo_usuario == 1){ //// DIRECTORA
			$combo_materia = combos_html_onclick($result_materias,"materia","mat_codigo","mat_descripcion","Submit();");
		}else if($tipo_usuario == 5){ /// ADMINISTRADOR
			$combo_materia = combos_html_onclick($result_materias,"materia","mat_codigo","mat_descripcion","Submit();");
		}
	}else{
		$combo_materia = combos_vacios("materia");
	}

	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../../CONFIG/images/logo.png">
		<?php
		   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		   $xajax->printJavascript("../..");
		 ?>
    <!-- CSS personalizado -->
    <link href="../../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
	<!-- DataTables CSS -->
   <link href="../../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
   
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
    
    <!-- Bootstrap Core CSS -->
    <link href="../../assets.3.6.2/css/formulario.css" rel="stylesheet">
    
    <!-- Datepicker Bootstrap v3.0 -->
	<script type="text/javascript" src="../../assets.3.6.2/bower_components/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="../../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="../../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />

    <!-- MetisMenu CSS -->
    <link href="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    
      <!-- DataTables CSS -->
   <link href="../../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- Sweet Alert -->
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
                <?php echo $_SESSION["rotulos_colegio_subpantalla"]; ?>
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
                       <li class="active">
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="../FRMperiodos.php">
									<i class="fa fa-list"></i> Listar Periodos
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="../FRMlist_seccion.php">
									<i class="fa fa-search"></i> Asistencia por Grado/Secci&oacute;n
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="../FRMlista_alumnos.php">
									<i class="fa fa-search"></i> Asistencia por Alumno
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="../FRMlist_maestros.php">
									<i class="fa fa-search"></i> Asistencia por Maestro
									</a>
                                </li>
                                <?php } ?>
                                <?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="FRMrepasistencia.php.php">
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
			<form name = "f1" id = "f1" method="get">
			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading"> 
									<span class="fa fa-calendar" aria-hidden="true"></span>
									<?php echo $titulo; ?>
								</div>
								<div class="panel-body">
									<form name = "f1" id = "f1" method="get">
									<div class="row">
										<div class="col-xs-5 col-xs-offset-3"><label>Fecha:</label></div>
									<div class="row">
										<div class="col-xs-5  col-xs-offset-3">
											<div class='input-group date' id='fec'>
												<input type='text' class="form-control" id = "fecha" name='fecha' value="<?php echo $fecha; ?>" onblur = "Submit();" />
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-time"></span>
												</span>
											</div>
										</div>
									</div>
									
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
										<div class="col-xs-5"><label>Secci&oacute;n:</label></div>
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
											<?php if($pensum != "" && $nivel != "" && $grado != ""){
													echo seccion_html($pensum,$nivel,$grado,"","seccion","Submit();");
												}else{
													echo combos_vacios("seccion");
												}	
											?>
											<?php if($pensum != "" && $nivel != "" && $grado != ""){ ?>
											<script type = "text/javascript">
												document.getElementById("seccion").value = '<?php echo $seccion; ?>';
											</script>
											<?php } ?>
										</div>
									</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="panel panel-default">
								<br>
								<?php
									if($fecha != ""){
										if($pensum != "" && $nivel != "" && $grado != "" && $seccion != ""){
											echo tabla_asistencia_seccion($fecha,$pensum,$nivel,$grado, $seccion);
										}else{
											echo '<div class="panel-body">';
											echo '<h6 class="alert alert-warning text-center"> <i class="fa fa-warning"></i> Uno de los campos esta vacio</h6>';
											echo '</div>';
										}
									}else{
										echo '<div class="panel-body">';
										echo '<h6 class="alert alert-info text-center"> <i class="fa fa-exclamation-circle"></i> Seleccione la fecha a listar...</h6>';
										echo '</div>';
									}
								?>
								<br>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>		
            <div class="row">
				<div class="col-lg-12" id = "result">
					
				</div>
			</div>
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
			<h4 class="modal-title text-left" id="myModalLabel"><img src="../../../CONFIG/images/logo.png" width = "60px;" /></h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<img src="../../../CONFIG/images/img-loader.gif"/><br>
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
    <script src="../../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>
    
    <!-- DataTables JavaScript -->
    <script src="../../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../assets.3.6.2/dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/academico/asistencia.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		
		function Excel(){
			pensum = document.getElementById("pensum");
			nivel = document.getElementById("nivel");
			grado = document.getElementById("grado");
			seccion = document.getElementById("seccion");
			fecha = document.getElementById("fecha");
			if(pensum.value !=="" && nivel.value !=="" && grado.value !== "" && seccion.value !== "" && fecha.value!=""){
				myform = document.forms.f1;
				myform.target ="_blank";
				myform.action ="EXCELnomina_seccion.php";
				myform.submit();
				myform.action ="";
				myform.target ="";
			}else{
				if(pensum.value ===""){
					pensum.className = "form-info";
				}else{
					pensum.className = "form-control";
				}
				if(nivel.value ===""){
					nivel.className = "form-info";
				}else{
					nivel.className = "form-control";
				}
				if(grado.value ===""){
					grado.className = "form-info";
				}else{
					grado.className = "form-control";
				}
				if(seccion.value ===""){
					seccion.className = "form-info";
				}else{
					seccion.className = "form-control";
				}
                if(fecha.value ===""){
					fecha.className = "form-info";
				}else{
					fecha.className = "form-control";
				}
				swal("Ohoo!", "Debe llenar los campos obligatorios...", "info");
			}
		}
		
		
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				responsive: true
			});
		});
		
		$(function () {
            $('#fecha').datetimepicker({
                format: 'DD/MM/YYYY'
            });
        });
    </script>	
    
</body>

</html>