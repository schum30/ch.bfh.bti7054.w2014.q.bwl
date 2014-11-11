<?php 
class Product{
	
	private $name;
	private $price;
	private $id;
	
	function __construct($name, $price, $id) {
		$this->name = $name;
		$this->price = $price;
		$this->id = $id;
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
