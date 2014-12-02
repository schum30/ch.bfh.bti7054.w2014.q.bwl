<?php 
$dbHandler = new dbHandler();
$product = isset($_GET["id"]) ? $dbHandler->getProduct($_GET["id"]) : NULL;
?>
<div class="product">
	<ul>
		<li><img src="<?php echo $product->imgPath ?>">
		<li><?php echo "$expr[name]: $product->name" ?></li>
		<li><?php echo "$expr[price]: $product->price" ?></li>
		<li>Amber, süsslich-herb, üppige Karamalznote, mittelkräftig und cremig</li>
		<li><a href="javascript:addToCart(<?php echo $id ?>)">add to cart!</a></li>
	</ul>
	<a href="./index.php">Zurück</a>
</div>
