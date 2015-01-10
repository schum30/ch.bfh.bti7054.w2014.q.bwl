<?php 

class Template404 extends Template{
	
	function __construct() {
		parent::__construct();
		$this->templateContent = file_get_contents($this->TEMPLATE_PATH . 'content404' . $this->TEMPLATE_EXTENSION);
	}
	
	public function fill(){
		parent::fill(); 
		$this->fillContent();
	}
	
	private function fillContent(){
		
	}
	
}
?>
