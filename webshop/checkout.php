<?php 
session_start();
if(isset($_POST["submitted"])){
	$_SESSION["first"] = $_POST['billing_firstname']; 
	$_SESSION["last"] = $_POST['billing_lastname']; 
	$_SESSION["address"] = $_POST['billing_address'];
	$_SESSION["postal"] = $_POST['billing_postalcode'];
	$_SESSION["city"] = $_POST['billing_city'];  
	$_SESSION["country"] = $_POST['billing_country'];
	$_SESSION["paymentmethod"] = $_POST['paymentmethod'];
	$_SESSION["shippingaddress"] = $_POST['shippingaddress'];
	
	header('HTTP/1.1 303 See Other');
	header("Location: index.php?view=confirm");
}
?>
