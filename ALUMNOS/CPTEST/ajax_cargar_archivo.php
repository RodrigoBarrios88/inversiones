<?php
	include_once('html_fns_examen.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo = $_SESSION["nivel"];
	
if($id != "" && $nombre != ""){ 
	// obtenemos los datos del archivo
    // Fecha del Sistema
	$tamano = $_FILES["archivo"]['size'];
	$tipo = $_FILES["archivo"]['type'];
	$archivo = $_FILES["archivo"]['name'];
	$examen = $_REQUEST['codigo'];
	$alumno = $_REQUEST['alumno'];
	$nombre = $_FILES["archivo"]['name'];
	$desc = $_FILES["archivo"]['name'];
	$extension = $_REQUEST['extension'];
	$extension = str_replace(".", "", $extension); //quita el punto de la extension
	// Upload
	if ($archivo != "") {
		$ClsExa = new ClsExamen();
		$codigo = $ClsExa->max_resolucion_examen_archivo($examen,$alumno);
		$codigo++;
		$sql = $ClsExa->insert_resolucion_examen_archivo($codigo,$examen,$alumno,$nombre,$desc,$extension);
		$rs = $ClsExa->exec_sql($sql);
		if($rs == 1){
			// guardamos el archivo a la carpeta files
			$destino =  "../../CONFIG/DATALMSALUMNOS/TEST/MATERIAS/".$codigo."_".$examen."_".$alumno.".".$extension;
			if (move_uploaded_file($_FILES['archivo']['tmp_name'],$destino)) {
				///respuesta
				$arr_respuesta = array(
					"status" => true,
					"message" => "Archivo cargada satisfactoriamente!!!"
				);
				echo json_encode($arr_respuesta);
				return;
			}else {
				$arr_respuesta = array(
					"status" => false,
					"message" => "Error en la transacción, hubo un problema al subir el archivo..."
				);
				echo json_encode($arr_respuesta);
				return;
			}
		} else {
			$arr_respuesta = array(
				"status" => false,
				"message" => "Error en la transacción... "
			);
			echo json_encode($arr_respuesta);
			return;
		}
	} else {
		$arr_respuesta = array(
			"status" => false,
			"message" => "Error en la transacción, archivo vacio..."
		);
		echo json_encode($arr_respuesta);
		return;
	}

}else{
	$arr_respuesta = array(
		"status" => false,
		"message" => "Error en la transacción, usuario no autenticado..."
	);
	echo json_encode($arr_respuesta);
	return;
}
?>