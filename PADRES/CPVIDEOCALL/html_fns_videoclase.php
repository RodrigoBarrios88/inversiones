<?php
include_once('../html_fns.php');
//Push Notifications
include_once('../../CONFIG/push/push_android.php');
include_once('../../CONFIG/push/push_ios.php');
include_once('../../CONFIG/videoclases/kaltura.php');

//////////////////---- HISTORIALES -----/////////////////////////////////////////////
function historial_videoclase($desde,$hasta,$nombre_grupo){
	$ClsVid = new ClsVideoclase();
	$administrador = 1;
	$credenciales = $ClsVid->get_credentials($administrador);
	$partnerId = $credenciales["partner"];
	$secret = $credenciales["secret"];

	$response = kaltura_list_liveStream($partnerId, '', $secret, $nombre_grupo);
	$result = (array) $response["data"]["objects"];
	//print_r($result);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-kaltura">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "150px">Videoclase</td>';
		$salida.= '<th class = "text-center" width = "100px">Fecha Inicio</td>';
		$salida.= '<th class = "text-center" width = "50px">Duraci&oacute;n</td>';
		$salida.= '<th class = "text-center" width = "60px"><i class="fa fa-cogs"></i></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$string_base = $row->name;
			$trozos = explode("-", $string_base);
			//---
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//nombre
			$nombre = trim($trozos[2]);
			$nombre = utf8_decode($nombre);
			$nombre = str_replace(".mp4", "", $nombre);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//fecha inicia
			$fini = $trozos[1];
			$salida.= '<td class = "text-center">'.$fini.'</td>';
			//duracion
			$duracion = $row->duration;
			$duracion = gmdate("H:i:s", $duracion);
			$duracion = str_replace("00:", "", $duracion);
			$salida.= '<td class = "text-center">'.$duracion.'</td>';
			////--------------
			$link = $row->dataUrl;
			$linkDownload = $row->downloadUrl;
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<a class="btn btn-default" target="_blank" href = "'.$linkDownload.'" title = "Ver carpetas y archivos enlazados" ><i class="fa fa-cloud-download"></i></a>';
					$salida.= '<a class="btn btn-primary" target="_blank" href = "FRMrecorder.php?url='.$link.'" title = "Ver clase" ><i class="fa fa-angle-double-right"></i></a>';
				$salida.= '</div>';
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




function historial_videoclase_otros($codigosVideo){
	$ClsVid = new ClsVideoclase();
    	$result = $ClsVid->get_videoclase($codigosVideo);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-otra">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "150px">Videoclase</td>';
		$salida.= '<th class = "text-center" width = "100px">Plataforma</td>';
		$salida.= '<th class = "text-center" width = "100px">Inici&oacute;</td>';
		$salida.= '<th class = "text-center" width = "100px">Finaliz&oacute;</td>';
		$salida.= '<th class = "text-center" width = "60px"><i class="fa fa-cogs"></i></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$plataforma = trim($row["vid_plataforma"]);
			if($plataforma != "ASMS Videoclass"){
				$salida.= '<tr>';
				//codigo
				$salida.= '<td class = "text-center" >'.$i.'.</td>';
				//nombre
				$nombre = trim(utf8_decode($row["vid_nombre"]));
				$salida.= '<td class = "text-left">'.$nombre.'</td>';
				//plataforma
				$plataforma = trim(utf8_decode($row["vid_plataforma"]));
				$salida.= '<td class = "text-left">'.$plataforma.'</td>';
				//fecha inicia
				$fini = trim($row["vid_fecha_inicio"]);
				$fini = cambia_fechaHora($fini);
				$salida.= '<td class = "text-center">'.$fini.'</td>';
				//fecha finaliza
				$ffin = trim($row["vid_fecha_fin"]);
				$ffin = cambia_fechaHora($ffin);
				$salida.= '<td class = "text-center">'.$ffin.'</td>';
				////--------------
				$codigo = $row["vid_codigo"];
				$plataforma = trim($row["vid_plataforma"]);
				$link = trim($row["vid_link"]);
				if($plataforma == "ASMS Videoclass"){
					$enlace = "FRMviewer.php?codigo=$codigo";
				}else{
					$enlace = $link;
				}
				$salida.= '<td class = "text-center" >';
					$salida.= '<div class="btn-group">';
						$salida.= '<a class="btn btn-primary" target="_blank" href = "'.$enlace.'" title = "Ver clase" ><i class="fa fa-angle-double-right"></i></a>';
					$salida.= '</div>';
				$salida.= '</td>';
				//--
				$salida.= '</tr>';
				$i++;
			}
		}
		$i--;
		$salida.= '</table>';
		$salida.= '</div>';
	}

	return $salida;
}



/////////////////////////////// CONFIRMACIONES DE LECTURA ///////////////////////////////////////////////

function tabla_info_confirmacion(){
	$ClsVid = new ClsVideoclase();
	$result = $ClsVid->get_videoclase($codigo,$target,$tipo);
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cog"></span></th>';
		$salida.= '<th class = "text-center" width = "150px">T&Iacute;TULO</th>';
		$salida.= '<th class = "text-center" width = "200px">DESCRIPCI&Oacute;N O OBSERVACIONES</th>';
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
			$titulo = trim(utf8_decode($row["vid_nombre"]));
			$salida.= '<td class = "text-left">'.$titulo.'</td>';
			//desc
			$desc = trim(utf8_decode($row["vid_descripcion"]));
			$desc = (strlen($desc) > 128)?substr($desc,0,120)."...":$desc;
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//fecha inicia
			$publicacion = trim($row["vid_fecha_registro"]);
			$publicacion = cambia_fechaHora($publicacion);
			$salida.= '<td class = "text-center">'.$publicacion.'</td>';
			//--
			$codigo = $row["vid_codigo"];
            	$usu = $_SESSION["codigo"];
			$hashkey = $ClsVid->encrypt($codigo, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-success btn-xs" href="FRMleidos.php?hashkey='.$hashkey.'" title = "Listado de Usuarios y su lectura" ><i class="fa fa-group"></i> <i class="fa fa-eye"></i></a> ';
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
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "40px">CUI</td>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "100px">Grado y Secci&oacute;n</td>';
		$salida.= '<th class = "text-center" width = "150px">USUARIO</td>';
		$salida.= '<th class = "text-center" width = "50px">STUATUS</td>';
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
			$salida.= '<a href="FRMVideoclases.php?hashkey='.$hashkey.'">';
			$salida.= '<img src="../../CONFIG/Fotos/'.$foto.'" class="img-circle avatar hidden-phone" width = "50px" />';
			$salida.= '</a>';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-left">';
			$salida.= '<a href="FRMVideoclases.php?hashkey='.$hashkey.'" class="name">'.$nombre.'</a>';
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
			$salida.= '<a class="btn-glow primary" href="FRMvideoclases.php?hashkey='.$hashkey.'" ><i class="icon icon-arrow-right"></i></a>';
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
