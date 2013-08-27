<?php

date_default_timezone_set('America/New_York');

ini_set('zlib.output_compression', 1024);
ini_set('zlib.output_compression_level', 6);
header('Content-Type: text/html; charset=utf-8', true);

// run phpinfo
ob_start();phpinfo();$contents = ob_get_clean();

// emulate slow, cpu-intensive loop
for($j=0;$j<10000;$j++) { $v = ''; for($i=0;$i<20;$i++) { $v=base64_encode($v.$i.''); }}

?><!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<body>
		<h1 id="testing">Load Balancer Testing</h1>
		<h2>Server address: <?php echo $_SERVER['SERVER_ADDR']; ?></h2>
		<p><img width="400" height="175" alt="Testing loading the image from the server" src="images/img000.jpeg?r=<?php echo mt_rand(0,999999);?>" /></p>
	</body>
</html>