<?php
	include_once('xajax_funct_rrhh.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	
	$ClsOrg = new ClsOrganizacion();
	$hashkey = $_REQUEST["hashkey"];
	$plaza = $ClsOrg->decrypt($hashkey,$id);
	$result = $ClsOrg->get_plaza($plaza,'','','','','','','',1);
	if(is_array($result)){
		foreach($result as $row){
			$codigo = $row["plaz_codigo"];
			$plaza = Agrega_Ceros($codigo);
			$suc = trim($row["dep_sucursal"]);
			//--
			$dpi = trim($row["org_personal"]);
			$nombres = utf8_decode($row["plaz_personal_nombres"]);
			$empleo = utf8_decode($row["plaz_desc_lg"]);
			$departamento = utf8_decode($row["dep_desc_lg"]);
			$nombres = ($nombres == "")?$empleo:$nombres;
			
			if (file_exists ('../../CONFIG/Fotos/RRHH/'.$dpi.'.jpg')){ /// valida que tenga foto registrada
				$foto = 'RRHH/'.$dpi.'.jpg';
			}else{
				$foto = 'RRHH/nofoto.png';
			}
		}
	}
	
	//---$_POST
	$gru = $_REQUEST["gru"];
	$art = $_REQUEST["art"];
	
	
if($id != "" && $nombre != ""){ 	
?>
<!DOCTYPE html>
<html lang="es">
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
								<?php if($_SESSION["NEWRRHH"] == 1){ ?>
                                <li>
									<a href="FRMformulario.php">
										<i class="glyphicon glyphicon-file"></i> Nuevo Formulario
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["UPDRRHH"] == 1){ ?>
								<li>
									<a href="FRMbuscar.php">
										<i class="fa fa-search"></i> Busqueda de Personal
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["REPCARNE"] == 1){ ?>
								<li>
									<a href="FRMcarne.php">
										<i class="fa fa-credit-card"></i> Generador de Carn&eacute;
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["REPCARNE"] == 1){ ?>
								<li>
									<a href="FRMlistplazas.php">
										<i class="fa fa-file-text-o"></i> Tarjeta de Responsabilidad
									</a>
								</li>
								<?php } ?>
								<li>
									<a href="../CPMENU/MENUadministrativo.php">
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
				<div class="panel-heading"><label><i class="fa fa-file-text-o"></i>  Gestor de Tarjetas de Responsabilidad</label></div>
                <div class="panel-body" id = "formulario">
					<form id='f1' name='f1' method='get'>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>DPI:</label></div>
						<div class="col-xs-5"><label>Colaborador:</label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label class="form-info"><?php echo $dpi; ?></label>
							<input type="hidden" id="dpi" name="dpi" value="<?php echo $dpi; ?>" />
							<input type="hidden" id="codigo" name="codigo" value="<?php echo $codigo; ?>" />
							<input type = "hidden" name = "suc" id = "suc" value="<?php echo $suc; ?>" />
							<input type="hidden" id="hashkey" name="hashkey" value="<?php echo $hashkey; ?>" />
						</div>
						<div class="col-xs-5">
							<label class="form-info"><?php echo $nombres; ?></label>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Departamento:</label></div>
						<div class="col-xs-5"><label>Empleao:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label class="form-info"><?php echo $departamento; ?></label>
						</div>
						<div class="col-xs-5" id = "scue">
							<label class="form-info"><?php echo $empleo; ?></label>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Grupo:</label></div>
						<div class="col-xs-5"><label>Art&iacute;culo:</label></div>
					</div>
					<div class="row">
                        <div class="col-xs-5 col-xs-offset-1">
							<?php echo grupo_articulo_propio_html("gru","Submit();"); ?>
							<script type="text/javascript">
								document.getElementById('gru').value = '<?php echo $gru; ?>';
							</script>
						</div>
                        <div class="col-xs-5">
							<?php
								if($gru == ""){
									echo combos_vacios("art");
								}else{
									echo articulo_propio_html($gru,"art","Submit();");
								}
							?>
							<script type="text/javascript">
							document.getElementById('art').value = '<?php echo $art; ?>';
							</script>
						</div>
                    </div>
					<br>
					<div class="row">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <a type="button" class="btn btn-default" title="Limpiar" href = "FRMboleta.php?hashkey=<?php echo $hashkey; ?>"><span class="fa fa-eraser"></span> Limpiar</a>
                                <button type="button" class="btn btn-primary" id = "grab" onclick = "Asignar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
                                <button type="button" class="btn btn-default" title="Imprimir Todas las Tarjeta" onclick = "PrintTarjeta();"><span class="glyphicon glyphicon-print"></span> Tarjeta</button>
                            </div>
                        </div>
                    </div>
					</form>
					<br>
					<br>
					<div class="row">
						<div class="col-lg-12" id = "result">
							<?php //echo tabla_maquinaria_equipo($codigo); ?>
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
		<h4 class="modal-title" id="myModalLabel"><img src = "../../CONFIG/images/escudo.png" width = "40px;" /> ASMS</h4>
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

    
    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/rrhh/rrhh.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				responsive: true
			});
	    });
	
		
		function PrintTarjeta(){
			myform = document.forms.f1;
			myform.target ="_blank";
			myform.action ="CPREPORTES/REPtarjeta.php";
			myform.submit();
			myform.action ="";
			myform.target ="";
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