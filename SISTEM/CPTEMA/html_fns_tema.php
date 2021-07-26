<?php
include_once('../html_fns.php');

function tabla_temas($codigo,$pensum,$nivel,$grado,$seccion,$materia){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_tema($codigo,$pensum,$nivel,$grado,$seccion,$materia);
	
	if(is_array($result)){
		$Thoras = 0;
			$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "20px" class = "text-center"><span class="fa fa-cogs"></span></td>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "30px" class = "text-center">UNIDAD</td>';
			$salida.= '<th width = "150px" class = "text-center">TEMA</td>';
			$salida.= '<th width = "20px" class = "text-center">PERIODOS</td>';
			//$salida.= '<th width = "130px" class = "text-center">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th width = "40px" class = "text-center"><span class="fa fa-paperclip"></span></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">';
			$codigo = $row["tem_codigo"];
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Tema('.$codigo.');" title = "Seleccionar Tema" ><span class="fa fa-edit"></span></button> &nbsp;';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Confirm_Elimina('.$codigo.');" title = "Deshabilitar Tema" ><span class="fa fa-trash"></span></button>';
			$salida.= '</td>';	
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//unidad
			$unidad = utf8_decode($row["tem_unidad"]);
			$salida.= '<td class = "text-center">'.$unidad.'U</td>';
			//tema
			$nom = utf8_decode($row["tem_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//cantidad de periodos
			$periodos = trim($row["tem_cantidad_periodos"]);
			$salida.= '<td class = "text-center">'.$periodos.'</td>';
			//descripcion
			$desc = utf8_decode($row["tem_descripcion"]);
			//$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//botones
			$salida.= '<td class = "text-center">';
			$tarea = $row["tar_codigo"];
			$salida.= '<button type="button" class="btn btn-outline btn-primary" onclick = "NewFile('.$codigo.','.$i.');" title="Cargar material de auxiliar o Gu&iacute;a"><i class="fa fa-cloud-upload"></i> <i class="fa fa-file-picture-o"></i></button> ';
			$salida.= '<a class="btn btn-default" href = "IFRMarchivostema.php?curso='.$curso.'&tema='.$codigo.'" target = "_blank" title="Ver Documentos Cargados" ><i class="fa fa-search"></i> <i class="fa fa-file-pdf-o"></i></a> ';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}
	
	return $salida;
}


?>