<?php
session_start();

include_once('inc/dbHandler.inc.php');

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

$dbHandler = new DBHandler();

$query = $_GET["query"];
$products = $dbHandler->getProductsSearch($query, $_SESSION['lang']);

$TEMPLATE_PATH = 'template/';
$TEMPLATE_EXTENSION = '.tpl.html';
$templateContent = file_get_contents($TEMPLATE_PATH . 'contentProducts' . $TEMPLATE_EXTENSION);

if(count($products) >= 1){
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
} else {
	fill_template($templateContent, 'products', '@noProductsFound@');
}

//translate
fill_template($templateContent, 'add', $expr['add']);
fill_template($templateContent, 'noProductsFound', $expr['noProductsFound']);

echo $templateContent;
?> 
