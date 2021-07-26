<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//--
	$codigo = $_REQUEST["codigo"];
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_cobro($codigo);
	$i = 0;
	if(is_array($result)){
		foreach($result as $row){
			$alumno = $row["bol_alumno"];
			$referencia.= $row["bol_referencia"].", ";
			$fecha = $row["bol_fecha_pago"];
			$fecha = cambia_fecha($fecha);
			$monto = $row["bol_monto"];
			$mons = $row["mon_simbolo"];
			$monto = $mons." ".number_format($monto, 2);
			$i++;
		}
		$referencia = substr($referencia, 0, -2);
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
		<i class="fa fa-money"></i> Informaci&oacute;n de las Boletas a Anular
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">
				<h5 class="text-danger "> <span class="fa fa-times"></span> Anulaci&oacute;n de Boletas de Pago</h5>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
				<label>CUI (Alumno): </label>
				<label class="form-info"><?php echo $alumno; ?></label>
				<input type="hidden" id="codigo1" name="codigo1" value = "<?php echo $codigo; ?>" />
				<input type="hidden" id="cue1" name="cue1" value = "<?php echo $cuenta; ?>" />
				<input type="hidden" id="ban1" name="ban1" value = "<?php echo $banco; ?>" />
				<input type="hidden" id="cui1" name="cui1" value = "<?php echo $alumno; ?>" />
			</div>
			<div class="col-xs-5">
				<label>No. de Referencia(s): </label>
				<label class="form-info"><?php echo $referencia; ?></label>
			</div>
		</div>
		<?php if($i == 1){ ?>
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
				<label>Fecha de Pago: </label>
				<label class="form-info"><?php echo $fecha; ?></label>
			</div>
			<div class="col-xs-5">
				<label>Monto: </label> 
				<label class="form-info"><?php echo $monto; ?></label>
			</div>
		</div>
		<?php } ?>
		<hr>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1"><label>Motivo:</label></div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<textarea class="form-control" id="motivo1" name="motivo1" rows="3" onkeyup="texto(this);" ></textarea>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-default" id = "limp" onclick = "cerrar();"><span class="fa fa-times"></span> Cancelar</button>
				<button type="button" class="btn btn-danger" id = "mod" onclick = "EliminarBoleta();"><span class="fa fa-trash-o"></span> Eliminar</button>
			</div>
		</div>
		<br>
	</div>
</div>
</body>
</html>
