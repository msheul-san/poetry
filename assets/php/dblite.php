<?php
require_once 'mysql.php';

$db = 0;
$dbLastName = '';

// Make the database connection.
function _db_connect($dbname, $timeout = 10, $tries = 10)
{
	global $db;
	global $dbhost, $dbuser, $dbpasswd;
	global $dbLastName;
	
	if (!$db && $dbname != $dbLastName)
		_db_close();
	
	for ($try = 0; $try < $tries; $try++)
	{
		$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);
		if ($db->db_connect_id)
			break;
		
		usleep(rand(50000, 200000));
	}
	
	if ($try == $tries)
		return false;
	
	$dbLastName = $dbname;
	
	$db->sql_query('SET NAMES utf8;');
	if ($timeout)
		$db->sql_query("SET wait_timeout = $timeout;");
	
	return true;
}

function _db_reconnect()
{
	global $db;
	global $dbLastName;
	
	if ($db)
		return true;
	
	if ($dbLastName == '')
		return false;
	
	return _db_connect($dbLastName);
}

// Close the database connection.
function _db_close()
{
	global $db;
	
	if ($db)
		$db->sql_close();
	
	$db = 0;
}

?>