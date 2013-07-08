<?php

function screenSmart($value)
{
	if (get_magic_quotes_gpc())
		$value = stripslashes($value);
	
	$value = @mysql_real_escape_string($value);
	
	return $value;
}

function poemExists($poem)
{
	if (strlen(screenSmart($poem)) != 0)
		return true;
	else 
		return false;
}

function getTitle($poem)
{
	$pos = strpos($poem, chr(13)) > 0 ? strpos($poem, chr(13)) : strlen($poem) ;
	return trim(substr($poem, 0, $pos), ",.:-!?") . '&#8230;';
}

function getFirstSign($poem)
{
	preg_match_all('/[0-9a-zA-Zа-яА-Я]/u', $poem, $arr);
	$sign = isset($arr[0][0]) ? $arr[0][0] : 'other';
	return mb_strtoupper($sign, 'UTF-8');
}

?>
