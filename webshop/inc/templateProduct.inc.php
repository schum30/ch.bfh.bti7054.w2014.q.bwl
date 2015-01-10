<?php 

class TemplateProduct extends Template{
	
	function __construct() {
		parent::__construct();
		$this->templateContent = file_get_contents($this->TEMPLATE_PATH . 'contentProduct' . $this->TEMPLATE_EXTENSION);
	}
	
	public function fill(){
		parent::fill(); 
		$this->fillContent();
	}
	
	private function fillContent(){
		$id = isset($_GET['id']) ? $_GET['id'] : NULL;
		$product = $this->dbHandler->getProduct($id);
		$base = "./index.php";
		$query = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY) : NULL;
		$href = is_null($query) ? $base : $base . "?" . $query;
		
		$content = '';
		
		$content .= '<div class="product" name="' . $product->id . '">';
		$content .= '<span class="title">' . $product->name . '</span>';
		$content .= '<span class="manufacturer">von ' . $product->manufacturer . '</span>';
		$content .= '<img class="productimage" src="./' . $product->imgPath . '" />';
		$content .= '<span class="description">' . $product->description . '</span>';
		$content .= '<span class="price">' . $product->price . '</span>';
		$content .= '<form action="cart.php" method="post">';
		$content .= '<input type="hidden" name="id" value="' . $product->id . '" />';
		$content .= '<input type="number" name="amount" />';
		$content .= '<input type="submit" value="send" />';
		$content .= '</form>';
		$content .= '</div>';
		$content .= '<a href="' . $href . '">Zur&uuml;ck</a>';
		
		$this->templateContent = str_replace("@product@", $content, $this->templateContent);
	}
	
}
?>
