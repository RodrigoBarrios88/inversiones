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
	$url = $_REQUEST["url"];
	$urlDownload = str_replace("format/url/protocol/", "format/download/protocol/", $url);
	$urlDownload = $urlDownload."/flavorParamIds/0";

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
	<!-- navbar -->
	<header class="navbar navbar-inverse" role="banner">
		<div class="navbar-header">
			<button class="navbar-toggle" type="button" data-toggle="collapse" id="menu-toggler">
				<span class="sr-only"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /> &nbsp; <label><?php echo $_SESSION["nombre_colegio"]; ?></label> </a>
			<a class="navbar-brand2" href="#"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /></a>
			<button type="button"  class="navbar-toggle second-menu-toggler pull-right" id="second-menu-toggler" data-toggle="collapse" data-target="#second-menu">
				<i class="fa fa-th"></i>
			</button>
		</div>
		<ul class="nav navbar-nav pull-right collapse" id="second-menu" >
			<ul class="nav navbar-nav" style="font-size: 14px;">						
				<li><a href="../CPSOLICITUD_MINEDUC/FRMmineduc.php"> <span class="fa fa-book"></span> Educaci&oacute;n Virtual a Distancia</a></li>
			</ul>
			<li class="settings">
				<a href="javascript:void(0)" role="button" onclick="window.close();"><i class="fa fa-times"></i> &nbsp; Cerrar</a>
			</li>
	   </ul>
    </header>
    <!-- end navbar -->
	<div class="row">
		<div class="col-xs-12">
			<iframe src="<?php echo $url; ?>" wmode=transparent allow="microphone *; camera *; speakers *; usermedia *; autoplay *; fullscreen *;" width="100%" height="600px"></iframe>
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
