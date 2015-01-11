<?php
include_once('inc/dbHandler.inc.php');
include_once('inc/cart.inc.php');
session_start();
if(isset($_POST['submit'])){
	$cart = unserialize($_SESSION['cart']);
	$customer = $_SESSION['customer'];
	$dbHandler = new DBHandler();
	$dbHandler->createOrder($cart, $customer);
	unset($_SESSION['cart']);
	header('HTTP/1.1 303 See Other');
	header('Location: index.php');
}
?>
