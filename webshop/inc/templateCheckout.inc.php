<?php 

class TemplateCheckout extends Template{
	
	function __construct() {
		parent::__construct();
	}
	
	public function fill(){
		parent::fill(); 
		$this->fillContent();
	}
	
	private function fillContent(){
		
	}
	
}
?>
