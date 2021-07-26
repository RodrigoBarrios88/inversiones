<?php
	include_once('xajax_funct_otrousu.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	$tipoAsi = $_REQUEST["tipoAsi"];
	$area = $_REQUEST["area"];
	$pensum = $_REQUEST["pensum"];
	$nivel = $_REQUEST["nivel"];
	
	$ClsOtro = new ClsOtrosUsu();
	$ClsAsi = new ClsAsignacion();
	$ClsAcadem = new ClsAcademico();
	$cui = $ClsOtro->decrypt($hashkey, $usuario);
	
	$result = $ClsOtro->get_otros_usuarios($cui,'','',1);
	if(is_array($result)){
		
		foreach($result as $row){
			$cui = $row["otro_cui"];
			$nombre = trim($row["otro_nombre"])." ".trim($row["otro_apellido"]);
			$mail = $row["otro_mail"];
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
    <!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
   <link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    

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
                                <?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
                                <li>
									<a href="FRMnewotrousu.php">
										<i class="fa fa-user"></i> Gestor de Autoridades
									</a>
                                </li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMotrousu.php">
										<i class="fa fa-list-ol"></i> Listar Autoridades
									</a>
                                </li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMlistotrousu.php">
										<i class="fa fa-link"></i> Asignaci&oacute;n de Autoridades
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
								<hr>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="CPREPORTES/FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Autoridades
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
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
	    <br>
		<form name = "f1" id = "f1" method="get">
            <div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-link"></i> <label>Asignaci&oacute;n de Directores o Autoridades a Grados y Grupo</label></div>
                <div class="panel-body">
					<div class="row">
							<div class="col-xs-12 col-xs-12 text-right"><label class = " text-danger">* Campos Obligatorios</label> <label class = " text-info">* Campos de Busqueda</label></div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1"><label>Nombre y Apellido:</label>  <span class="text-danger">*</span> <span class="text-info">*</span></div>
							<div class="col-xs-5"><label>e-mail:</label>  <span class="text-danger">*</span> <span class="text-info">*</span></div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<label class = "text-info"><?php echo utf8_decode($nombre); ?></label>
								<input type = "hidden" name = "cui" id = "cui" value = "<?php echo $cui; ?>" />
								<input type = "hidden" name = "hashkey" id = "hashkey" value = "<?php echo $hashkey; ?>" />
							</div>
							<div class="col-xs-5">
								<label class = "text-info"><?php echo $mail; ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1"><label>T&iacute;po de Asignaci&oacute;n:</label>  <span class="text-danger">*</span> <span class="text-info">*</span></div>
							<div class="col-xs-5"><label>&Aacute;rea:</label>  <span class="text-danger">*</span> <span class="text-info">*</span></div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<select class = "form-control" name = "tipoAsi" id = "tipoAsi" onchange="Submit();">
									<option value = "">Seleccione</option>
									<option value = "1">GRADOS</option>
									<option value = "3">GRUPOS</option>
								</select>
								<script type = "text/javascript">
									document.getElementById("tipoAsi").value = '<?php echo $tipoAsi; ?>';
								</script>
							</div>
							<div class="col-xs-5">
								<?php echo Area_html("area","Submit();"); ?>
								<script type = "text/javascript">
									document.getElementById("area").value = '<?php echo $area; ?>';
								</script>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1"><label>Programa Acad&eacute;mico:</label></div>
							<div class="col-xs-5"><label>Nivel:</label></div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<?php echo pensum_html("pensum","Submit();"); ?>
								<?php if($pensum != ""){ ?>
								<script type = "text/javascript">
									document.getElementById("pensum").value = '<?php echo $pensum; ?>';
								</script>
								<?php } ?>
							</div>
							<div class="col-xs-5" id = "divnivel">
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
						<div class="row">
							<hr>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-4 text-center" id = "divxasignar">
								<?php
									if($tipoAsi == 3){
										if($area != ""){
											$result = $ClsAsi->get_usuario_grupo("",$cui,1);
											if(is_array($result)){
											   $grupos = "";
											   foreach($result as $row){
												  $grupos.= $row["gru_codigo"].",";
											   }
											   $grupos = substr($grupos, 0, strlen($grupos) - 1);
											}
											echo grupos_no_usuario_lista_multiple("xasignar",$area,$grupos);
										}else{
											echo lista_multiple_vacia("xasignar"," Listado de Grupos y Grados no asignadas");
										}
									}else if($tipoAsi == 1){
										if($pensum != "" && $nivel != ""){
											$ClsAcadem = new ClsAcademico();
											$result = $ClsAcadem->get_grado_otros_usuarios($pensum,$nivel,'',$cui);
											if(is_array($result)){
											   $grados = "";
											   foreach($result as $row){
												  $grados.= $row["gra_codigo"].",";
											   }
											   $grados = substr($grados, 0, strlen($grados) - 1);
											}
											echo grados_no_otros_usuarios_lista_multiple("xasignar",$pensum,$nivel,$grados);
										}else{
											echo lista_multiple_vacia("xasignar"," Listado de Grupos y Grados no asignadas");
										}
									}else{
										echo lista_multiple_vacia("xasignar"," Listado de Grupos y Grados no asignadas");
									}	
								?>
								<?php //echo grupos_no_alumno_lista_multiple($id,$area,$grupos); ?>
								<?php //echo secciones_no_maestro_lista_multiple(1,1,1,1,"A","1"); ?>
								<?php //echo materias_no_maestro_lista_multiple($id,$pensum,$nivel,$grado,$tipo,$materias); ?>
							</div>
                            <div class="col-xs-4 text-center">
								<div class="list-group">
									<span class="list-group-item">
									  <button type="button" class="btn btn-primary" id = "asig" onclick = "Asigna_Trabajo_OtroUsu();"><span class="fa fa-arrow-right "></span> Asignar</button>
									</span>
									<span class="list-group-item">
									  <button type="button" class="btn btn-primary" id = "quita" onclick = "Quitar_trabajo_OtroUsu();"><span class="fa fa-arrow-left "></span> &nbsp;Quitar &nbsp;</button>
									</span>
								</div>
							</div>
							<div class="col-xs-4 text-center" id = "divasignados">
								<?php
									if($tipoAsi == 3){
										if($area != ""){
											echo grupos_usuario_lista_multiple("asignados",$cui);
										}else{
											echo lista_multiple_vacia("asignados"," Listado Grupos y Grados asignadas");
										}
									}else if($tipoAsi == 1){
										if($pensum != ""){
											echo grados_otros_usuarios_lista_multiple("asignados",$pensum,$nivel,$cui);
										}else{
											echo lista_multiple_vacia("asignados"," Listado Grupos y Grados asignadas");
										}
									}else{
										echo lista_multiple_vacia("asignados"," Listado Grupos y Grados asignadas");
									}
								?>
								<?php //echo grupos_alumno_lista_multiple($id,$maestro); ?>
								<?php //echo secciones_maestro_lista_multiple($id,$pensum,$nivel,$grado,$maestro); ?>
								<?php //echo materias_maestro_lista_multiple($id,$pensum,$nivel,$grado,$maestro); ?>
							</div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="button" class="btn btn-info" id = "busc" onclick = "Buscar(2);"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                                <button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
                            </div>
                        </div>	
                    </div>
                    <!-- /.panel-body -->
            </div>
             <!-- /.panel-default -->
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/app/otrousu.js"></script>
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