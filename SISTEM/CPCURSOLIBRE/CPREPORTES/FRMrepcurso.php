<?php
	include_once('html_fns_reportes.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//POST
	$curso = $_REQUEST["curso"];
	$sede = $_REQUEST["sede"];
	$clase = $_REQUEST["clase"];
	$fini = $_REQUEST["fini"];
	$ffin = $_REQUEST["ffin"];
	
	$ClsCur = new ClsCursoLibre();
	if($tipo_usuario == 2){ //// MAESTRO
		$result_cursos = $ClsCur->get_curso_maestro($curso,$tipo_codigo,$sede);
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$result_cursos = $ClsCur->get_curso_autoridad($curso,$tipo_codigo,$sede);
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$result_cursos = $ClsCur->get_curso("");
	}else{
		$result_cursos = "";
	}
	
	if(is_array($result_cursos)){
        $combo_cursos = combos_html_onclick($result_cursos,"curso",'cur_codigo','cur_nombre',"Submit();");
    }else{
		$combo_cursos = combos_vacios("curso");
	}
	
if($pensum != "" && $nombre != ""){ 	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../../CONFIG/images/logo.png">
	
	<!-- CSS personalizado -->
    <link href="../../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../../assets.3.6.2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../../assets.3.6.2/bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
	
	<!-- Date Picker -->
    <link href="../../assets.3.6.2/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="../../assets.3.6.2/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
    
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
                        <li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Perfil de Usuario</a></li>
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
                                <?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li class="active">
                                    <a href="../FRMimportcurso.php">
									<i class="fa fa-sign-in"></i> Importar Cursos
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
                                    <a href="../FRMcurso.php">
									<i class="fa fa-tag"></i> Gestor de Cursos Libres
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
                                    <a href="../FRMlista_cursos_temas.php">
									<i class="fa fa-tags"></i> Gestor de Temas
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
                                    <a href="../FRMlista_cursos.php">
									<i class="fa fa-link"></i> Asignaci&oacute;n de Alumnos
									</a>
                                </li>
                                <?php } ?>
								<hr>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
                                    <a href="FRMrepcurso.php">
									<i class="glyphicon glyphicon-print"></i> Reporte de Cursos
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
                                    <a href="FRMesquema.php">
									<i class="glyphicon glyphicon-print"></i> Dosificaci&oacute;n Curricular
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
                                    <a href="FRMrepasigcurso.php">
									<i class="glyphicon glyphicon-print"></i> Alumnos en el Curso
									</a>
                                </li>
                                <?php } ?>
								<hr>
								<li>
                                    <a href="../../CPMENU/MENUacademico.php">
									<i class="fa fa-indent"></i> Men&uacute
									</a>
                                </li>
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
	    <br>
            <div class="panel panel-default">
				<div class="panel-heading">
					<i class="glyphicon glyphicon-print"></i>
					Reporte de Cursos Libres
				</div>
                <div class="panel-body">
					<form name = "f1" id = "f1" method="get">
						<div class="row">
							<div class="col-xs-12 col-xs-12 text-right"><label class = " text-info">* Campos de Busqueda</label></div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<label>Sede:</label>
								<?php echo sede_html("sede","Submit();"); ?>
								<script type = "text/javascript">
									document.getElementById("sede").value = '<?php echo $sede; ?>';
								</script>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<label>Clasificaci&oacute;n:</label>
								<select class = "form-control" id = "clase" name = "clase" onchange= "Submit();">
									<option value = "">Seleccione</option>
									<option value = "1">ACAD&Eacute;MICO</option>
									<option value = "2">ART&Iacute;STICO</option>
									<option value = "3">DEPORTIVO</option>
									<option value = "4">PR&Aacute;CTICO</option>
								</select>
								<script type = "text/javascript">
									document.getElementById("clase").value = '<?php echo $clase; ?>';
								</script>
							</div>
							<div class="col-xs-5">
								<label>Rango de Inicio de Curso:</label>
								<div class="form-group" id="rango">
									<div class="input-daterange input-group" id="datepicker">
										<input type="text" class="form-control" name="fini" id="fini" onchange= "Submit();" value = "<?php echo $fini; ?>" readonly />
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" class="form-control" name="ffin" id="ffin" onchange= "Submit();" value = "<?php echo $ffin; ?>" readonly />
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-12 text-center">
								<button type="button" class="btn btn-default" onclick = "window.location.reload();"><span class="fa fa-eraser"></span> Limpiar</button>
								<button type="button" class="btn btn-primary" onclick = "Reporte();"><span class="fa fa-print"></span> Imprimir</button>
							</div>
						</div>
						<br>
					</form>
                </div>
                <!-- /.panel-body -->
			</div>
             <!-- /.panel-default -->
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
    
    <!-- jQuery -->
    <script src="../../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../assets.3.6.2/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../assets.3.6.2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Date picker -->
    <script src="../../assets.3.6.2/js/plugins/datapicker/bootstrap-datepicker.js"></script>
	
	<!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/lms/tema.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength:50,
				responsive: true
			});
			
			$('#rango .input-daterange').datepicker({
                keyboardNavigation: false,
				format: 'dd/mm/yyyy',
                forceParse: false,
                autoclose: true
            });
	    });
		
		function Reporte(){
			myform = document.forms.f1;
			myform.target ="_blank";
			myform.action ="REPcurso.php";
			myform.submit();
			myform.action ="";
			myform.target ="";
		}
    </script>	

</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>