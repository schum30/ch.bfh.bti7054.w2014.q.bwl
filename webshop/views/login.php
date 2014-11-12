<?php
switch($username){
	case NULL:
?>
		<form action="login.php" method="post">
			Username: <input type="text" name="username" /><br />
			Password: <input type="password" name="password" /><br />
			<input type="submit" value="Anmelden" />
		</form>
<?php 
		break;
	default:
?>
<h2>Welcome <?php echo $username ?></h2>
<a onClick="javascript:document.cookie='username='" href="">logout</a>
<?php } ?>
