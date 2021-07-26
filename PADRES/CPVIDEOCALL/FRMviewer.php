<?php
	include_once('html_fns_videoclase.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$usunivel = $_SESSION["nivel"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	$codigo = $_REQUEST["codigo"];
	$ClsAlu = new ClsAlumno();
	$cui = $ClsAlu->decrypt($hashkey, $usuario);

	$result = $ClsAlu->get_alumno($cui,'','',1);
	if(is_array($result)){
		foreach($result as $row){
			$nombre_alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
			$nombres = ucwords(strtolower($nombre_alumno));
			$nombre_alumno = depurador_texto($nombre_alumno);
			$cui = trim($row["alu_cui"]);
		}
	}

	$ClsVid = new ClsVideoclase();
	$result = $ClsVid->get_videoclase($codigo);
	if(is_array($result)){
		foreach($result as $row){
			$codigo = $row["vid_codigo"];
			$nombre = utf8_decode($row["vid_nombre"]);
			$descripcion = utf8_decode($row["vid_descripcion"]);
			$desde = $row["vid_fecha_inicio"];
			$desde = cambia_fechaHora($desde);
			$fecini = substr($desde,0,10);
			$horini = substr($desde,11,18);
			$hasta = $row["vid_fecha_fin"];
			$hasta = cambia_fechaHora($hasta);
			$fecfin = substr($hasta,0,10);
			$horfin = substr($hasta,11,18);
			//--
			$eventId = $row["vid_event"];
			$schedule = $row["vid_schedule"];
			$partnerid = $row["vid_partnerId"];
			//--
			$usuario = $row["vid_usuario"];
		}
		//----
		$credenciales = $ClsVid->get_credentials($usuario);
		$partnerId = $credenciales["partner"];
		$secret = $credenciales["secret"];
		///---
		$tipo_codigo = ($tipo_usuario == 5)?"ADMIN".$_SESSION["codigo"]:$tipo_codigo;
		$result = kaltura_session($partnerId,$secret, $eventId, $tipo_usuario, $cui, $nombre_alumno, "");
		if($result["status"] == 1){
			$token = $result["token"][0];
			$url = "https://$partnerid.kaf.kaltura.com/virtualEvent/launch?ks=$token";
		}
		echo "<form id='f1' name='f1' action='$url' method='post'>";
		echo "<script>document.f1.submit();</script>";
		echo "</form>";
	}else{
		$url = "FRMerror.php";
	}

if($usunombre != "" && $valida != ""){
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/icono.ico">

	<!-- bootstrap -->
	<link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
	<link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

	<!-- libraries -->
	<link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
	<link href='../assets.3.5.20/css/lib/fullcalendar.css' rel='stylesheet' />
	<link href='../assets.3.5.20/css/lib/fullcalendar.print.css' rel='stylesheet' media='print' />
	<link href="../assets.3.5.20/css/lib/modal.css" rel="stylesheet" />

	<!-- global styles -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />

	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

	<!-- this page specific styles -->
	<link rel="stylesheet" href="../assets.3.5.20/css/compiled/index.css" type="text/css" media="screen" />

	<!-- this page specific styles -->
	<link rel="stylesheet" href="../assets.3.5.20/css/compiled/calendar.css" type="text/css" media="screen" />

	<!-- Utilitaria -->
	<link href="../assets.3.5.20/css/util.css" rel="stylesheet">

	<!-- open sans font -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

	<!-- lato font -->
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!-- Custom Fonts -->
	<link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

	<style>
		.navbar {
			margin: 0px;
		}
	</style>

</head>
<body>

	<nav class="navbar navbar-default" style = "z-index:500;">
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
						<a href="#"><i class="fa fa-print"></i> Videoclase</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="window.close();"><i class="fa fa-close"></i> Cerrar</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="row">
		<div class="col-xs-12">
			<iframe src="<?php echo $url; ?>" frameBorder="0" wmode=transparent allow="microphone *; camera *; speakers *; usermedia *; autoplay *; fullscreen *;" width="100%" height="700px"></iframe>
		</div>
	</div>
   <!-- //////////////////////////////////////////////////////// -->

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../bower_components/jquery/dist/jquery.min.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<!-- DataTables JavaScript -->
	<script src="../assets.3.5.20/js/plugins/dataTables/datatables.min.js"></script>

	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>

	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.5.20/js/modules/inscripcion/inscripcion.js"></script>
	<script type="text/javascript" src="../assets.3.5.20/js/core/util.js"></script>

</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>
