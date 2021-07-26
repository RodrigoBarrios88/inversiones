<?php
include_once('../html_fns.php');
//Push Notifications
include_once('../../CONFIG/push/push_android.php');
include_once('../../CONFIG/push/push_ios.php');

function tabla_postits($codigo,$pensum,$nivel,$grado,$seccion,$maestro,$desde,$fecha,$sit){
	$ClsPost = new ClsPostit();
	$result = $ClsPost->get_postit($codigo,$pensum,$nivel,$grado,$seccion,'',$maestro,'',$desde,$fecha,1);
	
	if(is_array($result)){
		$Thoras = 0;
		$salida= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
		$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" class = "text-center"><i class="fa fa-cogs"></i></td>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "100px" class = "text-center">Dirigido a</td>';
			$salida.= '<th width = "100px" class = "text-center">T&iacute;tulo</td>';
			$salida.= '<th width = "30px" class = "text-center"></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$codigo = $row["post_codigo"];
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group" data-toggle="buttons">';
					$salida.= '<button type="button" class="btn btn-default" onclick="abrir();xajax_Buscar_Postit('.$codigo.');" title = "Seleccionar Nota" ><i class="fa fa-edit"></i></button>';
					$salida.= '<button type="button" class="btn btn-danger" onclick="Confirm_Elimina_Postit('.$codigo.');" title = "Deshabilitar Nota" ><i class="fa fa-trash"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//target
			$target = trim($row["post_target"]);
			$target_nombre = trim(utf8_decode($row["post_target_nombre"]));
			$target = ($target != "")?$target_nombre:"TODOS";
			$salida.= '<td class = "text-left">'.$target.'</td>';
			//nombre
			$nombre = utf8_decode($row["post_titulo"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//botones
			$codigo = trim($row["post_codigo"]);
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group" data-toggle="buttons">';
					$salida.= '<button type="button" class="btn btn-default" onclick="verPostit('.$codigo.');" ><i class="fa fa-search"></i></button> ';
					$salida.= '<button type="button" class="btn btn-warning" onclick = "ConfirmRecordatorio('.$codigo.');" title = "Notificar Recordatorio" ><i class="fa fa-bell"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}



/////////////////////////////// CONFIRMACIONES DE LECTURA ///////////////////////////////////////////////

function tabla_postits_confirmacion($codigo,$pensum,$nivel,$grado,$seccion,$maestro,$desde,$fecha,$sit){
	$ClsPost = new ClsPostit();
	$result = $ClsPost->get_postit($codigo,$pensum,$nivel,$grado,$seccion,'',$maestro,'',$desde,$fecha,1);
	
	if(is_array($result)){
		$salida = '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cog"></span></th>';
		$salida.= '<th class = "text-center" width = "150px">Grado/Secci&oacute;n</th>';
		$salida.= '<th class = "text-center" width = "150px">T&iacute;tulo</th>';
		$salida.= '<th class = "text-center" width = "200px">Descripci&oacute;n</th>';
		$salida.= '<th class = "text-center" width = "50px">Fecha publicac&oacute;n</td>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1; 
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//grado / seccion
			$nivel_desc = trim(utf8_decode($row["post_nivel_desc"]));
			$grado_desc = trim(utf8_decode($row["post_grado_desc"]));
			$seccion_desc = trim(utf8_decode($row["post_seccion_desc"]));
			if($seccion_desc == "" && $grado_desc == "" && $nivel_desc == ""){
				$target = "Global";
			}else if($seccion_desc == "" && $grado_desc == "" && $nivel != ""){
				$target = $nivel_desc;
			}else if($seccion_desc == "" && $grado_desc != "" && $nivel_desc != ""){
				$target = $grado_desc;
			}else if($seccion_desc != "" && $grado_desc != ""){
				$target = $grado_desc." ".$seccion_desc;
			}
			$salida.= '<td class = "text-left">'.$target.'</td>';
			//nombre
			$titulo = trim(utf8_decode($row["post_titulo"]));
			$nombre_alumno = trim(utf8_decode($row["post_target_nombre"]));
			$salida.= '<td class = "text-left">'.$titulo.' / '.$nombre_alumno.'</td>';
			//desc
			$desc = trim(utf8_decode($row["post_descripcion"]));
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//fecha inicia
			$publicacion = trim($row["post_fecha_registro"]);
			$publicacion = cambia_fechaHora($publicacion);
			$salida.= '<td class = "text-center">'.$publicacion.'</td>';
			//--
			$cod = $row["post_codigo"];
            $usu = $_SESSION["codigo"]; 
			$hashkey = $ClsPost->encrypt($cod, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-success btn-xs" href="FRMleidos.php?hashkey='.$hashkey.'&nivel='.$nivel.'&grado='.$grado.'&seccion='.$seccion.'" title = "Listado de Usuarios y su lectura" ><i class="fa fa-group"></i> <i class="fa fa-eye"></i></a> ';
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


function tabla_lectura($push_type,$type_id,$nivel,$grado,$seccion){
	$ClsPush = new ClsPushup(); 
	$result = $ClsPush->get_notification_status($push_type,$type_id,$nivel,$grado,$seccion);
	if(is_array($result)){
		$salida = '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "40px">DPI/ID</td>';
			$salida.= '<th class = "text-center" width = "150px">PADRE/MADRE</td>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "150px">ALUMNO</td>';
			$salida.= '<th class = "text-center" width = "100px">Grado y Secci&oacute;n</td>';
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
			$dpi = utf8_decode($row["pa_padre"]);
			$salida.= '<td class = "text-center">'.$dpi.'</td>';
			//padre o encargado
			$padnom = utf8_decode($row["pad_nombre"]);
			$padape = utf8_decode($row["pad_apellido"]);
			$salida.= '<td class = "text-left">'.$padnom.' '.$padape.'</td>';
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
	}
	
	return $salida;
}



?>
