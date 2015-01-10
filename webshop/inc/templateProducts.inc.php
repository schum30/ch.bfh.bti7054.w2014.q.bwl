<?php 

class TemplateProducts extends Template{
	
	function __construct() {
		parent::__construct();
		$this->templateContent = file_get_contents($this->TEMPLATE_PATH . 'contentProducts' . $this->TEMPLATE_EXTENSION);
	}
	
	public function fill(){
		parent::fill(); 
		$this->fillContent();
	}
	
	private function fillContent(){
		$products = $this->dbHandler->getAllProducts();
		$content = '';
		
		$productItem = file_get_contents($this->TEMPLATE_PATH . 'part/productItem' . $this->TEMPLATE_EXTENSION);
		foreach ($products as $product) {
			$content .= str_replace('@id@', $product->id, $productItem);
			$content = str_replace('@name@', $product->name, $content);
			$content = str_replace('@imgPath@', $product->imgPath, $content);
			$content = str_replace('@price@', $product->price, $content);
		}
		$this->templateContent = str_replace("@products@", $content, $this->templateContent);
	}
	
}

?>
