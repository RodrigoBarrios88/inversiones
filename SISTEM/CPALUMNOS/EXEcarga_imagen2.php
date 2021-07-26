<?php
	include_once('xajax_funct_alumno.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//--
	$ClsAlu = new ClsAlumno();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	<!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Sweet Alert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
	
<?php
// obtenemos los datos del archivo
   // Fecha del Sistema
	$tamano = $_FILES["doc"]['size'];
	$tipo = $_FILES["doc"]['type'];
	$archivo = $_FILES["doc"]['name'];
	$nombre = $_REQUEST["nom"];
	$hashkey = $_REQUEST["hashkey"];
	// Upload
		if ($archivo != "") {
			$ultimaFoto = $ClsAlu->last_foto_alumno($nombre);
			$stringFoto = str_shuffle($nombre.uniqid());
			$sql = $ClsAlu->cambia_foto($nombre,$stringFoto);
			$rs = $ClsAlu->exec_sql($sql);
			// guardamos el archivo a la carpeta files
			$destino =  "../../CONFIG/Fotos/ALUMNOS/".$stringFoto.".jpg";
			if (move_uploaded_file($_FILES["doc"]['tmp_name'],$destino)) {
				$msj = "Imagen $archivo subido exitosamente...!" ; $status = 1;
				$url = "FRMficha.php?hashkey=$hashkey";
				//////////// -------- Convierte todas las imagenes a JPEG
				// Abrimos una Imagen PNG
				$mime_type = mime_content_type($destino);
				//Valida si es un PNG
				if($mime_type == "image/png"){
					$imagen = imagecreatefrompng($destino); // si es, convierte a JPG
					imagejpeg($imagen,$destino,100); // Creamos la Imagen JPG a partir de la PNG u otra que venga
				}
				///eliminamos la anterior
				unlink("../../CONFIG/Fotos/ALUMNOS/".$ultimaFoto.".jpg");
			} else {
				$msj = "Error al subir el archivo"; $status = 0;
				$url = "FRMficha.php?hashkey=$hashkey";
			}
		} else {
			$msj = "Archivo vacio.";  $status = 0;
			$url = "FRMficha.php?hashkey=$hashkey";
		}
 
?>    
    <!-- Modal -->
    <script type='text/javascript' >
		function mensaje(status){
			var msj = '<?php echo $msj; ?>';
			//-----
			if(status === 1){
				swal("Excelete!", "<?php echo $msj; ?>", "success").then((value)=>{ window.location.assign("FRMeditfoto.php?hashkey=<?php echo $hashkey; ?>"); });
			}else{
				swal("Erorr", "<?php echo $msj; ?>", "error").then((value)=>{ window.history.back(); });
			}
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',500);
	</script>
	
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/seguridad/usuario.js"></script>
    
</body>

</html>