<?php
	include_once('xajax_funct_reportes.php');
	include_once('html_fns_reportes.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["GRP_GPCONTA"];
if($nivel != "" && $nombre != "" && $empresa != ""){ 
if($valida == 1){ 	
?>
<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../../CONFIG/images/icono.ico" >
		<?php
		   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		   $xajax->printJavascript("../..");
		 ?>
	<link rel="stylesheet" href="../../assets.3.6.2/css/formulario.css" type="text/css" media="screen,projection" charset="ISO-8859-1" />
	<link rel="stylesheet" href="../../assets.3.6.2/css/leftmenu.css" type="text/css" media="screen,projection" charset="ISO-8859-1" />
	<link rel="stylesheet" href="../../assets.3.6.2/css/elementos.css" type="text/css" media="screen,projection" charset="ISO-8859-1" />
	<!--Librerias de JQuery-->
	<script type="text/javascript" src="../../assets.3.6.2/js/jquery-1.4.2.min.js"></script>
	<!--Librerias Utilitarias-->
	<script type="text/javascript" src="../../assets.3.6.2/js/modules/bancos/banco.js"></script>
	<script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	<!-- Libreria de Calendarios -->
	<link type="text/css" rel="stylesheet" href ="../../ $('.dataTables-example').DataTable({dhtmlgoodies_calendar.css">
	<script type="text/javascript" src="../../assets.3.6.2/js/dhtmlgoodies_calendar_inter.js"></script>
	<!-- Gift Cargando -->
	<link type="text/css" href="../../assets.3.6.2/css/jquery-ui-1.8.custom.css" rel="stylesheet">
	<script type="text/javascript" src="../../assets.3.6.2/js/jquery-ui-1.8.custom.min.js"></script>
	<script type="text/javascript" src="../../assets.3.6.2/js/ejecutaGif.js"></script>
</head>
<body>
<div id="all">
  <div id="header">
    <table border = "0" cellpadding = "0" cellspacing = "0" width = "1000" align = "center">
      <tbody>        
		  <tr>
			<td colspan="2" height="10" align="center">
			
			</td>
		  </tr>
	  </tbody>
	</table>
    <div class="wrap">&nbsp;</div>
  </div>
  <!-- end header -->
  <div id="contentarea2"> <a name="mainmenu" id="mainmenu"></a>
	<!-- left -->
      <div id="left">
		<table class = "tablaarriba">
		<tbody>
		<tr>
		</tr>
		</tbody>
		</table>
		<ul class="menu">
			<li class="item1">
				<a href="../../CPMENU/menu3.php">
					<span>Men??? de Modulo</span>
				</a>
			</li>
			<li class="item1">
				<a href="../../menu.php">
					<span>Men??? Principal</span>
				</a>
			</li>
			<li class="item1">
				<a href="../../logout.php">
					<span>Salir del Sistema</span>
				</a>
			</li>
		</ul>
    </div>
    <!-- end left -->
	<!-- main or main2 -->
    <div id="main2" align = "center">
		<div id="cuerpo" align = "center">
				<form name = "f1" name = "f1" method="post" target="_blank" enctype="multipart/form-data">
					<h3 class="encabezado"> Apertura de Cuentas Bancarias </h3>
					<table>
						<tr>
							<td colspan = "4" align = "right">
								<span class = "busqueda">* Campos de Busqueda</span>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Banco: <span class = "busca">*</span></td>
							<td><?php echo Banco_html(); ?></td>
							<td class = "celda" align = "right">No. Cuenta: <span class = "busca">*</span></td>
							<td><input type = "text" class = "text" name = "num" id = "num" onkeyup = "enteros(this)" /></td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Tipo de Cuenta: <span class = "busca">*</span></td>
							<td><?php echo Tipo_Cuenta_html("tip"); ?></td>
							<td class = "celda" align = "right">Moneda: <span class = "busca">*</span> </td>
							<td><?php echo Moneda_html(); ?></td>
						</tr>
						<tr>
							<td colspan = "4" align = "center">
								<div class = "boxboton" style = "width:200px;">
								<br>
								<a class="button" href="javascript:void(0)" id = "rep" onclick = "ReporteCueBancos()" ><img src="../../../CONFIG/images/icons/printer_add.png" class="icon" > Reporte</a>
								<a class="button" href="FRMrepcuenta.php" id = "limp" ><img src="../../../CONFIG/images/icons/refresh.png" class="icon" > Limpiar</a>
								</div>
							</td>
						</tr>
					</table>
				</form>	
				<br>
		</div>
	</div>
	<!-- end main or main2 -->
    <!-- right -->
	<div id="right">         
		<div align = "center" id = "rightlogo" >
			<img src= "../../../CONFIG/images/logo.jpg" width = "200px;" />
		</div>
	</div>
    <!-- end right -->
  </div>
  <!-- end contentarea2 -->
  <div id="footer">
    <table class = "tablafoot" >
		<tr>
			<td>
			<font face="Verdana, Arial, Helvetica, sans-serif"><br>
				<div align="center">
					<font face="Verdana, Arial, Helvetica, sans-serif" size="1">
					Powered by Inversiones Digitales S.A. Web Development Team. <strong>PBX: 2268-2732</strong> Call Center <br>
					<strong> :. Inversiones Digitales S.A. ??? 2012 ??? COPYRIGHT??? Espa???ol .:</strong>
					</font>
				</div>
				<font face="Verdana, Arial, Helvetica, sans-serif" size="1">
					<strong>
						<div align="center"></div><br>
					</strong>
				</font>
			</font>
			</td>
		</tr>
    </table>
  </div>
  <!-- footer -->
</div>

	<!--Promt-->	
	<div id="dialog">
		<div align ="center">
			<div id = "Pcontainer" ></div>
		</div>
	</div>
	<!-- --- -->
	<!-- Gif Loadin -->
	<div id="dialog-modal">
		<div align ="center">
			<p  id = "lblparrafo" align ="center">
				<img src="../../../CONFIG/images/ajax-loader.gif"/><br> 
				<label align ="center">Transaccion en Proceso...</label>
			</p>	
		</div>
	</div>
	<!-- --- -->
</body>
</html>

<?php
}else{
	echo "<form id='f1' name='f1' action='../../menu.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
} 
}else{
	echo "<form id='f1' name='f1' action='../../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>
