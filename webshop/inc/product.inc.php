<?php 
class Product{
	
	private $id;
	private $name;
	private $category;
	private $description;
	private $manufacturer;
	private $price;
	private $imgPath;
	
	function __construct($id, $name, $category, $description, $manufacturer, $price) {
		$this->name = $name;
		$this->category = $category;
		$this->description = $description;
		$this->manufacturer = $manufacturer;
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
