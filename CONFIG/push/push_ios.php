<?php

function SendPushiOS($deviceToken, $cert_path, $title, $message, $contador, $push_tipo, $item_id, $sender_id = '') {
    
	$body['aps'] = array(
		'title'=> $title,
		'alert' => $message,
		'badge' => $contador,
		'sound' => 'default',
		'type'=> $push_tipo,
		'item_id'=> $item_id,
		'sender_id'=> $sender_id
	);
	
    $is_production_mode='0';
    if ($is_production_mode == '1' || $is_production_mode == 1) {
        $url_socket = 'ssl://gateway.push.apple.com:2195';
    } else {
        $url_socket = 'ssl://gateway.sandbox.push.apple.com:2195';
    }
	
    $logFile = "LIVE_PUSH_DEBUG_IOS.txt";
    $logfh = fopen($logFile, 'a');

    fwrite($logfh, "\nLog at " . date("Y-m-d H:i:s") . " ---------------- ");
    $passphrase = 'ID123';
    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', $cert_path); // path to cetificate
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
    
    fwrite($logfh, "\nLog at " . $cert_path);
    fwrite($logfh, "\nLog at " . $url_socket);
    // envio
    $fp = stream_socket_client($url_socket, $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
    fwrite($logfh, "\nLog at " . $errstr);
    if (!$fp){
	exit("Failed to connect: $err $errstr" . PHP_EOL);
        fwrite($logfh, "\n Failed to connect: ". $err);
    }
    $payload = json_encode($body);
    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

    fwrite($logfh, "\n payload ".$payload );
	fwrite($logfh, "\n err = ".$err );
    fwrite($logfh, "\n deviceToken = ".$deviceToken );
    fwrite($logfh, "\n msg = ".$message );
    $result = fwrite($fp, $msg, strlen($msg));

    fwrite($logfh, "\n result = ".$result );
    fclose($fp);
}

?>