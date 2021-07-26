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

	$directorio = '../../CONFIG/Fotos/ALUMNOS';
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
				if($imagen[1] == "jpg" || $imagen[1] == "jpeg" || $imagen[1] == "png" || $imagen[1] == "gif" ){
					//////////// -------- Convierte todas las imagenes a JPEG
					// Abrimos una Imagen PNG
					$origen = $directorio."/".$value;
					$destino = $directorio."/".$imagen[0].".jpg";
					$origen = imagecreatefrompng($origen);
					// Creamos la Imagen JPG a partir de la PNG u otra que venga
					imagejpeg($origen,$destino,100);
					echo $destino."<br>";
				}
				$i++;
			}
		}
    }
	echo "<br><br><b>Total: $i imagenes...</b>"
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