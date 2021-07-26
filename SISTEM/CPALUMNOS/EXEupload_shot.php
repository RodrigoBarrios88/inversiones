<?php
include_once('xajax_funct_alumno.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//--
///////////// A CARPETAS //////////////////////
// obtenemos los datos del archivo
    // Fecha del Sistema
	$tamano = $_FILES["imagen"]['size'];
    $tipo = $_FILES["imagen"]['type'];
    $archivo = $_FILES["imagen"]['name'];
	$cui = $_REQUEST['cui'];
	// Upload
		if ($archivo != "") {
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
				// Abrimos una Imagen PNG
				$imagen = imagecreatefrompng($destino);
				// Creamos la Imagen JPG a partir de la PNG u otra que venga
				imagejpeg($imagen,$destino,100);
				///eliminamos la anterior
				unlink("../../CONFIG/Fotos/ALUMNOS/".$ultimaFoto.".jpg");
			} else {
				$msj = "Error al subir el archivo"; $status = 0;
			}
		} else {
			$msj = "Archivo vacio.";  $status = 0;
		}
		
		echo $msj;
?>