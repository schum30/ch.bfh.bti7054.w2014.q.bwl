<?php
class Address{
	
	private $id;
	private $street;
	private $plz;
	private $city;
	
	function __construct($id, $street, $plz, $city){
		$this->id = $id;
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
