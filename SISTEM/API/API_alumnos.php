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
		case "usuario_secciones":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_secciones($tipo_usuario,$tipo_codigo);
			break;
		case "lista_alumnos":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			API_lista_alumnos($nivel,$grado,$seccion);
			break;
		case "alumno_perfil":
			$cui = $_REQUEST["cui"];
			API_alumno_perfil($cui);
			break;
		case "padre_perfil":
			$dpi = $_REQUEST["dpi"];
			API_padre_perfil($dpi);
			break;
		case "materias":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_materias($nivel,$grado,$tipo_usuario,$tipo_codigo);
			break;
		case "materia_unidades":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$materia = $_REQUEST["materia"];
			$alumno = $_REQUEST["alumno"];
			API_lista_materia_unidades($nivel,$grado,$materia,$alumno);
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



function API_lista_alumnos($nivel,$grado,$seccion){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	
	if($nivel != "" && $grado != "" && $seccion != ""){
		$pensum = $ClsPen->get_pensum_activo();
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
				$grado_desc = trim($row["gra_descripcion"]);
				$seccion_desc = trim($row["sec_descripcion"]);
				$grado_completo = $grado_desc." ".$seccion_desc;
				//--
				$arr_data[$i]['cui'] = $cui;
				$arr_data[$i]['nombre'] = $nombres;
				$arr_data[$i]['seccion'] = $grado_completo;
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
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}



function API_alumno_perfil($cui){
	$ClsAlu = new ClsAlumno();
	$ClsCli = new ClsCliente();
	$ClsAcadem = new ClsAcademico();
	$ClsAsig = new ClsAsignacion();
	$ClsSeg = new ClsSeguro();
	
	if($cui != ""){
		$result = $ClsAlu->get_alumno($cui,"","",1);
		$i=0;
		if(is_array($result)){
			foreach($result as $row){
				$arr_data[$i]['cui'] = $row["alu_cui"];
				$arr_data[$i]['nombres'] = trim($row["alu_nombre"]);
				$arr_data[$i]['apellidos'] = trim($row["alu_apellido"]);
				$arr_data[$i]['genero'] = trim($row["alu_genero"]);
				$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
				$arr_data[$i]['fecha_nacimiento'] = $fecnac; 
				$edad = Calcula_Edad($fecnac);
				$arr_data[$i]['edad'] = $edad;
				$arr_data[$i]['tipo_sangre'] = trim($row["alu_tipo_sangre"]);
				$arr_data[$i]['alergico_a'] = trim($row["alu_alergico_a"]);
				$cliente = $row["alu_cliente_factura"];
				//--
				$foto = $row["alu_foto"];
			}
		
			if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
				$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
			}else{
				$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
			}
			
			$result = $ClsAcadem->get_grado_alumno($pensum,'','',$cui,'',1);
			if(is_array($result)){
				foreach($result as $row){
					$arr_data[$i]['nivel'] = trim($row["niv_descripcion"]);
					$arr_data[$i]['grado'] = trim($row["gra_descripcion"]);
				}
			}else{
				$arr_data[$i]['nivel'] = "NO ASIGNADO";
				$arr_data[$i]['grado'] = "NO ASIGNADO";
			}
			
			$result = $ClsAcadem->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);
			if(is_array($result)){
				foreach($result as $row){
					$arr_data[$i]['seccion'] = trim($row["sec_descripcion"]);
				}
			}else{
				$arr_data[$i]['seccion'] = "NO ASIGNADO";
			}
			
			$arr_papas = array();
			$j=0;
			$result = $ClsAsig->get_alumno_padre('',$cui);
			if(is_array($result)){
				foreach($result as $row){
					$arr_papas[$j]["dpi"] = $row["pad_cui"];
					$arr_papas[$j]["nom"] = trim($row["pad_nombre"]);
					$arr_papas[$j]["ape"] = trim($row["pad_apellido"]);
					$arr_papas[$j]["mail"] = trim($row["pad_mail"]);
					$arr_papas[$j]["tel"] = trim($row["pad_telefono"]);
					$j++;
				}
				$j--; //quita una vuelta para cuadrar
			}else{
				$arr_papas[$j]["dpi"] = "SIN PADRES REPORTADOS";
			}
			$arr_data[$i]['padres'] = $arr_papas;
			
			//////// SEGURO /////////
			$arr_seguro = array();
			$j = 0;
			$result_seguro = $ClsSeg->get_seguro($cui);
			if(is_array($result_seguro)){
				foreach($result_seguro as $row_seguro){
					$arr_seguro[$j]['tiene_seguro'] = ($row_seguro["seg_tiene_seguro"] == 1)?"SI":"NO";
					$arr_seguro[$j]['poliza'] = trim($row_seguro["seg_poliza"]);
					$arr_seguro[$j]['aseguradora'] = trim($row_seguro["seg_aseguradora"]);
					$arr_seguro[$j]['plan'] = trim($row_seguro["seg_plan"]);
					$arr_seguro[$j]['asegurado_principla'] = trim($row_seguro["seg_asegurado_principal"]);
					$arr_seguro[$j]['instrucciones'] = trim($row_seguro["seg_instrucciones"]);
					$arr_seguro[$j]['comentario'] = trim($row_seguro["seg_comentarios"]);
				}
			}else{
				$arr_seguro[$j]['tiene_seguro'] = "";
				$arr_seguro[$j]['poliza'] = "";
				$arr_seguro[$j]['aseguradora'] = "";
				$arr_seguro[$j]['plan'] = "";
				$arr_seguro[$j]['asegurado_principla'] = "";
				$arr_seguro[$j]['instrucciones'] = "";
				$arr_seguro[$j]['comentario'] = "";
			}
			$arr_data[$i]['seguro'] = $arr_seguro;
			
			if(strlen($cliente)>0){
				$result = $ClsCli->get_cliente($cliente);
				if(is_array($result)){
					foreach($result as $row){
						$arr_data[$i]['nit_facturacion'] = $row["cli_nit"];
						$arr_data[$i]['nombre_facturacion'] = $row["cli_nombre"];
					}
				}
			}else{
				$arr_data[$i]['nit_facturacion'] = "CF";
				$arr_data[$i]['nombre_facturacion'] = "CONSUMIDOR FINAL";
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
			"message" => "El codigo de usuario esta vacio");
			echo json_encode($arr_data);
	}
	
}



