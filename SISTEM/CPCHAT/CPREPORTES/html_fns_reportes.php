<?php
include_once('../../html_fns.php');


function tabla_grados_usuarios($pensum,$nivel,$grado){
	$ClsChat = new ClsChat();
	$result = $ClsChat->get_grado_usuarios($pensum,$nivel,$grado,$usuario,'');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "150px" class = "text-center">GRADO</td>';
			$salida.= '<th width = "150px" class = "text-center">T&Iacute;PO</td>';
			$salida.= '<th width = "150px" class = "text-center">NOMBRE</td>';
			$salida.= '<th width = "100px" class = "text-center">T&Iacute;TULO</td>';
			$salida.= '<th width = "50px" class = "text-center">CUI</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'</td>';
			//grado
			$grado_desc = utf8_decode($row["gra_descripcion"]);
			$salida.= '<td class = "text-center">'.$grado_desc.'</td>';
			//Tipo
			$tipo = $row["usu_tipo"];
			$tipo = ($tipo == 1)?"Autoridad":"Maestro";
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//nombre
			$nombre = utf8_decode($row["cm_nombre"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//titulo
			$titulo = utf8_decode($row["cm_titulo"]);
			$salida.= '<td class = "text-left">'.$titulo.'</td>';
			//cui
			$cui = $row["cm_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
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