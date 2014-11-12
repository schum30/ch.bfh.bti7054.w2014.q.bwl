<?php 
$id = isset($_GET["id"]) ? $_GET["id"] : NULL;
$product = $products[$id];
?>
<div class="product">
	<ul>
		<li><img src="./img/AppenzellerBrandloescher_Flasche.png">
		<li><?php echo "$expr[name]: $product->name" ?></li>
		<li><?php echo "$expr[price]: $product->price" ?></li>
		<li>Amber, süsslich-herb, üppige Karamalznote, mittelkräftig und cremig</li>
		<li><?php echo "ID: $product->id"?></li>
		<li><a href="javascript:addToCart(<?php echo $id ?>)">add to cart!</a></li>
	</ul>
	<a href="./index.php">Zurück</a>
</div>
