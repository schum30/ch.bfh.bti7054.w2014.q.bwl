<?php
session_start();
include('inc/cart.inc.php');
include('inc/site.inc.php');
$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();

$req = $_SERVER['REQUEST_METHOD'];

if($req == 'GET'){
	$site = new Site();
	if(isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])){
		$cart->addItem($_GET['id'], 1);
		echo $site->getCart();
	}
	else if(isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])){
		$cart->removeItem($_GET['id'], 1);
		echo $site->getCart();
	}
} else {
	$cart->addItem($_POST['id'],$_POST['amount'],$_POST['option']);
	header('HTTP/1.1 303 See Other');
	header("Location: $_SERVER[HTTP_REFERER]");
}
$_SESSION['cart'] = serialize($cart);
?>
