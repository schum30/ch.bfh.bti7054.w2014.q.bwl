<div id="sidebar">
	<?php 
	include_once('inc/cart.inc.php');
	if(isset($_SESSION["cart"])){
		/*
		$cart = unserialize($_SESSION["cart"]);
		$cart.display();
		*/
		echo unserialize($_SESSION["cart"])->display();
		echo "<a href=./index.php?view=checkout>Checkout</a>";
	}
	else{
		echo "The cart is empty";
	}
	?>
</div>
