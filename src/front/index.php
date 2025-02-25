<?php

if(isset($_GET['getServiceInfo'])) {
	header('Content-type: application/json');
	echo json_encode(array(
		'host'=> 'wss.' . $_SERVER['HTTP_HOST'],
		'port'=> 8443,
		'serviceName'=> ''
	));
	exit();
}
?>
<!doctype html>
<html>
	<head>
	<title>Webdrop</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0"/>
	<link rel="stylesheet" href="assets/global.css"></link>
	<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🛜</text></svg>">
</head>

<body>

<input type="file" id="fileInput" style="opacity:0" multiple/>

<div class="background">
	<div class="scanner"></div>
</div>

<main>
	<h1>
		Drag, drop on, share with
	</h1>

	<div id="userInfo">
		My name:  <input id="userName"/>
	</div>
	<div class="userListContainer">
		<h2>Share with</h2>
		<p>Drop a file on a user to send it to him</p>
		<div class="userList"></div>
	</div>
</main>


<!-- <span id="forkongithub"><a href="https://github.com/ElBiniou/Webdrop">Fork me on GitHub</a></span> -->


<iframe id="download" style="display:none"></iframe>

<script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
<script src="assets/js/gc_socket/websocket/client.js"></script>
<script src="assets/js/gc_socket/websocket/message.js"></script>


<script src="assets/js/webdrop/webdropclient.js"></script>
<script src="assets/js/webdrop/webdropuser.js"></script>
<script src="assets/js/webdrop/webdropuploader.js"></script>

<script>

const containerCircle = document.querySelector('.background');
var increment=80;
for(var i=1; i<30; i++) {
	const circle = document.createElement('div');
	circle.classList.add('circle');
	circle.style.width = i*increment + 'px';
	circle.style.height = i*increment + 'px';
	circle.style.marginTop = -i*increment/2 + 'px';
	circle.style.marginLeft = -i*increment/2 + 'px';
	containerCircle.appendChild(circle);
}
</script>


<script>
	var client=new WebDropClient(new GC_Client());
	client.connect('?getServiceInfo');

</script>
</body>

</html>
