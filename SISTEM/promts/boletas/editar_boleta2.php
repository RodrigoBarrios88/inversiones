<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//--
	$codigo = $_REQUEST["codigo"];
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_boleta_cobro($codigo);
	
	if(is_array($result)){
		foreach($result as $row){
			$cod = $row["pag_codigo"];
			$alumno = $row["pag_alumno"];
			$codint = $row["pag_codigo_interno"];
			$referencia = $row["pag_referencia"];
			$fecha = $row["pag_fechor"];
			$fecha = cambia_fechaHora($fecha);
			$hora = substr($fecha,11,5);
			$fecha = substr($fecha,0,10);
			$monto = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			$mons = $row["mon_simbolo"];
			//$monto = $mons." ".number_format($monto, 2);
			$motivo = $row["bol_motivo"];
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
                <button type="button" onclick="cerrarModal();" class="btn btn-default btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
				<label>CUI (Alumno):</label>
				<input type="text" class="form-control" id="cui" name="cui" onkeyup="enteros(this);" value = "<?php echo $alumno; ?>" />
				<input type="hidden" id="codint" name="codint" value = "<?php echo $codint; ?>" />
				<input type="hidden" id="cod" name="cod" value = "<?php echo $codigo; ?>" />
			</div>
			<div class="col-xs-5">
				<label>No. de Referencia: </label>
				<input type="text" class="form-control" id="boleta" name="boleta" onkeyup="enteros(this);" value = "<?php echo $referencia; ?>" disabled />
			</div>
		</div>
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
				<label>Monto:</label>
				<input type="text" class="form-control" id="monto" name="monto" onkeyup="enteros(this);" value = "<?php echo $monto; ?>" disabled />
			</div>
			<div class="col-xs-3">
				<label>Fecha de Pago: </label>
				<div class='input-group date' id='fec'>
					<input type='text' class="form-control" id = "fecha" name='fecha' value = "<?php echo $fecha; ?>" disabled />
					<span class="input-group-addon">
						<span class="fa fa-calendar"></span>
					</span>
				</div>
			</div>
			<div class="col-xs-2">
				<label>Fecha de Pago: </label>
				<div class="form-group">
					<div class="input-group clockpicker" data-autoclose="true">
						<input type="text" class="form-control" name = "hora" id = "hora" value = "<?php echo $hora; ?>" disabled >
						<span class="input-group-addon">
							<span class="fa fa-clock-o"></span>
						</span>
					</div>
				 </div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Motivo de la Boleta:</label>
				<textarea  class="form-control" name = "motivo" id = "motivo" rows="5" disabled= ><?php echo $motivo; ?></textarea>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-default" id = "limp" onclick = "cerrar();"><span class="fa fa-times"></span> Cancelar</button>
				<button type="button" class="btn btn-primary" id = "mod" onclick = "EditarPagosCarga();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
			</div>
        </div>
		<br>
	</div>
</div>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(function () {
            $('#fecha').datetimepicker({
                format: 'DD/MM/YYYY'
            });
			
			$('.clockpicker').clockpicker();
        });
    </script>	
</body>
</html>
