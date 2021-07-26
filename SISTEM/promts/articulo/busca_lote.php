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
		<br>
		<form name = "f1" id = "f1" onsubmit = "return false;">
			<h3 class="encabezado"> Busqueda de Art&iacute;culos </h3>
				<table>
						<tr>
							<td colspan = "4" align = "right">
								<span class = "obligatorio">* Campos Obligatorios</span>
								<span class = "busqueda">* Campos de Busqueda</span>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Grupo: <span class = "busca">*</span></td>
							<td>
								<?php echo grupo_art_html("gru1"); ?>
								<input type = "hidden" name = "suc1" id = "suc1" value = "<?php echo $suc; ?>" />
							</td>
							<td class = "celda" align = "right">Marca: <span class = "busca">*</span></td>
							<td><input type = "text" class = "text" name = "amarca1" id = "amarca1" onkeyup = "texto(this);" onblur = "BuscarArticulo(<?php echo $x; ?>)" /></td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Nombre: <span class = "busca">*</span></td>
							<td><input type = "text" class = "text" name = "anom1" id = "anom1" onkeyup = "texto(this);" onblur = "BuscarArticulo(<?php echo $x; ?>)" /></td>
							<td class = "celda" align = "right">Descripci&oacute;n: <span class = "busca">*</span></td>
							<td align = "right"><input type = "text" class = "text" name = "adesc1" id = "adesc1" onkeyup = "texto(this);" onblur = "BuscarArticulo(<?php echo $x; ?>)" /></td>
						</tr>
						<tr>
							<td colspan = "4" align = "center">
								<div class = "boxboton" style = "width:200px;">
								<br>
									<a class="button" href="javascript:void(0)" onclick = "BuscarArticulo(<?php echo $x; ?>)" ><img src="../../CONFIG/images/icons/search.png" class="icon" > Buscar</a>
									<a class="button" href="javascript:void(0)" onclick = "cerrarBigPromt();"><img src="../../CONFIG/images/icons/cancel.png" class="icon" > Cancelar</a>
								</div>
							</td>
						</tr>
				</table>
				<div id = "resultArt" align = "center"></div>
		</form>	
	</body>
</html>


<?php

function tabla_lista_lotes_suministros($grup,$art,$suc,$fila){
	$ClsArt = new ClsArticulo();
	$cont = $ClsArt->count_lote("",$grup,$art,"",$suc);
	
	if($cont>0){
		$result = $ClsArt->get_lote("",$grup,$art,"",$suc);
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "60px" height = "30px"></th>';
			$salida.= '<th class = "text-center" width = "70px">CODIGO DE LOTE</th>';
			$salida.= '<th class = "text-center" width = "200px">ARTICULO</th>';
			$salida.= '<th class = "text-center" width = "70px">CANTIDAD</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$lot = $row["lot_codigo"];
			$art = $row["art_codigo"];
			$gru = $row["gru_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="SeleccionarLote('.$fila.','.$i.');" title = "Seleccionar Lote" ><span class="fa fa-check"></span></button>';
			$salida.= '</td>';
			//Codigo
			$lot = Agrega_Ceros($lot);
			$art = Agrega_Ceros($art);
			$gru = Agrega_Ceros($gru);
			$codigo = $lot."A".$art."A".$gru;
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Lacod'.$fila.'_'.$i.'" value = "'.$codigo.'" />';
			$salida.= $codigo.'</td>';
			//nombre
			$nom = $row["art_nombre"];
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Lartn'.$fila.'_'.$i.'" value = "'.$nom.'" />';
			$salida.= $nom.'</td>';
			//Cantidad
			$desc = $row["lot_cantidad"];
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Lacant'.$fila.'_'.$i.'" value = "'.$desc.'" />';
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
