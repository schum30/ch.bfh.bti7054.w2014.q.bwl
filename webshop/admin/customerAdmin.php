<?php
include_once('../inc/dbHandler.inc.php');
$dbHandler = new DBHandler();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$address = new Address($_POST['street'],$_POST['plz'],$_POST['city']);
	$customer = new Customer($_POST['name'],$_POST['firstName'],$_POST['lastName'],$_POST['phone'],$address,$_POST['password']);
	$dbHandler->insertCustomer($customer);
	header('HTTP/1.1 303 See Other');
	header('Location: index.php?view=customer');
}
elseif(isset($_GET['action'])){
	$action = $_GET['action'];
	$customer = $dbHandler->getCustomer($_GET['name']);
	if($action='delete'){
		$dbHandler->deleteCustomer($customer);
		header('HTTP/1.1 303 See Other');
		header('Location: index.php?view=customer');
	}
}
?>

<div id="userAdmin">
	<form method="POST" id="insert" action="customerAdmin.php"></form>
	<table>
		<tr>
			<td>name</td>
			<td>firstName</td>
			<td>lastName</td>
			<td>phone</td>
			<td>street</td>
			<td>plz</td>
			<td>city</td>
			<td>password</td>
		</tr>
	<?php foreach($dbHandler->getAllCustomers() as $customer){ 
		$address = $customer->address;
		?>
		<tr>
			<td><?php echo $customer->name ?></td>
			<td><?php echo $customer->firstName ?></td>
			<td><?php echo $customer->lastName ?></td>
			<td><?php echo $customer->phone ?></td>
			<td><?php echo $address->street ?></td>
			<td><?php echo $address->plz ?></td>
			<td><?php echo $address->city ?></td>
			<td><?php echo $customer->password ?></td>
			<td><a href="customerAdmin.php?action=delete&name=<?php echo $customer->name ?>">delete</a></td>
		</tr>
	<?php } ?>
		<tr>
			<td><input type="text" name="name" form="insert" required /></td>
			<td><input type="text" name="firstName" form="insert" required /></td>
			<td><input type="text" name="lastName" form="insert" required /></td>
			<td><input type="text" name="phone" form="insert" required /></td>
			<td><input type="text" name="street" form="insert" required /></td>
			<td><input type="number" name="plz" form="insert" required /></td>
			<td><input type="text" name="city" form="insert" required /></td>
			<td><input type="password" name="password" form="insert" required /></td>
			<td><input type="submit" value="insert" form="insert" required /></td>
		</tr>
	</table>
</div>

