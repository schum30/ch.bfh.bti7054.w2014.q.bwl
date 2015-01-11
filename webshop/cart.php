<?php
session_start();
include('inc/dbHandler.inc.php');
include('inc/cart.inc.php');

function fill_template(&$template, $tag, $content) {
	$template = str_replace("@$tag@", $content, $template);
}

$DEFAULT_LANG="de";
if (isset($_SESSION['lang']) && file_exists('lang/' . $_SESSION['lang'] . '.ini')){
	$filename = 'lang/' . $_SESSION['lang'] . '.ini';
}
else {
	$_SESSION['lang'] = $DEFAULT_LANG;
	$filename = 'lang/' . $DEFAULT_LANG . '.ini';
}
$expr = parse_ini_file($filename);

$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();

$req = $_SERVER['REQUEST_METHOD'];
if($req == 'GET'){
	if(isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])){
		$cart->addItem($_GET['id'], $_GET['amount'], $_GET['option']);
	} else if(isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])){
		$cart->removeItem($_GET['id'], $_GET['amount'], $_GET['option']);
	}
	
	$dbHandler = new DBHandler();
	$TEMPLATE_PATH = 'template/';
	$TEMPLATE_EXTENSION = '.tpl.html';
	$templateBasket = file_get_contents($TEMPLATE_PATH . 'basket' . $TEMPLATE_EXTENSION);
	$templateBasketItem = file_get_contents($TEMPLATE_PATH . 'basketItem' . $TEMPLATE_EXTENSION);
	$templateBasketSum = file_get_contents($TEMPLATE_PATH . 'basketSum' . $TEMPLATE_EXTENSION);
	
	$items = $cart->getItems();
	if(count($items) >= 1 && count(current($items)) >= 1){
		$templateBasketCheckout = file_get_contents($TEMPLATE_PATH . 'basketCheckout' . $TEMPLATE_EXTENSION);
		fill_template($templateBasket, 'checkoutButton', $templateBasketCheckout);
		$basketItemstmp = '';
		$basketTotal = 0;
		foreach($items as $key => $obj){
			$product = $dbHandler->getProduct($key, $_SESSION['lang']);
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
				$basketTotal += $priceSum;
			}
		}
		$basketTotal = number_format($basketTotal, 2);
		fill_template($templateBasketSum, 'total', $basketTotal);
		fill_template($templateBasket, 'basketItems', $basketItemstmp);
		fill_template($templateBasket, 'basketSum', $templateBasketSum);
	} else {
		fill_template($templateBasket, 'basketItems', '@emptyCart@');
		fill_template($templateBasket, 'basketSum', '');
		fill_template($templateBasket, 'checkoutButton', '');
	}
	if(isset($_SESSION['customer'])){
		fill_template($templateBasket, 'basketHref', '?view=checkout');
	} else {
		fill_template($templateBasket, 'basketHref', 'javascript:void(0)');
		fill_template($templateBasket, 'basketOnClick', 'showPopUpLogin();return false;');
		fill_template($tmp, 'navOnClick', 'showPopUpLogin();return false;');
	}
	
	//translate
	fill_template($templateBasket, 'searchHint', $expr['searchHint']);
	fill_template($templateBasket, 'search', $expr['search']);
	fill_template($templateBasket, 'yourPurchases', $expr['yourPurchases']);
	fill_template($templateBasket, 'checkout', $expr['checkout']);
	fill_template($templateBasket, 'emptyCart', $expr['emptyCart']);
	
	echo $templateBasket;
} else {
	$cart->addItem($_POST['id'],$_POST['amount'],$_POST['option']);
	header('HTTP/1.1 303 See Other');
	header("Location: $_SERVER[HTTP_REFERER]");
}
$_SESSION['cart'] = serialize($cart);
?>
