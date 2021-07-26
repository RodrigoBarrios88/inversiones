<?php 
include_once('../html_fns.php');

//////////////////---- Otros Alumnos -----/////////////////////////////////////////////
function tabla_direcotrio_alumnos(){
	$ClsAlu = new ClsAlumno();
	$result = $ClsAlu->get_alumno_grados_secciones($cui,'','',1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "60px">ID</td>';
			$salida.= '<th class = "text-center" width = "60px">TIPO ID</td>';
			$salida.= '<th class = "text-center" width = "170px">ALUMNO</td>';
			$salida.= '<th class = "text-center" width = "100px">GRADO</td>';
			$salida.= '<th class = "text-center" width = "50px">SECCION</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//ID
			$id = utf8_decode($row["alu_cui"]);
			$salida.= '<td class = "text-center">'.$id.'</td>';
			//TIPO ID
			$tipo = utf8_decode($row["alu_tipo_cui"]);
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//correo
			$grado = utf8_decode($row["alu_grado"]);
			$salida.= '<td class = "text-left">'.$grado.'</td>';
			//telefono1
			$seccion = utf8_decode($row["alu_seccion"]);
			$salida.= '<td class = "text-center">'.$seccion.'</td>';
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



function tabla_alumnos($pensum,$nivel,$grado,$seccion,$acc){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			if($acc == 1){
			$salida.= '<th class = "text-center" width = "60px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "60px">ID</td>';
			$salida.= '<th class = "text-center" width = "60px">TIPO ID</td>';
			$salida.= '<th class = "text-center" width = "120px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "120px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "200px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "100px">CORREO</td>';
			$salida.= '<th class = "text-center" width = "100px">TEL&Eacute;FONO</td>';
			}else if($acc == 2){
			$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "60px">ID</td>';
			$salida.= '<th class = "text-center" width = "60px">TIPO ID</td>';
			$salida.= '<th class = "text-center" width = "120px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "120px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "200px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "100px">CORREO</td>';
			$salida.= '<th class = "text-center" width = "100px">TEL&Eacute;FONO</td>';
			}else if($acc == 3){
			$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "60px">ID</td>';
			$salida.= '<th class = "text-center" width = "60px">TIPO ID</td>';
			$salida.= '<th class = "text-center" width = "120px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "120px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "200px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "100px">CORREO</td>';
			$salida.= '<th class = "text-center" width = "100px">TEL&Eacute;FONO</td>';
			}else if($acc == 4){
			$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "60px">ID</td>';
			$salida.= '<th class = "text-center" width = "60px">TIPO ID</td>';
			$salida.= '<th class = "text-center" width = "120px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "120px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "200px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "100px">CORREO</td>';
			$salida.= '<th class = "text-center" width = "100px">TEL&Eacute;FONO</td>';
			}else if($acc == 5){
			$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "60px">ID</td>';
			$salida.= '<th class = "text-center" width = "60px">TIPO ID</td>';
			$salida.= '<th class = "text-center" width = "120px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "120px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "200px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "100px">CORREO</td>';
			$salida.= '<th class = "text-center" width = "100px">TEL&Eacute;FONO</td>';
			}else{
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "60px">ID</td>';
			$salida.= '<th class = "text-center" width = "60px">TIPO ID</td>';
			$salida.= '<th class = "text-center" width = "120px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "120px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "200px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "100px">CORREO</td>';
			$salida.= '<th class = "text-center" width = "100px">TEL&Eacute;FONO</td>';
			}
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			if($acc == 1){
				//codigo
				$cui = $row["alu_cui"];
				$sit = $row["alu_situacion"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAcad->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-default btn-xs" href="FRMmodalumno.php?hashkey='.$hashkey.'" title = "Editar Alumno" ><span class="fa fa-pencil"></span></a> ';
				if($sit == 1){
				$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Alumno(\''.$cui.'\')" title = "inhabilitar Alumno" ><span class="fa fa-trash"></span></button>';
				}else if($sit == 2){
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "Habilita_Alumno(\''.$cui.'\')" title = "Habilitar Alumno" ><span class="fa fa-check"></span></button>';
				}
				$salida.= '</td>';
			}else if($acc == 2){
				//codigo
				$cui = $row["alu_cui"];
				$sit = $row["alu_situacion"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAcad->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a type="button" class="btn btn-primary btn-xs" href="FRMalumnoasig.php?hashkey='.$hashkey.'" title = "Asignar Alumno a Grupo" ><i class="fa fa-link"></i></a>';
				$salida.= '</td>';
			}else if($acc == 3){
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAcad->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-success btn-xs" target = "_blank" href="FRMfoto.php?hashkey='.$hashkey.'" title = "Cambiar Foto de Alumno" ><i class="fa fa-camera"></i></a>';
				$salida.= '</td>';
			}else if($acc == 4){
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAcad->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-info btn-xs" target = "_blank" href="FRMficha.php?hashkey='.$hashkey.'" title = "Ver Ficha T&eacute;cnica del Alumno" ><i class="fa fa-search"></i></a>';
				$salida.= '</td>';
			}else if($acc == 5){
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAcad->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-info btn-xs" target = "_blank" href="FRMbitacora.php?hashkey='.$hashkey.'" title = "Ver Bitacora Psicopedagogica del Alumno" ><i class="fa fa-search"></i></a>';
				$salida.= '</td>';
			}else{
				$salida.= '<td class = "text-center">'.$i.'.</td>';
			}
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
			$salida.= '<td class = "text-center">'.$mail.'</td>';
			//telefono1
			$tel = $row["alu_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
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


function lista_padres($filas,$arrcui,$arrnom,$arrape,$arrtel,$arrmail,$arrexist){
	//echo $filas;
	if($filas > 0){
		for($i = 1; $i <= $filas; $i++){
			$salida.= '<div class="row">';
			//mail
			$cui = $arrcui[$i];
			$salida.= '<div class="col-xs-2 text-right"><label>CUI: </label> <span class="text-danger">*</span></div>';
			$salida.= '<div class="col-xs-3 text-left"><input type = "text" class="form-control text-libre" name = "cui'.$i.'" id = "cui'.$i.'" value = "'.$cui.'" onkeyup = "enteros(this)" onblur = "xajax_Buscar_Padre(this.value,'.$i.');" onchange = "xajax_Buscar_Padre(this.value,'.$i.');" maxlength = "15" /></div>';              
			//telefono
			$salida.= '</div>';
		//---
			$salida.= '<div class="row">';
			//mail
			$mail = $arrmail[$i];
			$salida.= '<div class="col-xs-2 text-right"><label>e-mail: </label> <span class="text-danger">*</span></div>';
			$salida.= '<div class="col-xs-3 text-left"><input type = "text" class="form-control text-libre" name = "mail'.$i.'" id = "mail'.$i.'" value = "'.$mail.'" onkeyup = "texto(this)" /></div>';
			//telefono
			$tel = $arrtel[$i];
			$salida.= '<div class="col-xs-2 text-right"><label>Telefono: </label> <span class="text-danger">*</span></div>';
			$salida.= '<div class="col-xs-3 text-left"><input type = "text" class="form-control" name = "tel'.$i.'" id = "tel'.$i.'" value = "'.$tel.'" onkeyup = "texto(this)" /></div>';
			$salida.= '</div>';
		//---
			$salida.= '<div class="row">';
			//nombre
			$nom = $arrnom[$i];
			$cui = $arrcod[$i];
			$salida.= '<div class="col-xs-2 text-right"><label>Nombre: </label> <span class="text-danger">*</span></div>';
			$salida.= '<div class="col-xs-3 text-left"><input type = "text" class="form-control" name = "nom'.$i.'" id = "nom'.$i.'" value = "'.$nom.'" onkeyup = "texto(this)" /></div>';
			//codigo
			$ape = $arrape[$i];
			$existe = $arrexist[$i];
			$salida.= '<div class="col-xs-2 text-right"><label>Apellido: </label> <span class="text-danger">*</span></div>';
			$salida.= '<div class="col-xs-3 text-left"><input type = "text" class="form-control" name = "ape'.$i.'" id = "ape'.$i.'" value = "'.$ape.'" onkeyup = "texto(this)" /><input type = "hidden" id ="existe'.$i.'" name = "existe'.$i.'" value = "'.$existe.'"></div>';
			$salida.= '</div>';
		//---
			$salida.= '<hr>';
		}
	}
	
	return $salida;
}




function tabla_alumnos_temporales($nom,$ape,$desc_nomina,$sit){
	$ClsAlu = new ClsAlumno();
	$result =  $ClsAlu->get_alumno_temporal($nom,$ape,$desc_nomina,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "300px">NOMBRE Y APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "100px">GRADO/SECCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "70px">USUARIO</td>';
			$salida.= '<th class = "text-center" width = "50px">PASS</td>';
			$salida.= '<th class = "text-center" width = "100px">CUI</td>';
			$salida.= '<th class = "text-center" width = "20px">SITUACI&Oacute;N</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//grado(seccion)
			$desc_nomina = $row["alu_desc_nomina"];
			$salida.= '<td class = "text-center">'.$desc_nomina.'</td>';
			//USUARIO
			$usu = $row["alu_codigo"];
			$salida.= '<td class = "text-center">'.$usu.'</td>';
			//pass
			$pass = $row["alu_pass"];
			$salida.= '<td class = "text-center">'.$pass.'</td>';
			//CUI
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';	
			//situacion
			$sit = $row["alu_situacion"];
			switch($sit){
				case 0: $icon = '<span class=" text-warning fa fa-warning fa-2x"></span>'; break;
				case 1: $icon = '<span class="text-success fa fa-check fa-2x"></span>'; break;
				default: "";	
			}
			$salida.= '<td class = "text-center" >';
			$salida.= $icon;
			$salida.= '</td>';
				
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



function tabla_psicopedagogica($alumno){
	$ClsAcadem = new ClsAcademico();
	$result =  $ClsAcadem->get_comentario_psicopedagogico('',$alumno, $pensum, $nivel, $grado,$seccion,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-psico">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "70px">GRADO/SECCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "70px">FECHA/REGISTRO</td>';
			$salida.= '<th class = "text-center" width = "200px">COMENTARIO</td>';
			$salida.= '<th class = "text-center" width = "50px">REGISTR&Oacute;</td>';
			$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//grado
			$seccion = utf8_decode($row["sec_descripcion"]);
			$grado = utf8_decode($row["gra_descripcion"]);
			$salida.= '<td class = "text-center">'.$grado.' '.$seccion.'</td>';
			//fecha
			$fechor = $row["psi_fechor_registro"];
			$fechor = cambia_fechaHora($fechor);
			$salida.= '<td class = "text-center">'.$fechor.'</td>';
			//comentario
			$coment = utf8_decode($row["psi_comentario"]);
			$salida.= '<td class = "text-justify">'.$coment.'</td>';
			//usuario
			$usuario_nom = utf8_decode($row["usu_nombre_registro"]);
			$salida.= '<td class = "text-justify">'.$usuario_nom.'</td>';
			//--
			$salida.= '<td class = "text-center" >';
			$usuario = $row["psi_usuario_registro"];
			if($usuario == $_SESSION["codigo"]){
			$codigo = $row["psi_codigo"];
			$alumno = $row["psi_alumno"];
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "EditaComentario(\''.$codigo.'\',\''.$alumno.'\');" title = "Editar Comentario Psicopedagogico" ><span class="fa fa-edit"></span></button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs"  onclick = "Deshabilita_Comentario(\''.$codigo.'\',\''.$alumno.'\');" title = "Eliminar Comentario Psicopedagogico" ><span class="fa fa-trash"></span></button>';
			}else{
			$salida.= '<button type="button" class="btn btn-default btn-xs" title = "Editar Comentario Psicopedagogico" disabled ><span class="fa fa-edit"></span></button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs"  title = "Eliminar Comentario Psicopedagogico" disabled ><span class="fa fa-trash"></span></button>';
			}
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


?>
