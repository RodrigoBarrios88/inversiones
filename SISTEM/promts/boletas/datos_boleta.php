<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//--
	$ClsPer = new ClsPeriodoFiscal();
	if($_REQUEST["periodo"] == ""){
		$periodo = $ClsPer->get_periodo_pensum($pensum);
	}else{
		$periodo = $_REQUEST["periodo"];
	}
	$boleta = $_REQUEST["boleta"];
	$alumno = $_REQUEST["alumno"];
	
	$ClsBol = new ClsBoletaCobro();
	$ClsAlu = new ClsAlumno();
	$ClsCli = new ClsCliente();
	$result = $ClsBol->get_boleta_cobro($boleta);
	if(is_array($result)){
		foreach($result as $row){
			$codigo = $row["bol_codigo"];
			$referencia = $row["bol_referencia"];
			$motivo = utf8_decode($row["bol_motivo"]);
			$fecha = $row["bol_fecha_pago"];
			$fecha = cambia_fecha($fecha);
			$mons = $row["mon_simbolo"];
			$monto = $row["bol_monto"];
			$monto = number_format($monto, 2);
			$monto = $mons.'. '.$monto;
			$girada_a = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			$cui_girada_a = $row["alu_cui"];;
		}
	}else{
		$result = $ClsBol->get_pago_boleta_cobro('', '', '', $alumno, '', $periodo, '', $boleta);
		if(is_array($result)){
			foreach($result as $row){
				$codigo = "#".$row["pag_programado"];
				$referencia = $row["pag_referencia"];
				$motivo = "Esta boleta no est&aacute; registrada...";
				$fecha = "---";
				$mons = $row["mon_simbolo"];
				$monto = floatval($row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"]);
				$monto = $mons.'. '.number_format($monto, 2,'.',',');
				$girada_a = "---";
				$cui_girada_a = "---";
			}	
		}	
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
		<i class="fa fa-money"></i> Datos de la Boleta
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">
			<div class="row">
				<div class="col-xs-10 col-xs-offset-1 text-center">
					<h5 class="text-primary ">Datos de la Boleta</h5>
				</div>
            </div>
			<div class="row">
				<div class="col-xs-4">
					<label>No. de Boleta: </label><br>
					<input type="text" class="form-info" value=" # <?php echo Agrega_Ceros($codigo); ?>" />
				</div>
				<div class="col-xs-4">
					<label>No. de Referencia: </label><br>
					<input type="text" class="form-info" value=" <?php echo $referencia; ?>" />
				</div>
				<div class="col-xs-4">
					<label>Fecha de Pago: </label> <br>
					<input type="text" class="form-info" value=" <?php echo $fecha; ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<label>Monto: </label><br>
					<input type="text" class="form-info" value=" <?php echo $monto; ?>" />
				</div>
				<div class="col-xs-4">
					<label>Girada para: </label><br>
					<input type="text" class="form-info" value=" <?php echo $girada_a; ?>" />
				</div>
				<div class="col-xs-4">
					<label>CUI: </label><br>
					<input type="text" class="form-info" value=" <?php echo $cui_girada_a; ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<label>Motivo: </label><br>
					<input type="text" class="form-info" value=" <?php echo $motivo; ?>" />
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-xs-10 col-xs-offset-1 text-center">
					<h5 class="text-primary ">Datos del Alumno</h5>
				</div>
            </div>
			<div class="row">
				<div class="col-xs-5 col-xs-offset-1">
					<label>Nombre: </label><br>
					<input type="text" class="form-info" value=" <?php echo $alumno; ?>" />
				</div>
				<div class="col-xs-5">
					<label>CUI: </label><br>
					<input type="text" class="form-info" value=" <?php echo $cui; ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-xs-5 col-xs-offset-1">
					<label>Nombre a Facturar: </label><br>
					<input type="text" class="form-info" value=" <?php echo $cliente; ?>" />
				</div>
				<div class="col-xs-5">
					<label>Nit a Facturar: </label><br>
					<input type="text" class="form-info" value=" <?php echo $nit; ?>" />
				</div>
			</div>
		<br><br>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-success" id = "limp" onclick = "cerrarModal();"> &nbsp;&nbsp;&nbsp; <span class="fa fa-check"></span> Ok &nbsp;&nbsp;&nbsp; </button>
			</div>
        </div>
		<br>
	</div>
</div>
</body>
</html>
