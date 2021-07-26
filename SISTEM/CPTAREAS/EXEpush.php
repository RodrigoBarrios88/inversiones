<?php
	include_once('html_fns_tarea.php');

	$pensum = 2;
	$nivel = 1;
	$grado = 1;
	$seccion = 1;
	$materia = 1;
	$maestro = '1597452760101';
	
	$codigo = 10;
	$nom = "Prueba de notificacion para tarea ";
	$desc = "Esta es una tarea de prueba para probar notificaciones";
	$fechor = "21/02/2018 22:00:00";

	$ClsTar = new ClsTarea();
	$ClsAcad = new ClsAcademico();
	$ClsPush = new ClsPushup();

		$result = $ClsPush->get_nivel_grado_seccion_users($pensum,$nivel,$grado,$seccion);
		/// registra la notificacion //
		if(is_array($result)) {
			$title = 'Nueva Tarea';
			$message = $nom;
			$push_tipo = 2;
			$item_id = $codigo;
			$cert_path = '../../CONFIG/push/ck_prod.pem';
			//--
			foreach ($result as $row){
				$user_id = $row["user_id"];
				$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id);
			}
			//---------
			$ClsPen = new ClsPensum();
			$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado,$materia);
			if(is_array($result_materias)){
				foreach($result_materias as $row_materias){
					$materia_descripcion = utf8_decode($row_materias["mat_descripcion"]);
				}
			}
			$ClsMae = new ClsMaestro();
			$result_maestro = $ClsMae->get_maestro($maestro);
			if(is_array($result_maestro)){
				foreach($result_maestro as $row_maestro){
					$maestro_nombre = utf8_decode($row_maestro["mae_nombre"])." ".utf8_decode($row_maestro["mae_apellido"]);
				}
			}	
		}
		$data = array(
            'landing_page'=> 'page',
            'codigo' => $item_id
         );
			
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			///// Ejecuta notificaciones push
			if(is_array($result)) {
				foreach ($result as $row){
					$user_id = "2337476130101";
					$device_type = 'ios';
					$device_token = "d5xQeK70tFg:APA91bHVav3Bvq2vskQr35F9OHcPHStcK8RkHb57BWzVr9kJZ-T7R1yC4pU7vVj8rpfaWqEnNeb4ouc_liaLHZ3jPchpr9zKm5TUeFvI9dJHCzakitRplEg_FQou-tW7SggJwrP-tZO9";
					$certificate_type = 0;
					//cuenta las notificaciones pendientes
					$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
					//--
					$data = array(
					   'landing_page'=> 'tareas',
					   'codigo' => $item_id
					);
					//envia la push
					if($device_type == 'android') {
						SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // Android
					}else if($device_type == 'ios') {
						SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // iOS
					}	
				}
			}
			////
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

    <!-- Swal -->
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