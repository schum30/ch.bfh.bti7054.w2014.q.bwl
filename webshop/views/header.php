<header>
	<ul>
		<li><a onClick="javascript:document.cookie='lang=de'" href="">Deutsch</a></li>
		<li><a onClick="javascript:document.cookie='lang=en'" href="">English</a></li>
		<li>Language is <?php echo isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : "none" ?></li>
	</ul>
<?php
switch($user){
	case NULL:
?>
		<form action="session.php?login" method="post">
			Username: <input type="text" name="username" /><br />
			Password: <input type="password" name="password" /><br />
			<input type="submit" value="Anmelden" />
		</form>
<?php 
		break;
	default:
?>
<h2>Logged in as <?php echo $user->name ?></h2>
<form action="session.php?logout" method="post">
	<input type="submit" value="Logout" />
</form>
<?php } ?>
<?php foreach($dbHandler->getCategories() as $category){
	echo "<a href=\"$_SERVER[PHP_SELF]?category=$category\">$category</a> ";
}?>
</header>
