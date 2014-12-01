<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	include('../inc/dbHandler.inc.php');
	$dbHandler = new DBHandler();
	$product = new Product($_POST['name'], $_POST['price'], 0);
	$dbHandler->insertProduct($product);
	header('HTTP/1.1 303 See Other');
	header("Location: index.php?view=product");
}
elseif(isset($_GET['action'])){
	include('../inc/dbHandler.inc.php');
	$dbHandler = new DBHandler();
	$action = $_GET['action'];
	$product = $dbHandler->getProduct($_GET['id']);
	if($action='delete'){
		$dbHandler->deleteProduct($product);
		header('HTTP/1.1 303 See Other');
		header("Location: index.php?view=product");
	}
	/*
	elseif($action='update'){
		$dbHandler->updateProduct($product);
		header('HTTP/1.1 303 See Other');
		header("Location: index.php?view=product");
	}
	*/
}
?>

<div id="productAdmin">
	<form method="POST" id="insert" action="productAdmin.php"></form>
	<table>
		<tr>
			<td>id</td>
			<td>name</td>
			<td>price</td>
		</tr>
	<?php foreach($dbHandler->getAllProducts() as $product){ ?>
		<tr>
			<td><?php echo $product->id ?></td>
			<td><?php echo $product->name ?></td>
			<td><?php echo $product->price ?></td>
			<!--<td><a href="productAdmin.php?action=update&id=<?php echo $product->id ?>">update</a></td>-->
			<td><a href="productAdmin.php?action=delete&id=<?php echo $product->id ?>">delete</a></td>
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
