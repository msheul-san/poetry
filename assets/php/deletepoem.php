<?php

require_once 'common.php';

$ip = $_SERVER['REMOTE_ADDR'];
$ip = strlen($ip) > 32 ? substr($ip, 0, 32) : $ip;

$sidFull = isset($_COOKIE['auth_sid']) ? $_COOKIE['auth_sid'] : '';

$sid = strlen($sidFull) > 32 ? substr($sidFull, 0, 32) : $sidFull;
$sidSecure = strlen($sidFull) > 32 ? substr($sidFull, 32) : '';

if ($sidSecure != md5($sid . $ip . '2m35l2')) // солим!
{
	echo 0; 
}
else 
{
	_db_connect($dbMain);

	$sql = "DELETE FROM poems WHERE id = " . $_POST['id'];
	$db->sql_query($sql);
	
	_db_close();
	
	echo 1;
}

?>
