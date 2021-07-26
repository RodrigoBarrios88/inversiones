<?php
	include_once('html_fns_push.php');
	
	$mensaje = utf8_encode(utf8_decode($_REQUEST["mensaje"]));
	$user_id = $_REQUEST['user_id'];
	$device_id = $_REQUEST['device_id'];

	$ClsPush = new ClsPushup();

	$result = $ClsPush->get_push_user($user_id,'','',$device_id);
	if(is_array($result)) {
		foreach ($result as $row){
			$user_id = $row["user_id"];
			$device_type = $row["device_type"];
			$device_token = $row["device_token"];
			$certificate_type = $row["certificate_type"];
		}
		$title = 'Prueba';
		$message = $mensaje;
		$push_tipo = 100;
		$item_id = '';
		$cert_path = '../../CONFIG/push/ck_prod.pem';
		$data = array(
            'landing_page'=> 'page',
            'codigo' => $item_id
        );
		//--
		$sql = $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id);
		$rs = $ClsPush->exec_sql($sql);
		if($rs == 1){
			echo "user_id: $user_id <br>";
			echo "device_id: $device_id <br>";
			echo "<hr>";
			//cuenta las notificaciones pendientes
			$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
			//--
			$data = array(
			   'landing_page'=> 'general',
			   'codigo' => $item_id
			);
			//envia la push
			if($device_type == 'android') {
				SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // Android
				$status = 1;
			}else if($device_type == 'ios') {
				SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // iOS
				$status = 1;
			}
		}else{
			$status = 0;
			$mensaje = "Error en el registro...";
		}
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
	<script src="../assets.3.6.2/js/plugins/sweetalert/sweetalertnew.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../assets.3.6.2/css/plugins/sweetalert/sweetalert.css">

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
			if(status == 1){
				swal("Excelente!", "Notificaci\u00F3n enviada... Pendientes de lectura: <?php echo $pendientes ?>", "info").then((value)=>{ window.history.back(); });
			}else{
				swal("Error", "Error en el registro de la notificaci\u00F3n", "error").then((value)=>{ window.history.back(); });
			}
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',1000);
	 </script>
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/app/push.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    
</body>

</html>