<header>
	<ul>
		<a onClick="javascript:document.cookie='lang=de'" href="">Deutsch</a>
		<a onClick="javascript:document.cookie='lang=en'" href="">English</a>
	</ul>
<?php
switch($username){
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
<h2>Logged in as <?php echo $username ?></h2>
<form action="session.php?logout" method="post">
	<input type="submit" value="Logout" />
</form>
<?php } ?>
</header>
