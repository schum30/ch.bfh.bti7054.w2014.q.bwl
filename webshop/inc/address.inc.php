<?php
class Address{
	
	private $street;
	private $plz;
	private $city;
	
	function __construct($street, $plz, $city){
		$this->street = $street;
		$this->plz = $plz;
		$this->city = $city;
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
