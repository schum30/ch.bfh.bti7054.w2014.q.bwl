<?php 
$dbHandler = new dbHandler();
$product = isset($_GET["id"]) ? $dbHandler->getProduct($_GET["id"]) : NULL;
?>
<div class="product">
	<div class="product" name="<?php echo $product->id ?>">
		<span class="title"><?php echo $product->name ?></span>
		<img class="productimage" src="<?php echo $product->imgPath ?>" />
		<span class="price"><?php echo $product->price ?></span>
		<form action="cart.php" method="post">
			<input type="hidden" name="id" value="<?php echo $product->id ?>" />
			<input type="number" name="amount" />
			<input type="submit" value="send" />
		</form>
	</div>
	<a href="./index.php">Zurück</a>
</div>
