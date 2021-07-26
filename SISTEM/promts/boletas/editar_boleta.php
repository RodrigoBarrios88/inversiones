<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//--
	$pago = $_REQUEST["codigo"];
	
	$ClsBol = new ClsBoletaCobro();
	$ClsAlu = new ClsAlumno();
	$ClsPer = new ClsPeriodoFiscal();
	$periodo = $ClsPer->periodo;
/////////////////////////////////////////////////////////////////////////

	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_boleta_cobro($pago);
	
	if(is_array($result)){
		foreach($result as $row){
			$cuenta = trim($row["pag_cuenta"]);
			$banco = trim($row["pag_banco"]);
			$alumno = trim($row["pag_alumno"]);
			$boleta = trim($row["pag_programado"]);
			//
			$nombre_pago = utf8_decode($row["alu_nombre_completo"]);
			$nombre_pago = ($nombre_pago == "")?"No registrado...":$nombre_pago;
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
		<strong><i class="fa fa-link"></i> Enlace de Boletas por Alumnos NO Registrados</strong>
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
			<div class="col-xs-2 col-xs-offset-1"><label>Alumno: </label> </div>
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
		<hr>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">
				<h5 class="text-success">Alumnos Inscritos</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<?php echo tabla_alumnos($pago,$alumno); ?>
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

function tabla_alumnos($pago,$cuiIncorreocto){
	$pensum = $_SESSION["pensum"];
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,'','','','','','',1);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-pendientes">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px" height = "30px"></th>';
		$salida.= '<th class = "text-center" width = "40px">CUI</td>';
		$salida.= '<th class = "text-center" width = "250px">NOMBRE Y APELLIDO</td>';
		$salida.= '<th class = "text-center" width = "150px">GRADO</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		//--
		$hoy = date('Y-m-d');
		$i = 1;
		foreach($result as $row){
			///---
			$salida.= '<tr>';
			//--------
			$cui = trim($row["alu_cui"]);
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-primary" title="Enlazar Boleta con el Alumno" onclick = "ConfirmEnlazarPagoAlumno('.$pago.',\''.$cui.'\');" ><span class="fa fa-link"></span> Enlazar</button> ';
			$salida.= ' &nbsp; '.$iconos.'</td>';
			//cui
			$cui = trim($row["alu_cui"]);
			$salida.= '<td class = "text-center" >'.$cui.'</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left" >'.$nombre.'</td>';
			//Fecha de Pago
			$grado = utf8_decode($row["gra_descripcion"])." ".utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-left" >'.$grado.'</td>';
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