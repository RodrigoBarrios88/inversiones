<?php 
include_once('../../html_fns.php');


function tabla_grupos_alumnos($grupo){
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_alumno_grupo($grupo,'','');
	
	if(is_array($result)){
          $salida.= '<div class="panel-body">';
          $salida.= '<div class="dataTable_wrapper">';
          $salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
          $salida.= '<thead>';
          $salida.= '<tr>';
          $salida.= '<th width = "10px" class = "text-center">No.</td>';
          $salida.= '<th class = "text-center" width = "60px">ID</td>';
          $salida.= '<th class = "text-center" width = "60px">TIPO ID</td>';
          $salida.= '<th class = "text-center" width = "120px">NOMBRE</td>';
          $salida.= '<th class = "text-center" width = "120px">APELLIDO</td>';
          $salida.= '<th class = "text-center" width = "200px">PADRE O ENCARGADO</td>';
          $salida.= '<th class = "text-center" width = "100px">CORREO</td>';
          $salida.= '<th class = "text-center" width = "100px">TELEFONO</td>';
          $salida.= '</tr>';
          $salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'</td>';
			//ID
			$id = utf8_decode($row["alu_cui"]);
			$salida.= '<td class = "text-center">'.$id.'</td>';
			//TIPO ID
			$tipo = utf8_decode($row["alu_tipo_cui"]);
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//correo
			$pad = utf8_decode($row["alu_padre"]);
			$salida.= '<td class = "text-left">'.$pad.'</td>';
			//correo
			$mail = $row["alu_mail_padre"];
			$salida.= '<td class = "text-left">'.$mail.'</td>';
			//telefono1
			$tel = $row["alu_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
			//---
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
