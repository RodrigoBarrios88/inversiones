<?php 
include_once('../html_fns.php');
require_once("../recursos/mandrill/src/Mandrill.php"); //--correos
require_once("../../CONFIG/constructor.php");
//////////////////---- Otros OtroUsus -----/////////////////////////////////////////////
function tabla_otros_usuarios($cui,$nom,$ape,$sit,$acc){
	$ClsOtro = new ClsOtrosUsu();
	$sit = ($acc == 2)?1:"";
	$result = $ClsOtro->get_otros_usuarios($cui,$nom,$ape,1);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		if($acc == 1){
		$salida.= '<th class = "text-center" width = "50px"><i class="fa fa-cogs"></i></th>';
		//$salida.= '<th class = "text-center" width = "50px">CUI</td>';
		$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
		$salida.= '<th class = "text-center" width = "60px">FECHA NAC.</td>';
		$salida.= '<th class = "text-center" width = "150px">TEL&Eacute;FONO</td>';
		$salida.= '<th class = "text-center" width = "150px">MAIL</td>';
		$salida.= '<th class = "text-center" width = "30px"><i class="fa fa-cog"></i></td>';
		}else if($acc == 2){
		$salida.= '<th class = "text-center" class = "text-center" width = "30px"><i class="fa fa-cogs"></i></td>';
		//$salida.= '<th class = "text-center" width = "50px">CUI</td>';
		$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
		$salida.= '<th class = "text-center" width = "60px">FECHA NAC.</td>';
		$salida.= '<th class = "text-center" width = "150px">TEL&Eacute;FONO</td>';
		$salida.= '<th class = "text-center" width = "150px">MAIL</td>';
		}else{
		$salida.= '<th class = "text-center" width = "30px">No.</th>';
		//$salida.= '<th class = "text-center" width = "50px">CUI</td>';
		$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
		$salida.= '<th class = "text-center" width = "60px">FECHA NAC.</td>';
		$salida.= '<th class = "text-center" width = "150px">TEL&Eacute;FONO</td>';
		$salida.= '<th class = "text-center" width = "150px">MAIL</td>';
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
				$cui = $row["otro_cui"];
				$sit = $row["otro_situacion"];
				$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Buscar_OtroUsu(\''.$cui.'\');" title = "Editar Usuario Administrativo" ><span class="fa fa-pencil"></span></button> ';
				if($sit == 1){
				$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_OtroUsu(\''.$cui.'\');" title = "inhabilitar Usuario Administrativo" ><span class="fa fa-trash"></span></button> ';
				}else if($sit == 2){
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "Habilita_OtroUsu(\''.$cui.'\');" title = "Habilitar Usuario Administrativo" ><span class="fa fa-check"></span></button> ';
				}
			}else if($acc == 2){
				//codigo
				$cui = $row["otro_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsOtro->encrypt($cui, $usu);
				$salida.= '<a class="btn btn-primary btn-xs" href="FRMotrousuasig.php?hashkey='.$hashkey.'" title = "Seleccionar Usuario Administrativo" ><i class="fa fa-link"></i></a>';
			}else{
				$salida.= '<label>'.$i.'.</label>';
			}
			$salida.= '</td>';
			//CUI
			$cui = trim($row["otro_cui"]);
			//$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = utf8_decode($row["otro_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape = utf8_decode($row["otro_apellido"]);
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//fecha nacimiento
			$fecnac = $row["otro_fecha_nacimiento"];
			$fecnac = cambia_fecha($fecnac);
			$salida.= '<td class = "text-center">'.$fecnac.'</td>';
			//telefono1
			$tel = $row["otro_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
			//correo
			$mail = $row["otro_mail"];
			$salida.= '<td class = "text-center">'.$mail.'</td>';
			if($acc == 1){
			///re-send mail
			$cui = $row["otro_cui"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary btn-xs" onclick = "abrir();xajax_Send_Mail(\''.$cui.'\');" title = "Re-enviar Correo de Activaci&oacute;n" ><i class="fa fa-envelope-o"></i></button>';
			$salida.= '</td>';
			}else if($acc == 3){
			///re-send mail
			$cui = $row["otro_cui"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsOtro->encrypt($cui, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-info btn-xs" href="FRMficha.php?hashkey='.$hashkey.'" target = "_blank" title = "Ver Asignaciones del Usuario Autoridad" ><i class="fa fa-search"></i></a>';
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


function tabla_autoridades_asignacion_cursos($curso,$cui,$nom,$ape,$sit){
	$ClsOtro = new ClsOtrosUsu();
	$ClsCur = new ClsCursoLibre();
	$result = $ClsOtro->get_otros_usuarios($cui,$nom,$ape,1);
	
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
			$cui = $row["otro_cui"];
			//$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = trim(utf8_decode($row["otro_nombre"]));
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape =  trim(utf8_decode($row["otro_apellido"]));
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//correo
			$mail = $row["otro_mail"];
			$salida.= '<td class = "text-center">'.$mail.'</td>';
			//codigo
			$salida.= '<td class = "text-center" >';
			$cui = $row["otro_cui"];
			$valida = $ClsCur->get_curso_autoridad($curso,$cui);
			if(!is_array($valida)){
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsOtro->encrypt($cui, $usu);
				$salida.= '<button class="btn btn-primary btn-block btn-xs" onclick="Asignar_Curso_Autoridad(\''.$cui.'\',\''.$curso.'\');" title = "Asignar Director o Autoridad" ><i class="fa fa-link"></i> <i class="fa fa-book"></i></button>';
			}else{
				$salida.= '<small>Ya Asignado!</small> &nbsp; ';
				$salida.= '<button class="btn btn-danger btn-xs" onclick="Desasignar_Curso_Autoridad(\''.$cui.'\',\''.$curso.'\');" title = "Desasignar Director o Autoridad" ></i> <i class="fa fa-unlink"></i></button>';
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

function tabla_cursos($cui,$sede,$clase,$nom,$anio,$mes,$fini,$ffin){
	$ClsCur = new ClsCursoLibre();
	$result = $ClsCur->get_curso($cui,$sede,$clase,$nom,$anio,$mes,$fini,$ffin);
	
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
			$nombre = utf8_decode($row["cur_nombre"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//descripcion
			$desc = utf8_decode($row["cur_descripcion"]);
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//año
			$fini = cambia_fecha($row["cur_fecha_inicio"]);
			$ffin = cambia_fecha($row["cur_fecha_fin"]);
			$salida.= '<td class = "text-center">'.$fini.' - '.$ffin.'</td>';
			//--
			$salida.= '<td class = "text-center">';
			$cui = $row["cur_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsCur->encrypt($cui, $usu);
			$salida.= '<a class="btn btn-primary btn-xs btn-block" href="FRMlistotro_curso.php?hashkey='.$hashkey.'" title = "Seleccionar Curso" ><span class="fa fa-angle-double-right fa-2x"></span></a>';
			$salida.= '</td>';	
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}
	
	return $salida;
}


function tabla_usuario_grados($cui){
	$pensum = $_SESSION["pensum"];
	$ClsAcadem = new ClsAcademico();
	$result = $ClsAcadem->get_grado_otros_usuarios($pensum,'','',$cui);
	
	if(is_array($result)){
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-grados">';
		$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "200px" class = "text-center">GRADO</td>';
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
			$salida.= '<td class = "text-left">'.$niv_desc.', '.$gra_desc.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-info-circle"></i> No se registran grados asignados';
		$salida.= '</h5>';
	}
	
	return $salida;
}



function tabla_usuario_grupos($cui){
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_usuario_grupo("",$cui,1);
	
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



function tabla_usuario_cursos($cui){
	$ClsCur = new ClsCursoLibre();
	$result = $ClsCur->get_curso_autoridad("",$cui);
	
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
	$ClsOtro = new ClsOtrosUsu();
	$hashkey = $ClsOtro->encrypt($id, "clave");
	$absolute_url = full_url( $_SERVER );
	$absolute_url = str_replace("/CPOTROUSU/FRMnewotrousu.php","",$absolute_url);
	
	$subject = "Bienvenido a $colegio_nombre_titulo (Portal para Autoridades)";
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
