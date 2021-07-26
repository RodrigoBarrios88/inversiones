<?php
	include_once('xajax_funct_asistencia.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	$ClsHor = new ClsHorario();
	$ClsAsist = new ClsAsistencia();
	//_$POST  //recibe el codigo de horario
	$hashkey = $_REQUEST["hashkey"];
	$horario = $ClsHor->decrypt($hashkey, $usuario);
	
	// trae los datos principales del periodo segun el codigo de horario
	$result = $ClsHor->get_horario_cursos($horario);
	if(is_array($result)){
		foreach($result as $row){
			$curso = $row["hor_curso"];
			$dia = $row["hor_dia"];
			//---
			$curso_desc = utf8_decode($row["cur_nombre"]);
		}
	}
	
	// seleccional el nombre del día segun el numero de dia
	switch($dia){
		case 1: $dia_desc = "LUNES"; break;
		case 2: $dia_desc = "MARTES"; break;
		case 3: $dia_desc = "MIERCOLES"; break;
		case 4: $dia_desc = "JUEVES"; break;
		case 5: $dia_desc = "VIERNES"; break;
		case 6: $dia_desc = "SABADO"; break;
	}
	
	////// Recibe los datos del campo hoy que valida si es el dia del Sistema o 1 semana + o - a partir de hoy 
	$hoy = $_REQUEST["hoy"];
	$hoy = ($hoy != "")?$hoy:date("Y-m-d"); //valida
	$hoymenos = date("Y-m-d",strtotime("$hoy -1 week")); //resta una semana para el botoncito -
	$hoymas = date("Y-m-d",strtotime("$hoy +1 week")); //suma una semana para el botoncito +
	
	$fechaInicio = strtotime("$hoy -2 week"); //Fecha del mismo día de las 2 semanas pasadas
	$fechaFin = strtotime("$hoy +2 week"); // Fecha del mismo día de las siguientes 2 semanas
	
	//////////// Inicia combo de Fechas //////////////////
	$combo_fecha.= '<select class = "form-control" name = "fecha" id = "fecha" onchange = "Submit();">';
	
	$anterior = date("d/m/Y",$fechaInicio);
	for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){ ///// recorre los rangos de fechas de 2 semanas hantes hasta 2 semanas despues
		$dia_recorrido = date('N', $i); /// convierte a Formato dia de la semana la fecha recorrida
		if($dia_recorrido == $dia){ ///// valida si ese dia corresponde a uno de los dias del horario (L, M, M, J, V)
			$combo_fecha.= '<option value = "'.date("d/m/Y", $i).'" >'.$dia_desc.' '.date("d/m/Y", $i).'</option>';
			$anterior = date("d/m/Y", $i);
		}
		if(date("d/m/Y") == date("d/m/Y", $i)){ //// registra la ultima fecha valida mas cercana a la fecha de hoy para setear en el combo fechas
			$fecha = $anterior;
		}
	}
	$combo_fecha.= '</select>';
	////// Finaliza combo de Fechas //////
	
	$fecha = ($_REQUEST["fecha"] == "")?$fecha:$_REQUEST["fecha"]; /// valida la fecha que va a setear a la fecha de hoy
	
	$titulo = "TOMA DE ASISTENCIA DEL CURSO $curso_desc PARA EL DIA $dia_desc $fecha";
	
	////////////////// VALIDA SI YA FUE TOMADA LA ASISTENCIA ////////////////
	$asistencia = $ClsAsist->count_asistencia_cursos($horario,$fecha);
	//$asistencia = 28;
if($tipo_usuario != "" && $usunombre != "" && $valida != ""){	
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
<body onload="Lista_Multiple();">
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
                       <li class="active">
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a class="active" href="FRMperiodos.php">
									<i class="fa fa-check"></i> Tomar Asistencia
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="FRMlist_cursos.php">
									<i class="fa fa-search"></i> Asistencia por Curso Libre
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="FRMlista_alumnos.php">
									<i class="fa fa-search"></i> Asistencia por Alumno
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="FRMlist_maestros.php">
									<i class="fa fa-search"></i> Asistencia por Maestro
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
            <div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading"> 
							<span class="fa fa-check-square-o" aria-hidden="true"></span>
							Tomar Asistencia para Cursos Libres
						</div>
						<div class="panel-body">
						<h5 class="alert alert-info text-center"><?php echo $titulo; ?></h5>
						<form id = "f1" name = "f1" method="get">
							<div class="row">
								<div class="col-xs-2 col-xs-offset-2"><label>Fecha de la Asistencia:</label></div>
								<div class="col-xs-5">
									<div class='input-group'>
										<a class="input-group-addon" href="FRMasistencia.php?hashkey=<?php echo $hashkey; ?>&hoy=<?php echo $hoymenos; ?>">
											<span class="fa fa-minus"></span>
										</a>
										<?php echo $combo_fecha; ?>
										<input type="hidden" id = "horario" name = "horario" value = "<?php echo $horario; ?>" />
										<input type="hidden" id = "hashkey" name = "hashkey" value = "<?php echo $hashkey; ?>" />
										<input type="hidden" id = "asistencia" name = "asistencia" value = "<?php echo $asistencia; ?>" />
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-time"></span>
										</span>
										<a class="input-group-addon" href="FRMasistencia.php?hashkey=<?php echo $hashkey; ?>&hoy=<?php echo $hoymas; ?>">
											<span class="fa fa-plus"></span>
										</a>
										<script>
											document.getElementById("fecha").value = '<?php echo $fecha; ?>';
										</script>
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-xs-8 col-xs-offset-2">
									<?php
										//echo "$pensum,$nivel,$grado,$seccion,$materia,$parcial";
										if($asistencia > 0){
											echo '<h5 class="alert alert-success text-center"> <i class="fa fa-exclamation-circle"></i> La Asistencia de este dia ya fue registrada</h5>';
										}
									?>
								</div>
							</div>	
							<div class="row">
								<div class="col-lg-12">
									<?php
										//echo "$pensum,$nivel,$grado,$seccion,$materia,$parcial";
										
										if($asistencia > 0){
											if($horario != "" && $fecha != ""){
												echo tabla_asistencia_alumnos($horario,$fecha);
											}else{
												echo '<h6 class="alert alert-warning text-center"> <i class="fa fa-warning"></i> Uno de los parametros esta vacio, porfavor refresque la p&aacute;gina...</h6>';
											}
										}else{
											if($curso != ""){
												echo tabla_lista_alumnos($curso);
												echo '<script> document.getElementById("asistbase").checked = true;</script>';
											}else{
												echo '<h6 class="alert alert-warning text-center"> <i class="fa fa-warning"></i> Uno de los parametros esta vacio, porfavor refresque la p&aacute;gina...</h6>';
											}
										}
									?>
								</div>
							</div>
						</form>
						</div>
					</div>
					<!-- /.panel-default -->
					<br>
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-xs-12 text-center">
									<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
									<?php
										//echo "$pensum,$nivel,$grado,$seccion,$materia,$parcial";
										if($asistencia > 0){
											echo '<button type="button" class="btn btn-primary" id = "gra" onclick = "Modificar();"><span class="fa fa-save"></span> Modificar</button>';
										}else{
											echo '<button type="button" class="btn btn-primary" id = "gra" onclick = "Grabar();"><span class="fa fa-save"></span> Grabar</button>';
										}
									?>
								</div>
							</div>
						</div>
					</div>
					<!-- /.panel-default -->
				</div>
			</div>
			<br>	
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
    
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/lms/asistencia.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		
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