<?php
	include_once('xajax_funct_proyecto.php');
	$nombre = $_SESSION["nombre"];
	$pventa = $_SESSION["cajapv"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["GRP_GPOPER"];
	$moneda = $_SESSION["moneda"];
	$facturar = $_SESSION["facturar"];
	$sifact = ($facturar == 1)?"checked":"";
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
	<script type="text/javascript" src="../assets.3.6.2/js/popup.js"></script>
	<!-- Libreria de Calendarios -->
	<link type="text/css" rel="stylesheet" href ="../ $('.dataTables-example').DataTable({dhtmlgoodies_calendar.css">
	<script type="text/javascript" src="../assets.3.6.2/js/dhtmlgoodies_calendar.js"></script>
	<!-- Gift Cargando -->
	<link type="text/css" href="../assets.3.6.2/css/jquery-ui-1.8.custom.css" rel="stylesheet">
	<script type="text/javascript" src="../assets.3.6.2/js/jquery-ui-1.8.custom.min.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/ejecutaGif.js"></script>
</head>
<body onload = "Set_Inicial('<?php echo $empCodigo; ?>','<?php echo $pventa; ?>','<?php echo $moneda; ?>');" >
<div id="all">
  <div id="header">
    <br>
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
		
    </div>
    <!-- end left -->
	<!-- main or main2 -->
    <div id="main2" align = "center" style="width:835px;">
		<div id="cuerpo" align = "center">
			<h3 class="encabezado"> Gestor de Presupuestos </h3>
			<br>
			<div align = "center">
				<a href = "FRMproyecto.php" >
					<img src = "../../CONFIG/images/refresh1.png" onmouseover = "this.src = "../../CONFIG/images/refresh2.png'" onmouseout = "this.src = "../../CONFIG/images/refresh1.png'" title = "Click para ir a pagina de descara de Firefox">
				</a> 
			</div>
				<form action="EXEgraba_visitas.php" name = "f1" name = "f1" method="post" enctype="multipart/form-data">
					<table>
						<tr>
							<td colspan = "4" align = "right">
								<span class = "obligatorio">* Campos Obligatorios</span>
								<span class = "busqueda">* Campos de Busqueda</span>
							</td>
						</tr>
						<tr>
							<td align="center" colspan="4"><br><hr class = "linea-delicada"></td>
						</tr>
						<tr>
							<td align="center" colspan="4"><em>Datos de la Cotizaci&oacute;n</em></td>
						</tr>
						<tr>
							<td align="center" colspan="4"><hr class = "linea-delicada"><br></td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Fecha de Presupuesto: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "fec" id = "fec" value = "<?php echo date("d/m/Y"); ?>" onclick="displayCalendar(this,'dd/mm/yyyy', this)" readonly /></td>
							<td></td>
							<td align = "center">
								<div class = "boxboton" style = "width:60px;height:20px;">
									<a class="button" href="javascript:void(0)" style = "width:30px;" onclick = "NewCliente('');"  title = "Nuevo Cliente" >
										<img src = "../../CONFIG/images/icons/cliente.png" style = "vertical-align:middle;border:none;">
									</a>
								</div>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Nit: <span class = "requerido">*</span><span class = "busca">*</span></td>
							<td>
								<input type = "text" class = "text" name = "nit" id = "nit" onkeyup = "texto(this);KeyEnter(this,Cliente);" />
								<input type = "hidden" name = "cli" id = "cli" />
								<a href = "javascript:void(0);" onclick = "SearchCliente();"  title = "Click para Buscar al Cliente" style = "border:none;" >
									<img width = "25px;" src = "../../CONFIG/images/search1.png" onmouseover = "this.src = "../../CONFIG/images/search2.png'" onmouseout = "this.src = "../../CONFIG/images/search1.png'" style = "vertical-align:middle;border:none;">
								</a>
							</td>
							<td class = "celda" align = "right">Cliente: <span class = "requerido">*</span><span class = "busca">*</span></td>
							<td>
								<input type = "text" class = "text" name = "nom" id = "nom" onkeyup = "texto(this);" readonly />
								<a href = "javascript:void(0);" onclick = "ResetCli();"  title = "Click para Limpiar Campos de Cliente" style = "border:none;" >
									<img src = "../../CONFIG/images/icons/refresh.png" style = "vertical-align:middle;border:none;">
								</a>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right">C�digo: <span class = "busca">*</span></td>
							<td>
								<input type = "text" class = "text" name = "vcod" id = "vcod" onkeyup = "enteros(this);KeyEnter(this,Vendedor);" />
								<a href = "javascript:void(0);" onclick = "SearchVendedor();"  title = "Click para Buscar al Vendedor" style = "border:none;" >
									<img width = "25px;" src = "../../CONFIG/images/search1.png" onmouseover = "this.src = "../../CONFIG/images/search2.png'" onmouseout = "this.src = "../../CONFIG/images/search1.png'" style = "vertical-align:middle;border:none;">
								</a>
							</td>
							<td class = "celda" align = "right">Vendedor: <span class = "busca">*</span></td>
							<td>
								<input type = "text" class = "text" name = "vnom" id = "vnom" onkeyup = "texto(this);" readonly />
								<a href = "javascript:void(0);" onclick = "ResetVend();"  title = "Click para Limpiar Campos de Vendedor" style = "border:none;" >
									<img src = "../../CONFIG/images/icons/refresh.png" style = "vertical-align:middle;border:none;">
								</a>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Empresa: <span class = "requerido">*</span></td>
							<td>
								<?php echo Empresa_PuntoV_html(); ?>
								<input type = "hidden" name = "sucX" id = "sucX" value = "<?php echo $_SESSION["empCodigo"]; ?>" />
							</td>
							<td class = "celda" align = "right">P. Venta: <span class = "requerido">*</span></td>
							<td align = "left">
								<span id = "spv">
									<select id="pv" name="pv" class = "combo">
										<option value="">Seleccione</option>
									</select>
								</span>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Moneda a Facturar: <span class = "requerido">*</span></td>
							<td><?php echo Moneda_TipoCambio_html("Tmon","total","spantotal"); ?></td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Tipo Desc.: &nbsp;</td>
							<td align = "left">
								<select id="tfdsc" name="tfdsc" class = "combo" onchange= "ExeTipoCambio(document.getElementById('Tmon'));">
									<option value="P">Por Porcerntaje (%)</option>
									<option value="M">Por Monto Monetario (Q.)</option>
								</select>
							</td>
							<td class = "celda" align = "right">Descuento:  &nbsp;</td>
							<td><input type = "text" class = "textct2" name = "fdsc" id = "fdsc" onkeyup = "decimales(this);" onblur = "ExeTipoCambio(document.getElementById('Tmon'));" value = "0" /></td>
						</tr>
						<tr>
							<td align="center" colspan="4"><br><hr class = "linea-delicada"></td>
						</tr>
						<tr>
							<td align="center" colspan="4"><em>Datos del Detalle</em></td>
						</tr>
						<tr>
							<td align="center" colspan="4"><hr class = "linea-delicada"><br></td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Tipo de la Venta: <span class = "requerido">*</span></td>
							<td>
								<select id = "tip" name = "tip" class = "combo" onchange = "TipoProyecto(this.value)">
									<option value = "S">SERVICIOS</option>
									<option value = "P">PRODUCTOS</option>
									<option value = "O">OTROS</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right" id = "lb1">C�digo Int.: <span class = "busca">*</span></td>
							<td id = "cnt1">
								<input type = "text" class = "text" name = "barc" id = "barc" onkeyup = "texto(this);KeyEnter(this,Servicio);"  />
							</td>
							<td class = "celda" align = "right" id = "lb2" style = "visibility:hidden">Existencia: </td>
							<td align="left">
								<input type = "text" class = "text" name = "cantlimit" id = "cantlimit" disabled style = "visibility:hidden" />
								<input type = "hidden" name = "prec" id = "prec" />
								<input type = "hidden" name = "prem" id = "prem" />
								<input type = "hidden" name = "prov" id = "prov" />
								<input type = "hidden" name = "nit" id = "nit" />
								<input type = "hidden" name = "nom" id = "nom" />
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right" id = "lb3" >Codigo Serv.: <span class = "requerido">*</span><span class = "busca">*</span></td>
							<td id = "cnt2">
								<input type = "text" class = "text" name = "art" id = "art" onkeyup = "texto(this);KeyEnter(this,Servicio);" /> 
								<a href = "javascript:void(0);" onclick = "SearchServicio(1);"  title = "Click para Buscar el Servicio" style = "border:none;" >
									<img width = "25px;" src = "../../CONFIG/images/search1.png" onmouseover = "this.src = "../../CONFIG/images/search2.png'" onmouseout = "this.src = "../../CONFIG/images/search1.png'" style = "vertical-align:middle;border:none;">
								</a>
							</td>
							<td class = "celda" align = "right" id = "lb4">Servicio: <span class = "requerido">*</span></td>
							<td colspan = "3" id = "cnt3">
								<input type = "text" class = "text" name = "artn" id = "artn" readonly />
								<a href = "javascript:void(0);" onclick = "ResetServ();"  title = "Click para Limpiar Campos de Servicio" style = "border:none;" >
									<img src = "../../CONFIG/images/icons/refresh.png" style = "vertical-align:middle;border:none;">
								</a>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right" id = "lb5" style = "visibility:hidden;">Descripci�n: <span class = "requerido" >*</span></td>
							<td colspan = "3"><input type = "text" class = "textmd" name = "desc" id = "desc" onkeyup = "texto(this);" style = "visibility:hidden;width: 95%;" /></td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Cantidad: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "cant" id = "cant" onkeyup = "enteros(this);KeyEnter(this,NewFilaProyecto);" /></td>
							<td class = "celda" align = "right">Precio: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "prev" id = "prev" onkeyup = "decimales(this);KeyEnter(this,NewFilaProyecto);" /></td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Moneda: <span class = "requerido">*</span></td>
							<td><?php echo Moneda_Transacciones_html(); ?></td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Tipo Desc.: &nbsp;</td>
							<td align = "left">
								<select id="tdsc" name="tdsc" class = "combo">
									<option value="P">Por Porcerntaje (%)</option>
									<option value="M">Por Monto Monetario (Q.)</option>
								</select>
							</td>
							<td class = "celda" align = "right">Descuento:  &nbsp;</td>
							<td><input type = "text" class = "textct2" name = "dsc" id = "dsc" onkeyup = "decimales(this);KeyEnter(this,NewFilaProyecto);" value = "0" /></td>
						</tr>
					</table>
				<div class = "boxboton" style = "width:100px;">
					<br>
					<a class="button" href="javascript:void(0)" style = "width:50px;float:none" onclick = "NewFilaProyecto()" >
						<img src = "../../CONFIG/images/icons/check.png" class="icon" >
					</a>
				</div>
			<br>
			</form>	
				<div id = "result" align = "center" >
					<?php echo tabla_inicio_proyecto(1); ?>
				</div>	
				<div class = "boxboton" style = "width:200px;">
				<br>
					<a class="button" href="javascript:void(0)" id = "limp" onclick = "Limpiar()" ><img src = "../../CONFIG/images/icons/refresh.png" class="icon" > Limpiar</a>
					<a class="button" href="javascript:void(0)" id = "gra" onclick = "ConfirmProyectoJS()" ><img src = "../../CONFIG/images/icons/Dollar.png" class="icon" > Aceptar</a>
				</div>
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
<br>
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
