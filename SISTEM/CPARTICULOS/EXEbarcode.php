<?php
	include_once('xajax_funct_articulos.php');
	$usuario = $_SESSION['codigo'];
	$nombre = $_SESSION["nombre"];
?>
<!DOCTYPE html>
<html lang="es">
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
    
    <!-- CSS Propio -->
    <link rel="stylesheet" href="../assets.3.6.2/css/hojaElectronica.css" type="text/css" media="screen"/>

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
<?php
	
	$sql = "";
	
	/// Servicios (S) ///
	$ClsSer = new ClsServicio();
	$result = $ClsSer->get_servicio("","");
	if(is_array($result)){
		foreach($result as $row){
			$ser = $row["ser_codigo"];
			$gru = $row["gru_codigo"];
			$X1 = Agrega_Ceros($ser);
			$X2 = Agrega_Ceros($gru);
			$barc = "S".$X1."S".$X2;
			//--
			$sql.="UPDATE inv_servicio SET ser_barcode = '$barc' WHERE ser_codigo = $ser AND ser_grupo = $gru;";
		}
	}
	
	/// Suministros � Insumos (I) ///
	$ClsSum = new ClsSuministro();
	$result = $ClsSum->get_articulo("","");
	if(is_array($result)){
		foreach($result as $row){
			$art = $row["art_codigo"];
			$gru = $row["gru_codigo"];
			$X1 = Agrega_Ceros($art);
			$X2 = Agrega_Ceros($gru);
			$barc = "U".$X1."U".$X2;
			//--
			$sql.="UPDATE inv_articulo_suministro SET art_barcode = '$barc' WHERE art_codigo = $art AND art_grupo = $gru;";
		}
	}
	
	/// Articulos para venta (A) ///
	$ClsArt = new ClsArticulo();
	$result = $ClsArt->get_articulo("","");
	if(is_array($result)){
		foreach($result as $row){
			$art = $row["art_codigo"];
			$gru = $row["gru_codigo"];
			$X1 = Agrega_Ceros($art);
			$X2 = Agrega_Ceros($gru);
			$barc = "A".$X1."A".$X2;
			//--
			$sql.="UPDATE inv_articulo SET art_barcode = '$barc' WHERE art_codigo = $art AND art_grupo = $gru;";
		}
	}
	
	//$respuesta->alert("$sql");
	$rs = $ClsArt->exec_sql($sql);
	if($rs == 1){
		$msj = "Barcodes actualizados satisfactoriamente!";
		$status = 1;
	}else{
		$msj = "Error en la ejecuci�n...";
		$status = 0;
	}	
	
?>
	<!-- //////////////////////////////////////////////////////// -->
    <script type='text/javascript' >
		function mensaje(status){
			switch(status){
				case 1: status = 'success'; titulo = "Excelente!"; break;
				case 0: status = 'error'; titulo = "Error..."; break;
			}
			var msj = '<?php echo $msj; ?>';
			//-----
			swal(titulo, msj, status).then((value)=>{ window.location = '../menu.php'; });
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',1000);
	</script>
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/inventario/articulo.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
</body>

</html>
