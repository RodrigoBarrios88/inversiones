<?php
	include_once('xajax_funct_examen.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	$ClsExa = new ClsExamen();
	$ClsCur = new ClsCursoLibre();
	$acc = $_REQUEST["acc"];
	$hashkey = $_REQUEST["hashkey"];
	$curso = $ClsCur->decrypt($hashkey, $usuario);
	
	if($tipo_usuario == 2){ //// MAESTRO
		$result_temas = $ClsCur->get_tema("",$curso);
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$result_temas = $ClsCur->get_tema("",$curso);
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$result_temas = $ClsCur->get_tema("",$curso);
	}else{
		$valida = "";
	}
	
	if($acc == "gestor"){
		$active1 = 'class = "active"';
		$active2 = 'class = ""';
		$active3 = 'class = ""';
	}else if($acc == "calificar"){
		$active1 = 'class = ""';
		$active2 = 'class = "active"';
		$active3 = 'class = ""';
	}else if($acc == "ver"){
		$active1 = 'class = ""';
		$active2 = 'class = ""';
		$active3 = 'class = "active"';
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
	
	<!-- Libreria de Calendarios -->
	<link type="text/css" rel="stylesheet" href ="../ $('.dataTables-example').DataTable({dhtmlgoodies_calendar.css">
	<script type="text/javascript" src="../assets.3.6.2/js/dhtmlgoodies_calendar.js"></script>	
	
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
                       <li class="active">
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if($tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
                                    <a <?php echo $active1; ?> href="FRMcursoexamen.php?acc=gestor">
									<i class="fa fa-pencil"></i> Gestor de Evaluaciones
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
                                    <a <?php echo $active2; ?> href="FRMcursoexamen.php?acc=calificar">
									<i class="fa fa-paste"></i> Calificar Evaluaciones
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
                                    <a <?php echo $active3; ?> href="FRMcursoexamen.php?acc=ver">
									<i class="fa fa-search"></i> Visualizar Evaluaciones
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
            <br>
            <div class="panel panel-default">
				<div class="panel-heading"> 
					<span class="fa fa-tags" aria-hidden="true"></span>
					Seleccione el Tema en el Curso donde se asignar&aacute; el Evaluaciones
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12">
							<table class="table table-striped table-bordered table-hover">
								<thead>
								<tr>
									<th width = "10px" class = "text-center">No.</td>
									<th width = "210px" class = "text-center">TEMA</th>
									<th width = "100px" class = "text-center">Evaluaciones</td>
									<th width = "100px" class = "text-center"></th>
								</tr>
								</thead>
								<tr>
									<th width = "10px" class = "text-center">N</td>
									<td class = "text-left">Evaluacion GLOBAL DE CURSO (No afiliado a un tema en espec&iacute;fico)</td>
									<?php
										//////////////////////////
										$result_examenes = $ClsExa->get_examen_curso('',$curso,0);
										$total_actividades = 0;
										if(is_array($result_examenes)){
											$actividades = 0;
											foreach($result_examenes as $row_examenes){
												$actividades++;
											}	
										}else{
											$actividades = 0;
										}
										$total_actividades+= $actividades;
										//actividades
										$salida.= '<td class = "text-center">'.$actividades.'</td>';
										//boton
										$salida.= '<td class = "text-center">';
										/// Selecciona Examenes Globales del curso (Tema = 0)
										$usu = $_SESSION["codigo"];
										$hashkey1 = $ClsCur->encrypt($curso, $usu);
										$hashkey2 = $ClsCur->encrypt("0", $usu);
										if($acc == "gestor"){
											$salida.= '<a class="btn btn-primary btn-block" href="FRMgestorexamen.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" title = "Crear Evaluaciones" ><i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></a>';
										}else if($acc == "calificar"){
											$salida.= '<a class="btn btn-primary btn-block" href="FRMlistarexamen.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&acc=calificar" title = "Listar Evaluaciones" ><i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></a>';
										}else if($acc == "ver"){
											$salida.= '<a class="btn btn-primary btn-block" href="IFRMexamen.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" title = "Listar Evaluaciones" ><i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></a>';
										}
										$salida.= '</td>';
										echo $salida;
									?>
								</tr>
							</table>	
						</div>
					</div>
					<hr>
					<h5 class="text-center"> Evaluaciones por Tema</h5>
					<div class="row">
						<div class="col-xs-12">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
								<tr>
								<th width = "10px" class = "text-center">No.</td>
								<th width = "150px" class = "text-center">TEMAS</td>
								<th width = "100px" class = "text-center">Evaluaciones</td>
								<th width = "100px" class = "text-center"><span class="fa fa-cogs"></span></td>
								</tr>
								</thead>
								<?php
									if(is_array($result_temas)){
										$i = 1;
										$salida = "";
										$usu = $_SESSION["codigo"];
										foreach($result_temas as $row){
											$curso = $row["tem_curso"];
											$tema = $row["tem_codigo"];
											$usu = $_SESSION["codigo"];
											$hashkey1 = $ClsCur->encrypt($curso, $usu);
											$hashkey2 = $ClsCur->encrypt($tema, $usu);
											//No.
											$salida.= '<td class = "text-center">'.$i.'. </td>';
											//nombre
											$nombre = utf8_decode($row["tem_nombre"]);
											$salida.= '<td class = "text-left">'.$nombre.'</td>';
											//////////////////////////
											$result_examenes = $ClsExa->get_examen_curso('',$curso,$tema);
											if(is_array($result_examenes)){
												$actividades = 0;
												foreach($result_examenes as $row_examenes){
													$actividades++;
												}	
											}else{
												$actividades = 0;
											}
											$total_actividades+= $actividades;
											//actividades
											$salida.= '<td class = "text-center">'.$actividades.'</td>';
											//boton
											$salida.= '<td class = "text-center">';
											if($acc == "gestor"){
											$salida.= '<a class="btn btn-primary btn-block" href="FRMgestorexamen.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" title = "Seleccionar Tema" ><i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></a>';
											}else if($acc == "calificar"){
											$salida.= '<a class="btn btn-primary btn-block" href="FRMlistarexamen.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&acc=calificar" title = "Seleccionar Tema" ><i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></a>';
											}else if($acc == "ver"){
											$salida.= '<a class="btn btn-primary btn-block" href="IFRMexamen.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" title = "Seleccionar Tema" ><i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></a>';
											}
											$salida.= '</td>';
											$salida.= '</tr>';
											$i++;
										}
										
										echo $salida;
									}else{
										
									}
								?>			
							</table>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<h6 class="alert alert-info text-center"> Total de Examenes o Evaluaciones en el Curso: <label><?php echo $total_actividades; ?></label></h6>
						</div>
					</div>
					<br>
				</div>
			</div>
					<!-- /.panel-default -->
			<br>	
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/lms/tarea.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
	$(document).ready(function() {
		$('#dataTables-example').DataTable({
			pageLength: 50,
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