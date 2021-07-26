<?php
include_once('html_fns_alumno.php');

///////////// A CARPETAS //////////////////////
// obtenemos los datos del archivo
    $tamano = $_FILES["imagen"]['size'];
    $archivo = $_FILES["imagen"]['name'];
	$cui = $_REQUEST['cui'];
	//--
	$ClsAlu = new ClsAlumno();
	// Upload
	if($archivo != "") {
		$ultimaFoto = $ClsAlu->last_foto_alumno($cui);
		$stringFoto = str_shuffle($cui.uniqid());
		$sql = $ClsAlu->cambia_foto($cui,$stringFoto);
		$rs = $ClsAlu->exec_sql($sql);
		// guardamos el archivo a la carpeta files
		$destino =  "../../CONFIG/Fotos/ALUMNOS/".$stringFoto.".jpg";
		if (move_uploaded_file($_FILES['imagen']['tmp_name'],$destino)) {
			$msj = "Imagen <b>$archivo</b> subido como $nombre<br> Carga Exitosa...!" ; $status = 1;
			$url = "FRMficha.php?hashkey=$hashkey";
			//////////// -------- Convierte todas las imagenes a JPEG
			// Abrimos una Imagen PNG
			$imagen = imagecreatefrompng($destino);
			// Creamos la Imagen JPG a partir de la PNG u otra que venga
			imagejpeg($imagen,$destino,100);
			///eliminamos la anterior
			unlink("../../CONFIG/Fotos/ALUMNOS/".$ultimaFoto.".jpg");
		} else {
			$msj = "Error al subir el archivo"; $status = 0;
		}
	}else{
		$msj = "Archivo vacio.";  $status = 0;
	}
	
?>