<?php
include_once("html_fns_reportes.php");
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//post
	$suc = trim($_REQUEST["suc"]);
	$doc = trim($_REQUEST["doc"]);
	$ser = trim($_REQUEST["ser"]);
	$facc = trim($_REQUEST["facc"]);
	$fini = trim($_REQUEST["fini"]);
	$ffin = trim($_REQUEST["ffin"]);
	$tipo = trim($_REQUEST["class"]);
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $_SESSION["nombre_colegio"]; ?></title>	
		<!--Librerias Utilitarias-->
		<link rel="shortcut icon" href="../../../CONFIG/images/icono.ico" >
		<script type="text/javascript" src="../../assets.3.6.2/js/modules/compras/compra.js"></script>
		<link rel="stylesheet" href="../../assets.3.6.2/css/estilorep.css" type="text/css" media="screen,projection" charset="ISO-8859-1" />
		<link rel="stylesheet" type="text/css" href="../../assets.3.6.2/css/printrep.css" media="print" />
	</head>
	<body>
		<div align = "center">
			<img src= "../../../CONFIG/images/replogo.jpg" height = "55px;" />
		</div>
			<h3>Reporte de Anulaci�n de Compras y Gastos</h3>
		<p>
			<b>Fecha/Hora de generaci�n:</b> <?php echo date("d/m/Y H:i"); ?><br />
			<b>Generado por:</b> <?php echo $nombre; ?> <br />
			<b>Empresa:</b> <?php echo $empresa; ?> 
		</p>
		<div align = "center" id = "print">
		<input type = "button" class = "boton" value = "Imprimir" onclick = "pageprint();" /><br /><br />
		</div>
	<?php 
		if($tipo == "C"){
			echo "<p><b>Compras:</b></p> ";
			echo rep_tabla_historial_compra($cod,"C",$suc,$doc,$fini,$ffin,0); 
		}else if($tipo == "G"){
			echo "<p><b>Gastos:</b></p> ";
			echo rep_tabla_historial_compra($cod,"C",$suc,$doc,$fini,$ffin,0);
		}else{
			echo "<p><b>Compras:</b></p> ";
			echo rep_tabla_historial_compra($cod,"C",$suc,$doc,$fini,$ffin,0); 
			echo "<br><p><b>Gastos:</b></p> ";
			echo rep_tabla_historial_compra($cod,"G",$suc,$doc,$fini,$ffin,0);
		}
		
	?>
	</body>
</html>
