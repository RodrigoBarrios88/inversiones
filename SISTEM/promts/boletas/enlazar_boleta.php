<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//--
	$pago = $_REQUEST["codigo"];
	$periodo = $_REQUEST["periodo"];
	
	$ClsBol = new ClsBoletaCobro();
	$ClsAlu = new ClsAlumno();
	$ClsPer = new ClsPeriodoFiscal();
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo;
/////////////////////////////////////////////////////////////////////////

	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_boleta_cobro($pago);
	
	if(is_array($result)){
		foreach($result as $row){
			$cuenta = trim($row["pag_cuenta"]);
			$banco = trim($row["pag_banco"]);
			$alumno = trim($row["pag_alumno"]);
			//
			$nombre_pago = utf8_decode($row["alu_nombre_completo"]);
			$codint = $row["pag_codigo_interno"];
			$referencia = trim($row["pag_referencia"]);
			$fecha_pago = $row["pag_fechor"];
			$fecha_pago = cambia_fechaHora($fecha_pago);
			$fecha_pago = substr($fecha_pago,0,10);
			$monto_pago = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			$mons = $row["mon_simbolo"];
			$monto_pago = $mons." ".number_format($monto_pago, 2);
			//--
			$banco_nombre = utf8_decode($row["ban_desc_ct"]);
			$cuenta_nombre = utf8_decode($row["cueb_nombre"]);
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
		<strong><i class="fa fa-link"></i> Enlace de Boletas por Pagos Aislados</strong>
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">
				<h5 class="text-primary">Datos de la Boleta en la Carga Electr&oacute;nica</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-xs-offset-1"><label>Codigo de Pago: </label> </div>
			<div class="col-xs-4 text-left">
				<label class="text-primary"># <?php echo Agrega_Ceros($pago); ?></label>
				<input type="hidden" name="pagcod" id="pagcod" value="<?php echo $pago; ?>">
				<input type="hidden" name="pagboleta" id="pagboleta" value="<?php echo $referencia; ?>">
			</div>
			<div class="col-xs-2 text-right"><label>No. de Referencia: </label> </div>
			<div class="col-xs-3 text-left"><label class="text-primary"><?php echo $referencia; ?></label></div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-xs-offset-1"><label>Fecha de Pago: </label> </div>
			<div class="col-xs-4 text-left"><label class="text-primary"><?php echo $fecha_pago; ?></label></div>
			<div class="col-xs-2 text-right"><label>Monto: </label> </div>
			<div class="col-xs-3 text-left"><label class="text-primary"><?php echo $monto_pago; ?></label></div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-xs-offset-1"><label>Pagado para: </label> </div>
			<div class="col-xs-4 text-left"><label class="text-primary"><?php echo $nombre_pago; ?></label></div>
			<div class="col-xs-2 text-right"><label>CUI:  </label> </div>
			<div class="col-xs-2 text-left"><label class="text-primary"><?php echo $alumno; ?></label></div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-xs-offset-1"><label>Cuenta:  </label> </div>
			<div class="col-xs-4 text-left"><label class="text-primary"><?php echo $cuenta_nombre; ?></label></div>
			<div class="col-xs-2 text-right"><label>Banco: </label> </div>
			<div class="col-xs-2 text-left"><label class="text-primary"><?php echo $banco_nombre; ?></label></div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-xs-offset-1"><label>Perido Fiscal:  </label> </div>
			<div class="col-xs-4 text-left">
				<?php echo periodo_fiscal_html("periodo","EnlazarBoletaPeriodo($pago,this.value);"); ?>
				<script type="text/javascript">
					document.getElementById("periodo").value = "<?php echo $periodo; ?>";
				</script>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">
				<h5 class="text-success">Boletas Programadas del Alumno (Pendientes de Pago)</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12" id="promt-result">
				<?php echo tabla_estado_cuenta_programado($pago,$cuenta,$banco,$alumno,$periodo,$referencia); ?>
			</div>
        </div>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-default" onclick="cerrar();"><i class="fa fa-close"></i> Cancelar</button>
			</div>
        </div>
	</div>
	<br>
</div>
	<script>
		$(document).ready(function() {
			$('#dataTables-pendientes').DataTable({
				pageLength: 100,
				responsive: true
			});
		});
    </script>	
</body>
</html>
<?php

function tabla_estado_cuenta_programado($pago,$cuenta,$banco,$alumno,$periodo,$nuevoNumero){
	
	//echo "$pago,$cuenta,$banco,$alumno,$periodo,$nuevoNumero";
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_cobro('',$cuenta,$banco,$alumno,'',$periodo,'','','',1,2,0);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-pendientes">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px" height = "30px"></th>';
		$salida.= '<th class = "text-center" width = "20px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "30px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "50px">FECHA LIMITE</th>';
		$salida.= '<th class = "text-center" width = "50px">MOTIVO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		//--
		$hoy = date('Y-m-d');
		$i = 1;
		foreach($result as $row){
			///---
			$salida.= '<tr>';
			//--------
			$codigo = $row["bol_codigo"];
			$cuenta = $row["bol_cuenta"];
			$banco = $row["bol_banco"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-primary" title="Enlazar Boleta con el Pago" onclick = "ConfirmEnlazarBoletas('.$codigo.',\''.$nuevoNumero.'\','.$pago.','.$periodo.');" ><span class="fa fa-link"></span> Enlazar</button> ';
			$salida.= ' &nbsp; '.$iconos.'</td>';
			//boleta
			$referencia = $row["bol_referencia"];
			$referencia_label = ($pagado == 1)?'<label class = "text-info">'.$referencia.'</label>':$referencia;
			$salida.= '<td class = "text-center" >'.$referencia_label.'</td>';
			//monto
			$valor = $row["bol_monto"];
			$mons = $row["mon_simbolo"];
			$valor = number_format($valor, 2);
			$valor_label = ($pagado == 1)?'<label class = "text-info">'.$mons.'. '.$valor.'</label>':$mons.'. '.$valor;
			$salida.= '<td class = "text-center" >'.$valor_label.'</td>';
			//Fecha de Pago
			$fecha = $row["bol_fecha_pago"];
			$fecha = cambia_fechaHora($fecha);
			$fecha_label = ($pagado == 1)?'<label class = "text-info">'.$fecha.'</label>':$fecha;
			$salida.= '<td class = "text-center" >'.$fecha_label.'</td>';
			//motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			$motivo_label = ($pagado == 1)?'<label class = "text-info">'.$motivo.'</label>':$motivo;
			$salida.= '<td class = "text-left" >'.$motivo_label.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$i--; //quita la ultima fila para cuadrar cantidades
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}

?>
