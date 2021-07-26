<?php

function SendAndroidPush($id, $title, $message, $contador, $push_tipo, $item_id, $sender_id = '', $data = '') {
    
    $GOOGLE_SERVER_KEY='AAAAJnt7Hwg:APA91bHTIvZ2Gy0799zpBn5WOJ3Zd6ZBrhoabICAKPcWNR0MZDeHGRjldbqLEeUcj7p3nOaiHdJa8zunCW6znpaj219OIwYnQ-R-iAOl4_LjVYfKFjpgRorQjC9q6g5f-mCP24nOnNU3';
    
    $icono = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/logo.png";
    
    $subtitle = substr($message,0, 100)."...";
    
	$notification = array(
		'title'=> $title,
		'subtitle'=> $subtitle,
		'body' => $message,
		'badge' => $contador,
		'type'=> $push_tipo,
		'item_id'=> $item_id,
		'sender_id'=> $sender_id,
		'sound'=> 'default',
		'icon'=> 'fcm_push_icon',
        'click_action' => 'FCM_PLUGIN_ACTIVITY'
	);
    
    $webpush = array(
        'title'=> $title,
		'body' => $message,
		'click_action'=> 'default',
		'sound'=> 'default',
		'icon'=> 'fcm_push_icon'
    );

    $logFile = "LIVE_PUSH_DEBUG_FIREBASE.txt";
    $logfh = fopen($logFile, 'a');
    fwrite($logfh, "\n\n Log at " . date("Y-m-d H:i:s") . " ---------------- ");

    $ids = array($id);

    fwrite($logfh, "\n ids : ". $ids);
    $url = 'https://fcm.googleapis.com/fcm/send';
    $post = array(
        'registration_ids' => $ids,
        'notification' => $notification,
        'data' => $data,
        'webpush' => $webpush,
        'priority'=> 'high'
    );

    $headers = array(
        'Authorization: key=' . $GOOGLE_SERVER_KEY,
        'Content-Type: application/json'
    );

    fwrite($logfh, "\n post : ".  json_encode($post));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

    $result = curl_exec($ch);
    
    // echo "hello";
    // print_r($result);exit();

    if (curl_errno($ch)) {
        echo 'GCM error: ' . curl_error($ch);
    }

    curl_close($ch);
    fwrite($logfh, "\n\n result : ".  $result);
}

?>