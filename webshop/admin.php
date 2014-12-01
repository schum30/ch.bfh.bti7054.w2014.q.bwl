<?php
include('inc/productDB.inc.php');
$productDB = new ProductDB();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$product = new Product($_POST['name'], $_POST['price'], 0);
	$productDB->insertProduct($product);
}
elseif(isset($_GET['action'])){
	$action = $_GET['action'];
	$product = $productDB->getProduct($_GET['id']);
	if($action='delete'){
		$productDB->deleteProduct($product);
		header('HTTP/1.1 303 See Other');
		header("Location: admin.php");
	}
	elseif($action='update'){
		$productDB->updateProduct($product);
		header('HTTP/1.1 303 See Other');
		header("Location: admin.php");
	}
}


?>
<html>
	<head>
	
	</head>
	<body>
		<div id="admin">
			<form method="POST" id="insert" action=<?php $_PHP_SELF ?>></form>
			<table>
				<tr>
					<td>id</td>
					<td>name</td>
					<td>price</td>
				</tr>
			<?php foreach($productDB->getAllProducts() as $product){ ?>
				<tr>
					<td><?php echo $product->id ?></td>
					<td><?php echo $product->name ?></td>
					<td><?php echo $product->price ?></td>
					<td><a href="<?php $_PHP_SELF ?>?action=update&id=<?php echo $product->id ?>">update</a></td>
					<td><a href="<?php $_PHP_SELF ?>?action=delete&id=<?php echo $product->id ?>">delete</a></td>
				</tr>
			<?php } ?>
				<tr>
					<td></td>
					<td><input type="text" name="name" form="insert" /></td>
					<td><input type="number" name="price" step="any" form="insert" /></td>
					<td><input type="submit" value="insert" form="insert" /></td>
				</tr>
			</table>
		</div>
	</body>
</html>
