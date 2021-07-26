<?php 
//inclu�mos las clases
include_once("html_fns_segmentos.php");


$request = $_REQUEST["request"]; 
switch($request){
	case "tabla":
		get_tabla();
		break;
	case "grabarSegmento":
		$nom = $_REQUEST["nom"];
		$area = $_REQUEST["area"];
		Grabar_Segmento($area,$nom);
		break;
	case "buscarSegmento":
		$codigo = $_REQUEST["codigo"];
		$area = $_REQUEST["area"];
		Buscar_Segmento($codigo,$area);
		break;
	case "modificarSegmento":
		$cod = $_REQUEST["codigo"];
		$nom = $_REQUEST["nom"];
		$area = $_REQUEST["area"];
		Modificar_Segmento($cod,$area,$nom);
		break;
	case "situacionSegmento":
		$codigo = $_REQUEST["codigo"];
		$area = $_REQUEST["area"];
		$sit = $_REQUEST["situacion"];
		Situacion_Segmento($codigo,$area,$sit);
		break;						
	default:
		$arr_respuesta = array(
			"status" => false,
			"data" => [],
			"message" => "Seleccione un metodo..."
		);
		//echo json_encode($arr_respuesta);
}
 ///////////// TABLA /////////
 
 function get_tabla(){ 
	$ClsArea = new ClsArea();
	$result = $ClsArea->get_segmento('','','',1);
	if(is_array($result)){
		$arr_respuesta = array(
			"status" => true,
			"tabla" => tabla_segmentos(),
			"message" => ""
		);
	}else{
		$arr_respuesta = array(
			"status" => false,
			"data" => [],
			"message" => "Aún no hay datos registrados..."
		);
	}
	echo json_encode($arr_respuesta);
}



//////////////////---- EMPRESAS -----/////////////////////////////////////////////
function Grabar_Segmento($area,$nom){
   $ClsArea = new ClsArea();
   //pasa a mayusculas
		$nom = trim($nom);
	//--------
	//decodificaciones de tildes y �'s
		$nom = utf8_encode($nom);
		//--
		$nom = utf8_decode($nom);
	//--------
    if($nom != "" && $area != ""){
		$cod = $ClsArea->max_segmento($area);
		$cod++; /// Maximo codigo de Grupo
		$sql = $ClsArea->insert_segmento($cod,$area,$nom); /// Inserta Empresa
		$rs = $ClsArea->exec_sql($sql);
		if($rs == 1){
			$arr_respuesta = array(
				"status" => true,
				"data" => [],
				"message" => "Registro guardado satisfactoriamente...!"
			);
			echo json_encode($arr_respuesta);
		
		}else{
			$arr_respuesta = array(
				"status" => false,
				//"sql" => $sql,
				"data" => [],
				"message" => "Error en la transacción..."
			);
			echo json_encode($arr_respuesta);
		}
	}
}


function Buscar_Segmento($codigo,$area){
   $ClsArea = new ClsArea();
   $result = $ClsArea->get_segmento($codigo,$area,"",1);
   $arr_data = array();
   if(is_array($result)){
	   foreach($result as $row){
		   $arr_data["codigo"] = trim($row["seg_codigo"]);
		   $arr_data["nombre"] = trim($row["seg_nombre"]);
		   $arr_data["area"] = trim($row["seg_area"]);
		   $i++;
	   }
	   $arr_respuesta = array(
		   "status" => true,
		   "data" => $arr_data,
		   "tabla" => tabla_segmentos($codigo),
		   "message" => ""
	   );
   }else{
	   $arr_respuesta = array(
		   "status" => false,
		   "data" => [],
		   "message" => "Aún no hay datos registrados..."
	   );
   }
   echo json_encode($arr_respuesta);
}

function Modificar_Segmento($cod,$area,$nom){
   $ClsArea = new ClsArea();
   //pasa a mayusculas
		$nom = trim($nom);
	//--------
	//decodificaciones de tildes y �'s
		$nom = utf8_encode($nom);
		//--
		$nom = utf8_decode($nom);
	//--------
	if($nom != "" && $area != ""){
		$sql = $ClsArea->modifica_segmento($cod,$area,$nom);
		$rs = $ClsArea->exec_sql($sql);
		if($rs == 1){
			$arr_respuesta = array(
				"status" => true,
				"data" => [],
				"message" => "Registro actualizado satisfactoriamente...!"
			);
			echo json_encode($arr_respuesta);
		}else{
			$arr_respuesta = array(
				"status" => false,
				//"sql" => $sql,
				"data" => [],
				"message" => "Error en la transacción..."
			);
			echo json_encode($arr_respuesta);
		}
	}else{
		$arr_respuesta = array(
			"status" => false,
			"data" => [],
			"message" => "Debe llenar los campos obligadsadsasdatorios........"
		);
		echo json_encode($arr_respuesta);
	}	
}



function Situacion_Segmento($codigo,$area,$sit){
   $ClsArea = new ClsArea();
   if($codigo != "" && $area){
	$sql = $ClsArea->cambia_sit_segmento($codigo,$area,$sit);
	$rs =  $ClsArea->exec_sql($sql);
	if($rs == 1){
	  $arr_respuesta = array(
		  "status" => true,
		  "data" => [],
		  "message" => "Cambio de situacion realiado satisfactoriamente...!"
	  );
	  echo json_encode($arr_respuesta);
	}else{
		$arr_respuesta = array(
			"status" => false,
			//"sql" => $sql,
			"data" => [],
			"message" => "Error en la transacción..."
		);
		echo json_encode($arr_respuesta);
	}
	}else{
	$arr_respuesta = array(
		"status" => false,
		"data" => [],
		"message" => "Debe llenar los campos obligatorios..."
	);
	echo json_encode($arr_respuesta);
	}
}


?>  