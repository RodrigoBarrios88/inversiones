<?php
include_once('html_fns_img.php');

///////////// A CARPETAS //////////////////////
// obtenemos los datos del archivo
    $tamano = $_FILES["imagen"]['size'];
    $archivo = $_FILES["imagen"]['name'];
	$cui = $_REQUEST['cui'];
	
	// Upload
	if($archivo != "") {
		// guardamos el archivo a la carpeta files
		$destino =  "../../CONFIG/Fotos/ALUMNOS/".$cui.".jpg";
		if (move_uploaded_file($_FILES['imagen']['tmp_name'],$destino)) {
			$msj = "Imagen <b>$archivo</b> subido como $nombre<br> Carga Exitosa...!" ; $status = 1;
			$url = "FRMficha.php?hashkey=$hashkey";
			//--
			$selloAgua = '../../CONFIG/images/sello_agua.png';
			list($wBase, $hBase) = getimagesize($destino);
			list($wSello, $hSello) = getimagesize($selloAgua);
			$dest_image = imagecreatetruecolor($wBase, $hBase);
			imagesavealpha($dest_image, true);
			$trans_background = imagecolorallocatealpha($dest_image, 0, 0, 0, 127);
			imagefill($dest_image, 0, 0, $trans_background);
			$a = imagecreatefrompng($destino);
			$b = imagecreatefrompng($selloAgua);
			imagecopy($dest_image, $a, 0, 0, 0, 0, $wBase, $hBase);
			imagecopy($dest_image, $b, 100, 100, 0, 0, $wSello, $hSello);
			imagejpeg($dest_image, $destino);
			//////////// -------- Convierte todas las imagenes a JPEG
			// Abrimos una Imagen PNG
			$imagen = imagecreatefrompng($destino);
			// Creamos la Imagen JPG a partir de la PNG u otra que venga
			imagejpeg($imagen,$destino,100);
		} else {
			$msj = "Error al subir el archivo"; $status = 0;
		}
	}else{
		$msj = "Archivo vacio.";  $status = 0;
	}
	
?>