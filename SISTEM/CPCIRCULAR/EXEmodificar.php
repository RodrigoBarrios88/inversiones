<?php
	include_once('xajax_funct_circular.php');
	$titulo = $_SESSION["nombre"];
	
if($titulo != ""){	
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
// obtenemos los datos del archivo
    // archivo
    $tamano = $_FILES["documento"]['size'];
    $tipo = $_FILES["documento"]['type'];
    $documento = $_FILES["documento"]['name'];
	// otros parametros
	$codigo = $_REQUEST['codigo'];
	$nombre = $_REQUEST['docname'];
	$documentoold = $_REQUEST['documentoold'];
	// Upload
	if ($documento != "") {
		// guardamos el archivo a la carpeta files
		$destino =  "../../CONFIG/Circulares/$nombre";
		if(move_uploaded_file($_FILES['documento']['tmp_name'],$destino)) {
			$msj = "Documento $documento subido con exito...!" ; $status = 1;
			unlink("../../CONFIG/Circulares/$documentoold");
		}else{
			$msj = "Error al subir el archivo"; $status = 0;
		}
	} else {
		//$msj = "Error al subir el archivo";
		$status = 1;
	}
 
?>    
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
    <script type='text/javascript' >
		function mensaje(status){
			switch(status){
				case 1: status = 'success'; titulo = "Excelente!"; break;
				case 0: status = 'error'; titulo = "Error"; break;
			}
			//-----
			swal({
				title: titulo,
				text:'<?php echo $msj; ?>',
				icon: status,
			}).then((value) => {
				window.location.href = 'FRMmodcircular.php?info=<?php echo $codigo; ?>';
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/app/circular.js"></script>
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