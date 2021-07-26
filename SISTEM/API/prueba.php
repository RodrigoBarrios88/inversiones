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
///API REQUEST

	$album = $_REQUEST['album'];
	$data = $_REQUEST['image'];
	
	if($album != ""){
		$data = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAYAAAAECAYAAACtBE5DAAAAb0lEQVQImQFkAJv/ANTAu/+9pZ//wKSs/8G1vP/Dwrn/taum/wC9p5P/q4OA/4Zmdv+se4L/vJR4/4JyUf8AX1dL/4BQaP9fRWj/tF54/7hiW/+AalH/AFk7SP9uUYH/blSA/8Bhgv/BfY7/m4+T/9uoPoXpeveSAAAAAElFTkSuQmCC';
		$data = str_replace('data:image/png;base64,', '', $data);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data);
		
		$im = imagecreatefromstring($data);
		if ($im !== false) {
			$imagen = str_shuffle($album.uniqid()).".png";
			$resp = imagepng($im, "../../CONFIG/Fotos/PHOTO/$imagen");
			// frees image from memory
			imagedestroy($im);
			//-------------------------------------------------------
			$ClsPho = new ClsPhoto();
			$sql.= $ClsPho->insert_imagen($album,$imagen); /// Inserta Foto
			$rs = $ClsPho->exec_sql($sql);
			if($rs == 1){
				$arr_data = array(
					"status" => "success",
					"message" => "imagen cargada exitosamente..."
				);
				echo json_encode($arr_data);
			}else{
				$arr_data = array(
					"status" => "error",
					"message" => "existió un problema con el registro en base de datos..."
				);
				echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "la imagen no pudo ser cargada"
			);
			echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "El código de el album viene vacio..."
		);
		echo json_encode($arr_data);
	}
?>