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
	$codigo = $_REQUEST["codigo"];
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
		}
		//----
		$credenciales = $ClsVid->get_credentials($usuario);
		$partnerId = $credenciales["partner"];
		$secret = $credenciales["secret"];
		///---
		$usunombre = utf8_decode($usunombre);
		$tipo_codigo = ($tipo_usuario == 5)?"ADMIN".$_SESSION["codigo"]:$tipo_codigo;
		$result = kaltura_session($partnerId,$secret, $eventId, $tipo_usuario, $tipo_codigo, $usunombre, "");
		if($result["status"] == 1){
			$token = $result["token"][0];
			$url = "https://$partnerid.kaf.kaltura.com/virtualEvent/launch?ks=$token";
		}
		echo "<form id='f1' name='f1' action='$url' method='post'>";
		echo "<script>document.f1.submit();</script>";
		echo "</form>";
    	die;
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

	<!-- CSS personalizado -->
	<link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

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
	<script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<!-- DataTables JavaScript -->
	<script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>

	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>

	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.6.2/js/modules/inscripcion/inscripcion.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>

</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>
