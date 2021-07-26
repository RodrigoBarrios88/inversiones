<?php
	include_once('xajax_funct_reportes.php');
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	
if($nombre != "" && $valida != ""){	
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
    
    <!-- Bootstrap Core CSS -->
    <link href="../../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../../assets.3.6.2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../../assets.3.6.2/bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

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
                                <li>
                                    <a href="FRMgraficas_grados.php">
									<i class="fa fa-bar-chart-o "></i> Estadisticas por Grados
									</a>
                                </li>
                                <li>
                                    <a href="FRMgraficas_materias.php">
									<i class="fa fa-bar-chart-o "></i> Estadisticas por Materia
									</a>
                                </li>
                                <li>
                                    <a href="../FRMnominanotas.php">
									<i class="fa fa-file-text-o"></i> Nomina de Notas  por Grados
									</a>
                                </li>
                                <li>
                                    <a href="../FRMtarjetanotas.php">
									<i class="fa fa-users"></i> Nomina de Notas por Alumno
									</a>
                                </li>
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
			<form name = "f1" id = "f1"  method="post">
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading"> 
							<span class="fa fa-file-text-o" aria-hidden="true"></span>
							Generar Nominas de Notas
						</div>
						<div class="panel-body"> 
							<div class="row">
								<div class="col-lg-12">
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1"><label>Programa Acad&eacute;mico:</label></div>
										<div class="col-xs-5"><label>Nivel:</label></div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1">
											<?php echo pensum_html("pensum","xajax_Pensum_Nivel(this.value,'nivel','divnivel','Combo_Grado_Notas();');"); ?>
											<?php if($pensum != ""){ ?>
											<script type = "text/javascript">
												document.getElementById("pensum").value = '<?php echo $pensum; ?>';
											</script>
											<?php } ?>
										</div>
										<div class="col-xs-5" id = "divnivel">
											<?php
												if($pensum != "" && $nivel != ""){
													echo nivel_html($pensum,"nivel","Combo_Grado_Notas();");;
												}else{
													echo combos_vacios("nivel");
												}	
											?>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1"><label>Grado de los Alumnos: </label></div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1" id = "divgrado">
											<?php if($pensum != "" && $nivel != ""){
													echo grado_html($pensum,$nivel,"grado","Lista_Materia_Notas();");
												}else{
													echo combos_vacios("grado");
												}	
											?>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-10 col-xs-offset-1"><hr></div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1"><label>T&iacute;po Evaluaciones:</label></div>
										<div class="col-xs-5"><label>Numero de Unidad:</label></div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1">
											<select id = "tipo" name = "tipo" class = "form-control" onchange="Numero_Parcial(this.value)">
												<option value = "">Selecciones</option>
												<option value = "1">EVALUACION PARCIAL O DE UNIDAD</option>
												<option value = "3">EVALUACION FINAL</option>
											</select>
										</div>
										<div class="col-xs-5" >
											<select id = "num" name = "num" class = "form-control" disabled>
												<option value = "0">Selecciones</option>
												<option value = "1">1ERO. &Oacute; &Uacute;NICO</option>
												<option value = "2">2DO.</option>
												<option value = "3">3RO.</option>
												<option value = "4">4TO.</option>
												<option value = "5">5TO.</option>
											</select>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1"><label>T&iacute;po de Secci&oacute;n:</label></div>
										<div class="col-xs-5"><label>Secci&oacute;n:</label></div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1">
											<select id = "tiposec" name = "tiposec" class = "form-control" onchange="Combo_Seccion_Generador_Nominas();">
												<option value = "">Selecciones</option>
												<option value = "A">ACAD&Eacute;MICA</option>
												<option value = "P">PR&Aacute;CTICA</option>
												<option value = "D">Deportiva</option>
											</select>
										</div>
										<div class="col-xs-5" id = "divseccion">
											<select id = "seccion" name = "seccion" class = "form-control">
												<option value = "">Selecciones</option>
											</select>
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1" id = "divmateria">
											<?php echo lista_multiple_vacia("materia","Listado de Materias a Incluir"); ?>
										</div>
										<div class="col-xs-5">
											<div class="row">
												<div class="col-xs-12">
													<div class="row">
														<div class="col-xs-6"><label>Nota M&iacute;nima:</label></div>
														<div class="col-xs-6"><label>T&iacute;tulo:</label></div>
													</div>
													<div class="row">
														<div class="col-xs-6">
															<input type="text" class="form-control" id ="notaminima" name="notaminima" value = "60" onkeyup="decimales(this)" />
														</div>
														<div class="col-xs-6">
															<input type="text" class="form-control" id ="titulo" name="titulo" onkeyup="texto(this)" value="NOMINA DE NOTAS" />
														</div>
													</div>
												</div>
											</div>
											
											<br>
											
											<div class="row">
												<div class="col-xs-12">
													<div class="row">
														<div class="col-xs-6"><label>Tamaño de Letra:</label></div>
														<div class="col-xs-6"><label>Ancho de Columnas (mm.):</label></div>
													</div>
													<div class="row">
														<div class="col-xs-6">
															<select id = "font" name = "font" class = "form-control">
																<option value = "">Selecciones</option>
																<option value = "6" selected >6</option>
																<option value = "8">8</option>
																<option value = "10">10</option>
																<option value = "12">12</option>
																<option value = "14">14</option>
															</select>
														</div>
														<div class="col-xs-6">
															<input type="text" class="form-control" id ="anchocols" name="anchocols" value = "15" onkeyup="enteros(this)" />
														</div>
													</div>
												</div>
											</div>
											
											<br>
											
											<div class="row">
												<div class="col-xs-12">
													<div class="row">
														<div class="col-xs-6"><label>Tipo de Papel:</label></div>
														<div class="col-xs-6"><label>Orientaci&oacute;n:</label></div>
													</div>
													<div class="row">
														<div class="col-xs-6">
															<select id = "papel" name = "papel" class = "form-control">
																<option value = "">Selecciones</option>
																<option value = "Letter" selected >CARTA</option>
																<option value = "Legal">OFICIO</option>
															</select>
														</div>
														<div class="col-xs-6">
															<select id = "orientacion" name = "orientacion" class = "form-control">
																<option value = "">Selecciones</option>
																<option value = "L" selected >Horizontal</option>
																<option value = "P">Vertical</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											
											<br>
											
											<div class="row">
												<div class="col-xs-12 text-center">
													<button class="btn btn-primary" onclick="Submit();" title = "Desplegar Estadisticas" ><span class="fa fa-bar-chart-o "></span> &nbsp; <label>Imprimir </label>&nbsp;  <span class="fa fa-angle-double-right"></span></button> 
												</div>
											</div>
											
										</div>	
									</div>	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
            <div class="row">
				<div class="col-lg-12" id = "result"></div>
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
			<h4 class="modal-title text-left" id="myModalLabel"><img src="../../../CONFIG/images/escudo.png" width = "40px;" /> ASMS</h4>
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

    <!-- Custom Theme JavaScript -->
    <script src="../../assets.3.6.2/dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/academico/academico.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
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
	echo "<form id='f1' name='f1' action='../../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>