<?php
include_once('product.inc.php');
include_once('customer.inc.php');
include_once('address.inc.php');

class DBHandler extends mysqli{
	public function getCategories(){
		$categories = array();
		$res = $this->query("SELECT * FROM categories");
		while($category = $res->fetch_object()){
			array_push($categories, $category->name);
		}
		return $categories;
	}
	public function getProductsByCategory($category){
		$products = array();
		$res = $this->query("SELECT * FROM products WHERE categoryName = '$category'");
		while($product = $res->fetch_object()){
			$id = $product->id;
			$name = $product->name;
			$category = $product->categoryName;
			$description = $product->description;
			$manufacturer = $product->manufacturer;
			$price = $product->price;
			array_push($products,new Product($id, $name, $category, $description, $manufacturer, $price));
		}
		return $products;
	}
	public function getAllProducts() {
		$products = array();
		$res = $this->query("SELECT * FROM products");
		while($product = $res->fetch_object()){
			$id = $product->id;
			$name = $product->name;
			$category = $product->categoryName;
			$description = $product->description;
			$manufacturer = $product->manufacturer;
			$price = $product->price;
			array_push($products,new Product($id, $name, $category, $description, $manufacturer, $price));
		}
		return $products;
	}
	public function getProduct($id){
		$res = $this->query("SELECT * FROM products WHERE ID = $id");
		$product = $res->fetch_object();
		
		if (mysqli_num_rows($res) > 0){
			$id = $product->id;
			$name = $product->name;
			$category = $product->categoryName;
			$description = $product->description;
			$manufacturer = $product->manufacturer;
			$price = $product->price;
			return new Product($id, $name, $category, $description, $manufacturer, $price);
		}
	}
	public function getProductsSearch($query){
		$products = array();
		$res = $this->query("SELECT * FROM products WHERE MATCH (name,manufacturer,description) AGAINST ('*$query*' IN BOOLEAN MODE);");
		
		while($product = $res->fetch_object()){
			$id = $product->id;
			$name = $product->name;
			$category = $product->categoryName;
			$description = $product->description;
			$manufacturer = $product->manufacturer;
			$price = $product->price;
			array_push($products,new Product($id, $name, $category, $description, $manufacturer, $price));
		}
		
		return $products;
	}
	public function deleteProduct($product) {
		$id = $product->id;
		$this->query("DELETE FROM products WHERE ID = $id");
	}
	public function createProduct($name, $category, $description, $manufacturer, $price){
		$sql = "INSERT products (name, categoryName, description, manufacturer, price) VALUES ('$name','$category','$description','$manufacturer','$price')";
		$this->query($sql);
		$id = mysqli_insert_id($this);
		return $this->getProduct($id);
	}
	public function insertProduct($product) {
		$name = $product->name;
		$price = $product->price;
		$this->query("INSERT products (Name, Price) VALUES ('$name','$price')");
	}
	public function updateProduct($product) {
		$name = $product->name;
		$price = $product->price;
		$id = $product->id;
		$this->query("UPDATE products SET Name='$name',
			Price='$price' WHERE ID=$id");
	}
	public function getAllCustomers(){
		$customers = array();
		$res = $this->query("SELECT * FROM customers");
		while($customer = $res->fetch_object()){
			$address = $this->getAddress($customer->addressId);
			array_push($customers,new Customer($customer->name,$customer->firstName,$customer->lastName,$customer->phone,$address,$customer->password));
		}
		return $customers;
	}
	public function getCustomer($name){
		$res = $this->query("SELECT * FROM customers WHERE name = '$name'");
		$obj = isset($res) ? $res->fetch_object() : NULL;
		$address = $this->getAddress($obj->addressId);
		$customer = isset($obj) ? new Customer($obj->name, $obj->firstName, $obj->lastName, $obj->phone, $address,$obj->password) : NULL;
		return $customer;
	}
	public function deleteCustomer($customer){
		$name = $customer->name;
		$this->query("DELETE FROM customers WHERE name = '$name'");
	}
	public function insertCustomer($customer){
		$address = $customer->address;
		$street = $address->street;
		$plz = $address->plz;
		$city = $address->city;
		
		echo $sqlAddress = "INSERT addresses (street,plz,city) VALUES ('$street','$plz','$city')";
		$this->query($sqlAddress);
		
		$addressId = mysqli_insert_id($this);
		
		$name = $customer->name;
		$firstName = $customer->firstName;
		$lastName = $customer->lastName;
		$phone = $customer->phone;
		$password = $customer->password;
		
		echo $sqlCustomer = "INSERT customers (name, firstName, lastName, phone, addressId, password) VALUES ('$name','$firstName','$lastName','$phone','$addressId', '$password')";
		$this->query($sqlCustomer);
	}
	public function getAddress($id){
		$res = $this->query("SELECT * FROM addresses WHERE ID = $id");
		$obj = $res->fetch_object();
		return new Address($obj->street,$obj->plz,$obj->city);
	}
	function __construct() {
		parent::__construct("localhost", "root", "");
		parent::select_db("bwl");
	}
}
?>
