<?php
	include_once('html_fns_temporal.php');
	$nombre = $_SESSION["nombre"];
	$tipo = $_SESSION["nivel"];
	$valida = $_SESSION["GRP_GPADMIN"];
	
if($tipo != "" && $nombre != ""){	
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
	
	$ClsUsu = new ClsUsuario();
	$directorio = '../../CONFIG/Fotos/USUARIOS/';
	$ficheros  = scandir($directorio);
	$i = 0;
	foreach ($ficheros as $key => $value){
		if (!in_array($value,array(".",".."))){
			if (is_dir($directorio . DIRECTORY_SEPARATOR . $value)){
				//echo dirToArray($directorio . DIRECTORY_SEPARATOR . $value)."<br>";
				//echo "directorio <br>";
			}else{
				//echo $value."<br>";
				$imagen = explode(".",$value);
				$codigo = $imagen[0];
				$ultimaFoto = $ClsUsu->last_foto_usuario($codigo);
				$stringFoto = str_shuffle($codigo.uniqid());
				$sql = $ClsUsu->cambia_foto($codigo,$stringFoto);
				$rs = $ClsUsu->exec_sql($sql);
				rename ($directorio.$codigo.".jpg", $directorio.$stringFoto.".jpg");
				//////////// -------- Convierte todas las imagenes a JPEG
				$destino = $directorio.$stringFoto.".jpg";
				// Abrimos una Imagen PNG
				$imagen = imagecreatefrompng($destino);
				// Creamos la Imagen JPG a partir de la PNG u otra que venga
				imagejpeg($imagen,$destino,100);
				//--
				$i++;
			}
		}
    }
	
	echo "<br><br><b>Total: $i imagenes renombradas...</b>"
?>
    
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/seguridad/usuario.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
    
</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>