<div id="sidebar">
	<?php 
	include('inc/cart.inc.php');
	if(isset($_SESSION["cart"])){
		$cart = unserialize($_SESSION["cart"]);
		$cart.display();
	}
	else{
		echo "The cart is empty";
	}
	?>
</div>
