<?php 
include_once('../html_fns.php');

function tabla_materias($pensum,$nivel,$grado,$tipo,$sit){
	$ClsPen = new ClsPensum();
	$result = $ClsPen->get_materia($pensum,$nivel,$grado,'',$tipo,$sit);
	
	if(is_array($result)){
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "10px" class = "text-center">No.</td>';
		$salida.= '<th width = "40px" class = "text-center"><span class="fa fa-cogs"></span></td>';
		$salida.= '<th width = "10px" class = "text-center">ORDEN</td>';
		$salida.= '<th width = "100px" class = "text-center">NIVEL</td>';
		$salida.= '<th width = "100px" class = "text-center">GRADO</td>';
		$salida.= '<th width = "150px" class = "text-center">NOMBRE</td>';
		$salida.= '<th width = "150px" class = "text-center">TIPO</td>';
		$salida.= '<th width = "50px" class = "text-center">CATEGOR&Iacute;A</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//--
			$salida.= '<td class = "text-center">';
			$pensum = $row["mat_pensum"];
			$nivel = $row["mat_nivel"];
			$grado = $row["mat_grado"];
			$codigo = $row["mat_codigo"];
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Materia('.$pensum.','.$nivel.','.$grado.','.$codigo.');" target = "_blank" title = "Seleccionar Materia" ><span class="fa fa-pencil"></span></button> &nbsp;';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Confirm_Elimina_Materia('.$pensum.','.$nivel.','.$grado.','.$codigo.');" target = "_blank" title = "Deshabilitar Materia" ><span class="fa fa-trash"></span></button>';
			$salida.= '</td>';	
			//orden
			$orden = trim($row["mat_orden"]);
			$salida.= '<td class = "text-center">('.$orden.')</td>';
			//nivel
			$nivel = utf8_decode($row["niv_descripcion"]);
			$salida.= '<td class = "text-center">'.$nivel.'</td>';
			//grado
			$grado = utf8_decode($row["gra_descripcion"]);
			$salida.= '<td class = "text-center">'.$grado.'</td>';
			//descripcion
			$desc = utf8_decode($row["mat_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//tipo
			$tipo = trim($row["mat_tipo"]);
			switch($tipo){	
				case '1': $tipo_desc = "Valida para MINEDUC"; break;
				case '0': $tipo_desc = "No valida para MINEDUC"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo_desc.'</td>';
			//categoria
			$cate = trim($row["mat_categoria"]);
			switch($cate){	
				case 'A': $cate_desc = "ACAD&Eacute;MICA"; break;
				case 'P': $cate_desc = "PR&Aacute;CTICA"; break;
				case 'D': $cate_desc = "DEPORTIVA"; break;
			}
			$salida.= '<td class = "text-center">'.$cate_desc.'</td>';
			//-
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}
	
	return $salida;
}

?>