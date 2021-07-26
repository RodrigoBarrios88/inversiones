<?php
	include_once('html_fns_info.php');
	require_once("../constructor.php"); //--correos
	require_once("../recursos/mandrill/src/Mandrill.php"); //--correos
	
	$fecha = date("d/m/Y");
	
	$ClsInfo = new ClsInformacion();
	$ClsPush = new ClsPushup();
	$result = $ClsInfo->get_informacion_push_user('','TODOS','','',$fecha);
	if(is_array($result)) {
		foreach ($result as $row){
			$user_id = $row["user_id"];
			$device_type = $row["device_type"];
			$device_token = $row["device_token"];
			$certificate_type = $row["certificate_type"];
			//--
			$codigo = trim($row["inf_codigo"]);
			$mensaje = "Recordatorio: ".utf8_decode($row["inf_nombre"])." / Ver detalles...";
		
			$title = 'Automatizado';
			$message = $mensaje;
			$push_tipo = 3;
			$item_id = $codigo;
			$cert_path = '../../CONFIG/push/ck_prod.pem';
			$data = array(
				'landing_page'=> 'page',
				'codigo' => $item_id
			 );
			//--
			$sql = $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id);
			$rs = $ClsPush->exec_sql($sql);
			if($rs == 1){
				//cuenta las notificaciones pendientes
				$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
				//envia la push
				if($device_type == 'android') {
					SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // Android
					$status = 1;
				}else if($device_type == 'ios') {
					SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // iOS
					$status = 1;
				}
			}	
		}
	}

	
	$ClsInfo = new ClsInformacion();
	$ClsPush = new ClsPushup();
	$result = $ClsInfo->get_informacion_secciones_users('','','','','',$fecha);
	if(is_array($result)) {
		foreach ($result as $row){
			$user_id = $row["user_id"];
			$device_type = $row["device_type"];
			$device_token = $row["device_token"];
			$certificate_type = $row["certificate_type"];
			//--
			$codigo = trim($row["inf_codigo"]);
			$mensaje = "Recordatorio: ".utf8_decode($row["inf_nombre"])." / Ver detalles...";
		
			$title = 'Automatizado';
			$message = $mensaje;
			$push_tipo = 3;
			$item_id = $codigo;
			$cert_path = '../../CONFIG/push/ck_prod.pem';
			//--
			$sql = $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id);
			$rs = $ClsPush->exec_sql($sql);
			if($rs == 1){
				//cuenta las notificaciones pendientes
				$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
				//envia la push
				if($device_type == 'android') {
					SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id);
					$status = 1;
				}else if($device_type == 'ios') {
					SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // iOS
					$status = 1;
				}
			}	
		}
	}
	
    $result = $ClsInfo->get_informacion_grupos_users('','',$fecha);
	if(is_array($result)) {
		foreach ($result as $row){
			$user_id = $row["user_id"];
			$device_type = $row["device_type"];
			$device_token = $row["device_token"];
			$certificate_type = $row["certificate_type"];
			//--
			$codigo = trim($row["inf_codigo"]);
			$mensaje = "Recordatorio: ".utf8_decode($row["inf_nombre"])." / Ver detalles...";
		
			$title = 'Automatizado';
			$message = $mensaje;
			$push_tipo = 3;
			$item_id = $codigo;
			$cert_path = '../../CONFIG/push/ck_prod.pem';
			//--
			$sql = $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id);
			$rs = $ClsPush->exec_sql($sql);
			if($rs == 1){
				//cuenta las notificaciones pendientes
				$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
				//envia la push
				if($device_type == 'android') {
					SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id);
					$status = 1;
				}else if($device_type == 'ios') {
					SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // iOS
					$status = 1;
				}
			}	
		}
	}
	
	// Instancia el API KEY de Mandrill
	$mandrill = new Mandrill('kwBB4mXd5D3Jf1Ki3y1KYA');
	//--
	// Create the email and send the message
	$to = array(
		array(
            'email' => 'manuelsa@farasi.com.gt',
            'name' => 'Administrador 1',
            'type' => 'to'
		)
	);
	// Create the email and send the message
	$subject = trim("Correo desde el enviador automatico del Cron de Ansares");
	$texto = "Has recibido un nuevo mensaje desde ASMS.<br><br> Aqui estan los detalles:<br>";
	$texto = "<p>Las notificaciones se ejecutaron con exito...</p>";
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
		$status =  1;
		$i++; //suma una vuelta ya que empezo desde 0
	} catch(Mandrill_Error $e) { 
		//echo "<br>";
		//print_r($e);
		//devuelve un mensaje de manejo de errores
		$status =  0;
		$msj = "Ha ocurrido un error en el envio del mensaje, por favor intenta mas tarde...";
	}
	
?>