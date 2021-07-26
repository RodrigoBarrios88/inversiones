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

$ClsCir = new ClsCircular();
///API REQUEST

	$codigo = $_REQUEST['codigo'];
	if(!empty($_FILES)){
		if($codigo != ""){
			if (file_exists($_FILES['documento']['tmp_name']) || is_uploaded_file($_FILES['documento']['tmp_name'])) {
                $nombre = str_shuffle($codigo.uniqid()).".pdf";
				$destino =  "../..CONFIG/Circulares/$nombre";
                if (move_uploaded_file($_FILES['documento']['tmp_name'],$destino)) {
					$sql.= $ClsCir->modifica_documento($codigo,$nombre); /// Inserta Foto
					$rs = $ClsCir->exec_sql($sql);
					if($rs == 1){
						$arr_data = array(
							"status" => "success",
							"message" => "Archivo cargado exitosamente..."
						);
						echo json_encode($arr_data);
					}else{
						unlink($destino); //elimina carga si hay error...
						$arr_data = array(
							"status" => "error",
							"message" => "existió un problema con el registro en base de datos..."
						);
						echo json_encode($arr_data);
					}
				} else {
					$arr_data = array(
						"status" => "error",
						"message" => "existió un problema al cargar el documento...."
					);
					echo json_encode($arr_data);
				}
				
            } else {
				$arr_data = array(
					"status" => "error",
					"message" => "El documento puede ir vacio o no es apto para cargarse..."
				);
				echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "El código de la actividad viene vacio..."
			);
			echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "No hay documento a cargar..."
		);
		echo json_encode($arr_data);
	}
?>