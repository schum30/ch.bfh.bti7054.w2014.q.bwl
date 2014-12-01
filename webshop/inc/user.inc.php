<?php
class User{
	
	private $name;
	private $password;
	
	function __construct($name, $password) {
		$this->name = $name;
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
