<?php

require_once 'inc/common.php';
defined('WEB_ROOT') ||
	define('WEB_ROOT', dirname(__FILE__).'/');

// run phpinfo
// ob_start();phpinfo();$contents = ob_get_clean();

// emulate slow, cpu-intensive loop (useful to test OpsWorks load based instances when running ApacheBench)
// for($j=0;$j<10000;$j++) { $v = ''; for($i=0;$i<20;$i++) { $v=base64_encode($v.$i.''); }}

$_timer = microtime(true);

$ret = array();
if(function_exists('geoip_record_by_name')) {
    try {
        $ip = IPR::getIP();
        $err = false;
        $loc = @geoip_record_by_name($ip);
        if($loc) {
            $loc = (object)$loc;
        }
        else {
            $loc = new stdClass();
            $err = 'Location unknown';
        }
        $loc->hostname = @gethostbyaddr($ip);
        $loc->hostname = $loc->hostname ?: $ip;
        	if( preg_match('/\./', $loc->hostname) ) $loc->domain = substr($loc->hostname, strpos($loc->hostname, '.', substr_count($loc->hostname, '.'))+1);
        else $loc->domain = '';
        
        $ret = array('geo' => $loc);
        if($err) $ret['error'] = $err;
        	$ret['timems'] = round((microtime(true)-$_timer)*1000);
    }
    catch(Exception $ex) { $ret = array('error'=>$ex->getMessage()); }
}
else {
    $ret['error'] = 'Please install geoip and geoip-devel';
}

/* 
echo PHP_EOL.PHP_EOL;
echo geoip_database_info(GEOIP_CITY_EDITION_REV1)."\n";
echo "YOUR LOCATION:\n";
print_r(geoip_record_by_name(IPR::getIP());

echo "\nRANDOM LOCATION:\n";
print_r(geoip_record_by_name(long2ip(rand(0, 4294967295))));

print_r( geoip_db_get_all_info() );
*/

$content = new stdClass();
$content->title = 'OpsWorks Load Balancer Testing';
$content->h1 = 'Server address: '.$_SERVER['SERVER_ADDR'];
$content->body = '<p>This is OpsWorks theme test.</p><h3>GeoIP</h3><pre>'.json_encode($ret).'</pre>';

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
