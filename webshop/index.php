<?php 
	include "inc/product.inc.php";
	include "lang.php";
	
	session_start();
	
	$products = array(
		new Product("Burgdorfer Helles",3.45,0), 
		new Product("Aare Amber",3.50,1)
	);
	
	$view = isset($_GET["view"]) ? $_GET["view"] : NULL;
	$username = isset($_SESSION["username"]) ? $_SESSION["username"] : NULL;
	$cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : NULL;
?>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<?php
		include('views/header.php');
		
		switch($view){
		case NULL:
		case "default":
			include('views/products.php');
			break;
		case "detail":
			include('views/product_info.php');
			break;
		case "cart":
			include('views/cart.php');
			break;
		}
		
		include('views/sidebar.php');
		include('views/footer.php')
		?>
	</body>
</html>
