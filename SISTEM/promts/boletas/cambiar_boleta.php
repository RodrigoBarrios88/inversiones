<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//--
	$referencia = $_REQUEST["boleta"];
	$cuenta = $_REQUEST["cuenta"];
	$banco = $_REQUEST["banco"];
	$alumno = $_REQUEST["alumno"];
	$pago = $_REQUEST["pago"];
	
	$ClsBol = new ClsBoletaCobro();
	$ClsAlu = new ClsAlumno();
	$ClsCli = new ClsCliente();
	$result = $ClsBol->get_boleta_cobro('',$cuenta,$banco,'',$referencia,'','','','','');
	
	if(is_array($result)){
		foreach($result as $row){
			$codigo_boleta = $row["bol_codigo"];
			$referencia1 = $row["bol_referencia"];
			$motivo = utf8_decode($row["bol_motivo"]);
			$fecha = $row["bol_fecha_pago"];
			$fecha = cambia_fecha($fecha);
			$mons = $row["mon_simbolo"];
			$monto = $row["bol_monto"];
			$monto = $mons." ".number_format($monto, 2);
			$girada_a = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			$cui_girada_a = $row["alu_cui"];;
		}
	}else{
		$codigo = "";
		$referencia1 = $referencia;
		$motivo = "NO ESXISTE ESTA BOLETA...";
		$monto = "";
		$fecha = "";
	}
	
	$result = $ClsAlu->get_alumno($alumno);
	if(is_array($result)){
		foreach($result as $row){
			$cui = $row["alu_cui"];
			$alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			$cli = $row["alu_cliente_factura"];
		}
		if(strlen($cli)>0){
			$result = $ClsCli->get_cliente($cli);
			if(is_array($result)){
				foreach($result as $row){
					$nit = $row["cli_nit"];
					$cliente = utf8_decode($row["cli_nombre"]);
				}
			}
		}
	}else{
		$result = $ClsAlu->get_alumno_codigo_interno($alumno);
		if(is_array($result)){
			foreach($result as $row){
				$cui = $row["alu_cui"];
				$alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
				$cli = $row["alu_cliente_factura"];
			}
			if(strlen($cli)>0){
				$result = $ClsCli->get_cliente($cli);
				if(is_array($result)){
					foreach($result as $row){
						$nit = $row["cli_nit"];
						$cliente = utf8_decode($row["cli_nombre"]);
					}
				}
			}
		}else{
			$cui = $alumno;
			$alumno = "NO EXISTE ESTE ALUMNO, REVISE LOS DATOS DE LA BOLETA...";
		}
	}
	
/////////////////////////////////////////////////////////////////////////

	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_boleta_cobro($pago);
	
	if(is_array($result)){
		foreach($result as $row){
			$codigo_pago = $row["pag_codigo"];
			$cui_pago = $row["pag_alumno"];
			$nombre_pago = utf8_decode($row["alu_nombre_completo"]);
			$codint = $row["pag_codigo_interno"];
			$referencia2 = $row["pag_referencia"];
			$fecha_pago = $row["pag_fechor"];
			$fecha_pago = cambia_fechaHora($fecha_pago);
			$fecha_pago = substr($fecha_pago,0,10);
			$monto_pago = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			$mons = $row["mon_simbolo"];
			$monto_pago = $mons." ".number_format($monto_pago, 2);
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
    </head>
<body>	

<div class="panel panel-default">
	<div class="panel-heading">
		<strong><i class="fa fa-exchange"></i> Intercambio de Boletas</strong>
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">
				<h5 class="text-primary ">Datos Originales de la Boleta Registrada</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-xs-offset-1"><label>Codigo de Boleta: </label> </div>
			<div class="col-xs-4 text-left">
				<span class="text-primary"># <?php echo Agrega_Ceros($codigo_boleta); ?></span>
				<input type="hidden" name="bolcod" id="bolcod" value="<?php echo $codigo_boleta; ?>">
				<input type="hidden" name="cuenta" id="cuenta" value="<?php echo $cuenta; ?>">
				<input type="hidden" name="banco" id="banco" value="<?php echo $banco; ?>">
			</div>
			<div class="col-xs-2 text-right"><label>No. de Referencia: </label> </div>
			<div class="col-xs-3 text-left">
				<input type="text" class="form-control" id="bolnumero" name="bolnumero" onkeyup="enteros(this);" value = "<?php echo $referencia1; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-xs-offset-1"><label>Fecha para pago: </label> </div>
			<div class="col-xs-4 text-left"><span class="text-primary"><?php echo $fecha; ?></span></div>
			<div class="col-xs-2 text-right"><label>Monto: </label> </div>
			<div class="col-xs-3 text-left"><span class="text-primary"><?php echo $monto; ?></span></div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-xs-offset-1"><label>Girada para: </label> </div>
			<div class="col-xs-4 text-left"><span class="text-primary"><?php echo $girada_a; ?></span></div>
			<div class="col-xs-2 text-right"><label>CUI: </label> </div>
			<div class="col-xs-2 text-left"><span class="text-primary"><?php echo $cui_girada_a; ?></span></div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-xs-offset-1"><label>Motivo: </label> </div>
			<div class="col-xs-9 text-left"><span class="text-primary"><?php echo $motivo; ?></span></div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">
				<h5 class="text-primary ">Datos de la Boleta en la Carga Electr&oacute;nica</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-xs-offset-1"><label>Codigo de Pago: </label> </div>
			<div class="col-xs-4 text-left">
				<span class="text-primary"># <?php echo Agrega_Ceros($codigo_pago); ?></span>
				<input type="hidden" name="pagcod" id="pagcod" value="<?php echo $codigo_pago; ?>">
			</div>
			<div class="col-xs-2 text-right"><label>No. de Referencia: </label> </div>
			<div class="col-xs-3 text-left">
				<input type="text" class="form-control" id="pagnumero" name="pagnumero" onkeyup="enteros(this);" value = "<?php echo $referencia2; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-xs-offset-1"><label>Fecha de Pago: </label> </div>
			<div class="col-xs-4 text-left"><span class="text-primary"><?php echo $fecha_pago; ?></span></div>
			<div class="col-xs-2 text-right"><label>Monto: </label> </div>
			<div class="col-xs-3 text-left"><span class="text-primary"><?php echo $monto_pago; ?></span></div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-xs-offset-1"><label>Pagado para: </label> </div>
			<div class="col-xs-4 text-left"><span class="text-primary"><?php echo $nombre_pago; ?></span></div>
			<div class="col-xs-2 text-right"><label>CUI:  </label> </div>
			<div class="col-xs-2 text-left"><span class="text-primary"><?php echo $cui_pago; ?></span></div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-default" id = "limp" onclick = "cerrar();"><span class="fa fa-times"></span> Cancelar</button>
				<button type="button" class="btn btn-primary" id = "mod" onclick = "CambiarPagosBoletas();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
			</div>
        </div>
	</div>
	<br>
</div>
</body>
</html>
