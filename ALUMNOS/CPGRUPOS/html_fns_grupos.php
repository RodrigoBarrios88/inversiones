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
			$salida.= '<a href="FRMgrupos.php?hashkey='.$hashkey.'">';
            $salida.= '<img src="../../CONFIG/Fotos/'.$foto.'" class="img-circle avatar hidden-phone" width = "50px" />';
			$salida.= '</a>';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-left">';
            $salida.= '<a href="FRMgrupos.php?hashkey='.$hashkey.'" class="name">'.$nombre.'</a>';
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
            $salida.= '<a class="btn-glow primary" href="FRMgrupos.php?hashkey='.$hashkey.'" ><i class="icon icon-arrow-right"></i></a>';
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


function lista_grupos($cui){
	$ClsAsi = new ClsAsignacion();
	////// Trae las materias a listar en las notas
	$result = $ClsAsi->get_alumno_grupo("",$cui,1);
	if(is_array($result)){
		//------------------------------------------------------------------------------------------------------
		$salida.='<br>';
		$salida.='<div class="panel-body users-list">';
		$salida.='<div class="row-fluid table">';
		$salida.='<table class="table table-hover">';
		$salida.='<tr>';
		$salida.='<th class = "text-center" width = "15px" >No.</th>';
		$salida.='<th class = "text-left" width = "150px" >AREA</th>';
		$salida.='<th class = "text-left" width = "150px" >GRUPO</th>';
		$salida.='<th class = "text-center" width = "50px" ></th>';
		$salida.='</tr>';
		$salida.='</thead>';
		//--
		$i = 1;
		foreach($result as $row){
			$grupo = $row["gru_codigo"];
			$salida.='</tr>';
			//--
			$salida.='<th class = "text-center">'.$i.'.</th>';
			//--
			$area_descripcion = utf8_decode($row["are_nombre"]);
			$salida.='<td class = "text-left">';
			$salida.='<a href="FRMdetalle.php?cui='.$cui.'&grupo='.$grupo.'" target = "_blank" class="name">'.$area_descripcion.'</a>';
			$salida.='</td>';
			//--
			//--
			$grupo_descripcion = utf8_decode($row["gru_nombre"]);
			$salida.='<td class = "text-left">';
			$salida.='<a href="FRMdetalle.php?cui='.$cui.'&grupo='.$grupo.'" target = "_blank" class="name">'.$grupo_descripcion.'</a>';
			$salida.='</td>';
			//--
			$salida.='<td>';
			$salida.='<a class="btn-glow primary" href="FRMdetalle.php?cui='.$cui.'&grupo='.$grupo.'" target = "_blank" title="Ver detalle del Grupo" ><i class="icon icon-profile"></i></a>';
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
		}else{
			$salida = '<h4 class = "alert alert-warning">No se registran grupos asignadas..</h4>';
		}
	
	return $salida;
}

?>