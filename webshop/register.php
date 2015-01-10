<?php
include_once('inc/dbHandler.inc.php');
include_once('inc/customer.inc.php');
include_once('inc/address.inc.php');
session_start();

$name = $_POST['name'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phone = $_POST['phone'];
$password = $_POST['password'];

$street = $_POST['street'];
$plz = $_POST['plz'];
$city = $_POST['city'];

$address = new Address($street, $plz, $city);
$customer = new Customer($name, $firstName, $lastName, $phone, $address,$password);

$dbHandler->insertCustomer($customer);
$_SESSION['customer'] = $customer;
?>
