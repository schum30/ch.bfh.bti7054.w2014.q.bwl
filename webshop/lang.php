<?php
session_start();

if(isset($_GET['lang']) && file_exists('lang/' . $_GET['lang'] . '.ini')){
	$_SESSION['lang'] = $_GET['lang'];
}

header('HTTP/1.1 303 See Other');
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
