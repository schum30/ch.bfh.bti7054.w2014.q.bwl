<div id="products">
<?php	foreach ($products as $product) {?>
	<div class="product">
		<ul>
			<a href=./index.php?id=<?php echo $product->id ?>>
				<li><img src="./img/AppenzellerBrandloescher_Flasche.png" style="width:50px;">
			</a>
			<li><?php echo "$expr[name]: $product->name" ?></li>
			<li><?php echo "$expr[price]: $product->price" ?></li>
			<li><?php echo "ID: $product->id" ?></li>
		</ul>
	</div>
<?php } ?>
</div>
