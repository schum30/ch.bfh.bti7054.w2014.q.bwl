<div class="product">
	<?php $product = $products[$id] ?>
	<ul>
		<li><img src="./img/AppenzellerBrandloescher_Flasche.png">
		<li><?php echo "$expr[name]: $product->name" ?></li>
		<li><?php echo "$expr[price]: $product->price" ?></li>
		<li>Amber, süsslich-herb, üppige Karamalznote, mittelkräftig und cremig</li>
		<li><?php echo "ID: $product->id"?></li>
	</ul>
	<a href="./index.php">Zurück</a>
</div>
