<?php
include_once('inc/dbHandler.inc.php');
include_once('inc/cart.inc.php');

session_start();
function fill_template(&$template, $tag, $content) {
	$template = str_replace("@$tag@", $content, $template);
}

$TEMPLATE_PATH = 'template/';
$TEMPLATE_EXTENSION = '.tpl.html';
$dbHandler = new DBHandler();
$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();
$template = file_get_contents($TEMPLATE_PATH . 'index' . $TEMPLATE_EXTENSION);
$view = isset($_GET['view']) ? $_GET['view'] : NULL;
$category = $view == 'category' && isset($_GET['id']) ? $_GET['id'] : NULL;
$query = $view == 'search' && isset($_GET['query']) ? $_GET['query'] : NULL;
$customer = isset($_SESSION['customer']) ? $_SESSION['customer'] : NULL;

//fill navigation
$templateNavItem = file_get_contents($TEMPLATE_PATH . 'navItem' . $TEMPLATE_EXTENSION);
$navtmp = '';
foreach($dbHandler->getCategories() as $categoryItem){
	$tmp = $templateNavItem;
	$href = '?view=category&id=' . $categoryItem;
	fill_template($tmp, 'navHref', $href);
	fill_template($tmp, 'navOnClick', '');
	fill_template($tmp, 'navText', $categoryItem);
	if($categoryItem == $category){
		fill_template($tmp, 'navCssClass', 'selected');
	} else {
		fill_template($tmp, 'navCssClass', '');
	}
	$navtmp .= $tmp;
}
if(isset($_SESSION['customer'])){
	$tmp = $templateNavItem;
	fill_template($tmp, 'navHref', '?view=account');
	fill_template($tmp, 'navOnClick', '');
	fill_template($tmp, 'navText', 'mein konto');
	if($view == 'account'){
		fill_template($tmp, 'navCssClass', 'selected');
	}
	$navtmp .= $tmp;
} else {
	$tmp = $templateNavItem;
	fill_template($tmp, 'navHref', 'javascript:void(0)');
	fill_template($tmp, 'navOnClick', 'showPopUpLogin();return false;');
	fill_template($tmp, 'navText', 'Login');
	if($view == 'login'){
		fill_template($tmp, 'navCssClass', 'selected');
	}
	$navtmp .= $tmp;
}
fill_template($template, 'navItems', $navtmp);

//fill basket
$templateBasket = file_get_contents($TEMPLATE_PATH . 'basket' . $TEMPLATE_EXTENSION);

if($view == 'account' || $view == 'checkout' || $view == 'confirm'){
	fill_template($template, 'basket', '');
} else {
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
		fill_template($templateBasket, 'basketHref', '?view=checkout');
	} else {
		fill_template($templateBasket, 'basketHref', 'javascript:void(0)');
		fill_template($templateBasket, 'basketOnClick', 'showPopUpLogin();return false;');
		fill_template($tmp, 'navOnClick', 'showPopUpLogin();return false;');
	}
	fill_template($template, 'basket', $templateBasket);
}

//fill content
switch($view){
	case 'category':
		$products = $dbHandler->getProductsByCategory($category);
	case 'search':
		if(!isset($products)){
			$products = $dbHandler->getProductsSearch($query);
		}
	case NULL;
	case 'products':
		if(!isset($products)){
			$products = $dbHandler->getAllProducts();
		}
		$templateContent = file_get_contents($TEMPLATE_PATH . 'contentProducts' . $TEMPLATE_EXTENSION);
		$templateProduct = file_get_contents($TEMPLATE_PATH . 'contentProduct' . $TEMPLATE_EXTENSION);
		$productstmp = '';
		foreach($products as $product){
			$tmp = $templateProduct;
			fill_template($tmp, 'imagePath', $product->imgPath);
			fill_template($tmp, 'productName', $product->name);
			fill_template($tmp, 'description', $product->description);
			fill_template($tmp, 'productId', $product->id);
			$options = '';
			foreach($product->options as $key => $num){
				$options .= '<option value="' . $key . '">' . $key . 'cl ' . $num .'</option>';
			}
			fill_template($tmp, 'options', $options);
			$productstmp .= $tmp;
		}
		fill_template($templateContent, 'products', $productstmp);
		break;
	case 'login':
		$templateContent = file_get_contents($TEMPLATE_PATH . 'contentLogin' . $TEMPLATE_EXTENSION);
		break;
	case 'account':
		$templateContent = file_get_contents($TEMPLATE_PATH . 'contentAccount' . $TEMPLATE_EXTENSION);
		break;
	case 'checkout':
		$templateContent = file_get_contents($TEMPLATE_PATH . 'contentCheckout' . $TEMPLATE_EXTENSION);
		fill_template($templateContent, 'firstName', $customer->firstName);
		fill_template($templateContent, 'lastName', $customer->lastName);
		fill_template($templateContent, 'street', $customer->address->street);
		fill_template($templateContent, 'plz', $customer->address->plz);
		fill_template($templateContent, 'city', $customer->address->city);
		break;
	case 'confirm':
		$templateContent = file_get_contents($TEMPLATE_PATH . 'contentConfirm' . $TEMPLATE_EXTENSION);
		$items = $cart->getItems();
		
		if(count($items) >= 1){
			$templateBasketItem = file_get_contents($TEMPLATE_PATH . 'basketItem' . $TEMPLATE_EXTENSION);
			$basketItemstmp = '';
			
			foreach($items as $key => $obj){
				$product = $dbHandler->getProduct($key);
				foreach($obj as $key => $num){
					$tmp = $templateBasketItem;
					$price = number_format($product->options[$key],2);
					$priceSum = number_format($price * $num, 2);
					fill_template($tmp, 'productName', $product->name);
					fill_template($tmp, 'option', $key);
					fill_template($tmp, 'price', $price);
					fill_template($tmp, 'productId', $product->id);
					fill_template($tmp, 'amount', $num);
					fill_template($tmp, 'priceSum', $priceSum);
					$basketItemstmp .= $tmp;
				}
			}
			fill_template($templateContent, 'basketItems', $basketItemstmp);
		} else {
			fill_template($templateContent, 'basketItems', 'Der Warenkorb ist leer');
		}
		fill_template($templateContent, 'options', 'Abrechnung: ' . $_SESSION['paymentmethod']);
		break;
	default:
		$templateContent = file_get_contents($TEMPLATE_PATH . 'content404' . $TEMPLATE_EXTENSION);
		break;
}
fill_template($template, 'content', $templateContent);

//fill quote
$service_url = 'http://api.adviceslip.com/advice';
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_response = curl_exec($curl);
curl_close($curl);
$decoded = json_decode($curl_response);
$quote = $decoded->slip->advice;
fill_template($template, 'quote', $quote);

//return the site
echo $template;
?>
