<?php
include_once('dbHandler.inc.php');
include_once('cart.inc.php');

class Site {
	private $dbHandler;
	
	function __construct() {
		$this->dbHandler = new DBHandler();
	}
	
	public function getHeader($user){
		$ret = '';
		
		$ret .= $this->getSearch();
		//$ret .= $this->getLogin($user);
		$ret .= $this->getNavigation();
		
		return $ret;
	}
	
	private function getLogin($user){
		switch($user){
			case NULL:
				$ret = '<form action="session.php?login" method="post">';
				$ret .= '	Username: <input type="text" name="username" /><br />';
				$ret .= '	Password: <input type="password" name="password" /><br />';
				$ret .= '	<input type="submit" value="Anmelden" />';
				$ret .= '</form>';
				break;
			default:
				$ret = '<h2>Logged in as <?php echo $user->name ?></h2>';
				$ret .= '<form action="session.php?logout" method="post">';
				$ret .= '	<input type="submit" value="Logout" />';
				$ret .= '</form>';
		}
		return $ret;
	}
	
	private function getSearch(){
		$ret = '<form id="search" method="get" action="./index.php">';
		$ret .= '<input type="hidden" name="view" value="search">';
		$ret .= '<input type="text" class="searchBox" name="query">';
		$ret .= '<input type="submit" class="submitButton" value="search">';
		$ret .= '</form>';
		
		return $ret;
	}
	
	private function getNavigation(){
		$ret = '<ol id="navigation">';
		foreach($this->dbHandler->getCategories() as $category){
			$ret .= '<li>';
			$ret .= '<a href="' . $_SERVER['PHP_SELF'] . '?category=' . $category . '">' . $category . '</a>';
			$ret .= '</li>';
		}
		$ret .= '</ol>';
		return $ret;
	}
	
	public function getTitle(){
		return "Welcome to da Shop!";
	}
	
	public function getContent($view, $category, $query, $id){
		switch($view){
		case NULL:
		case "default":
			return $this->getProducts($category);
		case "detail":
			return $this->getProductInfo($id);
		case "search":
			return $this->getProductsSearch($query);
		case "checkout":
			include('views/checkout.php');
			break;
		case "confirm":
			include('views/confirm.php');
			break;
		default:
			include('views/products.php');
			break;
		}
	}
	
	private function getProducts($category){
		$products = is_null($category) ? $this->dbHandler->getAllProducts() : $this->dbHandler->getProductsByCategory($category);
		$ret = '<div id="products">';
		
		foreach ($products as $product) {
			$ret .= '<div class="product" name="' . $product->id . '">';
			$ret .= '<span class="title">' . $product->name . '</span>';
			$ret .= '<a href=./index.php?view=detail&id=' . $product->id . '>';
			$ret .= '<img class="productimage" src="' . $product->imgPath . '" style="width:50px;">';
			$ret .= '</a>';
			$ret .= '<span class="price">' . $product->price . '</span>';
			$ret .= '<form action="cart.php" method="post">';
			$ret .= '<input type="hidden" name="id" value="' . $product->id . '" />';
			$ret .= '<input type="number" name="amount" />';
			$ret .= '<input type="submit" value="send" />';
			$ret .= '</form>';
			$ret .= '</div>';
		}
		
		$ret .= '</div>';
		
		return $ret;
	}
	
	private function getProductInfo($id){
		$product = isset($id) ? $this->dbHandler->getProduct($id) : NULL;
		if(isset($product)){
			$base = "./index.php";
			$query = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY) : NULL;
			$href = is_null($query) ? $base : $base . "?" . $query;
			
			$ret = '<div class="product">';
			$ret .= '<div class="product" name="' . $product->id . '">';
			$ret .= '<span class="title">' . $product->name . '</span>';
			$ret .= '<span class="manufacturer">von ' . $product->manufacturer . '</span>';
			$ret .= '<img class="productimage" src="./' . $product->imgPath . '" />';
			$ret .= '<span class="description">' . $product->description . '</span>';
			$ret .= '<span class="price">' . $product->price . '</span>';
			$ret .= '<form action="cart.php" method="post">';
			$ret .= '<input type="hidden" name="id" value="' . $product->id . '" />';
			$ret .= '<input type="number" name="amount" />';
			$ret .= '<input type="submit" value="send" />';
			$ret .= '</form>';
			$ret .= '</div>';
			$ret .= '<a href="' . $href . '">Zur&uuml;ck</a>';
			$ret .= '</div>';
			return $ret;
		}
		return "Wrong id!";
	}
	
	private function getProductsSearch($query){
		$products = $this->dbHandler->getProductsSearch($query);
		$ret = '<div id="products">';
		$ret = '<p>query was ' . $query . '</p>';
		
		foreach ($products as $product){
			$ret .= '<div class="product" name="' . $product->id . '">';
			$ret .= '<span class="title">' . $product->name . '</span>';
			$ret .= '<a href=./index.php?view=detail&id=' . $product->id . '>';
			$ret .= '<img class="productimage" src="' . $product->imgPath . '" style="width:50px;">';
			$ret .= '</a>';
			$ret .= '<span class="price">' . $product->price . '</span>';
			$ret .= '<form action="cart.php" method="post">';
			$ret .= '<input type="hidden" name="id" value="' . $product->id . '" />';
			$ret .= '<input type="number" name="amount" />';
			$ret .= '<input type="submit" value="send" />';
			$ret .= '</form>';
			$ret .= '</div>';
		}
		
		$ret .= '</div>';
		
		return $ret;
	}
	
	public function getSidebar(){
		if(isset($_SESSION["cart"])){
			/*
			$cart = unserialize($_SESSION["cart"]);
			$cart.display();
			*/
			$ret = unserialize($_SESSION["cart"])->display();
			$ret .= '<a href=./index.php?view=checkout>Checkout</a>';
			return $ret;
		}
		else{
			return "The cart is empty";
		}
	}
	
	public function getFooter(){
		$service_url = 'http://api.adviceslip.com/advice';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		curl_close($curl);

		$decoded = json_decode($curl_response);
		return $decoded->slip->advice;
	}
}

?>
