<?php
	include_once('xajax_funct_articulos.php');
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$margen = $_SESSION["margenutil"];
	$valida = $_SESSION["GRP_GPADMON"];
	//-- $_POST
	$anio = $_REQUEST["anio"];
	//----- Obtiene la ultima depreciacion Calculada ----//
	$ClsArt = new ClsArticuloPropio();
	if($anio == ""){ // Si no viene vacio, viene un post 
		$anio = $ClsArt->max_anio_depreciacion();
	}
	$anio = ($anio == "")? date("Y"):$anio; // si viene vacio por el post o por la consulta, entonces llena con el año actual
	$mes = $ClsArt->max_mes_depreciacion($anio);
	//calcula cual debe ser la siguiente
	$mes++;
	if($mes > 12){
		$anio++;
		$mes = 1;
	}
	
if($pensum != "" && $nombre != "" && $valida != ""){	
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
	
	<!-- Inpuut File Uploader libs -->
	<link href="../assets.3.6.2/bower_components/bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
	<script src="../assets.3.6.2/bower_components/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
	<script src="../assets.3.6.2/bower_components/bootstrap-fileinput/js/fileinput_locale_fr.js" type="text/javascript"></script>
	<script src="../assets.3.6.2/bower_components/bootstrap-fileinput/js/fileinput_locale_es.js" type="text/javascript"></script>
	
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
                               <?php if($_SESSION["GGRUPARTP"] == 1){ ?>
								<li>
									<a href="FRMgrupos.php">
									<i class="fa fa-th"></i> Gestor de Grupos
									</a>
                                </li>
                                <?php } ?>
								<?php if($_SESSION["GARTP"] == 1){ ?>
								<li>
									<a href="FRMarticulos.php">
									<i class="fa fa-desktop"></i> Gestor de Mobiliario y Equipo
									</a>
                                </li>
                                <?php } ?>
								<hr>
								<?php if($_SESSION["INVRCARP"] == 1){ ?>
								<li>
									<a href="FRMcarga.php">
									<i class="fa fa-sign-in"></i> Carga a Inventario
									</a>
                                </li>
                                <?php } ?>
								<?php if($_SESSION["ACTINVP"] == 1){ ?>
								<li>
									<a href="FRMmodificar.php">
									<i class="fa fa-edit"></i> Actualizaci&oacute;n de Inventario
									</a>
                                </li>
                                <?php } ?>
								<?php if($_SESSION["CALCDEP"] == 1){ ?>
								<li>
									<a href="FRMdepreciaciones.php">
									<i class="fa fa-unlink"></i> Depreciaciones
									</a>
                                </li>
                                <?php } ?>
								<?php if($_SESSION["CALCDEP"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMreplistado.php">
									<i class="fa fa-print"></i> Reporte de Inventario
									</a>
                                </li>
                                <?php } ?>
								<hr>
								<li>
                                    <a href="../CPMENU/MENUadministrativo.php">
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
            <div id = "cuerpo" class="panel panel-default">
					<div class="panel-heading"><label><i class="fa fa-unlink"></i> Calculo de Depreciaciones Mensuales</label></div>
                    <div class="panel-body">
					<form id='f1' name='f1' action='FRMdepreciaciones.php' method='get'>
						<div class="row">
							<div class="col-xs-12 col-xs-12 text-right"><label class = " text-danger">* Campos Obligatorios</label></div>
						</div>
                         <div class="row">
							<div class="col-xs-2 col-xs-offset-5"><label>A&ntilde;o:</label> <span class = "text-danger">*</span></div>
						</div>
						<div class="row">
                            <div class="col-xs-2 col-xs-offset-5 text-center">
								<input type = "text" class = "form-control" name = "anio" id = "anio" value = "<?php echo $anio; ?>" readonly />
							</div>
                        </div>
						<hr>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
								<?php
									$j = 1;
									for($i = 1; $i <= 12; $i++){
										if($j == 1){
											echo '<div class="row">';
										}
											$checked = ($mes == $i)?"checked":""; // Chequea el mes que toca
											$disabled = ($mes > $i)?"disabled":""; // desabilita los meses anteriores
											echo '<div class="col-xs-2 col-xs-offset-1"><input type="checkbox" name="chk'.$i.'" id="chk'.$i.'" '.$checked.' '.$disabled.'> <label>'.Meses_Letra($i).'</label></div>';
										$j++;
										if($j > 4){
											echo '</div>';
										}
										$j = ($j > 4)?1:$j;
									 }
								?>
							</div>
						</div>
						<hr>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="button" class="btn btn-default" onclick = "Limpiar();"><span class="glyphicon glyphicon-erase"></span> Limpiar</button>
                                <button type="button" class="btn btn-primary" onclick = "ConfirmDepreciacionesJS();"><span class="fa fa-edit"></span> Calcular</button>
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
			<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?> ASMS</h4>
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
    
    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/inventario/articulopropio.js"></script>
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
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>