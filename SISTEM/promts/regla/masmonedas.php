<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-money"></i> Gestor de Monedas
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Nombre de la Moneda: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-5"><label>Simbolo: </label><span class = "text-danger">*</span></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<input type = "text" class = "form-control" name = "desc1" id = "desc1" onkeyup = "texto(this)" />
						<input type = "hidden" name = "cod1" id = "cod1" />
					</div>
					<div class="col-xs-5">
						<input type = "text" class = "form-control" name = "simb1" id = "simb1" onkeyup = "texto(this)" maxlength="1" />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Pa&iacute;s: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-5"><label>Tasa de Cambio: </label><span class = "text-danger">*</span></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<input type = "text" class = "form-control" name = "pais1" id = "pais1" onkeyup = "texto(this)" />
					</div>
					<div class="col-xs-5">
						<input type = "text" class = "form-control" name = "cambio1" id = "cambio1" onkeyup = "decimales(this)" />
					</div>
				</div>
				<br><br>
				<div class="row">
					<div class="col-xs-12 text-center">
					    <button type="button" class="btn btn-default" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
						<button type="button" class="btn btn-primary" id = "gra" onclick = "GrabarMoneda();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
                        <button type="button" class="btn btn-primary hidden" id = "mod" onclick = "ModificarMoneda();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
					 </div>
				</div>
				<br>
				<?php echo tabla_monedas(); ?>
			</div>		
		</div>	
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
function tabla_monedas(){
	$ClsMon = new ClsMoneda();
	$result = $ClsMon->get_moneda($cod);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "50px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "150px">NOMBRE DE LA MONEDA</th>';
			$salida.= '<th class = "text-center" width = "30px">SIMBOLO</th>';
			$salida.= '<th class = "text-center" width = "100px">PAIS</td>';
			$salida.= '<th class = "text-center" width = "100px">TASA/CAMBIO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["mon_id"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Buscar_Moneda('.$cod.')" title = "Editar Datos de la Moneda" ><span class="fa fa-pencil"></span></button>';
			$salida.= '</td>';
			//nombre
			$nom = utf8_decode($row["mon_desc"]);
			$salida.= '<td class = "text-center">'.$nom.'</td>';
			//simbolo
			$simbolo = $row["mon_simbolo"];
			$salida.= '<td class = "text-center">'.$simbolo.'</td>';
			//codigo
			$pais = $row["mon_pais"];
			$salida.= '<td class = "text-center">'.$pais.'</td>';
			//cambio
			$tasa = utf8_decode($row["mon_cambio"]);
			$salida.= '<td class = "text-center">'.$tasa.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

?>
