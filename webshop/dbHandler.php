<?php

class DBHandler {
	private $products = null;
	private static $instance = null;
	
	private function __construct(){}
	
	public static function getInstance(){
		if(!isset($instance)){
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function 	getProducts(){
		if(!isset($products)){
			$products = array(
				new Product("Burgdorfer Helles",3.45,0), 
				new Product("Aare Amber",3.50,1)
			);
		}
		return $products;
	}
}

?>
