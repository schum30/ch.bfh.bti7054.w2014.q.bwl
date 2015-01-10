<?php
include_once('inc/dbHandler.inc.php');
$dbHandler = new DBHandler();

$query = $_GET["query"];
$products = $dbHandler->getProductsSearch($query);

$ret = '<h2>Suche</h2>';
$ret .= '<div id="products">';
if(count($products) >= 1){
	
	foreach ($products as $product) {
		$ret .= '<div class="product" name="' . $product->id . '">';
		$ret .= '<span class="title">' . $product->name . '</span>';
		$ret .= '<a href=./index.php?view=product&id=' . $product->id . '>';
		$ret .= '<img class="productimage" src="' . $product->imgPath . '" style="width:50px;">';
		$ret .= '</a>';
		$ret .= '<span class="price">' . $product->price . '</span>';
		$ret .= '<form action="cart.php" method="post">';
		$ret .= '<input type="hidden" name="id" value="' . $product->id . '" />';
		$ret .= '<input type="number" name="amount" />';
		$ret .= '<input type="submit" value="send" />';
		$ret .= '</form>';
		$ret .= '</div>';
	}
} else {
	$ret .= '<p>No products were found</p>';
}
$ret .= '</div>';

echo $ret;
?> 
