<?php 
include_once('../html_fns.php');
//Push Notifications
include_once('../../CONFIG/push/push_android.php');
include_once('../../CONFIG/push/push_ios.php');

//////////////////---- Otros Alumnos -----/////////////////////////////////////////////
function tabla_encuestas($cod,$target,$tipo_target,$destinatarios){
	$ClsEnc = new ClsEncuesta();
    $result = $ClsEnc->get_encuesta($cod,$target,$tipo_target,$destinatarios);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "150px"><i class="fa fa-cog"></i></th>';
		$salida.= '<th class = "text-center" width = "150px">Encuesta</td>';
		$salida.= '<th class = "text-center" width = "100px">Fecha L&iacute;mite</td>';
		$salida.= '<th class = "text-center" width = "100px">Tipo de destinatarios</td>';
		$salida.= '<th width = "20px"><i class="fa fa-cog"></i></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["enc_codigo"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsEnc->encrypt($codigo, $usu);
			$situacion = $row["enc_situacion"];
			if($situacion == 1){
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group" data-toggle="buttons">';
					$salida.= '<button type="button" class="btn btn-default" onclick = "abrir();xajax_Buscar_Encuesta('.$codigo.')" title = "Editar Encuesta" > <span class="fa fa-edit"></span> </button>';
					$salida.= '<button type="button" class="btn btn-default" onclick="window.location=\'FRMmodtarget.php?hashkey='.$hashkey.'\'" title = "Editar Participantes" > <i class="fa fa-group"></i> </button>';
					$salida.= '<button type="button" class="btn btn-danger" onclick = "ConfirmEliminar('.$codigo.');" title = "Eliminar Encuesta" > <span class="fa fa-trash-o"></span> </button>';
					$salida.= '<button type="button" class="btn btn-success" onclick = "ConfirmCerrar('.$codigo.');" title = "Cerrar Encuesta" > <span class="fa fa-lock"></span> </button>';
					$salida.= '<button type="button" class="btn btn-warning" onclick="window.location=\'FRMnotificar.php?hashkey='.$hashkey.'\'" title = "Revisar y Notificar Encuesta" > <i class="fa fa-bell"></i> </button>';
				$salida.= '</div>';
			$salida.= '</td>';
			}else{
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group" data-toggle="buttons">';
					$salida.= '<button type="button" class="btn btn-default" disabled > <span class="fa fa-edit"></span> </button>';
					$salida.= '<button type="button" class="btn btn-default" disabled > <span class="fa fa-group"></span> </button>';
					$salida.= '<button type="button" class="btn btn-danger" disabled > <span class="fa fa-trash-o"></span> </button>';
					$salida.= '<button type="button" class="btn btn-success" disabled > <span class="fa fa-lock"></span> </button>';
				$salida.= '</div>';
			$salida.= '</td>';
			}
			//nombre
			$titulo = trim(utf8_decode($row["enc_titulo"]));
			$salida.= '<td class = "text-left">'.$titulo.'</td>';
			//fecha inicia
			$feclimit = trim($row["enc_fecha_limite"]);
			$feclimit = cambia_fechaHora($feclimit);
			$salida.= '<td class = "text-center">'.$feclimit.'</td>';
			//fecha finaliza
			$dest = trim($row["enc_destinatarios"]);
			switch($dest){
				case 1: $destinatarios = "Directores o Autoridades"; break;
				case 2: $destinatarios = "Maestros"; break;
				case 3: $destinatarios = "Padres"; break;
				case 4: $destinatarios = "Monitores"; break;
				case 5: $destinatarios = "Alumno"; break;
			}
			$salida.= '<td class = "text-center">'.$destinatarios.'</td>';
			//--
			$codigo = $row["enc_codigo"];
			$situacion = $row["enc_situacion"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsEnc->encrypt($codigo, $usu);
			$salida.= '<td class = "text-center" >';
			if($situacion == 1){
				$salida.= '<a type="button" class="btn btn-primary btn-block" href="FRMpreguntas.php?hashkey='.$hashkey.'" target = "_blank" title = "Editar Preguntas" ><span class="fa fa-plus"></span> <span class="fa fa-question"></span></a>';
			}else{
				$salida.= '<a type="button" class="btn btn-primary btn-block" disabled ><span class="fa fa-plus"></span> <span class="fa fa-question"></span></a>';
			}
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






function tabla_preguntas($codigo,$encuesta){
	$ClsEnc = new ClsEncuesta();
    $result = $ClsEnc->get_pregunta($codigo,$encuesta);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "30px"><span class="fa fa-cog"></span></th>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "250px">PREGUNTA</td>';
		$salida.= '<th class = "text-center" width = "150px">TIPO DE RESPUESTA</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["pre_codigo"];
			$encuesta = $row["pre_encuesta"];
            $salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default" onclick = "abrir();xajax_Buscar_Pregunta('.$codigo.','.$encuesta.')" title = "Editar Pregunta" > <span class="fa fa-edit"></span> </button>';
			$salida.= '<button type="button" class="btn btn-danger" onclick = "Eliminar_Pregunta('.$codigo.','.$encuesta.');" title = "Eliminar Pregunta" > <span class="fa fa-trash-o"></span> </button> ';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//nombre
			$desc = trim(utf8_decode($row["pre_descripcion"]));
			$desc = nl2br($desc);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//tipo
			$tipo = trim($row["pre_tipo"]);
			switch($tipo){
				case 1: $tipo_pregunta = "PUNTUACI&Oacute;N (1-5)"; break;
				case 2: $tipo_pregunta = "VERDADERO Y FALSO"; break;
				case 3: $tipo_pregunta = "ABIERTA"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo_pregunta.'</td>';
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




function tabla_resultados_encuestas(){
	$ClsEnc = new ClsEncuesta();
    $result = $ClsEnc->get_encuesta($cod,$target,$tipo_target,$destinatarios);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "150px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "100px">FECHA LIMITE</td>';
		$salida.= '<th class = "text-center" width = "150px">TIPO DE DESTINATATIOS</td>';
		$salida.= '<th width = "20px"><span class="fa fa-cog"></span></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["enc_codigo"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsEnc->encrypt($cod, $usu);
			$sit = $row["enc_situacion"];
			//nombre
			$titulo = trim(utf8_decode($row["enc_titulo"]));
			$salida.= '<td class = "text-left">'.$titulo.'</td>';
			//fecha inicia
			$feclimit = trim($row["enc_fecha_limite"]);
			$feclimit = cambia_fechaHora($feclimit);
			$salida.= '<td class = "text-center">'.$feclimit.'</td>';
			//fecha finaliza
			$dest = trim($row["enc_destinatarios"]);
			switch($dest){
				case 1: $destinatarios = "DIRECTORES O AUTORIDADES"; break;
				case 2: $destinatarios = "MAESTROS"; break;
				case 3: $destinatarios = "PADRES"; break;
				case 4: $destinatarios = "MONITORES"; break;
				case 5: $destinatarios = "ALUMNOS"; break;
			}
			$salida.= '<td class = "text-center">'.$destinatarios.'</td>';
			//--
			$cod = $row["enc_codigo"];
			$sit = $row["enc_situacion"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsEnc->encrypt($cod, $usu);
			$btn = ($sit == 2)?"success":"default";
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-'.$btn.'" href="CPREPORTES/GRAPHresultados.php?hashkey='.$hashkey.'" target = "_blank" title = "Ver Resultados de la Encuesta" ><span class="fa fa-bar-chart-o"></span></a>';
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


/////////////////////////////// CONFIRMACIONES DE LECTURA ///////////////////////////////////////////////

function tabla_encuesta_confirmacion(){
	$ClsEnc = new ClsEncuesta();
    $result = $ClsEnc->get_encuesta($cod,$target,$tipo_target,$destinatarios);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cog"></span></th>';
		$salida.= '<th class = "text-center" width = "150px">T&Iacute;TULO</th>';
		$salida.= '<th class = "text-center" width = "200px">DESCRIPCI&Oacute;N U OBSERVACIONES</th>';
		$salida.= '<th class = "text-center" width = "50px">FECHA PUBLICACI&Oacute;N</td>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//nombre
			$titulo = trim(utf8_decode($row["enc_titulo"]));
			$salida.= '<td class = "text-left">'.$titulo.'</td>';
			//desc
			$desc = trim(utf8_decode($row["enc_descripcion"]));
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//fecha inicia
			$publicacion = trim($row["enc_fecha_registro"]);
			$publicacion = cambia_fechaHora($publicacion);
			$salida.= '<td class = "text-center">'.$publicacion.'</td>';
			//--
			$cod = $row["enc_codigo"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsEnc->encrypt($cod, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-success" href="FRMleidos.php?hashkey='.$hashkey.'" title = "Listado de Usuarios y su lectura" ><i class="fa fa-group"></i> <i class="fa fa-eye"></i></a> ';
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


function tabla_lectura($push_type,$type_id){
	$ClsPush = new ClsPushup();
	$result = $ClsPush->get_notification_status($push_type,$type_id);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "150px">ALUMNO</td>';
			$salida.= '<th class = "text-center" width = "100px">Grado y Secci&oacute;n</td>';
			$salida.= '<th class = "text-center" width = "150px">USUARIO</td>';
			$salida.= '<th class = "text-center" width = "50px">STATUS</td>';
			$salida.= '<th class = "text-center" width = "50px">FECHA/REGISTRO</td>';
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
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//grado
			$grado_desc = utf8_decode($row["alu_grado"]);
			$seccion_desc = utf8_decode($row["alu_seccion"]);
			$salida.= '<td class = "text-left">'.$grado_desc.' Secci&oacute;n '.$seccion_desc.'</td>';
			//padre o encargado
			$padnom = utf8_decode($row["pad_nombre"]);
			$padape = utf8_decode($row["pad_apellido"]);
			$salida.= '<td class = "text-left">'.$padnom.' '.$padape.'</td>';
			//ape
			$sit = trim($row["status"]);
			$status = ($sit == 1)?'<span class = "text-success"><i class="fa fa-check"></i> Leido</span>':'';
			$salida.= '<td class = "text-center">'.$status.'</td>';
			//fecha inicia
			$fecha = trim($row["updated_at"]);
			$fecha = cambia_fechaHora($fecha);
			$fecha = ($sit == 1)?$fecha:'';
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
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