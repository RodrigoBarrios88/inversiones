<?php 
include_once('../html_fns.php');
require_once("../recursos/mandrill/src/Mandrill.php"); //--correos
require_once("../../CONFIG/constructor.php");

//////////////////---- Otros Padres -----/////////////////////////////////////////////
function tabla_padres($cui,$nom,$ape,$sit,$acc){
	$ClsPad = new ClsPadre();
	$result = $ClsPad->get_padre($cui,$nom,$ape,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			if($acc == 1){
			$salida.= '<th width = "30px" colspan = "2"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "100px">CUI</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "150px">TEL&Eacute;FONO</td>';
			$salida.= '<th class = "text-center" width = "150px">MAIL</td>';
			$salida.= '<th class = "text-center" width = "10px"><i class = "fa fa-cog"></i></td>';
			}else{
			$salida.= '<th width = "30px">No.</th>';
			$salida.= '<th class = "text-center" width = "100px">CUI</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "150px">TEL&Eacute;FONO</td>';
			$salida.= '<th class = "text-center" width = "150px">MAIL</td>';
			$salida.= '<th class = "text-center" width = "10px"><i class = "fa fa-cog"></i></td>';
			}
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			if($acc == 1){
			//codigo
			$cui = $row["pad_cui"];
			$sit = $row["pad_situacion"];
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Buscar_Padre(\''.$cui.'\');" title = "Editar Padre" ><span class="glyphicon glyphicon-pencil"></span></button>';
				$salida.= '</td>';
				if($sit == 1){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Padre(\''.$cui.'\')" title = "inhabilitar Padre" ><span class="glyphicon glyphicon-trash"></span></button>';
				$salida.= '</td>';
				}else if($sit == 2){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "Habilita_Padre(\''.$cui.'\')" title = "Habilitar Padre" ><span class="glyphicon glyphicon-ok"></span></button>';
				$salida.= '</td>';
				}
			}else{
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			}
			//CUI
			$cui = $row["pad_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = utf8_decode($row["pad_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape = utf8_decode($row["pad_apellido"]);
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//telefono1
			$tel = $row["pad_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
			//correo
			$mail = $row["pad_mail"];
			$salida.= '<td class = "text-left">'.$mail.'</td>';
			//ficha
			$cui = $row["pad_cui"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsPad->encrypt($cui, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-info btn-xs" target = "_blank" href="FRMficha.php?hashkey='.$hashkey.'" title = "Ver Ficha del Padre" ><i class="fa fa-search"></i></a>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		//$salida = "$cui,$nom,$ape,$sit,$acc";
	}
	
	return $salida;
}

function tabla_hijos($padre){
	$ClsAsig = new ClsAsignacion();
	$result = $ClsAsig->get_alumno_padre($padre,'');
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-psico">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "150px">Nombres</td>';
		$salida.= '<th class = "text-center" width = "150px">Grado / Secci&oacute;n</td>';
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
			//mail
			$grado = utf8_decode($row["alu_grado"])." ".utf8_decode($row["alu_seccion"]);
			$salida.= '<td class = "text-left">'.$grado.'</td>';
			//--
			$cui = $row["alu_cui"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsAsig->encrypt($cui, $usu);
			$salida.= '<td class = "text-center">';
			$salida.= '<a href="../CPALUMNOS/FRMmodalumno.php?hashkey='.$hashkey.'" title="Actualizar Datos del Alumno" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a> ';
			$salida.= '<a href="../CPALUMNOS/FRMficha.php?hashkey='.$hashkey.'" title="Visualizar Ficha del Alumno" class="btn btn-success btn-xs"><i class="fa fa-search"></i></a>';
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
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-psico">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "150px">Nombres</td>';
		$salida.= '<th class = "text-center" width = "100px">Fecha Cumplea&ntilde;os</td>';
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
			$salida.= '<a href="FRMmodpadre.php?hashkey='.$hashkey.'" title="Actualizar Datos del Padre/Madre o Encargado" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a> ';
			$salida.= '<a href="FRMficha.php?hashkey='.$hashkey.'" title="Visualizar Ficha del Padre/Madre o Encargado" class="btn btn-success btn-xs"><i class="fa fa-search"></i></a>';
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

////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

function mail_usuario($id,$dpi,$mail){
		
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
	$ClsPad = new ClsPadre();
	$hashkey = $ClsPad->encrypt($dpi, $_SESSION["codigo"]);
	$absolute_url = full_url( $_SERVER );
	$absolute_url = str_replace("/SISTEM/CPPADRES/FRMficha.php?hashkey=$hashkey","",$absolute_url);
	
	$hashkey = $ClsPad->encrypt($id, "clave");
	
	$subject = "Bienvenido a $colegio_nombre_titulo (App para Padres)";
	$texto = "Han generado un nuevo usuario para ti. Haz click en el link adjunto, para activar tu usuario.<br><br> ";
	$texto.= "<a href = '$absolute_url/PADRES/CPVALIDA/FRMactivate.php?hashkey=$hashkey' style = 'color: #337ab7; font-weight: bold; text-decoration: none;'> Click para Activar el Usuario </a>";
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