<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = isset($_POST['username']) ? $_POST['username'] : "Besucher";
	setcookie("username",$username);
	$password = isset($_POST['password']) ? $_POST['password'] : NULL;
}

header('HTTP/1.1 303 See Other');
header('Location: http://localhost/webshop/index.php');
?>
