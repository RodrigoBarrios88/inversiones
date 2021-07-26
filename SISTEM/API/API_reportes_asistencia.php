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
			API_lista_hijos($tipo_usuario,$tipo_codigo);
			break;
		case "usuarios_secciones":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_secciones($tipo_usuario,$tipo_codigo);
			break;
		case "lista_maestros":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			API_lista_maestros($nivel,$grado,$seccion);
			break;
		case "asistencias_seccion":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			$fecha = $_REQUEST["fecha"];
			API_asistencias_seccion($nivel,$grado,$seccion,$fecha);
			break;
		case "asistencias_maestro":
			$cui = $_REQUEST["cui"];
			$fecha = $_REQUEST["fecha"];
			API_asistencia_maestro($cui,$fecha);
			break;
		case "detalle_asistencia":
			$horario = $_REQUEST["codigo"];
			$fecha = $_REQUEST["fecha"];
			API_detalle_asistencia($horario,$fecha);
			break;
		case "lista_alumnos":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			API_lista_alumnos($nivel,$grado,$seccion);
			break;
		case "detalle_alumno":
			$cui = $_REQUEST["cui"];
			$fecha = $_REQUEST["fecha"];
			API_detalle_alumno($cui,$fecha);
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
					///------------------
					$result_grado_alumno = $ClsAcad->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);  ////// este array se coloca en la columna de combos
					if(is_array($result_grado_alumno)){
						$j = 0;
						foreach($result_grado_alumno as $row_grado_alumno){
							$arr_grados[$j]['pensum'] = $row_grado_alumno["seca_pensum"];
							$arr_grados[$j]['nivel'] = $row_grado_alumno["seca_nivel"];
							$arr_grados[$j]['grado'] = $row_grado_alumno["seca_grado"];
							$arr_grados[$j]['seccion'] = $row_grado_alumno["seca_seccion"];
							$j++;
						}
						$arr_data[$i]['seccion'] = $arr_grados;
					}
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
			"message" => "El codigo de usuario esta vacio");
			echo json_encode($arr_data);
	}
	
}


function API_lista_secciones($tipo_usuario,$tipo_codigo){
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "2"){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAcadem->get_seccion_maestro($pensum,'','','',$tipo_codigo,'','',1);
			if (is_array($result)) {
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['nivel'] = trim($row["niv_codigo"]);
					$arr_data[$i]['grado'] = trim($row["gra_codigo"]);
					$arr_data[$i]['seccion'] = trim($row["sec_codigo"]);
					$arr_data[$i]['grado_descripcion'] = trim($row["gra_descripcion"]);
					$arr_data[$i]['seccion_descripcion'] = trim($row["sec_descripcion"]);
					///------------------
					$i++;
				}
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "vacio",
					"message" => "No exsisten secciones enlazados a este maestro...");
					echo json_encode($arr_data);
			}
		}else if($tipo_usuario === "1"){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAcadem->get_grado_otros_usuarios($pensum,'','',$tipo_codigo);
			if(is_array($result)){
				$nivel = "";
				$grado = "";
				foreach($result as $row){
					$nivel.= $row["gra_nivel"].",";
					$grado.= $row["gra_codigo"].",";
				}
				$nivel = substr($nivel, 0, -1);
				$grado = substr($grado, 0, -1);
				$result = $ClsPen->get_seccion_IN($pensum,$nivel,$grado,'','',1);
				if (is_array($result)) {
					$i = 0;
					foreach($result as $row){
						$arr_data[$i]['nivel'] = trim($row["niv_codigo"]);
						$arr_data[$i]['grado'] = trim($row["gra_codigo"]);
						$arr_data[$i]['seccion'] = trim($row["sec_codigo"]);
						$arr_data[$i]['grado_descripcion'] = trim($row["gra_descripcion"]);
						$arr_data[$i]['seccion_descripcion'] = trim($row["sec_descripcion"]);
						$i++;
					}
					echo json_encode($arr_data);
				}
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "vacio",
					"message" => "No exsisten secciones enlazados a esta autoridad...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario no pertenece al grupo de maestros o autoridades...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo de usuario esta vacio");
			echo json_encode($arr_data);
	}
	
}


