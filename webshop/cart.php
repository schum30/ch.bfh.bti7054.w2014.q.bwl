<?php
session_start();
$req = $_SERVER['REQUEST_METHOD'];
if($req == 'POST'){
	$cart = $_SESSION["cart"];
}



header('HTTP/1.1 303 See Other');
header("Location: $_SERVER[HTTP_REFERER]");
?>
