<?php
$site_root_path = './';

require($site_root_path . 'assets/php/common.php');

if (isset($_POST['login']) && isset($_POST['password']))
{
	_db_connect($dbMain);
	
	$login = screenSmart($_POST['login']);
	$password = md5($_POST['password'] . '2m35l2'); // солим!
	
	$sql = "SELECT login, password " .
		   "FROM users " .
		   "WHERE login = '$login' ";
	$devRes = $db->sql_query($sql);
	$devRow = $db->sql_fetchrow($devRes);
	$db->sql_freeresult($devRes);
	
	if ($devRow && $devRow['password'] == $password)
	{
		$ip = screenSmart($_SERVER['REMOTE_ADDR']);
		$ip = strlen($ip) > 32 ? substr($ip, 0, 32) : $ip;
		
		$sid = md5($devRow['login'] . time() . $ip);
		$sidSecure = md5($sid . $ip . '2m35l2'); // солим!
		
		$expireTime = time() + $userSessionLiveTime;
		
		setcookie('auth_sid', $sid . $sidSecure, $expireTime, '/');
				
		$_SESSION['admin'] = true;
		
		header('Location: /admin/');
		exit();
	}
	
	_db_close();
}

elseif (isset($_GET['logout']))
{	
	setcookie('auth_sid', '', time() - 86400, '/');
	
	unset($_SESSION['admin']);
	session_destroy();
	
	header('Location: /login/');
	exit();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
        <title>Омский поэт Афанасий</title>
    </head>
    <body>
	<div class="login">	
		
		<h1>Авторизация</h1>

		<form style=""method="post">
				<div class="input"><input id="login" class="inputtext" type="text" name="login" value=""></div>
				<div class="input"><input id="password" class="inputtext" type="password" name="password" value=""></div>
		</form>
		<div class="button" onclick="document.forms[0].submit()"><p class="buttontext">Войти</p></div>
	</div>
	</body>
</html>
