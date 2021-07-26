<?php
	include_once('xajax_funct_usuarios.php');
	require_once("../recursos/mandrill/src/Mandrill.php"); //--correos
	
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
// Fecha del Sistema
	$fecha = date("Y-m-d H:i:s");
	//-
	$ClsUsu = new ClsUsuario();
	// ID del Ultimo Usuario
	$mandrill = new Mandrill('kwBB4mXd5D3Jf1Ki3y1KYA');
	
	$absolute_url = full_url( $_SERVER );
	$absolute_url = str_replace("/CPUSUARIOS/EXEhabilita_usuarios.php","",$absolute_url);
	$subject = "Bienvenido a ASMS";
	$colegio = $_SESSION["colegio_nombre_reporte"];
	$cuerpo = "El nuevo sistema educativo de $colegio esta activo! un nuevo usuario se ha generado para ti.\n\n"."Aqui estan los detalles:\n\nHaz clcik en el link para activar tu usuario\n\n ";
	
	
	echo "<h3>MAESTROS</h3><br>";
	$result = $ClsUsu->get_usuario('','','',2,'',1);
	if(is_array($result)){
		$i = 1;
		$correos_maestros = 0;
		foreach($result as $row){
			$id = utf8_decode($row["usu_id"]);
			$nom = utf8_decode($row["usu_nombre"]);
			echo $nom."<br>";
			$mail = trim($row["usu_mail"]);
			if($mail != ""){
				$to = array(
					array(
						'email' => $mail,
						'name' => $nombre,
						'type' => 'to'
					)
				);
				$envia =  $cuerpo;
				$hashkey = $ClsUsu->encrypt($id, "clave");
				$envia.= $absolute_url.'/CPVALIDA/FRMactivate.php?hashkey='.$hashkey.' Click para Activar el Usuario';
				$envia.= "\n\nQue pases un feliz dia!!!";
				try{
					$message = array(
						'subject' => $subject,
						'text' => $envia,
						'from_email' => 'noreply@inversionesd.com',
						'to' => $to
					 );
					 
					 //print_r($message);
					 //echo "<br>";
					 $result = $mandrill->messages->send($message);
					 $validacion =  1;
					 $correos_maestros++;
				} catch(Mandrill_Error $e) { 
					//echo "<br>";
					//print_r($e);
					//devuelve un mensaje de manejo de errores
					$validacion =  0;
				}
			}
			$i++;
		}
		$i--;
		$msj = "Total de Maestros: $i.  Correos enviados $correos_maestros.";
	}
	
	
	echo "<h3>AUTORIDADES</h3><br>";
	$result = $ClsUsu->get_usuario('','','',1,'',1);
	if(is_array($result)){
		$i = 1;
		$correos_auto = 0;
		foreach($result as $row){
			$id = utf8_decode($row["usu_id"]);
			$nom = utf8_decode($row["usu_nombre"]);
			$mail = trim($row["usu_mail"]);
			if($mail != ""){
				$to = array(
					array(
						'email' => $mail,
						'name' => $nombre,
						'type' => 'to'
					)
				);
				$envia =  $cuerpo;
				$hashkey = $ClsUsu->encrypt($id, "clave");
				$envia.= $absolute_url.'/CPVALIDA/FRMactivate.php?hashkey='.$hashkey.' Click para Activar el Usuario';
				$envia.= "\n\nQue pases un feliz dia!!!";
				try{
					$message = array(
						'subject' => $subject,
						'text' => $envia,
						'from_email' => 'noreply@inversionesd.com',
						'to' => $to
					 );
					 
					 //print_r($message);
					 //echo "<br>";
					 //$result = $mandrill->messages->send($message);
					 $validacion =  1;
					 $correos_auto++;
				} catch(Mandrill_Error $e) { 
					//echo "<br>";
					//print_r($e);
					//devuelve un mensaje de manejo de errores
					$validacion =  0;
				}
			}
			$i++;
		}
		$i--;
		$msj.= "Total de Autoridades: $i.  Correos enviados $correos_auto.";
	}
	
	
	echo "<h3>USUARIOS ADMINISTRATIVIVOS</h3><br>";
	$result = $ClsUsu->get_usuario('','','',6,'',1);
	if(is_array($result)){
		$i = 1;
		$correos_administrativos = 0;
		foreach($result as $row){
			$id = utf8_decode($row["usu_id"]);
			$nom = utf8_decode($row["usu_nombre"]);
			echo $nom."<br>";
			$mail = trim($row["usu_mail"]);
			if($mail != ""){
				$to = array(
					array(
						'email' => $mail,
						'name' => $nombre,
						'type' => 'to'
					)
				);
				$envia =  $cuerpo;
				$hashkey = $ClsUsu->encrypt($id, "clave");
				$envia.= $absolute_url.'/CPVALIDA/FRMactivate.php?hashkey='.$hashkey.' Click para Activar el Usuario';
				$envia.= "\n\nQue pases un feliz dia!!!";
				try{
					$message = array(
						'subject' => $subject,
						'text' => $envia,
						'from_email' => 'noreply@inversionesd.com',
						'to' => $to
					 );
					 
					 //print_r($message);
					 //echo "<br>";
					 $result = $mandrill->messages->send($message);
					 $validacion =  1;
					 $correos_administrativos++;
				} catch(Mandrill_Error $e) { 
					//echo "<br>";
					//print_r($e);
					//devuelve un mensaje de manejo de errores
					$validacion =  0;
				}
			}
			$i++;
		}
		$i--;
		$msj.= "Total de Administrativos: $i.  Correos enviados $correos_administrativos.";
	}
	
	
	
	echo "<h3>ADMINISTRADORES</h3><br>";
	$result = $ClsUsu->get_usuario('','','',5,'',1);
	if(is_array($result)){
		$i = 1;
		$correos_admin = 0;
		foreach($result as $row){
			$id = utf8_decode($row["usu_id"]);
			$nom = utf8_decode($row["usu_nombre"]);
			echo $nom."<br>";
			$mail = trim($row["usu_mail"]);
			if($mail != ""){
				$to = array(
					array(
						'email' => $mail,
						'name' => $nombre,
						'type' => 'to'
					)
				);
				$envia =  $cuerpo;
				$hashkey = $ClsUsu->encrypt($id, "clave");
				$envia.= $absolute_url.'/CPVALIDA/FRMactivate.php?hashkey='.$hashkey.' Click para Activar el Usuario';
				$envia.= "\n\nQue pases un feliz dia!!!";
				try{
					$message = array(
						'subject' => $subject,
						'text' => $envia,
						'from_email' => 'noreply@inversionesd.com',
						'to' => $to
					 );
					 
					 //print_r($message);
					 //echo "<br>";
					 $result = $mandrill->messages->send($message);
					 $validacion =  1;
					 $correos_admin++;
				} catch(Mandrill_Error $e) { 
					//echo "<br>";
					//print_r($e);
					//devuelve un mensaje de manejo de errores
					$validacion =  0;
				}
			}
			$i++;
		}
		$i--;
		$msj = "Total de Administradores: $i.  Correos enviados $correos_admin.";
	}
	
	$status = 1;
?>
    
    
    <script type='text/javascript' >
		function mensaje(status){
			switch(status){
				case 1: status = 'success'; titulo = "Excelente!"; break;
				case 0: status = 'error'; titulo = "Error..."; break;
			}
			var msj = '<?php echo $msj; ?>';
			//-----
			swal(titulo, msj, status).then((value)=>{ window.location = 'FRMusuarios.php'; });
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',1000);
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