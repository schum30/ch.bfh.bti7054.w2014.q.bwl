<div id="products">
<?php
$category = isset($_GET["category"]) ? $_GET["category"] : NULL;
$products = is_null($category) ? $dbHandler->getAllProducts() : $dbHandler->getProductsByCategory($category);
foreach ($products as $product) {?>
	<div class="product" name="<?php echo $product->id ?>">
		<span class="title"><?php echo $product->name ?></span>
		<a href=./index.php?view=detail&id=<?php echo $product->id ?>>
			<img class="productimage" src="<?php echo $product->imgPath ?>" style="width:50px;">
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
