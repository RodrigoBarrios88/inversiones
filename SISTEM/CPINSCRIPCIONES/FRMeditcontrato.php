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
			//-- DATOS DEL CONTRATO
			$result2 = $ClsIns->get_status($cuinew);
			if(is_array($result2)){
				foreach($result2 as $row2){
					$contrato = $row2["stat_contrato"];
					$contradpi = utf8_decode($row2["stat_dpi_firmante"]);
					$contratipodpi = trim($row2["stat_tipo_dpi"]);
					$contranombre = utf8_decode($row2["stat_nombre"]);
					$contraapellido = utf8_decode($row2["stat_apellido"]);
					$contrafecnac = cambia_fecha($row2["stat_fec_nac"]);
					//--
						$contrafecnacdia = substr($contrafecnac, 0, 2);
						$contrafecnacmes = substr($contrafecnac, 3, 2);
						$contrafecnacanio = substr($contrafecnac, 6, 4);
					//--
					$contraedad = Calcula_Edad(cambia_fecha($row2["stat_fec_nac"]));
					$contraparentesco = trim($row2["stat_parentesco"]);
					$contraecivil = trim($row2["stat_estado_civil"]);
					$contranacionalidad = strtolower($row2["stat_nacionalidad"]);
					$contramail = strtolower($row2["stat_mail"]);
					$contradireccion = utf8_decode($row2["stat_direccion"]);
					$contradep = utf8_decode($row2["stat_departamento"]);
					$contramun = utf8_decode($row2["stat_municipio"]);
					$contratelcasa = $row2["stat_telefono"];
					$contracelular = $row2["stat_celular"];
					$contratrabajo = utf8_decode($row2["stat_lugar_trabajo"]);
					$contrateltrabajo = $row2["stat_telefono_trabajo"];
					$contraprofesion = utf8_decode($row2["stat_profesion"]);
				}
			}
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
	
	<!-- Bootstrap Core CSS -->
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
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
					<i class="fa fa-edit"></i> Corregir Informaci&oacute;n del Firmante del Contrato
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
						<div class="col-lg-4 col-lg-offset-1"><label>Alumno:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input type="text" class="form-info" id = "cuinew" name = "cuinew" value="<?php echo $cuinew; ?>" readonly />
							<label class="form-info"><?php echo trim($nombre); ?> <?php echo trim($apellido); ?></label>
							<input type="hidden" id = "contrato" name = "contrato" value="<?php echo $contrato; ?>" />
						</div>
					</div>
					<hr>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>DPI del Firmante:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "contradpi" name = "contradpi" value="<?php echo $contradpi; ?>" onkeyup = "enterosExtremos(this);" maxlength = "13" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Tipo de ID del Firmante:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<select class="form-control" id = "contratipodpi" name = "contratipodpi" >
								<option value = "">Seleccione</option>
								<option value = "DPI">DPI</option>
								<option value = "PASAPORTE">PASAPORTE</option>
							</select>
							<script>
								document.getElementById("contratipodpi").value = '<?php echo $contratipodpi; ?>';
							</script>
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Nombres:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "contranombre" name = "contranombre" value="<?php echo $contranombre; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Apellidos:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "contraapellido" name = "contraapellido" value="<?php echo $contraapellido; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Fecha de Nacimiento:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<div class='input-group date'>
								<?php echo input_fecha("contrafecnac","valida_fecha('contrafecnac');"); ?>
								<script>
									document.getElementById("contrafecnac").value = '<?php echo $contrafecnac; ?>';
									document.getElementById("contrafecnacdia").value = '<?php echo $contrafecnacdia; ?>';
									document.getElementById("contrafecnacmes").value = '<?php echo $contrafecnacmes; ?>';
									document.getElementById("contrafecnacanio").value = '<?php echo $contrafecnacanio; ?>';
								</script>
								<span class="input-group-addon">
									&nbsp; <span class="fa fa-calendar"></span> &nbsp;
								</span>
							</div>
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Parentesco con el alumno:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<select class="form-control" name = "contraparentesco" id = "contraparentesco" >
								<option value = "">Seleccione</option>
								<option value = "P">PADRE</option>
								<option value = "M">MADRE</option>
								<option value = "A">ABUELO(A)</option>
								<option value = "O">ENCARGADO</option>
							</select>
							<script>
								document.getElementById("contraparentesco").value = '<?php echo $contraparentesco; ?>';
							</script>
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Estado Civil:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<select class="form-control" name = "contraecivil" id = "contraecivil" >
								<option value = "">Seleccione</option>
								<option value = "S">SOLTERO(A)</option>
								<option value = "C">CASADO(A)</option>
							</select>
							<script>
								document.getElementById("contraecivil").value = '<?php echo $contraecivil; ?>';
							</script>
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Nacionalidad del Firmante:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "contranacionalidad" name = "contranacionalidad" value="<?php echo $contranacionalidad; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>E-mail:</label> </div>
						<div class="col-lg-6">
							<input class="form-control text-libre" type="text" id = "contramail" name = "contramail" value="<?php echo $contramail; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Direcci&oacute;n:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "contradireccion" name = "contradireccion" value="<?php echo $contradireccion; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Departamento:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<?php echo departamento_html("contradep","xajax_depmun(this.value,'contramun','contradivmun');"); ?>
							<script>
								document.getElementById("contradep").value = '<?php echo $contradep; ?>';
							</script>
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Municipio:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6" id = "contradivmun">
							<?php
								$tempdep = ($contradep != "")?$contradep:100;
								echo municipio_html($tempdep,"contramun","");
							?>
							<script>
								document.getElementById("contramun").value = '<?php echo $contramun; ?>';
							</script>
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Tel&eacute;fono Casa:</label> </div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "contratelcasa" name = "contratelcasa" value="<?php echo $contratelcasa; ?>" onkeyup="enteros(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Celular:</label> </div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "contracelular" name = "contracelular" value="<?php echo $contracelular; ?>" onkeyup="enteros(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Lugar de Trabajo:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "contratrabajo" name = "contratrabajo" value="<?php echo $contratrabajo; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Tel&eacute;fono de Trabajo:</label> </div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "contrateltrabajo" name = "contrateltrabajo" value="<?php echo $contrateltrabajo; ?>" onkeyup="enteros(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Profesi&oacute;n u Oficio:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "contraprofesion" name = "contraprofesion" value="<?php echo $contraprofesion; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<br>
					<div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="button" class="btn btn-default" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
                            <button type="button" class="btn btn-primary" onclick = "ActualizaContrato();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
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