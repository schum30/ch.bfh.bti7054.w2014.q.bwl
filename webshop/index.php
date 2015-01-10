<?php

include_once('inc/product.inc.php');
include_once('inc/dbHandler.inc.php');
include_once('inc/site.inc.php');
include "lang.php";

session_start();

function fill_template(&$template, $tag, $content) {
	$template = str_replace("@$tag@", $content, $template);
}

$site = new Site();
$TEMPLATE_PATH = "template/";
$TEMPLATE_EXTENSION = ".tpl.html";

$view = isset($_GET["view"]) ? $_GET["view"] : NULL;
$category = $view == "category" && isset($_GET["id"]) ? $_GET["id"] : NULL;
$customer = isset($_SESSION['customer']) ? $_SESSION['customer'] : NULL;
switch($view){
	case NULL:
	case "products":
		$templateContent = file_get_contents($TEMPLATE_PATH . "contentProducts" . $TEMPLATE_EXTENSION);
		fill_template($templateContent, "products", $site->getProducts());
		break;
	case "category":
		$templateContent = file_get_contents($TEMPLATE_PATH . "contentProducts" . $TEMPLATE_EXTENSION);
		$id = isset($_GET["id"]) ? $_GET["id"] : NULL;
		fill_template($templateContent, "products", $site->getProducts($category));
		break;
	case "search":
		$templateContent = file_get_contents($TEMPLATE_PATH . "contentProducts" . $TEMPLATE_EXTENSION);
		$query = isset($_GET["query"]) ? $_GET["query"] : NULL;
		fill_template($templateContent, "products", $site->getProductsSearch($query));
		break;
	case "product":
		$templateContent = file_get_contents($TEMPLATE_PATH . "contentProduct" . $TEMPLATE_EXTENSION);
		$id = isset($_GET["id"]) ? $_GET["id"] : NULL;
		fill_template($templateContent, "product", $site->getProduct($id));
		break;
	case "checkout":
		if($_SESSION['customer'] != null){
			$address = $customer->address;
			$templateContent = file_get_contents($TEMPLATE_PATH . "contentCheckout" . $TEMPLATE_EXTENSION);
			fill_template($templateContent, 'firstName', $customer->firstName);
			fill_template($templateContent, 'lastName', $customer->lastName);
			fill_template($templateContent, 'street', $address->street);
			fill_template($templateContent, 'plz', $address->plz);
			fill_template($templateContent, 'city', $address->city);
		} else {
			$templateContent = '<div id="content">login first to order</div>';
		}
		break;
	case "confirm":
		$templateContent = file_get_contents($TEMPLATE_PATH . "contentConfirm" . $TEMPLATE_EXTENSION);
		fill_template($templateContent, 'cart', $site->getCart());
		fill_template($templateContent, 'options', $_SESSION['paymentmethod']);
		break;
	case "register":
		$templateContent = file_get_contents($TEMPLATE_PATH . "contentRegister" . $TEMPLATE_EXTENSION);
		break;
	case "account";
	default:
		$templateContent = file_get_contents($TEMPLATE_PATH . "content404" . $TEMPLATE_EXTENSION);
		break;
}
$templateHead = file_get_contents($TEMPLATE_PATH . "head" . $TEMPLATE_EXTENSION);
$templateHeader = file_get_contents($TEMPLATE_PATH . "header" . $TEMPLATE_EXTENSION);
$templateSidebar = file_get_contents($TEMPLATE_PATH . "sidebar" . $TEMPLATE_EXTENSION);
$templateFooter = file_get_contents($TEMPLATE_PATH . "footer" . $TEMPLATE_EXTENSION);

fill_template($templateHeader, "login", $site->getLogin($customer));
fill_template($templateHeader, "categories", $site->getCategories($category));
fill_template($templateSidebar, "cart", $site->getCart());
fill_template($templateFooter, "footer", $site->getFooter());

$template = $templateHead . $templateHeader . $templateContent . $templateSidebar . $templateFooter;

echo $template;
/*
$template = file_get_contents("template/index.tpl.html");
$site = new Site;

session_start();
$view = isset($_GET["view"]) ? $_GET["view"] : NULL;
$category = isset($_GET["category"]) ? $_GET["category"] : NULL;
$query = isset($_GET["query"]) ? $_GET["query"] : NULL;
$id = isset($_GET["id"]) ? $_GET["id"] : NULL;
$user = isset($_SESSION["user"]) ? $_SESSION["user"] : NULL;
$cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : NULL;
$dbHandler = new DBHandler;

fill_template($template, "header", $site->getHeader($user));
fill_template($template, "title", $site->getTitle());
fill_template($template, "content", $site->getContent($view, $category, $query, $id));
fill_template($template, "sidebar", $site->getSidebar());
fill_template($template, "footer", $site->getFooter());

echo $template;
*/
?>
