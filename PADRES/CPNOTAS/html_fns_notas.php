<?php 
include_once('../html_fns.php');

function tabla_hijos($padre){
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_alumno_padre($padre,"");
	
	if(is_array($result)){
			$salida.= '<div class="panel-body users-list">';
            $salida.= '<div class="row-fluid table">';
			$salida.= '<table class="table table-hover">';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
            //foto
            $cui = trim($row["alu_cui"]);
			$foto = trim($row["alu_foto"]);
			if(file_exists ('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
                $foto = 'ALUMNOS/'.$foto.'.jpg';
            }else{
                $foto = 'nofoto.png';
            }
			//--
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsAsi->encrypt($cui, $usu);
            //nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
            $nombre = ucwords(strtolower($nom));
            $apellido = ucwords(strtolower($ape));
			//--
			$salida.= '<td>';
			$salida.= '<a href="FRMnotas.php?hashkey='.$hashkey.'">';
            $salida.= '<img src="../../CONFIG/Fotos/'.$foto.'" class="img-circle avatar hidden-phone" width = "50px" />';
			$salida.= '</a>';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-left">';
            $salida.= '<a href="FRMnotas.php?hashkey='.$hashkey.'" class="name">'.$nombre.'</a>';
            $salida.= '<span class="subtext">'.$apellido.'</span>';
            $salida.= '</td>';
			//grado(seccion)
			$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
			$edad = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
			$salida.= '<td class = "text-center">'.$fecnac.' ('.$edad.' a&ntilde;os)</td>';
			//grado(seccion)
			$desc_nomina = $row["alu_desc_nomina"];
			$salida.= '<td class = "text-center">'.$desc_nomina.'</td>';
			//--
			$salida.= '<td>';
            $salida.= '<a class="btn-glow primary" href="FRMnotas.php?hashkey='.$hashkey.'" ><i class="icon icon-arrow-right"></i></a>';
            $salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function lista_notas_por_unidad($cui,$parcial){
	$nota_minima = 65;
	
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	$ClsAcad = new ClsAcademico();
	$ClsNota = new ClsNotas();
	$result = $ClsAcad->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);  ////// este array se coloca en la columna de combos
	if(is_array($result)){
		$j = 0;
		foreach($result as $row){
			$nivel = $row["seca_nivel"];
			$grado = $row["seca_grado"];
			$seccion = $row["seca_seccion"];
			$j++;
		}
		
		////// Trae las materias a listar en las notas
		$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado,'','',1);
		if(is_array($result_materias)){
			$mat_count = 1;
			foreach($result_materias as $row_materia){
				//--
				$pensum_desc = $row_materia["pen_descripcion"];
				$nivel_desc = $row_materia["niv_descripcion"];
				$grado_desc = $row_materia["gra_descripcion"];
				//--
				$materia_codigo[$mat_count] = $row_materia["mat_codigo"];
				$materia_descripcion[$mat_count] = utf8_decode($row_materia["mat_descripcion"]);
				//--
				$mat_count++;
			}
			$mat_count--;
		}
		//--
		
		$salida.='<table class="display" width="100%" cellspacing="0" border="1">';
		$salida.='<thead>';
		$salida.='<tr>';
		$salida.='<th class = "text-center" width = "20px">No.</th>';
		$salida.='<th class = "text-center" width = "250px">Materia</th>';
		$salida.='<th class = "text-center" width = "50px">Actividades</th>';
		$salida.='<th class = "text-center" width = "50px">Evaluaci&oacute;n</th>';
		$salida.='<th class = "text-center" width = "50px">Total</th>';
		//$salida.='<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
		$salida.='</tr>';
		$salida.='</thead>';
		
		for($z = 1; $z <= $mat_count; $z++){
			$materia = $materia_descripcion[$z];
			$codigo = $materia_codigo[$z];
			
			$result = $ClsNota->get_notas_alumno_tarjeta($cui,$pensum,$nivel,$grado,$seccion,$materia_codigo[$z],$parcial);
			if(is_array($result)){
				$total = 0;
				foreach($result as $row){
					$zona = $row["not_zona"];
					$nota = $row["not_nota"];
					$total = $row["not_total"];
				}
				//---
			}else{
				$zona = "PENDIENTE";
				$nota = "PENDIENTE";
				$total = "PENDIENTE";
			}
			$color = ($total <= $nota_minima )?"text-danger":"";
			$salida.='<tr>';
			$salida.='<td class = "text-center">'.$z.'.</td>';
			$salida.='<td class = "text-left">'.$materia.'</td>';
			$salida.='<td class = "text-center">'.$zona.'</td>';
			$salida.='<td class = "text-center">'.$nota.'</th>';
			$salida.='<td class = "text-center"><label class = "'.$color.'">'.$total.'</label></th>';
			//--
			//$salida.= '<td class = "text-center" >';
			//$salida.= '<button type="button" class="btn btn-info btn-xs" onclick="promtComentario(\''.$cui.'\','.$pensum.','.$nivel.','.$grado.','.$materia_codigo[$z].','.$parcial.');" title = "Comentario de Maestro" ><i class="fa fa-comments"></i></button>';
			//$salida.= '</td>';
			//--
			$salida.='</tr>';
			
		}
		$salida.='</table>';
		
	}else{
		$salida = '<h4 class = "alert alert-warning">No se reportan datos..</h4>';
	}
	
	return $salida;
}





function lista_notas_por_materia($cui){
	$nota_minima = 65;
	
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	$ClsAcad = new ClsAcademico();
	$ClsNota = new ClsNotas();
	$result = $ClsAcad->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);  ////// este array se coloca en la columna de combos
	if(is_array($result)){
		$j = 0;
		foreach($result as $row){
			$nivel = $row["seca_nivel"];
			$grado = $row["seca_grado"];
			$seccion = $row["seca_seccion"];
			$j++;
		}
		
		////// Trae las materias a listar en las notas
		$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado,'','',1);
		if(is_array($result_materias)){
			$mat_count = 1;
			//------------------------------------------------------------------------------------------------------
			
			foreach($result_materias as $row_materia){
				$salida.='<br>';
				$salida.='<table class="display" width="100%" cellspacing="0" border="1">';
				$salida.='<thead>';
				$salida.='<tr>';
				$salida.='<th class = "text-center" width = "15px" rowspan = "2" >No.</th>';
				$salida.='<th class = "text-center" width = "150px" rowspan = "2" >Materia</th>';
				$salida.='<th class = "text-center" width = "150px" colspan = "3">1. Unidad</th>';
				$salida.='<th class = "text-center" width = "150px" colspan = "3">2. Unidad</th>';
				$salida.='<th class = "text-center" width = "150px" colspan = "3">3. Unidad</th>';
				//$salida.='<th class = "text-center" width = "150px" colspan = "3">4. Unidad</th>';
				//$salida.='<th class = "text-center" width = "150px" colspan = "3">5. Unidad</th>';
				$salida.='</tr>';
				$salida.='<tr>';
				//--1.
				$salida.='<th class = "text-center" width = "50px">ACTIV.</th>';
				$salida.='<th class = "text-center" width = "50px">EVAL.</th>';
				$salida.='<th class = "text-center" width = "50px">TOTAL</th>';
				//--2.
				$salida.='<th class = "text-center" width = "50px">ACTIV.</th>';
				$salida.='<th class = "text-center" width = "50px">EVAL.</th>';
				$salida.='<th class = "text-center" width = "50px">TOTAL</th>';
				//--3.
				$salida.='<th class = "text-center" width = "50px">ACTIV.</th>';
				$salida.='<th class = "text-center" width = "50px">EVAL.</th>';
				$salida.='<th class = "text-center" width = "50px">TOTAL</th>';
				//--4.
				/*$salida.='<th class = "text-center" width = "50px">ACTIV.</th>';
				$salida.='<th class = "text-center" width = "50px">EVAL.</th>';
				$salida.='<th class = "text-center" width = "50px">TOTAL</th>';
				//--5.
				$salida.='<th class = "text-center" width = "50px">ACTIV.</th>';
				$salida.='<th class = "text-center" width = "50px">EVAL.</th>';
				$salida.='<th class = "text-center" width = "50px">TOTAL</th>';*/
				$salida.='</tr>';
				$salida.='</thead>';
				//--
				$materia_codigo = $row_materia["mat_codigo"];
				$materia_descripcion = utf8_decode($row_materia["mat_descripcion"]);
				//------------------------------------------------------------------------------------------------------
				//tabla de Notas
				$salida.='</tr>';
					$salida.='<td class = "text-center">'.$mat_count.'.</td>';
					$salida.='<td class = "text-left">'.$materia_descripcion.'</td>';
				for($z = 1; $z <= 3; $z++){
					$result = $ClsNota->get_notas_alumno_tarjeta($cui,$pensum,$nivel,$grado,$seccion,$materia_codigo,$z);
					if(is_array($result)){
						$total = 0;
						foreach($result as $row){
							$zona = $row["not_zona"];
							$nota = $row["not_nota"];
				        	$total = $row["not_total"];
						}
						//---
					}else{
						$zona = "-";
						$nota = "-";
						$total = "-";
					}
					$color = ($total <= $nota_minima )?"text-danger":"";
					$salida.='<td class = "text-center">'.$zona.'</td>';
					$salida.='<td class = "text-center">'.$nota.'</th>';
					$salida.='<td class = "text-center"><label class = "'.$color.'">'.$total.'</label></th>';	
				}
				$salida.='</tr>';
				$salida.='</table>';
				$salida.='<br>';
				//--
				$mat_count++;
			}
			
			//------------------------------------------------------------------------------------------------------
		}
		//--
		
	}else{
		$salida = '<h4 class = "alert alert-warning">No se reportan datos..</h4>';
	}
	
	return $salida;
}


?>
