<?php
	include_once('xajax_funct_rrhh.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["GRP_GPADMON"];
	
if($pensum != "" && $nombre != "" && $valida != ""){	
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
	$tamano = $_FILES["imagen"]['size'];
	$tipo = $_FILES["imagen"]['type'];
	$archivo = $_FILES["imagen"]['name'];
	$nombre = $_REQUEST["nom"];
	$hashkey = $_REQUEST["hashkey"];
	//$clase = $_REQUEST['clase'];
	// Upload
	if ($archivo != "") {
		$destino =  "../../CONFIG/Fotos/RRHH/$nombre.jpg";
		if (move_uploaded_file($_FILES['imagen']['tmp_name'],$destino)) {
			$msj = "Imagen $archivo subido como $nombre, Carga Exitosa...!" ; $status = 1;
			
			if($tipo != 'image/jpeg' || $tipo != 'image/png'){
				//////////// -------- Convierte todas las imagenes a JPEG
				// Abrimos una Imagen PNG
				$imagen = imagecreatefrompng($destino);
				if($imagen){
					// Creamos la Imagen JPG a partir de la PNG u otra que venga
					imagejpeg($imagen,$destino,100);
				}
			}
			
		} else {
			$msj = "Error al subir el archivo"; $status = 0;
		}
	} else {
		$msj = "Archivo vacio.";  $status = 0;
	}
		
	//hash encriptado de codigo para metodo get
	$ClsPer = new ClsPersonal();
	$usu = $_SESSION["codigo"];
	$cat = str_replace("P1", "", $nombre);
	$cat = str_replace("P2", "", $nombre);
	$hashkey = $ClsPer->encrypt($cat, $usu);
	//--
 
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/app/informacion.js"></script>
    
</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>