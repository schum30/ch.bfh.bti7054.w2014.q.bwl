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
		$stmt = $this->prepare('SELECT * FROM products WHERE categoryName = ?;');
		$stmt->bind_param('s', $category);
		$stmt->execute();
		$res = $stmt->get_result();
		while($product = $res->fetch_object()){
			$id = $product->id;
			$name = $product->name;
			$category = $product->categoryName;
			$description = $product->description;
			$manufacturer = $product->manufacturer;
			$price = $product->price;
			$options = $this->getOptions($id);
			array_push($products,new Product($id, $name, $category, $description, $manufacturer, $options, $price));
		}
		return $products;
	}
	public function getAllProducts() {
		$products = array();
		$res = $this->query('SELECT * FROM products;');
		while($product = $res->fetch_object()){
			$id = $product->id;
			$name = $product->name;
			$category = $product->categoryName;
			$description = $product->description;
			$manufacturer = $product->manufacturer;
			$options = $this->getOptions($id);
			array_push($products,new Product($id, $name, $category, $description, $manufacturer, $options));
		}
		return $products;
	}
	public function getProduct($id){
		$stmt = $this->prepare('SELECT * FROM products WHERE ID = ?;');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$res = $stmt->get_result();
		$product = $res->fetch_object();
		
		if (mysqli_num_rows($res) > 0){
			$id = $product->id;
			$name = $product->name;
			$category = $product->categoryName;
			$description = $product->description;
			$manufacturer = $product->manufacturer;
			$options = $this->getOptions($id);
			return new Product($id, $name, $category, $description, $manufacturer, $options);
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
			$options = $this->getOptions($id);
			array_push($products,new Product($id, $name, $category, $description, $manufacturer, $options));
		}
		
		return $products;
	}
	private function getOptions($id){
		$ret = array();
		
		$query = 'SELECT size,price FROM
(SELECT * FROM productsOptions JOIN products ON productsOptions.productId = products.id WHERE products.id = ?) AS a
JOIN
options
ON
a.optionId = options.id';
		$stmt = $this->prepare($query);
		$stmt->bind_param('s', $id);
		$stmt->execute();
		$res = $stmt->get_result();
		while($result = $res->fetch_object()){
			$optionPrice = array();
			$optionPrice[$result->size] = $result->price;
			$ret[$result->size] = $result->price;
		}
		return $ret;
	}
	public function deleteProduct($product) {
		$id = $product->id;
		$stmt = $this->prepare('DELETE FROM products WHERE ID = ?;');
		$stmt->bind_param('i', $id);
		$stmt->execute();
	}
	public function createProduct($name, $category, $description, $manufacturer, $price){
		$stmt = $this->prepare("INSERT products (name, categoryName, description, manufacturer, price) VALUES ('?','?','?','?','?')");
		$stmt->bind_param('ssssd', $name, $category, $description, $manufacturer, $price);
		$stmt->execute();
		$id = mysqli_insert_id($this);
		return $this->getProduct($id);
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
	public function getCustomer($name, $password){
		$query = 'SELECT * FROM customers WHERE name = ? AND password = ?';
		$stmt = $this->prepare($query);
		
		$stmt->bind_param('ss', $name, $password);
		
		$stmt->execute();
		
		$result = $stmt->get_result();
		if($result->num_rows == 1){
			$row = $result->fetch_array();
			$address = $this->getAddress($row['addressId']);
			$customer = new Customer($row['name'], $row['firstName'], $row['lastName'], $row['phone'], $address, $row['password']);
			return $customer;
		}
		
		$stmt->close();
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
	public function createOrder(&$cart, &$customer){
		$query = "INSERT orders (customerName, date, status) VALUES (?, NOW(), 'open')";
		$stmt = $this->prepare($query);
		
		$customerName = $customer->name;
		$stmt->bind_param('s', $customerName);
		
		$stmt->execute();
		
		$stmt->close();
		$this->createOrderDetails($cart);
	}
	private function createOrderDetails(&$cart){
		$items = $cart->getItems();
		
		$query = "INSERT orderdetails (orderId, productId, amountOrdered, priceEach) VALUE (?, ?, ?, ?)";
		$stmt = $this->prepare($query);
		
		$orderId = $this->insert_id;
		
		foreach($items as $product){
			$productId = $product->id;
			$amountOrdered = $items[$product];
			$priceEach = $product->price;
			$stmt->bind_param('iiid',$orderId, $productId, $amountOrdered, $priceEach);
			
			$stmt->execute();
		}
		$stmt->close();
	}
	function __construct() {
		parent::__construct("localhost", "root", "");
		parent::set_charset("utf8");
		parent::select_db("bwl");
	}
}
?>
