<?php 
	include "models/product.php";
	include "lang.php";
	include "database.php";
	
	$products = array(
		new Product("Burgdorfer Helles",3.45,0), 
		new Product("Aare Amber",3.50,1)
	);
	$view = isset($_GET["view"]) ? $_GET["view"] : NULL;
	$pdo = Database::connect();
?>
<html>
	<head>
		<meta charset="utf-8">
		<script type="text/javascript">
			function addToCart(id){
				window.alert("id: " + id);
			}
		</script>
	</head>
	<body>
		<header><?php include('header.php') ?></header>
		<?php
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
		?>
		<footer><?php include('footer.php') ?></footer>
	</body>
</html>
