<?php
	include_once('html_fns_perfil.php');
	
// obtenemos los datos del archivo
    // Fecha del Sistema
	$tamano = $_FILES["doc"]['size'];
	$tipo = $_FILES["doc"]['type'];
	$archivo = $_FILES["doc"]['name'];
	$usuario = $_REQUEST["codigo"];
	// Upload
		if ($archivo != "") {
			$ClsUsu = new ClsUsuario();
			$ultimaFoto = $ClsUsu->last_foto_usuario($usuario);
			$stringFoto = str_shuffle($usuario.uniqid());
			$sql = $ClsUsu->cambia_foto($usuario,$stringFoto);
			$rs = $ClsUsu->exec_sql($sql);
			
			// guardamos el archivo a la carpeta files
			$destino =  "../../CONFIG/Fotos/USUARIOS/".$stringFoto.".jpg";
			if (move_uploaded_file($_FILES['doc']['tmp_name'],$destino)) {
				$msj = "Imagen $archivo subida exitosamente...!" ; $status = 1;
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
				$url = "FRMfoto.php";
			}
		} else {
			$msj = "Archivo vacio.";  $status = 0;
			$url = "FRMfoto.php";
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	
	<!-- Sweet Alert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.assets.3.5.20/js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
    <!-- //////////////////////////////////////////////////////// -->
    <script type='text/javascript' >
		function mensaje(status){
			var msj = '<?php echo $msj; ?>';
			//-----
			if(status === 1){
				swal("Excelete!", "<?php echo $msj; ?>", "success").then((value)=>{ window.history.back(); });
			}else{
				swal("Erorr", "<?php echo $msj; ?>", "error").then((value)=>{ window.history.back(); });
			}
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',500);
	</script>
	
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/assets.3.5.20/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script type="text/javascript" src="../assets.3.5.20/js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/perfil/perfil.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
    
</body>
</html>