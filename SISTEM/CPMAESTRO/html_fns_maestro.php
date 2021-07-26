<?php 
include_once('../html_fns.php');
require_once("../recursos/mandrill/src/Mandrill.php"); //--correos
require_once("../../CONFIG/constructor.php");
//////////////////---- Otros Maestros -----/////////////////////////////////////////////
function tabla_maestros($cui,$nom,$ape,$sit,$acc){
	$ClsMae = new ClsMaestro();
	$result = $ClsMae->get_maestro($cui,$nom,$ape,1);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		if($acc == 1){
		$salida.= '<th class = "text-center" width = "50px"><i class="fa fa-cogs"></i></th>';
		//$salida.= '<th class = "text-center" width = "100px">CUI</td>';
		$salida.= '<th class = "text-center" width = "130px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "130px">APELLIDO</td>';
		$salida.= '<th class = "text-center" width = "60px">FECHA NAC.</td>';
		$salida.= '<th class = "text-center" width = "50px">TEL&Eacute;FONO</td>';
		$salida.= '<th class = "text-center" width = "100px">MAIL</td>';
		$salida.= '<th class = "text-center" width = "30px"><i class="fa fa-cog"></i></td>';
		}else if($acc == 2){
		$salida.= '<th class = "text-center" class = "text-center" width = "30px"><i class="fa fa-cogs"></i></td>';
		//$salida.= '<th class = "text-center" width = "100px">CUI</td>';
		$salida.= '<th class = "text-center" width = "130px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "130px">APELLIDO</td>';
		$salida.= '<th class = "text-center" width = "60px">FECHA NAC.</td>';
		$salida.= '<th class = "text-center" width = "50px">TEL&Eacute;FONO</td>';
		$salida.= '<th class = "text-center" width = "100px">MAIL</td>';
		}else{
		$salida.= '<th class = "text-center" width = "30px">No.</th>';
		//$salida.= '<th class = "text-center" width = "100px">CUI</td>';
		$salida.= '<th class = "text-center" width = "130px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "130px">APELLIDO</td>';
		$salida.= '<th class = "text-center" width = "60px">FECHA NAC.</td>';
		$salida.= '<th class = "text-center" width = "50px">TEL&Eacute;FONO</td>';
		$salida.= '<th class = "text-center" width = "100px">MAIL</td>';
		$salida.= '<th class = "text-center" width = "10px"><i class = "fa fa-cog"></i></td>';
		}
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >';
			if($acc == 1){
				//codigo
				$cui = $row["mae_cui"];
				$sit = $row["mae_situacion"];
				$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Buscar_Maestro(\''.$cui.'\');" title = "Editar Maestro" ><span class="glyphicon glyphicon-pencil"></span></button> ';
				if($sit == 1){
				$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Maestro(\''.$cui.'\');" title = "inhabilitar Maestro" ><span class="glyphicon glyphicon-trash"></span></button> ';
				}else if($sit == 2){
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "Habilita_Maestro(\''.$cui.'\');" title = "Habilitar Maestro" ><span class="glyphicon glyphicon-ok"></span></button> ';
				}
			}else if($acc == 2){
				//codigo
				$cui = $row["mae_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsMae->encrypt($cui, $usu);
				$salida.= '<a class="btn btn-primary btn-xs" href="FRMmaestroasig.php?hashkey='.$hashkey.'" title = "Seleccionar Maestro" ><span class="fa fa-link"></span></a>';
			}else{
				$salida.= '<label>'.$i.'.</label>';
			}
			$salida.= '</td>';
			//CUI
			$cui = $row["mae_cui"];
			//$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = utf8_decode($row["mae_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape = utf8_decode($row["mae_apellido"]);
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//fecha nacimiento
			$fecnac = $row["mae_fecha_nacimiento"];
			$fecnac = cambia_fecha($fecnac);
			$salida.= '<td class = "text-center">'.$fecnac.'</td>';
			//telefono1
			$tel = $row["mae_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
			//correo
			$mail = $row["mae_mail"];
			$salida.= '<td class = "text-left">'.$mail.'</td>';
			if($acc == 1){
			///re-send mail
			$cui = $row["mae_cui"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary btn-xs" onclick = "abrir();xajax_Send_Mail(\''.$cui.'\');" title = "Re-enviar Correo de Activaci&oacute;n" ><i class="fa fa-envelope-o"></i></button>';
			$salida.= '</td>';
			}else if($acc == 3){
			///re-send mail
			$cui = $row["mae_cui"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsMae->encrypt($cui, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-info btn-xs" href="FRMficha.php?hashkey='.$hashkey.'" target = "_blank" title = "Ver Asignaciones del Maestro" ><i class="fa fa-search"></i></a>';
			$salida.= '</td>';
			}
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



function tabla_maestros_asignacion($cui,$nom,$ape,$sit){
	$ClsMae = new ClsMaestro();
	$result = $ClsMae->get_maestro($cui,$nom,$ape,1);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "30px"><span class="glyphicon glyphicon-cog"></span></th>';
		//$salida.= '<th class = "text-center" width = "100px">CUI</td>';
		$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
		$salida.= '<th class = "text-center" width = "150px">TEL&Eacute;FONO</td>';
		$salida.= '<th class = "text-center" width = "150px">MAIL</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["mae_cui"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsMae->encrypt($cui, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-primary btn-xs" href="FRMmaestrodesasig.php?hashkey='.$hashkey.'" title = "Seleccionar Maestro" ><span class="fa fa-unlink"></span></a>';
			$salida.= '</td>';
			//CUI
			$cui = $row["mae_cui"];
			//$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = trim(utf8_decode($row["mae_nombre"]));
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape =  trim(utf8_decode($row["mae_apellido"]));
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//telefono1
			$tel = $row["mae_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
			//correo
			$mail = $row["mae_mail"];
			$salida.= '<td class = "text-left">'.$mail.'</td>';
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



function tabla_cursos($cod,$sede,$clase,$nom,$anio,$mes,$fini,$ffin){
	$ClsCur = new ClsCursoLibre();
	$result = $ClsCur->get_curso($cod,$sede,$clase,$nom,$anio,$mes,$fini,$ffin);
	
	if(is_array($result)){
		$Thoras = 0;
			$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "150px" class = "text-center">NOMBRE</td>';
			$salida.= '<th width = "250px" class = "text-center">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th width = "100px" class = "text-center">FECHAS</td>';
			$salida.= '<th width = "30px" class = "text-center"><i class="fa fa-cogs"></i></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//descripcion
			$desc = utf8_decode($row["cur_nombre"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//descripcion
			$desc = utf8_decode($row["cur_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//año
			$fini = cambia_fecha($row["cur_fecha_inicio"]);
			$ffin = cambia_fecha($row["cur_fecha_fin"]);
			$salida.= '<td class = "text-center">'.$fini.' - '.$ffin.'</td>';
			//--
			$salida.= '<td class = "text-center">';
			$codigo = $row["cur_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsCur->encrypt($codigo, $usu);
			$salida.= '<a class="btn btn-primary btn-xs btn-block" href="FRMlistmaestro_curso.php?hashkey='.$hashkey.'" title = "Seleccionar Curso" ><span class="fa fa-angle-double-right fa-2x"></span></a>';
			$salida.= '</td>';	
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}
	
	return $salida;
}


function tabla_maestros_asignacion_cursos($curso,$cui,$nom,$ape,$sit){
	$ClsMae = new ClsMaestro();
	$ClsCur = new ClsCursoLibre();
	$result = $ClsMae->get_maestro($cui,$nom,$ape,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			//$salida.= '<th class = "text-center" width = "60px">CUI</td>';
			$salida.= '<th class = "text-center" width = "120px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "120px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "100px">MAIL</td>';
			$salida.= '<th class = "text-center" width = "50px"><span class="fa fa-cog"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//CUI
			$cui = $row["mae_cui"];
			//$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = trim(utf8_decode($row["mae_nombre"]));
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape =  trim(utf8_decode($row["mae_apellido"]));
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//correo
			$mail = $row["mae_mail"];
			$salida.= '<td class = "text-center">'.$mail.'</td>';
			//codigo
			$salida.= '<td class = "text-center" >';
			$cui = $row["mae_cui"];
			$valida = $ClsCur->get_curso_maestro($curso,$cui);
			if(!is_array($valida)){
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsMae->encrypt($cui, $usu);
				$salida.= '<button class="btn btn-primary btn-block btn-xs" onclick="Asignar_Curso_Maestro(\''.$cui.'\',\''.$curso.'\');" title = "Asignar Maestro" ><i class="fa fa-link"></i> <i class="fa fa-book"></i></button>';
			}else{
				$salida.= '<small>Ya Asignado!</small> &nbsp; ';
				$salida.= '<button class="btn btn-danger btn-xs" onclick="Desasignar_Curso_Maestro(\''.$cui.'\',\''.$curso.'\');" title = "Desasignar Maestro" ></i> <i class="fa fa-unlink"></i></button>';
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


function tabla_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,$materia,$maestro){
	$ClsAcadem = new ClsAcademico();
	$result = $ClsAcadem->get_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,$materia,$maestro);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px">No.</td>';
			$salida.= '<th class = "text-center" width = "100px">NIVEL</td>';
			$salida.= '<th class = "text-center" width = "200px">GRADO</td>';
			$salida.= '<th class = "text-center" width = "170px">MATERIA</td>';
			$salida.= '<th class = "text-center" width = "110px">SECCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "30px"><span class="fa fa-cogs"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//CUI
			$niv = utf8_decode($row["niv_descripcion"]);
			$salida.= '<td class = "text-left">'.$niv.'</td>';
			//nombre
			$gra = utf8_decode($row["gra_descripcion"]);
			$salida.= '<td class = "text-left">'.$gra.'</td>';
			//ape
			$mat = utf8_decode($row["materia_descripcion"]);
			$salida.= '<td class = "text-left">'.$mat.'</td>';
			//telefono1
			$sec = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$sec.'</td>';
			//Quitar
			$pensum = $row["secmat_pensum"];
			$nivel = $row["secmat_nivel"];
			$grado = $row["secmat_grado"];
			$seccion = $row["secmat_seccion"];
			$materia = $row["secmat_materia"];
			$maestro = $row["secmat_maestro"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Desasignar_Materia_Seccion_Maestro('.$pensum.','.$nivel.','.$grado.','.$seccion.','.$materia.',\''.$maestro.'\');" title = "Desasignar Maestro" ><span class="fa fa-times"></span></button>';
			$salida.= '</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		$salida.= '<h5 class="alert alert-info text-center">';
		$salida.= '<i class="fa fa-ban"></i> No hay Secciones o Materias asignadas a este Maestro....';
		$salida.= '</h5>';
	}
	
	return $salida;
}


function tabla_maestro_secciones($cui){
	$pensum = $_SESSION["pensum"];
	$ClsAcadem = new ClsAcademico();
	$result = $ClsAcadem->get_seccion_maestro($pensum,'','','',$cui);
	
	if(is_array($result)){
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-grados">';
		$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "200px" class = "text-center">SECCI&Oacute;N</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//grado
			$niv_desc = utf8_decode($row["niv_descripcion"]);
			$gra_desc = utf8_decode($row["gra_descripcion"]);
			$sec_desc = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-left">'.$niv_desc.', '.$gra_desc.', '.$sec_desc.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-info-circle"></i> No se registran secciones asignadas';
		$salida.= '</h5>';
	}
	
	return $salida;
}


function tabla_maestro_materias($cui){
	$pensum = $_SESSION["pensum"];
	$ClsAcadem = new ClsAcademico();
	$result = $ClsAcadem->get_materia_maestro($pensum,'','','',$cui);
	
	if(is_array($result)){
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-grados">';
		$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "200px" class = "text-center">SECCI&Oacute;N</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//grado
			$niv_desc = utf8_decode($row["niv_descripcion"]);
			$gra_desc = utf8_decode($row["gra_descripcion"]);
			$materia_desc = utf8_decode($row["mat_descripcion"]);
			$salida.= '<td class = "text-left">'.$materia_desc.' ('.$niv_desc.', '.$gra_desc.')</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-info-circle"></i> No se registran materias asignadas';
		$salida.= '</h5>';
	}
	
	return $salida;
}



function tabla_maestro_grupos($cui){
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_maestro_grupo("",$cui,1);
	
	if(is_array($result)){
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-grupos">';
		$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "200px" class = "text-center">GRUPO</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//grado
			$grupo_desc = utf8_decode($row["gru_nombre"]);
			$salida.= '<td class = "text-left">'.$grupo_desc.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-info-circle"></i> No se registran grupos asignados';
		$salida.= '</h5>';
	}
	
	return $salida;
}



function tabla_maestro_cursos($cui){
	$ClsCur = new ClsCursoLibre();
	$result = $ClsCur->get_curso_maestro("",$cui);
	
	if(is_array($result)){
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-cursos">';
		$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "200px" class = "text-center">CURSO</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//grado
			$sede_desc = utf8_decode($row["sed_nombre"]);
			$curso_desc = utf8_decode($row["cur_nombre"]);
			$salida.= '<td class = "text-left">'.$curso_desc.' (SEDE: '.$sede_desc.')</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-info-circle"></i> No se registran cursos libres asignados';
		$salida.= '</h5>';
	}
	
	return $salida;
}


////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

function mail_usuario($id,$nombre,$mail){
		
	// Instancia el API KEY de Mandrill
	$mandrill = new Mandrill('kwBB4mXd5D3Jf1Ki3y1KYA');
	//--
	// Create the email and send the message
	$to = array(
		array(
			'email' => $mail,
			'name' => 'Nuevo Usuario',
			'type' => 'to'
		)
	);
	//////////////////////// CREDENCIALES DE COLEGIO
	$ClsReg = new ClsRegla();
	$result = $ClsReg->get_credenciales();
	if(is_array($result)){
	   foreach($result as $row){
			$colegio_nombre = utf8_decode($row['colegio_nombre']);
			$colegio_nombre_titulo = utf8_decode($row['cliente_nombre_reporte']);
	   }
	}
	$nombre = depurador_texto($nombre);
	$colegio_nombre = depurador_texto($colegio_nombre);
	$colegio_nombre_titulo = depurador_texto($colegio_nombre_titulo);
	/////////////_________ Correo a admin
	$ClsMae = new ClsMaestro();
	$hashkey = $ClsMae->encrypt($id, "clave");
	$absolute_url = full_url( $_SERVER );
	$absolute_url = str_replace("/CPMAESTRO/FRMnewmaestro.php","",$absolute_url);
	
	$subject = "Bienvenido a $colegio_nombre_titulo (Portal para Maestros)";
	$texto = "Han generado un nuevo usuario para ti. Haz click en el link adjunto, para activar tu usuario.<br><br> ";
	$texto.= "<a href = '$absolute_url/CPVALIDA/FRMactivate.php?hashkey=$hashkey' style = 'color: #337ab7; font-weight: bold; text-decoration: none;'> Click para Activar el Usuario </a>";
	$texto.= "<br><br>Que pases un feliz dia!!!";
	
	$html = mail_constructor($subject,$texto); 
	
	try{
	
		$message = array(
			'subject' => $subject,
			'html' => $html,
			'from_email' => 'noreply@inversionesd.com',
			'from_name' => 'ASMS',
			'to' => $to
		 );
		 
		 //print_r($message);
		 //echo "<br>";
		 $result = $mandrill->messages->send($message);
		 $validacion =  1;
	} catch(Mandrill_Error $e) { 
		//echo "<br>";
		//print_r($e);
		//devuelve un mensaje de manejo de errores
		$validacion =  0;
	}         
		
	return $validacion;
}

?>