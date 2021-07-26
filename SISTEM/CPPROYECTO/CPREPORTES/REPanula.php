<?php
include_once("html_fns_reportes.php");
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//post
	$nit = trim($_REQUEST["nit"]);
	$suc = trim($_REQUEST["suc"]);
	$pv = trim($_REQUEST["pv"]);
	$ser = trim($_REQUEST["ser"]);
	$facc = trim($_REQUEST["facc"]);
	$fini = trim($_REQUEST["fini"]);
	$ffin = trim($_REQUEST["ffin"]);
	//--

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $_SESSION["nombre_colegio"]; ?></title>	
		<!--Librerias Utilitarias-->
		<link rel="shortcut icon" href="../../../CONFIG/images/icono.ico" >
		<script type="text/javascript" src="../../assets.3.6.2/js/proyecto.js"></script>
		<link rel="stylesheet" href="../../assets.3.6.2/css/estilorep.css" type="text/css" media="screen,projection" charset="ISO-8859-1" />
		<link rel="stylesheet" type="text/css" href="../../assets.3.6.2/css/printrep.css" media="print" />
	</head>
	<body>
		<table style = "width:100%">
			<tr>
				<td style = "width:70%;border:none;">
					<h3>Reporte de Anulaci�n de Proyectos</h3>
					<p>
						<b>Fecha/Hora de generaci�n:</b> <?php echo date("d/m/Y H:i"); ?><br />
						<b>Generado por:</b> <?php echo $nombre; ?> <br />
						<b>Empresa:</b> <?php echo $empresa; ?> 
					</p>
				</td>
				<td style = "width:30%;border:none;">
					<div align = "center">
						<img src= "../../../CONFIG/images/replogo.jpg" style = "width:40%" />
					</div>
				</td>
			</tr>
		</table>
		<div align = "center" id = "print">
		<input type = "button" class = "boton" value = "Imprimir" onclick = "pageprint();" /><br /><br />
		</div>
		<?php 
			echo rep_tabla_anulacion_venta('',$cil,$suc,$pv,$ser,$facc,$fini,$ffin); 
		?>
	</body>
</html>
