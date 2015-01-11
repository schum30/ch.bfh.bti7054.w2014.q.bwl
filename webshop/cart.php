<?php
session_start();
include('inc/dbHandler.inc.php');
include('inc/cart.inc.php');

function fill_template(&$template, $tag, $content) {
	$template = str_replace("@$tag@", $content, $template);
}

$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();

$req = $_SERVER['REQUEST_METHOD'];
if($req == 'GET'){
	$dbHandler = new DBHandler();
	$TEMPLATE_PATH = 'template/';
	$TEMPLATE_EXTENSION = '.tpl.html';
	$templateBasket = file_get_contents($TEMPLATE_PATH . 'basket' . $TEMPLATE_EXTENSION);
	$templateBasketItem = file_get_contents($TEMPLATE_PATH . 'basketItem' . $TEMPLATE_EXTENSION);
	$items = $cart->getItems();
	
	if(count($items) >= 1){
		$basketItemstmp = '';
		
		foreach($items as $key => $obj){
			$product = $dbHandler->getProduct($key);
			foreach($obj as $key => $num){
				$tmp = $templateBasketItem;
				$price = number_format($product->options[$key],2);
				fill_template($tmp, 'productName', $product->name);
				fill_template($tmp, 'option', $key);
				fill_template($tmp, 'price', $price);
				fill_template($tmp, 'productId', $product->id);
				fill_template($tmp, 'amount', $num);
				$priceSum = number_format($price * $num, 2);
				fill_template($tmp, 'priceSum', $priceSum);
				$basketItemstmp .= $tmp;
			}
		}
		fill_template($templateBasket, 'basketItems', $basketItemstmp);
	} else {
		fill_template($templateBasket, 'basketItems', 'Der Warenkorb ist leer');
	}
	if(isset($_SESSION['customer'])){
		fill_template($templateBasket, 'basketHref', 'checkout');
	} else {
		fill_template($templateBasket, 'basketHref', 'javascript:void(0)');
		fill_template($templateBasket, 'basketOnClick', 'showPopUpLogin();return false;');
		fill_template($tmp, 'navOnClick', 'showPopUpLogin();return false;');
	}
	
	if(isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])){
		$cart->addItem($_GET['id'], $_GET['amount'], $_GET['option']);
		echo $templateBasket;
	}
	else if(isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])){
		$cart->removeItem($_GET['id'], $_GET['amount'], $_GET['option']);
		echo $templateBasket;
	}
} else {
	$cart->addItem($_POST['id'],$_POST['amount'],$_POST['option']);
	header('HTTP/1.1 303 See Other');
	header("Location: $_SERVER[HTTP_REFERER]");
}
$_SESSION['cart'] = serialize($cart);
?>