function API_padre_perfil($dpi){
	$ClsUsu = new ClsUsuario();
	$ClsPad = new ClsPadre();
	if($dpi != ""){
		$i=0;
		$result = $ClsPad->get_padre($dpi,'','',1);
		if (is_array($result)) {
			foreach ($result as $row){
				$arr_data[$i]['dpi'] = $row["pad_cui"];
				$arr_data[$i]['nombres'] = trim($row["pad_nombre"]);
				$arr_data[$i]['apellidos'] = trim($row["pad_apellido"]);
				$arr_data[$i]['direccion'] = trim($row["pad_direccion"]);
				$arr_data[$i]['lugar_trabajo'] = trim($row["pad_lugar_trabajo"]);
			}
			$result = $ClsUsu->get_usuario_tipo_codigo('3',$dpi);
			if(is_array($result)){
				foreach($result as $row){
					$id = trim($row["usu_id"]);
					//---
					$arr_data[$i]['nombre_pantalla'] = trim($row["usu_nombre_pantalla"]);
					$arr_data[$i]['mail'] = $row["usu_mail"];
					$arr_data[$i]['telefono'] = $row["usu_telefono"];
				}
				//$_POST
				$foto = $ClsUsu->last_foto_usuario($id);
				if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/USUARIOS/'.$foto.'.jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/nofoto.png";
				}
			}else{
				$arr_data[$i]['usuario'] = "NO CUENTA CON USUARIO";
			}
			
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "no esxiste este DPI con los padres...");
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



function API_lista_materias($nivel,$grado,$tipo_usuario,$tipo_codigo){
	$ClsPen = new ClsPensum();
	$ClsAcadem = new ClsAcademico();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($pensum != "" && $nivel != "" && $grado != "" && $tipo_usuario != "" && $tipo_codigo != ""){
		if($tipo_usuario == 2){ //// MAESTRO
			$result = $ClsAcadem->get_materia_seccion_maestro($pensum,$nivel,$grado,'','',$tipo_codigo);
		}else if($tipo_usuario == 1){ //// DIRECTORA
			$result = $ClsPen->get_materia($pensum,$nivel,$grado);
		}else if($tipo_usuario == 5){ //// ADMINISTRADOR
			$result = $ClsPen->get_materia($pensum,$nivel,$grado);
		}
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


function API_lista_materia_unidades($nivel,$grado,$materia,$alumno){
	$ClsNot = new ClsNotas();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($pensum != "" && $nivel != "" && $grado != "" && $materia != "" && $alumno != ""){
		$result = $ClsPen->get_materia($pensum,$nivel,$grado,$materia,'',1);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				//--
				for($j = 1; $j <= 5; $j++){
					$arr_data[$i]['parcial'] = $j;
					$arr_data[$i]['pensum'] = $row["mat_pensum"];
					$arr_data[$i]['nivel'] = $row["mat_nivel"];
					$arr_data[$i]['grado'] = $row["mat_grado"];
					$arr_data[$i]['materia'] = $row["mat_codigo"];
					$arr_data[$i]['mat_descripcion'] = trim($row["mat_descripcion"]);
					switch($j){
						case 1: $par_descripcion = "1RA. UNIDAD"; break;
						case 2: $par_descripcion = "2DA. UNIDAD"; break;
						case 3: $par_descripcion = "3RA. UNIDAD"; break;
						case 4: $par_descripcion = "4TA. UNIDAD"; break;
						case 5: $par_descripcion = "5TA. UNIDAD"; break;
					}
					$arr_data[$i]['descripcion'] = $par_descripcion;
					//--
					$parcial = $j;
					$result_notas = $ClsNot->comprueba_notas_alumno($alumno,$pensum,$nivel,$grado,$materia,$parcial);
					$arr_nota = "";
					$k = 0;
					if(is_array($result_notas)){
						foreach($result_notas as $row_notas){
							$arr_nota[$k]['examen'] = $row_notas["not_nota"];
							$arr_nota[$k]['zona'] = $row_notas["not_zona"];
							$k++;
						}
					}else{
						$arr_nota[$k]['nota'] = "PENDIENTE";
					}
					$arr_data[$i]['nota'] = $arr_nota;
					//--
					$i++;
				}
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No existe la materia...");
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
