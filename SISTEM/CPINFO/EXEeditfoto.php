<?php
include_once('html_fns_alumno.php');

///////////// A CARPETAS //////////////////////
// obtenemos los datos del archivo
    $tamano = $_FILES["imagen"]['size'];
    $archivo = $_FILES["imagen"]['name'];
	$nombre = $_REQUEST["nombre"];
	$sello = $_REQUEST["sello"];
	
	// Upload
	if($archivo != "") {
		// guardamos el archivo a la carpeta files
		$destino =  "../../CONFIG/Actividades/".$nombre;
		if(move_uploaded_file($_FILES['imagen']['tmp_name'],$destino)) {
			$msj = "Imagen <b>$archivo</b> subido como $nombre<br> Carga Exitosa...!" ; $status = 1;
			if($sello == 1){
				$selloAgua = '../../CONFIG/images/sello_agua.png';
				///medidas de imagenes
				list($wBase, $hBase) = getimagesize($destino);
				$margen_dcho = $wBase*0.05; // margen derecho del 5% del ancho de la foto
				$margen_inf = $wBase*0.05; // margen inferior del 5% del ancho de la foto
				list($sx, $sy) = getimagesize($selloAgua);
				$dest_image = imagecreatetruecolor($wBase, $hBase);
				//--
				imagesavealpha($dest_image, true);
				$trans_background = imagecolorallocatealpha($dest_image, 0, 0, 0, 127);
				imagefill($dest_image, 0, 0, $trans_background);
				$a = imagecreatefrompng($destino);
				$b = imagecreatefrompng($selloAgua);
				imagecopy($dest_image, $a, 0, 0, 0, 0, $wBase, $hBase);
				imagecopy($dest_image, $b, $wBase - $sx - $margen_dcho, $hBase - $sy - $margen_inf, 0, 0, $sx, $sy);
				imagepng($dest_image, $destino, 0,NULL);
			}
		} else {
			$msj = "Error al subir el archivo"; $status = 0;
		}
	}else{
		$msj = "Archivo vacio.";  $status = 0;
	}
	
?>