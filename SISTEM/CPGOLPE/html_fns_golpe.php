<?php
include_once('../html_fns.php');
//Push Notifications
include_once('../../CONFIG/push/push_android.php');
include_once('../../CONFIG/push/push_ios.php');

function tabla_direcotrio_alumnos($pensum = ''){
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAlu = new ClsAlumno();
	
	if($pensum == ""){
		$pensum = $ClsPen->get_pensum_activo();
	}
	
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	if($tipo_usuario === "1"){ /// SI el Usuario es Director
		$result = $ClsAcad->get_otros_usuarios_alumnos($pensum,'','',$tipo_codigo);
	}else if($tipo_usuario === "2"){ /// SI el Usuario es Maestro
		$result = $ClsAcad->get_maestro_alumnos($pensum,'','','',$tipo_codigo);
	}else{ // Si el Usuario es Administrador
		$result = $ClsAcad->get_seccion_alumno($pensum,'','','','');
	}	
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "170px">Alumno</td>';
		$salida.= '<th class = "text-center" width = "100px">Nivel</td>';
		$salida.= '<th class = "text-center" width = "100px">Grado</td>';
		$salida.= '<th class = "text-center" width = "30px"></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//nombre
			$nombres = utf8_decode($row["alu_nombre"]).' '.utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//nivel
			$nivel = utf8_decode($row["niv_descripcion"]);
			$salida.= '<td class = "text-left">'.$nivel.'</td>';
			//grado
			$grado = utf8_decode($row["gra_descripcion"])." ".utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-left">'.$grado.'</td>';
			//codigo
			$cui = $row["alu_cui"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsAlu->encrypt($cui, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-primary btn-block" href="FRMgestor.php?hashkey='.$hashkey.'" title = "Selecionar Alumno Alumno" ><i class="fa fa-chevron-right"></i></a> ';
			$salida.= '</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
		$i--;
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}

function tabla_reportes($alumno){
	$ClsGol = new ClsGolpe();
	$result = $ClsGol->get_golpe('','','','','',$alumno,'','',1);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "40px"><span class="fa fa-cog"></span></td>';
		$salida.= '<th class = "text-center" width = "10px">No.</td>';
		$salida.= '<th class = "text-center" width = "150px">Alumno</th>';
		$salida.= '<th class = "text-center" width = "40px">Lugar</th>';
		$salida.= '<th class = "text-center" width = "40px">Hora</th>';
		$salida.= '<th class = "text-center" width = "150px">Descripci&oacute;n</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$codigo = $row["gol_codigo"];
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group" data-toggle="buttons">';
					$salida.= '<button type="button" class="btn btn-default" onclick="abrir();xajax_Buscar_Golpe('.$codigo.');" title = "Seleccionar Reporte" ><i class="fa fa-edit"></i></button>';
					$salida.= '<button type="button" class="btn btn-danger" onclick="Confirm_Elimina_Golpe('.$codigo.');" title = "Deshabilitar Reporte" ><i class="fa fa-trash"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$alumno.'</td>';
			//lugar
			$lugar = trim(utf8_decode($row["gol_lugar"]));
			$salida.= '<td class = "text-center">'.$lugar.'</td>';
			//hora
			$hora = trim(utf8_decode($row["gol_hora"]));
			$salida.= '<td class = "text-center">'.$hora.'</td>';
			//desc
			$desc = trim(utf8_decode($row["gol_descripcion"]));
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
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

function tabla_reportes_confirmacion($cod,$pensum,$nivel,$grado,$seccion,$desde,$fecha,$sit){
	$ClsGol = new ClsGolpe();
	$result = $ClsGol->get_golpe($cod,$pensum,$nivel,$grado,$seccion,$desde,$fecha,$sit);
	
	if(is_array($result)){
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "30px"><span class="fa fa-cog"></span></th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "50px">LUGAR</th>';
		$salida.= '<th class = "text-center" width = "50px">HORA</th>';
		$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</th>';
		$salida.= '<th class = "text-center" width = "50px">FECHA PUBLICACI&Oacute;N</td>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$alumno.'</td>';
			//lugar
			$lugar = trim(utf8_decode($row["gol_lugar"]));
			$salida.= '<td class = "text-center">'.$lugar.'</td>';
			//hora
			$hora = trim(utf8_decode($row["gol_hora"]));
			$salida.= '<td class = "text-center">'.$hora.'</td>';
			//desc
			$desc = trim(utf8_decode($row["gol_descripcion"]));
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//fecha inicia
			$publicacion = trim($row["gol_fecha_registro"]);
			$publicacion = cambia_fechaHora($publicacion);
			$salida.= '<td class = "text-center">'.$publicacion.'</td>';
			//--
			$cod = $row["gol_codigo"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsGol->encrypt($cod, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-success" href="FRMleidos.php?hashkey='.$hashkey.'" title = "Listado de Usuarios y su lectura" ><i class="fa fa-group"></i> <i class="fa fa-eye"></i></a> ';
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
		$salida.= '<div class="dataTable_wrapper">';
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
