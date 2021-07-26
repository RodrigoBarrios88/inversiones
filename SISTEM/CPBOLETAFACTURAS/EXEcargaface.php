<?php
	include_once('xajax_funct_boleta.php');
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["GRP_GPCONTA"];
	
if($nombre != "" && $valida != ""){	
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
    $tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
    $archivo = $_FILES["archivo"]['name'];
	// otros parametros
	$cuenta = $_REQUEST['cue'];
	$banco = $_REQUEST['ban'];
	// Upload
		if ($archivo != "") {
			if ($tamano < 2000000) {
				// guardamos el archivo a la carpeta files
				$archivo = str_replace(" ","_",$archivo);
				$destino =  "../../CONFIG/FACE/$archivo";
				if (move_uploaded_file($_FILES['archivo']['tmp_name'],$destino)) {
					$msj = "Archivo $archivo Cargado como $archivo, Carga Exitosa...!" ; $status = 1;
				} else {
					$msj = "Error al subir el archivo"; $status = 0;
				}
			}else {
				$msj = "Se permiten archivos de 2 Mb máximo. $tamano"; $status = 0;
			}
		} else {
			$status = 1;
		}
		
		/// Actualiza las fechas de los antecedentes penales y policiacos
		if($status == 1){
			$accion = "window.location='FRMlectorcsv.php?name=$archivo';";
		}else{
			$accion = "window.history.back();";
		}
 
?>    
    <!-- //////////////////////////////////////////////////////// -->
    <!-- //////////////////////////////////////////////////////// -->
	 <script type='text/javascript' >
		function mensaje(status){
			switch(status){
				case 1: status = 'success'; titulo = "Excelente!"; break;
				case 0: status = 'error'; titulo = "Error..."; break;
			}
			var msj = '<?php echo $msj; ?>';
			//-----
			swal(titulo, msj, status).then((value)=>{ <?php echo $accion; ?>; });
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',1000);
	 </script>
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/boleta.js"></script>
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