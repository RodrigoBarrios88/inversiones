<?php
	include_once('xajax_funct_chat.php');
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
	
	$ClsChat = new ClsChat();
	$ClsAsi = new ClsAsignacion();
	$ClsAcadem = new ClsAcademico();
	$cui = $ClsChat->decrypt($hashkey, $usuario);
	
	$result = $ClsChat->get_cm($cui);
	if(is_array($result)){
		
		foreach($result as $row){
			$cui = $row["cm_cui"];
			$nombre = utf8_decode($row["cm_nombre"]);
			$mail = $row["cm_mail"];
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
									<a href="FRMusuario.php">
										<i class="fa fa-user"></i> Gestor de Usuarios
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a class="active" href="FRMusuarios.php">
										<i class="fa fa-link"></i> Asignaci&oacute;n de Usuarios
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="CPREPORTES/FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Usuarios
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="CPREPORTES/FRMrepasignacion.php">
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
					<i class="fa fa-tags"></i> Asignaci&oacute;n de Usuarios CM a Grados de Responsabilidad
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
					</form>
					<hr>
					<form id="form" action="#" class="wizard-big">
						<div class="row">
							<div class="col-lg-10 col-xs-offset-1">
							<?php
								if($pensum != ""){
									$ClsPen = new ClsPensum();
									$result_lista = $ClsPen->get_grado($pensum,$nivel,"",1);
									$result = $ClsChat->get_grado_usuarios($pensum,$nivel,$grado,$cui);
									if(is_array($result)){
									   $i = 0;
									   foreach($result as $row){
										  $arrseleccionado[$i] = $row["gra_nivel"]."|".$row["gra_codigo"];
										  $i++;
									   }
									   $cantidad_seleccionado = $i;
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
										$codigo = $row["gra_nivel"]."|".$row["gra_codigo"];
										$nombre = utf8_decode($row["niv_descripcion"])." ".utf8_decode($row["gra_descripcion"]);
										$chk = "";
										//echo "$cantidad_seleccionado";
										for($i = 0; $i < $cantidad_seleccionado; $i++){
											//echo "$cod == ".$arrempresaes[$i]."<br>";
											if($codigo == $arrseleccionado[$i]){
												$chk = "selected";
												break;
											}
										}
										echo '<option value="'.$codigo.'" '.$chk.'>'.$nombre.'</option>';
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/app/cm.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		var dual = $('select[name="duallistbox1[]"]').bootstrapDualListbox();
		$("#form").submit(function() {
			Asigna_Grado_Usuario($('[name="duallistbox1[]"]').val());
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