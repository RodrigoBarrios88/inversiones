<?php
	include_once('xajax_funct_photo.php');
	$nombre = $_SESSION["nombre"];
if($nombre != ""){	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	<?php
		//En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		$xajax->printJavascript("..");
	?>	
	<!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Swal -->
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
// REQUESTS
$album = $_REQUEST['codigo'];
$cantidad = intval($_REQUEST["cuantos"]);
//print_r($_FILES["fotos"]);
//--------
$ClsPho = new ClsPhoto();
$sql = "";
//--
//for($i = 0; $i < $cantidad; $i ++){
//$tamano = $_FILES["fotos"]['size'];
$tamano = $_FILES["fotos"]['size'];
$tipo = $_FILES["fotos"]['type'];
$archivo = $_FILES["fotos"]['name'];
if($album !=""){
	$imagen = str_shuffle($i.$album.uniqid()).".jpg";
	// Upload
	if ($archivo != "") {
		// guardamos el archivo a la carpeta files
		$destino =  "../../CONFIG/Fotos/PHOTO/$imagen";
		if (move_uploaded_file($_FILES['fotos']['tmp_name'],$destino)) {
			$sql.= $ClsPho->insert_imagen($album,$imagen); /// Inserta Foto
			$status = 1;
			//////////// -------- Convierte todas las imagenes a JPEG
			///// CONVIERTE A JPG
			//$foto = imagecreatefrompng($destino);
			//$destino = str_replace(".png", ".jpg", $destino);
			//echo $destino."<br>";
			//imagejpeg($foto,$destino,100); 
		} else {
			$msj_err = "Error al subir el archivo"; $status = 0;
			//break;
		}
	} else {
		$msj_err = "Archivo vacio.";  $status = 0;
		//break;
	}
}else{
	$msj_err = 'Error de Traslado de Datos, refresque la pagina e intente de nuevo...';
	$status = 0;
	//break;
}
//}

if($status == 1){
	//echo $sql;
	$rs = $ClsPho->exec_sql($sql);
	if($rs == 1){
		$usu = $_SESSION["codigo"];
		$hashkey = $ClsPho->encrypt($album, $usu);
		$msj = 'Photo Album publicado exitosamente!!!';
		$status = 1;
	}else{
		$usu = $_SESSION["codigo"];
		$hashkey = $ClsPho->encrypt($album, $usu);
		$msj = 'Error en la transacci\u00F3n...';
		$msj.= '\n'.$msj_err;
		$status = 0;
	}
}else{
	$msj = $msj_err;
	$status = 0;
}
	
?>
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
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
				window.location.href = 'FRMdetalle.php?hashkey=<?php echo $hashkey; ?>';
			});
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',500);
	</script>
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/app/photo.js"></script>
 
</body>

</html>

<?php	
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>