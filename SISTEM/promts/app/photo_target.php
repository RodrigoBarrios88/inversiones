<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$codigo = $_REQUEST['codigo'];
	
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAlu = new ClsAlumno();
	
	if($tipo_usuario === "1"){ /// SI el Usuario es Director
		$pensum = $ClsPen->get_pensum_activo();
		$result_alumnos = $ClsAcad->get_otros_usuarios_alumnos($pensum,'','',$tipo_codigo);
	}else if($tipo_usuario === "2"){ /// SI el Usuario es Maestro
		$pensum = $ClsPen->get_pensum_activo();
		$result_alumnos = $ClsAcad->get_maestro_alumnos($pensum,'','','',$tipo_codigo);
	}else{ // Si el Usuario es Administrador
		$result_alumnos = $ClsAcad->get_seccion_alumno($pensum,'','','','');
	}	
	
	$ClsPho = new ClsPhoto();
	$result = $ClsPho->get_photos_alumno($codigo);
	$arralumnos = array();
	$seleccionados = 0;
	if(is_array($result)){
		foreach($result as $row){
			$arralumnos[$seleccionados] = trim(utf8_decode($row["tpho_alumno"]));
			//$arralumnos[$seleccionados]." ".$seleccionados;
			$seleccionados++;
		}	
	}	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
<body>	
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-pencil"></i>
		Editar la descripci&oacute;n del Album
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Alumnos:</label>
				<input type = "hidden" id="codigo" name = "codigo" value="<?php echo $codigo; ?>" />
				<?php
				if(is_array($result_alumnos)){
					$combo_alumnos = '<select name="target" id="target"  class = "form-control chosen-select" data-placeholder="Seleccione..." multiple >';
					$seccionX = '';
					$i = 1; ///primera vuelta
					foreach ($result_alumnos as $row) {
						///////////////////////////// abre y cierra Optiosgroup
						$seccion = utf8_decode(trim($row["gra_descripcion"]))." ".utf8_decode(trim($row["sec_descripcion"]));
						if($seccionX != $seccion){
							if($i > 1){
							$combo_alumnos.= '</optgroup>'; /// Si no es la primera viuelta ( > 1 ), cierra el optgroup
							}
							$combo_alumnos.= '<optgroup label="'.$seccion.'">';
							$seccionX = $seccion;
						}
						/////////////////////////////// Checkea seleccionados
						$cui = trim($row['alu_cui']);
						if(is_array($arralumnos)){
							for($j = 0; $j <= $seleccionados; $j++){
								$cui_seleccionado = $arralumnos[$j];
								if($cui == $cui_seleccionado){
									//echo "$cui == $cui_seleccionado ($i) <br>";
									$selected = 'selected';
									break;
								}else{
									$selected = '';
								}
							}
						}
						//
						$nombres = utf8_decode($row['alu_nombre'])." ".utf8_decode($row['alu_apellido']);
						$combo_alumnos.= '<option value="'.trim($row['alu_cui']).'" '.$selected.' >'.$nombres.'</option>';
						$i++;
					}
					$combo_alumnos.='</select>';
				}else{
					$combo_alumnos = combos_vacios("target");
				}
				
				echo $combo_alumnos;
				?>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-default" onclick = "cerrarModal();"><i class="fa fa-times"></i> Cerrar</button>
				<button type="button" class="btn btn-primary" onclick = "ModificarTarget();"><i class="fa fa-save"></i> Grabar</button>
			</div>
		</div>
		<br>
	</div>
</div>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
	$('.chosen-select').chosen();
</script>	
</body>
</html>