<?php 
	include_once('inc/product.inc.php');
	include "lang.php";
	
	session_start();
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
		case "checkout":
			include('form.php');
			break;
		}
		
		include('views/sidebar.php');
		include('views/footer.php')
		?>
	</body>
</html>
