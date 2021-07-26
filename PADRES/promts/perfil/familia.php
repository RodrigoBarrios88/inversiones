<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$dpi = $_REQUEST['dpi'];

?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
<body>	
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-copy"></i>
		Copiar datos de familiar 
	</div>
	<div class="panel-body">
		<div class="row">
			<?php echo tabla_familia($dpi); ?>
		</div>
		<br>
		<div class="row">
			<div class="col-lg-12 text-center">
				<button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><i class="fa fa-times"></i> cerrar</button>
			</div>
		</div>
		<br>
	</div>
</div>
</body>
</html>
<?php

function tabla_familia($padre){
	$ClsAsig = new ClsAsignacion();
	$result = $ClsAsig->get_alumno_padre($padre,'');
	if(is_array($result)){
		$alumnos = '';
		foreach($result as $row){
			$alumnos.= $row["alu_cui"].",";
		}
		$alumnos = substr($alumnos,0,-1);
	}else{
		$alumnos = 'X';
	}
	
	$result = $ClsAsig->get_familia($padre, $alumnos);
	if(is_array($result)){
		$salida.= '<div class="panel-body users-list">';
		$salida.= '<div class="row-fluid table">';
		$salida.= '<table class="table table-hover">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "150px">Nombres</td>';
		$salida.= '<th class = "text-center" width = "150px">Parentesco</td>';
		$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//nombre
			$nombre = utf8_decode($row["pad_nombre"])." ".utf8_decode($row["pad_apellido"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//parentesco
			$parentesco = $row["pad_parentesco"];
			switch($parentesco){
				case "P": $parentesco = "Padre"; break;
				case "M": $parentesco = "Madre"; break;
				case "A": $parentesco = "Abuelo(a)"; break;
				case "O": $parentesco = "Encargado"; break;
			}
			$salida.= '<td class = "text-center">'.$parentesco.'</td>';
			//--
			$dpi = $row["pad_cui"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" onclick="xajax_Copiar_Datos_Familia(\''.$dpi.'\');" title="Copiar datos" class="btn btn-info"><i class="fa fa-link"></i></button> ';
			$salida.= '</td>';
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