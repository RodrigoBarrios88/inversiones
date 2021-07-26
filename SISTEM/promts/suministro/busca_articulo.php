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
				<?php echo tabla_lista_suministros($grup,$nom,$desc,$marca,$barc,$suc,1); ?>
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
				$('#dataTables-example').DataTable({
					responsive: true
				});
			});
		</script>	
	</body>
</html>

<?php

function tabla_lista_suministros($grup,$nom,$desc,$marca,$barc,$suc,$x){
	$ClsArt = new ClsSuministro();
	$cont = $ClsArt->count_articulo($cod,$grup,$nom,$desc,$marca,'','',$barc,1,$suc);
	
	if($cont>0){
		$result = $ClsArt->get_articulo($cod,$grup,$nom,$desc,$marca,'','',$barc,1,$suc);
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "40px" height = "30px"></th>';
			$salida.= '<th class = "text-center" width = "50px">COD. ART.</th>';
			$salida.= '<th class = "text-center" width = "70px">GRUPO</th>';
			$salida.= '<th class = "text-center" width = "70px">BARCODE</th>';
			$salida.= '<th class = "text-center" width = "50px">PRECIO</th>';
			$salida.= '<th class = "text-center" width = "170px">NOMBRE</th>';
			$salida.= '<th class = "text-center" width = "150px">MARCA</th>';
			$salida.= '<th class = "text-center" width = "150px">PROVEEDOR</th>';
			$salida.= '<th class = "text-center" width = "200px">DESCRIPCI&Oacute;N</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$art = $row["art_codigo"];
			$gru = $row["gru_codigo"];
			if($x == 1){
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="SeleccionarArticulo('.$i.');" title = "Seleccionar Articulo" ><span class="fa fa-check"></span></button>';
			$salida.= '</td>';
			}else if($x == 1){
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Listar_Lotes('.$gru.','.$art.','.$i.');" title = "Ver Lotes de este Articulo" ><span class="fa fa-chevron-down"></span></button>';
			$salida.= '</td>';
			}else if($x == 3){
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Listar_Lotes('.$gru.','.$art.','.$suc.','.$i.');" title = "Ver Lotes de este Articulo" ><span class="fa fa-chevron-down"></span></button>';
			$salida.= '</td>';
			}
			//codigo
			$art = Agrega_Ceros($art);
			$gru = Agrega_Ceros($gru);
			$codigo = $art."A".$gru;
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Tacod'.$i.'" value = "'.$codigo.'" />';
			$salida.= $codigo.'</td>';
			//grupo
			$grun = utf8_decode($row["gru_nombre"]);
			$pnit = $row["prov_nit"];
			$pnom = utf8_decode($row["prov_nombre"]);
			$pcod = $row["prov_id"];
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Tagru'.$i.'" value = "'.$grun.'" />';
			$salida.= '<input type = "hidden" id = "Tpnit'.$i.'" value = "'.$pnit.'" />';
			$salida.= '<input type = "hidden" id = "Tpnom'.$i.'" value = "'.$pnom.'" />';
			$salida.= '<input type = "hidden" id = "Tpcod'.$i.'" value = "'.$pcod.'" />';
			$salida.= $grun.'</td>';
			//Barcode
			$barc = $row["art_barcode"];
			$barc = ($barc != "")?$barc:"N/A";
			$cant = $row["art_cant_suc"];
			$prec = $row["art_precio_costo"];
			$prec = round($prec, 2);
			$prem = $row["art_precio_manufactura"];
			$prem = round($prem, 2);
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Tbarc'.$i.'" value = "'.$barc.'" />';
			$salida.= '<input type = "hidden" id = "Tcant'.$i.'" value = "'.$cant.'" />';
			$salida.= $barc.'</td>';
			//precio
			$prev = $row["art_precio"];
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
			$nom = utf8_decode($row["art_nombre"]);
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Tartn'.$i.'" value = "'.$nom.'" />';
			$salida.= $nom.'</td>';
			//marca
			$marca = utf8_decode($row["art_marca"]);
			$salida.= '<td class = "text-center">'.$marca.'</td>';
			//proveedor
			$provee = utf8_decode($row["prov_nombre"]);
			$salida.= '<td class = "text-center">'.$provee.'</td>';
			//desc
			$desc = utf8_decode($row["art_desc"]);
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
