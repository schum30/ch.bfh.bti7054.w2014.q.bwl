<?php
session_start();
include('inc/dbHandler.inc.php');
$dbHandler = new DBHandler();
$req = $_SERVER['REQUEST_METHOD'];
if(isset($_GET["login"])){
	if ($req == 'POST' && isset($_POST['username'])) {
		$_SESSION["user"] = $user;
	}
}
else if(isset($_GET["logout"])){
	if ($req == 'POST'){
		$_SESSION["username"] = NULL;
		session_unset();
		session_destroy();
	}
}
header('HTTP/1.1 303 See Other');
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
