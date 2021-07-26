<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	$x = $_REQUEST["formulario"];
	$suc = $_REQUEST["empCodigo"];
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel-body">
			<div class="row">
				<?php echo tabla_lista_servicios($grup,$nom,$desc); ?>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 text-center">
					<button type="button" class="btn btn-default" onclick = "cerrarModal();"><span class="fa fa-times"></span> Cerrar</button>
				</div>
			</div>
			<br>
		</div>
		<!-- Page-Level Demo Scripts - Tables - Use for reference -->
		<script>
			$(document).ready(function() {
				$('#dataTables-example2').DataTable({
					responsive: true
				});
			});
		</script>	
	</body>
</html>

<?php

function tabla_lista_servicios($grup,$nom,$desc){
	$ClsSer = new ClsServicio();
	$cont = $ClsSer->count_servicio($cod,$grup,$nom,$desc,$barc,1);
	
	if($cont>0){
		$result = $ClsSer->get_servicio($cod,$grup,$nom,$desc,$barc,1);
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example2">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "40px" height = "30px"></th>';
			$salida.= '<th class = "text-center" width = "50px">COD. ART.</th>';
			$salida.= '<th class = "text-center" width = "90px">GRUPO</th>';
			$salida.= '<th class = "text-center" width = "90px">BARCODE</th>';
			$salida.= '<th class = "text-center" width = "50px">PRECIO</th>';
			$salida.= '<th class = "text-center" width = "190px">NOMBRE</th>';
			$salida.= '<th class = "text-center" width = "280px">DESCRIPCI&Oacute;N</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$ser = $row["ser_codigo"];
			$gru = $row["gru_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="SeleccionarServicio('.$i.');" title = "Seleccionar Servicio" ><span class="fa fa-check"></span></button>';
			$salida.= '</td>';
			//codigo
			$ser = Agrega_Ceros($ser);
			$gru = Agrega_Ceros($gru);
			$codigo = $ser."A".$gru;
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Tacod'.$i.'" value = "'.$codigo.'" />';
			$salida.= $codigo.'</td>';
			//grupo
			$grun = $row["gru_nombre"];
			$pnit = "";
			$pnom = "";
			$pcod = "";
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Tagru'.$i.'" value = "'.$grun.'" />';
			$salida.= '<input type = "hidden" id = "Tpnit'.$i.'" value = "'.$pnit.'" />';
			$salida.= '<input type = "hidden" id = "Tpnom'.$i.'" value = "'.$pnom.'" />';
			$salida.= '<input type = "hidden" id = "Tpcod'.$i.'" value = "'.$pcod.'" />';
			$salida.= $grun.'</td>';
			//Barcode
			$barc = $row["ser_barcode"];
			$barc = ($barc != "")?$barc:"N/A";
			$cant = 100;
			$prec = $row["ser_precio_costo"];
			$prec = round($prec, 2);
			$prem = $row["ser_precio_costo"];
			$prem = round($prem, 2);
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Tbarc'.$i.'" value = "'.$barc.'" />';
			$salida.= '<input type = "hidden" id = "Tcant'.$i.'" value = "'.$cant.'" />';
			$salida.= $barc.'</td>';
			//precio
			$prev = $row["ser_precio_venta"];
			$prev = round($prev, 2);
			$mon = $row["mon_id"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Tmon'.$i.'" value = "'.$mon.'" />';
			$salida.= '<input type = "hidden" id = "Tprev'.$i.'" value = "'.$prev.'" />';
			$salida.= '<input type = "hidden" id = "Tprec'.$i.'" value = "'.$prec.'" />';
			$salida.= '<input type = "hidden" id = "Tprem'.$i.'" value = "'.$prem.'" />';
			$salida.= $mons.'. '.$prev.'</td>';
			//nombre
			$nom = $row["ser_nombre"];
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Tartn'.$i.'" value = "'.$nom.'" />';
			$salida.= $nom.'</td>';
			//desc
			$desc = $row["ser_desc"];
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Tdesc'.$i.'" value = "'.$desc.'" />';
			$salida.= $desc.'</td>';
			$salida.= '</tr>';
			//--
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


?>

