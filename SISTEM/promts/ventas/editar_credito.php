<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$gremial = $_SESSION["gremial"];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$codigo = $_REQUEST["codigo"];
	$venta = $_REQUEST["venta"];
	$ClsCred = new ClsCredito();
	$result = $ClsCred->get_credito_venta($codigo,$venta);
	if(is_array($result)){
		foreach($result as $row){
			//Codigo
			$cod = trim($row["cred_codigo"]);
			$vent = trim($row["cred_venta"]);
			$credito = Agrega_Ceros($row["cred_codigo"])."-".Agrega_Ceros($row["cred_venta"]);
			//Operador o Banco
			$autorizo = utf8_decode($row["cred_operador"]);
			//Documento o Boucher
			$doc = utf8_decode($row["cred_doc"]);
			//fecha hora
			$fec = $row["cred_fechor"];
			$fec = cambia_fechaHora($fec);
			//observaciones
			$obs = utf8_decode($row["cred_obs"]);
			//monto
			$mont = $row["cred_monto"];
			$mons = $row["mon_simbolo"];
			$moncamb = $row["mon_cambio"];
			$monto = $mons.". ".$mont;
			//cambio
			$camb = $row["cred_tcambio"];
		}
	}	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label>Editar Datos del Cr&eacute;dito</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Cr&eacute;dito: <span class = "text-danger">*</span></label></div>
						<div class="col-xs-5"><label>No. de Venta: <span class = "text-danger">*</span></label></div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<label class="form-control text-info" disabled ><?php echo $credito; ?></label>
						<input type = "hidden" name = "codigo" id = "codigo" value = "<?php echo $codigo; ?>" />
						<input type = "hidden" name = "venta" id = "venta" value = "<?php echo $venta; ?>" />
					</div>
					<div class="col-xs-5">
						<label class="form-control text-info" disabled ># <?php echo $venta; ?></label>
					</div>	
				</div>
				<div class="row">
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Autoriz&oacute;: <span class = "text-danger">*</span></label></div>
						<div class="col-xs-5"><label>No. de Documento: <span class = "text-danger">*</span></label></div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<input type = "text" class = "form-control" name = "autoriza" id = "autoriza" value = "<?php echo $autorizo; ?>" onkeyup = "texto(this);" />
					</div>
					<div class="col-xs-5">
						<input type = "text" class = "form-control" name = "doc" id = "doc" value = "<?php echo $doc; ?>" onkeyup = "texto(this);" />
					</div>	
				</div>
				<div class="row">
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Fecha y Hora de cuando se otorg&oacute;: <span class = "text-danger">*</span></label></div>
						<div class="col-xs-5"><label>Monto Total del Cr&eacute;dito: <span class = "text-danger">*</span></label></div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<label class="form-control text-info" disabled ><?php echo $fec; ?></label>
					</div>
					<div class="col-xs-5">
						<label class="form-control text-info" disabled ><?php echo $monto; ?></label>
					</div>	
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1"><label>Observaciones: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-10 col-xs-offset-1">
						<textarea id="observaciones" name="observaciones" class = "form-control"  onkeyup = "texto(this);" ><?php echo $obs; ?></textarea>
					</div>
				</div>	
				<br><br>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-default" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
						<button type="button" class="btn btn-primary" onclick = "ModificarCredito();"><span class="fa fa-check"></span> Aceptar</button>
					</div>
				</div>
				<br>
			</div>		
		</div>	
	</body>
</html>
