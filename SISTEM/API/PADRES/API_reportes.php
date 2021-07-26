<?php
ob_start();
header("Cache-control: private, no-cache");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Pragma: no-cache");
header("Cache: no-cahce");
ini_set('max_execution_time', 90000);
ini_set("memory_limit", -1);
//--
include_once('html_fns_api.php');

header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");

///API REQUEST
$request = $_REQUEST["request"];

if($request != ""){
	switch($request){
		case "hijos":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_hijos($tipo_usuario,$tipo_codigo,$reporte);
			break;
		case "panial":
			$alumno = $_REQUEST["alumno"]; /// (CUI DEL ALUMNO AL QUE VA DIRIGIDO)
			API_panial($alumno);
			break;
		case "detalle_panial":
			$codigo = $_REQUEST["codigo"];
			API_detalle_panial($codigo);
			break;
		case "golpe":
			$alumno = $_REQUEST["alumno"]; /// (CUI DEL ALUMNO AL QUE VA DIRIGIDO)
			API_golpe($alumno);
			break;
		case "detalle_golpe":
			$codigo = $_REQUEST["codigo"];
			API_detalle_golpe($codigo);
			break;
		case "enfermedad":
			$alumno = $_REQUEST["alumno"]; /// (CUI DEL ALUMNO AL QUE VA DIRIGIDO)
			API_enfermedad($alumno);
			break;
		case "detalle_enfermedad":
			$codigo = $_REQUEST["codigo"];
			API_detalle_enfermedad($codigo);
			break;
		case "conducta":
			$alumno = $_REQUEST["alumno"]; /// (CUI DEL ALUMNO AL QUE VA DIRIGIDO)
			API_conducta($alumno);
			break;
		case "detalle_conducta":
			$codigo = $_REQUEST["codigo"];
			API_detalle_conducta($codigo);
			break;
        default:
			$arr_data = array(
			"status" => "error",
			"message" => "Parametros invalidos...");
			echo json_encode($arr_data);
			break;
	}
}else{
	//devuelve un mensaje de manejo de errores
	$arr_data = array(
		"status" => "error",
		"message" => "Delimite el tipo de consulta a realizar...");
		echo json_encode($arr_data);
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////// FUNCIONES Y CONSULTAS ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function API_lista_hijos($tipo_usuario,$tipo_codigo){
	$ClsAsi = new ClsAsignacion();
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsPush = new ClsPushup();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "3"){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAsi->get_alumno_padre($tipo_codigo,"");
			if (is_array($result)) {
				$i = 0;
				foreach($result as $row){
					$cui = $row["alu_cui"];
					$arr_data[$i]['cui'] = $row["alu_cui"];
					$arr_data[$i]['tipo_cui'] = $row["alu_tipo_cui"];
					$arr_data[$i]['nombre'] = trim($row["alu_nombre"]);
					$arr_data[$i]['apellido'] = trim($row["alu_apellido"]);
					$arr_data[$i]['fecha_nacimiento'] = cambia_fecha($row["alu_fecha_nacimiento"]);
					$arr_data[$i]['edad'] = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
					$arr_data[$i]['genero'] = $row["alu_genero"];
					//--
					$foto = $row["alu_foto"];
					if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
					}else{
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
					}
					///------------------
					$tareas = $ClsPush->count_pendientes_leer_type($tipo_codigo,2,$cui);
					$encuestas = $ClsPush->count_pendientes_leer_type($tipo_codigo,4,$cui);
					$panial = $ClsPush->count_pendientes_leer_type($tipo_codigo,7,$cui);
					$golpe = $ClsPush->count_pendientes_leer_type($tipo_codigo,8,$cui);
					$enfermendad = $ClsPush->count_pendientes_leer_type($tipo_codigo,9,$cui);
					$conducta = $ClsPush->count_pendientes_leer_type($tipo_codigo,10,$cui);
					$reportes = ($panial+$golpe+$enfermendad+$conducta);
					//validaciones
					$tareas = (!intval($tareas))?0:intval($tareas);
					$encuestas = (!intval($encuestas))?0:intval($encuestas);
					$panial = (!intval($panial))?0:intval($panial);
					$golpe = (!intval($golpe))?0:intval($golpe);
					$enfermendad = (!intval($enfermendad))?0:intval($enfermendad);
					$conducta = (!intval($conducta))?0:intval($conducta);
					$reportes = (!intval($reportes))?0:intval($reportes);
					//---
					$j=0;
					$arr_badges = array();
					$arr_badges[$j]['reportes'] = $reportes;
					$arr_badges[$j]['clasereportes'] = ($reportes > 0)?"visible":"novisible";
					$arr_badges[$j]['tipo2'] = $tareas;
					$arr_badges[$j]['clase2'] = ($tareas > 0)?"visible":"novisible";
					$arr_badges[$j]['tipo4'] = $encuestas;
					$arr_badges[$j]['clase4'] = ($encuestas > 0)?"visible":"novisible";
					$arr_badges[$j]['tipo7'] = $panial;
					$arr_badges[$j]['clase7'] = ($panial > 0)?"visible":"novisible";
					$arr_badges[$j]['tipo8'] = $golpe;
					$arr_badges[$j]['clase8'] = ($golpe > 0)?"visible":"novisible";
					$arr_badges[$j]['tipo9'] = $enfermendad;
					$arr_badges[$j]['clase9'] = ($enfermendad > 0)?"visible":"novisible";
					$arr_badges[$j]['tipo10'] = $conducta;
					$arr_badges[$j]['clase10'] = ($conducta > 0)?"visible":"novisible";
					//--
					$arr_data[$i]['notificaciones'] = $arr_badges;
					///------------------
					$i++;
				}
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No exsisten hijos enlazados a este papa...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario no pertenece al grupo de padres...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}



