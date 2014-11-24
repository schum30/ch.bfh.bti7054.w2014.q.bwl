<div id="products">
<?php
$products = array(
	new Product("Burgdorfer Helles",3.45,0),
	new Product("Aare Amber",3.50,1)
);
foreach ($products as $product) {?>
	<div class="product" name="<?php echo $product->id ?>">
		<span class="title"><?php echo $product->name ?></span>
		<a href=./index.php?view=detail&id=<?php echo $product->id ?>>
			<img class="productimage" src="./img/AppenzellerBrandloescher_Flasche.png" style="width:50px;">
		</a>
		<span class="price"><?php echo $product->price ?></span>
		<form action="cart.php" method="post">
			<input type="hidden" name="id" value="<?php echo $product->id ?>" />
			<input type="number" name="amount" />
			<input type="submit" value="send" />
		</form>
	</div>
<?php } ?>
</div>
