<?php
	include_once('xajax_funct_examen.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	//$_POST
	$tema = $_REQUEST["tema"];
	$unidad = $_REQUEST["unidad"];
	
	$hashkey1 = $_REQUEST["hashkey1"];
	$pensum = $ClsAcadem->decrypt($hashkey1, $usuario);
	$hashkey2 = $_REQUEST["hashkey2"];
	$nivel = $ClsAcadem->decrypt($hashkey2, $usuario);
	$hashkey3 = $_REQUEST["hashkey3"];
	$grado = $ClsAcadem->decrypt($hashkey3, $usuario);
	$hashkey4 = $_REQUEST["hashkey4"];
	$seccion = $ClsAcadem->decrypt($hashkey4, $usuario);
	$hashkey5 = $_REQUEST["hashkey5"];
	$materia = $ClsAcadem->decrypt($hashkey5, $usuario);
	
	$result = $ClsPen->get_seccion($pensum,$nivel,$grado,$seccion);
	if(is_array($result)){
		foreach($result as $row){
			//nivel
			$nivel_desc = utf8_decode($row["niv_descripcion"]);
			//grado
			$grado_desc = utf8_decode($row["gra_descripcion"]);
			//descripcion
			$seccion_desc = utf8_decode($row["sec_descripcion"]);
		}	
	}
	
	$result = $ClsPen->get_materia($pensum,$nivel,$grado,$materia);
	if(is_array($result)){
		foreach($result as $row){
			//descripcion
			$materia_desc = utf8_decode($row["mat_descripcion"]);
		}	
	}
	
	if($unidad != ""){
		$combo_tema = tema_html($pensum,$nivel,$grado,$seccion,$materia,$unidad,"tema","Submit();");
	}else{
		$combo_tema = combos_vacios("tema");
	}
	
	
	
if($tipo_codigo != "" && $tipo_usuario != ""){ 	
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
	<link href="../assets.3.6.2/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
	
	<!-- Bootstrap Core CSS -->
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- MetisMenu CSS -->
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- DataTables CSS -->
	<link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">
	
	<!-- Sweet Alert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
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
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
                                    <a class="active" href="FRMlista_secciones.php?acc=gestor">
									<i class="fa fa-pencil"></i> Gestor de Evaluaciones
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
                                    <a href="FRMlista_secciones.php?acc=calificar">
									<i class="fa fa-paste"></i> Calificar Evaluaciones
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
                                    <a href="FRMlista_secciones.php?acc=ver">
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
				<div class="panel-heading"><i class="fa fa-edit"></i> <label>Gestor de Evaluaciones</label></div>
                <div class="panel-body">
				<form name = "f1" id = "f1" method="get">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<a href="javascript:void(0)" onclick="window.history.back();"><i class="fa fa-arrow-left text-info"></i> &nbsp; Regresar a Materias</a>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Grado:</label></div>
						<div class="col-xs-5"><label>Materia:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label class="text-info"><?php echo $grado_desc; ?> secci&oacute;n <?php echo $seccion_desc; ?></label></div>
						<div class="col-xs-5"><label class="text-info"><?php echo $materia_desc; ?></label></div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-1 col-xs-offset-1 text-info"><em>* Nota:</em></div>
						<div class="col-xs-10 text-muted"><em>Si la Evaluaci&oacute;n es global para la unidad, deje la casilla <label>"Tema"</label> vacia.</em></div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Unidad:</label> <span class = "text-danger">*</span></div>
						<div class="col-xs-5"><label>Tema:</label> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo unidades_html($nivel,'unidad','Submit();','',''); ?>
							<script>
								document.getElementById("unidad").value = '<?php echo $unidad; ?>';
							</script>
							<input type = "hidden" id="hashkey1" name = "hashkey1" value="<?php echo $hashkey1; ?>" />
							<input type = "hidden" id="hashkey2" name = "hashkey2" value="<?php echo $hashkey2; ?>" />
							<input type = "hidden" id="hashkey3" name = "hashkey3" value="<?php echo $hashkey3; ?>" />
							<input type = "hidden" id="hashkey4" name = "hashkey4" value="<?php echo $hashkey4; ?>" />
							<input type = "hidden" id="hashkey5" name = "hashkey5" value="<?php echo $hashkey5; ?>" />
							<input type = "hidden" id="pensum" name = "pensum" value="<?php echo $pensum; ?>" />
							<input type = "hidden" id="nivel" name = "nivel" value="<?php echo $nivel; ?>" />
							<input type = "hidden" id="grado" name = "grado" value="<?php echo $grado; ?>" />
							<input type = "hidden" id="seccion" name = "seccion" value="<?php echo $seccion; ?>" />
							<input type = "hidden" id="materia" name = "materia" value="<?php echo $materia; ?>" />
							<input type = "hidden" id="maestro" name = "maestro" value="<?php echo $tipo_codigo; ?>" />
							<input type = "hidden" id="codigo" name = "codigo" />
						</div>
						<div class="col-xs-5" id = "divtema">
							<?php echo $combo_tema; ?>
							<script>
								document.getElementById("tema").value='<?php echo $tema; ?>';
							</script>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>T&iacute;tulo:</label> <span class = "text-danger">*</span></div>
						<div class="col-xs-5"><label>Tipo de Soluci&oacute;n:</label> <span class = "text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "titulo" id = "titulo"  onkeyup = "texto(this)" value="<?php echo $titulo; ?>" />
						</div>	
						<div class="col-xs-5">
							<select class = "form-control" name = "tipo" id = "tipo">
								<option value = "">Seleccione</option>
								<option value = "OL">SE RESPONDER&Aacute; EN L&Iacute;NEA</option>
								<option value = "SR">SE CALIFICAR&Aacute; INDEPENDIENTE</option>
							</select>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Fecha y Hora de Inicio:</label></div>
						<div class="col-xs-5"><label>Fecha y Hora de Entrega:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-3 col-xs-offset-1">
							<div class="form-group" id="simpleini">
								<div class='input-group date'>
									<input type="text" class="form-control" id = "fecini" name="fecini" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<div class="input-group clockpickerini" data-autoclose="true">
									<input type="text" class="form-control" name = "horini" id = "horini" readonly >
									<span class="input-group-addon">
										<span class="fa fa-clock-o"></span>
									</span>
								</div>
							 </div>
						</div>
						<div class="col-xs-3">
							<div class="form-group" id="simplefin">
								<div class='input-group date'>
									<input type="text" class="form-control" id = "fecfin" name="fecfin" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<div class="input-group clockpickerfin" data-autoclose="true">
									<input type="text" class="form-control" name = "horfin" id = "horfin" readonly >
									<span class="input-group-addon">
										<span class="fa fa-clock-o"></span>
									</span>
								</div>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Tipo de Calificaci&oacute;n:</label> <span class = "text-danger">*</span></div>
						<div class="col-xs-2"><label>Repetir Examen:</label> <span class = "text-danger">*</span> </div>
						<div class="col-xs-3"><label>Autocalificar:</label><span class = "text-danger">*</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<select class = "form-control" name = "tipocalifica" id = "tipocalifica">
								<option value = "">Seleccione</option>
								<option value = "Z">Actividades (pruebas cortas)</option>
								<option value = "E">Evaluaciones (evaluaci&oacute;n peri&oacute;dica)</option>
							</select>
						</div>
						<div class="col-xs-2 ">
							<select class = "form-control" name = "repetir" id = "repetir">
								<option value = "">Seleccione</option>
								<option value = "1">SI</option>
								<option value = "2">NO</option>
							</select>
						</div>
						<div class="col-xs-3 ">
							<select class = "form-control" name = "acalificar" id = "acalificar">
								<option value = "">Seleccione</option>
								<option value = "1">SI</option>
								<option value = "2">NO</option>
							</select>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1"><label>Descripci&oacute;n:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<textarea class="form-control" id = "desc" name = "desc" rows="5" onkeyup="textoLargo(this)"></textarea>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" id = "limp" onclick = "window.location.reload();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" id = "gra" onclick = "Grabar();"><span class="fa fa-save"></span> Grabar</button>
							<button type="button" class="btn btn-primary hidden" id = "mod" onclick = "Modificar();"><span class="fa fa-save"></span> Grabar</button>
						</div>
					</div>
				</form>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-body">
					<?php
						echo tabla_examens('',$pensum,$nivel,$grado,$seccion,$materia,'','','','','');
					?>
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

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
	<!-- Clock picker -->
    <script src="../assets.3.6.2/js/plugins/clockpicker/clockpicker.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/academico/examen.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 50,
				responsive: true
			});
			
			$('#fecini').datetimepicker({
                format: 'DD/MM/YYYY'
            });
			$('#fecfin').datetimepicker({
                format: 'DD/MM/YYYY'
            });
			
			$('.clockpickerini').clockpicker();
			$('.clockpickerfin').clockpicker();
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