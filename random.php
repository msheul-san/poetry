<?php
require_once 'assets/php/common.php';

_db_connect($dbMain);

$sql = "SELECT * FROM poems ORDER BY RAND() LIMIT 1 ";
$poemRow = $db->sql_fetchrow($db->sql_query($sql));

$title = $poemRow['title'];
$text = $poemRow['text'];
$realTitle = $poemRow['real_title'] == 1 ? true : false;

_db_close();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
        <title>Омский поэт Афанасий</title>
    </head>
    <body>
		<a href="/random/" id="backToList">
				<div class="button"> <!-- style="position: relative; margin: 0 auto;"> -->
					<p class="buttontext">Ещё</p>
				</div>
		</a>
		<div class="container">
		<div class="main_left">
			<div class="admin_panel">
				<img src="/assets/img/main.png" height="195px">
				<a href="/"><div class="button"><p class="buttontext">Главная</p></div></a>
				<a href="/allpoems/"><div class="button"><p class="buttontext">Все стихи</p></div></a>
				<div class="button_unactive"><p class="buttontext">Случайное</p></div>
<?php 
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) { 
?>
				<a href="/admin/"><div class="button"><p class="buttontext">админка</p></div></a> 
<?php } ?>

			</div>
		</div>
		<div class="main">
			<h1>Случайное стихотворение</h1>
			<div class="poem">
				<div class="title"><?= $realTitle ? $title : '* * *	' ?></div><br><br>
				<div class="text"><?= $text ?></div>
			</div>
		</div>
		</div>
	</body>
</html>
