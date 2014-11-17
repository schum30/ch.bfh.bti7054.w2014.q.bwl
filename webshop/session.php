<?php
session_start();
$req = $_SERVER['REQUEST_METHOD'];
if(isset($_GET["login"])){
	if ($req == 'POST') {
		$_SESSION["username"] = isset($_POST['username']) ? $_POST['username'] : NULL;
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
header("Location: $_SERVER[HTTP_REFERER]");
?>
