<?php
	include_once('xajax_funct_boleta.php');
	require_once("../../CONFIG/constructor.php"); //--correos
	require_once("../recursos/mandrill/src/Mandrill.php"); //--correos
	//////////////////////// CREDENCIALES DE COLEGIO
	require_once ("../Clases/ClsRegla.php");
	$ClsReg = new ClsRegla();
	$result = $ClsReg->get_credenciales();
	if(is_array($result)){
		foreach($result as $row){
			$colegio_nombre = utf8_decode($row['colegio_nombre']);
		}
	}
   ////////////////
	
	/// COLEGIO
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	
	////////////--------////////////
	$hashkey = $_REQUEST["hashkey"];
	$ClsAlu = new ClsAlumno();
	$cui = $ClsAlu->decrypt($hashkey, $id);
	$result = $ClsAlu->get_alumno($cui,"","",1);
	if(is_array($result)){
		foreach($result as $row){
			$nombre_alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
		}
	}
	
	$ClsAsig = new ClsAsignacion();
	$result = $ClsAsig->get_alumno_padre('',$cui);
	if(is_array($result)){
		$i = 0;
		$to = array();
		foreach($result as $row){
			$receptor["name"] = '';
			$receptor["email"] = trim($row["pad_mail"]);
			//$receptor["email"] = 'manuelsa@farasi.com.gt';
			$receptor["type"] = 'to';
			$to[$i] = $receptor;
			$i++;
		}
		$i--; //quita una vuelta para cuadrar
		$padres = $i;
	}
	
	// Instancia el API KEY de Mandrill
	$mandrill = new Mandrill('kwBB4mXd5D3Jf1Ki3y1KYA');
	//--
	// Create the email and send the message
	$subject = trim("Hola, $colegio_nombre te informa!");
	$texto = "Han generado las boletas de pago para el nuevo ciclo escolar.<br><br> Aqui estan los detalles:<br>";
	$texto.= "Se han generado las boletas de pago para el nuevo ciclo escolar, las puedes revisar en el modulo de pagos del portal de padres!";
	$texto.= "<br><br>Que pases un feliz dia!!!";
	
	$html = mail_constructor($subject,$texto);
  
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
		 $msj = "($padres) correos enviados satisfactoriamente!";
	} catch(Mandrill_Error $e) { 
		//echo "<br>";
		//print_r($e);
		//devuelve un mensaje de manejo de errores
		$status =  0;
		$msj = "Ocurrio un error al enviar el correo, por favor espere un momento e intente de nuevo.";
	}         
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
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
	<!-- //////////////////////////////////////////////////////// -->
	 <script type='text/javascript' >
		function mensaje(status){
			switch(status){
				case 1: status = 'success'; titulo = "Excelente!"; break;
				case 0: status = 'error'; titulo = "Error..."; break;
			}
			var msj = '<?php echo $msj; ?>';
			//-----
			swal(titulo, msj, status).then((value)=>{ window.close(); });
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',500);
	 </script>
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/configuracion.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
    
</body>

</html>