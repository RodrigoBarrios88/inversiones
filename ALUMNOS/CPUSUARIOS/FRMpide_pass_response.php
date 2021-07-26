<?php
	include_once('xajax_funct_usuarios.php');
	require_once("../../CONFIG/constructor.php"); //--correos
	$tipo = $_REQUEST['tipo'];
	$mail = $_REQUEST['email'];
	
	//////////////////////// CREDENCIALES DE COLEGIO
	require_once ("../Clases/ClsRegla.php");
	$ClsReg = new ClsRegla();
	$result = $ClsReg->get_credenciales();
	if(is_array($result)){
	   foreach($result as $row){
		  $colegio_nombre = utf8_decode($row['colegio_nombre']);
			$colegio_nombre_titulo = utf8_decode($row['cliente_nombre_reporte']);
	   }
	}
	$colegio_nombre = depurador_texto($colegio_nombre);
	$colegio_nombre_titulo = depurador_texto($colegio_nombre_titulo);
	////////////////
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ayuda</title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	<!-- Bootstrap Core CSS -->
    <link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />
    
    <!-- libraries -->
    <link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.5.20/css/formulario.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.assets.3.5.20/js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
</head>
<body>	
	<?php
	if($mail != ""){
		$ClsUsu = new ClsUsuario();
		$result = $ClsUsu->get_usuario('','',$mail);
		if(is_array($result)){
			foreach($result as $row){
				$nombre = $row["usu_nombre"];
				$seguridad = $row["usu_seguridad"];
				$situacion = $row["usu_situacion"];
				//--
				$usu = $row["usu_usuario"];
				$pass = $row["usu_pass"];
				$pass = $ClsUsu->decrypt($pass, $usu); //desencripta el password
			}
			if($situacion == 1){
				if($seguridad == 0){
					$mensaje_error = "";
					$status = 1;
				}else{
					$mensaje_error = "Su usuario se encuentra bloqueado, por favor contacte al administrador.";
					$status = 0;
				}
			}else{
				$mensaje_error = "Su usuario se encuentra inactivo.";
				$status = 0;
			}
			// Instancia el API KEY de Mandrill
			$mandrill = new Mandrill('kwBB4mXd5D3Jf1Ki3y1KYA');
			//--
			// Create the email and send the message
			$to = array(
				array(
					'email' => "$mail",
					'name' => "$nombre",
					'type' => 'to'
				)
			);
			/////////////_________ Correo a admin
			$subject = "Tu Password";
			$cuerpo = "Has recibido un nuevo mensaje desde el Sistema ASMS de $colegio_nombre. <br><br>"."Aqui estan los detalles:<br><br>Estimado(a) $nombre<br> $mensaje_error<br>E-mail: $mail<br>Usuario: $usu<br>Password: $pass<br><br>Que pases un feliz dia!!!";
			$html = mail_constructor($subject, $cuerpo);
			try{
    
				$message = array(
					'subject' => $subject,
					'html' => $html,
					'from_email' => 'noreply@inversionesd.com',
					'to' => $to
				 );
				 
				//print_r($message);
				//echo "<br>";
				$result = $mandrill->messages->send($message);
				$status = 1;
					
			} catch(Mandrill_Error $e) { 
				//echo "<br>";
				//print_r($e);
				$mensaje_error = "Su mensaje no ha podido ser entregado en este momento, lo sentimos...";
				$status = 0;
			}         
		}else{
			$mensaje_error = "Este correo no esta registrado en el sistema, por favor contacte al administrador...";
			$status = 0;
		}
	}else{
		$mensaje_error = "El Correo va vacio...";
		$status = 0;
	}
	?>
    <!-- //////////////////////////////////////////////////////// -->
    <script type='text/javascript' >
		function mensaje(status){
			if(status == 1){
				swal("Ok!", "Su solicitud esta siendo procesada, en unos minutos recibira un e-mail con su Usuario y Contrase\u00F1a al correo registrado...", "success").then((value)=>{ window.history.back(); });
			}else{
				swal("Ohoo!", "<?php echo $mensaje_error; ?>", "error").then((value)=>{ window.history.back(); });
			}
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',500);
	</script>	
    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/assets.3.5.20/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.5.20/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/seguridad/usuario.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/core/util.js"></script>
    
</body>
</html>
