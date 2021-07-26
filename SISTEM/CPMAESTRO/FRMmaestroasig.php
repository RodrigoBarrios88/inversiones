<?php
	include_once('xajax_funct_maestro.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	$pensum_session = $_SESSION["pensum"];
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	$tipoAsi = $_REQUEST["tipoAsi"];
	$area = $_REQUEST["area"];
	$pensum = $_REQUEST["pensum"];
	$pensum = ($pensum == "")?$pensum_session:$pensum;
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$tipo = $_REQUEST["tipo"];
	$seccion = $_REQUEST["seccion"];
	
	$ClsMae = new ClsMaestro();
	$ClsAsi = new ClsAsignacion();
	$ClsAcadem = new ClsAcademico();
	$cui = $ClsMae->decrypt($hashkey, $usuario);
	
	$result = $ClsMae->get_maestro($cui,'','',1);
	if(is_array($result)){
		
		foreach($result as $row){
			$cui = $row["mae_cui"];
			$nombre = utf8_decode($row["mae_nombre"])." ".utf8_decode($row["mae_apellido"]);
			$mail = $row["mae_mail"];
		}
	}
	
	
	
if($usuario != "" && $nombre != ""){ 	
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
	<!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Dual Listbox -->
	<link rel="stylesheet" type="text/css" href="../assets.3.6.2/css/plugins/dualListbox/bootstrap-duallistbox.css">
    
    <!-- CSS personalizado -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">
	
	<!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body onload="Tipo_Asignacion('<?php echo $tipoAsi; ?>');">
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
                        <li><a href="../logout.php"><i class="glyphicon glyphicon-off fa-fw"></i> Salir</a></li>
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
                                <?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
                                <li>
									<a href="FRMnewmaestro.php">
										<i class="fa fa-user"></i> Gestor de Maestros
									</a>
                                </li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMmaestro.php">
										<i class="fa fa-list-ol"></i> Listar Maestros
									</a>
                                </li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a class="active" href="FRMlistmaestro.php">
										<i class="fa fa-link"></i> Asignaci&oacute;n de Maestros
									</a>
                                </li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMlist_curso.php">
										<i class="fa fa-link"></i> Asignaci&oacute;n a Cursos Libres
									</a>
                                </li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMlistmaestro_desasig.php">
										<i class="fa fa-unlink"></i> Desasignaci&oacute;n por Secci&oacute;n
									</a>
                                </li>
								<?php } ?>
								<hr>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="CPREPORTES/FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Maestros
									</a>
                                </li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="CPREPORTES/FRMrepmaestro.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Asignaciones
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
					<i class="fa fa-tags"></i> Asignaci&oacute;n de Maestros a Grupo, Materias, Grados y Secciones
				</div>
                <div class="panel-body">
					<form name = "f1" id = "f1" method="get">
						<div class="row">
							<div class="col-xs-12 col-xs-12 text-right"><label class = " text-danger">* Campos Obligatorios</label> <label class = " text-info">* Campos de Busqueda</label></div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<label>Nombre y Apellido:</label> <span class="text-danger">*</span> <span class="text-info">*</span>
								<span class = "form-info"><?php echo $nombre; ?></span>
								<input type = "hidden" name = "cui" id = "cui" value = "<?php echo $cui; ?>" />
								<input type = "hidden" name = "hashkey" id = "hashkey" value = "<?php echo $hashkey; ?>" />
							</div>
							<div class="col-xs-5">
								<label>e-mail:</label> <span class="text-danger">*</span> <span class="text-info">*</span>
								<span class = "form-info"><?php echo $mail; ?></span>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<label>T&iacute;po de Asignaci&oacute;n:</label>  <span class="text-danger">*</span> <span class="text-info">*</span>
								<select class = "form-control" name = "tipoAsi" id = "tipoAsi" onchange="Submit();">
									<option value = "">Seleccione</option>
									<option value = "1">GRADOS Y SECCIONES</option>
									<option value = "2">MATERIAS</option>
									<option value = "3">GRUPOS</option>
								</select>
								<script type = "text/javascript">
									document.getElementById("tipoAsi").value = '<?php echo $tipoAsi; ?>';
								</script>
							</div>
							<div class="col-xs-5">
								<label>&Aacute;rea:</label>  <span class="text-danger">*</span> <span class="text-info">*</span>
								<?php echo Area_html("area","Submit();"); ?>
								<script type = "text/javascript">
									document.getElementById("area").value = '<?php echo $area; ?>';
								</script>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<label>Programa Acad&eacute;mico:</label>
								<?php echo pensum_html("pensum","Submit();"); ?>
								<?php if($pensum != ""){ ?>
								<script type = "text/javascript">
									document.getElementById("pensum").value = '<?php echo $pensum; ?>';
								</script>
								<?php } ?>
							</div>
							<div class="col-xs-5">
								<label>Nivel:</label>
								<div id = "divnivel">
								<?php if($pensum != ""){
									echo nivel_html($pensum,"nivel","Submit();");
								?>
								<script type = "text/javascript">
									document.getElementById("nivel").value = '<?php echo $nivel; ?>';
								</script>
								<?php
									}else{
										echo combos_vacios("nivel");
									}	
								?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<label>Grado de los Alumnos:</label>
								<div id = "divgrado">
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
							</div>
							<div class="col-xs-5">
								<label>T&iacute;po:</label>
								<select id = "tipo" name = "tipo" class = "form-control">
									<option value = "">Selecciones</option>
									<option value = "1">Materia exigida por MINEDUC (Tarjeta de Calificaciones)</option>
									<option value = "0">Materia del Pensum interno del Colegio (No valida para MINEDUC)</option>
								</select>
								<?php if($tipo != ""){ ?>
								<script type = "text/javascript">
									document.getElementById("tipo").value = '<?php echo $tipo; ?>';
								</script>
								<?php } ?>
							</div>
						</div>
					</form>
					<hr>
					<form id="form" action="#" class="wizard-big">
						<div class="row">
							<div class="col-lg-10 col-xs-offset-1">
							<?php
								if($tipoAsi == 3){
									$ClsGruCla = new ClsGrupoClase();
									if($area != ""){
										$result_lista = $ClsGruCla->get_grupo_clase("","",$area,"",1);
										$result = $ClsAsi->get_maestro_grupo("",$cui,1);
										if(is_array($result)){
										   $i = 0;
										   foreach($result as $row){
											  $arrseleccionado[$i] = $row["gru_codigo"];
											  $i++;
										   }
										   $cantidad_seleccionado = $i;
										}
									}else{
										$result = "";
										$result_lista = "";
										$cantidad_seleccionado = 0;
									}
								}else if($tipoAsi == 2){
									if($pensum != ""){
										$ClsPen = new ClsPensum();
										$ClsAcadem = new ClsAcademico();
										$result_lista = $ClsPen->get_materia($pensum,$nivel,$grado,"",$tipo,1);
										$result = $ClsAcadem->comprueba_materia_maestro($pensum,$nivel,$grado,"",$cui,$tipo);
										if(is_array($result)){
										   $i = 0;
										   foreach($result as $row){
											  $arrseleccionado[$i] = $row["mat_pensum"]."|".$row["mat_nivel"]."|".$row["mat_grado"]."|".$row["mat_codigo"];
											  $i++;
										   }
										   $cantidad_seleccionado = $i;
										}
									}else{
										$result = "";
										$result_lista = "";
										$cantidad_seleccionado = 0;
									}
								}else if($tipoAsi == 1){
									if($pensum != ""){
										$ClsPen = new ClsPensum();
										$ClsAcadem = new ClsAcademico();
										$result_lista = $ClsPen->get_seccion($pensum,$nivel,$grado,"",$tipo,1);
										$result = $ClsAcadem->comprueba_seccion_maestro($pensum,$nivel,$grado,"",$cui,$tipo);
										if(is_array($result)){
										   $i = 0;
										   foreach($result as $row){
											  $arrseleccionado[$i] = $row["sec_pensum"]."|".$row["sec_nivel"]."|".$row["sec_grado"]."|".$row["sec_codigo"];
											  $i++;
										   }
										   $cantidad_seleccionado = $i;
										}
									}else{
										$result = "";
										$result_lista = "";
										$cantidad_seleccionado = 0;
									}
								}else{
									$result = "";
									$result_lista = "";
									$cantidad_seleccionado = 0;
								}	
							?>
								<select class="form-control dual_select"  name="duallistbox1[]" multiple >
							<?php
								if(is_array($result_lista)){
									foreach($result_lista as $row){
										if($tipoAsi == 3){
											$cod = $row["gru_codigo"];
											$nom = utf8_decode($row["gru_nombre"]);
										}else if($tipoAsi == 2){
											$cod = $row["mat_pensum"]."|".$row["mat_nivel"]."|".$row["mat_grado"]."|".$row["mat_codigo"];
											$nom = utf8_decode($row["mat_descripcion"])." - ".utf8_decode($row["gra_descripcion"]);
										}else if($tipoAsi == 1){
											$cod = $row["sec_codigo"];
											$cod = $row["sec_pensum"]."|".$row["sec_nivel"]."|".$row["sec_grado"]."|".$row["sec_codigo"];
											$nom = utf8_decode($row["gra_descripcion"])." ".utf8_decode($row["sec_descripcion"]);
										}	
										$chk = "";
										//echo "$cantidad_seleccionado";
										for($i = 0; $i < $cantidad_seleccionado; $i++){
											//echo "$cod == ".$arrempresaes[$i]."<br>";
											if($cod == $arrseleccionado[$i]){
												$chk = "selected";
												break;
											}
										}
										echo '<option value="'.$cod.'" '.$chk.'>'.$nom.'</option>';
									}
								}else{
									echo '<option value="">No hay sedes registradas...</option>';
								}
							?>
								</select>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1 text-center">
								<button type="submit" class="btn btn-block btn-primary"><span class="fa fa-save"></span> Grabar</button>
							</div>
						</div>
					</form>
                </div>
				<!-- /.panel-body -->
            </div>
            <!-- /.panel-default -->
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
    <script src="../assets.3.6.2/js/core/jquery.min.js"></script>
    
	<!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- Dual List Box -->
    <script src="../assets.3.6.2/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js"></script>
	
	<!-- Metis Menu Plugin JavaScript -->
    <script src="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/app/maestro.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		var dual = $('select[name="duallistbox1[]"]').bootstrapDualListbox();
		$("#form").submit(function() {
			Asigna_Trabajo_Maestro($('[name="duallistbox1[]"]').val());
			return false;
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