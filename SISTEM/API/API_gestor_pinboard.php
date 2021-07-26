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

include_once('../../CONFIG/push/push_android.php');
include_once('../../CONFIG/push/push_ios.php');
///API REQUEST
$request = $_REQUEST["request"];

if($request != ""){
	switch($request){
		case "alumnos":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			$nombre = $_REQUEST["alu_nombre"];
			API_alumnos($tipo_usuario,$tipo_codigo,$nombre);
			break;
		case "secciones":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_secciones($tipo_usuario,$tipo_codigo);
			break;
		case "materias":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			API_lista_materias($nivel,$grado);
			break;
		case "postits_materia":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			$materia = $_REQUEST["materia"];
			API_lista_postits_materia($nivel,$grado,$seccion,$materia);
			break;
		case "postits_alumno":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			$alumno = $_REQUEST["alumno"];
			$tipo_usuario = $_REQUEST["tipo_usuario"];
			$usuario = $_REQUEST["usuario"];
			API_lista_postits_alumno($nivel,$grado,$seccion,$alumno,$tipo_usuario,$usuario);
			break;
		case "postits_mestro":
			$maestro = $_REQUEST["maestro"];
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			$page = $_REQUEST["page"]; //opcional
			API_lista_postits_maestro($maestro,$nivel,$grado,$seccion,$page);
			break;
		case "postit":
			$codigo = $_REQUEST["codigo"];
			API_postit($codigo);
			break;
		case "new_postit":
			$data = $_REQUEST["data"];
			API_new_postit($data);
			break;
		case "update_postit":
			$data = $_REQUEST["data"];
			API_update_postit($data);
			break;
		case "delete_postit":
			$codigo = $_REQUEST["codigo"];
			API_delete_postit($codigo);
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
function API_alumnos($tipo_usuario,$tipo_codigo,$nombre){
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "2"){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAcad->get_maestro_alumnos($pensum,'','','',$tipo_codigo,$nombre);
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
					$grado_desc = trim($row["gra_descripcion"]);
					$seccion_desc = trim($row["sec_descripcion"]);
					$grado_completo = $grado_desc." ".$seccion_desc;
					//--
					$arr_data[$i]['cui'] = $cui;
					$arr_data[$i]['nombre'] = $nombres;
					$arr_data[$i]['seccion_descripcion'] = $grado_completo;
					$arr_data[$i]['pensum'] = $pensum;
					$arr_data[$i]['nivel'] = trim($row["niv_codigo"]);
					$arr_data[$i]['grado'] = trim($row["gra_codigo"]);
					$arr_data[$i]['seccion'] = trim($row["sec_codigo"]);
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
				//print_r($arr_data);
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "vacio",
					"message" => "No se registran datos...");
					echo json_encode($arr_data);
			}		
		}else if($tipo_usuario === "1"){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAcad->get_otros_usuarios_alumnos($pensum,'','',$tipo_codigo,$nombre);
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
					$grado_desc = trim($row["gra_descripcion"]);
					$seccion_desc = trim($row["sec_descripcion"]);
					$grado_completo = $grado_desc." ".$seccion_desc;
					//--
					$arr_data[$i]['cui'] = $cui;
					$arr_data[$i]['nombre'] = $nombres;
					$arr_data[$i]['seccion_descripcion'] = $grado_completo;
					$arr_data[$i]['pensum'] = $pensum;
					$arr_data[$i]['nivel'] = trim($row["niv_codigo"]);
					$arr_data[$i]['grado'] = trim($row["gra_codigo"]);
					$arr_data[$i]['seccion'] = trim($row["sec_codigo"]);
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
				//print_r($arr_data);
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



function API_lista_materias($nivel,$grado){
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	if($pensum != "" && $nivel != "" && $grado != ""){
		$result = $ClsPen->get_materia($pensum,$nivel,$grado,'','',1);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["mat_codigo"];
                $arr_data[$i]['pensum'] = $row["mat_pensum"];
				$arr_data[$i]['nivel'] = $row["mat_nivel"];
				$arr_data[$i]['grado'] = $row["mat_grado"];
				$arr_data[$i]['codigo'] = $row["mat_codigo"];
				$arr_data[$i]['descripcion'] = $row["mat_descripcion"];
				$arr_data[$i]['descripcion_corta'] = $row["mat_desc_ct"];
				//tipo
				$tipo = trim($row["mat_tipo"]);
				switch($tipo){	
					case 'A': $tipo_desc = "ACADEMICA"; break;
					case 'P': $tipo_desc = "PRACTICA"; break;
					case 'D': $tipo_desc = "DEPORTIVA"; break;
				}
				$arr_data[$i]['tipo'] = $tipo_desc;
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


function API_lista_postits_materia($nivel,$grado,$seccion,$materia){
	$ClsPost = new ClsPostit();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $materia != ""){
		$result = $ClsPost->get_postit('',$pensum,$nivel,$grado,$seccion,$materia,'','','','',1);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["post_codigo"];
				$arr_data[$i]['titulo'] = trim($row["post_titulo"]);
				$arr_data[$i]['descripcion'] = $row["post_descripcion"];
				$target = trim($row["post_target"]);
				$target_nombre = trim($row["post_target_nombre"]);
				$target = ($target != "")?$target_nombre:"Todos";
				$arr_data[$i]['target'] = $target;
				$arr_data[$i]['post_fecha_registro'] = cambia_fechaHora($row["post_fecha_registro"]);
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



function API_lista_postits_alumno($nivel,$grado,$seccion,$alumno,$tipo_usuario,$usuario){
	$ClsPost = new ClsPostit();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $alumno != "" && $tipo_usuario != ""){
		//////////valida el tipo de usuario
		if($tipo_usuario == 1){
			$cui_usuario = "";
		}else if($tipo_usuario == 2){
			$cui_usuario = $usuario;
		}
		////////////// PARA Todos EN EL GRADO //////////
		$result_todos = $ClsPost->get_postit('',$pensum,$nivel,$grado,$seccion,'',$cui_usuario,'Todos','','',1);
		$result_target = $ClsPost->get_postit('',$pensum,$nivel,$grado,$seccion,'',$cui_usuario,$alumno,'','',1);
		if(is_array($result_todos) || is_array($result_target)) {
			$i = 0;	
		    if (is_array($result_todos)) {
    			foreach ($result_todos as $row){
    				$arr_data[$i]['codigo'] = $row["post_codigo"];
					$arr_data[$i]['post_pensum'] = $row["post_pensum"];
					$arr_data[$i]['post_nivel'] = $row["post_nivel"];
					$arr_data[$i]['post_grado'] = $row["post_grado"];
					$arr_data[$i]['post_seccion'] = $row["post_seccion"];
					$arr_data[$i]['post_materia'] = $row["post_materia"];
					//--
    				$arr_data[$i]['seccion'] =  trim($row["post_grado_desc"]).' '.trim($row["post_seccion_desc"]);
    				$arr_data[$i]['materia'] = trim($row["post_materia_desc"]);
    				$target_nombre = trim($row["post_target_nombre"]);
    				$target = ($target != "")?$target_nombre:"Todos";
                    $arr_data[$i]['target'] = $target;
    				$arr_data[$i]['target_codigo'] = trim($row["post_target"]);
    				$arr_data[$i]['maestro'] = trim($row["post_maestro_nombre"]);
    				$arr_data[$i]['maestro_cui'] = trim($row["post_maestro"]);
    				$arr_data[$i]['titulo'] = trim($row["post_titulo"]);
    				$arr_data[$i]['descripcion'] = trim($row["post_descripcion"]);
    				$fecha = $row["post_fecha_registro"];
    				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
					//--
    				$i++;
    			}
		    }
			if (is_array($result_target)) {
				foreach ($result_target as $row){
					$arr_data[$i]['codigo'] = $row["post_codigo"];
					$arr_data[$i]['post_pensum'] = $row["post_pensum"];
					$arr_data[$i]['post_nivel'] = $row["post_nivel"];
					$arr_data[$i]['post_grado'] = $row["post_grado"];
					$arr_data[$i]['post_seccion'] = $row["post_seccion"];
					$arr_data[$i]['post_materia'] = $row["post_materia"];
					//--
    				$arr_data[$i]['seccion'] =  trim($row["post_grado_desc"]).' '.trim($row["post_seccion_desc"]);
    				$arr_data[$i]['materia'] = trim($row["post_materia_desc"]);
    				$target_nombre = trim($row["post_target_nombre"]);
    				$target = ($target != "")?$target_nombre:"Todos";
                    $arr_data[$i]['target'] = $target;
    				$arr_data[$i]['target_codigo'] = trim($row["post_target"]);
    				$arr_data[$i]['maestro'] = trim($row["post_maestro_nombre"]);
    				$arr_data[$i]['maestro_cui'] = trim($row["post_maestro"]);
    				$arr_data[$i]['titulo'] = trim($row["post_titulo"]);
    				$arr_data[$i]['descripcion'] = trim($row["post_descripcion"]);
    				$fecha = $row["post_fecha_registro"];
    				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
					//--
					$i++;
				}
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



function API_lista_postits_maestro($cui_usuario,$nivel,$grado,$seccion,$page = ''){
	$ClsUsu = new ClsUsuario();
	$ClsPost = new ClsPostit();
	$ClsPen = new ClsPensum();
	$ClsAcadem = new ClsAcademico();
	if($cui_usuario != ""){
		$result = $ClsUsu->get_usuario_tipo_codigo('',$cui_usuario);
		if(is_array($result)) {
			foreach ($result as $row){
				if($row["usu_tipo"] == 1 || $row["usu_tipo"] == 2){
					$tipo = $row["usu_tipo"];
				}
			}	
		}
		/////// TRAES POSTITS
		$codigos = '';
		$pensum = $ClsPen->get_pensum_activo();
		if($tipo == 1){
			$codigos = $ClsPost->get_postit_codigos('',$pensum,$nivel,$grado,$seccion,'','','','','',1);
		}else if($tipo == 2){
			$codigos = $ClsPost->get_postit_codigos('',$pensum,$nivel,$grado,$seccion,'','','','','',1);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario no pertenece a este perfil...");
				echo json_encode($arr_data);
			return;
		}
		//FILTRA
		////////////////// PAGES //////////////////
		if($page != ""){
			$limit1 = 1;
			$limit2 = 1;
			if($page == 0){
				$limit1 = 0;
				$limit2 = 10;
			}else{
				$limit1 = $page * 10;
				$limit2 = 10;
			}
		}else{
			$limit1 = 0;
			$limit2 = 10;
		}
		//echo $codigos.'<br>';
		$result = $ClsPost->get_postit_limit($codigos,$limit1,$limit2);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["post_codigo"];
				$maestro = $row["post_maestro"];
				if($tipo == 2){
					if($cui_usuario != $maestro){
						$arr_data[$i]['editable'] = 'nocreado';
					}else{
						$arr_data[$i]['editable'] = 'creado';
					}
				}else{
					$arr_data[$i]['editable'] = 'creado';
				}
				$arr_data[$i]['post_pensum'] = $row["post_pensum"];
				$arr_data[$i]['post_nivel'] = $row["post_nivel"];
				$arr_data[$i]['post_grado'] = $row["post_grado"];
				$arr_data[$i]['post_seccion'] = $row["post_seccion"];
				$arr_data[$i]['mat_codigo'] = $row["post_materia"];
				$arr_data[$i]['mat_descripcion'] = $row["post_materia_desc"];
				$arr_data[$i]['post_maestro'] = $row["post_maestro"];
				$arr_data[$i]['seccion'] = trim($row["post_grado_desc"])." Sección ".trim($row["post_seccion_desc"]);
				//--
				$maestro = trim($row["post_maestro"]);
				$arr_data[$i]['editable'] = ($maestro == $cui_usuario)? 'creado' : 'nocreado';
				//-
				$arr_data[$i]['titulo'] = trim($row["post_titulo"]);
				$arr_data[$i]['descripcion'] = $row["post_descripcion"];
				$target = trim($row["post_target"]);
				$target_nombre = trim($row["post_target_nombre"]);
				$target_nombre = ($target != "")?$target_nombre:"Todos";
				$arr_data[$i]['target'] = $target_nombre;
				$arr_data[$i]['cui'] = trim($row["post_target"]);
				$arr_data[$i]['alumno_name'] = trim($row["post_target_nombre"]);
				//--
				$foto = $row["alu_foto"];
				if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg' && $target != "")){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
				}
				$arr_data[$i]['post_fecha_registro'] = cambia_fechaHora($row["post_fecha_registro"]);
				//--
				$i++;
			}
			echo json_encode($arr_data);
			return;
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



function API_postit($codigo){
	$ClsPost = new ClsPostit();
	if($codigo != ""){
		$result = $ClsPost->get_postit($codigo);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["post_codigo"];
				$arr_data[$i]['titulo'] = trim($row["post_titulo"]);
				$arr_data[$i]['descripcion'] = $row["post_descripcion"];
				$target = trim($row["post_target"]);
				$target_nombre = trim($row["post_target_nombre"]);
				$target = ($target != "")?$target_nombre:"Todos";
				$arr_data[$i]['target'] = $target;
				$arr_data[$i]['post_fecha_registro'] = cambia_fechaHora($row["post_fecha_registro"]);
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


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////// GESTORES ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function API_new_postit($data){
	$ClsPost = new ClsPostit();
	$ClsPen = new ClsPensum();
	$ClsAcadem = new ClsAcademico();
	$ClsPush = new ClsPushup();
	
	$data = str_replace("\\n"," ",$data);
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$pensum = $ClsPen->get_pensum_activo();
		$nivel = trim($data[0]["nivel"]);
		$grado = trim($data[0]["grado"]);
		$seccion = trim($data[0]["seccion"]);
		$maestro = trim($data[0]["maestro"]);
		$titulo = trim($data[0]["titulo"]);
		$desc = trim($data[0]["descripcion"]);
		//--
		$titulo = trim($titulo);
		$desc = trim($desc);
		//--------
		if($titulo !="" && $desc !=""){
			$bandera_codigo = false; //validará que se cree o no un nuevo codigo
			$codigo = $ClsPost->max_postit();
			$codigo++;
			
			$alumnos = trim($data[0]["target"]);
			$arralumnos = array();
			$arralumnos = explode(",", $alumnos);
			$cantidad = count($arralumnos);
			
			$array_notificaciones = array();
			$alumnos = "";
			for($i = 0; $i < $cantidad; $i ++){
				$alumnos.= $arralumnos[$i].","; /// alinea y separa con comas para la busqueda de padres...
			}
			$alumnos = substr($alumnos,0,-1);
			$codigos = ''; //almacena y concatena los codigos de postit creados
			$i = 0;
			$result = $ClsPush->get_alumnos_users($alumnos);
			if(is_array($result)) {
				$AlumnoRepetido = ''; // valida que no repita el insert del postit, solo el de la notificación
				$UsuarioRepetido = ''; // valida que no repita el insert de la push
				foreach ($result as $row){
					$alumno = $row["pa_alumno"];
					if($AlumnoRepetido != $alumno){
						$sql.= $ClsPost->insert_postit($codigo,$pensum,$nivel,$grado,$seccion,$maestro,$alumno,$titulo,$desc);
						$AlumnoRepetido = $alumno;
						$codigos.= $codigo.",";
						$bandera_codigo = true;
					}else{
						$codigo--;
					}
					$user_id = $row["user_id"];
					$device_id = $row["device_id"];
					if($UsuarioRepetido != $user_id && $device_id != ""){
						$message = $desc;
						$push_tipo = 1;
						$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$codigo,$alumno);
						//--
						$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
						$array_notificaciones[$i]["user_id"] = $row["user_id"];
						$array_notificaciones[$i]["device_type"] = $row["device_type"];
						$array_notificaciones[$i]["device_token"] = $row["device_token"];
						$array_notificaciones[$i]["certificate_type"] = $row["certificate_type"];
						$array_notificaciones[$i]["push_tipo"] = $push_tipo;
						$array_notificaciones[$i]["item_id"] = $codigo;
						$array_notificaciones[$i]["message"] = $message;
						$array_notificaciones[$i]["pendientes"] = $pendientes;
						$i++;
						$UsuarioRepetido = $user_id;
					}
					$codigo++;
				}
			}
			$codigo--; //resta una vuelta al codigo, para que haga match con el item_id de la notificación
			$codigos = substr($codigos,0,-1);
			$eliminar = $codigos; //selecciona los codigos a notificar
			/////// Escoge a los códigos por eliminar ////////
			$arr_codigos = array();
			$arr_codigos = explode(",",$codigos);
			$cont = count($arr_codigos);
			$base = $arr_codigos[0]; /// trae el codigo mas bajo
			$notificar = "";
			for($n = $cont; $n > 0; $n--){
				$base--;
				$notificar.= $base.",";
			}
			$notificar = substr($notificar,0,-1);
			
			$rs = $ClsPost->exec_sql($sql);
			if($rs == 1){
			    //devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "success",
					"notificar" => $notificar,
					"elimnar" => $eliminar,
					"message" => "Notificación creada satisfactoriamente....");
					echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"eliminar" => '',
					"notificar" => '',
					"message" => "Uno o mas datos no cumplen con las normas de integridad de la información, contacte al administrador...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"eliminar" => '',
				"notificar" => '',
				"message" => "Algunos datos estan vacios");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"eliminar" => '',
			"notificar" => '',
			"message" => "Formato no valido...");
			echo json_encode($arr_data);
	}
	
}


function API_update_postit($data){
	$ClsPost = new ClsPostit();
	
	$data = str_replace("\\n"," ",$data);
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$codigo = trim($data[0]["codigo"]);
		$materia = trim($data[0]["materia"]);
		$target = trim($data[0]["target"]); /// Todos = '' ó CUI de alumno
		$titulo = trim($data[0]["titulo"]);
		$desc = trim($data[0]["descripcion"]);
		//--
		$titulo = trim($titulo);
		$desc = trim($desc);
		//--------
		if($titulo !="" && $desc !=""){
			$sql = $ClsPost->modifica_postit_datos($codigo,$titulo,$desc);
			$rs = $ClsPost->exec_sql($sql);
			//echo $sql;
			if($rs == 1){
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "success",
					"message" => "Notificación Actualizada Satisfactoriamente....");
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
				"message" => "Algunos datos estan vacios");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Formato no valido...");
			echo json_encode($arr_data);
	}
	
}


function API_delete_postit($codigo){
	$ClsPost = new ClsPostit();
	$ClsPush = new ClsPushup();
	if($codigo != ""){
		$sql = $ClsPost->delete_postit($codigo);
		$sql.= $ClsPush->delete_push_especifica(1,$codigo);
		$rs = $ClsPost->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Notificación Eliminada Satisfactoriamente....");
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
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}

