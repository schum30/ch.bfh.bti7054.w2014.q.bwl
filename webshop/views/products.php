<div id="products">
<?php	foreach ($products as $product) {?>
	<div class="product">
		<ul>
			<a href=./index.php?view=detail&id=<?php echo $product->id ?>>
				<li><img src="./img/AppenzellerBrandloescher_Flasche.png" style="width:50px;">
			</a>
			<li><?php echo "$expr[name]: $product->name" ?></li>
			<li><?php echo "$expr[price]: $product->price" ?></li>
			<li><a href="javascript:addToCart(<?php echo $product->id ?>)">add to cart!</a></li>
		</ul>
	</div>
<?php } ?>
</div>
