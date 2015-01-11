<?php
include('inc/dbHandler.inc.php');
include_once('inc/address.inc.php');
session_start();

$DEFAULT_LANG="de";
if (isset($_SESSION['lang']) && file_exists('lang/' . $_SESSION['lang'] . '.ini')){
	$filename = 'lang/' . $_SESSION['lang'] . '.ini';
}
else {
	$_SESSION['lang'] = $DEFAULT_LANG;
	$filename = 'lang/' . $DEFAULT_LANG . '.ini';
}
$expr = parse_ini_file($filename);

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['street']) && isset($_POST['plz']) && isset($_POST['city'])){
	$customer = $_SESSION['customer'];
	$address = $customer->address;
	$street = $_POST['street'];
	$plz = $_POST['plz'];
	$city = $_POST['city'];
	
	$dbHandler = new DBHandler();
	$dbHandler->updateAddress($address->id, $street, $plz, $city);
	
	$customer->address = new Address($address->id, $street, $plz, $city);
	
	echo $expr['addressChangeSucessful'];
	
	$_SESSION['customer'] = $customer;
} else{
	echo $expr['addressChangeUnsucessful'];
}
?>
