<?php 
$dbHandler = new dbHandler();
$product = isset($_GET["id"]) ? $dbHandler->getProduct($_GET["id"]) : NULL;

$base = "./index.php";
$query = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY);
$href = is_null($query) ? $base : $base . "?" . $query;
?>
<div class="product">
	<div class="product" name="<?php echo $product->id ?>">
		<span class="title"><?php echo $product->name ?></span>
		<span class="manufacturer">von <?php echo $product->manufacturer ?></span>
		<img class="productimage" src="./<?php echo $product->imgPath ?>" />
		<span class="description"><?php echo $product->description ?></span>
		<span class="price"><?php echo $product->price ?></span>
		<form action="cart.php" method="post">
			<input type="hidden" name="id" value="<?php echo $product->id ?>" />
			<input type="number" name="amount" />
			<input type="submit" value="send" />
		</form>
	</div>
	<a href="<?php echo $href ?>">Zur&uuml;ck</a>
</div>
