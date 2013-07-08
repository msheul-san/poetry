<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
        <title>Омский поэт Афанасий</title>
    </head>
    <body>
		<div class="container">
		<div class="main_left">
			<div class="admin_panel">
				<h1>Омский</h1>
				<h1>Поэт</h1>
				<h1>Афанасий</h1>
				<div class="button_unactive"><p class="buttontext">Главная</p></div>
				<a href="/allpoems/"><div class="button"><p class="buttontext">Все стихи</p></div></a>
				<a href="/random/"><div class="button"><p class="buttontext">Случайное</p></div></a>
<?php 
session_start();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) { 
?>
				<a href="/admin/"><div class="button"><p class="buttontext">админка</p></div></a> 
<?php } ?>
			</div>
		</div>
		<div class="main">
			<img src="../assets/img/main.png">
		</div>
		</div>
	</body>
</html>
