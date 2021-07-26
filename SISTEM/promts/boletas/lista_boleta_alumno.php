<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//--
	$alumno = $_REQUEST["alumno"];
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_cobro('','','',$alumno,'',date("Y"),'','','',1,2);
	
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
			$girada_a = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
		}
	}else{
		$codigo = "#";
		$referencia = $referencia;
		$motivo = "NO ESXISTE ESTA BOLETA...";
		$monto = "";
		$fecha = "";
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
		<i class="fa fa-copy"></i> Listado de la Boletas generadas al alumno
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body" id = "formulario">
		<?php if(is_array($result)){ ?>
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTables-modal">
					<thead>
					<tr>
						<th class = "text-center" width = "40px"><span class="glyphicon glyphicon-cog"></span></th>
						<th class = "text-center" width = "30px"># BOLETA</th>
						<th class = "text-center" width = "100px">BANCO</th>
						<th class = "text-center" width = "100px">CUENTA</th>
						<th class = "text-center" width = "100px">FECHA/PAGO</th>
						<th class = "text-center" width = "50px">MONTO</th>
						<th class = "text-center" width = "200px">MOTIVO</th>
						</tr>
						</thead>
				<?php
					$hoy = date('Y-m-d');
					$i = 0;	
					foreach($result as $row){
						$fecha = $row["bol_fecha_pago"];
						if(strtotime($hoy) > strtotime($fecha)){ /// pinta de celeste las fechas pasadas
							$class = 'info';
						}else{
							$class = '';
						}
						$ban = $row["ban_codigo"];
						$cue = $row["cueb_codigo"];
						$ban_desc = utf8_decode($row["ban_desc_ct"]);
						$cue_desc = utf8_decode($row["cueb_ncuenta"]);
						//Documento
						$pagado = $row["bol_pagado"];
						$doc = $row["bol_referencia"];
						//fecha de pago
						$fecha = $row["bol_fecha_pago"];
						$fecha = cambia_fecha($fecha);
						//Monto
						$mons = $row["mon_simbolo"];
						$monto = $row["bol_monto"];
						$monto_boleta = number_format($monto, 2, '.', '');
						//Motivo
						$motivo = utf8_decode($row["bol_motivo"]);
				?>
					<tr class = "<?php echo $class; ?>" >
						<td class = "text-center" >
							<button type="button" class="btn btn-success btn-xs" onclick="SeleccionarBoletaCobro(<?php echo $i; ?>);" title = "Seleccionar Boleta"><span class="fa fa-check"></span></button>
							<input type="hidden" id = "ban<?php echo $i; ?>" value = "<?php echo $ban; ?>" />
							<input type="hidden" id = "cue<?php echo $i; ?>" value = "<?php echo $cue; ?>" />
							<input type="hidden" id = "doc<?php echo $i; ?>" value = "<?php echo $doc; ?>" />
							<input type="hidden" id = "monto<?php echo $i; ?>" value = "<?php echo $monto; ?>" />
							<input type="hidden" id = "pagado<?php echo $i; ?>" value = "<?php echo $pagado; ?>" />
						</td>
						<td class = "text-center"><?php echo $doc; ?></td>
						<td class = "text-center"><?php echo $ban_desc; ?></td>
						<td class = "text-center"><?php echo $cue_desc; ?></td>
						<td class = "text-center"><?php echo $fecha; ?></td>
						<td class = "text-center"><?php echo $mons.'. '.$monto_boleta; ?></td>
						<td class = "text-left"><?php echo $motivo; ?></td>
					</tr>
				<?php
						$i++;
					}
				?>
				</table>
			</div>
	<?php } ?>
	</div>
	<script>
		$(document).ready(function() {
			$('#dataTables-modal').DataTable({
				pageLength: 10,
				responsive: true
			});
	    });
    </script>	
</body>
</html>
