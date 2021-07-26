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
			$salida.= '<a href="FRMmaterias.php?hashkey='.$hashkey.'">';
            $salida.= '<img src="../../CONFIG/Fotos/'.$foto.'" class="img-circle avatar hidden-phone" width = "50px" />';
			$salida.= '</a>';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-left">';
            $salida.= '<a href="FRMmaterias.php?hashkey='.$hashkey.'" class="name">'.$nombre.'</a>';
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
            $salida.= '<a class="btn-glow primary" href="FRMmaterias.php?hashkey='.$hashkey.'" ><i class="icon icon-arrow-right"></i></a>';
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


function lista_materias($cui){
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	$ClsAcad = new ClsAcademico();
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
		$result = $ClsPen->get_materia($pensum,$nivel,$grado,'','',1);
		if(is_array($result)){
			//------------------------------------------------------------------------------------------------------
			$salida.='<br>';
			$salida.='<div class="panel-body users-list">';
			$salida.='<div class="row-fluid table">';
			$salida.='<table class="table table-hover">';
			$salida.='<tr>';
			$salida.='<th class = "text-center" width = "15px" >No.</th>';
			$salida.='<th class = "text-center" width = "30px" >Materia</th>';
			$salida.='<th class = "text-center" width = "50px" ></th>';
			$salida.='</tr>';
			$salida.='</thead>';
				//--
			$i = 1;
			foreach($result as $row){
				$materia_codigo = $row["mat_codigo"];
				$materia_descripcion = utf8_decode($row["mat_descripcion"]);
				$salida.='</tr>';
				//--
				$salida.='<th class = "text-center">'.$i.'.</th>';
				//--
				$salida.='<td class = "text-left">';
				$salida.='<a href="FRMdetalle.php?cui='.$cui.'&pensum='.$pensum.'&nivel='.$nivel.'&grado='.$grado.'&seccion='.$seccion.'&materia='.$materia_codigo.'" target = "_blank" class="name">'.$materia_descripcion.'</a>';
				$salida.='</td>';
				//--
				$salida.='<td>';
				$salida.='<a class="btn-glow primary" href="FRMdetalle.php?cui='.$cui.'&pensum='.$pensum.'&nivel='.$nivel.'&grado='.$grado.'&seccion='.$seccion.'&materia='.$materia_codigo.'" target = "_blank" title="Ver detalle de la Materia" ><i class="icon icon-profile"></i></a>';
				$salida.='</td>';
				//--
				$salida.='</tr>';
				$i++;
			}
			$salida.='</table>';
			$salida.='</div>';
			$salida.='</div>';
			$salida.='<br>';
			//------------------------------------------------------------------------------------------------------
		}
		//--
		
	}else{
		$salida = '<h4 class = "alert alert-warning">No se registran materias asignadas..</h4>';
	}
	
	return $salida;
}




function lista_notas($cui,$pensum,$nivel,$grado,$seccion,$materia){
	$nota_minima = 65;
	$ClsAcad = new ClsAcademico();
	$ClsNota = new ClsNotas();
	
	$salida.='<br>';
	$salida.='<table class="display" width="100%" cellspacing="0" border="1">';
	$salida.='<thead>';
	$salida.='<tr>';
	$salida.='<th class = "text-center" width = "15px" rowspan = "2" >No.</th>';
	$salida.='<th class = "text-center" width = "150px" colspan = "3">1. Unidad</th>';
	$salida.='<th class = "text-center" width = "150px" colspan = "3">2. Unidad</th>';
	$salida.='<th class = "text-center" width = "150px" colspan = "3">3. Unidad</th>';
	$salida.='<th class = "text-center" width = "150px" colspan = "3">4. Unidad</th>';
	$salida.='<th class = "text-center" width = "150px" colspan = "3">5. Unidad</th>';
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
	$salida.='<th class = "text-center" width = "50px">ACTIV.</th>';
	$salida.='<th class = "text-center" width = "50px">EVAL.</th>';
	$salida.='<th class = "text-center" width = "50px">TOTAL</th>';
	//--5.
	$salida.='<th class = "text-center" width = "50px">ACTIV.</th>';
	$salida.='<th class = "text-center" width = "50px">EVAL.</th>';
	$salida.='<th class = "text-center" width = "50px">TOTAL</th>';
	$salida.='</tr>';
	$salida.='</thead>';
	//------------------------------------------------------------------------------------------------------
	//tabla de Notas
	$salida.='</tr>';
		$salida.='<td class = "text-center">1.</td>';
	for($z = 1; $z <= 5; $z++){
		$result = $ClsNota->get_notas_alumno_tarjeta($cui,$pensum,$nivel,$grado,$seccion,$materia,$z);
		if(is_array($result)){
			$total = 0;
			foreach($result as $row){
				$zona = $row["not_zona"];
				$nota = $row["not_nota"];
				$total  = $row["not_total"];
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
	
	return $salida;
}




function lista_horarios($pensum,$nivel,$grado,$seccion,$materia){
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_horario('','','','','','',$pensum,$nivel,$grado,$seccion,$materia,'','');
	if (is_array($result)) {
		$salida.='<br>';
		$salida.='<table class="display" width="100%" cellspacing="0" border="1">';
		$salida.='<thead>';
		$salida.='<tr>';
		$salida.='<th class = "text-center" width = "15px" >No.</th>';
		$salida.='<th class = "text-center" width = "150px">PERIODO</th>';
		$salida.='<th class = "text-center" width = "50px">TIEMPO</th>';
		$salida.='<th class = "text-center" width = "60px">HORARIO</th>';
		$salida.='<th class = "text-center" width = "100px">DIA</th>';
		$salida.='</tr>';
		$salida.='</thead>';
		//------------------------------------------------------------------------------------------------------
		$i = 1;	
		foreach ($result as $row){
			$salida.='</tr>';
			
			$periodo = utf8_decode($row["tip_descripcion"]);
			$tiempo = $row["tip_minutos"]." MINUTOS";
			$hini = $row["per_hini"];
			$hfin = $row["per_hfin"];
			$dia = trim($row["per_dia"]);
			switch($dia){	
				case '1': $dia_desc = "LUNES"; break;
				case '2': $dia_desc = "MARTES"; break;
				case '3': $dia_desc = "MIERCOLES"; break;
				case '4': $dia_desc = "JUEVES"; break;
				case '5': $dia_desc = "VIERNES"; break;
				case '6': $dia_desc = "SABADO"; break;
				case '7': $dia_desc = "DOMINGO"; break;
			}
			$salida.='<td class = "text-center">'.$i.'.</td>';
			$salida.='<td class = "text-left">'.$periodo.'</td>';
			$salida.='<td class = "text-center">'.$tiempo.' MINUTOS</td>';
			$salida.='<td class = "text-center">'.$hini.'-'.$hfin.'</td>';
			$salida.='<td class = "text-center">'.$dia_desc.'</td>';
			$salida.='</tr>';
			$i++;
		}
		$salida.='</table>';
		$salida.='<br>';
		//--
	}else{
		$salida = '<h4 class = "alert alert-warning">No se reportan horarios asignados..</h4>';
	}
	
	return $salida;
}


?>