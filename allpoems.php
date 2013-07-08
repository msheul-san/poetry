<?php
require_once 'assets/php/common.php';

$showall = isset($_GET['showall']) ? true : false;
$poemId = isset($_GET['poem_id']) ? $_GET['poem_id'] : 0;

_db_connect($dbMain);

$poems = array();

$sql = "SELECT * FROM poems ORDER BY firstsign ";
$poemsRes = $db->sql_query($sql);

for($i = 0; $poemRow = $db->sql_fetchrow($poemsRes); $i++)
{
	$poems[$i]['id'] = $poemRow['id'];
	$poems[$i]['title'] = $poemRow['title'];
	$poems[$i]['real_title'] = $poemRow['real_title'] == 1 ? true : false;
	$poems[$i]['text'] = $poemRow['text'];
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script src="/assets/js/scroll.js"></script>
		<script type="text/javascript">    
		$(function() {    
		$("#goTop").scrollToTop();    
		});    
		</script>
		<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
        <title>Омский поэт Афанасий</title>
    </head>
    <body>
		<div class="container">
		<a href="#" id="goTop">
			<div class="button">
				<p class="buttontext">Наверх</p>
			</div>
		</a>
<?php if ($showall) { ?>
		<a href="/allpoems/" id="backToList">
			<div class="button" >
				<p class="buttontext">По одному</p>
			</div>
		</a>
<?php } elseif ($poemId != 0) {?>
		<a href="/allpoems/"  id="backToList">
			<div class="button"> <!--style="position: relative; margin: 0 auto;"-->
				<p class="buttontext">К списку</p>
			</div>
		</a>
<?php }?>
		<div class="main_left">
			<div class="admin_panel">
				<img src="/assets/img/main.png" height="195px">
				<a href="/"><div class="button"><p class="buttontext">Главная</p></div></a>
				<div class="button_unactive"><p class="buttontext">Все стихи</p></div>
				<a href="/random/"><div class="button"><p class="buttontext">Случайное</p></div></a>
<?php 
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) { 
?>
				<a href="/admin/"><div class="button"><p class="buttontext">админка</p></div></a> 
<?php } ?>
			</div>
		</div>
		<div class="main">
			<h1 style="">Все стихи</h1>
<?php
if ($poemId == 0)
{
?>
			<div class="poem_list" <?= !$showall ? 'style="margin-bottom:7px"' : '' ?>>
<?php
	for ($i = 0; $i < count($poems); $i++)
	{
?>
				<div>
					<a class="poem_href" href="<?= $showall ? '#' . $poems[$i]['id'] : '/allpoems/poem/' . $poems[$i]['id'] . '/' ?>"><?= $poems[$i]['title'] ?></a>
				</div>
<?php } ?>
			</div>
<?php

	if (!$showall)
	{
?>
			<a href="/allpoems/showall/">
				<div class="button">
					<p class="buttontext">Все на одной странице</p>
				</div>
			</a>
<?php
	}

	if ($showall)
	{
?>
			<div class="allpoems">
<?php
		for ($i = 0; $i < count($poems); $i++)
		{
?>
				<div class="poem">
					<a name="<?= $poems[$i]['id']?>">
					<div class="title"><?= $poems[$i]['real_title'] ? $poems[$i]['title'] : '*  *  *' ?></div><br><br>
					<div class="text">
						<?= $poems[$i]['text'] ?>
					</div>
					<br>
				</div>
<?php 
		}
?>
			</div>
<?php
	}
}
else
{
	$sql = "SELECT * FROM poems WHERE id = $poemId ";
	$poemRow = $db->sql_fetchrow($db->sql_query($sql));

	$title = $poemRow['title'];
	$text = $poemRow['text'];
	$realTitle = $poemRow['real_title'] == 1 ? true : false;
?>
			<div class="poem">
				<div class="title"><?= $realTitle ? $title : '* * *' ?></div><br><br>
				<div class="text"><?= $text ?></div>
			</div>
<?php
}
?>
		</div>
		</div>
	</body>
</html>
<?php
_db_close();
?>