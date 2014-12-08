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
	
	public function getAllProducts() {
		$products = array();
		$res = $this->query("SELECT * FROM products");
		while($product = $res->fetch_object()){
			$name = $product->
			array_push($products,new Product($product->name,$product->price,$product->id));
		}
		return $products;
	}
	public function getProduct($id){
		$res = $this->query("SELECT * FROM products WHERE ID = $id");
		$obj = $res->fetch_object();
		return new Product($obj->name,$obj->price,$obj->id);
	}
	public function deleteProduct($product) {
		$id = $product->id;
		$this->query("DELETE FROM products WHERE ID = $id");
	}
	public function createProduct($name, $category, $description, $manufacturer, $price){
		$sql = "INSERT products (name, categoryName, description, manufacturer, price) VALUES ('$name','$category','$description','$manufacturer','$price')"
		$this->query($sql);
		/*$id = mysqli_insert_id($this);
		return $this->getProduct($id);*/
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
			$address = $this->getAddress($res->addressId);
			array_push($customers,new Customer($customer->customerName,$customer->customerFirstName,$customer->customerLastName,$customer->phone,$address,"123456"));
		}
		return $customers;
	}
	public function getUser($name){
		$res = $this->query("SELECT * FROM users WHERE name = '$name'");
		$obj = isset($res) ? $res->fetch_object() : NULL;
		$user = isset($obj) ? new User($obj->name,$obj->password) : NULL;
		return $user;
	}
	public function deleteUser($user){
		$name = $user->name;
		$this->query("DELETE FROM users WHERE name = '$name'");
	}
	public function insertCustomer($customer){
		$name = $customer->name;
		$firstName = $customer->firstName;
		$lastName = $customer->lastName;
		$phone = $customer->phone;
		$address = $customer->address;
		
		$street = $address->street;
		$plz = $address->plz;
		$city = $address->city;
		
		$this->query("INSERT addresses (street,plz,city) VALUES ('$street','$plz','$city')");
		
		$addressId = mysqli_insert_id($this);
		
		$this->query("INSERT users (name, firstName, lastName, phone, addressId) VALUES ('$name','$firstName','$lastName','$phone','$addressId')");
	}
	public function getAddress($id){
		$this->query("SELECT * FROM addresses WHERE ID = $id");
		$obj = $res->fetch_object();
		return new Address($obj->street,$obj->plz,$obj->city);
	}
	function __construct() {
		parent::__construct("localhost", "root", "");
		parent::select_db("bwl");
	}
}
?>
