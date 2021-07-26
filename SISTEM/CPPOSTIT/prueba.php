<?php 
//incluímos las clases
include_once('../../CONFIG/push/push_android.php');
include_once('../../CONFIG/push/push_ios.php');

	//envia la push
	if($device_type == 'android') {
		SendAndroidPush($device_token, $desc);
		//$respuesta->alert('SendAndroidPush($device_token, $mensaje);');
	}else if($device_type == 'ios') {
		$body = array();
		$body['aps'] = array(
			//'badge' => 1,
			'alert' =>  $pmsg, /////// QUE ES ESTO $pmsg ?
			'sound' => 'default'
		);
		$payload = json_encode($body);
		SendPushiOS($device_token, $payload, $certificate_type);
		//$respuesta->alert('SendPushiOS($device_token, $payload, $certificate_type);');
	}	
?>  