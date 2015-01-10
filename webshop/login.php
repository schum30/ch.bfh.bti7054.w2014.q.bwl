<?php
include_once('inc/dbHandler.inc.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['username']) && isset($_POST['password']) && !is_null($_POST['username']) && !is_null($_POST['password'])) {
		session_start();
		$dbHandler = new DBHandler();
		$customer = $dbHandler->getCustomer($_POST['username'], $_POST['password']);
		if(!is_null($customer)){
			$_SESSION['customer'] = $customer;
			header('HTTP/1.1 303 See Other');
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		} else{
			echo 'Wrong password or user does not exist!';
		}
	} else{
		echo 'Wrong password or user does not exist!';
	}
} else{
	echo 'Error: You can only post to this site! The main page is <a href="./index.php">here</a>';
}
?>
