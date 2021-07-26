<?php 
include_once('../html_fns.php');

// No utiliza este tipo de funciones....
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
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "checkbox" id = "hijo'.$i.'" name = "hijo'.$i.'" value = "'.$cui.'" checked />';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-left">';
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
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
            $salida.= '<input type = "hidden" id = "filas" name = "filas" value = "'.$i.'" />';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_hijos_mod($padre){
	$ClsAsig = new ClsAsignacion();
	$result = $ClsAsig->get_alumno_padre($padre,'');
	if(is_array($result)){
		$salida.= '<div class="panel-body users-list">';
		$salida.= '<div class="row-fluid table">';
		$salida.= '<table class="table table-hover">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "150px">Nombres</td>';
		$salida.= '<th class = "text-center" width = "100px">Fecha Cumplea&ntilde;os</td>';
		$salida.= '<th class = "text-center" width = "100px">Edad</td>';
		$salida.= '<th class = "text-center" width = "150px">Grado / Secci&oacute;n</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//grado
			$nombre = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//fecha
			$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
			$salida.= '<td class = "text-center">'.$fecnac.'</td>';
			//fecha
			$anios = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
			$salida.= '<td class = "text-center">'.$anios.' a&ntilde;os</td>';
			//mail
			$grado = utf8_decode($row["alu_grado"])." ".utf8_decode($row["alu_seccion"]);
			$salida.= '<td class = "text-left">'.$grado.'</td>';
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


function tabla_familia($padre){
	$ClsAsig = new ClsAsignacion();
	$result = $ClsAsig->get_alumno_padre($padre,'');
	if(is_array($result)){
		$alumnos = '';
		foreach($result as $row){
			$alumnos.= $row["alu_cui"].",";
		}
		$alumnos = substr($alumnos,0,-1);
	}else{
		$alumnos = 'X';
	}
	
	$result = $ClsAsig->get_familia($padre, $alumnos);
	if(is_array($result)){
		$salida.= '<div class="panel-body users-list">';
		$salida.= '<div class="row-fluid table">';
		$salida.= '<table class="table table-hover">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "150px">Nombres</td>';
		$salida.= '<th class = "text-center" width = "100px">Fecha Cumplea&ntilde;os</td>';
		$salida.= '<th class = "text-center" width = "100px">Parentesco</td>';
		$salida.= '<th class = "text-center" width = "100px">E-mail</td>';
		$salida.= '<th class = "text-center" width = "100px">Tel&eacute;fono</td>';
		$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
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
			$fecnac = cambia_fecha($row["pad_fec_nac"]);
			$salida.= '<td class = "text-center">'.$fecnac.'</td>';
			//parentesco
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
			$salida.= '<a href="FRMmodfamilia.php?hashkey='.$hashkey.'" title="Actualizar Datos del Padre/Madre o Encargado" class="btn btn-default"><i class="fas fa-pencil-alt"></i></a> ';
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


function tabla_telefonos($user_id){
	$ClsPush = new ClsPushup();
	$result = $ClsPush->get_push_user($user_id);
	
	if(is_array($result)){
		$Thoras = 0;
			$salida.= '<div class="panel-body users-list">';
            $salida.= '<div class="row-fluid table">';
			$salida.= '<table class="table table-hover">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "20px" class = "text-center"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th width = "120px" class = "text-center">ID Dispositivo</th>';
			$salida.= '<th width = "100px" class = "text-center">Tipo</th>';
			$salida.= '<th width = "100px" class = "text-center">Primer Ingreso</th>';
			$salida.= '<th width = "100px" class = "text-center">&Uacute;ltimo Ingreso</th>';
			$salida.= '<th width = "100px" class = "text-center">status</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$user_id = trim($row["user_id"]);
			$device_id = trim($row["device_id"]);
			$status = trim($row["status"]);
			$salida.= '<td class = "text-center">';
			if($status == 0){
				$salida.= '<button type="button" class="btn btn-success btn-outline" onclick="Reactivar(\''.$user_id.'\',\''.$device_id.'\');" title = "Re-Activar Acesso al este Dispositivo" ><i class="fa fa-check"></i> Re-Activar</button>';
			}else{
				$salida.= '<button type="button" class="btn btn-danger" onclick="Bloquear(\''.$user_id.'\',\''.$device_id.'\');" title = "Bloquear Acesso al este Dispositivo"><i class="fa fa-ban"></i> Bloquear</button>';
			}
			$salida.= '</td>';	
			//--
			$device_id = trim($row["device_id"]);
			$salida.= '<td class = "text-center">'.$device_id.'</td>';
			//
			$device_type = utf8_decode($row["device_type"]);
			$salida.= '<td class = "text-center">'.$device_type.'</td>';
			//
			$created_at = cambia_fechaHora($row["created_at"]);
			$salida.= '<td class = "text-center">'.$created_at.'</td>';
			//
			$updated_at = cambia_fechaHora($row["updated_at"]);
			$salida.= '<td class = "text-center">'.$updated_at.'</td>';
			//--
			$status = utf8_decode($row["status"]);
			$status_desc = ($status == 0)?'<strong class="text-danger">Bloqueado</strong>':'<strong class="text-success">Activo</strong>';
			$salida.= '<td class = "text-center">'.$status_desc.'</td>';
			//
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
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
				'name' => $nombre,
				'type' => 'to'
			)
	);
	/////////////_________ Correo a admin
	$ClsOtro = new ClsOtrosUsu();
	$hashkey = $ClsOtro->encrypt($id, "clave");
	$absolute_url = full_url( $_SERVER );
	$absolute_url = str_replace("/CPPERFIL/FRMnew-user.php","",$absolute_url);
	//$absolute_url = str_replace("/CPOTROUSU/prueba.php","",$absolute_url);
	$subject = "Bienvenido a ASMS";
	$cuerpo = "Han generado un nuevo usuario para ti.\n\n"."Aqui estan los detalles:\n\nHaz clcik en el link para activar tu usuario\n\n ";
	$cuerpo.= $absolute_url.'/CPVALIDA/FRMactivate.php?hashkey='.$hashkey.' Click para Activar el Usuario';
	$cuerpo.= "\n\nQue pases un feliz dia!!!";
	try{
	
		$message = array(
			'subject' => $subject,
			'text' => $cuerpo,
			'from_email' => 'noreply@inversionesd.com',
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