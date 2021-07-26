<?php
include_once('../../html_fns.php');

function tabla_esquema($pensum,$nivel,$grado,$seccion,$materia,$unidad){
	$ClsAcad = new ClsAcademico();
	$ClsTar = new ClsTarea();
	$ClsExa = new ClsExamen();
	$result = $ClsAcad->get_tema('',$pensum,$nivel,$grado,$seccion,$materia,$unidad);
	if(is_array($result)){
			$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">Fila</td>';
			$salida.= '<th width = "10px" class = "text-center">UNIDAD</td>';
			$salida.= '<th width = "10px" class = "text-center">PERIODOS</td>';
			$salida.= '<th width = "150px" class = "text-center">TEMA</td>';
			$salida.= '<th width = "150px" class = "text-center">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th width = "20px" class = "text-center"></td>';
			$salida.= '<th width = "40px" class = "text-center"></td>';
			$salida.= '<th width = "40px" class = "text-center"></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		$temnum = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$tema = $row["tem_codigo"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//unidad
			$unidad = utf8_decode($row["tem_unidad"]);
			$salida.= '<td class = "text-center">'.$unidad.' Unidad</td>';
			//cantidad de periodos
			$periodos = trim($row["tem_cantidad_periodos"]);
			$salida.= '<td class = "text-center">'.$periodos.'</td>';
			//nombre del tema
			$nombre = utf8_decode($row["tem_nombre"]);
			$salida.= '<td class = "text-left">TEMA '.$temnum.': &nbsp; '.$nombre.'</td>';
			//descripcion
			$desc = utf8_decode($row["tem_descripcion"]);
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//--
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			//--
			$salida.= '</tr>';
			$i++;
			/////////////// TAREAS POR TEMA //////////
			$result_tareas = $ClsTar->get_tarea('','','','','','','','',$tema);
			if(is_array($result_tareas)){
				//limpieza
				$unidad = "";
				$nom = "";
				$periodos = "";
				$desc = "";
				//encabezados
				$salida.= '<tr class = "info">';
				//--
				$salida.= '<td class = "text-center">'.$i.'. </td>';
				$salida.= '<td></td>';
				$salida.= '<td></td>';
				$salida.= '<td class = "text-center"><label>TAREA (TEMA '.$temnum.')</label></td>';
				$salida.= '<td class = "text-center"><label>DESCRIPCI&Oacute;N (TAREA)</label></td>';
				$salida.= '<td class = "text-center"><label>PUNTEO</label></td>';
				$salida.= '<td class = "text-center"><label>FECHA DE ENTREGA</label></td>';
				$salida.= '<td class = "text-center"><label>TIPO</label></td>';
				//--
				$salida.= '</tr>';
				$i++;
				foreach($result_tareas as $row_tarea){
					$salida.= '<tr class = "info">';
					//--
					$salida.= '<td class = "text-center">'.$i.'. </td>';
					$salida.= '<td></td>';
					$salida.= '<td></td>';
					//nombre
					$nombre = utf8_decode($row_tarea["tar_nombre"]);
					$salida.= '<td class = "text-left">TAREA (TEMA '.$temnum.'): &nbsp; '.$nombre.'</td>';
					//descripcion
					$desc = utf8_decode($row_tarea["tar_descripcion"]);
					$salida.= '<td class = "text-center">'.$desc.'</td>';
					//punteo
					$pondera = trim($row_tarea["tar_ponderacion"]);
					$tipo_pondera = trim($row_tarea["tar_tipo_calificacion"]);
					$tipo_pondera = ($tipo_pondera == "Z")?"Actividades":"AL Evaluaciones";
					$salida.= '<td class = "text-center">'.$pondera.'/'.$tipo_pondera.'</td>';
					//fecha de entreda
					$fecha = utf8_decode($row_tarea["tar_fecha_entrega"]);
					$fecha = cambia_fechaHora($fecha);
					$fecha = substr($fecha, 0, -3);
					$salida.= '<td class = "text-center">'.$fecha.'</td>';
					//TIPO
					$tipo = utf8_decode($row_tarea["tar_tipo"]);
					$tipo = ($tipo == "OL")?"EN L&Iacute;NEA":"EN CLASE";
					$salida.= '<td class = "text-center">'.$tipo.'</td>';
					//--
					$salida.= '</tr>';
					$i++;
				}	
			}
			/////////////// ! FIN TAREAS POR TEMA //////////
			/////////////// EXAMENES POR TEMA //////////
			$result_examenes = $ClsExa->get_examen('','','','','','','','',$tema);
			if(is_array($result_examenes)){
				//limpieza
				$unidad = "";
				$nom = "";
				$periodos = "";
				$desc = "";
				//encabezados
				$salida.= '<tr class = "success">';
				//--
				$salida.= '<td class = "text-center">'.$i.'. </td>';
				$salida.= '<td></td>';
				$salida.= '<td></td>';
				$salida.= '<td class = "text-center"><label>Evaluaciones (TEMA '.$temnum.')</label></td>';
				$salida.= '<td class = "text-center"><label>DESCRIPCI&Oacute;N (Evaluaciones)</label></td>';
				$salida.= '<td class = "text-center"><label>PUNTEO</label></td>';
				$salida.= '<td class = "text-center"><label>FECHA DE EVALUACI&Oacute;N</label></td>';
				$salida.= '<td class = "text-center"><label>TIPO</label></td>';
				//--
				$salida.= '</tr>';
				$i++;
				foreach($result_examenes as $row_examenes){
					$salida.= '<tr class = "success">';
					//--
					$salida.= '<td class = "text-center">'.$i.'. </td>';
					$salida.= '<td></td>';
					$salida.= '<td></td>';
					//nombre
					$titulo = utf8_decode($row_examenes["exa_titulo"]);
					$salida.= '<td class = "text-left">Evaluaciones (TEMA '.$temnum.'): &nbsp; '.$titulo.'</td>';
					//descripcion
					$desc = utf8_decode($row_examenes["exa_descripcion"]);
					$salida.= '<td class = "text-center">'.$desc.'</td>';
					//punteo
					$pondera = number_format($row_examenes["exa_ponderacion"],2,'.','');
					$tipo_pondera = trim($row_examenes["exa_tipo_calificacion"]);
					$tipo_pondera = ($tipo_pondera == "Z")?"Actividades":"AL Evaluaciones";
					$salida.= '<td class = "text-center">'.$pondera.'/'.$tipo_pondera.'</td>';
					//fecha de entreda
					$fecha = utf8_decode($row_examenes["exa_fecha_inicio"]);
					$fecha = cambia_fechaHora($fecha);
					$fecha = substr($fecha, 0, -3);
					$salida.= '<td class = "text-center">'.$fecha.'</td>';
					//TIPO
					$tipo = utf8_decode($row_examenes["exa_tipo"]);
					$tipo = ($tipo == "OL")?"EN L&Iacute;NEA":"EN CLASE";
					$salida.= '<td class = "text-center">'.$tipo.'</td>';
					//--
					$salida.= '</tr>';
					$i++;
				}	
			}
			/////////////// ! FIN EXAMENES POR TEMA //////////
			$temnum++;
		}
		
		/////////////// EXAMENES GLOBALES //////////
		$result_examenes = $ClsExa->get_examen('',$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,0);
		if(is_array($result_examenes)){
			//limpieza
			$unidad = "";
			$nom = "";
			$periodos = "";
			$desc = "";
			//encabezados
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td class = "text-center"><label>Evaluaciones GLOBALES</label></td>';
			$salida.= '<td class = "text-center"><label>DESCRIPCI&Oacute;N (Evaluaciones)</label></td>';
			$salida.= '<td class = "text-center"><label>PUNTEO</label></td>';
			$salida.= '<td class = "text-center"><label>FECHA DE EVALUACI&Oacute;N</label></td>';
			$salida.= '<td class = "text-center"><label>TIPO</label></td>';
			//--
			$salida.= '</tr>';
			$i++;
			foreach($result_examenes as $row_examenes){
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center">'.$i.'. </td>';
				$salida.= '<td></td>';
				$salida.= '<td></td>';
				//nombre
				$titulo = utf8_decode($row_examenes["exa_titulo"]);
				$salida.= '<td class = "text-left">Evaluaciones (TEMA '.$temnum.'): &nbsp; '.$titulo.'</td>';
				//descripcion
				$desc = utf8_decode($row_examenes["exa_descripcion"]);
				$salida.= '<td class = "text-center">'.$desc.'</td>';
				//punteo
				$pondera = number_format($row_examenes["exa_ponderacion"],2,'.','');
				$tipo_pondera = trim($row_examenes["exa_tipo_calificacion"]);
				$tipo_pondera = ($tipo_pondera == "Z")?"Actividades":"AL Evaluaciones";
				$salida.= '<td class = "text-center">'.$pondera.'/'.$tipo_pondera.'</td>';
				//fecha de entreda
				$fecha = utf8_decode($row_examenes["exa_fecha_inicio"]);
				$fecha = cambia_fechaHora($fecha);
				$fecha = substr($fecha, 0, -3);
				$salida.= '<td class = "text-center">'.$fecha.'</td>';
				//TIPO
				$tipo = utf8_decode($row_examenes["exa_tipo"]);
				$tipo = ($tipo == "OL")?"EN L&Iacute;NEA":"EN CLASE";
				$salida.= '<td class = "text-center">'.$tipo.'</td>';
				//--
				$salida.= '</tr>';
				$i++;
			}	
		}
		/////////////// ! FIN EXAMENES POR TEMA //////////
		$salida.= '</table>';
	}
	
	return $salida;
}


?>