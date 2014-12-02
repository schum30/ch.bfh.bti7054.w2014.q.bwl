<?php 
class Product{
	
	private $id;
	private $name;
	private $price;
	private $imgPath;
	
	function __construct($name, $price, $id) {
		$this->name = $name;
		$this->price = $price;
		$this->id = $id;
		$this->imgPath = "/img/products/" . $id . "_" . $name . ".png";
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
