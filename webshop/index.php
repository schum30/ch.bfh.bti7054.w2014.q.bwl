<?php 
	include "models/product.php";
	include "database.php";
	include "lang.php";
	
	$products = array(
		new Product("Burgdorfer Helles",3.45,0), 
		new Product("Aare Amber",3.50,1)
	);
	
	$view = isset($_GET["view"]) ? $_GET["view"] : NULL;
	
	$username = isset($_COOKIE["username"]) ? $_COOKIE["username"] : NULL;
	
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
		<?php
		include('views/header.php');
		include('views/login.php');
		
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
		case "logout":
			setcookie("username","",-1);
			include('views/logout.php');
			break;
		}
		
		include('views/footer.php')
		?>
	</body>
</html>
