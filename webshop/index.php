<?php 
	include "models/product.php";
	include "lang.php";
	
	$products = array(
		new Product("Burgdorfer Helles",3.45,0), 
		new Product("Aare Amber",3.50,1)
	);
	$id = isset($_GET["id"]) ? $_GET["id"] : NULL;
?>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<header><?php include('header.php') ?></header>
		<?php
		switch($id){
		case NULL:
			echo "id is not set<br/>";
			include('views/products.php');
			break;
		default:
			echo "id is set <br/>";
			include('views/product_info.php');
			break;
		}
		?>
		<footer><?php include('footer.php') ?></footer>
	</body>
</html>
