<?php
include('inc/dbHandler.inc.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['name']) && isset($_POST['password'])) {
		session_start();
		$_SESSION['user'] = $_POST['name'];
		header('HTTP/1.1 303 See Other');
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
}
else{
	echo 'You can only post to this site!';
}
?>
