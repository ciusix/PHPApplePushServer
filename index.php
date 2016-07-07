<html>
	<head>
		<link rel="stylesheet" href="files/style.css">
		
		<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		
		<script>
		function sendPush() {
		  	var xhr = new XMLHttpRequest();
			xhr.open('POST', 'push.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onload = function () {
				var responseHTML = "<li>Response: " + this.responseText + "</li>";
				var listHTML = document.getElementById('responseBox');
				listHTML.innerHTML += responseHTML;
				console.log(this.responseText);
			};
			var token = document.getElementById("tokenBox").value;
			var message = document.getElementById("messageBox").value;
			var certificate = $('input[name="certificate"]:checked').val();
			var pushserver = $('input[name="pushserver"]:checked').val();
	
			xhr.send('token=' + token 
			       + '&message=' + message 
			       + '&certificate=' + certificate
			       + '&pushserver=' + pushserver);
		  	return false;
		} 
		
		function clearResponses() {
			var listHTML = document.getElementById('responseBox');
			listHTML.innerHTML = "";
		  	return false;
		}  
		</script>
	</head>

	<body>
		<div class="mainTableWrapper">
			<div class="topTable">
			
				<table class="mainTable">
					<tr>
						<td>Device Token:</td>
						<td class="mainTableInputCell"><input style="width:100%" id="tokenBox" type="text" name="token"></td>
					</tr>

					<tr>
						<td>Message:</td>
						<td class="mainTableInputCell"><textarea style="width:100%" id="messageBox" type="text" name="message" cols="40" rows="20">{
  "aps": {
    "alert": "Hello!",
    "sound": "default",
    "badge": 1
  }
}</textarea></td>
					</tr>
					
					<tr>
						<td>Certificate:</td>
						<td class="mainTableInputCell">
						
						<?php
							if ($handle = opendir('.')) {
							    $numberOfCertificates = 0;
								while (false !== ($file = readdir($handle))) {
									if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'pem') {
										echo '<input type="radio" name="certificate" value="' . $file . '">' . $file . '<br>';
										$numberOfCertificates++;
									}
								}
								
								if ($numberOfCertificates == 0) {
								    echo "No certificates found! Put .pem certificates in same directory as index.php (this file) and refresh this page!";
								}
								
								closedir($handle);
							}
						?>
						
						</td>
					</tr>
					
					<tr>
						<td>Apple server:</td>
						<td class="mainTableInputCell">
						
						<input type="radio" name="pushserver" value="gateway.sandbox.push.apple.com">gateway.sandbox.push.apple.com:2195 (Development)<br>
  						<input type="radio" name="pushserver" value="gateway.push.apple.com">gateway.push.apple.com:2195 (Distribution)<br>
						
						</td>
					</tr>
				</table>
			
				<div class="buttonWrapper">
					<a href="#" onclick="sendPush();"><div class="bigButton sendButton">SEND</div></a>
					<a href="#" onclick="clearResponses();"><div class="bigButton clearButton">CLEAR RESPONSES</div></a>
				</div>
			</div>
			
			<div class="responsesTable">
				Responses (clear response means that there were no errors):
				<ul id="responseBox">
				</ul>
			</div>
		</div>
	</body>
</html>
