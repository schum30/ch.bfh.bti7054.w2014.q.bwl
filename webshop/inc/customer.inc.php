<?php
include_once('address.inc.php');

class Customer{
	
	private $name;
	private $firstName;
	private $lastName;
	private $phone;
	private $address;
	private $password;
	
	function __construct($name, $firstName, $lastName, $phone, $address,$password) {
		$this->name = $name;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->phone = $phone;
		$this->address = $address;
		$this->password = $password;
	}
	
	public function __get($property){
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}
	
	public function __set($property, $value){
		if (property_exists($this, $property)) {
			$this->$property = $value;
		}
	}
	
}
?>
