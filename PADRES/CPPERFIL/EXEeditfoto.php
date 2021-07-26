<?php
include_once('html_fns_perfil.php');

///////////// A CARPETAS //////////////////////
// obtenemos los datos del archivo
    $tamano = $_FILES["imagen"]['size'];
    $archivo = $_FILES["imagen"]['name'];
	$usuario = $_SESSION["codigo"];
	
	// Upload
	if($archivo != "") {
		$ClsUsu = new ClsUsuario();
		$ultimaFoto = $ClsUsu->last_foto_usuario($usuario);
		$stringFoto = str_shuffle($usuario.uniqid());
		$sql = $ClsUsu->cambia_foto($usuario,$stringFoto);
		$rs = $ClsUsu->exec_sql($sql);
			
		// guardamos el archivo a la carpeta files
		$destino =  "../../CONFIG/Fotos/USUARIOS/".$stringFoto.".jpg";
		if (move_uploaded_file($_FILES['imagen']['tmp_name'],$destino)) {
			$msj = "Imagen <b>$archivo</b> subido como $nombre<br> Carga Exitosa...!" ; $status = 1;
			//////////// -------- Convierte todas las imagenes a JPEG
			// Abrimos una Imagen PNG
            $mime_type = mime_content_type($destino);
            //Valida si es un PNG
            if($mime_type == "image/png"){
                $imagen = imagecreatefrompng($destino); // si es, convierte a JPG
                imagejpeg($imagen,$destino,100); // Creamos la Imagen JPG a partir de la PNG u otra que venga
            }
			///eliminamos la anterior
			unlink("../../CONFIG/Fotos/USUARIOS/".$ultimaFoto.".jpg");
		} else {
			$msj = "Error al subir el archivo"; $status = 0;
		}
	}else{
		$msj = "Archivo vacio.";  $status = 0;
	}
	
?>