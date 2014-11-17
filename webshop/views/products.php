<div id="products">
<?php	foreach ($products as $product) {?>
	<div class="product" name="<?php echo $product->id ?>">
		<span class="title"><?php echo $product->name ?></span>
		<a href=./index.php?view=detail&id=<?php echo $product->id ?>>
			<img clas="productimage" src="./img/AppenzellerBrandloescher_Flasche.png" style="width:50px;">
		</a>
		<span class="price"><?php echo $product->price ?></span>
		<form action="cart.php" method="POST">
			<input type="hidden" value=<?php echo $product->id ?>>
			<input type="number" value="amount"></input>
			<input type="submit">
		</form>
	</div>
<?php } ?>
</div>