function API_panial($alumno){
	$ClsPan = new ClsPanial();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($alumno != ""){
		$i = 0;
		$result = $ClsPan->get_panial('',$pensum,'','','',$alumno);
		if(is_array($result)){
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["pan_codigo"];
				$grado = trim($row["pan_grado_desc"]);
				$seccion = trim($row["pan_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$arr_data[$i]['cui'] = trim($row["pan_alumno"]);
				$arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$arr_data[$i]['genero'] = trim($row["alu_genero"]);
				$arr_data[$i]['titulo'] = 'Reporte de Pañal';
				//--
				$alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$pipi = trim($row["pan_cant_pipi"]);
				$popo = trim($row["pan_cant_popo"]);
				$tipo = trim($row["pan_tipo"]);
				$obs = trim($row["pan_observaciones"]);
				$obs = ($obs == "")?"Ninguna":$obs;
				//--
				$arr_data[$i]['pipi'] = $pipi;
				$arr_data[$i]['popo'] = $popo;
				$arr_data[$i]['consistencia'] = $tipo;
				$arr_data[$i]['observaciones'] = $obs;
				$fecha = $row["pan_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
				//--
				$foto = $row["alu_foto"];
				if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
				}
				//--
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}


function API_detalle_panial($codigo){
	$ClsPan = new ClsPanial();
	
	if($codigo != ""){
		$result = $ClsPan->get_panial($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["pan_codigo"];
				$grado = trim($row["pan_grado_desc"]);
				$seccion = trim($row["pan_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$arr_data[$i]['cui'] = trim($row["pan_alumno"]);
				$arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$arr_data[$i]['genero'] = trim($row["alu_genero"]);
				$arr_data[$i]['titulo'] = 'Reporte de Pañal';
				//--
				$alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$pipi = trim($row["pan_cant_pipi"]);
				$popo = trim($row["pan_cant_popo"]);
				$tipo = trim($row["pan_tipo"]);
				$obs = trim($row["pan_observaciones"]);
				$obs = ($obs == "")?"Ninguna":$obs;
				//--
				$arr_data[$i]['pipi'] = $pipi;
				$arr_data[$i]['popo'] = $popo;
				$arr_data[$i]['consistencia'] = $tipo;
				$arr_data[$i]['observaciones'] = $obs;
				$fecha = $row["pan_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
				//--
				$foto = $row["alu_foto"];
				if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
				}
				//--
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
}


function API_golpe($alumno){
	$ClsGol = new ClsGolpe();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($alumno != ""){
		$i = 0;
		$result = $ClsGol->get_golpe('',$pensum,'','','',$alumno);
		if(is_array($result)){
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["gol_codigo"];
				$grado = trim($row["gol_grado_desc"]);
				$seccion = trim($row["gol_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$arr_data[$i]['cui'] = trim($row["gol_alumno"]);
				$arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$arr_data[$i]['genero'] = trim($row["alu_genero"]);
				$arr_data[$i]['titulo'] = 'Reporte de Golpe';
				//--
				$alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$lugar = trim($row["gol_lugar"]);
				$hora = trim($row["gol_hora"]);
				$desc = trim($row["gol_descripcion"]);
				$accion = trim($row["gol_medida"]);
				$dosis = trim($row["gol_dosis"]);
                //--		
				$arr_data[$i]['lugar'] = trim($row["gol_lugar"]);
				$arr_data[$i]['hora'] = trim($row["gol_hora"]);
				$arr_data[$i]['descripcion'] = trim($row["gol_descripcion"]);
				$arr_data[$i]['accion'] = trim($row["gol_medida"]);
				$arr_data[$i]['dosis'] = trim($row["gol_dosis"]);
				//
				$fecha = $row["gol_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
				//--
				$foto = $row["alu_foto"];
				if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
				}
				//--
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}


function API_detalle_golpe($codigo){
	$ClsGol = new ClsGolpe();
	
	if($codigo != ""){
		$result = $ClsGol->get_golpe($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["gol_codigo"];
				$grado = trim($row["gol_grado_desc"]);
				$seccion = trim($row["gol_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$arr_data[$i]['cui'] = trim($row["gol_alumno"]);
				$arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$arr_data[$i]['genero'] = trim($row["alu_genero"]);
				$arr_data[$i]['titulo'] = 'Reporte de Golpe';
				//--
				$alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$lugar = trim($row["gol_lugar"]);
				$hora = trim($row["gol_hora"]);
				$desc = trim($row["gol_descripcion"]);
				$accion = trim($row["gol_medida"]);
				$dosis = trim($row["gol_dosis"]);
                //--		
				$arr_data[$i]['lugar'] = trim($row["gol_lugar"]);
				$arr_data[$i]['hora'] = trim($row["gol_hora"]);
				$arr_data[$i]['descripcion'] = trim($row["gol_descripcion"]);
				$arr_data[$i]['accion'] = trim($row["gol_medida"]);
				$arr_data[$i]['dosis'] = trim($row["gol_dosis"]);
				//
				$fecha = $row["gol_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
				//--
				$foto = $row["alu_foto"];
				if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
				}
				//--
                $i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
}


function API_enfermedad($alumno){
	$ClsEnf = new ClsEnfermedad();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($alumno != ""){
		$i = 0;
		$result = $ClsEnf->get_enfermedad('',$pensum,'','','',$alumno);
		if(is_array($result)){
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["enf_codigo"];
				$grado = trim($row["enf_grado_desc"]);
				$seccion = trim($row["enf_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$arr_data[$i]['cui'] = trim($row["enf_alumno"]);
				$arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$arr_data[$i]['genero'] = trim($row["alu_genero"]);
				$arr_data[$i]['titulo'] = 'Reporte de Enfermedad';
				//--
				$alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$sintomas = trim($row["enf_sintomas"]);
				$hora = trim($row["enf_hora"]);
				$aviso = trim($row["enf_aviso"]);
				$accion = trim($row["enf_medida"]);
				$dosis = trim($row["enf_dosis"]);
				//--		
				$arr_data[$i]['sintomas'] = trim($row["enf_sintomas"]);
				$arr_data[$i]['hora'] = trim($row["enf_hora"]);
				$arr_data[$i]['se_aviso_a'] = trim($row["enf_aviso"]);
				$arr_data[$i]['accion'] = trim($row["enf_medida"]);
				$arr_data[$i]['dosis'] = trim($row["enf_dosis"]);
				//
				$fecha = $row["enf_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
				//--
				$foto = $row["alu_foto"];
				if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
				}
				//--
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}


function API_detalle_enfermedad($codigo){
	$ClsEnf = new ClsEnfermedad();
	
	if($codigo != ""){
		$result = $ClsEnf->get_enfermedad($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["enf_codigo"];
				$grado = trim($row["enf_grado_desc"]);
				$seccion = trim($row["enf_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$arr_data[$i]['cui'] = trim($row["enf_alumno"]);
				$arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$arr_data[$i]['genero'] = trim($row["alu_genero"]);
				$arr_data[$i]['titulo'] = 'Reporte de Enfermedad';
				//--
				$alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$sintomas = trim($row["enf_sintomas"]);
				$hora = trim($row["enf_hora"]);
				$aviso = trim($row["enf_aviso"]);
				$accion = trim($row["enf_medida"]);
				$dosis = trim($row["enf_dosis"]);
				//--		
				$arr_data[$i]['sintomas'] = trim($row["enf_sintomas"]);
				$arr_data[$i]['hora'] = trim($row["enf_hora"]);
				$arr_data[$i]['se_aviso_a'] = trim($row["enf_aviso"]);
				$arr_data[$i]['accion'] = trim($row["enf_medida"]);
				$arr_data[$i]['dosis'] = trim($row["enf_dosis"]);
				//
				$fecha = $row["enf_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
				//--
				$foto = $row["alu_foto"];
				if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
				}
				//--
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
}


function API_conducta($alumno){
	$ClsCon = new ClsConducta();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($alumno != ""){
		$i = 0;
		$result = $ClsCon->get_conducta('',$pensum,'','','',$alumno);
		if(is_array($result)){
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["con_codigo"];
				$grado = trim($row["con_grado_desc"]);
				$seccion = trim($row["con_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$arr_data[$i]['cui'] = trim($row["con_alumno"]);
				$arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$arr_data[$i]['genero'] = trim($row["alu_genero"]);
				$arr_data[$i]['titulo'] = 'Reporte de Conducta';
				//--
				$alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$calificacion = trim($row["con_calificacion"]);
				switch($calificacion){
					 case 1: $cond_text = "Muy Bien"; break;
					 case 2: $cond_text = "Bien"; break;
					 case 3: $cond_text = "Regular"; break;
					 case 4: $cond_text = "Debo Mejorar"; break;
				}
				$obs = trim($row["con_observaciones"]);
				//--
				$arr_data[$i]['calificacion'] = trim($row["con_calificacion"]);
				$arr_data[$i]['calificacion_descripcion'] = $cond_text;
				$arr_data[$i]['observaciones'] = trim($row["con_observaciones"]);
				//
				$fecha = $row["con_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
				//--
				$foto = $row["alu_foto"];
				if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
				}
				//--
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}


function API_detalle_conducta($codigo){
	$ClsCon = new ClsConducta();
	
	if($codigo != ""){
		$result = $ClsCon->get_conducta($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["con_codigo"];
				$grado = trim($row["con_grado_desc"]);
				$seccion = trim($row["con_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$arr_data[$i]['cui'] = trim($row["con_alumno"]);
				$arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$arr_data[$i]['genero'] = trim($row["alu_genero"]);
				$arr_data[$i]['titulo'] = 'Reporte de Conducta';
				//--
				$alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$calificacion = trim($row["con_calificacion"]);
				switch($calificacion){
					 case 1: $cond_text = "Muy Bien"; break;
					 case 2: $cond_text = "Bien"; break;
					 case 3: $cond_text = "Regular"; break;
					 case 4: $cond_text = "Debo Mejorar"; break;
				}
				$obs = trim($row["con_observaciones"]);
				//--		
				$arr_data[$i]['calificacion'] = trim($row["con_calificacion"]);
				$arr_data[$i]['calificacion_descripcion'] = $cond_text;
				$arr_data[$i]['observaciones'] = trim($row["con_observaciones"]);
				//
				$fecha = $row["con_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
				//--
				$foto = $row["alu_foto"];
				if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
				}
				//--
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
}

?>