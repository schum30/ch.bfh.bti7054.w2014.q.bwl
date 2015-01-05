<?php
include_once('dbHandler.inc.php');
include_once('cart.inc.php');

class Site {
	private $dbHandler;
	
	function __construct() {
		$this->dbHandler = new DBHandler();
	}
	
	public function getLogin($user){
		switch($user){
			case NULL:
				$ret = '<form action="login.php" method="post">';
				$ret .= '	Username: <input type="text" name="name" /><br />';
				$ret .= '	Password: <input type="password" name="password" /><br />';
				$ret .= '	<input type="submit" value="Anmelden" />';
				$ret .= '</form>';
				break;
			default:
				$ret = '<h2>Logged in</h2>';
				$ret .= '<a href="logout.php">logout</a>';
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
	
	public function getCategories($activeCategory){
		$ret = "";
		foreach($this->dbHandler->getCategories() as $category){
			if($category == $activeCategory){
				$ret .= '<li class="active">';
			}else {
				$ret .= '<li>';
			}
			$ret .= '<a href="' . $_SERVER['PHP_SELF'] . '?view=category&id=' . $category . '">' . $category . '</a>';
			$ret .= '</li>';
		}
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
			return $this->getCheckout();
			break;
		case "confirm":
			return $this->getConfirm();
			break;
		default:
			return $this->get404();
			break;
		}
	}
	
	public function getProducts($category = null){
		$products = is_null($category) ? $this->dbHandler->getAllProducts() : $this->dbHandler->getProductsByCategory($category);
		$ret = '';
		
		foreach ($products as $product) {
			$ret .= '<div class="product" name="' . $product->id . '">';
			$ret .= '<span class="title">' . $product->name . '</span>';
			$ret .= '<a href=./index.php?view=product&id=' . $product->id . '>';
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
		
		return $ret;
	}
	
	public function getProduct($id){
		$product = isset($id) ? $this->dbHandler->getProduct($id) : NULL;
		if(isset($product)){
			$ret = '';
			
			$base = "./index.php";
			$query = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY) : NULL;
			$href = is_null($query) ? $base : $base . "?" . $query;
			
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
			
			return $ret;
		}
		return 'Wrong id!';
	}
	
	public function getProductsSearch($query){
		$products = $this->dbHandler->getProductsSearch($query);
		$ret = '';
		
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
		
		return $ret;
	}
	
	private function getCheckout(){
		$ret = '<div id="checkout">
	<form name="bestellung" action="checkout.php" method="post">
		<h1>Bestellung</h1>
		<div id="billingaddress">
			<h2>1. Rechnungsadresse</h2>
			Vorname:<input type="text" name="billing_firstname" /><br /> 
			Nachname:<input type="text" name="billing_lastname" /><br /> 
			Strasse und Hausnummer:<input type="text" name="billing_address" /><br />
			PLZ:<input type="text" name="billing_postalcode" /><br />
			Ort:<input type="text" name="billing_city" /><br />
			Land:<select name ="billing_country" size="1"> 
				<option value="de">Deutschland</option> 
				<option value="ch" selected>Schweiz</option> 
			</select>
		</div>

		<h2>2. Lieferadresse</h2>
		<input type="radio" name="shippingaddress" value="billingaddress" onclick="lieferadresse()" checked>Gleich wie Rechnungsadresse</input><br />
		<input type="radio" name="shippingaddress" value="shippingaddress" onclick="lieferadresse()">Lieferadresse</input><br />
		<div id="shippingaddress" style="display: none;">
			Vorname:<input type="text" name="shipping_firstname" /><br /> 
			Nachname:<input type="text" name="shipping_lastname" /><br /> 
			Strasse und Hausnummer:<input type="text" name="shipping_address" /><br />
			PLZ:<input type="text" name="shipping_postalcode" /><br />
			Ort:<input type="text" name="shipping_city" /><br />
			Land:<select name ="shipping_country" size="1"> 
				<option value="de">Deutschland</option> 
				<option value="ch" selected>Schweiz</option> 
			</select>
		</div>

		<h2>3. Zahlungsmittel</h2>
		<select name ="paymentmethod" size="1"> 
			<option value="pal">PayPal</option> 
			<option value="bill" selected>Rechnung</option> 
		</select><br />

		<input type="submit" name="submitted" value="Submit"/>

	</form>
</div>';
		return $ret;
	}
	
	private function getConfirm(){
		$ret = '<div id="confirm">';
		$ret .= 'Vorname: ' . $_SESSION["first"] . '<br/>Nachname: ' . $_SESSION["last"] . '<br/>Adresse: ' . $_SESSION["address"] . '<br/>Postleitzahl: ' . $_SESSION["postal"] . '<br/>Ort: ' . $_SESSION["city"] . '<br/>Land: ' . $_SESSION["country"] . '<br/>Lieferadresse: ' . $_SESSION["shippingaddress"] . '<br/>Zahlungsmethode: ' . $_SESSION["paymentmethod"];
		$ret .= '</div>';
		return $ret;
	}
	
	private function get404(){
		return '<h1>This page was lost or never existed</h1>';
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
	
	public function getCart(){
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
