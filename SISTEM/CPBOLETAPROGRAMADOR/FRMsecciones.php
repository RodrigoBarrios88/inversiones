<?php
	include_once('xajax_funct_boleta.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	$pensum_vigente = $_SESSION["pensum"];
	//$_POST
	$pensum = $_REQUEST["pensum"];
	$pensum = ($pensum == "")?$pensum_vigente:$pensum;
	
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	
	$result_secciones = $ClsPen->get_seccion($pensum,'','','','',1);
	
	
if($id != "" && $nombre != ""){	
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
                       <li>
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
                                <li>
									<a href="FRMnewconfiguracion.php">
										<i class="fa fa-check"></i> Crear Configuraci&oacute;n
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMeditconfiguracion.php">
										<i class="fa fa-edit"></i> Actualizar Configuraci&oacute;n
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMsecciones.php">
										<i class="fa fa-calendar"></i> Programador de Boletas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMlista_inscripciones.php">
										<i class="fa fa-certificate"></i> Programador para Inscripciones
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="../CPBOLETA/FRMsecciones.php?acc=GBOL">
										<i class="fa fa-edit"></i> Gestor de Boletas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="../CPBOLETA/FRMcarga.php">
										<i class="fa fa-table"></i> Carga Electr&oacute;nica .CSV
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="../CPBOLETAFACTURAS/FRMlist_cargas.php">
										<i class="fa fa-file-text-o"></i> Facturas y Recibos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
								<li>
									<a href="../CPBOLETA/FRMsecciones.php?acc=CUE">
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
				<div class="panel-heading"> 
					<span class="fa fa-list-ol" aria-hidden="true"></span>
					Seleccione la Secci&oacute;n
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-6"><label>Ciclo Escolar:</label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<form id='f1' name='f1' method='get'>
							<input type="hidden" name = "acc" id = "acc" value="<?php echo $acc; ?>" />
							<?php echo pensum_html("pensum", "Submit();"); ?>
							<script type="text/javascript">
								document.getElementById("pensum").value = '<?php echo $pensum; ?>';
							</script>
							</form>
						</div>
						<div class="col-xs-6 text-right">
							<a class="btn btn-default" title="Limpiar" href = "FRMdirectorio.php?pensum=<?php echo $pensum; ?>"><span class="fa fa-group"></span> Directorio de Alumnos</a>
						</div>
					</div>
					<br>	
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
							<tr>
								<th width = "10px" class = "text-center">No.</td>
								<th width = "150px" class = "text-center">Nivel Educativo</td>
								<th width = "200px" class = "text-center">Grado y Secci&oacute;n</td>
								<th width = "100px" class = "text-center"><i class="fa fa-cogs"></i></td>
							</tr>
							</thead>
								<?php
									if(is_array($result_secciones)){
									$i = 1;
									$usu = $_SESSION["codigo"];
									foreach($result_secciones as $row){
										$hashkey1 = $ClsAcadem->encrypt($pensum, $usu);
										$nivel = $row["niv_codigo"];
										$hashkey2 = $ClsAcadem->encrypt($nivel, $usu);
										$grado = $row["gra_codigo"];
										$hashkey3 = $ClsAcadem->encrypt($grado, $usu);
										$seccion = $row["sec_codigo"];
										$hashkey4 = $ClsAcadem->encrypt($seccion, $usu);
										$nivel_desc = utf8_decode($row["niv_descripcion"]);
										$grado_desc = utf8_decode($row["gra_descripcion"]);
										$seccion_desc = utf8_decode($row["sec_descripcion"]);
										$salida.= '<tr>';
										//No.
										$salida.= '<td class = "text-center">'.$i.'. </td>';
										//nivel
										$salida.= '<td class = "text-left">'.$nivel_desc.'</td>';
										//grado
										$salida.= '<td class = "text-left">'.$grado_desc.' '.$seccion_desc.'</td>';
										//boton
										$salida.= '<td class = "text-center">';
										$salida.= '<a class="btn btn-primary btn-block" href="FRMlistalumno.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&hashkey3='.$hashkey3.'&hashkey4='.$hashkey4.'" title = "Seleccionar Secci&oacute;n" ><i class="fa fa-arrow-right "></i></a>';
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
			<!-- /.panel-default -->
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/configuracion.js"></script>
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