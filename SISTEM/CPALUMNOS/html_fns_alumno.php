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
			$result = $ClsAcad->get_seccion_alumno($pensum,'','','','','','',1);
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
				$sit = $row["alu_situacion"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAlu->encrypt($cui, $usu);
				if($acc == 1){
					$salida.= '<td class = "text-center" >';
					$salida.= '<a class="btn btn-default" href="FRMmodalumno.php?hashkey='.$hashkey.'" title = "Editar Alumno" ><i class="fa fa-pencil"></i></a> ';
					$salida.= '</td>';
				}else if($acc == 2){
					$salida.= '<td class = "text-center" >';
					$salida.= '<a class="btn btn-primary btn-outline" href="FRMalumnoasig.php?hashkey='.$hashkey.'" title = "Asignar Alumno a Grupo" ><i class="fa fa-link"></i></a>';
					$salida.= '</td>';
				}else if($acc == 3){
					$salida.= '<td class = "text-center" >';
					$salida.= '<a class="btn btn-success" href="FRMfoto.php?hashkey='.$hashkey.'" title = "Cambiar Foto de Alumno" ><i class="fa fa-camera"></i></a>';
					$salida.= '</td>';
				}else if($acc == 4){
					$salida.= '<td class = "text-center" >';
					$salida.= '<a class="btn btn-info" target = "_blank" href="FRMficha.php?hashkey='.$hashkey.'" title = "Ver Ficha T&eacute;cnica del Alumno" ><i class="fa fa-search"></i></a>';
					$salida.= '</td>';
				}else if($acc == 5){
					$salida.= '<td class = "text-center" >';
					$salida.= '<a class="btn btn-primary" target = "_blank" href="FRMbitacora.php?hashkey='.$hashkey.'" title = "Ver Bit&aacute;cora Psicopedag&oacute;gica del Alumno" ><i class="fa fa-search"></i></a>';
					$salida.= '</td>';
				}else if($acc == 6){
					$salida.= '<td class = "text-center" >';
					$salida.= '<button type="button" class="btn btn-danger" onclick = "Deshabilita_Alumno(\''.$cui.'\');" title = "inhabilitar Alumno" ><i class="fa fa-trash"></i></button>';
					$salida.= '</td>';
				}else if($acc == 7){
					$salida.= '<td class = "text-center" >';
					$salida.= '<button type="button" class="btn btn-success" onclick = "Habilita_Alumno(\''.$cui.'\')" title = "Habilitar Alumno" ><i class="fa fa-check"></i></button>';
					$salida.= '</td>';
				}
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



function tabla_alumnos($pensum,$nivel,$grado,$seccion,$acc){
	$ClsAcad = new ClsAcademico();
	$sit = ($acc == 7)?2:1;
		
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,$alumno,$cod,$tipo,$sit);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "60px">ID</td>';
		$salida.= '<th class = "text-center" width = "60px">TIPO ID</td>';
		$salida.= '<th class = "text-center" width = "120px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "120px">APELLIDO</td>';
		$salida.= '<th class = "text-center" width = "200px">PADRE O ENCARGADO</td>';
		$salida.= '<th class = "text-center" width = "100px">CORREO</td>';
		$salida.= '<th class = "text-center" width = "100px">TEL&Eacute;FONO</td>';
		$salida.= '<th class = "text-center" width = "30px"></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
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
			$salida.= '<td class = "text-left">'.$mail.'</td>';
			//telefono1
			$tel = $row["alu_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
			//codigo
			$cui = $row["alu_cui"];
			$sit = $row["alu_situacion"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsAcad->encrypt($cui, $usu);
			if($acc == 1){
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-default" href="FRMmodalumno.php?hashkey='.$hashkey.'" title = "Editar Alumno" ><i class="fa fa-pencil"></i></a> ';
				$salida.= '</td>';
			}else if($acc == 2){
				$salida.= '<td class = "text-center" >';
				$salida.= '<a type="button" class="btn btn-primary btn-outline" href="FRMalumnoasig.php?hashkey='.$hashkey.'" title = "Asignar Alumno a Grupo" ><i class="fa fa-link"></i></a>';
				$salida.= '</td>';
			}else if($acc == 3){
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-success" href="FRMfoto.php?hashkey='.$hashkey.'" title = "Cambiar Foto de Alumno" ><i class="fa fa-camera"></i></a>';
				$salida.= '</td>';
			}else if($acc == 4){
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-info" target = "_blank" href="FRMficha.php?hashkey='.$hashkey.'" title = "Ver Ficha T&eacute;cnica del Alumno" ><i class="fa fa-search"></i></a>';
				$salida.= '</td>';
			}else if($acc == 5){
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-primary" target = "_blank" href="FRMbitacora.php?hashkey='.$hashkey.'" title = "Ver Bit&aacute;cora Psicopedag&oacute;gica del Alumno" ><i class="fa fa-search"></i></a>';
				$salida.= '</td>';
			}else if($acc == 6){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-danger" onclick = "Deshabilita_Alumno(\''.$cui.'\');" title = "inhabilitar Alumno" ><i class="fa fa-trash"></i></button>';
				$salida.= '</td>';
			}else if($acc == 7){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-success" onclick = "Habilita_Alumno(\''.$cui.'\')" title = "Habilitar Alumno" ><i class="fa fa-check"></i></button>';
				$salida.= '</td>';
			}
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
	}
	
	return $salida;
}


function tabla_padres($alumno){
	$ClsAsig = new ClsAsignacion();
	$result = $ClsAsig->get_alumno_padre('',$alumno);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-padres">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "150px">Nombres</td>';
		$salida.= '<th class = "text-center" width = "100px">Parentesco</td>';
		$salida.= '<th class = "text-center" width = "100px">E-mail</td>';
		$salida.= '<th class = "text-center" width = "100px">Tel&eacute;fono</td>';
		$salida.= '<th class = "text-center" width = "50px"><span class="fa fa-cogs"></span></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//grado
			$nombre = utf8_decode($row["pad_nombre"])." ".utf8_decode($row["pad_apellido"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//fecha
			$parentesco = $row["pad_parentesco"];
			switch($parentesco){
				case "P": $parentesco = "Padre"; break;
				case "M": $parentesco = "Madre"; break;
				case "A": $parentesco = "Abuelo(a)"; break;
				case "O": $parentesco = "Encargado"; break;
			}
			$salida.= '<td class = "text-center">'.$parentesco.'</td>';
			//mail
			$mail = trim($row["pad_mail"]);
			$salida.= '<td class = "text-center">'.$mail.'</td>';
			//usuario
			$telefono = trim($row["pad_celular"]);
			$salida.= '<td class = "text-center">'.$telefono.'</td>';
			//--
			$dpi = $row["pad_cui"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsAsig->encrypt($dpi, $usu);
			$salida.= '<td class = "text-center">';
			$salida.= '<a href="../CPPADRES/FRMmodpadre.php?hashkey='.$hashkey.'" title="Actualizar Datos del Padre, Madre o Encargado" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a> ';
			$salida.= '<button type="button" onclick="Desligar_Padre(\''.$alumno.'\',\''.$dpi.'\');" title="Desligar Padre, Madre o Encargado" class="btn btn-danger btn-xs"><i class="fa fa-unlink"></i></button> ';
			$salida.= '<a href="../CPPADRES/FRMficha.php?hashkey='.$hashkey.'" title="Visualizar Ficha del Padre, Madre o Encargado" class="btn btn-success btn-xs"><i class="fa fa-search"></i></a>';
			$salida.= '</td>';
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


function tabla_hermanos($alumno){
	$ClsAsig = new ClsAsignacion();
	$result = $ClsAsig->get_alumno_padre('',$alumno);
	if(is_array($result)){
		$padres = '';
		foreach($result as $row){
			$padres.= $row["pad_cui"].",";
		}
		$padres = substr($padres,0,-1);
	}else{
		$padres = 'X';
	}
	
	$result = $ClsAsig->get_hermanos($alumno, $padres);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-hermanos">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "150px">Nombres</td>';
		$salida.= '<th class = "text-center" width = "100px">Fecha Nac.</td>';
		$salida.= '<th class = "text-center" width = "30px">Edad</td>';
		$salida.= '<th class = "text-center" width = "100px">Grado / Secci&oacute;n</td>';
		$salida.= '<th class = "text-center" width = "30px">Situaci&oacute;</td>';
		$salida.= '<th class = "text-center" width = "50px"><span class="fa fa-cogs"></span></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//grado
			$nombre = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//fecha
			$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
			$salida.= '<td class = "text-center">'.$fecnac.'</td>';
			//edad
			$edad = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
			$salida.= '<td class = "text-center">'.$edad.'</td>';
			//grado
			$grado = utf8_decode($row["alu_grado"])." ".utf8_decode($row["alu_seccion"]);
			$salida.= '<td class = "text-left">'.$grado.'</td>';
			//situacion
			$sit = trim($row["alu_situacion"]);
			$situacion = ($sit == 1)?'<span class="text-success">Activo</span>':'<span class="text-danger">Inactivo</span>';
			$salida.= '<td class = "text-center">'.$situacion.'</td>';
			//--
			$cui = $row["alu_cui"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsAsig->encrypt($cui, $usu);
			$salida.= '<td class = "text-center">';
			$salida.= '<a href="FRMmodalumno.php?hashkey='.$hashkey.'" title="Actualizar Datos del Hermano(a)" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a> ';
			$salida.= '<a href="FRMficha.php?hashkey='.$hashkey.'" title="Visualizar Ficha del Hermano(a)" class="btn btn-success btn-xs"><i class="fa fa-search"></i></a>';
			$salida.= '</td>';
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


function tabla_psicopedagogica($alumno){
	$ClsAcadem = new ClsAcademico();
	$result =  $ClsAcadem->get_comentario_psicopedagogico('',$alumno, '', '', '','',1);
	
	if(is_array($result)){
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
			$coment = nl2br($coment);
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
	}
	
	return $salida;
}


?>
