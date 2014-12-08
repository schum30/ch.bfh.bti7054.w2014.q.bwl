<?php
include_once('../inc/dbHandler.inc.php');
$dbHandler = new DBHandler();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$name = $_POST['name'];
	$category = $_POST['category'];
	$manufacturer = $_POST['manufacturer'];
	$price = $_POST['price'];
	
	$description = file_get_contents($_FILES['description']['tmp_name']);
	
	$product = $dbHandler->createProduct($name, $category, $description, $manufacturer, $price);
	
	move_uploaded_file($_FILES["img"]["tmp_name"], "../" . $product->imgPath);
	
	header('HTTP/1.1 303 See Other');
	header('Location: index.php?view=product');

}
elseif(isset($_GET['action'])){
	$action = $_GET['action'];
	$product = $dbHandler->getProduct($_GET['id']);
	if($action='delete'){
		$dbHandler->deleteProduct($product);
		header('HTTP/1.1 303 See Other');
		header('Location: index.php?view=product');
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
	<form method="POST" id="insert" action="productAdmin.php" enctype="multipart/form-data" /></form>
	<table>
		<tr>
			<td>id</td>
			<td>img</td>
			<td>name</td>
			<td>category</td>
			<td>description</td>
			<td>manufacturer</td>
			<td>price</td>
		</tr>
	<?php foreach($dbHandler->getAllProducts() as $product){ ?>
		<tr>
			<td><?php echo $product->id ?></td>
			<td><img style="height: 10%" src="<?php echo "../" . $product->imgPath; ?>" /></td>
			<td><?php echo $product->name ?></td>
			<td><?php echo $product->category ?></td>
			<td><?php echo $product->description ?></td>
			<td><?php echo $product->manufacturer ?></td>
			<td><?php echo $product->price ?></td>
			<td><a href="productAdmin.php?action=delete&id=<?php echo $product->id ?>">delete</a></td>
		</tr>
	<?php } ?>
		<tr>
			<td></td>
			<td><input type="file" accept=".png" name="img" form="insert" required /></td>
			<td><input type="text" name="name" form="insert" required /></td>
			<td><select name="category" form="insert">
				<option></option>
			<?php foreach($dbHandler->getCategories() as $category){
				echo "<option>".$category."</option>";
			}?>
			</select></td>
			<td><input type="file" accept=".txt" name="description" form="insert" required /></td>
			<td><input type="text" name="manufacturer" form="insert" required /></td>
			<td><input type="number" name="price" step="any" form="insert" required /></td>
			<td><input type="submit" value="insert" form="insert" /></td>
		</tr>
	</table>
</div>
