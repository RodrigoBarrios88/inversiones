<?php
include_once('../html_fns.php');

function tabla_unidades($pensum,$nivel,$unidad){
	$ClsNot = new ClsNotas();
	$result = $ClsNot->get_unidades($pensum,$nivel,$unidad);
	
	if(is_array($result)){
		$Thoras = 0;
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "50px" class = "text-center"><span class="glyphicon glyphicon-cog"></span></td>';
		$salida.= '<th width = "10px" class = "text-center">No.</td>';
		$salida.= '<th width = "100px" class = "text-center">PROGRAMA ACAD&Eacute;MICO</td>';
		$salida.= '<th width = "100px" class = "text-center">NIVEL</td>';
		$salida.= '<th width = "100px" class = "text-center">UNIDAD</td>';
		$salida.= '<th width = "100px" class = "text-center">DESCRIPCI&Oacute;N</td>';
		$salida.= '<th width = "30px" class = "text-center">PORCENTAJE %</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$pensum = $row["uni_pensum"];
			$nivel = $row["uni_nivel"];
			$codigo = $row["uni_unidad"];
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Unidad('.$pensum.','.$nivel.','.$codigo.');" title = "Seleccionar Unidad" ><i class="fa fa-edit"></i></button> &nbsp;';
					$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Confirm_Elimina_Unidad('.$pensum.','.$nivel.','.$codigo.');" title = "Deshabilitar Unidad" ><i class="fa fa-trash"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//descripcion
			$desc = utf8_decode($row["pen_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//nivel
			$nivel = utf8_decode($row["niv_descripcion"]);
			$salida.= '<td class = "text-left">'.$nivel.'</td>';
			//posicion
			$unidad = trim($row["uni_unidad"]);
			$salida.= '<td class = "text-center">'.$unidad.'</td>';
			//descripcion
			$desc = utf8_decode($row["uni_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//porcentaje
			$porcent = trim($row["uni_porcentaje"]);
			$salida.= '<td class = "text-center">'.$porcent.' %</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
	}
	
	return $salida;
}

function tabla_secciones_alumnos_notas($pensum,$nivel,$grado,$seccion,$materia,$unidad,$tipo_calificacion,$situacion){
	$ClsPen = new ClsPensum();
	$ClsNot = new ClsNotas();
	$ClsTar = new ClsTarea();
	$ClsExa = new ClsExamen();
	$tareasporcen = $ClsTar->get_tarea($cui,$pensum,$nivel,$grado,$seccion);
	 //array de secciones disponibles para ese pensum y ese grado con ese tipo de area (civil, militar o deportiva) //////////
	$result_letras = $ClsNot->get_literales();  ////// este array se coloca en la columna de combos
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////// Trae el array de secciones disponibles para ese pensum y ese grado con ese tipo de area (civil, militar o deportiva) //////////
	$result_tipifica = $ClsNot->get_tipificacion();  ////// este array se coloca en la columna de combos
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',$situacion);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "10px" class = "text-center">No.</th>';
		$salida.= '<th width = "50px" class = "text-center">CUI</th>';
		$salida.= '<th width = "150px" class = "text-center">Alumno</td>';
		$salida.= '<th width = "20px" class = "text-center">Tareas</td>';
		$salida.= '<th width = "20px" class = "text-center">Cortos</td>';
		$salida.= '<th width = "20px" class = "text-center">Trabajos (final)</td>';
		$salida.= '<th width = "20px" class = "text-center">Evaluaciones</td>';
		if($tipo_calificacion == 1){
		$salida.= '<th width = "20px" class = "text-center">Actividades</td>';
		$salida.= '<th width = "20px" class = "text-center">Evaluacion</td>';
		$salida.= '<th width = "20px" class = "text-center">Total</td>';
		}else if($tipo_calificacion == 2){
		$salida.= '<th width = "20px" class = "text-center">Actividades Acumulada (Referencia)</td>';
		$salida.= '<th width = "20px" class = "text-center">Nota</td>';
		}else if($tipo_calificacion == 3){
		$salida.= '<th width = "20px" class = "text-center">Actividades Acumulada (Referencia)</td>';
		$salida.= '<th width = "20px" class = "text-center">Nota</td>';
		}	
		$salida.= '<th width = "10px" class = "text-center"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th width = "10px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//catalogo
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '<input type = "hidden" name = "tipo'.$i.'" id = "tipo'.$i.'" value = "'.$tipo_calificacion.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//---
			$zonaTareas = $ClsTar->get_notas_tarea('',$cui,$pensum,$nivel,$grado,'',$materia,$unidad,'','Z','1,2');
			$zonaTareasmax = $ClsTar->get_notasmax_tarea('',$cui,$pensum,$nivel,$grado,'',$materia,$unidad,'','Z','1,2');
			if(is_array($zonaTareasmax)){
    			foreach($zonaTareasmax as $row){
    				$puntoszonatar = $row['puntos'];
    			    $cantidad = $row['cantidad'];
    			
        		}
    		}
			$zonaExamen = $ClsExa->get_notas_examen('',$cui,$pensum,$nivel,$grado,'',$materia,'',$unidad,'','Z','1,2,3');
			$zonaExamenmax = $ClsExa->get_notasmax_examen('',$cui,$pensum,$nivel,$grado,'',$materia,'',$unidad,'','Z','1,2,3');
			if(is_array($zonaExamenmax)){
    			foreach($zonaExamenmax as $row){
    				$puntoszonaex = $row['puntos'];
    			    $cantidad1 = $row['cantidad'];
    			}
    		}
			$notaTareas = $ClsTar->get_notas_tarea('',$cui,$pensum,$nivel,$grado,'',$materia,$unidad,'','E','1,2');
			$notaTareasmax = $ClsTar->get_notasmax_tarea('',$cui,$pensum,$nivel,$grado,'',$materia,$unidad,'','E','1,2');
			if(is_array($notaTareasmax)){
    			foreach($notaTareasmax as $row){
    				$puntosnotatar = $row['puntos'];
    			    $cantidad2 = $row['cantidad'];
    			}
    		}
			$notaExamen = $ClsExa->get_notas_examen('',$cui,$pensum,$nivel,$grado,'',$materia,'',$unidad,'','E','1,2,3');
			$notaExamenmax = $ClsExa->get_notasmax_examen('',$cui,$pensum,$nivel,$grado,'',$materia,'',$unidad,'','E','1,2,3');
			if(is_array($notaExamenmax)){
    			foreach($notaExamenmax as $row){
    				$puntosnotaex = $row['puntos'];
    			    $cantidad3 = $row['cantidad'];
    			}
    		}
    		$zona = $zonaExamen + $zonaTareas;
    		$nota = $notaExamen + $notaTareas;
    		$cantidadtotal= $puntoszonatar+$puntoszonaex+$puntosnotatar+$puntosnotaex;
			$salida.= '<th width = "20px" class = "text-center">'.$zonaTareas.'</td>';
			$salida.= '<th width = "20px" class = "text-center">'.$zonaExamen.'</td>';
			$salida.= '<th width = "20px" class = "text-center">'.$notaTareas.'</td>';
			$salida.= '<th width = "20px" class = "text-center">'.$notaExamen.'</td>';
		
			///--comprueba si el alumno ya tiene nota, si no da la opcion para grabar.  Si ya tiene nota da la opcion para modificar y señala que ya tiene...
			$result_nota_alumno = $ClsNot->comprueba_notas_alumno($cui,$pensum,$nivel,$grado,$materia,$unidad);
			if(is_array($result_nota_alumno)){
				foreach($result_nota_alumno as $row_nota_alumno){
					$situacion = $row_nota_alumno["not_situacion"];
					$total = $row_nota_alumno['not_total'];
				}
				$tipo_usuario = $_SESSION['tipo_usuario'];
				if($tipo_usuario == 5 || $tipo_usuario == 1){
					$disabled = "";
				}else{	
					$disabled = ($situacion != 1)?"disabled":"";
				}
				$total = floatval($total);
				//--
				if($tipo_calificacion == 1){
					$salida.= '<td class = "text-center" >';
					$salida.= '<input type = "text" class="form-control text-center" name = "zona'.$i.'" id = "zona'.$i.'" value = "'.$zona.'" onkeyup="decimales(this);" onblur = "Asignar_Nota('.$i.');" style = "width: 50px;" maxlength = "2" '.$disabled.' />';
					$salida.= '<input type = "hidden"id = "cantidadtotal'.$i.'" value = "'.$cantidadtotal.'" />';
					$salida.= '</td>';
					$salida.= '<td class = "text-center" >';
					$salida.= '<input type = "text" class="form-control text-center" name = "nota'.$i.'" id = "nota'.$i.'" value = "'.$nota.'" onkeyup="decimales(this);" onblur = "Asignar_Nota('.$i.');" style = "width: 50px;" maxlength = "2" '.$disabled.' />';
					$salida.= '</td>';
					$salida.= '<td class = "text-center" >';
					$salida.= '<input type = "text" class="form-control text-center" name = "total'.$i.'" id = "total'.$i.'" value = "'.$total.'" style = "width: 50px;" disabled />';
					$salida.= '</td>';
				}else if($tipo_calificacion == 2){
					$total = identificaRangosLetras($result_letras,$total);
					$total = number_format($total, 2, '.', '');
					$combo =  combos_html_onclick($result_letras,"nota$i",'lit_alta','lit_letra',"Asignar_Nota($i);");
					$salida.= '<td class = "text-center" ><strong>'.$zona.'</strong></td>';
					$salida.= '<td class = "text-center" >'.$combo;
					$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "0" />';
					$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" />';
					$salida.= '<script type = "text/javascript">document.getElementById("nota'.$i.'").value = "'.$total.'";</script>';
					$salida.= '</td>';
				}else if($tipo_calificacion == 3){
					$total = identificaRangosTipificacion($result_tipifica,$total);
					$total = number_format($total, 0, '', '');
					$combo =  combos_html_onclick($result_tipifica,"nota$i",'tip_alta','tip_califcacion',"Asignar_Nota($i);");
					$salida.= '<td class = "text-center" ><strong>'.$zona.'</strong></td>';
					$salida.= '<td class = "text-center" >'.$combo;
					$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "0" />';
					$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" />';
					$salida.= '<script type = "text/javascript">document.getElementById("nota'.$i.'").value = "'.$total.'";</script>';
					$salida.= '</td>';
				}
				$salida.= '<td class = "text-center" >';
				$salida.= '<span id = "spancheck'.$i.'" class="btn btn-success btn-xs" title = "Este Alumno ya Tiene Nota" onclick="Asignar_Nota('.$i.');"  ><span class="fa fa-check-circle-o"></span></span> ';
				$salida.= '</td>';
			}else{
				$zona = '';
				$nota = '';
				$total = '';
				$zona = $zonaTareas + $zonaExamen;
				$nota = $notaTareas + $notaExamen;
				//--maxmax
				$total = ($zona + $nota);
				$totalporcen = 100 * $total / $cantidadtotal ;
				if($tipo_calificacion == 1){
					$salida.= '<td class = "text-center" >';
					$salida.= '<input type = "text" class="form-control text-center" name = "zona'.$i.'" id = "zona'.$i.'" value = "'.$zona.'" onkeyup="decimales(this);" onblur = "Asignar_Nota('.$i.');" style = "width: 50px;" maxlength = "2" />';
						$salida.= '<input type = "hidden"id = "cantidadtotal'.$i.'" value = "'.$cantidadtotal.'" />';
					$salida.= '</td>';
					$salida.= '<td class = "text-center" >';
					$salida.= '<input type = "text" class="form-control text-center" name = "nota'.$i.'" id = "nota'.$i.'" value = "'.$nota.'" onkeyup="decimales(this);" onblur = "Asignar_Nota('.$i.');" style = "width: 50px;" maxlength = "2" />';
					$salida.= '</td>';
					$salida.= '<td class = "text-center" >';
					$salida.= '<input type = "text" class="form-control text-center" name = "total'.$i.'" id = "total'.$i.'" value = "'.round($totalporcen).'" style = "width: 50px;" disabled />';
					$salida.= '</td>';
				}else if($tipo_calificacion == 2){
					$tipo_usuario = $_SESSION['tipo_usuario'];
					if($tipo_usuario == 5 || $tipo_usuario == 1){
						$disabled = "";
					}else{	
						$disabled = ($situacion != 1)?"disabled":"";
					}
					$combo =  combos_html_onclick($result_letras,"nota$i",'lit_alta','lit_letra',"Asignar_Nota($i);");
					$salida.= '<td class = "text-center" ><strong>'.$zona.'</strong></td>';
					$salida.= '<td class = "text-center" >'.$combo;
					$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "0" />';
					$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" />';
					$salida.= '</td>';
				}else if($tipo_calificacion == 3){
					$tipo_usuario = $_SESSION['tipo_usuario'];
					if($tipo_usuario == 5 || $tipo_usuario == 1){
						$disabled = "";
					}else{	
						$disabled = ($situacion != 1)?"disabled":"";
					}
					$combo =  combos_html_onclick($result_tipifica,"nota$i",'tip_alta','tip_califcacion',"Asignar_Nota($i);");
					$salida.= '<td class = "text-center" ><strong>'.$zona.'</strong></td>';
					$salida.= '<td class = "text-center" >'.$combo;
					$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "0" />';
					$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" />';
					$salida.= '</td>';
				}	
				$salida.= '<td class = "text-center" >';
				$salida.= '<span id = "spancheck'.$i.'" title = "" ><input type="checkbox" name="valida'.$i.'" onclick="Asignar_Nota('.$i.');" title="Validar la sumatoria de Evaluaciones" ></span> ';
				$salida.= '</td>';
			}
			//--
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-info btn-xs" onclick="promtComentario(\''.$cui.'\','.$pensum.','.$nivel.','.$grado.','.$materia.','.$unidad.');" title = "Comentario de Maestro" ><i class="fa fa-comments"></i></button>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_secciones_alumnos_notas_literales($pensum,$nivel,$grado,$seccion,$materia,$unidad,$sit){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsNot = new ClsNotas();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',$sit);
	
	/////////// Trae el array de secciones disponibles para ese pensum y ese grado con ese tipo de area (civil, militar o deportiva) //////////
	$result_letras = $ClsNot->get_literales();  ////// este array se coloca en la columna de combos
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "30px" class = "text-center">No.</td>';
		$salida.= '<th width = "60px" class = "text-center">CUI</td>';
		$salida.= '<th width = "250px" class = "text-center">ALUMNO</td>';
		$salida.= '<th width = "100px" class = "text-center">SECCION</td>';
		$salida.= '<th width = "60px" class = "text-center">EVALUACI&Oacute;N</td>';
		$salida.= '<th width = "10px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '<th width = "10px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//catalogo
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//seccion
			$sec = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$sec.'</td>';
			//---
			
			///--comprueba si el alumno ya tiene nota, si no da la opcion para grabar.  Si ya tiene nota da la opcion para modificar y señala que ya tiene...
			$result_nota_alumno = $ClsNot->comprueba_notas_alumno($cui,$pensum,$nivel,$grado,$materia,$unidad);
			if(is_array($result_nota_alumno)){
				foreach($result_nota_alumno as $row_nota_alumno){
					$zona = $row_nota_alumno["not_zona"];
					$nota = $row_nota_alumno["not_nota"];
					$situacion = $row_nota_alumno["not_situacion"];
				}
				$tipo_usuario = $_SESSION['tipo_usuario'];
				if($tipo_usuario == 5 || $tipo_usuario == 1){
					$disabled = "";
				}else{	
					$disabled = ($situacion != 1)?"disabled":"";
				}
				$total = ($zona + $nota);
				//--
				$total = identificaRangosLetras($result_letras,$total);
				$total = number_format($total, 2, '.', '');
				$combo =  combos_html_onclick($result_letras,"nota$i",'lit_alta','lit_letra',"Asignar_Nota($i);");
				$salida.= '<td class = "text-center" >';
				$salida.= $combo;
				$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "0" />';
				$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" />';
				$salida.= '<script type = "text/javascript">document.getElementById("nota'.$i.'").value = "'.$total.'";</script>';
				$salida.= '</td>';
				//$salida.= ' '.$total.' - '.$total2;
				$salida.= '<td class = "text-center" >';
				$salida.= '<span id = "spancheck'.$i.'" class="btn btn-success btn-xs" title = "Este Alumno ya Tiene Nota" ><span class="fa fa-check-circle-o"></span></span> ';
				$salida.= '</td>';
			}else{
				$tipo_usuario = $_SESSION['tipo_usuario'];
				if($tipo_usuario == 5 || $tipo_usuario == 1){
					$disabled = "";
				}else{	
					$disabled = ($situacion != 1)?"disabled":"";
				}
				$combo =  combos_html_onclick($result_letras,"nota$i",'lit_alta','lit_letra',"Asignar_Nota($i);");
				$salida.= '<td class = "text-center" >';
				$salida.= $combo;
				$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "0" />';
				$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" >';
				$salida.= '<span id = "spancheck'.$i.'" title = "" ></span> ';
				$salida.= '</td>';
			}
			//--
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-info btn-xs" onclick="promtComentario(\''.$cui.'\','.$pensum.','.$nivel.','.$grado.','.$materia.','.$unidad.');" title = "Comentario de Maestro" ><i class="fa fa-comments"></i></button>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_secciones_alumnos_notas_tipificacion($pensum,$nivel,$grado,$seccion,$materia,$unidad,$sit){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsNot = new ClsNotas();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',$sit);
	
	/////////// Trae el array de secciones disponibles para ese pensum y ese grado con ese tipo de area (civil, militar o deportiva) //////////
	$result_tipifica = $ClsNot->get_tipificacion();  ////// este array se coloca en la columna de combos
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "30px" class = "text-center">No.</td>';
		$salida.= '<th width = "60px" class = "text-center">CUI</td>';
		$salida.= '<th width = "250px" class = "text-center">ALUMNO</td>';
		$salida.= '<th width = "100px" class = "text-center">SECCION</td>';
		$salida.= '<th width = "60px" class = "text-center">EVALUACI&Oacute;N</td>';
		$salida.= '<th width = "10px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '<th width = "10px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//catalogo
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//seccion
			$sec = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$sec.'</td>';
			//---
			
			///--comprueba si el alumno ya tiene nota, si no da la opcion para grabar.  Si ya tiene nota da la opcion para modificar y señala que ya tiene...
			$result_nota_alumno = $ClsNot->comprueba_notas_alumno($cui,$pensum,$nivel,$grado,$materia,$unidad);
			if(is_array($result_nota_alumno)){
				foreach($result_nota_alumno as $row_nota_alumno){
					$zona = $row_nota_alumno["not_zona"];
					$nota = $row_nota_alumno["not_nota"];
					$situacion = $row_nota_alumno["not_situacion"];
				}
				$tipo_usuario = $_SESSION['tipo_usuario'];
				if($tipo_usuario == 5 || $tipo_usuario == 1){
					$disabled = "";
				}else{	
					$disabled = ($situacion != 1)?"disabled":"";
				}
				$total = ($zona + $nota);
				//--
				$total = identificaRangosTipificacion($result_tipifica,$total);
				$total = number_format($total, 0, '', '');
				$combo =  combos_html_onclick($result_tipifica,"nota$i",'tip_alta','tip_califcacion',"Asignar_Nota($i);");
				$salida.= '<td class = "text-center" >';
				$salida.= $combo;
				$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "0" />';
				$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" />';
				$salida.= '<script type = "text/javascript">document.getElementById("nota'.$i.'").value = "'.$total.'";</script>';
				$salida.= '</td>';
				//$salida.= ' '.$total.' - '.$total2;
				$salida.= '<td class = "text-center" >';
				$salida.= '<span id = "spancheck'.$i.'" class="btn btn-success btn-xs" title = "Este Alumno ya Tiene Nota" ><span class="fa fa-check-circle-o"></span></span> ';
				$salida.= '</td>';
			}else{
				$tipo_usuario = $_SESSION['tipo_usuario'];
				if($tipo_usuario == 5 || $tipo_usuario == 1){
					$disabled = "";
				}else{	
					$disabled = ($situacion != 1)?"disabled":"";
				}
				$combo =  combos_html_onclick($result_tipifica,"nota$i",'tip_alta','tip_califcacion',"Asignar_Nota($i);");
				$salida.= '<td class = "text-center" >';
				$salida.= $combo;
				$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "0" />';
				$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" >';
				$salida.= '<span id = "spancheck'.$i.'" title = "" ></span> ';
				$salida.= '</td>';
			}
			//--
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-info btn-xs" onclick="promtComentario(\''.$cui.'\','.$pensum.','.$nivel.','.$grado.','.$materia.','.$unidad.');" title = "Comentario de Maestro" ><i class="fa fa-comments"></i></button>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


///////////////////////////////////// CERTIFICACIONES /////////////////////////////////////////////////////


function tabla_secciones_certificacion($pensum,$nivel,$grado,$seccion,$materia,$unidad,$sit){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsNot = new ClsNotas();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',$sit);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "30px" class = "text-center">No.</td>';
		$salida.= '<th width = "60px" class = "text-center">CUI</td>';
		$salida.= '<th width = "250px" class = "text-center">ALUMNO</td>';
		$salida.= '<th width = "100px" class = "text-center">SECCION</td>';
		$salida.= '<th width = "20px" class = "text-center">ACTIVIDADES</td>';
		$salida.= '<th width = "20px" class = "text-center">EVALUACI&Oacute;N</td>';
		$salida.= '<th width = "20px" class = "text-center">TOTAL</td>';
		$salida.= '<th width = "10px" class = "text-center"></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		$pendientes = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//catalogo
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//seccion
			$sec = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$sec.'</td>';
			//---
			
			///--comprueba si el alumno ya tiene nota, si no da la opcion para grabar.  Si ya tiene nota da la opcion para modificar y señala que ya tiene...
			$result_nota_alumno = $ClsNot->comprueba_notas_alumno($cui,$pensum,$nivel,$grado,$materia,$unidad); ////// este array se coloca en la columna de combos
			if(is_array($result_nota_alumno)){
				foreach($result_nota_alumno as $row_nota_alumno){
					$zona = $row_nota_alumno["not_zona"];
					$nota = $row_nota_alumno["not_nota"];
					$situacion = $row_nota_alumno["not_situacion"];
					$total = $row_nota_alumno["not_total"];
				}
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" name = "zona'.$i.'" id = "zona'.$i.'" value = "'.$zona.'" style = "width: 50px;" disabled />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" name = "nota'.$i.'" id = "nota'.$i.'" value = "'.$nota.'" style = "width: 50px;" disabled />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center alert-success" name = "total'.$i.'" id = "total'.$i.'" value = "'.$total.'" style = "width: 50px;" disabled />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" >';
				if($situacion == 1){
				$salida.= '<i title = "" ></i> ';
				}else if($situacion == 2){
				$salida.= '<span class="btn btn-success btn-circle" title = "Nota Certificada" ><span class="fa fa-check"></span></span> ';
				}
				$salida.= '</td>';
			}else{
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" name = "zona'.$i.'" id = "zona'.$i.'" onkeyup="decimales(this);" style = "width: 50px;" disabled />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" name = "nota'.$i.'" id = "nota'.$i.'" onkeyup="decimales(this);" style = "width: 50px;" disabled />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center alert-success" name = "total'.$i.'" id = "total'.$i.'" style = "width: 50px;" disabled />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" ></td>';
				$pendientes++;
			}
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '<input type = "hidden" name = "pendientes" id = "pendientes" value = "'.$pendientes.'" />';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_secciones_certificacion_literales($pensum,$nivel,$grado,$seccion,$materia,$unidad,$sit){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsNot = new ClsNotas();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',$sit);
	
	/////////// Trae el array de secciones disponibles para ese pensum y ese grado con ese tipo de area (civil, militar o deportiva) //////////
	$result_letras = $ClsNot->get_literales();  ////// este array se coloca en la columna de combos
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "30px" class = "text-center">No.</td>';
		$salida.= '<th width = "60px" class = "text-center">CUI</td>';
		$salida.= '<th width = "250px" class = "text-center">ALUMNO</td>';
		$salida.= '<th width = "100px" class = "text-center">SECCION</td>';
		$salida.= '<th width = "60px" class = "text-center">TOTAL</td>';
		$salida.= '<th width = "10px" class = "text-center"></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		$pendientes = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//catalogo
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//seccion
			$sec = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$sec.'</td>';
			//---
			
			///--comprueba si el alumno ya tiene nota, si no da la opcion para grabar.  Si ya tiene nota da la opcion para modificar y señala que ya tiene...
			$result_nota_alumno = $ClsNot->comprueba_notas_alumno($cui,$pensum,$nivel,$grado,$materia,$unidad); ////// este array se coloca en la columna de combos
			if(is_array($result_nota_alumno)){
				foreach($result_nota_alumno as $row_nota_alumno){
					$zona = $row_nota_alumno["not_zona"];
					$nota = $row_nota_alumno["not_nota"];
					$situacion = $row_nota_alumno["not_situacion"];
				}
				$total = ($zona + $nota);
				$desc_total = descripcionRangosLetras($result_letras,$total);
				
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" value = "'.$desc_total.'" style = "width: 100px;" disabled />';
				$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "'.$zona.'" />';
				$salida.= '<input type = "hidden" name = "nota'.$i.'" id = "nota'.$i.'" value = "'.$nota.'" />';
				$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" value = "'.$total.'" />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" >';
				if($situacion == 1){
				$salida.= '<i title = "" ></i> ';
				}else if($situacion == 2){
				$salida.= '<span class="btn btn-success btn-circle" title = "Nota Certificada" ><span class="fa fa-check"></span></span> ';
				}
				$salida.= '</td>';
			}else{
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" value = "-" style = "width: 100px;" disabled />';
				$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "'.$zona.'" />';
				$salida.= '<input type = "hidden" name = "nota'.$i.'" id = "nota'.$i.'" value = "'.$nota.'" />';
				$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" value = "'.$total.'" />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" ></td>';
				$pendientes++;
			}
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '<input type = "hidden" name = "pendientes" id = "pendientes" value = "'.$pendientes.'" />';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_secciones_certificacion_tipificacion($pensum,$nivel,$grado,$seccion,$materia,$unidad,$sit){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsNot = new ClsNotas();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',$sit);
	
	/////////// Trae el array de secciones disponibles para ese pensum y ese grado con ese tipo de area (civil, militar o deportiva) //////////
	$result_letras = $ClsNot->get_tipificacion();  ////// este array se coloca en la columna de combos
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "30px" class = "text-center">No.</td>';
		$salida.= '<th width = "60px" class = "text-center">CUI</td>';
		$salida.= '<th width = "250px" class = "text-center">ALUMNO</td>';
		$salida.= '<th width = "100px" class = "text-center">SECCION</td>';
		$salida.= '<th width = "60px" class = "text-center">TOTAL</td>';
		$salida.= '<th width = "10px" class = "text-center"></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		$pendientes = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//catalogo
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//seccion
			$sec = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$sec.'</td>';
			//---
			
			///--comprueba si el alumno ya tiene nota, si no da la opcion para grabar.  Si ya tiene nota da la opcion para modificar y señala que ya tiene...
			$result_nota_alumno = $ClsNot->comprueba_notas_alumno($cui,$pensum,$nivel,$grado,$materia,$unidad); ////// este array se coloca en la columna de combos
			if(is_array($result_nota_alumno)){
				foreach($result_nota_alumno as $row_nota_alumno){
					$zona = $row_nota_alumno["not_zona"];
					$nota = $row_nota_alumno["not_nota"];
					$situacion = $row_nota_alumno["not_situacion"];
				}
				$total = ($zona + $nota);
				$desc_total = descripcionRangosTipificacion($result_letras,$total);
				
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" value = "'.$desc_total.'" style = "width: 100px;" disabled />';
				$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "'.$zona.'" />';
				$salida.= '<input type = "hidden" name = "nota'.$i.'" id = "nota'.$i.'" value = "'.$nota.'" />';
				$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" value = "'.$total.'" />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" >';
				if($situacion == 1){
				$salida.= '<i title = "" ></i> ';
				}else if($situacion == 2){
				$salida.= '<span class="btn btn-success btn-circle" title = "Nota Certificada" ><span class="fa fa-check"></span></span> ';
				}
				$salida.= '</td>';
			}else{
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" value = "-" style = "width: 100px;" disabled />';
				$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "'.$zona.'" />';
				$salida.= '<input type = "hidden" name = "nota'.$i.'" id = "nota'.$i.'" value = "'.$nota.'" />';
				$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" value = "'.$total.'" />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" ></td>';
				$pendientes++;
			}
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '<input type = "hidden" name = "pendientes" id = "pendientes" value = "'.$pendientes.'" />';
		$salida.= '</div>';
	}
	
	return $salida;
}





//////////////////////////////////// MODIFICACONES //////////////////////////////////////////////

function tabla_secciones_alumnos_modificaciones($pensum,$nivel,$grado,$seccion,$materia,$unidad,$sit){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsNot = new ClsNotas();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',$sit);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "30px" class = "text-center">No.</td>';
		$salida.= '<th width = "60px" class = "text-center">CUI</td>';
		$salida.= '<th width = "250px" class = "text-center">ALUMNO</td>';
		$salida.= '<th width = "100px" class = "text-center">SECCION</td>';
		$salida.= '<th width = "20px" class = "text-center">ACTIVIDADES</td>';
		$salida.= '<th width = "20px" class = "text-center">EVALUACI&Oacute;N</td>';
		$salida.= '<th width = "20px" class = "text-center">TOTAL</td>';
		$salida.= '<th width = "30px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//catalogo
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//seccion
			$sec = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$sec.'</td>';
			//---
			
			///--comprueba si el alumno ya tiene nota, si no da la opcion para grabar.  Si ya tiene nota da la opcion para modificar y señala que ya tiene...
			$result_nota_alumno = $ClsNot->comprueba_notas_alumno($cui,$pensum,$nivel,$grado,$materia,$unidad);
			if(is_array($result_nota_alumno)){
				foreach($result_nota_alumno as $row_nota_alumno){
					$zona = $row_nota_alumno["not_zona"];
					$nota = $row_nota_alumno["not_nota"];
					$situacion = $row_nota_alumno["not_situacion"];
					$total = $row_nota_alumno["not_total"];
				}
				$tipo_usuario = $_SESSION['tipo_usuario'];
				if($tipo_usuario == 5 || $tipo_usuario == 1){
					$disabled = "";
				}else{	
					$disabled = ($situacion != 1)?"disabled":"";
				}
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" name = "zona'.$i.'" id = "zona'.$i.'" value = "'.$zona.'" onkeyup="decimales(this);" onblur = "Asignar_Nota('.$i.');" style = "width: 50px;" disabled  />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" name = "nota'.$i.'" id = "nota'.$i.'" value = "'.$nota.'" onkeyup="decimales(this);" onblur = "Asignar_Nota('.$i.');" style = "width: 50px;" disabled  />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" name = "total'.$i.'" id = "total'.$i.'" value = "'.$total.'" style = "width: 50px;" disabled />';
				$salida.= '</td>';
			}else{
				$tipo_usuario = $_SESSION['tipo_usuario'];
				if($tipo_usuario == 5 || $tipo_usuario == 1){
					$disabled = "";
				}else{	
					$disabled = ($situacion != 1)?"disabled":"";
				}
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" name = "zona'.$i.'" id = "zona'.$i.'" onkeyup="decimales(this);" onblur = "Asignar_Nota('.$i.');" style = "width: 50px;" disabled />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" name = "nota'.$i.'" id = "nota'.$i.'" onkeyup="decimales(this);" onblur = "Asignar_Nota('.$i.');" style = "width: 50px;" disabled />';
				$salida.= '</td>';
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type = "text" class="form-control text-center" name = "total'.$i.'" id = "total'.$i.'" style = "width: 50px;" disabled />';
				$salida.= '</td>';
			}
			//--
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="justificaModificacion(\''.$cui.'\',\''.$nombres.'\','.$zona.','.$nota.','.$total.');" title = "Modificar Nota" ><i class="fa fa-pencil"></i></button>';
					$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="hisotiralModificaciones(\''.$cui.'\','.$pensum.','.$nivel.','.$grado.','.$materia.','.$unidad.');" title = "Ver Historial de Modificaciones" ><i class="fa fa-list"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_secciones_alumnos_modificaciones_literales($pensum,$nivel,$grado,$seccion,$materia,$unidad,$sit){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsNot = new ClsNotas();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',$sit);
	
	/////////// Trae el array de secciones disponibles para ese pensum y ese grado con ese tipo de area (civil, militar o deportiva) //////////
	$result_letras = $ClsNot->get_literales();  ////// este array se coloca en la columna de combos
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "30px" class = "text-center">No.</td>';
		$salida.= '<th width = "60px" class = "text-center">CUI</td>';
		$salida.= '<th width = "250px" class = "text-center">ALUMNO</td>';
		$salida.= '<th width = "100px" class = "text-center">SECCION</td>';
		$salida.= '<th width = "60px" class = "text-center">EVALUACI&Oacute;N</td>';
		$salida.= '<th width = "30px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//catalogo
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//seccion
			$sec = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$sec.'</td>';
			//---
			
			///--comprueba si el alumno ya tiene nota, si no da la opcion para grabar.  Si ya tiene nota da la opcion para modificar y señala que ya tiene...
			$result_nota_alumno = $ClsNot->comprueba_notas_alumno($cui,$pensum,$nivel,$grado,$materia,$unidad);
			if(is_array($result_nota_alumno)){
				foreach($result_nota_alumno as $row_nota_alumno){
					$zona = $row_nota_alumno["not_zona"];
					$nota = $row_nota_alumno["not_nota"];
					$situacion = $row_nota_alumno["not_situacion"];
				}
				$tipo_usuario = $_SESSION['tipo_usuario'];
				if($tipo_usuario == 5 || $tipo_usuario == 1){
					$disabled = "";
				}else{	
					$disabled = ($situacion != 1)?"disabled":"";
				}
				$total = ($zona + $nota);
				$total = identificaRangosLetras($result_letras,$total);
				$total = number_format($total, 2, '.', '');
				//--
				$combo =  combos_html_onclick($result_letras,"nota$i",'lit_alta','lit_letra',"");
				$salida.= '<td class = "text-center" >';
				$salida.= $combo;
				$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "0" />';
				$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" />';
				$salida.= '<script type = "text/javascript">document.getElementById("nota'.$i.'").value = "'.$total.'";</script>';
				//$salida.= ' '.$total.' - '.$total2;
			}else{
				$tipo_usuario = $_SESSION['tipo_usuario'];
				if($tipo_usuario == 5 || $tipo_usuario == 1){
					$disabled = "";
				}else{	
					$disabled = ($situacion != 1)?"disabled":"";
				}
				$combo =  combos_html_onclick($result_letras,"nota$i",'lit_alta','lit_letra',"");
				$salida.= '<td class = "text-center" >';
				$salida.= $combo;
				$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "0" />';
				$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" />';
				$salida.= '</td>';
			}
			//--
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="justificaModificacion(\''.$cui.'\',\''.$nombres.'\','.$zona.','.$nota.','.$total.');" title = "Modificar Nota" ><i class="fa fa-pencil"></i></button>';
					$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="hisotiralModificaciones(\''.$cui.'\','.$pensum.','.$nivel.','.$grado.','.$materia.','.$unidad.');" title = "Ver Historial de Modificaciones" ><i class="fa fa-list"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_secciones_alumnos_modificaciones_tipificacion($pensum,$nivel,$grado,$seccion,$materia,$unidad,$sit){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsNot = new ClsNotas();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',$sit);
	
	/////////// Trae el array de secciones disponibles para ese pensum y ese grado con ese tipo de area (civil, militar o deportiva) //////////
	$result_tipifica = $ClsNot->get_tipificacion();  ////// este array se coloca en la columna de combos
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "30px" class = "text-center">No.</td>';
		$salida.= '<th width = "60px" class = "text-center">CUI</td>';
		$salida.= '<th width = "250px" class = "text-center">ALUMNO</td>';
		$salida.= '<th width = "100px" class = "text-center">SECCION</td>';
		$salida.= '<th width = "60px" class = "text-center">EVALUACI&Oacute;N</td>';
		$salida.= '<th width = "30px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//catalogo
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//seccion
			$sec = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$sec.'</td>';
			//---
			
			///--comprueba si el alumno ya tiene nota, si no da la opcion para grabar.  Si ya tiene nota da la opcion para modificar y señala que ya tiene...
			$result_nota_alumno = $ClsNot->comprueba_notas_alumno($cui,$pensum,$nivel,$grado,$materia,$unidad);
			if(is_array($result_nota_alumno)){
				foreach($result_nota_alumno as $row_nota_alumno){
					$zona = $row_nota_alumno["not_zona"];
					$nota = $row_nota_alumno["not_nota"];
					$situacion = $row_nota_alumno["not_situacion"];
				}
				$tipo_usuario = $_SESSION['tipo_usuario'];
				if($tipo_usuario == 5 || $tipo_usuario == 1){
					$disabled = "";
				}else{	
					$disabled = ($situacion != 1)?"disabled":"";
				}
				$total = ($zona + $nota);
				$total = identificaRangosTipificacion($result_tipifica,$total);
				$total = number_format($total, 0, '', '');
				//--
				$combo =  combos_html_onclick($result_tipifica,"nota$i",'tip_alta','tip_califcacion',"");
				$salida.= '<td class = "text-center" >';
				$salida.= $combo;
				$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "0" />';
				$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" />';
				$salida.= '<script type = "text/javascript">document.getElementById("nota'.$i.'").value = "'.$total.'";</script>';
				//$salida.= ' '.$total.' - '.$total2;
			}else{
				$tipo_usuario = $_SESSION['tipo_usuario'];
				if($tipo_usuario == 5 || $tipo_usuario == 1){
					$disabled = "";
				}else{	
					$disabled = ($situacion != 1)?"disabled":"";
				}
				$combo =  combos_html_onclick($result_tipifica,"nota$i",'tip_alta','tip_califcacion',"");
				$salida.= '<td class = "text-center" >';
				$salida.= $combo;
				$salida.= '<input type = "hidden" name = "zona'.$i.'" id = "zona'.$i.'" value = "0" />';
				$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" />';
				$salida.= '</td>';
			}
			//--
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="justificaModificacion(\''.$cui.'\',\''.$nombres.'\','.$zona.','.$nota.','.$total.');" title = "Modificar Nota" ><i class="fa fa-pencil"></i></button>';
					$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="hisotiralModificaciones(\''.$cui.'\','.$pensum.','.$nivel.','.$grado.','.$materia.','.$unidad.');" title = "Ver Historial de Modificaciones" ><i class="fa fa-list"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}



//////////////------------ ver  Notas ------------------/////////////////

function tabla_secciones_ver_notas($pensum,$nivel,$grado,$seccion,$materia,$unidad,$sit){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsNot = new ClsNotas();
	$ClsTar = new ClsTarea();
	$ClsExa = new ClsExamen();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',$sit);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "10px" class = "text-center">No.</td>';
		$salida.= '<th width = "150px" class = "text-center">Alumno</td>';
		$salida.= '<th width = "20px" class = "text-center">Tareas</td>';
		$salida.= '<th width = "20px" class = "text-center">Cortos</td>';
		$salida.= '<th width = "20px" class = "text-center">Trabajos (final)</td>';
		$salida.= '<th width = "20px" class = "text-center">Evaluaciones</td>';
		$salida.= '<th width = "20px" class = "text-center">Actividades</td>';
		$salida.= '<th width = "20px" class = "text-center">Evaluaci&oacute;n</td>';
		$salida.= '<th width = "20px" class = "text-center">Total</td>';
		$salida.= '<th width = "10px" class = "text-center">Validado</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//nombre
        			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//---
	$zonaTareas = $ClsTar->get_notas_tarea('',$cui,$pensum,$nivel,$grado,'',$materia,$unidad,'','Z','1,2');
			$zonaTareasmax = $ClsTar->get_notasmax_tarea('',$cui,$pensum,$nivel,$grado,'',$materia,$unidad,'','Z','1,2');
			if(is_array($zonaTareasmax)){
    			foreach($zonaTareasmax as $row){
    				$puntoszonatar = $row['puntos'];
    			    $cantidad = $row['cantidad'];
    			
        		}
    		}
			$zonaExamen = $ClsExa->get_notas_examen('',$cui,$pensum,$nivel,$grado,'',$materia,'',$unidad,'','Z','1,2,3');
			$zonaExamenmax = $ClsExa->get_notasmax_examen('',$cui,$pensum,$nivel,$grado,'',$materia,'',$unidad,'','Z','1,2,3');
			if(is_array($zonaExamenmax)){
    			foreach($zonaExamenmax as $row){
    				$puntoszonaex = $row['puntos'];
    			    $cantidad1 = $row['cantidad'];
    			}
    		}
			$notaTareas = $ClsTar->get_notas_tarea('',$cui,$pensum,$nivel,$grado,'',$materia,$unidad,'','E','1,2');
			$notaTareasmax = $ClsTar->get_notasmax_tarea('',$cui,$pensum,$nivel,$grado,'',$materia,$unidad,'','E','1,2');
			if(is_array($notaTareasmax)){
    			foreach($notaTareasmax as $row){
    				$puntosnotatar = $row['puntos'];
    			    $cantidad2 = $row['cantidad'];
    			}
    		}
			$notaExamen = $ClsExa->get_notas_examen('',$cui,$pensum,$nivel,$grado,'',$materia,'',$unidad,'','E','1,2,3');
			$notaExamenmax = $ClsExa->get_notasmax_examen('',$cui,$pensum,$nivel,$grado,'',$materia,'',$unidad,'','E','1,2,3');
			if(is_array($notaExamenmax)){
    			foreach($notaExamenmax as $row){
    				$puntosnotaex = $row['puntos'];
    			    $cantidad3 = $row['cantidad'];
    			}
    		}
			$salida.= '<th width = "20px" class = "text-center">'.$zonaTareas.'</td>';
			$salida.= '<th width = "20px" class = "text-center">'.$zonaExamen.'</td>';
			$salida.= '<th width = "20px" class = "text-center">'.$notaTareas.'</td>';
			$salida.= '<th width = "20px" class = "text-center">'.$notaExamen.'</td>';
			$cantidadtotal= $puntoszonatar+$puntoszonaex+$puntosnotatar+$puntosnotaex;
			$totalValida = 100 * ($zonaTareas + $zonaExamen + $notaTareas + $notaExamen) / $cantidadtotal;
			$totalValida = round($totalValida);
			///--comprueba si el alumno ya tiene nota, si no da la opcion para grabar.  Si ya tiene nota da la opcion para modificar y señala que ya tiene...
			$result_nota_alumno = $ClsNot->comprueba_notas_alumno($cui,$pensum,$nivel,$grado,$materia,$unidad);
			if(is_array($result_nota_alumno)){
				foreach($result_nota_alumno as $row_nota_alumno){
					$zona = $row_nota_alumno["not_zona"];
					$nota = $row_nota_alumno["not_nota"];
					$situacion = $row_nota_alumno["not_situacion"];
					$total = $row_nota_alumno["not_total"];
				}
				$tipo_usuario = $_SESSION['tipo_usuario'];
				if($tipo_usuario == 5 || $tipo_usuario == 1){
					$disabled = "";
				}else{	
					$disabled = ($situacion != 1)?"disabled":"";
				}
				if($total < $totalValida){
					$zona = $zonaTareas + $zonaExamen;
					$nota = $notaTareas + $notaExamen;
					$validacion = '<span id = "spancheck'.$i.'" class="btn btn-warning btn-xs" title = "revisar  nota" >Revisar</i></span> ';
				}else{
					$validacion = '<span id = "spancheck'.$i.'" class="btn btn-success btn-xs" title = "Este Alumno ya Tiene Nota" >Validado</i></span> ';
				}
				$salida.= '<td class = "text-center" >'.$zona.'</td>';
				$salida.= '<td class = "text-center" >'.$nota.'</td>';
				$salida.= '<td class = "text-center" >'.$total.'</td>';
				$salida.= '<td class = "text-center" >'.$validacion.'</td>';
			}else{
				$zona = '';
				$nota = '';
				$total = '';
				$zonaTareas = $ClsTar->get_notas_tarea('',$cui,$pensum,$nivel,$grado,'',$materia,$unidad,'','Z','1,2');
				$zonaExamen = $ClsExa->get_notas_examen('',$cui,$pensum,$nivel,$grado,'',$materia,'',$unidad,'','Z','1,2,3');
				$zona = $zonaTareas + $zonaExamen;
				$notaTareas = $ClsTar->get_notas_tarea('',$cui,$pensum,$nivel,$grado,'',$materia,$unidad,'','E','1,2');
				$notaExamen = $ClsExa->get_notas_examen('',$cui,$pensum,$nivel,$grado,'',$materia,'',$unidad,'','E','1,2,3');
				$nota = $notaTareas + $notaExamen;
				//--
				$total = ($zona + $nota);
				$salida.= '<td class = "text-center" >'.$zona.'</td>';
				$salida.= '<td class = "text-center" >'.$nota.'</td>';
				$salida.= '<td class = "text-center" >'.$total.'</td>';
				$salida.= '<td class = "text-center" >';
				$salida.= '<span id = "spancheck'.$i.'" class="btn btn-danger btn-xs" title = "Este Alumno aun no Tiene Nota" >Pendiente</i></span> ';
				$salida.= '</td>';
			}
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


////////////////--------- REPORTE DE NOTAS --------------//////////////
function tabla_secciones_alumnos_hitorial_notas($pensum,$nivel,$grado,$seccion){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',$sit);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "15px" class = "text-center">No.</th>';
		$salida.= '<th width = "70px" class = "text-center">CUI</th>';
		$salida.= '<th width = "200px" class = "text-center">ALUMNO</th>';
		$salida.= '<th width = "70px" class = "text-center">SECCION</th>';
		$salida.= '<th width = "130px" class = "text-center"><span class="fa fa-cogs" aria-hidden="true"></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//catalogo
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//seccion
			$sec = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$sec.'</td>';
			//---
			$salida.= '<td class = "text-center" >';
			//$salida.= '<a class="btn btn-primary" onclick="confirmTarjetaNotasIndividual('.$i.',3);" title = "Desplegar Tarjeta de Notas" ><span class="fa fa-file-text-o"></span></a> ';
			//$salida.= '<button class="btn btn-default" onclick="confirmTarjetaNotasIndividual('.$i.',2);" title = "Desplegar Tarjeta de Notas" disabled ><span class="fa fa-file-excel-o text-success"></span></button> ';
			$salida.= '<a class="btn btn-default" onclick="Tarjeta_Notas_Individual('.$i.',1);" title = "Imprimir Tarjeta de Evaluaciones" ><span class="fa fa-print text-primary"></span></a> ';
			$salida.= '</td>';
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_secciones_alumnos_diplomas($pensum,$nivel,$grado,$seccion){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "15px" class = "text-center">No.</th>';
		$salida.= '<th width = "70px" class = "text-center">CUI</th>';
		$salida.= '<th width = "200px" class = "text-center">ALUMNO</th>';
		$salida.= '<th width = "70px" class = "text-center">SECCION</th>';
		$salida.= '<th width = "130px" class = "text-center"><span class="fa fa-cogs" aria-hidden="true"></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//catalogo
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//seccion
			$sec = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$sec.'</td>';
			//---
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-primary" href="CPREPORTES/REPdiploma.php?cui='.$cui.'" target = "_blank" title = "Imprimir Diploma" ><span class="fa fa-graduation-cap"></span></a> ';
			$salida.= '</td>';
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}

//////////////------------ ver  Notas ------------------/////////////////

function tabla_secciones_ver_notas_sabana($cod,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,$tipo,$sit){
    
	$ClsTar = new ClsTarea();
	$ClsAcad = new ClsAcademico();
	$ClsExa = new ClsExamen();
	$resultTarea = $ClsTar->get_tarea($cod,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,'','','','',$sit);
	$resultExa = $ClsExa->get_examen($cod,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,'','','','',$sit);
	$sit = 1;
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',$sit);
	
	if(is_array($resultTarea)){
	    $x =1;
		$Thoras = 0;
			$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "150px" class = "text-center">ALUMNO.</td>';
		    foreach($resultTarea as $row){
			$nombre = utf8_decode($row["tar_nombre"]);
			$salida.= '<th width = "100px" class = "text-center">'.$nombre.'</td>';
			$x++;
			}
			foreach($resultExa as $row){
			$nombreexa = utf8_decode($row["exa_titulo"]);
			$salida.= '<th width = "100px" class = "text-center">'.$nombreexa.'</td>';
			$x++;
			}
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
		    $cui = utf8_decode($row["alu_cui"]);
		    $alumno = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$alumno;
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//No.
			$salida.= '<td class = "text-center">'.$nombres.'</td>';
		foreach($resultTarea as $row){
			$tarea = $row["tar_codigo"];   
    	    $resultnota = $ClsTar->get_det_tarea($tarea,$cui,$pensum,$nivel ,$grado ,$seccion,$materia ,$unidad );
        	    foreach($resultnota as $row){
        	        $tareanota = $row["dtar_nota"]; 
        	        $sit = $row["dtar_situacion"];
			        $tareanota = ($sit == 1)?"":$tareanota." Punto(s).";
        	    }
			//nota
			if ($tareanota != ""){
		        $salida.= '<td class = "text-left">'.$tareanota.'</td>';
			}else{
			    $salida.= '<td class = "text-left">0 Punto(s).</td>';
			}
	    }
	    
	    
	    foreach($resultExa as $row){
			$examen = $row["exa_codigo"];   
    	    $resultexa = $ClsExa->get_det_examen($examen,$cui,$pensum,$nivel ,$grado ,$seccion,$materia,'' ,$unidad );
        	    foreach($resultexa as $row){
        	        $exanota = $row["dexa_nota"]; 
        	        $sit = $row["dexa_situacion"];
        	    }
			//nota
			if ($exanota != ""){
		        $salida.= '<td class = "text-left">'.$exanota.' Punto(s).</td>';
			}else{
			    $salida.= '<td class = "text-left">0 Punto(s).</td>';
			}
	    }
			$salida.= '</tr>';
			
		
			$i++;
		}
			$salida.= '</table>';
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-warning"></i> No se registran tareas en este tema...';
		$salida.= '</h5>';
	}
	
	return $salida;
}

function identificaRangosLetras($result,$valor){
	$valor = number_format($valor,2,'.','');
	foreach ($result as $row){
		$mayor = trim($row["lit_alta"]);
		$menor = trim($row["lit_baja"]);
		if($valor >= $menor && $valor <= $mayor){
			return $mayor;
		}
	}
	return "";
}


function identificaRangosTipificacion($result,$valor){
	$valor = number_format($valor,0,'','');
	foreach ($result as $row){
		$mayor = trim($row["tip_alta"]);
		$menor = trim($row["tip_baja"]);
		if($valor >= $menor && $valor <= $mayor){
			return $mayor;
		}
	}
	return "";
}


function descripcionRangosLetras($result,$valor){
	$valor = number_format($valor,2,'.','');
	foreach ($result as $row){
		$mayor = trim($row["lit_alta"]);
		$menor = trim($row["lit_baja"]);
		if($valor >= $menor && $valor <= $mayor){
			return utf8_decode($row["lit_letra"]);
		}
	}
	return "";
}


function descripcionRangosTipificacion($result,$valor){
	$valor = number_format($valor,0,'','');
	foreach ($result as $row){
		$mayor = trim($row["tip_alta"]);
		$menor = trim($row["tip_baja"]);
		if($valor >= $menor && $valor <= $mayor){
			return utf8_decode($row["tip_califcacion"]);
		}
	}
	return "";
}

?>
