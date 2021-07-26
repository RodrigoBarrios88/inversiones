<?php
	include_once('xajax_funct_perfil.php');
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
	<!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Sweet Alert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
	$nombre = $_SESSION["codigo"];
	//$clase = $_REQUEST['clase'];
	// Upload
		if ($archivo != "") {
			$ClsUsu = new ClsUsuario();
			$ultimaFoto = $ClsUsu->last_foto_usuario($nombre);
			$stringFoto = str_shuffle($nombre.uniqid());
			$sql = $ClsUsu->cambia_foto($nombre,$stringFoto);
			$rs = $ClsUsu->exec_sql($sql);
			
			// guardamos el archivo a la carpeta files
			$destino =  "../../CONFIG/Fotos/USUARIOS/".$stringFoto.".jpg";
			if (move_uploaded_file($_FILES['doc']['tmp_name'],$destino)) {
				$msj = "Imagen $archivo subida exitosamente...!" ; $status = 1;
				//////////// -------- Convierte todas las imagenes a JPEG
				// Abrimos una Imagen PNG
				$imagen = imagecreatefrompng($destino);
				// Creamos la Imagen JPG a partir de la PNG u otra que venga
				imagejpeg($imagen,$destino,100);
				///eliminamos la anterior
				unlink("../../CONFIG/Fotos/USUARIOS/".$ultimaFoto.".jpg");
			}else {
				$msj = "Error al subir el archivo"; $status = 0;
			}
		} else {
			$msj = "Archivo vacio.";  $status = 0;
		}
 
?>    
    <!-- Modal -->
    <script type='text/javascript' >
		function mensaje(status){
			var msj = '<?php echo $msj; ?>';
			//-----
			if(status === 1){
				swal("Excelete!", "<?php echo $msj; ?>", "success").then((value)=>{ window.location.assign("FRMeditfoto.php"); });
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/master/reglas.js"></script>
    
</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>