<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	include('../inc/dbHandler.inc.php');
	$dbHandler = new DBHandler();
	echo $_POST['password'];
	$user = new User($_POST['name'], $_POST['password']);
	$dbHandler->insertUser($user);
	header('HTTP/1.1 303 See Other');
	header("Location: index.php?view=user");
}
elseif(isset($_GET['action'])){
	include('../inc/dbHandler.inc.php');
	$dbHandler = new DBHandler();
	$action = $_GET['action'];
	$user = $dbHandler->getUser($_GET['name']);
	if($action='delete'){
		$dbHandler->deleteUser($user);
		header('HTTP/1.1 303 See Other');
		header("Location: index.php?view=user");
	}
}
?>

<div id="userAdmin">
	<form method="POST" id="insert" action="userAdmin.php"></form>
	<table>
		<tr>
			<td>name</td>
			<td>password</td>
		</tr>
	<?php foreach($dbHandler->getAllUsers() as $user){ ?>
		<tr>
			<td><?php echo $user->name ?></td>
			<td><?php echo $user->password ?></td>
			<td><a href="userAdmin.php?action=delete&name=<?php echo $user->name ?>">delete</a></td>
		</tr>
	<?php } ?>
		<tr>
			<td><input type="text" name="name" form="insert" /></td>
			<td><input type="text" name="password" form="insert" /></td>
			<td><input type="submit" value="insert" form="insert" /></td>
		</tr>
	</table>
</div>

