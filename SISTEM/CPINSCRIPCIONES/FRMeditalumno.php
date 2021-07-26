<?php
	include_once('xajax_funct_inscripciones.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo = $_SESSION["nivel"];
	// $_POST
	$cui = $_REQUEST["cui"];
	
	$ClsIns = new ClsInscripcion();
	$ClsCli = new ClsCliente();
	$ClsAsi = new ClsAsignacion();
	$ClsSeg = new ClsSeguro();
	
	/////////// VALIDA SI YA ACTUALIZÓ O AUN NO ////////////
	// si está inscrito
	$i = 1;
	$result = $ClsIns->get_alumno($cui);
	if(is_array($result)){
		foreach($result as $row){
			$cuinew = trim($row["alu_cui_new"]);
			$cuiold = trim($row["alu_cui_old "]);
			$codigo = trim($row["alu_codigo_interno"]);
			$tipocui = trim($row["alu_tipo_cui"]);
			//pasa a mayusculas
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			//--------
			$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
			//--
				$fecnacdia = substr($fecnac, 0, 2);
				$fecnacmes = substr($fecnac, 3, 2);
				$fecnacanio = substr($fecnac, 6, 4);
			//--
			$edad = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
			$genero = trim($row["alu_genero"]);
			$nacionalidad = utf8_decode($row["alu_nacionalidad"]);
			$religion = utf8_decode($row["alu_religion"]);
			$idioma = utf8_decode($row["alu_idioma"]);
			$mail = trim($row["alu_mail"]);
			$cli = trim($row["alu_cliente_factura"]);
			//--
			$sangre = trim($row["alu_tipo_sangre"]);
			$alergico = utf8_decode($row["alu_alergico_a"]);
			$emergencia = utf8_decode($row["alu_emergencia"]);
			$emertel = trim($row["alu_emergencia_telefono"]);
			$i++;
		}
		$i--;
	}
	
if($tipo != "" && $nombre != ""){ 	
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
	
	<!-- Social Buttons CSS -->
    <link href="../assets.3.6.2/bower_components/bootstrap-social/bootstrap-social.css" rel="stylesheet">
	
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
                                <?php if($_SESSION["BOLINSCRIP"] == 1){ ?>
                                <li>
									<a href="FRMimpresion_boletas.php">
										<i class="fa fa-print"></i> Impresi&oacute;n de Boletas de Inscripci&oacute;n
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["BOLINSCRIP"] == 1){ ?>
                                <li>
									<a href="FRMboletas.php">
										<i class="fa fa-money"></i> Recepci&oacute;n de Boletas de Inscripci&oacute;n
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["APROVCON"] == 1){ ?>
								<li>
									<a class="active" href="FRMaprobacion.php">
										<i class="fa fa-file-text-o"></i> Abrobaci&oacute;n de Contratos
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["RECEPCON"] == 1){ ?>
								<li>
									<a href="FRMrecepcion.php">
										<i class="fa fa-inbox"></i> Recepci&oacute;n de Contratos
									</a>
                                </li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="FRMblacklist.php">
										<i class="fa fa-ban"></i> Listas Reservada
									</a>
                                </li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMdatos_actualizados.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Datos Actualizados
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMboletas_giradas.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Boletas en Circulaci&oacute;n
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMboletas_aprobadas.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Boletas Pagadas
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMcontratos_aprobados.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Contratos Aprobados
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte General del Proceso
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
					<i class="fa fa-edit"></i> Corregir Informaci&oacute;n del Alumno (para el siguiente ciclo)
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-5 col-lg-offset-1 col-xs-6">
							<button type ="button" class="btn btn-defaul" onclick="window.history.back();">
								<i class="fa fa-chevron-left"></i> Regresar al men&uacute;
							</button>
						</div>
						<div class="col-xs-5 col-xs-6 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<br>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>CUI (Identificaci&oacute;n):</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input type="text" class="form-control" id = "cuinew" name = "cuinew" value="<?php echo $cuinew; ?>" readonly />
							<input type="hidden" id = "cuiold" name = "cuiold" value="<?php echo $cuiold; ?>" />
							<input type="hidden" id = "codigo" name = "codigo" value="<?php echo $codigo; ?>" />
						</div>
						<div class="col-lg-1">
							<?php
								if($cuinew != ""){
									$usuario = $_SESSION["codigo"];
									$hashkey = $ClsIns->encrypt($cuinew, $usuario);
									$disabled = "";
								}else{
									$hashkey = "";
									$disabled = "disabled";
								}
							?>
							<a class="btn btn-warning" href="FRMeditCUI.php?hashkey=<?php echo $hashkey; ?>" data-toggle="tooltip" data-placement="left" title="Cambiar o modificar el CUI del Alumno" <?php echo $disabled; ?> >
								<i class="fa fa-pencil"></i>
							</a>
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Tipo de ID:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<select class="form-control" id = "tipocui" name = "tipocui" >
								<option value = "">Seleccione</option>
								<option value = "CUI">CUI</option>
								<option value = "PASAPORTE">PASAPORTE</option>
							</select>
							<script>
								document.getElementById("tipocui").value = '<?php echo $tipocui; ?>';
							</script>
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Nombres:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "nombre" name = "nombre" value="<?php echo $nombre; ?>" onkeyup="texto(this);" />    
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Apellidos:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "apellido" name = "apellido" value="<?php echo $apellido; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Genero:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<select class="form-control" id = "genero" name = "genero" >
								<option value = "">Seleccione</option>
								<option value = "M">Ni&ntilde;o (M)</option>
								<option value = "F">Ni&ntilde;a (F)</option>
							</select>
							<script>
								document.getElementById("genero").value = '<?php echo $genero; ?>';
							</script>
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Fecha de Nacimiento:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<div class='input-group date'>
								<?php echo input_fecha("fecnac","valida_fecha('fecnac');"); ?>
								<script>
									document.getElementById("fecnac").value = '<?php echo $fecnac; ?>';
									document.getElementById("fecnacdia").value = '<?php echo $fecnacdia; ?>';
									document.getElementById("fecnacmes").value = '<?php echo $fecnacmes; ?>';
									document.getElementById("fecnacanio").value = '<?php echo $fecnacanio; ?>';
								</script>
								<span class="input-group-addon">
									&nbsp; <span class="fa fa-calendar"></span> &nbsp;
								</span>
							</div>
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Edad:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "edad" name = "edad" value="<?php echo $edad; ?> A&Ntilde;O(S)" readonly />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Nacionalidad:</label> </div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "nacionalidad" name = "nacionalidad" value="<?php echo $nacionalidad; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Religi&oacute;n:</label> </div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "religion" name = "religion" value="<?php echo $religion; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Idioma Nativo :</label> </div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "idioma" name = "idioma" value="<?php echo $idioma; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Email del Alumno: <small class="text-muted">(no aplica para preescolar)</small> </label> </div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "mail" name = "mail" value="<?php echo $mail; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>T&iacute;po de Sangre:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<select class="form-control" id = "sangre" name = "sangre" onchange="CompareCodigoBloqueado();" >
								<option value = "">Seleccione</option>
								<option value = "O+">O Rh +</option>
								<option value = "O-">O Rh -</option>
								<option value = "A+">A Rh +</option>
								<option value = "A-">A Rh -</option>
							   <option value = "B+">B Rh +</option>
							   <option value = "B-">B Rh -</option>
							   <option value = "AB+">AB Rh +</option>
							   <option value = "AB-">AB Rh -</option>
							</select>
							<script>
								document.getElementById("sangre").value = '<?php echo $sangre; ?>';
							</script>
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Al&eacute;rgico A:</label> &nbsp;</div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "alergico" name = "alergico" value="<?php echo $alergico; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>En una emergencia avisar a:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "emergencia" name = "emergencia" value="<?php echo $emergencia; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Telefono de emergencia:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control text-libre" type="text" id = "emertel" name = "emertel" value="<?php echo $emertel; ?>" onkeyup="enteros(this);" />
						</div>
					</div>
					<br>
					<div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="button" class="btn btn-default" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
                            <button type="button" class="btn btn-primary" onclick = "ActualizaAlumno();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
                        </div>
                    </div>
					<br>
				</div>
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/inscripcion/modificaciones.js"></script>
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
	//echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>