<?php
	include_once('xajax_funct_info.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$codigo = $_REQUEST['codigo'];
	
	$ClsInfo = new ClsInformacion();
	$result = $ClsInfo->get_informacion($codigo,"","","");
	if(is_array($result)){
		$i = 0;	
		foreach ($result as $row){
			$codigo = $row["inf_codigo"];
			$imagen =  "../../CONFIG/Actividades/".trim($row["inf_imagen"]);
			$link = trim($row["inf_link"]);
			$titulo = utf8_decode($row["inf_nombre"]);
			$descripcion = utf8_decode($row["inf_descripcion"]);
			$fini = trim($row["inf_fecha_inicio"]);
			$ffin = trim($row["inf_fecha_fin"]);
			//--				
			$fechaini = explode(" ",$fini);
			$fini = cambia_fecha($fechaini[0]);
			$fecha_inicio = $fini;
			$hora_inicio = substr($fechaini[1], 0, -3);
			//--
			$fechafin = explode(" ",$ffin);
			$fini = cambia_fecha($fechafin[0]);
			$fecha_final = $fini;
			$hora_final = substr($fechafin[1], 0, -3);
			//--
			$tipo = $row["inf_tipo_target"];
			$target = $row["inf_target"];
			$target_desc = ($target == "SELECT")?"ACTIVIDAD PARA GRUPOS ESPECIFICOS":"ACTIVIDAD PARA TODOS";
		}
	}else{
		
	}
	
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/shop-item.css" rel="stylesheet">
    
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

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" style = "z-index:500;">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" type="button">
					<span class="sr-only">ASMS</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php echo $_SESSION["rotulos_colegio"]; ?>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="#"><i class="fa fa-paste"></i> Actividades</a>
					</li>
					<li>
						<a href="../menu.php"><i class="fa fa-home"></i> Men&uacute; Principal</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="window.close();"><i class="fa fa-close"></i> Cerrar</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <p class="lead"><i class="fa fa-group-item"></i> Informaci&oacute;n de Actividades</p>
                <div class="list-group">
					<a href="../CPINFO/IFRMinformacion.php" class="list-group-item active"><i class="fa fa-calendar"></i> Informaci&oacute;n de Actividades</a>
                    <a href="../CPENCUESTAS/IFRMencuestas.php" class="list-group-item"><i class="fa fa-paste"></i> Encuestas</a>
				    <a href="../CPTAREAS/IFRMinformacion.php" class="list-group-item"><i class="fa fa-paste"></i> Tareas</a>
                    <a href="../CPPOSTIT/FRMpinboard.php" class="list-group-item"><i class="fa fa-thumb-tack"></i> Pin Board</a>
                	<a href="../CPMULTIMEDIA/FRMvisualizar.php" class="list-group-item"><i class="fa fa-film"></i> Multimedia</a>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="thumbnail">
                    <img class="img-responsive well" src="<?php echo $imagen; ?>" alt="">
                    <div class="caption-full">
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<h4 class="pull-right"><?php echo $fecha_inicio." - ".$fecha_final; ?></h4>
								<h4><a href="javascript:void(0);"><?php echo $titulo; ?></a>
								</h4>
								<p><?php echo $descripcion; ?></p>
							</div>
						</div>
						<br>
						<hr>
						<div class="row">
							<div class="col-xs-6 col-xs-offset-3">
								<div class="panel panel-default">
									<div class="panel-heading"><i class="fa fa-clock-o"></i> Fecha y Hora</div>
									<div class="panel-body">
										<h5>Inicia: <label class = "text-info"><?php echo $fecha_inicio; ?></label></h5>
										<h6>Hora: <label class = "text-info"><?php echo $hora_inicio; ?></label></h6>
										<hr>
										<h5>Finaliza: <label class = "text-info"><?php echo $fecha_final; ?></label></h5>
										<h6>Hora: <label class = "text-info"><?php echo $hora_final; ?></label></h6>
									</div>	
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 text-center">
								<h5 class="text-primary ">Participantes</h5>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 text-center">
							<?php if($target == "SELECT"){ ?>
								<table class="table table-striped table-bordered table-hover" >
									<thead>
										<tr>
											<th class = 'text-center'>No. </th>
											<th class = 'text-center'>Grupos</th>
										</tr>
									</thead>
									<tbody>
									<?php
										if($target == "SELECT"){
											if($tipo == 1){
												$result = $ClsInfo->get_lista_detalle_informacion_secciones($codigo,'','','','');
											}else if($tipo == 2){
												$result = $ClsInfo->get_lista_detalle_informacion_grupos($codigo,'');
											}
										}else{
											
										}
										//print_r($result);
										if(is_array($result)){
											$i = 1;
											foreach($result as $row){
												$tipo = $row["inf_tipo_target"];
												if($tipo == 1){
													$nivel = $row["niv_descripcion"];
													$grado = $row["gra_descripcion"];
													$seccion = $row["sec_descripcion"];
													$nombre = "SECCI&Oacute;N $seccion DE $grado EN $nivel.";
												}else if($tipo == 2){
													$area = $row["are_nombre"];
													$grupo = $row["gru_nombre"];
													$nombre = "$grupo DEL AREA $area.";
												}
												echo "<tr><td class = 'text-center' >".$i.". </td> <td class = 'text-left'>".$nombre."</td></tr>";
												
												$i++;
											}
											
										}
									?>	
										
									</tbody>
								</table>
							<?php }else if($target == "TODOS"){ ?>
								<div class="alert alert-success" role="alert"> ASISTEN TODOS </div>
							<?php } ?>
							</div>
						</div>
                    </div>
                    <div class="ratings">
                        <p class="pull-right text-info"> Visualizado el <?php echo date("d/m/Y"); ?> a las <?php echo date("H:i"); ?></p>
                    </div>
					<br><br>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; ID <?php echo date("Y"); ?></p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="../assets.3.6.2/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/js/bootstrap.min.js"></script>

</body>

</html>
