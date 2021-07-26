<?php
include_once("html_fns_reportes.php");
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//post
	$dct = trim($_REQUEST["dct"]);
	$dlg = trim($_REQUEST["dlg"]);
	$pai = trim($_REQUEST["pai"]);
	$sit = trim($_REQUEST["sit"]);
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $_SESSION["nombre_colegio"]; ?></title>	
		<!--Librerias Utilitarias-->
		<link rel="shortcut icon" href="../../../CONFIG/images/icono.ico" >
		<script type="text/javascript" src="../../assets.3.6.2/js/modules/finanzas/pventa.js"></script>
		<link rel="stylesheet" href="../../assets.3.6.2/css/estilorep.css" type="text/css" media="screen,projection" charset="ISO-8859-1" />
		<link rel="stylesheet" type="text/css" href="../../assets.3.6.2/css/printrep.css" media="print" />
	</head>
	<body>
		<div align = "center">
			<img src= "../../../CONFIG/images/replogo.jpg" height = "55px;" />
		</div>
			<h3>Lista de Divisions </h3>
		<p>
			<b>Fecha/Hora de generaci�n:</b> <?php echo date("d/m/Y H:i"); ?><br />
			<b>Generado por:</b> <?php echo $nombre; ?> <br />
			<b>Empresa:</b> <?php echo $empresa; ?> 
		</p>
		<div align = "center" id = "print">
		<input type = "button" class = "boton" value = "Imprimir" onclick = "pageprint();" /><br /><br />
		</div>
		<?php 
			echo rep_tabla_grupos('',$dct,$dlg,$pai,$sit); 
		?>
	</body>
</html>
