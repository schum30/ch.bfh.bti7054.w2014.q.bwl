<?php 
include_once('dbHandler.inc.php');

class Template{
	
	protected $dbHandler;
	protected $templateContent;
	protected $TEMPLATE_PATH = "template/";
	protected $TEMPLATE_EXTENSION = ".tpl.html";
	private $templateHead;
	private $templateHeader;
	private $templateSidebar;
	private $templateFooter;
	
	function __construct() {
		$this->dbHandler = new DBHandler();
		$TEMPLATE_PATH = "template/";
		$TEMPLATE_EXTENSION = ".tpl.html";
		
		$this->templateHead = file_get_contents($TEMPLATE_PATH . "head" . $TEMPLATE_EXTENSION);
		$this->templateHeader = file_get_contents($TEMPLATE_PATH . "header" . $TEMPLATE_EXTENSION);
		$this->templateSidebar = file_get_contents($TEMPLATE_PATH . "sidebar" . $TEMPLATE_EXTENSION);
		$this->templateFooter = file_get_contents($TEMPLATE_PATH . "footer" . $TEMPLATE_EXTENSION);
	}
	
	public function fill(){
		$this->fillHeader();
		$this->fillSidebar();
		$this->fillFooter();
	}
	
	private function fillHeader(){
		$content = "";
		$user = isset($_SESSION['user']) ? $_SESSION['user'] : NULL;
		switch($user){
			case NULL:
				$content = file_get_contents($this->TEMPLATE_PATH . "part/loginForm" . $this->TEMPLATE_EXTENSION);
				break;
			default:
				$content = '<h2>Logged in</h2>';
				$content .= '<a href="logout.php">logout</a>';
		}
		$this->templateHeader = str_replace("@login@", $content, $this->templateHeader);
		
		$content = '<ol id="navigation">';
		$navItem = file_get_contents($this->TEMPLATE_PATH . "part/navItem" . $this->TEMPLATE_EXTENSION);
		foreach($this->dbHandler->getCategories() as $category){
			$content .= str_replace("@href@",$_SERVER['PHP_SELF'] . '?view=category&id=' . $category, $navItem);
			$content = str_replace("@category@", $category, $content);
		}
		$content .= '</ol>';
		$this->templateHeader = str_replace("@categories@", $content, $this->templateHeader);
	}
	
	private function fillSidebar(){
		$content = "";
		if(isset($_SESSION['cart'])){
			$items = unserialize($_SESSION['cart'])->getItems();
			
			$content .= '<table border=\"1\">';
			$content .= '<tr><th>Article</th><th>Items</th></tr>';
			foreach($items as $product){
				$content .= '<tr><td>' . $product->name . '</td><td>' . $items[$product] . '</td></tr>';
			}
			$content .= '</table>';
			$content .= '<a href=./index.php?view=checkout>Checkout</a>';
		}
		else{
			$content = 'The cart is empty!';
		}
		$this->templateSidebar = str_replace("@cart@", $content, $this->templateSidebar);
	}
	
	private function fillFooter(){
		$service_url = 'http://api.adviceslip.com/advice';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		curl_close($curl);
		$decoded = json_decode($curl_response);
		$decoded->slip->advice;
		$this->templateFooter = str_replace("@footer@", $decoded->slip->advice, $this->templateFooter);
	}
	
	public function display(){
		echo $this->templateHead . $this->templateHeader . $this->templateContent . $this->templateSidebar . $this->templateFooter;
	}
}

?>
