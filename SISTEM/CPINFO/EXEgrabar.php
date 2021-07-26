<?php
	include_once('xajax_funct_info.php');
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
    // archivo
    $tamano = $_FILES["imagen"]['size'];
    $tipo = $_FILES["imagen"]['type'];
    $archivo = $_FILES["imagen"]['name'];
	// otros parametros
	$codigo = $_REQUEST['codigo'];
	$nombre = $_REQUEST['docname'];
	// Upload
	if ($archivo != "") {
		// guardamos el archivo a la carpeta files
		$destino =  "../../CONFIG/Actividades/$nombre";
		if(move_uploaded_file($_FILES['imagen']['tmp_name'],$destino)) {
			$msj = "Imagen $archivo cargada con exito...!" ; $status = 1;
		} else {
			$msj = "Error al subir el archivo"; $status = 0;
		}
	} else {
		$status = 1;
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
			var msj = '<?php echo $msj; ?>';
			//-----
			swal(titulo, msj, status).then((value)=>{ window.location.href = 'FRMeditfoto.php?info=<?php echo $codigo; ?>'; });
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',1000);
	</script>
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/app/informacion.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/reglas.js"></script>
    
</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>