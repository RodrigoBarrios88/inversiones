<?php
	include_once('xajax_funct_boleta.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//$_Post
	$empresa = $_REQUEST["empresa"];
	$cue = $_REQUEST["cue"];
	$ban = $_REQUEST["ban"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	//--
	$empresa = ($empresa == "")?$empCodigo:$empresa;
	$ban = ($ban == "")?1:$ban;
	
if($pensum != "" && $nombre != ""){ 	
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
		<?php
		   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		   $xajax->printJavascript("..");
		 ?>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	
	<!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
	 <!-- Estilos Utilitarios -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
	
	<!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

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
                       <li>
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
								<a href="../CPBOLETAPROGRAMADOR/FRMnewconfiguracion.php">
									<i class="fa fa-check"></i> Configuraciones de Boletas
								</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="../CPBOLETAPROGRAMADOR/FRMsecciones.php">
										<i class="fa fa-calendar"></i> Programador de Boletas
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMsecciones.php?acc=GBOL">
										<i class="fa fa-edit"></i> Gestor de Boletas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["PAGOCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMsecciones.php?acc=GPAGO">
										<i class="fa fa-edit"></i> Gestor de Pagos Individuales
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="FRMcarga.php">
										<i class="fa fa-table"></i> Carga Electr&oacute;nica .CSV
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="FRMhistorial_cargas.php">
										<i class="fa fa-table"></i> Historial de Cargas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="FRMhistorial_csv.php">
										<i class="fa fa-file-excel-o"></i> Historial de .CSV
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
								<li>
									<a href="FRMmora.php">
										<i class="fa fa-clock-o"></i> Registro de Moras
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
									<li>
										<a class="active" href="FRMmoras.php">
											<i class="fa fa-edit"></i> Gestor de Moras
										</a>
									</li>
								<?php } ?>
								<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
								<li>
									<a href="FRMsecciones.php?acc=CUE">
										<i class="fa fa-money"></i> Estado de Cuenta
									</a>
								</li>
								<?php } ?>
								<hr>
								<li>
									<a href="../CPMENU/MENUcuenta.php">
										<i class="fa fa-indent"></i> Men&uacute;
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
				<div class="panel-heading"><i class="fa fa-pencil"></i> Gestor de Moras Activas (Moras generadas)</div>
                <div class="panel-body" id = "formulario">
					<form name = "f1" id = "f1" method="get">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Empresa:</label> <small class = " text-info">(Opcional)</small></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo empresa_html("empresa",""); ?>
						</div>
						<div class="col-xs-5">
							<a class="btn btn-default btn-block btn-md" href="FRMmora_grupos.php"> <i class="fa fa-copy"></i> Ver boletas de mora por grupos</a>
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Banco:</label> <small class = " text-info">(Opcional)</small></div>
						<div class="col-xs-5"><label>Cuenta de Banco:</label> <small class = " text-info">(Opcional)</small></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo banco_html("ban","Submit();"); ?>
							<input type = "hidden" name = "cod" id = "cod" />
							<script type="text/javascript">
								document.getElementById("ban").value = "<?php echo $ban; ?>";
							</script>
						</div>	
						<div class="col-xs-5" id = "scue">
							<?php
								if($ban != ""){
									echo cuenta_banco_html($ban,"cue","");
								}else{
									echo combos_vacios("cue");
								}
							?>
						</div>
						<script type="text/javascript">
							document.getElementById("cue").value = "<?php echo $cue; ?>";
						</script>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Nivel:</label> <span class = "text-danger">*</span></div>
						<div class="col-xs-5"><label>Grado:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php
								if($pensum != ""){
										echo nivel_html($pensum,"nivel","Submit();");;
								}else{
									echo combos_vacios("nivel");
								}	
							?>
							<?php if($nivel != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("nivel").value = '<?php echo $nivel; ?>';
							</script>
						<?php } ?>
						</div>
						<div class="col-xs-5">
							<?php if($pensum != "" && $nivel != ""){
									echo grado_html($pensum,$nivel,"grado","Submit();");
								}else{
									echo combos_vacios("grado");
								}	
							?>
							<?php if($grado != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("grado").value = '<?php echo $grado; ?>';
							</script>
							<?php } ?>
						</div>
                    </div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Secci&oacute;n:</label> <span class = "text-danger">*</span></div>
						<div class="col-xs-5"><label>Situaci&oacute;n:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php if($pensum != "" && $nivel != "" && $grado != ""){
									echo seccion_html($pensum,$nivel,$grado,"","seccion","Submit();");
								}else{
									echo combos_vacios("seccion");
								}	
							?>
							<?php if($seccion != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("seccion").value = '<?php echo $seccion; ?>';
							</script>
							<?php } ?>
						</div>
						<div class="col-xs-5">
							<select class="form-control" name="pagado" id="pagado">
								<option value="">TODAS</option>
								<option value="0">Pendientes de Pago</option>
								<option value="1">Pagadas</option>
							</select>
						</div>
					</div>
					<br>
					</form>
					<br>
					<div class="row">
                        <div class="col-xs-12 text-center">
							<a class="btn btn-default" href = "FRMmoras.php"><span class="fa fa-eraser"></span> Limpiar</a> 
                            <button type="button" class="btn btn-primary btn-outline" onclick = "Editar();"><span class="fa fa-pencil"></span> Gestor</button>
							<button type="button" class="btn btn-default" onclick = "Reporte();"><span class="fa fa-search"></span> Revisar</button> 
                        </div>
                    </div>
					<br>
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
		<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" width = "60px;" /> ASMS</h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<img src="../../CONFIG/images/img-loader.gif"/><br>
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

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/mora.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		function Editar(){
			empresa = document.getElementById("empresa");
			cuenta = document.getElementById("cue");
			banco = document.getElementById("ban");
			if(empresa.value !== "" || (cuenta.value != "" && banco.value != "")){
				myform = document.forms.f1;
				myform.action ="FRMmora_edit.php";
				myform.submit();
				myform.action ="";
				myform.target ="";
			}else{
				if(empresa.value ===""){
					empresa.className = "form-warning";
				}else{
					empresa.className = "form-control";
				}
				if(cuenta.value ===""){
					cuenta.className = "form-warning";
				}else{
					cuenta.className = "form-control";
				}
				if(banco.value ===""){
					banco.className = "form-warning";
				}else{
					banco.className = "form-control";
				}
				swal("Error","Debe Seleccione los filtros de consulta","warning");
			}
		}
		
		
		function Reporte(){
			empresa = document.getElementById("empresa");
			cuenta = document.getElementById("cue");
			banco = document.getElementById("ban");
			if(empresa.value !== "" || (cuenta.value != "" && banco.value != "")){
				myform = document.forms.f1;
				myform.target ="_blank";
				myform.action ="CPREPORTES/REPmoras.php";
				myform.submit();
				myform.action ="";
				myform.target ="";
			}else{
				if(empresa.value ===""){
					empresa.className = "form-info";
				}else{
					empresa.className = "form-control";
				}
				if(cuenta.value ===""){
					cuenta.className = "form-info";
				}else{
					cuenta.className = "form-control";
				}
				if(banco.value ===""){
					banco.className = "form-info";
				}else{
					banco.className = "form-control";
				}
				swal("Error","Debe Seleccione los filtros de consulta","info");
			}
		}
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