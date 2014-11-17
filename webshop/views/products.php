<div id="products">
<?php
include('dbHandler.php');
$dbHandler = DBHandler::getInstance();
$products = $dbHandler->getProducts();
foreach ($products as $product) {?>
	<div class="product" name="<?php echo $product->id ?>">
		<span class="title"><?php echo $product->name ?></span>
		<a href=./index.php?view=detail&id=<?php echo $product->id ?>>
			<img clas="productimage" src="./img/AppenzellerBrandloescher_Flasche.png" style="width:50px;">
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
