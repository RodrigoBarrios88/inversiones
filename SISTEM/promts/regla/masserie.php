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
				<i class="fa fa-file-text-o"></i> Gestor de Serie de Facturas
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>N&uacute;mero o Letra: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-5"><label>Descripci&oacute;n: </label><span class = "text-danger">*</span></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<input type = "text" class = "form-control" name = "num1" id = "num1" onkeyup = "texto(this)" />
						<input type = "hidden" name = "cod1" id = "cod1" />
					</div>
					<div class="col-xs-5">
						<input type = "text" class = "form-control" name = "desc1" id = "desc1" onkeyup = "texto(this)" />
					</div>
				</div>
				<br><br>
				<div class="row">
					<div class="col-xs-12 text-center">
					    <button type="button" class="btn btn-default" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
						<button type="button" class="btn btn-primary" id = "gra" onclick = "GrabarSerie();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
                        <button type="button" class="btn btn-primary hidden" id = "mod" onclick = "ModificarSerie();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
					 </div>
				</div>
				<br>
				<?php echo tabla_series(); ?>
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
function tabla_series(){
	 $ClsFac = new ClsFactura();
	$result = $ClsFac->get_serie('');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "100px">N&Uacute;MERO O LETRA</th>';
			$salida.= '<th class = "text-center" width = "200px">DESCRIPCI&Oacute;N</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["ser_codigo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Buscar_Serie('.$cod.')" title = "Editar Datos de la Serie de Factura" ><span class="fa fa-pencil"></span></button>';
			$salida.= '</td>';
			//nombre
			$nom = utf8_decode($row["ser_numero"]);
			$salida.= '<td class = "text-center">'.$nom.'</td>';
			//simbolo
			$desc = utf8_decode($row["ser_descripcion"]);
			$salida.= '<td class = "text-center">'.$desc.'</td>';
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