function API_lista_maestros($nivel,$grado,$seccion){
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != ""){
		$result = $ClsAcadem->get_seccion_maestro($pensum,$nivel,$grado,$seccion,'','','',1);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['cui'] = $row["mae_cui"];
				$arr_data[$i]['nombre'] = trim($row["mae_nombre"])." ".trim($row["mae_apellido"]);
				$arr_data[$i]['titulo'] = trim($row["mae_titulo"]);
				$arr_data[$i]['mail'] = trim($row["mae_mail"]);
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



function API_asistencias_seccion($nivel,$grado,$seccion,$fecha){
	$ClsAsist = new ClsAsistencia();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	//--
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $fecha != ""){
		$result = $ClsAsist->get_horario_asistencia_seccion('',$fecha,$pensum,$nivel,$grado,$seccion);
		if(is_array($result)){
			$i = 0;
			foreach($result as $row){
				//codigo
				$codigo = $row["asi_horario"];
				//duracion
				$min = $row["tip_minutos"]." minutos";
				//horarios
				$ini = trim($row["per_hini"]);
				$ini = substr($ini,0,-3);
				$fin = trim($row["per_hfin"]);
				$fin = substr($fin,0,-3);
				//grado y seccion
				$grado = trim($row["gra_descripcion"]);
				$seccion = trim($row["sec_descripcion"]);
				//materia
				$materia = trim($row["mat_descripcion"]);
				//aula
				$aula = trim($row["aul_descripcion"]);
				//--
				$arr_data[$i]['codigo'] = $codigo;
				$arr_data[$i]['fecha'] = $fecha;
				$arr_data[$i]['duracion'] = $min;
				$arr_data[$i]['horario'] = trim($ini)." ".trim($fin);
				$arr_data[$i]['seccion'] = trim($grado)." ".trim($seccion);
				$arr_data[$i]['materia'] = trim($materia);
				$arr_data[$i]['aula'] = trim($aula);
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




function API_asistencia_maestro($maestro,$fecha){
	$ClsAsist = new ClsAsistencia();
	//--
	if($maestro != "" && $fecha != ""){
		$result = $ClsAsist->get_horario_asistencia_maestro('',$fecha,'',$maestro);
		if(is_array($result)){
			$i = 0;
			foreach($result as $row){
				//codigo
				$codigo = $row["hor_codigo"];
				//duracion
				$min = $row["tip_minutos"]." minutos";
				//horarios
				$ini = $row["per_hini"];
				$fin = $row["per_hfin"];
				//grado y seccion
				$grado = trim($row["gra_descripcion"]);
				$seccion = trim($row["sec_descripcion"]);
				//materia
				$materia = trim($row["mat_descripcion"]);
				//aula
				$aula = trim($row["aul_descripcion"]);
				//--
				$arr_data[$i]['codigo'] = $codigo;
				$arr_data[$i]['fecha'] = $fecha;
				$arr_data[$i]['duracion'] = $min;
				$arr_data[$i]['horario'] = trim($ini)." ".trim($fin);
				$arr_data[$i]['seccion'] = trim($grado)." ".trim($seccion);
				$arr_data[$i]['materia'] = trim($materia);
				$arr_data[$i]['aula'] = trim($aula);
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





function API_detalle_asistencia($horario,$fecha){
	$ClsAsist = new ClsAsistencia();
	//--
	if($horario != "" && $fecha != ""){
		$result = $ClsAsist->get_asistencia($horario,$fecha);
		if(is_array($result)){
			$i = 0;
			foreach($result as $row){
				//codigo
				$cui = $row["alu_cui"];
				//duracion
				$nombre = trim($row["alu_nombre"]);
				$apellido = trim($row["alu_apellido"]);
				//grado y seccion
				$sit = $row["asi_asistencia"];
				$status = ($sit == 1)?true:false;
				$asistencia = ($sit == 1)?"Presente":"Ausente";
				$clase = ($sit == 1)?"success":"danger";
				//--
				$arr_data[$i]['cui'] = $cui;
				$arr_data[$i]['nombre'] = $nombre." ".$apellido;
				$arr_data[$i]['asistencia'] = $asistencia;
				$arr_data[$i]['clase'] = $clase;
				$arr_data[$i]['situacion'] = $status;
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




function API_lista_alumnos($nivel,$grado,$seccion){
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != ""){
		$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
		if(is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['cui'] = $row["alu_cui"];
				$arr_data[$i]['nombre'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
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




function API_detalle_alumno($cui,$fecha){
	$ClsAsist = new ClsAsistencia();
	//--
	//2019-12-19T10:37:12.989-06:00
	if($cui != "" && $fecha != ""){
		$arr_data = array();
		///--- AUSENCIAS --///
		$mes = substr($fecha,5,2);
		$result = $ClsAsist->get_ausencia_alumno('','',$cui,$mes);
		if(is_array($result)){
			$i = 0;
			foreach($result as $row){
				//fecha
				$fec = $row["asi_fecha"];
				$dia = $dia = date('N', strtotime($fec));
				switch($dia){
					case 1: $dia_desc = "Lunes"; break;
					case 2: $dia_desc = "Martes"; break;
					case 3: $dia_desc = "Miércoles"; break;
					case 4: $dia_desc = "Jueves"; break;
					case 5: $dia_desc = "Viernes"; break;
					case 6: $dia_desc = "Sábado"; break;
					case 7: $dia_desc = "Domingo"; break;
				}
				$fecha_asistencia = cambia_fecha($fec);
				//horarios
				$ini = $row["per_hini"];
				$fin = $row["per_hfin"];
				//materia
				$materia = trim($row["mat_descripcion"]);
				//aula
				$aula = trim($row["aul_descripcion"]);
				//--
				$arr_ausencia[$i]['fecha'] = $dia_desc.' '.$fecha_asistencia;
				$arr_ausencia[$i]['horario'] = trim($ini)." ".trim($fin);
				$arr_ausencia[$i]['materia'] = trim($materia);
				$arr_ausencia[$i]['aula'] = trim($aula);
				//--
				$i++;
			}
		}else{
			$arr_ausencia[0]['fecha'] = '';
			$arr_ausencia[0]['horario'] = '';
			$arr_ausencia[0]['materia'] = '';
			$arr_ausencia[0]['aula'] = '';
		}
		///--- ASISTENCIAS --///
		$fecha = substr($fecha,0,10);
		$fecha = cambia_fecha($fecha);
		$result = $ClsAsist->get_horario_asistencia_alumno('',$fecha,$cui);
		if(is_array($result)){
			$i = 0;
			foreach($result as $row){
				//duracion
				$min = $row["tip_minutos"]." minutos";
				//horarios
				$ini = $row["per_hini"];
				$fin = $row["per_hfin"];
				//materia
				$materia = trim($row["mat_descripcion"]);
				//aula
				$aula = trim($row["aul_descripcion"]);
				//--
				$arr_asistencia[$i]['duracion'] = $min;
				$arr_asistencia[$i]['horario'] = trim($ini)." ".trim($fin);
				$arr_asistencia[$i]['materia'] = trim($materia);
				$arr_asistencia[$i]['aula'] = trim($aula);
				//--
				$i++;
			}
		}else{
			$arr_asistencia[0]['duracion'] = '';
			$arr_asistencia[0]['horario'] = '';
			$arr_asistencia[0]['materia'] = '';
			$arr_asistencia[0]['aula'] = '';
		}
		
		//devuelve un mensaje de manejo de errores
		$arr_data[0]['ausencias'] = $arr_ausencia;
		$arr_data[0]['asistencias'] = $arr_asistencia;
		echo json_encode($arr_data);
		
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}