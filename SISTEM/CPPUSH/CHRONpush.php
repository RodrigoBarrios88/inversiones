<?php
	include_once('html_fns_push.php');
	require_once("../../CONFIG/constructor.php"); //--correos
	require_once("../recursos/mandrill/src/Mandrill.php"); //--correos
	
	/*$mensaje = 'Mensaje Automatizado desde ASMS el '.date("d/m/Y H:i:s");
	$user_id = '2337476130101';
	$device_id = '6086c9b062372d0eb5f5dabcac3db85a';

	$ClsPush = new ClsPushup();
	$result = $ClsPush->get_push_user($user_id,'','',$device_id);
	if(is_array($result)) {
		foreach ($result as $row){
			$user_id = $row["user_id"];
			$device_type = $row["device_type"];
			$device_token = $row["device_token"];
			$certificate_type = $row["certificate_type"];
			
		}
		$title = 'Automatizado';
		$message = $mensaje;
		$push_tipo = 5;
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
	
	
	// Instancia el API KEY de Mandrill
   $mandrill = new Mandrill('IyYUk0dXRAa72qDWVqujrg');
	require_once("constructor_plazas.php"); //--correos
	//--
	$to = array();
	//criterios
	$result = $ClsCri->get_criterios();
	$i = 0;
	if(is_array($result)){
		foreach($result as $row){
			$arrcorreos["email"] = trim($row["per_mail"]);
			$arrcorreos["name"] = "";
			$arrcorreos["type"] = "to";
			$to[$i] = $arrcorreos;
			$i++;
		}
		$arrcorreos["email"] = "manuelsa@farasi.com.gt";
		$arrcorreos["name"] = "";
		$arrcorreos["type"] = "to";
		$to[$i] = $arrcorreos;
		//$i--;
	}*/
	
	// Instancia el API KEY de Mandrill
	$mandrill = new Mandrill('kwBB4mXd5D3Jf1Ki3y1KYA');
	//--
	// Create the email and send the message
	$to = array(
		array(
            'email' => 'manuelsa@farasi.com.gt',
            'name' => 'Administrador 1',
            'type' => 'to'
		),
		array(
            'email' => 'ppsk8358@gmail.com',
            'name' => 'Administrador 2',
            'type' => 'to'
		)
	);
	// Create the email and send the message
	$subject = trim("Correo desde el enviador automatico del Cron");
	$texto = "Has recibido un nuevo mensaje desde ASMS.<br><br> Aqui estan los detalles:<br>";
	$texto = "<p>Este es un mensaje automatico desde el Cron, por favor valide si esta llegando....</p>";
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
		//$result = $mandrill->messages->send($message);
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