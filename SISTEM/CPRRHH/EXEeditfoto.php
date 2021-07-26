<?php
include_once('html_fns_rrhh.php');

///////////// A CARPETAS //////////////////////
// obtenemos los datos del archivo
    $tamano = $_FILES["imagen"]['size'];
    $archivo = $_FILES["imagen"]['name'];
	$cui = $_REQUEST['cui'];
	//--
	$ClsAlu = new ClsAlumno();
	// Upload
	if ($archivo != "") {
		$destino =  "../../CONFIG/Fotos/RRHH/$cui.jpg";
		if (move_uploaded_file($_FILES['imagen']['tmp_name'],$destino)) {
			$msj = "Imagen <b>$archivo</b> subido como $nombre<br> Carga Exitosa...!" ; $status = 1;
			
			if($tipo != 'image/jpeg' || $tipo != 'image/png'){
				//////////// -------- Convierte todas las imagenes a JPEG
				// Abrimos una Imagen PNG
				$imagen = imagecreatefrompng($destino);
				if($imagen){
					// Creamos la Imagen JPG a partir de la PNG u otra que venga
					imagejpeg($imagen,$destino,100);
				}
			}
			
		} else {
			$msj = "Error al subir el archivo"; $status = 0;
		}
	} else {
		$msj = "Archivo vacio.";  $status = 0;
	}
	
?>