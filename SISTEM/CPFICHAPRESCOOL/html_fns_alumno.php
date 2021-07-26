<?php 
include_once('../html_fns.php');

//////////////////---- Otros Alumnos -----/////////////////////////////////////////////

function tabla_direcotrio_alumnos($acc, $pensum = ''){
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAlu = new ClsAlumno();
	
	if($pensum == ""){
		$pensum = $ClsPen->get_pensum_activo();
	}
	
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	if($acc != 6 && $acc != 7){
		if($tipo_usuario === "1"){ /// SI el Usuario es Director
			$result = $ClsAcad->get_otros_usuarios_alumnos($pensum,'','',$tipo_codigo);
		}else if($tipo_usuario === "2"){ /// SI el Usuario es Maestro
			$result = $ClsAcad->get_maestro_alumnos($pensum,'','','',$tipo_codigo);
		}else{ // Si el Usuario es Administrador
			$result = $ClsAcad->get_seccion_alumno($pensum,'','','','');
		}
		///---
		if(is_array($result)){
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "170px">ALUMNO</td>';
			$salida.= '<th class = "text-center" width = "60px">FECHA NAC.</td>';
			$salida.= '<th class = "text-center" width = "100px">GRADO</td>';
			$salida.= '<th class = "text-center" width = "150px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "60px">CORREO</td>';
			$salida.= '<th class = "text-center" width = "50px">TEL&Eacute;FONO</td>';
			$salida.= '<th class = "text-center" width = "30px"></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
			$i=1;
			foreach($result as $row){
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center">'.$i.'.</td>';
				//ID
				$id = utf8_decode($row["alu_cui"]);
				//$salida.= '<td class = "text-center">'.$id.'</td>';
				//TIPO ID
				$tipo = utf8_decode($row["alu_tipo_cui"]);
				//$salida.= '<td class = "text-center">'.$tipo.'</td>';
				//nombre
				$nom = utf8_decode($row["alu_nombre"]);
				$ape = utf8_decode($row["alu_apellido"]);
				$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
				//FECHA NACIMIENTO
				$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
				$salida.= '<td class = "text-center">'.$fecnac.'</td>';
				//correo
				$grado = utf8_decode($row["gra_descripcion"])." ".utf8_decode($row["sec_descripcion"]);
				$salida.= '<td class = "text-left">'.$grado.'</td>';
				//correo
				$pad = utf8_decode($row["alu_padre"]);
				$salida.= '<td class = "text-left">'.$pad.'</td>';
				//correo
				$mail = $row["alu_mail_padre"];
				$salida.= '<td class = "text-left">'.$mail.'</td>';
				//telefono1
				$tel = $row["alu_telefono"];
				$salida.= '<td class = "text-center">'.$tel.'</td>';
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAlu->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-primary btn-xs" target = "_blank" href="FRMficha.php?hashkey='.$hashkey.'" title = "Ver Ficha Preescolar del Alumno" ><i class="fa fa-file-text-o"></i></a>';
				$salida.= '</td>';
				//--
				$salida.= '</tr>';
				$i++;
			}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
		}
	}else{
		$salida.= '<h4 class="alert alert-warning text-center">';
		$salida.= '<i class="fa fa-warning" ></i> Esta opci&oacute;n est&aacute; habilidata solo desde el Directorio por Secciones...';
		$salida.= '</h4>';
	}

	return $salida;
}



function tabla_alumnos($pensum,$nivel,$grado,$seccion){
	$ClsFic = new ClsFicha();
	$result = $ClsFic->get_seccion_alumno($pensum,$nivel,$grado,$seccion);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
		//$salida.= '<th class = "text-center" width = "60px">ID</th>';
		$salida.= '<th class = "text-center" width = "120px">NOMBRE</th>';
		$salida.= '<th class = "text-center" width = "20px">1.</th>';
		$salida.= '<th class = "text-center" width = "20px">2.</th>';
		$salida.= '<th class = "text-center" width = "20px">3.</th>';
		$salida.= '<th class = "text-center" width = "20px">4.</th>';
		$salida.= '<th class = "text-center" width = "20px">5.</th>';
		$salida.= '<th class = "text-center" width = "20px">6.</th>';
		$salida.= '<th class = "text-center" width = "20px">7.</th>';
		$salida.= '<th class = "text-center" width = "20px">8..</th>';
		$salida.= '<th class = "text-center" width = "20px">9.</th>';
		$salida.= '<th class = "text-center" width = "20px">10</th>';
		$salida.= '<th class = "text-center" width = "20px">11</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsFic->encrypt($cui, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-primary btn-xs" target = "_blank" href="FRMficha.php?hashkey='.$hashkey.'" title = "Ver Ficha Preescolar del Alumno" ><i class="fa fa-file-text-o"></i></a>';
			$salida.= '</td>';
			//ID
			$id = utf8_decode($row["alu_cui"]);
			//$salida.= '<td class = "text-center">'.$id.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//informacion
			$p1 = trim($row["info_colegio"]);
			$p1 = ($p1 != "")?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';
			$salida.= '<td class = "text-center">'.$p1.'</td>';
			$p2 = trim($row["info_embarazo"]);
			$p2 = ($p2 != "")?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';
			$salida.= '<td class = "text-center">'.$p2.'</td>';
			$p3 = trim($row["info_parto"]);
			$p3 = ($p3 != "")?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';
			$salida.= '<td class = "text-center">'.$p3.'</td>';
			$p4 = trim($row["info_lactancia"]);
			$p4 = ($p4 != "")?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';
			$salida.= '<td class = "text-center">'.$p4.'</td>';
			$p5 = trim($row["info_motor"]);
			$p5 = ($p5 != "")?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';
			$salida.= '<td class = "text-center">'.$p5.'</td>';
			$p6= trim($row["info_lenguaje"]);
			$p6 = ($p6 != "")?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';
			$salida.= '<td class = "text-center">'.$p6.'</td>';
			$p7= trim($row["info_suenio"]);
			$p7 = ($p7 != "")?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';
			$salida.= '<td class = "text-center">'.$p7.'</td>';
			$p8= trim($row["info_alimentacion"]);
			$p8 = ($p8 != "")?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';
			$salida.= '<td class = "text-center">'.$p8.'</td>';
			$p9= trim($row["info_vista"]);
			$p9 = ($p9 != "")?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';
			$salida.= '<td class = "text-center">'.$p9.'</td>';
			$p10 = trim($row["info_oido"]);
			$p10 = ($p10 != "")?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';
			$salida.= '<td class = "text-center">'.$p10.'</td>';
			$p11 = trim($row["info_conducta"]);
			$p11 = ($p11 != "")?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';
			$salida.= '<td class = "text-center">'.$p11.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$i--;
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


?>