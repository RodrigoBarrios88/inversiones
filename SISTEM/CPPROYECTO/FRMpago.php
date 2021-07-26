<?php
	include_once('xajax_funct_proyecto.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["GRP_GPOPER"];
if($nivel != "" && $nombre != "" && $empresa != ""){ 
if($valida == 1){ 	
?>
<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/icono.ico" >
		<?php
		   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		   $xajax->printJavascript("..");
		 ?>
	<link rel="stylesheet" href="../assets.3.6.2/css/formulario.css" type="text/css" media="screen,projection" charset="ISO-8859-1" />
	<link rel="stylesheet" href="../assets.3.6.2/css/leftmenu.css" type="text/css" media="screen,projection" charset="ISO-8859-1" />
	<link rel="stylesheet" href="../assets.3.6.2/css/elementos.css" type="text/css" media="screen,projection" charset="ISO-8859-1" />
	<link rel="stylesheet" href="../assets.3.6.2/css/grid.css" type="text/css" media="screen,projection" charset="ISO-8859-1" />
	<link rel="stylesheet" href="../assets.3.6.2/css/popup.css" type="text/css" media="screen,projection" charset="ISO-8859-1" />
	<!--Librerias de JQuery-->
	<script type="text/javascript" src="../assets.3.6.2/js/jquery-1.4.2.min.js"></script>
	<!--Librerias Utilitarias-->
	<script type="text/javascript" src="../assets.3.6.2/js/proyecto.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	<!-- Gift Cargando -->
	<link type="text/css" href="../assets.3.6.2/css/jquery-ui-1.8.custom.css" rel="stylesheet">
	<script type="text/javascript" src="../assets.3.6.2/js/jquery-ui-1.8.custom.min.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/ejecutaGif.js"></script>
</head>
<body onload = "Set_Inicial('<?php echo $empCodigo; ?>','<?php echo $pventa; ?>','<?php echo $moneda; ?>');" >
<div id="all">
  <div id="header">
    <table border = "0" cellpadding = "0" cellspacing = "0" width = "1000" align = "center">
      <tbody>        
		  <tr>
			<td colspan="2" height="25" align="center">
			
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
			<?php if($_SESSION["PROY"] == 1){ ?>
			<li class="item1">
				<a href="FRMproyecto.php">
					<span>Gestor de Presupuesto</span>
				</a>
			</li>
			<?php } ?>
			<?php if($_SESSION["PROYHIST"] == 1){ ?>
			<li class="item1">
				<a href="FRMhistorial.php">
					<span>Historial de Presupuesto</span>
				</a>
			</li>
			<?php } ?>
			<?php if($_SESSION["PROYANUL"] == 1){ ?>
			<li class="item1">
				<a href="FRManula.php">
					<span>Anulaci�n de Presupuesto</span>
				</a>
			</li>
			<?php } ?>
			<?php if($_SESSION["CXCOBPROY"] == 1){ ?>
			<li class="item1">
				<a href="FRMcuentaxcob.php">
					<span>Cuentas por Cobrar</span>
				</a>
			</li>
			<?php } ?>
			<?php if($_SESSION["PROYPAG"] == 1){ ?>
			<li class="item1">
				<a href="FRMpago.php">
					<span>Pagos</span>
				</a>
			</li>
			<?php } ?>
			<li class="item1">
				<a href="../CPMENU/menu2.php">
					<span>Menu</span>
				</a>
			</li>
			<li class="item1">
				<a href="../menu.php">
					<span>Menu Principal</span>
				</a>
			</li>
			<li class="item1">
				<a href="../logout.php">
					<span>Salir del Sistema</span>
				</a>
			</li>
		</ul>
		<br>
	</div>
    <!-- end left -->
	<!-- main or main2 -->
    <div id="main2" align = "center" style="width:835px;">
		<div id="cuerpo" align = "center">
			<h3 class="encabezado"> Pagos de Presupuestos </h3>
			<br>
			<div align = "center">
				<a href = "FRMpago.php" >
					<img src = "../../CONFIG/images/refresh1.png" onmouseover = "this.src = "../../CONFIG/images/refresh2.png'" onmouseout = "this.src = "../../CONFIG/images/refresh1.png'" title = "Click para ir a pagina de descara de Firefox">
				</a> 
			</div>
				<form name = "f1" name = "f1" method="post" enctype="multipart/form-data">
					<table>
						<tr>
							<td colspan = "4" align = "right">
								<span class = "obligatorio">* Campos Obligatorios</span>
								<span class = "busqueda">* Campos de Busqueda</span>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Nit del Cliente: <span class = "busca">*</span></td>
							<td>
								<input type = "text" class = "text" name = "nit" id = "nit" onkeyup = "texto(this);KeyEnter(this,Cliente);KeyEnter(this,BuscarProyecto);" />
								<input type = "hidden" name = "cli" id = "cli" />
								<input type = "hidden" name = "nom" id = "nom" />
								<input type = "hidden" name = "vcod" id = "vcod" />
								<a href = "javascript:void(0);" onclick = "SearchCliente();"  title = "Click para Buscar al Cliente" style = "border:none;" >
									<img width = "25px;" src = "../../CONFIG/images/search1.png" onmouseover = "this.src = "../../CONFIG/images/search2.png'" onmouseout = "this.src = "../../CONFIG/images/search1.png'" style = "vertical-align:middle;border:none;">
								</a>
							</td>
							<td class = "celda" align = "center"><span id = "lbf3">No. de Presupuesto: <span class = "busca">*</span></span></td>
							<td>
								<input type = "text" class = "text" name = "cod" id = "cod" value = "" onkeyup = "enteros(this);KeyEnter(this,BuscarProyecto);" />
								<input type = "hidden" name = "proC" id = "proC" value = "" />
							</td>
						</tr>
						<tr>
							<td colspan = "4" align = "center">
								<div class = "boxboton" style = "width:200px;">
								<br>
								<a class="button" href="javascript:void(0)" id = "busc" onclick = "BuscarProyecto()" ><img src = "../../CONFIG/images/icons/search.png" class="icon" > Buscar</a>
								<a class="button" href="FRMpago.php" id = "limp" ><img src = "../../CONFIG/images/icons/refresh.png" class="icon" > Limpiar</a>
								</div>
							</td>
						</tr>
					</table>
					<br>
					<table id = "sucbox" style = "margin-left:10px; display:none; width: 80%">
						<tr>
							<td class = "celda" align = "right">Empresa Cobro: <span class = "requerido">*</span></td>
							<td style = "width: 35%">
								<?php echo Empresa_PuntoV_html(); ?>
								<input type = "hidden" name = "sucX" id = "sucX" value = "<?php echo $_SESSION["empCodigo"]; ?>" />
							</td>
							<td class = "celda" align = "right">Punto de Venta: <span class = "requerido">*</span></td>
							<td align = "left" style = "width: 35%">
								<span id = "spv">
									<select id="pv" name="pv" class = "combo">
										<option value="">Seleccione</option>
									</select>
								</span>
							</td>
						</tr>
						<tr>
							<td align="center" colspan="4"><br><hr class = "linea-delicada"><br></td>
						</tr>
					</table>
					<table id = "pagobox" style = "margin-left:10px; display:none">
						<tr>
							<td class="encabeza" colspan = "2" width = "170">Forma de Pago</td>
						</tr>
						<tr>
							<td class = "celda" align = "left"><a href = "javascript:void(0);" onclick = "PromtPagoJS(1);"  title = "Forma de Pago" style = "border:none;text-decoration:underline;" >Efectivo: </a></td>
							<td class = "celda" align = "right"><input type = "hidden" name = "Pag1" id = "Pag1" value = "0" /><span id = "spanpago1"> 0 </span></td>
						</tr>
						<tr>
							<td class = "celda" align = "left"><a href = "javascript:void(0);" onclick = "PromtPagoJS(2);"  title = "Forma de Pago" style = "border:none;text-decoration:underline;" >Tarjeta: </a></td>
							<td class = "celda" align = "right"><input type = "hidden" name = "Pag2" id = "Pag2" value = "0" /><span id = "spanpago2"> 0 </span></td>
						</tr>
						<tr>
							<td class = "celda" align = "left"><a href = "javascript:void(0);" onclick = "PromtPagoJS(4);"  title = "Forma de Pago" style = "border:none;text-decoration:underline;" >Cheque: </a></td>
							<td class = "celda" align = "right"><input type = "hidden" name = "Pag4" id = "Pag4" value = "0" /><span id = "spanpago4"> 0 </span></td>
						</tr>
						<tr>
							<td colspan = "2" width = "170" align = "center">
								<div class = "boxboton" style = "width:200px;">
									<br>
									<a class="button" href="javascript:void(0)" onclick = "xajax_Reset_Pago()"><img src = "../../CONFIG/images/icons/refresh.png" class="icon" > Limpiar</a>
									<a class="button" href="javascript:void(0)" onclick = "ConfirmPagoJS()" ><img src = "../../CONFIG/images/icons/Dollar.png" class="icon" > Pagar</a>
								</div>
							</td>
						</tr>
					</table>
					<div id = "divPagos" align = "center" >
						<?php echo tabla_inicio_proyecto_pago(1); ?>
					</div>
				</form>	
				<br>
				<div id = "result" align = "center" ></div>	
			<br>
		</div>
		<br><br>
	</div>
	<!-- end main or main2 -->
  </div>
  <!-- end contentarea2 -->
  <div id="footer">
    
    <table class = "tablafoot" >
		<tr>
			<td>
			<font face="Verdana, Arial, Helvetica, sans-serif"><br>
				<div align="center">
					<font face="Verdana, Arial, Helvetica, sans-serif" size="1">
					Powered by ID Web Development Team. <strong>PBX: 2268-2732</strong> Call Center <br>
					<strong> :. Inversiones Digitales S.A. � 2012 � COPYRIGHT� Espa�ol .:</strong>
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
	<!--BigPromt-->	
	<div id="Bigdialog">
		<div align ="center">
			<div id = "Bigcontainer" ></div>
		</div>
	</div>
	<!-- --- -->
	<!-- Gif Loadin -->
	<div id="dialog-modal">
		<div align ="center">
			<p  id = "lblparrafo" align ="center">
				<img src = "../../CONFIG/images/ajax-loader.gif"/><br> 
				<label align ="center">Transaccion en Proceso...</label>
			</p>	
		</div>
	</div>
	<!-- --- -->
</body>
</html>

<?php
}else{
	echo "<form id='f1' name='f1' action='../menu.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
} 
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>
