<?php
include_once('inc/dbHandler.inc.php');

function fill_template(&$template, $tag, $content) {
	$template = str_replace("@$tag@", $content, $template);
}

$dbHandler = new DBHandler();

$query = $_GET["query"];
$products = $dbHandler->getProductsSearch($query);

$TEMPLATE_PATH = 'template/';
$TEMPLATE_EXTENSION = '.tpl.html';
$templateContent = file_get_contents($TEMPLATE_PATH . 'contentProducts' . $TEMPLATE_EXTENSION);

$ret = '<h2>Suche</h2>';
$ret .= '<div id="products">';
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
		foreach($product->options as $option){
			$options .= '<option value="' . $option . '">' . $option . ' cl</option>';
		}
		fill_template($tmp, 'options', $options);
		$productstmp .= $tmp;
	}
	fill_template($templateContent, 'products', $productstmp);
} else {
	fill_template($templateContent, 'products', 'No Products were found');
}

echo $templateContent;
?> 
