<?php
include_once('html_fns_hijos.php');

///////////// A CARPETAS //////////////////////
// obtenemos los datos del archivo
    $tamano = $_FILES["imagen"]['size'];
    $archivo = $_FILES["imagen"]['name'];
	$cui = $_REQUEST['cui'];
	
	// Upload
	if($archivo != "") {
        $ClsAlu = new ClsAlumno();
		$ultimaFoto = $ClsAlu->last_foto_alumno($cui);
		$stringFoto = str_shuffle($cui.uniqid());
		$sql = $ClsAlu->cambia_foto($cui,$stringFoto);
		$rs = $ClsAlu->exec_sql($sql);
		
		// guardamos el archivo a la carpeta files
		$destino =  "../../CONFIG/Fotos/ALUMNOS/".$stringFoto.".jpg";
		if (move_uploaded_file($_FILES['imagen']['tmp_name'],$destino)) {
			$msj = "Imagen <b>$archivo</b> subido como $nombre<br> Carga Exitosa...!" ; $status = 1;
			//////////// -------- Convierte todas las imagenes a JPEG
			$mime_type = mime_content_type($destino);
			//Valida si es un PNG
			if($mime_type == "image/png"){
				$imagen = imagecreatefrompng($destino); // si es, convierte a JPG
				imagejpeg($imagen,$destino,100); // Creamos la Imagen JPG a partir de la PNG u otra que venga
			}
			///eliminamos la anterior
			if(file_exists("../../CONFIG/Fotos/ALUMNOS/".$ultimaFoto.".jpg")){
				unlink("../../CONFIG/Fotos/ALUMNOS/".$ultimaFoto.".jpg");
			}
            ///respuesta
			$arr_respuesta = array(
				"status" => true,
				"data" => [],
				"message" => "Fotografía actualizada satisfactoriamente!!!"
			);
			echo json_encode($arr_respuesta);
			return;
        
		} else {
			$msj = "Error al subir el archivo"; $status = 0;
			$arr_respuesta = array(
				"status" => false,
				"data" => [],
				"message" => "Error en la transacción, hubo un problema al subir el archivo..."
			);
			echo json_encode($arr_respuesta);
			return;
		}
	}else{
		$arr_respuesta = array(
			"status" => false,
			"data" => [],
			"message" => "Error en la transacción, archivo vacio..."
		);
		echo json_encode($arr_respuesta);
		return;
	}
	
?>