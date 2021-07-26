<?php
	include_once('../../html_fns.php');
	//--
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
		$codigo = "#";
		$referencia = $referencia;
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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
    </head>
<body>	

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fas fa-file-alt"></i> Datos de la Boleta
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1 text-center">
					<h5 class="text-primary "> Datos de la Boleta</h5>
				</div>
            </div>
			<div class="row">
				<div class="col-md-2 col-md-offset-1"><label>No. de Boleta: </label> </div>
				<div class="col-md-4 text-left"><label class="text-primary"># <?php echo Agrega_Ceros($codigo); ?></label></div>
				<div class="col-md-2 text-right"><label>No. de Referencia: </label> </div>
				<div class="col-md-3 text-left"><label class="text-primary"><?php echo $referencia; ?></label></div>
			</div>
			<div class="row">
				<div class="col-md-2 col-md-offset-1"><label>Fecha de Pago: </label> </div>
				<div class="col-md-4 text-left"><label class="text-primary"><?php echo $fecha; ?></label></div>
				<div class="col-md-2 text-right"><label>Monto: </label> </div>
				<div class="col-md-3 text-left"><label class="text-primary"><?php echo $monto; ?></label></div>
            </div>
			<div class="row">
				<div class="col-md-2 col-md-offset-1"><label>Girada para: </label> </div>
				<div class="col-md-4 text-left"><label class="text-primary"><?php echo $girada_a; ?></label></div>
				<div class="col-md-2 text-right"><label>CUI: </label> </div>
				<div class="col-md-2 text-left"><label class="text-primary"><?php echo $cui_girada_a; ?></label></div>
			</div>
			<div class="row">
				<div class="col-md-2 col-md-offset-1"><label>Motivo: </label> </div>
				<div class="col-md-9 text-left"><label class="text-primary"><?php echo $motivo; ?></label></div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-10 col-md-offset-1 text-center">
					<h5 class="text-primary ">Datos del Alumno</h5>
				</div>
            </div>
			<div class="row">
				<div class="col-md-2 col-md-offset-1"><label>Nombre: </label> </div>
				<div class="col-md-4 text-left"><label class="text-primary"><?php echo $alumno; ?></label></div>
				<div class="col-md-2 text-right"><label>CUI: </label> </div>
				<div class="col-md-3 text-left"><label class="text-primary"><?php echo $cui; ?></label></div>
			</div>
			<div class="row">
				<div class="col-md-2 col-md-offset-1"><label>Nombre a Facturar: </label> </div>
				<div class="col-md-4 text-left"><label class="text-primary"><?php echo $cliente; ?></label></div>
				<div class="col-md-2 text-right"><label>Nit: </label> </div>
				<div class="col-md-3 text-left"><label class="text-primary"><?php echo $nit; ?></label></div>
			</div>
		<br><br>
		<div class="row">
			<div class="col-md-6 col-md-offset-3 text-center">
				<button type="button" class="btn btn-success" id = "limp" onclick = "cerrarModal();"> &nbsp;&nbsp;&nbsp; <i class="fa fa-check"></i> Ok &nbsp;&nbsp;&nbsp; </button>
			</div>
        </div>
	<br>
</div>
</body>
</html>