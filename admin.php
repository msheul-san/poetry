<?php
require_once 'assets/php/common.php';
require_once 'assets/php/auth.php';

$error = false;
$errorId = false;

if (isset($_GET['edit']) && isset($_GET['id']))
{
	_db_connect($dbMain);
	
	$poemId = intval($_GET['id']);
	
	$sql = "SELECT * FROM poems WHERE id = $poemId ";
	$poemRow = $db->sql_fetchrow($db->sql_query($sql));
	
	if (!$poemRow)
		$errorId = true;
	else
	{
		$title = $poemRow['title'];
		$text = $poemRow['text'];
	}
	
	_db_close();
}

if (isset($_POST['addpoem']))
//если пришло стихотворение
{
	_db_connect($dbMain);
	
	if (!poemExists($_POST['text']))
	{
		$error = true;
	}
	else
	{		
		$text = str_replace(chr(13), '<br>', $_POST['text']);
		if (isset($_POST['title']) && strlen($_POST['title']) > 0)
		{
			$title = $_POST['title'];
			$realTitle = 1;
		}
		else
		{
			$title =  getTitle($_POST['text']); 
			$realTitle = 0;
		}
		$firstSign = getFirstSign($title);
		
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
		
		$sql = $id != 0 ? 
			"UPDATE poems SET title = '$title', text = '$text' WHERE id = $id "  :
			"INSERT INTO poems (title, real_title, text, firstsign) VALUES ('$title', $realTitle, '$text', '$firstSign') ";
		$db->sql_query($sql);
		
		header('Location: /admin/');
		exit();
	}
	
	_db_close();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
        <title>Омский поэт Афанасий</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script src="/assets/js/functions.js"></script>
    </head>
    <body>
		<div class="container">
		<div class="main_left">
			<div class="admin_panel">
				<h1>Коля, это ты!</h1>
				<a href="/admin/">
					<div class="button"><p class="buttontext">все посмотреть</p></div>
				</a>
				<a href="/admin/adding/">
					<div class="button"><p class="buttontext">добавить</p></div>
				</a>
				<a href="/logout/">
					<div class="button"><p class="buttontext">выйти</p></div>
				</a>
				<a href="/">
					<div class="button"><p class="buttontext">на главную</p></div>
				</a>
			</div>
		</div>
		<div class="main" style="text-align: left">

<?php if (!isset($_GET['adding']) && !isset($_GET['edit'])) { 
	
	_db_connect($dbMain);
	
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
			<h1 style="margin-bottom: 0">Все стихи</h1>
			<div class="poem_list"style="margin-top: 20px;">
<?php
	for ($i = 0; $i < count($poems); $i++)
	{
?>
				<div id="<?= $poems[$i]['id'] ?>_href_container">
					<div class="delete" onclick="deletePoem(<?=$poems[$i]['id']?>)">X</div>&nbsp;
					<a class="poem_href" href="/admin/edit/<?=$poems[$i]['id']?>/"><?= $poems[$i]['title'] ?></a>
				</div>
<?php 
	} 
	_db_close();
?>
			</div>
<?php } elseif (isset($_GET['edit'])) { ?>	
			<h1 style="margin-bottom: 0">Редактирование</h1>
<?php if ($errorId) { ?>
			<p style="color:red">Нет такого стихотворения!</p>
<?php } else {?>
			<?= $error ? '<p style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:red">Ну текст-то хотя-бы введи!</p>' : ''?>
			<form class="add_poem" method="post">
				<input type="hidden" name="addpoem">
				<div class="input">
					<div class="label">Название:</div> 
					<div class="elem">
						<input id="title" class="inputtext" type="text" name="title" value="<?= $title ?>" placeholder="не обязательно, по умолчанию - первая строка стихотворения">
					</div>
				</div>
				<div class="input">
					<div class="label">И текст:</div>
					<div class="elem">
						<textarea name="text" <?= $error ? 'class="iserror"' : ''?>><?= str_replace('<br>', '', $text) ?></textarea>
					</div>
				</div>
			</form>
			<div class="button" style="margin-top: -10px;"  onclick="document.forms[0].submit()"><p class="buttontext">Сохранить</p></div>
<?php } ?>
<?php } elseif (isset($_GET['adding'])) { ?>	
			<h1 style="margin-bottom: 0">Добавь стихотворение!</h1>
			<?= $error ? '<p style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:red">Ну текст-то хотя-бы введи!</p>' : ''?>
			<form class="add_poem" method="post">
				<input type="hidden" name="addpoem">
				<div class="input">
					<div class="label">Название:</div> 
					<div class="elem">
						<input id="title" class="inputtext" type="text" name="title" value="" placeholder="не обязательно, по умолчанию - первая строка стихотворения">
					</div>
				</div>
				<div class="input">
					<div class="label">И текст:</div>
					<div class="elem">
						<textarea name="text" <?= $error ? 'class="iserror"' : ''?>></textarea>
					</div>
				</div>
			</form>
			<div class="button" style="margin-top: -10px;" onclick="document.forms[0].submit()"><p class="buttontext">Добавить</p></div>
<?php } ?>
		</div>
		</div>
	</body>
</html>
