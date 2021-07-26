<?php
ob_start();
header("Cache-control: private, no-cache");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Pragma: no-cache");
header("Cache: no-cahce");
ini_set('max_execution_time', 90000);
ini_set("memory_limit", -1);
ini_set("post_max_size", 0);
//--
include_once('html_fns_api.php');

header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");

///API REQUEST
$request = $_REQUEST["request"];

if($request != ""){
	switch($request){
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
		case "periodos_maestro":
			$cui = $_REQUEST["cui"];
			$dia = $_REQUEST["dia"];
			API_periodos_maestro($cui,$dia);
			break;
		case "fechas_dia":
			$dia = $_REQUEST["dia"];
			$hoy = $_REQUEST["hoy"];
			API_fechas_por_dia($dia,$hoy);
			break;
		case "lista_alumnos":
			$horario = $_REQUEST["codigo"];
			$fecha = $_REQUEST["fecha"];
			API_lista_alumnos($horario,$fecha);
			break;
		case "asistencia":
			$horario = $_REQUEST["codigo"];
			$fecha = $_REQUEST["fecha"];
			$data = $_REQUEST["data"];
			API_asistencia($horario,$fecha,$data);
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



function API_periodos_maestro($maestro,$dia=''){
	$ClsAsist = new ClsAsistencia();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	$dia = date("N");
	$fecha = date("d/m/Y");
	//--
	if($maestro != "" && $dia != "" && $fecha){
		$ClsHor = new ClsHorario();
		$result = $ClsHor->get_horario('','',$dia,'','','',$pensum,'','','','',$maestro,'');
		if(is_array($result)){
			$i = 0;
			foreach($result as $row){
				//codigo
				$codigo = $row["hor_codigo"];
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
				//-tomo asistencia
				$asistencia = $ClsAsist->count_asistencia($codigo,$fecha);
				$asistencia = ($asistencia > 0)?1:0;
				//--
				$arr_data[$i]['codigo'] = $codigo;
				$arr_data[$i]['duracion'] = $min;
				$arr_data[$i]['horario'] = trim($ini)." ".trim($fin);
				$arr_data[$i]['seccion'] = trim($grado)." ".trim($seccion);
				$arr_data[$i]['materia'] = trim($materia);
				$arr_data[$i]['aula'] = trim($aula);
				$arr_data[$i]['asistencia'] = $asistencia;
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




function API_fechas_por_dia($dia,$hoy){
	
	if($dia != ""){
		// seleccional el nombre del día segun el numero de dia
		switch($dia){
			case 1: $dia_desc = "LUNES"; break;
			case 2: $dia_desc = "MARTES"; break;
			case 3: $dia_desc = "MIERCOLES"; break;
			case 4: $dia_desc = "JUEVES"; break;
			case 5: $dia_desc = "VIERNES"; break;
			case 6: $dia_desc = "SABADO"; break;
		}
		
		$hoy = ($hoy != "")?regresa_fecha($hoy):date("Y-m-d"); //valida
		$hoymenos = date("Y-m-d",strtotime("$hoy -1 week")); //resta una semana para el botoncito -
		$hoymas = date("Y-m-d",strtotime("$hoy +1 week")); //suma una semana para el botoncito +
		
		$fechaInicio = strtotime("$hoy -2 week"); //Fecha del mismo día de las 2 semanas pasadas
		$fechaFin = strtotime("$hoy +2 week"); // Fecha del mismo día de las siguientes 2 semanas
		
		//////////// Inicia combo de Fechas //////////////////
		$anterior = date("d/m/Y",$fechaInicio);
		for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){ ///// recorre los rangos de fechas de 2 semanas hantes hasta 2 semanas despues
			$dia_recorrido = date('N', $i); /// convierte a Formato dia de la semana la fecha recorrida
			if($dia_recorrido == $dia){ ///// valida si ese dia corresponde a uno de los dias del horario (L, M, M, J, V)
				$lista_fecha = $dia_desc.' '.date("d/m/Y", $i);
				$anterior = date("d/m/Y", $i);
				//--
				$arr_data[0]['fecha'][$i] = $lista_fecha;
			}
			if(date("d/m/Y") == date("d/m/Y", $i)){ //// registra la ultima fecha valida mas cercana a la fecha de hoy para setear en el combo fechas
				$fecha = $anterior;
			}
		}
		$arr_data[1]['fecha_probable_hoy'] = $fecha;
		echo json_encode($arr_data);
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}


function API_lista_alumnos($horario,$fecha){
	
	if($horario != "" && $fecha != ""){
		$ClsAsist = new ClsAsistencia();
		$ClsHor = new ClsHorario();
		$ClsAcad = new ClsAcademico();
		$ClsPen = new ClsPensum();
		$asistencia = $ClsAsist->count_asistencia($horario,$fecha);
		
		if($asistencia > 0){
			$result = $ClsAsist->get_asistencia($horario,$fecha);
			if(is_array($result)){
				$i = 0;
				foreach($result as $row){
					//codigo
					$cui = $row["alu_cui"];
					$sit = $row["asi_asistencia"];
					$chk = ($sit == 1)?true:false;
					//alumno
					$nombre = trim($row["alu_nombre"]);
					$apellido = trim($row["alu_apellido"]);
					$nombres = $apellido.", ".$nombre;
					//--
					$arr_data[$i]['cui'] = $cui;
					$arr_data[$i]['nombre'] = $nombres;
					$arr_data[$i]['asistencia'] = $chk;
					$arr_data[$i]['situacion'] = "Tomada";
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
			$result = $ClsHor->get_horario($horario);
			$pensum = $ClsPen->get_pensum_activo();
			if(is_array($result)){
				foreach($result as $row){
					$nivel = $row["hor_nivel"];
					$grado = $row["hor_grado"];
					$seccion = $row["hor_seccion"];
					$dia = $row["hor_dia"];
					//---
					$grado_desc = trim($row["gra_descripcion"]);
					$seccion_desc = $row["sec_descripcion"];
				}
			}
			///
			$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
			if(is_array($result)){
				$i = 0;
				foreach($result as $row){
					//codigo
					$cui = $row["alu_cui"];
					//alumno
					$nombre = trim($row["alu_nombre"]);
					$apellido = trim($row["alu_apellido"]);
					$nombres = $apellido.", ".$nombre;
					//--
					$arr_data[$i]['cui'] = $cui;
					$arr_data[$i]['nombre'] = $nombres;
					$arr_data[$i]['asistencia'] = false;
					$arr_data[$i]['situacion'] = "Pendiente de Tomar";
					//--
					$i++;
				}
				//print_r($arr_data);
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "vacio",
					"message" => "No se registran datos...");
					echo json_encode($arr_data);
			}
			
		}	
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}



function API_asistencia($horario,$fecha,$data){
	
	$ClsAsist = new ClsAsistencia();
	$ClsHor = new ClsHorario();
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	
	if($horario != "" && $fecha != "" && $data != ""){
		$asistencia = $ClsAsist->count_asistencia($horario,$fecha);
		///desglosa $data
		$data = json_decode(stripslashes($data), true);
		
		if($asistencia > 0){
			if(is_array($data)){
				$sql = "";
				$result = $ClsHor->get_horario($horario);
				if(is_array($result)){
					foreach($result as $row){
						$nivel = $row["hor_nivel"];
						$grado = $row["hor_grado"];
						$seccion = $row["hor_seccion"];
					}
				}
				///
				$pensum = $ClsPen->get_pensum_activo();
				$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
				if(is_array($result)){
					foreach($result as $row){
						//codigo
						$alumno = $row["alu_cui"];
						$sql.= $ClsAsist->modifica_asistencia($horario,$fecha,$alumno,0);
					}
				}
				//
				$i = 0;
				foreach($data as $row){
					$alumno = trim($data[$i]["cui"]);
					$sql.= $ClsAsist->modifica_asistencia($horario,$fecha,$alumno,1);
					$i++;
				}
				$rs = $ClsAsist->exec_sql($sql);
				//echo $sql."<br><br>";
				if($rs == 1){
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "success",
						"message" => "Asistencia modificada satisfactoriamente...!");
						echo json_encode($arr_data);
				}else{
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "error",
						"message" => "Uno o mas datos no cumplen con las normas de integridad de la información, contacte al administrador...");
						echo json_encode($arr_data);
				}
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "este arreglo de datos no cumple con las caracteristicas....");
					echo json_encode($arr_data);
			}
		}else{
			if(is_array($data)){
				$sql = "";
				$result = $ClsHor->get_horario($horario);
				if(is_array($result)){
					foreach($result as $row){
						$nivel = $row["hor_nivel"];
						$grado = $row["hor_grado"];
						$seccion = $row["hor_seccion"];
					}
				}
				///
				$pensum = $ClsPen->get_pensum_activo();
				$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
				if(is_array($result)){
					foreach($result as $row){
						//codigo
						$alumno = $row["alu_cui"];
						$sql.= $ClsAsist->insert_asistencia($horario,$fecha,$alumno,0);
					}
				}
				//
				$i=0;
				foreach($data as $row){
					$alumno = trim($data[$i]["cui"]);
					$sql.= $ClsAsist->modifica_asistencia($horario,$fecha,$alumno,1);
					$i++;
				}
				$rs = $ClsAsist->exec_sql($sql);
				//echo $sql."<br><br>";
				if($rs == 1){
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "success",
						"message" => "Asistencia registrada satisfactoriamente...!");
						echo json_encode($arr_data);
				}else{
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "error",
						"message" => "Uno o mas datos no cumplen con las normas de integridad de la información, contacte al administrador...");
						echo json_encode($arr_data);
				}
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "este arreglo de datos no cumple con las caracteristicas....");
					echo json_encode($arr_data);
			}
		}	
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}