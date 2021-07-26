<?php 
//inclu�mos las clases
include_once("html_fns_area.php");

$request = $_REQUEST["request"]; 
switch($request){
	case "getSegmentos":
		$codigo = '';
		$area = $_REQUEST["area"];
		get_segmentos($codigo,$area);
	break;
	case "tabla":
		get_tabla();
		break;
	case "grabarArea":
		$nom = $_REQUEST["nom"];
		$periodo = $_REQUEST["perio"];
		$anio = $_REQUEST["anio"];
		Grabar_Area($nom,$periodo,$anio);
		break;
	case "buscarArea":
		$cod = $_REQUEST["codigo"];
		Buscar_Area($cod);
		break;
	case "modificarArea":
		$cod = $_REQUEST["codigo"];
		$nom = $_REQUEST["nom"];
		$periodo = $_REQUEST["periodo"];
		$anio = $_REQUEST["anio"];
		Modificar_Area($cod,$nom,$periodo,$anio);
		break;
	case "situacionArea":
		$grupo = $_REQUEST["codigo"];
		$sit = $_REQUEST["situacion"];
		Situacion_Area($grupo,$sit);
		break;						
	default:
		$arr_respuesta = array(
			"status" => false,
			"data" => [],
			"message" => "Seleccione un metodo..."
		);
		//echo json_encode($arr_respuesta);
}

//////////////////---- TABLA -----/////////////////////////////////////////////
function get_tabla(){ 
	$ClsArea = new ClsArea();
	$result = $ClsArea->get_area('','','','',1);
	if(is_array($result)){
		$arr_respuesta = array(
			"status" => true,
			"tabla" => tabla_areas(),
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
function Grabar_Area($nom,$periodo,$anio){
   //instanciamos el objeto para generar la respuesta con ajax
   $ClsArea = new ClsArea();
   //pasa a mayusculas
		$nom = trim($nom);
		$periodo = trim($periodo);
		$anio = trim($anio);
	//--------
	//decodificaciones de tildes y �'s
		$nom = utf8_encode($nom);
		$periodo = utf8_encode($periodo);
		//--
		$nom = utf8_decode($nom);
		$periodo = utf8_decode($periodo);
	//--------
    if($nom != "" && $periodo != "" && $anio != ""){
		$cod = $ClsArea->max_area();
		$cod++; /// Maximo codigo de Grupo
		$sql = $ClsArea->insert_area($cod,$nom,$periodo,$anio); /// Inserta Empresa
		//$respuesta->alert("$sql");
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


function Buscar_Area($cod){
	$ClsArea = new ClsArea();
	//$respuesta->alert("$codigo");
			$result = $ClsArea->get_area($cod);
			$arr_data = array();
			if(is_array($result)){
				foreach($result as $row){
					$arr_data["codigo"] = trim($row["are_codigo"]);
					$arr_data["nombre"] = trim($row["are_nombre"]);
					$arr_data["periodo"] = trim($row["are_periodo"]);
					$arr_data["anio"] = trim($row["are_anio"]);
					$i++;
				}
				$arr_respuesta = array(
					"status" => true,
					"data" => $arr_data,
					"tabla" => tabla_areas($codigo),
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

function Modificar_Area($cod,$nom,$periodo,$anio){
   $ClsArea = new ClsArea();
   //pasa a mayusculas
		$nom = trim($nom);
		$periodo = trim($periodo);
		$anio = trim($anio);
	//--------
	//decodificaciones de tildes y �'s
		$nom = utf8_encode($nom);
		$periodo = utf8_encode($periodo);
		//--
		$nom = utf8_decode($nom);
		$periodo = utf8_decode($periodo);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
		if($nom != "" && $periodo != "" && $anio != ""){
			$sql = $ClsArea->modifica_area($cod,$nom,$periodo,$anio);
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

function Situacion_Area($area,$sit){
   $ClsArea = new ClsArea();
   if($area != ""){
      $sql = $ClsArea->cambia_sit_area($area,$sit);
      $rs = $ClsArea->exec_sql($sql);
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