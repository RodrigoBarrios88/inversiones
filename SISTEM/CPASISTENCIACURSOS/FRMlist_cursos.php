<?php
	include_once('xajax_funct_asistencia.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	$ClsCur = new ClsCursoLibre();
	$acc = $_REQUEST["acc"];
	
	if($tipo_usuario == 2){ //// MAESTRO
		$result_cursos = $ClsCur->get_curso_maestro("",$tipo_codigo);
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$result_cursos = $ClsCur->get_curso_maestro("",$tipo_codigo);
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$result_cursos = $ClsCur->get_curso("");
	}else{
		$valida = "";
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
                       <li class="active">
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
                               <?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="FRMperiodos.php">
									<i class="fa fa-check"></i> Tomar Asistencia
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a class="active" href="FRMlist_cursos.php">
									<i class="fa fa-search"></i> Asistencia por Cursos Libres
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
				<div class="panel-heading"> 
					<span class="fa fa-search" aria-hidden="true"></span>
					Seleccione el Curso a revisar asistencia
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
									<th width = "10px" class = "text-center">No.</td>
									<th width = "200px" class = "text-center">CURSO</td>
									<th width = "150px" class = "text-center">SEDE</td>
									<th width = "100px" class = "text-center">PERIODO</td>
									<th width = "100px" class = "text-center"><span class="fa fa-cogs"></span></td>
									</tr>
								</thead>
								<?php
									if(is_array($result_cursos)){
										$i = 1;
										$usu = $_SESSION["codigo"];
										foreach($result_cursos as $row){
											$codigo = $row["cur_codigo"];
											$usu = $_SESSION["codigo"];
											$hashkey = $ClsCur->encrypt($codigo, $usu);
											//No.
											$salida.= '<td class = "text-center">'.$i.'. </td>';
											//nombre
											$nombre = utf8_decode($row["cur_nombre"]);
											$salida.= '<td class = "text-left">'.$nombre.'</td>';
											//Sede
											$sede = utf8_decode($row["sed_nombre"]);
											$salida.= '<td class = "text-left">'.$sede.'</td>';
											//nombre
											$fini = cambia_fecha($row["cur_fecha_inicio"]);
											$ffin = cambia_fecha($row["cur_fecha_fin"]);
											$salida.= '<td class = "text-center">'.$fini.' - '.$ffin.'</td>';
											//boton
											$salida.= '<td class = "text-center">';
											$salida.= '<a class="btn btn-primary btn-block" href="FRMasistencia_curso.php?hashkey='.$hashkey.'&acc='.$acc.'" title = "Seleccionar Curso" ><i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></a>';
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/lms/asistencia.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
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
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	//echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>