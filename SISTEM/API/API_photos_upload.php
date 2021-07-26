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

$ClsPho = new ClsPhoto();
///API REQUEST

	$album = $_REQUEST['album'];
	if(!empty($_FILES)){
		if($album != ""){
			if (file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {
                $stringFoto = str_shuffle($album.uniqid()).".jpg";
				$destino =  "../../CONFIG/Fotos/PHOTO/$stringFoto";
                if (move_uploaded_file($_FILES['image']['tmp_name'],$destino)) {
					// Abrimos una Imagen PNG
					$mime_type = mime_content_type($destino);
					//Valida si es un PNG
					if($mime_type == "image/png"){
						$imagen = imagecreatefrompng($destino); // si es, convierte a JPG
						imagejpeg($imagen,$destino,100); // Creamos la Imagen JPG a partir de la PNG u otra que venga
					}
					/// redimensionando 
					$image = new ImageResize($destino);
					$image->resizeToWidth(500);
					$image->save($destino);
					///
					$sql.= $ClsPho->insert_imagen($album,$stringFoto); /// Inserta Foto
					$rs = $ClsPho->exec_sql($sql);
					if($rs == 1){
						$arr_data = array(
							"status" => "success",
							"message" => "imagen cargada exitosamente..."
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
						"message" => "existió un problema al cargar la imagen...."
					);
					echo json_encode($arr_data);
				}
				
            }else{
				$arr_data = array(
					"status" => "error",
					"message" => "El archivo puede ir vacio o no es apto para cargarse..."
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
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "No hay imagen a cargar..."
		);
		echo json_encode($arr_data);
	}
?>