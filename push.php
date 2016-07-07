<?php 

	if ("" != trim($_POST['token']) && "" != trim($_POST['message']) && "" != trim($_POST['certificate']) && "" != trim($_POST['pushserver'])) {

		$token = $_POST['token'];
		$message = $_POST['message'];
		$callbackAddress = $_POST['callbackAddress'];
		$certificate = $_POST['certificate'];
		$pushServer = $_POST['pushserver'];

		$badge = intval($badge);
		
	    $payload = $message;
	
		// $payload = json_encode($payload);
	
		$deviceToken = $token;
		$apnsHost = $pushServer;
		$apnsPort = 2195;
		$apnsCert = $certificate;
		$streamContext = stream_context_create();
		stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);

        // $certPass = 'certificate password';
		// stream_context_set_option($streamContext, 'ssl', 'passphrase', $certPass);

		$apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
	
		$apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $deviceToken)) . chr(strlen($payload) / 256) . chr(strlen($payload) % 256) . $payload;
		
		fwrite($apns, $apnsMessage);
	
		fclose($apns);
	} else {
		echo "Error! Something is not set.";
	}
?>
