<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$gremial = $_SESSION["gremial"];
	$pensum = $_SESSION["pensum"];
	
	$cod = $_REQUEST["cod"];
	$fini = $_REQUEST["fini"];
	$ffin = $_REQUEST["ffin"];

?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
<body>	
<table>
	<tr>
		<td colspan = "4" align = "right">
			<br>
		</td>
	</tr>
	<tr>
		<td></td>
		<td  class = "text-justify">
			<span class = "requerido">¿Esta seguro de Anular este Presupuesto </span> # <?php echo Agrega_Ceros($cod); ?><span class = "requerido">?</span><br>
			<span class = "requerido">Revertira las transacciones adjuntas a esta.... </span>
		</td>
	</tr>
	<tr>
		<td class = "celda" align = "right">Justificación: <span class = "requerido">*</span></td>
		<td>
			<textarea id="just1" name="just1" class = "textarea"></textarea>
			<input type = "hidden" name = "pro1" id = "pro1" value = "<?php echo $cod; ?>" />
			<input type = "hidden" name = "fini1" id = "fini1" value = "<?php echo $fini; ?>" />
			<input type = "hidden" name = "ffin1" id = "ffin1" value = "<?php echo $ffin; ?>" />
		</td>
    </tr>
	<tr>
		<td colspan = "4" align = "center">
			<br><br>
			<input type = "button" class = "boton" value = "Cancelar" onclick = "cerrarPromt()" />
			<input type = "button" class = "boton" value = "Aceptar" onclick = "CambiarSituacion()" />
		</td>
	</tr>
</table>
</body>
</html>
