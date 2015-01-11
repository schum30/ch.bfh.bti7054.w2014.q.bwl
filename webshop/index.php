<?php
include_once('inc/dbHandler.inc.php');
include_once('inc/cart.inc.php');

session_start();
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
		fill_template($tmp, 'navCssId', 'selected');
	} else {
		fill_template($tmp, 'navCssClass', '');
		fill_template($tmp, 'navCssId', '');
	}
	$navtmp .= $tmp;
}
if(isset($_SESSION['customer'])){
	$tmp = $templateNavItem;
	fill_template($tmp, 'navHref', '?view=account');
	fill_template($tmp, 'navOnClick', '');
	fill_template($tmp, 'navText', '@myAccount@');
	if($view == 'account'){
		fill_template($tmp, 'navCssClass', 'selected');
	}
	$navtmp .= $tmp;
} else {
	$tmp = $templateNavItem;
	fill_template($tmp, 'navHref', 'javascript:void(0)');
	fill_template($tmp, 'navOnClick', 'showPopUpLogin();return false;');
	fill_template($tmp, 'navText', 'Login');
	fill_template($tmp, 'navCssClass', '');
	$navtmp .= $tmp;
}
fill_template($template, 'navItems', $navtmp);

//fill basket
$templateBasket = file_get_contents($TEMPLATE_PATH . 'basket' . $TEMPLATE_EXTENSION);
if($view == 'category' || $view == null){
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
	fill_template($template, 'basket', $templateBasket);
} else {
	fill_template($template, 'basket', '');
}

//fill content
switch($view){
	case 'category':
		$products = $dbHandler->getProductsByCategory($category, $_SESSION['lang']);
	case 'search':
		if(!isset($products)){
			$products = $dbHandler->getProductsSearch($query, $_SESSION['lang']);
		}
	case NULL;
	case 'products':
		if(!isset($products)){
			$products = $dbHandler->getAllProducts($_SESSION['lang']);
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
				$num = number_format($num, 2);
				$options .= '<option value="' . $key . '">' . $key . 'cl ' . $num .' CHF</option>';
			}
			fill_template($tmp, 'options', $options);
			$productstmp .= $tmp;
		}
		fill_template($templateContent, 'products', $productstmp);
		break;
	case 'account':
		$templateContent = file_get_contents($TEMPLATE_PATH . 'contentAccount' . $TEMPLATE_EXTENSION);
		$address = $customer->address;
		fill_template($templateContent, 'firstName', $customer->firstName);
		fill_template($templateContent, 'lastName', $customer->lastName);
		fill_template($templateContent, 'phone', $customer->phone);
		fill_template($templateContent, 'street', $address->street);
		fill_template($templateContent, 'plz', $address->plz);
		fill_template($templateContent, 'city', $address->city);
		fill_template($templateContent, 'addressId', $address->id);
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
				$product = $dbHandler->getProduct($key, $_SESSION['lang']);
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
		header('HTTP/1.0 404 Not Found');
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

//translate UI Elements
fill_template($template, 'myAccount', $expr['myAccount']);
fill_template($template, 'add', $expr['add']);
fill_template($template, 'yourPurchases', $expr['yourPurchases']);
fill_template($template, 'emptyCart', $expr['emptyCart']);
fill_template($template, 'searchHint', $expr['searchHint']);
fill_template($template, 'search', $expr['search']);
fill_template($template, 'userNameHint', $expr['userNameHint']);
fill_template($template, 'checkout', $expr['checkout']);
fill_template($template, 'login', $expr['login']);
fill_template($template, 'close', $expr['close']);
fill_template($template, 'invoiceAddress', $expr['invoiceAddress']);
fill_template($template, 'paymentMethod', $expr['paymentMethod']);
fill_template($template, 'changeDetails', $expr['changeDetails']);
fill_template($template, 'submit', $expr['submit']);
fill_template($template, '404', $expr['404']);
fill_template($template, 'sendOrder', $expr['sendOrder']);

//return the site
echo $template;
?>
