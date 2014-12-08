<?php
include('../inc/dbHandler.inc.php');
$view = isset($_GET["view"]) ? $_GET["view"] : NULL;
$dbHandler = new DBHandler();
?>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<ul>
			<li><a href=<?php $_PHP_SELF ?>?view=product>products</a></li>
			<li><a href=<?php $_PHP_SELF ?>?view=customer>customer</a></li>
		</ul>
		<?php
		switch($view){
			case 'product':
				include('productAdmin.php');
				break;
			case 'customer':
				include('customerAdmin.php');
				break;
		}
		?>
	</body>
</html>
