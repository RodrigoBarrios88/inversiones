<?php
	include_once('xajax_funct_usuarios.php');
	$nombre = $_SESSION["nombre"];
	$nombre_pantalla = $_SESSION["nombre_pantalla"];
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
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>
	
<?php
// Fecha del Sistema
	$fecha = date("Y-m-d H:i:s");
	//-
	$ClsAlu = new ClsAlumno();
	$ClsUsu = new ClsUsuario();
	// ID del Ultimo Usuario
	$id = $ClsUsu->max_usuario();
	$id++; /// Maximo codigo
	echo "<h3>ALUMNOS</h3><br>";
	$result = $ClsAlu->get_alumno('','','',1);
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			$cui = utf8_decode($row["alu_cui"]);
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$mail = trim($row["alu_mail"]);
			$tel = trim($row["alu_emergencia_telefono"]);
			//--
			$mail = (strlen($mail) <= 0)?"$cui.sinmail@asms.gt":$mail;
			$mail = str_replace(" ","_",$mail);
			$pass_claro = "123456";
			//--
			$sql.= $ClsUsu->insert_usuario($id,"$nom $ape","$nom $ape",$mail,$tel,10,$cui,$mail,$pass_claro,1);
			echo $ClsUsu->insert_usuario($id,"$nom $ape","$nom $ape",$mail,$tel,10,$cui,$mail,$pass_claro,1);
			echo "<br>";
			$id++;
			$i++;
		}
		echo "<h5>Total de Alumnos: $i.</h5><br>";
	}
	
	//echo $sql;
	//$rs = $ClsUsu->exec_sql($sql);
	if ($rs == 1) {
		$status = 1;
		$msj = "Usuarios Actualizados satisfactoriamente!!!";
	} else {
		$status = 0;
		$msj = "Error en la transacci\u00F3n...";
	}
	//echo $Ssql;
	
?>
    
    <!-- //////////////////////////////////////////////////////// -->
    <script type='text/javascript' >
		function mensaje(status){
			if(status == 1){
				swal("Excelente!", "<?php echo $msj; ?>", "success" ).then((value)=>{ window.history.back(); });
			}else{
				swal("Ohoo!", "<?php echo $msj; ?>", "error").then((value)=>{ window.history.back(); });
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