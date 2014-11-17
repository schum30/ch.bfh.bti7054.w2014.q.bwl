<?php
session_start();
include('inc/cart.inc.php');
$req = $_SERVER['REQUEST_METHOD'];
if($req == 'POST'){
	$cart = isset($_SESSION["cart"]) ? unserialize($_SESSION["cart"]) : new Cart();
	$id = $_POST["id"];
	$amount = $_POST["amount"];
	$cart->addItem($id, $amount);
	$_SESSION["cart"] = serialize($cart);
	$cart->display();
}

header('HTTP/1.1 303 See Other');
header("Location: $_SERVER[HTTP_REFERER]");
?>
