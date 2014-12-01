<?php
include_once('product.inc.php');
include_once('user.inc.php');

class DBHandler extends mysqli{
	public function getAllProducts() {
		$products = array();
		$res = $this->query("SELECT * FROM products");
		while($product = $res->fetch_object()){
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
	public function getAllUsers(){
		$users = array();
		$res = $this->query("SELECT * FROM users");
		while($user = $res->fetch_object()){
			array_push($users,new User($user->name,$user->password));
		}
		return $users;
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
	public function insertUser($user){
		$name = $user->name;
		$password = $user->password;
		$this->query("INSERT users (name,password) VALUES ('$name','$password')");
	}
	function __construct() {
		parent::__construct("localhost", "root", "");
		parent::select_db("bwl");
	}
}
?>
