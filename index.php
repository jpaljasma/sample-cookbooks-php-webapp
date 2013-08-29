<?php

require_once 'inc/common.php';
defined('WEB_ROOT') ||
	define('WEB_ROOT', dirname(__FILE__).'/');

// run phpinfo
// ob_start();phpinfo();$contents = ob_get_clean();

// emulate slow, cpu-intensive loop (useful to test OpsWorks load based instances when running ApacheBench)
for($j=0;$j<10000;$j++) { $v = ''; for($i=0;$i<20;$i++) { $v=base64_encode($v.$i.''); }}


$content = new stdClass();
$content->title = 'OpsWorks Load Balancer Testing';
$content->h1 = 'Server address: '.$_SERVER['SERVER_ADDR'];
$content->body = '<p>This is OpsWorks theme test.</p>';

/* Render the output using theme */
if(file_exists('theme.php')) {
	include_once('theme.php');
	if(defined('APP_THEME') && ('' != APP_THEME)) {
		$themeFolder = dirname(__FILE__).'/themes/'.APP_THEME.'/';
		$themeFile = $themeFolder.'index.php';
		if(file_exists($themeFile)) {
			include($themeFile);
		}
		else {
			die('Theme file '.$themeFile.' does not exist.');
		}
	}
	else {
		die('APP_THEME not defined.');
	}
}
else {
	var_dump($content);
}