<div id="sidebar">
	<?php 
	if(isset($_SESSION["cart"])){
		$cart = $_SESSION["cart"];
	}
	else{
		echo "The cart is empty";
	}
	?>
</div>
