<?php 
session_start();
if(isset($_POST["submitted"])){
	$_SESSION['paymentmethod'] = $_POST['paymentmethod'];
	header('HTTP/1.1 303 See Other');
	header("Location: index.php?view=confirm");
}
?>
