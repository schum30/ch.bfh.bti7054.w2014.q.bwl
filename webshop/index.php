<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<?php include'lang.php' ?>
		<ul>
			<li><?php echo "Die Seite ist auf $expr[id]"?></li>
			<li><?php echo "?lang= enspricht " . "$_GET[lang]" ?></li>
		</ul>
		<ul id="products">
			<?php include'products.php' ?>
		</ul>
		<?php phpinfo(); ?>
	</body>
</html>
