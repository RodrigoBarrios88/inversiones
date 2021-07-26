<?php
	include_once('html_fns_tarea.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo = $_SESSION["nivel"];
	
if($id != "" && $nombre != ""){ 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	<!-- Bootstrap Core CSS -->
    <link href="../css.3.5.18/bootstrap/bootstrap.modify.css" rel="stylesheet" />
	<link href="../css.3.5.18/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />
	<!-- Custom CSS -->
    <link href="../css.3.5.18/lib/shop-item.css" rel="stylesheet">
    
    <!-- libraries -->
    <link href="../css.3.5.18/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link href="../css.3.5.18/lib/font-awesome.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../css.3.5.18/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../css.3.5.18/compiled/elements.css" />
    
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../font-awesome/css/font-awesome.css" rel="stylesheet">
	
	<!-- Sweet Alert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body>
	
<?php
// obtenemos los datos del archivo
    // Fecha del Sistema
	$tamano = $_FILES["archivo"]['size'];
	$tipo = $_FILES["archivo"]['type'];
	$archivo = $_FILES["archivo"]['name'];
	$tarea = $_REQUEST['Filetarea'];
	$alumno = $_REQUEST['Filealumno'];
	$nombre = $_REQUEST['Filenom'];
	$desc = $_REQUEST['Filedesc'];
	$extension = $_REQUEST['Fileextension'];
	$fila = $_REQUEST['fila'];
	// Upload
	//-- mayusculas
	$nombre = strtoupper($nombre);
	$desc = strtoupper($desc);
	$extension = strtolower($extension);
	//-- decodificacion
	$nombre = utf8_encode($nombre);
	$desc = utf8_encode($desc);
    //--
	$nombre = utf8_decode($nombre);
	$desc = utf8_decode($desc);
	//--
	$ClsTar = new ClsTarea();
	$codigo = $ClsTar->max_respuesta_tarea_archivo($tarea,$alumno);
	$codigo++;
	$sql = $ClsTar->insert_respuesta_tarea_archivo($codigo,$tarea,$alumno,$nombre,$desc,$extension);
	$rs = $ClsTar->exec_sql($sql);
	if($rs == 1){
		if ($archivo != "") {
			if ($tamano < 6000000) {
				// guardamos el archivo a la carpeta files
				$destino =  "../../CONFIG/DATALMSALUMNOS/TAREAS/MATERIAS/".$codigo."_".$tarea."_".$alumno.".".$extension;
				if (move_uploaded_file($_FILES['archivo']['tmp_name'],$destino)) {
					$msj = "Archivo $archivo subido exitosamente...!" ; $status = 1;
				}else {
					$msj = "Error al subir el archivo"; $status = 0;
				}
			}else {
				$msj = "Se permiten archivos de 6 Mb m�ximo. $tamano"; $status = 0;
			}
		} else {
			$msj = "Archivo vacio.";  $status = 0;
		}
	}else{
		$msj = "Error de almacenamiento, uno o mas parametros con la base de datos no son compatibles....";  $status = 0;
    }
?>    
    <script type='text/javascript' >
		function mensaje(status){
			switch(status){
				case 1: status = 'success'; titulo = "Excelente!"; break;
				case 0: status = 'error'; titulo = "Error..."; break;
			}
			//-----
			swal({
				title: titulo,
				text:'<?php echo $msj; ?>',
				icon: status,
			}).then((value) => {
				window.history.back();
			});
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',1000);
	</script>

	
    <!-- scripts -->
    <script src="../js/jquery-latest.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-ui-1.10.2.custom.min.js"></script>
	
	<!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../js/modules/lms/tarea.js"></script>
    <script type="text/javascript" src="../js/modules/util.js"></script>
    
</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>