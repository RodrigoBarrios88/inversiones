<?php 
//inclu�mos las clases
include_once("html_fns_grupos.php");


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
	case "tabla2":
		get_tabla2();
		break;
	case "grabarGrupoClase":
		$nom = $_REQUEST["nom"];
		$area = $_REQUEST["area"];
		$segmento = $_REQUEST["segmento"];
		Grabar_Grupo_Clase($nom,$area,$segmento);
		break;
	case "buscarGrupoClase":
		$codigo = $_REQUEST["codigo"];
		Buscar_Grupo_Clase($codigo);
		break;
	case "modificarGrupoClase":
		$codigo = $_REQUEST["codigo"];
		$nom = $_REQUEST["nom"];
		$area = $_REQUEST["area"];
		$segmento = $_REQUEST["segmento"];
		Modificar_Grupo_Clase($codigo,$nom,$area,$segmento);
		break;
	case "situacionGrupoClase":
		$grupo = $_REQUEST["codigo"];
		$sit = $_REQUEST["situacion"];
		Situacion_Grupo($grupo,$sit);
		break;						
	default:
		$arr_respuesta = array(
			"status" => false,
			"data" => [],
			"message" => "Seleccione un metodo..."
		);
		//echo json_encode($arr_respuesta);
}

///////////// COMBOS /////////


 function get_segmentos($codigo ='',$area){
	$ClsArea = new ClsArea();
	$result = $ClsArea->get_segmento("",$area,"");
	if($area !=''){		
		$arr_respuesta = array(
			"status" => true,			
			"data" => Segmento_html("",$area,""),
			"message" => ""
		);
	}else{
		$arr_respuesta = array(
			"status" => false,
			"data" => [],
			"message" => "Aún no hay datos de areas registrados..."
		);
	}
	echo json_encode($arr_respuesta);



}

 ///////////// TABLA /////////
 
 function get_tabla(){ 
	$ClsGruCla = new ClsGrupoClase();
	$result = $ClsGruCla->get_grupo_clase('','','','',1);
	if(is_array($result)){
		$arr_respuesta = array(
			"status" => true,
			"tabla" => tabla_grupo_clases(),
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

 function get_tabla2(){ 
	$ClsGruCla = new ClsGrupoClase();
	$result = $ClsGruCla->get_grupo_clase('','','','',1);
	if(is_array($result)){
		$arr_respuesta = array(
			"status" => true,
			"tabla" => tabla_grupo_clases2(),
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
//////////////////---- GRUPOS -----/////////////////////////////////////////////
function Grabar_Grupo_Clase($nom,$area,$segmento){
   $ClsGruCla = new ClsGrupoClase();
   //pasa a mayusculas
		$nom = trim($nom);
		$area = trim($area);
		$segmento = trim($segmento);
	//--------
	//decodificaciones de tildes y �'s
		$nom = utf8_encode($nom);
		$area = utf8_encode($area);
		//--
		$nom = utf8_decode($nom);
		$area = utf8_decode($area);
		$segmento = utf8_decode($segmento);
	//--------
    if($nom != "" && $area != "" && $segmento != ""){
		$codigo = $ClsGruCla->max_grupo_clase();
		$codigo++; /// Maximo codigo de Grupo
		$sql = $ClsGruCla->insert_grupo_clase($codigo,$nom,$area,$segmento); /// Inserta Empresa
		//$respuesta->alert("$sql");
		$rs = $ClsGruCla->exec_sql($sql);
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



function Buscar_Grupo_Clase($codigo){
	$ClsGruCla = new ClsGrupoClase();
	//$respuesta->alert("$codigo");

			$result = $ClsGruCla->get_grupo_clase($codigo,"","","");
			$arr_data = array();
			if(is_array($result)){
				foreach($result as $row){
					$arr_data["codigo"] = trim($row["gru_codigo"]);
					$arr_data["nombre"] = trim($row["gru_nombre"]);
					$arr_data["area"] = trim($row["gru_area"]);
					$arr_data["segmento"] = trim($row["gru_segmento"]);
					$i++;
				}
				$arr_respuesta = array(
					"status" => true,
					"data" => $arr_data,
					"tabla" => tabla_grupo_clases($codigo),
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



function Modificar_Grupo_Clase($codigo,$nom,$area,$segmento){
   $ClsGruCla = new ClsGrupoClase();
   //pasa a mayusculas
		$nom = trim($nom);
		$area = trim($area);
		$segmento = trim($segmento);
	//--------
	//decodificaciones de tildes y �'s
		$nom = utf8_encode($nom);
		$area = utf8_encode($area);
		//--
		$nom = utf8_decode($nom);
		$area = utf8_decode($area);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
		if($nom != "" && $area != "" && $segmento != ""){
			$sql = $ClsGruCla->modifica_grupo_clase($codigo,$nom,$area,$segmento);
			$rs = $ClsGruCla->exec_sql($sql);
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



function Situacion_Grupo($grupo,$sit){
   $ClsGruCla = new ClsGrupoClase();
    if($grupo != ""){
      $sql = $ClsGruCla->cambia_sit_grupo_clase($grupo,$sit);
      $rs = $ClsGruCla->exec_sql($sql);
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